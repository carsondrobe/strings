<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Post</title>
    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
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
        if (isset($_GET['discussionID'])) {
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
                    <div class="container justify-content-center" style="margin-top: 5em;">
                        <div class="row justify-content-center">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <p class="card-text"><strong>✏️ Posted by: </strong>' . ($row['username']) . ' | <strong>Published on:</strong> ' . ($row['time_posted']) . ' | <i><strong>' . ($row['category']) . '</strong></i></p>
                                            <div>
                                                <button type="button" class="btn btn-outline-success me-2" disabled>' . $row['upvotes'] . ' Upvotes</button>
                                                <button type="button" class="btn btn-outline-danger" disabled>' . $row['downvotes'] . ' Downvotes</button>
                                            </div>
                                        </div>
                                        <h4 class="card-title">' . ($row['title']) . '</h4>
                                        <img src="data:image/jpeg;base64,' . $imageData . '" class="card-img-top img-fluid mx-auto d-block"
                                            style="max-width: 400px; margin-bottom: .25em;" alt="Discussion Image">
                                        <p class="card-text">' . ($row['content']) . '</p>
                                        <hr>
                ';
                // If user is logged in
                if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] === true) {
                    // Check if user has already rated this post by querying user votes table
                    $stmt = $conn->prepare("SELECT voteType FROM UserVotes WHERE userID = ? AND discussionID = ?");
                    $stmt->bind_param("ii", $_SESSION['user_id'], $discussionId);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    // If user has already rated this post
                    if($result->num_rows > 0) {
                        // Display opposite option of their vote
                        echo '<div class="d-flex justify-content-end mt-3">                        ';
                        $voteRow = $result->fetch_assoc();
                        $userVoteType = $voteRow['voteType'];
                        if($voteRow['voteType'] !== 'upvote') {
                            echo '
                                <form method="post" action="ratings.php">
                                    <input type="hidden" name="discussionID" value="'.($row['discussionID']).'">
                                    <input type="hidden" name="ratingType" value="upvote">
                                    <button type="submit" id="upvote-btn" class="btn btn-outline-success me-2">Upvote</button>
                                </form>
                            ';
                        } else {
                            echo '
                            <form method="post" action="ratings.php">
                                <input type="hidden" name="discussionID" value="'.($row['discussionID']).'">
                                <input type="hidden" name="ratingType" value="downvote">
                                <button type="submit" id="downvote-btn" class="btn btn-outline-danger">Downvote</button>
                            </form>
                            ';
                        }
                        echo '</div>';
                    } else {
                        echo '
                            <div class="d-flex justify-content-end mt-3">
                                <form method="post" action="ratings.php">
                                    <input type="hidden" name="discussionID" value="'.($row['discussionID']).'">
                                    <input type="hidden" name="ratingType" value="upvote">
                                    <button type="submit" id="upvote-btn" class="btn btn-outline-success me-2">Upvote</button>
                                </form>
                                <form method="post" action="ratings.php">
                                    <input type="hidden" name="discussionID" value="'.($row['discussionID']).'">
                                    <input type="hidden" name="ratingType" value="downvote">
                                    <button type="submit" id="downvote-btn" class="btn btn-outline-danger">Downvote</button>
                                </form>
                            </div>
                        ';
                    }                    
                    // Display create a comment form
                    echo '       
                                                <br>
                                                <div class="card mb-3">
                                                    <div class="card-body">
                                                        <h5 class="card-title">Leave a comment!</h5>
                                                        <form id="commentForm">
                                                            <input type="hidden" name="discussionID" value=' . $discussionId . '>
                                                            <div class="mb-3">
                                                                <textarea class="form-control" id="commentContent" name="commentContent" rows="3" required></textarea>
                                                                <div id="characterCount" style="float: right;"></div>
                                                            </div>
                                                            <button type="button" id="submitComment" class="btn btn-outline-info">Comment</button>
                                                        </form>
                                                    </div>
                                                </div>
                    ';
                    // If user is admin
                    if (substr($_SESSION['username'], -6) === ".Admin") {
                        // If admin is author, allowing editing of post
                        if ($_SESSION['username'] == $row['username']) {
                            echo '  
                                            <a class="nav-link active" type="button" aria-disabled="true" data-bs-toggle="modal" data-bs-target="#editPostModal">
                                                <button onclick="openEditModal(\'' . htmlspecialchars($row['discussionID']) . '\', \'' . htmlspecialchars(addslashes($row['title']), ENT_QUOTES) . '\', \'' . htmlspecialchars(addslashes($row['content']), ENT_QUOTES) . '\', \'' . htmlspecialchars(addslashes($row['category']), ENT_QUOTES) . '\')" class="btn btn-outline-info" style="text-align: left; display: block;" id="edit-post-btn">Edit Post</button>
                                            </a>
                            ';
                        }
                        // Allow deletion of post
                        echo '      
                                            <form method="post" action="delete_discussion.php">
                                                <input type="hidden" name="discussionID" value="' . $discussionId . '">
                                                <button type="submit" class="btn btn-danger" style="float: right; display: block;" id="delete-post-btn" onclick="return confirm(\'Are you sure you want to delete this post?\');">Delete Post</button>
                                            </form>
                        ';
                        // If user is author, allow editing and deletion of post
                    } elseif ($_SESSION['username'] == $row['username']) {
                        echo '      
                                            <a class="nav-link active" type="button" aria-disabled="true" data-bs-toggle="modal" data-bs-target="#editPostModal">
                                                <button onclick="openEditModal(\'' . htmlspecialchars($row['discussionID']) . '\', \'' . htmlspecialchars(addslashes($row['title']), ENT_QUOTES) . '\', \'' . htmlspecialchars(addslashes($row['content']), ENT_QUOTES) . '\', \'' . htmlspecialchars(addslashes($row['category']), ENT_QUOTES) . '\')" class="btn btn-outline-info" style="text-align: left; display: block;" id="edit-post-btn">Edit Post</button>
                                            </a>
                                            <form method="post" action="delete_discussion.php">
                                                <input type="hidden" name="discussionID" value="' . $discussionId . '">
                                                <button type="submit" class="btn btn-danger" style="float: right; display: block;" id="delete-post-btn" onclick="return confirm(\'Are you sure you want to delete this post?\');">Delete Post</button>
                                            </form>
                        ';
                    }
                }
                echo '
                                    </div>
                                </div>
                                <br>
                                <div class="comments-container">
                ';
                // Dynamically generate comments here
                $query2 = "SELECT * FROM Comments WHERE discussionID = ?";
                $stmt2 = $conn->prepare($query2);
                $stmt2->bind_param("i", $discussionId);
                $stmt2->execute();
                $result2 = $stmt2->get_result();
                $num_comments = $result2->num_rows;
                if ($num_comments > 0) {
                    if ($num_comments == 1) {
                        echo '
                                            <p class="card-text" id="numComments">1 Comment</p>
                        ';
                    } else {
                        echo '
                                            <p class="card-text" id="numComments">' . $num_comments . ' Comments</p>
                        ';
                    }
                    while ($comment = $result2->fetch_assoc()) {
                        echo '
                                                <div class="card" id="comment-' . $comment['commentID'] . '">
                                                    <div class="card-body">
                                                        <p class="card-text"><strong>✏️ Written By: ' . $comment['username'] . ' | ' . $comment['timePosted'] . '</strong></p>
                                                        <div id="comment-content-' . $comment['commentID'] . '" style="display:block;">
                                                            <p class="card-text">' . $comment['content'] . '</p>
                                                            <div id="edit-form-' . $comment['commentID'] . '" style="display:none;">
                                                                <div class="card" style="margin-bottom: 15px;">
                                                                    <div class="card-body">
                                                                    <h5 class="card-title">Edit your comment:</h5>
                                                                        <form method="post" action="edit_comment.php">
                                                                            <input type="hidden" name="commentID" value="' . $comment['commentID'] . '">
                                                                            <textarea class="form-control" name="updatedContent" rows="3" style="margin-bottom: 15px;">' . ($comment['content']) . '</textarea>
                                                                            <button type="submit" class="btn btn-success btn-sm">Update</button>
                                                                            <button type="button" onclick="cancelEditComment(' . $comment['commentID'] . ')" class="btn btn-secondary btn-sm">Cancel</button>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                        ';
                        // If user is admin
                        if (substr($_SESSION['username'], -6) === ".Admin") {
                            // If admin is author, allowing editing of comment
                            if ($_SESSION['username'] == $comment['username']) {
                                echo '  <button onclick="editComment(' . $comment['commentID'] . ')" class="btn btn-outline-info btn-sm style="text-align: left; display: inline;" id="edit-comment-btn">Edit Comment</button>';
                            }
                            // Allow deletion of comment
                            echo '      <form method="post"  action="delete_comment.php" style="text-align: right;">
                                            <input type="hidden" name="commentID" value=' . $comment['commentID'] . '>
                                            <button type="submit" class="btn btn-danger btn-sm" style="text-align: right; display: inline;" id="delete-comment-btn" onclick="return confirm(\'Are you sure you want to delete this comment?\');">Delete Comment</button>
                                        </form>
                            ';
                            // If user is author, allow editing and deletion of comment
                        } elseif ($_SESSION['username'] == $comment['username']) {
                            echo '      <button onclick="editComment(' . $comment['commentID'] . ')" class="btn btn-outline-info btn-sm style="text-align: left; display: inline;" id="edit-comment-btn">Edit Comment</button>                                        
                                        <form method="post"  action="delete_comment.php" style="text-align: right;">
                                            <input type="hidden" name="commentID" value=' . $comment['commentID'] . '>
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
                    echo '
                            </div>
                            <p class="card-text" id="numComments">No one has commented yet, be the first!</p>';
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
    } catch (Exception $e) {
        die($e->getMessage());
    }
    ?>
    <!-- JavaScript functions for posts and comments and rating buttons -->
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
            document.getElementById('edit-post-btn').style.display = "none";
            document.getElementById('delete-post-btn').style.display = "none";
        }

        function cancelEditPost() {
            document.getElementById('post-edit-form').style.display = 'none';
            document.getElementById('post-display').style.display = 'block';
            document.getElementById('edit-post-btn').style.display = "block";
            document.getElementById('delete-post-btn').style.display = "block";
        }

        function openEditModal(discussionID, title, content, category) {
            document.getElementById('editDiscussionID').value = discussionID;
            document.getElementById('editPostTitle').value = title;
            document.getElementById('editPostContent').value = content;
            document.getElementById('editPostCategory').value = category;   
        }

        document.getElementById('submitComment').addEventListener('click', function() {
            var discussionID = document.querySelector('#commentForm input[name="discussionID"]').value;
            var commentContent = document.getElementById('commentContent').value;
            var comment = new FormData();
            comment.append('discussionID', discussionID);
            comment.append('commentContent', commentContent);
            fetch('create_comment.php', {
                method: 'POST',
                body: comment
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    // Add comment to page asynchronously
                    document.getElementById('commentContent').value = '';
                    var commentsContainer = document.querySelector('.comments-container');
                    var newComment = document.createElement('div');
                    newComment.classList.add('card');
                    newComment.innerHTML = `
                        <div class="card-body">
                            <p class="card-text"><strong>✏️ Written By: ${data.username || 'You'} | ${data.timePosted}</strong></p>
                            <p class="card-text">${commentContent}</p>
                            <button onclick="editComment(${data.commentId})" class="btn btn-outline-info btn-sm" style="text-align: left; display: inline;" id="edit-comment-btn">Edit Comment</button>
                            <form method="post" action="delete_comment.php" style="text-align: right;">
                                <input type="hidden" name="commentID" value="${data.commentId}">
                                <button type="button" class="btn btn-danger btn-sm" style="text-align: right; display: inline;" id="delete-comment-btn" onclick="return confirm('Are you sure you want to delete this comment?');">Delete Comment</button>
                            </form>
                        </div>
                    `;
                    commentsContainer.appendChild(newComment);
                    // Update number of comments asynchronously
                    if(data.numComments == 1) {
                        document.getElementById('numComments').textContent = `${data.numComments} Comment`;
                    } else {
                        document.getElementById('numComments').textContent = `${data.numComments} Comments`;
                    }
                } else {
                    alert('Error submitting comment: ' + data.message);
                }
            })
            .catch(error => console.error('Error:', error));
        });

        document.getElementById('commentContent').addEventListener('input', function() {
            var characters = this.value.length;
            var maxCharacters = 5000;
            var currentLength = maxCharacters - characters;
            document.getElementById('characterCount').textContent = currentLength + " characters remaining";
            });
        
        document.getElementById('submitComment').addEventListener('click', function() {
            document.getElementById('characterCount').textContent = "5000 characters remaining";
        });
    </script>
    <!-- BOOTSTRAP -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <!-- BOOTSTRAP -->

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
                                <input type="text" class="form-control" id="editPostCategory" name="editPostCategory" placeholder="Enter post category...">
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

    <!-- Back to top button -->
    <button type="button" class="btn btn-outline-black" id="btn-back-to-top">
        Back to Top
    </button>

    <!-- Back to Top Logic -->
    <script>
        //Get the button
        let mybutton = document.getElementById("btn-back-to-top");

        // When the user scrolls down 20px from the top of the document, show the button
        window.onscroll = function() {
            scrollFunction();
        };

        function scrollFunction() {
            if (
                document.body.scrollTop > 0 ||
                document.documentElement.scrollTop > 0
            ) {
                mybutton.style.display = "block";
            } else {
                mybutton.style.display = "none";
            }
        }
        // When the user clicks on the button, scroll to the top of the document
        mybutton.addEventListener("click", backToTop);

        function backToTop() {
            document.body.scrollTop = 0;
            document.documentElement.scrollTop = 0;
        }
    </script>

</body>

</html>