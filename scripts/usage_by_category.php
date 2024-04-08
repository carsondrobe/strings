<?php
session_start();
include 'config.php';

// Check if the user is logged in, if not then redirect to login page
if (!isset($_SESSION['username']) || substr($_SESSION['username'], -6) !== ".Admin") {
    header("Location: index.php");
    exit;
}

// Create sql statement depending on which filter range was clicked
$timeRange = isset($_GET['timeRange']) ? $_GET['timeRange'] : 'allTime';
$sql = "SELECT category, COUNT(*) as post_count FROM Discussions ";
switch ($timeRange) {
    case 'today':
        $sqlCondition = "WHERE DATE(time_posted) = CURDATE() ";
        break;
    case 'thisWeek':
        $sqlCondition = "WHERE YEARWEEK(time_posted, 1) = YEARWEEK(CURDATE(), 1) ";
        break;
    case 'thisMonth':
        $sqlCondition = "WHERE MONTH(time_posted) = MONTH(CURDATE()) AND YEAR(time_posted) = YEAR(CURDATE()) ";
        break;
    case 'thisYear':
        $sqlCondition = "WHERE YEAR(time_posted) = YEAR(CURDATE()) ";
        break;
    default:
        $sqlCondition = "";
        break;
}
$sql .= $sqlCondition . "GROUP BY category";

// Return json data from query
$result = $conn->query($sql);

$data = array();
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($data);
$conn->close();
