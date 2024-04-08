<?php
session_start();
include 'config.php';

if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_POST['username'];
    $email = $_POST['email'];
    $dob = $_POST['DOB'];
    if (substr($username, -6) !== ".Admin") {
        $password = $password;
        $new_password = $_POST['new_password'];
    } else {
        $password = md5($_POST['password']);
        $new_password = md5($_POST['new_password']);
    }

    $update_query = "UPDATE User SET username = '$username', email = '$email', dob = '$dob'";
    

    if (!empty($new_password)) {
        $update_query .= ", password = '$new_password'";
    }

    $update_query .= " WHERE userID = '$user_id'";

    $result = mysqli_query($conn, $update_query);

    if ($result) {
        header("Location: account.php");
        exit();
    } else {
        echo "Error updating user information: " . mysqli_error($conn);
    }

    mysqli_close($conn);
} else {
    header("Location: account.php");
    exit();
}
?>