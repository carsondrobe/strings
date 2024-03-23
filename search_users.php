<?php
require 'config.php';

if (isset($_GET['query'])) {
    $query = $_GET['query'];
    $search_query = "SELECT * FROM Users WHERE username LIKE ?";
    $stmt = $conn->prepare($search_query);
    $stmt->bind_param("s", $query);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        echo '<li class="list-group-item d-flex justify-content-between align-items-center">';
        echo '✏️ ' . $row['username'];
        echo '<button type="button" class="btn btn-danger" onclick="deleteUser(' . $row['userID'] . ')">Delete</button>';
        echo '</li>';
    }
}
