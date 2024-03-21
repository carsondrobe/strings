<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Strings Home A</title>
    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- BOOTSTRAP -->
    <link href="css/home_style.css" rel="stylesheet">
    <link href="css/navbar.css" rel="stylesheet">


</head>

<body>
    <?php include 'navbar.php'; ?>

    <h1>Welcome to Strings</h1>

    <!-- Filter Button -->
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5"> <!-- Adjust the column width based on your layout -->
                <div class="dropdown" id="filter-dropdown">
                    <button class="btn btn-outline-black rounded-pill dropdown-toggle w-100" type="button" data-bs-toggle="dropdown">
                        Filter<i class="bi bi-filter"></i>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Trending</a></li>
                        <li><a class="dropdown-item" href="#">Recent</a></li>
                        <li><a class="dropdown-item" href="#">Highest Voted</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- BOOTSTRAP -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <!-- BOOTSTRAP -->

    <!-- Create Post Modal -->
    <div class="modal fade" id="createPostModal" tabindex="-1" aria-labelledby="modal-title" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createPostModalTitle">Start a discussion!</h5>
                </div>
                <div class="modal-body">
                    <form method="post" action="create_post.php" enctype="multipart/form-data">
                        <div class="form-group row">
                            <label for="postCategory" class="col-sm-2 col-form-label">Category</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="postCategory" name="postCategory" placeholder="Enter post category">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="postTitle" class="col-sm-2 col-form-label">Title</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="postTitle" name="postTitle" placeholder="Enter post title...">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="postImage" class="col-sm-2 col-form-label">Image</label>
                            <div class="col-sm-10">
                                <input type="file" id="postImage" name="postImage">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="postDescription">Description</label>
                            <textarea class="form-control" id="postDescription" name="postDescription" rows="5" placeholder="Enter post description..."></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Post</button>
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
                document.body.scrollTop > 500 ||
                document.documentElement.scrollTop > 500
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


    <!-- When a post is searched for -->
    <script>
        function goToSearchResults() {
            var searchTerm = document.getElementById('nav-bar-search').value;
            if (searchTerm.trim() !== '') {
                window.location.href = 'search_results.html?query=' + encodeURIComponent(searchTerm);
            }
            return false; // Prevents the form from submitting in the traditional way
        }
    </script>

<!-- Posts will be dynamically generated here -->
<div class="container" id="postContainer">
    <!-- PHP script for displaying a post on the home page -->
    <?php 
    session_start();
    include 'config.php';
    try {
        $query = "SELECT * FROM Discussions";
        $result = $conn->query($query);
        while($row = $result->fetch_assoc()) {
            $imageData = base64_encode($row['discussion_picture']);
            $contentPeek = substr($row['content'], 0, 100);
            $contentPeek .= '...';
            echo '
            <div class="row justify-content-center">
            <div class="col-6">
                <div class="card">
                        <div class="card-body">
                            <p class="card-text"><strong>Posted by:✏️</strong> '.($row['username']).' | <strong>Published on:</strong> '.($row['time_posted']).'</p>
                            <hr>
                            <a href="view_post.php?discussionID='.$row['discussionID'].'" class="post-link">                        
                                <h4 class="card-title">'.($row['title']).'</h4>
                                <img src="data:image/jpeg;base64,'.$imageData.'" class="card-img-top" alt="Discussion Image" id="discussion-image">
                                <p class="card-text">'.$contentPeek.'</p>
                            </a>
                            <hr>
                            <div class="d-flex justify-content-between">
                                <p class="card-text" id="discussion-category">'.$row['category'].'</p>
                                <div>
                                    <button type="button" class="btn btn-outline-success me-2">+ ('.$row['upvotes'].')</button>
                                    <button type="button" class="btn btn-outline-danger">- ('.$row['downvotes'].')</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            ';
        }
        // $conn->close();
    } catch(Exception $e) {
        die($e->getMessage());
    }
    ?>
</div>
</body>
</html>