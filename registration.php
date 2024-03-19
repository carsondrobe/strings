<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    $conn = mysqli_connect("localhost", "root", "", "strings");
    // Check connection
    if ($conn === false) {
        die("ERROR: Could not connect. "
            . mysqli_connect_error());
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $dob = $_POST['dob'];
        $password = $_POST['password'];

        echo $username;
        echo $email;
        echo $dob;
        echo $password;


        // TODO: Add profile picture upload
        $profilePicture = null;

        $sql = "INSERT INTO User (username, password, email, dob) VALUES ('$username', '$password', '$email', '$dob')";
        echo $sql;
        $result = mysqli_query($conn, $sql);
        echo $result;
        if ($result) {
            echo "Registration Successful!";
        } else {
            echo "Registration Failed!";
        }
    } else {
        echo "Please fill the form and submit!";
    }
    mysqli_close($conn);
    ?>

</body>

</html>