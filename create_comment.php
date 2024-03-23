<?php
session_start();

header('Content-Type: application/json');
require 'config.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$response = ['success' => false, 'message' => '', 'username' => '', 'timePosted' => '', 'commentId' => ''];

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_SESSION['username'];
    $discussionId = $_POST['discussionID'];
    $content = $_POST['commentContent'];
    $timePosted = date('Y-m-d');
    $user_id = $_SESSION['user_id'];
    $response['username'] = $username;
    $response['timePosted'] = $timePosted;

    // Check if content is over limit
    if (strlen($content) > 5000) {
        $response['message'] = "Your comment content exceeds the maximum allowed length of 5000 characters. Please shorten your post.";
    } else {
        // Create prepared statement and bind parameters
        $stmt = $conn->prepare("INSERT INTO Comments (discussionID, username, content, timePosted) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isss", $discussionId, $username, $content, $timePosted);
         // Execute prepared statement
    if ($stmt->execute()) {
        // Update Notifications
        $commentId = $stmt->insert_id;
        // Update json responses
        $response['success'] = true;
        $response['message'] = "Comment successfully added.";
        $response['commentId'] = $commentId;
        //  Get the Username for the discussion commented on
        $stmt = $conn->prepare("SELECT username FROM Discussions WHERE discussionID = ?");
        if ($stmt === false) {
            die("Error preparing statement: " . $conn->error);
        }
        $stmt->bind_param("i", $discussionId);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $username = $row['username'];

        // get the userID for the given username
        $stmt = $conn->prepare("SELECT userID FROM User WHERE username = ?");
        if ($stmt === false) {
            $response['message'] = "Error: " . $stmt->error;
        }
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $notified_userID = $row['userID'];
        } else {
            $response['message'] = "Error: " . $stmt->error;
        }

        // Then, insert the notification
        $stmt = $conn->prepare("INSERT INTO Notifications (discussion_id, comment_id, commenting_userID, notified_userID, notification_type) VALUES (?, ?, ?, ?, 'comment')");
        $stmt->bind_param("iiii", $discussionId, $commentId, $user_id, $notified_userID);
        if ($stmt->execute()) {
        } else {
            $response['message'] = "Error: " . $stmt->error;
        }
    } else {
        $response['message'] = "Error: " . $stmt->error;
    }
    $stmt->close();
    // $conn->close();
    }
} else {
    $response['message'] = "Error: " . $stmt->error;
}

echo json_encode($response);