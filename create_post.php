<?php
session_start();
require 'config.php';

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_SESSION['username']; 
    $title = $_POST['postTitle'];
    $content = $_POST['postDescription'];
    $category = $_POST['postCategory'];
    $time_posted = date('Y-m-d');
    $upvotes = 0;
    $downvotes = 0;

    // Check if content is over limit
    if (strlen($content) > 5000) {
        $_SESSION['error_message'] = "Your post content exceeds the maximum allowed length of 5000 characters. Please shorten your post.";
        header("Location: index.php");
        exit();
    }

    // Get image
    $image = NULL;
    // If image upload
    if (isset($_FILES['postImage']) && $_FILES['postImage']['error'] == 0) {
        // Check if file is over limit
        if ($_FILES['postImage']['size'] > 2 * 1024 * 1024) {
            $_SESSION['error_message'] = "The uploaded file exceeds the maximum allowed size of 2048 KiB. Please upload a smaller file.";
            header("Location: index.php");
            exit();
        }
        $image = file_get_contents($_FILES['postImage']['tmp_name']);

    // Create prepared statement and bind parameters
    $stmt = $conn->prepare("INSERT INTO Discussions (username, title, content, discussion_picture, time_posted, category, upvotes, downvotes) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssii", $username, $title, $content, $image, $time_posted, $category, $upvotes, $downvotes);

    // Execute prepared statement
    if ($stmt->execute()) {
        header("Location: index.php");
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
    // $conn->close();
} else {
    echo "Invalid request.";
}
?>
