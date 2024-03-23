<?php
require 'config.php';

$userID = $POST['userID'];
// Delete User
$delete_query = "DELETE FROM User WHERE userID = ?";
$stmt = $conn->prepare($delete_query);
$stmt->bind_param("i", $userID);
$stmt->execute();
