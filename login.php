<?php
session_start();
require 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $username = mysqli_real_escape_string($conn, $username);
    $password = mysqli_real_escape_string($conn, $password);


    $user_query = "SELECT * FROM User WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($conn, $user_query);

    if (mysqli_num_rows($result) != 1) {
        $_SESSION['error'] = 'Account not found. Please check your username and password.';
        header("Location: login.php");
        exit();
    }


    $row = mysqli_fetch_assoc($result);


    $_SESSION['logged_in'] = true;
    $_SESSION['user_id'] = $row['userID'];
    $_SESSION['username'] = $row['username'];


    header("Location: index.php");
    exit();
}

// Close the database connection at the end of your script
mysqli_close($conn);
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

                <!-- Display error message if login fails -->
                <?php if (isset($_SESSION['error'])) : ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $_SESSION['error'];
                        unset($_SESSION['error']); ?>
                    </div>
                <?php endif; ?>

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