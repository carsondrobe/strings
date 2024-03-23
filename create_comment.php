<?php
session_start();
require 'config.php';

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_SESSION['username']; 
    $discussionId = $_POST['discussionID'];
    $content = $_POST['commentContent'];
    $timePosted = date('Y-m-d');

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
        header("Location: view_post.php?discussionID=$discussionId");
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
    // $conn->close();
} else {
    echo "Invalid request.";
}
?>
