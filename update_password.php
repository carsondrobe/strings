<?php
session_start();
include 'config.php';

if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (substr($username, -6) === ".Admin") {
        $password = $_POST['password'];
        $new_password = $_POST['new_password'];
    } else {
        $password = md5($_POST['password']);
        $new_password = md5($_POST['new_password']);
    }

    $check_password_query = "SELECT * FROM User WHERE userID = '$user_id' AND password = '$password'";
    $check_password_result = mysqli_query($conn, $check_password_query);

    if (mysqli_num_rows($check_password_result) > 0) {
        if (!empty($new_password)) {
            $update_query = "UPDATE User SET password = '$new_password' WHERE userID = '$user_id'";
            $result = mysqli_query($conn, $update_query);

            if ($result) {
                header("Location: account.php");
                exit();
            } else {
                echo "Error updating password: " . mysqli_error($conn);
            }
        }
    } else {
        echo "Current password is incorrect.";
    }

    mysqli_close($conn);
} else {
    header("Location: account.php");
    exit();
}
