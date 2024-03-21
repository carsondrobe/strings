<?php
$usernameErr = $emailErr = $dobErr = $passwordErr = $retypePasswordErr = "";

include 'config.php';
    if (empty($_POST['username'])) {
        $usernameErr = "Username is required";
    } else {
        $username = test_input($_POST['username']);
        if (!preg_match('/^[A-Za-z][A-Za-z0-9]{5,31}$/', $username)) {
            $usernameErr = "Username can only contain letters, numbers, and underscores";
        }
    }

    if (empty($_POST['email'])) {
        $emailErr = "Email is required";
    } else {
        $email = test_input($_POST['email']);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
        }
    }

    if (empty($_POST['dob'])) {
        $dobErr = "Date of Birth is required";
    } else {
        // Validate the format of the date
        $dob = test_input($_POST['dob']);
        if (preg_match("/^\d{4}-\d{2}-\d{2}$/", $dob) == 0) {
            $dobErr = "Invalid date format. Please use YYYY-MM-DD";
        } else {
            // Check if the date is in the past (not future DOB)
            $currentDate = date("Y-m-d");
            if ($dob >= $currentDate) {
                $dobErr = "Date of Birth must be in the past";
            }
        }
    }

    if (empty($_POST['password'])) {
        $passwordErr = "Password is required";
    } else {
        $password = test_input($_POST['password']);
        if ($password != $_POST['retype-pass']) {
            $retypePasswordErr = "Passwords do not match";
        }
    }

    if (empty($usernameErr) && empty($emailErr) && empty($dobErr) && empty($passwordErr) && empty($retypePasswordErr)) {
        // Check for unique User
        $unique_user = "SELECT * FROM User WHERE username = '$username' or email = '$email'";
        $result = mysqli_query($conn, $unique_user);

        if (mysqli_num_rows($result) > 0) {
            echo "<script> alert('Username or Email already exists!') </script>";
            exit();
        }

        // Profile Picture handling
        $profilePicture = mysqli_real_escape_string($conn, $profilePicture);

        $sql = "INSERT INTO User (username, password, email, dob, profile_picture) VALUES ('$username', '$password', '$email', '$dob', '$profilePicture')";

        $result = mysqli_query($conn, $sql);

        if ($result) {
            // Send them to the login page
            header("Location: login.php");
            exit();
        } else {
            echo "Registration failed.";
        }
    }

    mysqli_close($conn);


function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
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
    <link href="css/register.css" rel="stylesheet">
</head>

<body>
    <?php include 'navbar.php'; ?>


    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" onsubmit="return validateForm()">
        <div class="register_container">
            <fieldset>
                <legend class="register_legend">Register</legend>
                <div class="form-group">
                    <label for="profilePicture">Profile Picture</label>
                    <input type="file" class="form-control" id="postImage" name="profile_pic">
                </div>

                <div class="form-group">
                    <label for="inputUsername1">Username</label>
                    <input type="text" class="form-control" id="inputUsername1" name="username" placeholder="Enter username" required minlength="5" maxlength="31" pattern="^[A-Za-z][A-Za-z0-9]{5,31}$">
                    <span class="error"><?php echo $usernameErr; ?></span>
                </div>
                <div class="form-group">
                    <label for="inputEmail1">Email</label>
                    <input type="email" class="form-control" id="inputEmail1" name="email" aria-describedby="emailHelp" placeholder="Enter email" required>
                    <span class="error"><?php echo $emailErr; ?></span>
                    <small id="emailHelp" class="form-text text-muted">Don't worry, your email is safe with us:</small>
                </div>
                <div class="form-group">
                    <label for="inputDOB1">Date of Birth</label>
                    <input type="date" class="form-control" id="inputDOB1" name="dob" required pattern="/^\d{4}-\d{2}-\d{2}$/">
                    <span class="error"><?php echo $dobErr; ?></span>
                </div>
                <div class="form-group">
                    <label for="inputPassword1">Password</label>
                    <input type="password" class="form-control" id="inputPassword1" name="password" placeholder="Password" required maxlength="100">
                    <span class="error"><?php echo $passwordErr; ?></span>
                </div>
                <div class="form-group">
                    <label for="inputPassword1">Retype Password</label>
                    <input type="password" class="form-control" id="retypePassword1" placeholder="Retype password" name="retype-pass" required>
                    <span class="error"><?php echo $retypePasswordErr; ?></span>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary" name="submit">Register</button>
                </div>
            </fieldset>
    </form>
    </div>


</body>
<script>
    // Function to validate the form
    function validateForm() {
        if (document.getElementById('inputPassword1').value != document.getElementById('retypePassword1').value) {
            alert('Passwords do not match');
            return false;
        } else if (document.getElementById('inputDOB1').value >= new Date().toISOString().split('T')[0]) {
            alert('Date of Birth must be in the past');
            return false;
        }
    }
</script>

</html>