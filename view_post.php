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
    <link href="css/loggedInNavbar.css" rel="stylesheet">


</head>

<body>

<?php include 'navbar.php'; ?>

<!-- PHP script for displaying a post on the home page -->
<?php 
session_start();
include 'config.php';
try {
    if(isset($_GET['discussionID'])) {
        $postId = $_GET['discussionID'];
        $query = "SELECT * FROM Discussions WHERE discussionID = " . $postId;
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
                        <div class="col text-center white-text">
                            <a href="index.php" class="btn-close white-button"></a>
                        </div>
                    </div>
                </div>
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
                                    <p class="card-text">
                                        3 Comments
                                    </p>';
                                    if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] === true) {
                                        echo '
                                            <div class="card mb-3">
                                                <div class="card-body">
                                                    <h5 class="card-title">Create a Comment</h5>
                                                    <form>
                                                        <div class="mb-3">
                                                            <textarea class="form-control" id="commentContent" rows="3" required></textarea>
                                                        </div>
                                                        <button class="btn btn-outline-info" type="submit">
                                                            Submit
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        ';
                                    }
                                    echo '
                                </div>
                            </div>
                            <hr>
                            <div class="card" id="first-comment">
                                <div class="card-body">
                                    <p class="card-text">✏️ iPhoneGuy | 1 day ago</p>
                                    <p class="card-text">This is the best news ever!</p>
                                </div>
                            </div>
                            <div class="card" id="second-comment">
                                <div class="card-body">
                                    <p class="card-text">✏️ AndroidNerd | 1 day ago</p>
                                    <p class="card-text">I diagree you fool.</p>
                                </div>
                            </div>
                            <div class="card" id="first-comment">
                                <div class="card-body">
                                    <p class="card-text">✏️ UselessJoe | 1 day ago</p>
                                    <p class="card-text">I am so confused! Iaculis at erat pellentesque adipiscing commodo elit at
                                        imperdiet dui. Semper
                                        feugiat nibh sed pulvinar proin gravida hendrerit lectus a. Odio ut sem nulla pharetra diam
                                        sit amet nisl suscipit. Neque viverra justo nec ultrices dui sapien eget mi proin. Dignissim
                                        enim sit amet venenatis urna cursus eget nunc scelerisque. Tortor consequat id porta nibh
                                        venenatis. Interdum varius sit amet mattis vulputate enim nulla. Adipiscing at in tellus
                                        integer feugiat.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
    ';

    } else {
        echo "No post found with the provided discussionID.";
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