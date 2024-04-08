<?php

session_start();

include 'config.php';

// Check if the user is logged in, if not then redirect to login page
if (!isset($_SESSION['username']) || substr($_SESSION['username'], -6) !== ".Admin") {
    header("Location: index.php");
    exit;
}

$sql = "SELECT category, SUM(upvotes) as upvotes 
        FROM Discussions 
        GROUP BY category
        ORDER BY SUM(upvotes) DESC";

$result = $conn->query($sql);

$data = array();
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($data);
$conn->close();
