<?php
session_start();
include 'config.php';

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['user_id'])) {
    $discussionID = $_POST['discussionID'];
    $ratingType = $_POST['ratingType'];
    $userID = $_SESSION['user_id'];
    // Start a transaction
    $conn->begin_transaction();
    try {
        // Check if user has already voted on this post
        $stmt = $conn->prepare("SELECT voteType FROM UserVotes WHERE userID = ? AND discussionID = ?");
        $stmt->bind_param("ii", $userID, $discussionID);
        $stmt->execute();
        $result = $stmt->get_result();
        $shouldUpdateDiscussion = false;

        // If user has already voted
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            // If vote is different, update the UserVotes table
            if ($row['voteType'] !== $ratingType) {
                $stmt = $conn->prepare("UPDATE UserVotes SET voteType = ? WHERE userID = ? AND discussionID = ?");
                $stmt->bind_param("sii", $ratingType, $userID, $discussionID);
                $stmt->execute();
                $shouldUpdateDiscussion = true;
            }
        // If user hasn't voted yet
        } else {
            // Insert new vote into UserVotes table
            $stmt = $conn->prepare("INSERT INTO UserVotes (userID, discussionID, voteType) VALUES (?, ?, ?)");
            $stmt->bind_param("iis", $userID, $discussionID, $ratingType);
            $stmt->execute();
            $shouldUpdateDiscussion = true;
        }

        // Update the Discussions table if necessary
        if ($shouldUpdateDiscussion) {
            if ($ratingType === "upvote") {
                $stmt = $conn->prepare("UPDATE Discussions SET upvotes = upvotes + 1 WHERE discussionID = ?");
            } else { // downvote
                $stmt = $conn->prepare("UPDATE Discussions SET downvotes = downvotes + 1 WHERE discussionID = ?");
            }
            $stmt->bind_param("i", $discussionID);
            $stmt->execute();
        }
        // Commit the transaction
        $conn->commit(); 
        header("Location: view_post.php?discussionID=".$discussionID);
        exit();
    } catch (Exception $e) {
        $conn->rollback(); // Rollback the transaction on error
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Invalid request or not logged in.";
}
?>
