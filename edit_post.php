<?php
session_start();
require 'config.php';

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['editPostTitle'];
    $content = $_POST['editPostContent'];
    $category = $_POST['editPostCategory'];


    // Check if content is over limit
    if (strlen($content) > 5000) {
        $_SESSION['error_message'] = "Your post content exceeds the maximum allowed length of 5000 characters. Please shorten your post.";
        header("Location: view_post_user.php?discussionID=".$_SESSION['discussionID']);
        exit();
    }

    // Get image
    $image = NULL;
    // If image upload
    if (isset($_FILES['editPostImage']) && $_FILES['editPostImage']['error'] == 0) {
        // Check if file is over limit
        if ($_FILES['editPostImage']['size'] > 2 * 1024 * 1024) {
            $_SESSION['error_message'] = "The uploaded file exceeds the maximum allowed size of 2048 KiB. Please upload a smaller file.";
            header("Location: view_post_user.php?discussionID=".$_SESSION['discussionID']);
            exit();
        }
        $image = file_get_contents($_FILES['editPostImage']['tmp_name']);
    }

    // Create prepared statement and bind parameters
    $sql = "UPDATE Discussions SET title = ?, content = ?, discussion_picture = ?, category = ? WHERE discussionID = ? AND username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssis", $title, $content, $image, $category, $_SESSION['discussionID'], $_SESSION['username']);

    // Execute prepared statement
    if ($stmt->execute()) {
        header("Location: view_post_user.php?discussionID=".$_SESSION['discussionID']);
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
    // $conn->close();
} else {
    echo "Invalid request.";
}
?>
