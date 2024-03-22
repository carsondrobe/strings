<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Post</title>
    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- BOOTSTRAP -->
    <link href="css/view_post.css" rel="stylesheet">
    <link href="css/navbar.css" rel="stylesheet">
    </head>

<body>

    <?php include 'navbar.php'; ?>

    <!-- PHP script for displaying a post on the home page -->
    <?php 
    session_start();
    include 'config.php';
    try {
        if(isset($_GET['discussionID'])) {
            $discussionId = $_GET['discussionID'];
            $_SESSION['discussionID'] = $discussionId;
            $query = "SELECT * FROM Discussions WHERE discussionID = " . $discussionId;
            $result = $conn->query($query);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $imageData = base64_encode($row['discussion_picture']);
                echo '
                    <div class="container justify-content-center" id="headbar">
                        <div class="row align-items-center">
                            <div class="col " id="headtext">
                                <button type="button" class="btn btn-outline-success me-2">+</button>
                                <button type="button" class="btn btn-outline-danger">-</button>
                            </div>
                            <div class="col-6 " id="headtext">'.($row['title']).'</div>
                            <div class="col text-end white-text">
                                <a href="index.php" class="btn-close white-button">&nbsp;&nbsp;&nbsp;&nbsp;</a>
                            </div>
                        </div>
                    </div>
                    <br><br>
                    <div class="container justify-content-center">
                        <div class="row justify-content-center">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <p class="card-text"><strong>Posted by: ✏️ </strong>'.($row['username']).' | <strong>Published on:</strong>
                                        '.($row['time_posted']).'</p>
                                        <h4 class="card-title">'.($row['title']).'</h4>
                                        <img src="data:image/jpeg;base64,'.$imageData.'" class="card-img-top img-fluid mx-auto d-block"
                                            style="max-width: 400px; margin-bottom: .25em;" alt="Discussion Image">
                                        <p class="card-text">'.($row['content']).'</p>
                                        <hr>
                                        <div class="d-flex justify-content-end mt-3">
                                            <button type="button" class="btn btn-outline-success me-2">+ ('.($row['upvotes']).')</button>
                                            <button type="button" class="btn btn-outline-danger">- ('.($row['downvotes']).')</button>
                                        </div>
                                        <br>
                ';
                // If user is logged in
                if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] === true) {
                    // Display create a comment form
                    echo '
                                                <div class="card mb-3">
                                                    <div class="card-body">
                                                        <h5 class="card-title">Create a Comment</h5>
                                                        <form method="post" action="create_comment.php">
                                                            <input type="hidden" name="discussionID" value='.$discussionId.'>
                                                            <div class="mb-3">
                                                            <textarea class="form-control" id="commentContent" name="commentContent" rows="3" required></textarea>
                                                            </div>
                                                            <button class="btn btn-outline-info" type="submit">
                                                                Comment
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                    ';
                    // Display button to delete post if user is author of post
                    if ($_SESSION['username'] == $row['username']) {
                        echo '<form method="post" action="delete_discussion.php">
                                <input type="hidden" name="discussionID" value="'.$discussionId.'">
                                <button type="submit" class="btn btn-danger" onclick="return confirm(\'Are you sure you want to delete this post?\');">Delete Discussion</button>
                              </form>';
                    }
                }
                echo '
                                    </div>
                                </div>
                                <br>
                ';
                // Dynamically generate comments here
                $query2 = "SELECT * FROM Comments WHERE discussionID = " . $discussionId;
                $result2 = $conn->query($query2);
                $num_comments = $result2->num_rows;
                if ($num_comments > 0) {
                    if($num_comments == 1) {
                        echo '
                                            <p class="card-text">1 Comment</p>
                        ';
                    } else {
                        echo '
                                            <p class="card-text">'.$num_comments.' Comments</p>
                        ';
                    }
                    while ($comment = $result2->fetch_assoc()) {
                        echo '
                                                <div class="card" id="comment">
                                                    <div class="card-body">
                                                        <p class="card-text"><strong>Written By: ' . $comment['username'] . ' ✏️ | ' . $comment['timePosted'] . '</strong></p>
                            ';
                                    
                        // if ($comment['replyingTo'] != NULL) {
                        //     echo '
                        //                                 <p class="card-text">Responding To: ' . $comment['replyingTo'] . '</p>
                        //     ';
                        // }
                        
                        echo '
                                                        <p class="card-text">' . $comment['content'] . '</p>
                                                    </div>
                                                </div>
                            ';
                    }
                } else {
                    echo '<p class="card-text">No one has commented yet, be the first!</p>';
                }
                echo '
                            </div>
                        </div>
                    </div>
                    <br><br>
                ';
            } else {
                echo "Could not find any posts with this discussionID.";
            }
        } else {   
            echo "Could not find a discussionID.";
    }
    // $conn->close();
    } catch(Exception $e) {
        die($e->getMessage());
    }
    ?>
    <!-- BOOTSTRAP -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    <!-- BOOTSTRAP -->

    <script>
        window.addEventListener('scroll', function () {
            var headbar = document.getElementById('headbar');

            if (window.scrollY > headbar.offsetTop) {
                headbar.classList.add('fixed-top');
            } else {
                headbar.classList.remove('fixed-top');
            }
        });
    </script>
</body>

</html>