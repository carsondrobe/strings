<?php
require 'config.php'; // Include your database connection configuration file

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['user_id'])) {
    // Get user ID
    $user_id = $_POST['user_id'];

    // Check if a file was uploaded
    if(isset($_FILES['profilePicInput']) && $_FILES['profilePicInput']['error'] === UPLOAD_ERR_OK) {
        // Process the uploaded file
        $imageData = file_get_contents($_FILES['profilePicInput']['tmp_name']);
        $imageData = mysqli_real_escape_string($conn, $imageData);

        // Update profile picture in the database
        $query = "UPDATE User SET profile_picture = '$imageData' WHERE userID = '$user_id'";
        $result = mysqli_query($conn, $query);

        // Check if the query executed successfully
        if ($result) {
            // Redirect back to account.php after updating profile picture
            header("Location: account.php");
            exit();
        } else {
            // Handle database error
            echo "Error updating profile picture: " . mysqli_error($conn);
        }
    } else {
        // Handle file upload error
        echo "Error uploading file.";
    }
} else {
    // Redirect to account.php if accessed directly without form submission
    header("Location: account.php");
    exit();
}

// Close database connection
mysqli_close($conn);
?>