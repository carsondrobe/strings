<?php
session_start();
require 'config.php';

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get comment id and username
    $commentID = $_POST['commentID'];
    $username = $_SESSION['username'];

    // Prepare prepared statement
    $sql = "DELETE FROM Comments WHERE commentID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $commentID);
    
    // Execute prepared statement
    if($stmt->execute()) {
        header("Location: view_post_user.php?discussionID=".$_SESSION['discussionID']);
        exit(); 
    } else {
        echo '<script>alert("Error '.$conn->error.'")</script>';
    }
}
?>