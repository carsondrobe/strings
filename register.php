<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
$usernameErr = $emailErr = $dobErr = $passwordErr = $retypePasswordErr = "";
$profilePicture = NULL;

include 'config.php';


function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
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
        $dob = test_input($_POST['dob']);
        if (!preg_match("/^\d{4}-\d{2}-\d{2}$/", $dob)) {
            $dobErr = "Invalid Date Format. Please use YYYY-MM-DD";
        }elseif ($dob>=date("Y-m-d")){
            $dobErr = "Date of Birth must be in the past";
        }

    }

    if (empty($_POST['password'])) {
        $passwordErr = "Password is required";
    } else {
        $password = test_input($_POST['password']);
        if ($password != $_POST['retype-pass']){
            $retypePasswordErr = "Passwords do not match";
        }

    }
    $defaultPicPath = 'img/defaultprofile.jpeg';

    if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] == UPLOAD_ERR_OK) {
        $tmpName = $_FILES['profile_pic']['tmp_name'];
    } else {
        $tmpName = $defaultPicPath;
    }
    
    $fp = fopen($tmpName, 'rb');
    $profilePicture = fread($fp, filesize($tmpName));
    fclose($fp);

    if (empty($usernameErr) && empty($emailErr) && empty($dobErr) && empty($passwordErr) && empty($retypePasswordErr)) {
        $stmt = $conn->prepare("SELECT * FROM User WHERE username = ? OR email = ?");
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();
        $result = $stmt->get_result();

        
        if ($result->num_rows == 0) {
            $insert_stmt = $conn->prepare("INSERT INTO User (username, password, email, dob, profile_picture) VALUES (?, ?, ?, ?, ?)");
            $insert_stmt->bind_param("sssss", $username, md5($password), $email, $dob, $profilePicture);

            if ($insert_stmt->execute()) {

                header("Location: login.php");
                exit();
            } else {

                echo "<p>Registration failed: " . $conn->error . "</p>";
            }
        }
    }
    $conn->close();
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


    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
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