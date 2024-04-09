<?php
session_start();
require 'config.php';

if (!function_exists('buildQueryStringTopic')) {
    function buildQueryStringTopic($topic)
    {
        $queryParams = array(
            'topic' => $topic,
            'query' => $_GET['query']

        );
        return http_build_query($queryParams);
    }
}

require 'config.php';
?>
<link href="css/navbar.css" rel="stylesheet">

<!-- Navbar -->
<nav class="navbar navbar-expand-lg bg-body-tertiary fixed-top">
    <div class="container-fluid">
        <!-- Logo -->
        <?php
        if (isset($_SESSION['username']) && substr($_SESSION['username'], -6) === ".Admin") {
            $logo = 'strings admin';
        } else {
            $logo = 'strings';
        }
        ?>
        <a class="navbar-brand" href="index.php"><?php echo $logo ?></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Check if user logged in with PHP -->
        <?php
        if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] === true) {
            // Display create a post button
            echo '
            <a class="nav-link active" type="button" aria-disabled="true" data-bs-toggle="modal" data-bs-target="#createPostModal">Create Post ✏️ </a>
           
            ';
        }
        ?>


        <div class="collapse navbar-collapse" id="navbarScroll">
            <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll">

                <li class="nav-item">
                    <a class="nav-link" href="about_us.php">About Us</a>
                </li>
                <!-- Trending Tab -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Categories
                    </a>
                    <!-- Trending Content -->
                    <ul class="dropdown-menu">
                        <?php
                        echo '<li><a class="dropdown-item" href="index.php?' . buildQueryStringTopic('technology') . '">💻 Technology</a></li>';
                        echo '<li><a class="dropdown-item" href="index.php?' . buildQueryStringTopic('food') . '">🍔 Food</a></li>';
                        echo '<li><a class="dropdown-item" href="index.php?' . buildQueryStringTopic('science') . '">🔬 Science</a></li>';
                        echo '<li><a class="dropdown-item" href="index.php?' . buildQueryStringTopic('world') . '">🌍 World News</a></li>';
                        echo '<li><a class="dropdown-item" href="index.php?' . buildQueryStringTopic('business') . '">💼 Business</a></li>';
                        ?>
                    </ul>
                </li>
            </ul>
            <!-- Search Bar -->
            <form class="d-flex" role="search" method="get" action="index.php">
                <input class="form-control me-2" type="search" placeholder="Search Strings... 🔍" aria-label="Search" id="nav-bar-search" name="query">
            </form>
            <!-- Notifications -->
            <?php if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] === true) : ?>
                <?php
                // Query to get notifications
                $userID = $_SESSION['user_id'];
                $query = "SELECT * FROM Notifications WHERE notified_userID = " . $userID . " AND is_read = 0";

                $result = mysqli_query($conn, $query);

                $count = mysqli_num_rows($result);

                ?>
                <div class="dropdown ms-auto">
                    <button type="button" class="btn btn-outline-dark ms-auto" data-bs-toggle="dropdown" aria-expanded="false" style="margin-top: 5px; border-radius: 20px; background-color: #ffffff; color: #343a40;">
                        <span style="margin-right: 5px;">📬</span> Notifications
                        <span class="badge bg-danger" style="margin-left: 5px;"><?php echo $count ?></span>
                    </button>
                    <ul class="dropdown-menu" style="max-height: 200px; overflow-y: auto;">
                        <?php
                        // Display notifications
                        while ($row = mysqli_fetch_assoc($result)) {
                            $commenting_userID = $row['commenting_userID'];
                            $commenting_user_query = "SELECT username FROM User WHERE userID = $commenting_userID";
                            $commenting_user_result = mysqli_query($conn, $commenting_user_query);
                            $commenting_username = mysqli_fetch_assoc($commenting_user_result)['username'];

                            echo '<li>
                                    <div class="card">
                                        <div class="card-body">
                                        <a class="card-text" href="view_post.php?discussionID=' . $row['discussion_id'] . '" onclick="deleteNotification(' . $row['notification_id'] . ')" style="text-decoration: none; color: black;">' . $commenting_username . ' commented on your post. </a>
                                        </div>
                                    </div>
                                </li>';
                        }
                        ?>



                    </ul>
                </div>
            <?php endif; ?>
            <!-- Login Button -->
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <?php
                    if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] === true) {

                        $user_id = $_SESSION['user_id'];

                        $query = "SELECT profile_picture FROM User WHERE userID = ?";
                        $stmt = $conn->prepare($query);
                        $stmt->bind_param("s", $user_id);
                        $stmt->execute();
                        $stmt->store_result();

                        if ($stmt->num_rows > 0) {

                            $stmt->bind_result($profile_picture);
                            $stmt->fetch();

                            if (!is_null($profile_picture)) {
                                echo '<a class="nav-link" href="account.php"><img src="data:image/jpeg;base64,' . base64_encode($profile_picture) . '" alt="Profile Picture" id="nav-profileimg" style="max-height: 30px; max-width: 30px; border-radius: 50%;"></a>';
                            } else {
                                echo '<a class="nav-link" href="account.php"><img src="img/defaultprofile.jpeg" alt="Default Profile Picture" id="nav-profileimg" style="max-height: 30px; max-width: 30px; border-radius: 50%;"></a>';
                            }
                        } else {
                            echo '<a class="nav-link" href="account.php"><img src="img/defaultprofile.jpeg" alt="Default Profile Picture" id="nav-profileimg" style="max-height: 30px; max-width: 30px; border-radius: 50%;"></a>';
                        }

                        $stmt->close();
                        $conn->close();
                    }
                    ?>
                </li>

                <!-- Logout Button -->
                <li class="nav-item">
                    <?php
                    if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] === true) {
                        echo '<a class="nav-link" href="logout.php">Logout</a>';
                    } else {
                        echo '<a class="nav-link" href="login.php">Login</a>';
                    }
                    ?>
                </li>
            </ul>
        </div>
    </div>
</nav>

<script>
    function deleteNotification(notificationID) {
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "delete_notification.php?notificationID=" + notificationID, true);
        xhr.send();
    }
</script>