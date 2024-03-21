<?php 
session_start();
include 'navbar.php'; 
include 'config.php';


if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {

    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$user_query = "SELECT * FROM User WHERE userID = '$user_id'";
$result = mysqli_query($conn, $user_query);

if (!$result) {
    echo "Error: " . mysqli_error($conn);
    exit();
}

$row = mysqli_fetch_assoc($result);

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Strings Home</title>
    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- BOOTSTRAP -->
    <link href="css/loggedInNavbar.css" rel="stylesheet">
    <link rel="stylesheet" href="css/account_style.css">

</head>

<body>
    <?php include 'navbar.php'; ?>

    <div class="container mt-5 account-main">
        <div class="row justify-content-center">
            <!-- Profile Picture Column -->
            <div class="col-md-4">
                <button type="button" data-bs-toggle="modal" data-bs-target="#uploadProfilePicModal" style="background: none; border: none; padding: 0;">
                    <img src="uploads/<?php echo $row['profile_picture']; ?>" class="img-fluid rounded-circle" alt="Profile Picture">
                </button>
            </div>

            <!-- Change profile pic -->
            <div class="modal fade" id="uploadProfilePicModal" tabindex="-1" aria-labelledby="uploadProfilePicModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="uploadProfilePicModalLabel">Upload New Profile Picture</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form form method="POST" action="uploadpfp.php" enctype="multipart/form-data">
                                <div class="mb-3">
                                    <label for="profilePicInput" class="form-label">Select image</label>
                                    <input class="form-control" type="file" id="profilePicInput" accept="image/*">
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Upload</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Account Information Form Column -->
            <div class="col-md-8">
                <h2>My Account</h2>
                <form>
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" value="<?php echo $row['username']; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" class="form-control" id="email" value="<?php echo $row['email']; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="Date of Birth" class="form-label">Date of Birth</label>
                        <input type="date" class="form-control" id="DOB" value="<?php echo $row['dob']; ?>">

                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" value="<?php echo $row['password']; ?>">
                    </div>
                    <button type="submit" class="btn btn-primary">Update Information</button>
                </form>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row justify-content-start">
            <h3>
                <p>
                    My posts:
                </p>
            </h3>

            <!-- User List with Delete Button -->
            <ul class="list-group">
                <li class="list-group-item d-flex justify-content-between align-items-center" onclick="window.location.href='view_post.html';" style="cursor: pointer;">
                    ✏️ Exciting News in Tech World
                    <button type="button" class="btn btn-danger" onclick="event.stopPropagation(); deleteUser(1);">Delete</button>
                </li>
            </ul>
        </div>
    </div>



    <!-- BOOTSTRAP -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <!-- BOOTSTRAP -->


</body>

</html>