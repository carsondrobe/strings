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


</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg bg-body-tertiary fixed-top">
        <div class="container-fluid">
            <!-- Logo -->
            <a class="navbar-brand" href="home.html">strings</a>
            <!-- Create a Post Button -->
            <a class="nav-link active" type="button" aria-disabled="true" data-bs-toggle="modal" data-bs-target="#createPostModal">Create Post ✏️ </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarScroll">
                <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">

                    <li class="nav-item">
                        <a class="nav-link" href="about_us.html">About Us</a>
                    </li>
                    <!-- Trending Tab -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Trending
                        </a>
                        <!-- Trending Content -->
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">🌍 World News</a></li>
                            <li><a class="dropdown-item" href="#">⚽ Sports</a></li>
                            <li><a class="dropdown-item" href="#">💊 Health</a></li>
                            <li><a class="dropdown-item" href="#">💼 Business</a></li>

                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="#">🔥 Trending For You</a></li>

                        </ul>
                    </li>

                </ul>

                <!-- Search Bar -->
                <form class="d-flex" role="search" onsubmit="return goToSearchResults()">
                    <input class="form-control me-2" type="search" placeholder="Search Strings... 🔍" aria-label="Search" id="nav-bar-search">
                </form>


                <!-- Notifications -->
                <div class="dropdown ms-auto">
                    <button type="button" class="btn btn-outline-dark ms-auto" data-bs-toggle="dropdown" aria-expanded="false" style="margin-top: 5px; border-radius: 20px; background-color: #ffffff; color: #343a40;">
                        <span style="margin-right: 5px;">📬</span> Notifications
                        <span class="badge bg-danger" style="margin-left: 5px;">5</span>
                    </button>
                    <ul class="dropdown-menu" style="max-height: 200px; overflow-y: auto;">
                        <!-- Sample messages as cards -->
                        <li>
                            <div class="card">
                                <div class="card-body">
                                    <p class="card-text">Sample Message 1</p>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="card">
                                <div class="card-body">
                                    <p class="card-text">Sample Message 2</p>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="card">
                                <div class="card-body">
                                    <p class="card-text">Sample Message 3</p>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="card">
                                <div class="card-body">
                                    <p class="card-text">Sample Message 4</p>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="card">
                                <div class="card-body">
                                    <p class="card-text">Sample Message 5</p>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>

                <!-- Login Button -->
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="login.html">Login</a>
                    </li>
                </ul>

            </div>
        </div>
    </nav>

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

    <!-- Post Feed -->
    <div class="container" id="postContainer">
        <!-- Posts will be dynamically generated here -->
    </div>

    <!-- Post Generation Script -->
    <script>
        const posts = [{
                title: "Exciting News in Tech World",
                content: "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.",
                author: "TechEnthusiast",
                date: "February 5, 2024"
            },
            {
                title: "New Breakthrough in Medicine",
                content: "A groundbreaking discovery in the medical field promises to revolutionize the way we approach healthcare. Researchers have found a new treatment method that shows promising results in early trials.",
                author: "MedicalInnovator",
                date: "February 10, 2024"
            },
            {
                title: "Space Exploration Milestone",
                content: "In a historic achievement, astronauts have successfully landed on Mars, marking a significant milestone in human space exploration. The mission aims to uncover the mysteries of the Red Planet and pave the way for future interplanetary travel.",
                author: "SpaceExplorer",
                date: "February 15, 2024"
            },
            {
                title: "Environmental Conservation Initiative",
                content: "A new global initiative is underway to address climate change and promote environmental conservation. World leaders have come together to implement policies aimed at reducing carbon emissions and preserving biodiversity.",
                author: "GreenActivist",
                date: "February 20, 2024"
            },
            {
                title: "Artificial Intelligence Advancements",
                content: "Recent advancements in artificial intelligence have led to the development of highly sophisticated algorithms capable of solving complex problems. Experts predict that AI will play a crucial role in shaping the future of various industries.",
                author: "AIEnthusiast",
                date: "February 25, 2024"
            },
            // Add more post objects as needed
        ];


        // Function to generate HTML for a post
        function generatePostHTML(post) {
            const randomCount = Math.floor(Math.random() * 101);
            return `
        <div class="row justify-content-center">
            <div class="col-6">
                <div class="card">
                    <div class="card-body">
                        <p class="card-text"><strong>Posted by:✏️</strong> ${post.author} | <strong>Published on:</strong> ${post.date}</p>
                        <a href="view_post.html" class="post-link"> <!-- Anchor tag for the entire post -->
                            <h4 class="card-title">${post.title}</h4>
                            <img src="img/test_image.jpeg" class="card-img-top" alt="Test Image">
                            <p class="card-text">${post.content}</p>
                        </a>
                        
                        <div class="d-flex justify-content-end mt-3">
                            <button type="button" class="btn btn-outline-success me-2">+ (${randomCount})</button>
                            <button type="button" class="btn btn-outline-danger">-</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `;
        }


        // Function to append posts to the post container
        function appendPosts() {
            const postContainer = document.getElementById('postContainer');
            posts.forEach(post => {
                const postHTML = generatePostHTML(post);
                postContainer.innerHTML += postHTML;
            });
        }

        // Call the function to append posts when the page loads
        window.addEventListener('load', appendPosts);
    </script>



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
                    <form method="post" action="">
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

</body>

</html>