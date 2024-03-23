<?php
session_start();
include 'config.php'; 

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $discussionID = $_POST['discussionID'];
    $ratingType = $_POST['ratingType'];

    // If user clicks upvote
    if ($ratingType === "upvote") {
        $query = "UPDATE Discussions SET upvotes = upvotes + 1 WHERE discussionID = ?";
    // If user clicks downvote
    } elseif ($ratingType === "downvote") {
        $query = "UPDATE Discussions SET downvotes = downvotes + 1 WHERE discussionID = ?";
    }

    // Create prepared statement and bind parameters
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $discussionID);

    // Execute prepared statement
    if ($stmt->execute()) {
        
    } else {
        echo "Error: " . $stmt->error;
    }
} else {
    echo "Invalid request.";
}
?>
