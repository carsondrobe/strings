<?php

require 'config.php';

// If sent from Notification, delete the notification from database
if (isset($_GET['notificationID'])) {
    $notificationID = $_GET['notificationID'];
    $delete_query = "DELETE FROM Notifications WHERE notification_id = ?";
    $stmt = $conn->prepare($delete_query);
    $stmt->bind_param("i", $notificationID);
    $stmt->execute();
    // header("Location: view_post.php?discussionID=" . $_GET['discussionID']);
}
