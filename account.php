<?php
include 'navbar.php';
include 'config.php';
// debug
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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
if (!$row) {
    echo "Error: User not found";
    exit();
}

$username = mysqli_real_escape_string($conn, $row['username']);

$email = mysqli_real_escape_string($conn, $row['email']);
if (empty($email)) {
    $email = "No email provided";
}
$dob = mysqli_real_escape_string($conn, $row['dob']);
if (empty($dob)) {
    $dob = "No date of birth provided";
}
$pfp = mysqli_real_escape_string($conn, $row['profile_picture']);

$posts_query = "SELECT * FROM Discussions WHERE username = '$username' ORDER BY time_posted DESC";
$posts_result = mysqli_query($conn, $posts_query);

$comments_query = "SELECT * FROM Comments WHERE username = ? ORDER BY time_posted DESC";
$comments_stmt = mysqli_prepare($conn, $comments_query);
if (!$comments_stmt) {
    echo "Error preparing statement: " . mysqli_error($conn);
    exit();
}
mysqli_stmt_bind_param($comments_stmt, 's', $username);
mysqli_stmt_execute($comments_stmt);
$comments_result = mysqli_stmt_get_result($comments_stmt);

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

                    $profilePicPath = $pfp;
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

            <!-- Account Information Display -->
            <div class="col-md-8">
                <h2>My Account</h2>
                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <div class="form-text"><?php echo htmlspecialchars($username); ?></div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Email address</label>
                    <div class="form-text"><?php echo htmlspecialchars($email); ?></div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Date of Birth</label>
                    <div class="form-text"><?php echo htmlspecialchars($dob); ?></div>
                </div>

                <!-- Password Change Form -->
                <form id="passwordChangeForm" method="POST" action="update_password.php">
                    <div class="mb-3">
                        <label for="current_password" class="form-label">Current Password</label>
                        <input type="password" class="form-control" id="current_password" name="current_password" required>
                    </div>
                    <div class="mb-3">
                        <label for="new_password" class="form-label">New Password (leave blank to keep the same)</label>
                        <input type="password" class="form-control" id="new_password" name="new_password" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Password</button>
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
                        echo "
                        <li class='list-group-item d-flex justify-content-between align-items-center'>
                            <a href=\"view_post.php?discussionID=$post_id\" class=\"post-link\">                        
                                <h4 class=\"card-title\">$title</h4>
                            </a>
                            <form method=\"post\" action=\"delete_discussion.php\">
                                <input type=\"hidden\" name=\"discussionID\" value=$post_id>
                                <button type=\"submit\" class=\"btn btn-danger\" style=\"float: right; display: block; margin-top: auto;\" id=\"delete-post-btn\" onclick=\"return confirm('Are you sure you want to delete this post?');\">Delete Post</button>
                            </form>
                        </li>
                        ";
                    }
                } else {
                    echo "Error fetching posts: " . mysqli_error($conn);
                }
                ?>
            </ul>
        </div>
    </div>

    
    <div class="container">
        <div class="row justify-content-start">
            <h3>My comments:</h3>
            <ul class="list-group">
                <?php
                if ($comments_result) {
                    while ($comment = mysqli_fetch_assoc($comments_result)) {
                        $content = htmlspecialchars($comment['content']);
                        $comment_id = htmlspecialchars($comment['commentID']);
                        $content_post_id = htmlspecialchars($comment['discussionID']);
                        // Make sure to adjust the onclick function to properly handle the post_id
                        echo "
                        <li class='list-group-item d-flex justify-content-between align-items-center'>
                            <p>
                                $content
                            </p>
                            <a href=\"view_post.php?discussionID=$content_post_id\" class=\"post-link\">                        
                                <h4 class=\"card-title\">Go to post</h4>
                            </a>
                            <form method=\"post\"  action=\"delete_comment.php\" style=\"text-align: right;\">
                                <input type=\"hidden\" name=\"commentID\" value=$comment_id>
                                <button type=\"submit\" class=\"btn btn-danger btn-sm\" style=\"text-align: right; display: inline;\" id=\"delete-comment-btn-$comment_id\" onclick=\"return confirm('Are you sure you want to delete this comment?');\">Delete Comment</button>
                            </form>
                        </li>
                        ";
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