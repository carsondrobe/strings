<?php
require 'config.php'; // Ensure this connects to your database

if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];

    // Prepare a statement to enhance security and prevent SQL injection
    $query = "SELECT profile_picture FROM User WHERE userID = ?";
    $stmt = $conn->prepare($query);

    // Bind the user ID to the prepared statement
    $stmt->bind_param("s", $user_id);
    $stmt->execute();
    
    // Store the result so we can check if we got a record
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($imageData);
        $stmt->fetch();
        
        // Check if imageData is not null
        if(!is_null($imageData)) {
            // Assume the image is JPEG; adjust the content type if necessary
            header("Content-Type: image/jpeg");
            echo $imageData;
        } else {
            // Handle case where no image is found, perhaps serve a default image
            header("Content-Type: image/jpeg");
            readfile('path/to/default/image.jpg');
        }
    } else {
        // User not found or no image; serve a default image or return 404
        header("HTTP/1.0 404 Not Found");
        // readfile('path/to/default/image.jpg'); // Uncomment to serve a default image instead
    }

    $stmt->close();
    $conn->close();
} else {
    // No user_id provided
    header("HTTP/1.0 400 Bad Request");
}