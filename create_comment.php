<?php
session_start();
require 'config.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_SESSION['username'];
    $discussionId = $_POST['discussionID'];
    $content = $_POST['commentContent'];
    $timePosted = date('Y-m-d');
    $user_id = $_SESSION['user_id'];

    // Check if content is over limit
    if (strlen($content) > 5000) {
        $_SESSION['error_message'] = "Your comment content exceeds the maximum allowed length of 5000 characters. Please shorten your post.";
        header("Location: view_post.php?discussionID=$discussionId");
        exit();
    }

    // Create prepared statement and bind parameters
    $stmt = $conn->prepare("INSERT INTO Comments (discussionID, username, content, timePosted) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $discussionId, $username, $content, $timePosted);

    // Execute prepared statement
    if ($stmt->execute()) {
        // Update Notifications
        $commentId = $conn->insert_id;
        $stmt = $conn->prepare("INSERT INTO Notifications (discussion_id, comment_id, commenting_userID, notified_userID, notification_type) VALUES (?, ?, ?, (SELECT userID FROM Discussions WHERE username = ?), 'comment')");

        if ($stmt === false) {
            die("Error preparing statement: " . $conn->error);
        }

        $stmt->bind_param("iiis", $discussionId, $commentId, $user_id, $username);
        $stmt->execute();



        header("Location: view_post.php?discussionID=$discussionId");
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
    // $conn->close();
} else {
    echo "Invalid request.";
}
