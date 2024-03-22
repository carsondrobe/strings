<?php
session_start();

function buildQueryStringTopic($topic)
{
    $queryParams = array(
        'query' => $_GET['query'],
        'topic' => $topic
    );
    return http_build_query($queryParams);
}

?>
<link href="css/navbar.css" rel="stylesheet">

<!-- Navbar -->
<nav class="navbar navbar-expand-lg bg-body-tertiary fixed-top">
    <div class="container-fluid">
        <!-- Logo -->
        <a class="navbar-brand" href="index.php">strings</a>
        <!-- Check if user logged in with PHP -->
        <?php
        if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] === true) {
            // Display create a post button
            echo '
            <a class="nav-link active" type="button" aria-disabled="true" data-bs-toggle="modal" data-bs-target="#createPostModal">Create Post ✏️ </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            ';
        }
        ?>
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
                        <?php
                        echo '<li><a class="dropdown-item" href="?' . buildQueryStringTopic('world') . '">🌍 World News</a></li>';
                        echo '<li><a class="dropdown-item" href="?' . buildQueryStringTopic('sports') . '">⚽ Sports</a></li>';
                        echo '<li><a class="dropdown-item" href="?' . buildQueryStringTopic('science') . '">💊 Science</a></li>';
                        echo '<li><a class="dropdown-item" href="?' . buildQueryStringTopic('business') . '">💼 Business</a></li>';
                        ?>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="#">🔥 Trending For You</a></li>
                    </ul>
                </li>
            </ul>
            <!-- Search Bar -->
            <form class="d-flex" role="search" method="get" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <input class="form-control me-2" type="search" placeholder="Search Strings... 🔍" aria-label="Search" id="nav-bar-search" name="query">
            </form>
            <!-- Notifications -->
            <?php if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] === true) : ?>
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
                        <!-- Add more sample messages here -->
                    </ul>
                </div>
            <?php endif; ?>
            <!-- Login Button -->
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <?php
                    if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] === true) {
                        echo '<ul class="navbar-nav ms-auto">
                                <li class="nav-item">
                                    <a class="nav-link" href="account.php"><img src="img/goatprofile.jpeg" alt="" id="nav-profileimg" style="max-height: 30px; max-width: 30px; border-radius: 50%;"></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="logout.php" style="margin-left: 10px;">Logout</a>
                                </li>
                            </ul>';
                    } else {
                        echo '<a class="nav-link" href="login.php">Login</a>';
                    }
                    ?>
                </li>
            </ul>
        </div>
    </div>
</nav>