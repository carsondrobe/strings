<?php
require 'config.php'; 


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['user_id'])) {

    $user_id = $_POST['user_id'];


    if(isset($_FILES['profilePicInput']) && $_FILES['profilePicInput']['error'] === UPLOAD_ERR_OK) {

        $imageData = file_get_contents($_FILES['profilePicInput']['tmp_name']);
        $imageData = mysqli_real_escape_string($conn, $imageData);


        $query = "UPDATE User SET profile_picture = '$imageData' WHERE userID = '$user_id'";
        $result = mysqli_query($conn, $query);

        if ($result) {

            header("Location: account.php");
            exit();
        } else {

            echo "Error updating profile picture: " . mysqli_error($conn);
        }
    } else {

        echo "Error uploading file.";
    }
} else {

    header("Location: account.php");
    exit();
}

mysqli_close($conn);
?>