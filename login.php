<?php
// Path: login.php
session_start();
include 'config.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if the user exists
    $user = "SELECT * FROM User WHERE username = '$username' and password = '$password'";
    $result = mysqli_query($conn, $user);

    if (mysqli_num_rows($result) != 1) {
        echo "<script> alert('Username or Password is Incorrect') </script>";
        exit();
    }

    if ($result) {
        // Send them to the index home page
        $_SESSION['logged_in'] = true;
        header("Location: index.php");
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
    <title>Strings Login</title>
    <link href="css/login_style.css" rel="stylesheet">
    <!-- BOOTSTRAP CSS-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- BOOTSTRAP JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</head>

<body>
    <?php include 'navbar.php'; ?>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div class="login_container">
            <fieldset>
                <legend class="login_legend">Login</legend>
                <div class="form-group">
                    <label for="exampleInputEmail1">Username</label>
                    <input type="text" class="form-control" id="exampleInputUsername1" name="username" placeholder="Enter username" required>
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Password</label>
                    <input type="password" class="form-control" id="exampleInputPassword1" name="password" aria-describedby="forgotPasswordMsg" placeholder="Password" required>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary" name="submit">Login</button>
                    <br>
                    <small id="registerMsg" class="form-text text-muted">Don't have an account? Don't miss out on the discussion! Register <a href="register.php">here</a>!</small>
                </div>
            </fieldset>
        </div>
    </form>
</body>

</html>