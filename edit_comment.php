<?php
session_start();
require 'config.php';

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get comment content, comment id and username
    $updatedContent = $_POST['updatedContent'];
    $commentID = $_POST['commentID'];
    $username = $_SESSION['username'];

    // Check if updated comment is empty
    if (empty($updatedContent)) {
        echo '<script>alert("Comment cannot be empty."); window.history.back();</script>';
        exit();
    }

    // Prepare prepared statement
    $sql = "UPDATE Comments SET content = ? WHERE commentID = ? AND username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sis", $updatedContent, $commentID, $username);
    
    // Execute prepared statement
    if($stmt->execute()) {
        header("Location: view_post_user.php?discussionID=".$_SESSION['discussionID']);
        exit(); 
    } else {
        echo '<script>alert("Error '.$conn->error.'")</script>';
    }
}
?>