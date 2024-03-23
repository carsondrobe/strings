<?php
require 'config.php';
//debug stuff
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

if (isset($_GET['query'])) {
    $query = $_GET['query'];

    $search_query = "SELECT * FROM User WHERE username LIKE ?";
    $stmt = $conn->prepare($search_query);
    $search = "%" . $query . "%";
    $stmt->bind_param("s", $search);

    $stmt->execute();
    $result = $stmt->get_result();


    if ($result->num_rows > 0) {
        $response = '';

        while ($row = $result->fetch_assoc()) {
            $response .= '<li class="list-group-item d-flex justify-content-between align-items-center" style="margin: 1em;">';
            $response .= '✏️ ' . $row['username'];
            $response .= '<button type="button" class="btn btn-danger" onclick="deleteUser(' . $row['userID'] . ', this.parentNode)">Delete</button>';
            $response .= '</li>';
        }
    } else {
        $response = '<h2>No users match that search result</h2>';
    }

    echo $response;
}
