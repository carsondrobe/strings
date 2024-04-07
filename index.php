<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Strings Home</title>
    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- BOOTSTRAP -->
    <link href="css/home_style.css" rel="stylesheet">
    <link href="css/navbar.css" rel="stylesheet">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


</head>

<body>
    <?php include 'navbar.php'; ?>

    <?php
    if ($_GET['query'] != null) {
        echo '<h1>Search results for: ' . $_GET['query'] . '</h1>';
    } else if ($_GET['topic'] != null) {
        echo '<h1>Trending in ' . ucwords($_GET['topic']) . '</h1>';
    } else {
        // Check for Admin
        if (substr($_SESSION['username'], -6) === ".Admin") {
            echo '<h1>Welcome to Strings for Admin</h1>';
            echo '<div class="container">
                    <hr>
                    <div class="row align-items-center">
                        <div class="col-auto"> 
                            <p class="mb-0">Find Users:</p>
                        </div>
                        <div class="col">
                            <form class="input-group" id="search-users">
                                <input type="search" class="form-control rounded" placeholder="Search for Username"
                                    aria-label="Search" aria-describedby="search-addon" id="search-input" />
                                <button type="submit" class="btn btn-outline-primary" id="search-button">Search</button>
                            </form>
                        </div>
                    </div>
                    <ul class="users" id="user-list"></ul>
                    <hr>
                    <div class="row mt2"> 
                        <div class="col">
                            <div class="dropdown" id="reportDropdown"> 
                                <button class="btn btn-outline-black rounded-pill w-100 dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    View Reports<i class="bi bi-filter"></i>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="reportDropdown">
                                    <li><a class="dropdown-item" href="#">Today</a></li>
                                    <li><a class="dropdown-item" href="#">This Week</a></li>
                                    <li><a class="dropdown-item" href="#">This Month</a></li>
                                    <li><a class="dropdown-item" href="#">This Year</a></li>
                                    <li><a class="dropdown-item" onclick="generateAllTimeChart()">All Time</a></li>
                                    </ul>
                            </div>
                        </div>
                    </div>
                    <div id="chartContainer" style="display: none;">
                        <canvas id="categoryChart"></canvas>
                        <button type="button" class="btn-close" aria-label="Close" onclick="hideChart()"></button>                    </div>
                    <hr>
                </div>';
        } else {
            echo '<h1>Welcome to Strings</h1>';
        }
    }
    ?>

    <!-- Script for usage chart generation and closing -->
    <script>
    async function fetchCategoryData() {
        document.getElementById("chartContainer").style.display = "block";
        const response = await fetch('usage_by_category.php');
        const data = await response.json();
        return data;
    }
    function createChart(data) {
        const ctx = document.getElementById('categoryChart').getContext('2d');
        const chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: data.map(row => row.category),
                datasets: [{
                    label: 'Number of Posts',
                    data: data.map(row => row.post_count),
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                maintainAspectRatio: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }
    function generateAllTimeChart() {
        fetchCategoryData().then(createChart);
    }
    function hideChart() {
        document.getElementById("chartContainer").style.display = "none";
    }
    </script>
    <style>
        #chartContainer {
            width: 60%;
            /* Adjust width as needed */
            margin: auto;
            /* This centers the div */
            padding: 20px;
        }

        #categoryChart {
            width: 100%;
            /* Make the canvas fill the container */
            height: auto;
            /* Maintain aspect ratio */
        }
    </style>

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
                                <input type="text" class="form-control" id="postCategory" name="postCategory" placeholder="Enter post category...">
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
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Post</button>
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


    <!-- Posts will be dynamically generated here -->
    <div class="container" id="postContainer">
        <!-- PHP script for displaying a post on the home page -->
        <?php
        session_start();
        include 'config.php';
        $filter = isset($_GET['filter']) ? $_GET['filter'] : null;
        $topic = isset($_GET['topic']) ? $_GET['topic'] : null;


        if ($_GET['query'] == null) {
            $query = "SELECT * FROM Discussions";
            if ($topic != null) {
                $query .= " WHERE category = '$topic'";
            }
        } else {
            $search = $_GET['query'];
            $search = htmlspecialchars($search);
            $search = mysqli_real_escape_string($conn, $search);
            $query = "SELECT * FROM Discussions WHERE ((`title` LIKE '%" . $search . "%') OR (`content` LIKE '%" . $search . "%'))";
            if ($topic != null) {
                $query .= " AND category = '$topic'";
            }
        }

        if ($filter == 'highest') {
            $query .= " ORDER BY upvotes DESC";
        } else if ($filter == 'recent') {
            $query .= " ORDER BY time_posted DESC";
        } else if ($filter == 'oldest') {
            $query .= " ORDER BY time_posted ASC";
        }
        try {
            $result = $conn->query($query);
            if ($result->num_rows == 0) {
                echo '<h1 style="text-align:center;">No results found</h1>';
            } else {
                $queryStringHighest = buildQueryStringFilter('highest', $topic);
                $queryStringRecent = buildQueryStringFilter('recent', $topic);
                $queryStringOldest = buildQueryStringFilter('oldest', $topic);

                echo '<!-- Filter Button -->
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-md-5"> 
                            <div class="dropdown" id="filter-dropdown">
                                <button class="btn btn-outline-black rounded-pill dropdown-toggle w-100" type="button" data-bs-toggle="dropdown">
                                    Filter<i class="bi bi-filter"></i>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="?' . $queryStringRecent . '">Newest</a></li>
                                    <li><a class="dropdown-item" href="?' . $queryStringOldest . '">Oldest</a></li>
                                    <li><a class="dropdown-item" href="?' . $queryStringHighest . '">Highest Voted</a></li>
                                    
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>';
            }

            while ($row = $result->fetch_assoc()) {
                $imageData = base64_encode($row['discussion_picture']);
                $contentPeek = substr($row['content'], 0, 100);
                $contentPeek .= '...';
                echo '
            <div class="row justify-content-center">
            <div class="col-6">
                <div class="card post-card">
                        <div class="card-body">
                            <p class="card-text"><strong>Posted by:✏️</strong> ' . ($row['username']) . ' | <strong>Published on:</strong> ' . ($row['time_posted']) . '</p>
                            <hr>
                            <a href="view_post.php?discussionID=' . $row['discussionID'] . '" class="post-link">                        
                                <h4 class="card-title">' . ($row['title']) . '</h4>
                                <img src="data:image/jpeg;base64,' . $imageData . '" class="card-img-top" alt="Discussion Image" id="discussion-image">
                                <p class="card-text">' . $contentPeek . '</p>
                            </a>
                            <hr>
                            <div class="d-flex justify-content-between">
                                <p class="card-text" id="discussion-category">' . $row['category'] . '</p>
                                <div>
                                    <button type="button" class="btn btn-outline-success me-2" disabled>' . $row['upvotes'] . ' Upvotes</button>
                                    <button type="button" class="btn btn-outline-danger" disabled>' . $row['downvotes'] . ' Downvotes</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            ';
            }
            // $conn->close();
        } catch (Exception $e) {
            die($e->getMessage());
        }
        function buildQueryStringFilter($filter, $topic)
        {
            $queryParams = array(
                'query' => $_GET['query'],
                'filter' => $filter,
                'topic' => $topic
            );
            return http_build_query($queryParams);
        }

        ?>
    </div>


    <script>
        document.querySelector('#search-users').addEventListener('submit', function(event) {
            event.preventDefault();
            var searchQuery = document.getElementById('search-input').value;
            var xhr = new XMLHttpRequest();
            xhr.open("GET", "search_users.php?query=" + searchQuery, true);
            xhr.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById('user-list').innerHTML = this.responseText;
                }
            };
            xhr.send();
        });

        function deleteUser(userID, element) {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "delete_user.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    // Remove the <li> element from the screen
                    element.parentNode.removeChild(element);
                }
            };
            xhr.send("userID=" + userID);
        }
    </script>
</body>

</html>