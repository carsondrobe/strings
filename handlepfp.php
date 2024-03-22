<?php
require 'config.php';

if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];

    $query = "SELECT profile_picture FROM User WHERE userID = ?";
    $stmt = $conn->prepare($query);

    $stmt->bind_param("s", $user_id);
    $stmt->execute();
    

    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($imageData);
        $stmt->fetch();

        if(!is_null($imageData)) {

            header("Content-Type: image/jpeg");
            echo $imageData;
        } else {

            header("Content-Type: image/jpeg");
            readfile('path/to/default/image.jpg');
        }
    } else {

        header("HTTP/1.0 404 Not Found");
 
    }

    $stmt->close();
    $conn->close();
} else {

    header("HTTP/1.0 400 Bad Request");
}