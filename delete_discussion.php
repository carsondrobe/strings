<?php
session_start();
require 'config.php';

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get discussion id and username
    $discussionId = $_POST['discussionID'];
    $username = $_SESSION['username'];

    // Prepare prepared statement
    $sql = "DELETE FROM Discussions WHERE discussionID = ? AND username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $discussionId, $username);
    
    // Execute prepared statement
    if($stmt->execute()) {
        echo '<script>alert("Discussion deleted successfully.")</script>';
        header("Location: index.php");
        exit(); 
    } else {
        echo '<script>alert("Error '.$conn->error.'")</script>';
    }
}
?>