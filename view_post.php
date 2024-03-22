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
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $discussionId);
            $stmt->execute();
            $result = $stmt->get_result();
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
                                        <p class="card-text"><strong>✏️ Posted by: </strong>'.($row['username']).' | <strong>Published on:</strong> '.($row['time_posted']).' | <i><strong>'.($row['category']).'</strong></i></p>
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
                                                        <h5 class="card-title">Leave a comment!</h5>
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
                        echo '  <button onclick="openEditModal('.($row['discussionID']).', '.($row['title']).', '.($row['content']).', '.($row['category']).')" class="btn btn-outline-info" style="text-align: left; display: block;" id="edit-post-btn">Edit Post</button>
                                <form method="post" action="delete_discussion.php">
                                    <input type="hidden" name="discussionID" value="'.$discussionId.'">
                                    <button type="submit" class="btn btn-danger" style="float: right; display: block;" id="delete-comment-btn" onclick="return confirm(\'Are you sure you want to delete this post?\');">Delete Post</button>
                                </form>';
                    }
                }
                echo '
                                    </div>
                                </div>
                                <br>
                ';
                // Dynamically generate comments here
                $query2 = "SELECT * FROM Comments WHERE discussionID = ?";
                $stmt2 = $conn->prepare($query2);
                $stmt2->bind_param("i", $discussionId);
                $stmt2->execute();
                $result2 = $stmt2->get_result();
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
                                                <div class="card" id="comment-'.$comment['commentID'].'">
                                                    <div class="card-body">
                                                        <p class="card-text"><strong>✏️ Written By: ' . $comment['username'] . ' | ' . $comment['timePosted'] . '</strong></p>
                                                        <div id="comment-content-'.$comment['commentID'].'" style="display:block;">
                                                            <p class="card-text">'.$comment['content'].'</p>
                                                            <div id="edit-form-'.$comment['commentID'].'" style="display:none;">
                                                                <div class="card" style="margin-bottom: 15px;">
                                                                    <div class="card-body">
                                                                    <h5 class="card-title">Edit your comment:</h5>
                                                                        <form method="post" action="edit_comment.php">
                                                                            <input type="hidden" name="commentID" value="'.$comment['commentID'].'">
                                                                            <textarea class="form-control" name="updatedContent" rows="3" style="margin-bottom: 15px;">'.($comment['content']).'</textarea>
                                                                            <button type="submit" class="btn btn-success btn-sm">Update</button>
                                                                            <button type="button" onclick="cancelEditComment('.$comment['commentID'].')" class="btn btn-secondary btn-sm">Cancel</button>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                        ';
                        if($_SESSION['username'] == $comment['username']) {
                            echo '
                                                            <button onclick="editComment('.$comment['commentID'].')" class="btn btn-outline-info btn-sm style="text-align: left; display: inline;" id="edit-comment-btn">Edit Comment</button>
                                                            <form method="post"  action="delete_comment.php" style="text-align: right;">
                                                                <input type="hidden" name="commentID" value='.$comment['commentID'].'>
                                                                <button type="submit" class="btn btn-danger btn-sm" style="text-align: right; display: inline;" id="delete-comment-btn" onclick="return confirm(\'Are you sure you want to delete this comment?\');">Delete Comment</button>
                                                            </form>
                            ';
                        }
                        echo '
                                                        </div>
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
    <!-- JavaScript functions for editing posts and comments -->
    <script>
        function editComment(commentID) {
            document.getElementById('edit-form-' + commentID).style.display = "block";
            document.getElementById('edit-comment-btn').style.display = "none";
            document.getElementById('delete-comment-btn').style.display = "none";
        }
        function cancelEditComment(commentID) {
            document.getElementById('edit-form-' + commentID).style.display = "none";
            document.getElementById('edit-comment-btn').style.display = "inline";
            document.getElementById('delete-comment-btn').style.display = "inline";
        }
        function editPost() {
            document.getElementById('post-edit-form').style.display = 'block';
            document.getElementById('post-display').style.display = 'none';
            document.getElementById('edit-comment-btn').style.display = "none";
            document.getElementById('delete-comment-btn').style.display = "none";
        }
        function cancelEditPost() {
            document.getElementById('post-edit-form').style.display = 'none';
            document.getElementById('post-display').style.display = 'block';
            document.getElementById('edit-comment-btn').style.display = "block";
            document.getElementById('delete-comment-btn').style.display = "block";
        }
        function openEditModal(discussionID, title, content, category) {
            document.getElementById('editDiscussionID').value = discussionID;
            document.getElementById('editPostTitle').value = title;
            document.getElementById('editPostContent').value = content;
            document.getElementById('editPostCategory').value = category;
            var editModal = new bootstrap.Modal(document.getElementById('editPostModal'), {
            keyboard: false
            });
            editModal.show();
        }
    </script>
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

        <!-- Edit Post Modal -->
        <div class="modal fade" id="editPostModal" tabindex="-1" aria-labelledby="modal-title" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editPostModalTitle">Edit your post:</h5>
                </div>
                <div class="modal-body">
                    <form method="post" action="edit_post.php" enctype="multipart/form-data">
                    <input type="hidden" name="discussionID" id="editDiscussionID">
                        <div class="form-group row">
                            <label for="editPostCategory" class="col-sm-2 col-form-label">Category</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="editPostCategory" name="editPostCategory" placeholder="Enter post category">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="editPostTitle" class="col-sm-2 col-form-label">Title</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="editPostTitle" name="editPostTitle" placeholder="Enter post title...">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="editPostImage" class="col-sm-2 col-form-label">Image</label>
                            <div class="col-sm-10">
                                <input type="file" id="editPostImage" name="editPostImage">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="editPostContent">Description</label>
                            <textarea class="form-control" id="editPostContent" name="editPostContent" rows="5" placeholder="Enter post description..."></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Update Post</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>

</html>