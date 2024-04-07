<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Strings</title>
    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- BOOTSTRAP -->
    <link href="css/home_style.css" rel="stylesheet">
    <link href="css/navbar.css" rel="stylesheet">
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg bg-body-tertiary fixed-top">
        <div class="container-fluid">
            <!-- Logo -->
            <a class="navbar-brand" href="index.php">strings</a>
            <!-- Create a Post Button -->
            <a class="nav-link active" type="button" aria-disabled="true" data-bs-toggle="modal"
                data-bs-target="#createPostModal">Create Post ✏️ </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll"
                aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarScroll">
                <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">

                    <li class="nav-item">
                        <a class="nav-link" href="about_us.php">About Us</a>
                    </li>
                    <!-- Trending Tab -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
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
                <form class="d-flex" role="search">
                    <input class="form-control me-2" type="search" placeholder="Search Strings... 🔍"
                        aria-label="Search" id="nav-bar-search">
                </form>


                <!-- Notifications -->
                <div class="dropdown ms-auto">
                    <button type="button" class="btn btn-outline-dark ms-auto" data-bs-toggle="dropdown"
                        aria-expanded="false"
                        style="margin-top: 5px; border-radius: 20px; background-color: #ffffff; color: #343a40;">
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
                        <a class="nav-link" href="login.php">Login</a>
                    </li>
                </ul>

            </div>
        </div>
    </nav>

    <!-- About Us Section -->
    <section class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h2 class="mb-4">About Us</h2>
                <p>
                    Welcome to Strings, your go-to platform for staying informed about the latest news and trends
                    in various fields.
                </p>
                <p>
                    At Strings, we believe in providing a space for users to share and discover valuable information.
                    Whether it's world news, sports, health, or business, our platform is designed to cater to your
                    diverse interests.
                </p>
                <p>
                    Join our community, create posts, engage in discussions, and stay updated on what's trending
                    globally and tailored just for you.
                </p>
            </div>
        </div>
    </section>

    <!-- Bootstrap Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>

    <!-- Back to top button -->
    <button type="button" class="btn btn-outline-black" id="btn-back-to-top">
        Back to Top
    </button>

    <!-- Back to Top Logic -->
    <script>
        //Get the button
        let mybutton = document.getElementById("btn-back-to-top");

        // When the user scrolls down 20px from the top of the document, show the button
        window.onscroll = function () {
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

</body>

</html>