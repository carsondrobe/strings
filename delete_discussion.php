<?php
session_start();
require 'config.php';

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get discussion id and username
    $discussionId = $_POST['discussionID'];

    // Prepare prepared statement
    $sql = "DELETE FROM Discussions WHERE discussionID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $discussionId);
    
    // Execute prepared statement
    if($stmt->execute()) {
        header("Location: index.php");
        exit(); 
    } else {
        echo '<script>alert("Error '.$conn->error.'")</script>';
    }
}
?>