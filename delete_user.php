<?php
require 'config.php';

$userID = $_POST['userID'];
// Delete User
$delete_query = "DELETE FROM User WHERE userID = ?";
$stmt = $conn->prepare($delete_query);
$stmt->bind_param("i", $userID);
$stmt->execute();
