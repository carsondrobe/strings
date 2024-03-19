<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = mysqli_connect("localhost", "root", "", "strings");

    if ($conn === false) {
        die("ERROR: Could not connect. " . mysqli_connect_error());
    }

    $username = $_POST['username'];
    $email = $_POST['email'];

    // Check for unique User
    $unique_user = "SELECT * FROM User WHERE username = '$username' or email = '$email'";
    $result = mysqli_query($conn, $unique_user);

    if (mysqli_num_rows($result) > 0) {
        echo "<script> alert('Username or Email already exists!') </script>";
        exit();
    }

    $dob = $_POST['dob'];
    $password = $_POST['password'];

    // TODO: Add profile picture upload
    $profilePicture = null;

    $sql = "INSERT INTO User (username, password, email, dob) VALUES ('$username', '$password', '$email', '$dob')";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        // Send them to the login page
        header("Location: login.php");
        exit();
    } else {
        echo "Registration failed.";
    }

    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Strings Register</title>
    <link href="css/register_style.css" rel="stylesheet">
    <!-- BOOTSTRAP CSS-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- BOOTSTRAP JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</head>

<body>
    <?php include 'navbar.php'; ?>


    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="register_container">
            <fieldset>
                <legend class="register_legend">Register</legend>
                <div class="form-group">
                    <label for="profilePicture">Profile Picture</label>
                    <input type="file" class="form-control" id="postImage" name="profile_pic">
                </div>

                <div class="form-group">
                    <label for="inputUsername1">Username</label>
                    <input type="text" class="form-control" id="inputUsername1" name="username" placeholder="Enter username" required>
                </div>
                <div class="form-group">
                    <label for="inputEmail1">Email</label>
                    <input type="email" class="form-control" id="inputEmail1" name="email" aria-describedby="emailHelp" placeholder="Enter email" required>
                    <small id="emailHelp" class="form-text text-muted">Don't worry, your email is safe with us
                        :)</small>
                </div>
                <div class="form-group">
                    <label for="inputDOB1">Date of Birth</label>
                    <input type="date" class="form-control" id="inputDOB1" name="dob" required>
                </div>
                <div class="form-group">
                    <label for="inputPassword1">Password</label>
                    <input type="password" class="form-control" id="inputPassword1" name="password" placeholder="Password" required>
                </div>
                <div class="form-group">
                    <label for="inputPassword1">Retype Password</label>
                    <input type="password" class="form-control" id="retypePassword1" placeholder="Retype password" required>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary" name="submit">Register!</button>
                </div>
            </fieldset>
    </form>
    </div>


</body>

</html>