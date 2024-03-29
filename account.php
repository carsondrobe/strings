<?php 
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

$username = mysqli_real_escape_string($conn, $row['username']);
$posts_query = "SELECT * FROM Discussions WHERE username = '$username' ORDER BY time_posted DESC";
$posts_result = mysqli_query($conn, $posts_query);

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
    <link href="css/navbar.css" rel="stylesheet">
    <link rel="stylesheet" href="css/account_style.css">

</head>

<body>
    <?php include 'navbar.php'; ?>

    <div class="container mt-5 account-main">
        <div class="row justify-content-center">
            <!-- Profile Picture Column -->
            <div class="col-md-4">
                <button type="button" data-bs-toggle="modal" data-bs-target="#uploadProfilePicModal" style="background: none; border: none; padding: 0;">
                <?php
                
                $profilePicPath = $row['profile_picture'];
                if (empty($profilePicPath)) {
                   
                    $profilePicPath = "img/defaultprofile.jpeg";
                } else {
                    
                    $profilePicPath = "handlepfp.php?user_id=" . urlencode($user_id);
                }
                ?>
                <img src="<?php echo $profilePicPath; ?>" class="img-fluid rounded-circle" alt="Profile Picture">
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
                        <form id="updateProfilePicForm" method="POST" action="updatepfp.php" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="profilePicInput" class="form-label">Select New Profile Picture</label>
                                <input type="file" class="form-control" id="profilePicInput" name="profilePicInput" accept="image/*">
                                <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                            </div>
                            <button type="submit" class="btn btn-primary">Upload</button>
                        </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Account Information Form Column -->
            <div class="col-md-8">
            <h2>My Account</h2>
            <form id="updateForm" method="POST" action="update_info.php">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" value="<?php echo $row['username']; ?>">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo $row['email']; ?>">
                </div>
                <div class="mb-3">
                    <label for="DOB" class="form-label">Date of Birth</label>
                    <input type="date" class="form-control" id="DOB" name="DOB" value="<?php echo $row['dob']; ?>">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" value="<?php echo $row['password']; ?>">
                </div>
                <div class="mb-3">
                    <label for="new_password" class="form-label">New Password (leave blank to keep the same)</label>
                    <input type="password" class="form-control" id="new_password" name="new_password">
                </div>
                <button type="submit" class="btn btn-primary">Update Information</button>
            </form>
        </div>
    </div>
</div>

<div class="container">
    <div class="row justify-content-start">
        <h3>My posts:</h3>
        <ul class="list-group">
            <?php
            if ($posts_result) {
                while ($post = mysqli_fetch_assoc($posts_result)) {
                    $title = htmlspecialchars($post['title']);
                    $post_id = htmlspecialchars($post['discussionID']);
                    // Make sure to adjust the onclick function to properly handle the post_id
                    echo "<li class='list-group-item d-flex justify-content-between align-items-center' onclick='window.location.href=\"view_post.php?post_id=$post_id\";' style='cursor: pointer;'>$title<button type='button' class='btn btn-danger' onclick='event.stopPropagation(); deletePost($post_id);'>Delete</button></li>";
                }
            } else {
                echo "Error fetching posts: " . mysqli_error($conn);
            }
            ?>
        </ul>
    </div>
</div>

<!-- BOOTSTRAP -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<!-- BOOTSTRAP -->

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</body>

</html>