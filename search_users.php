<?php
require 'config.php';
//debug stuff
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (isset($_GET['query'])) {
    $query = $_GET['query'];
    var_dump($query);
    $search_query = "SELECT * FROM User WHERE username LIKE ?";
    $stmt = $conn->prepare($search_query);
    $search = "'%" . $query . "%'";
    $stmt->bind_param("s", $search);
    $stmt->execute();
    $result = $stmt->get_result();
    var_dump($result);

    $response = '';

    while ($row = $result->fetch_assoc()) {
        $response .= '<li class="list-group-item d-flex justify-content-between align-items-center">';
        $response .= '✏️ ' . $row['username'];
        $response .= '<button type="button" class="btn btn-danger" onclick="deleteUser(' . $row['userID'] . ')">Delete</button>';
        $response .= '</li>';
    }
    var_dump($response);
    echo $response;
}
