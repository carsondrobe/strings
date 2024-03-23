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
                // Update user votes table
                $stmt = $conn->prepare("UPDATE UserVotes SET voteType = ? WHERE userID = ? AND discussionID = ?");
                $stmt->bind_param("sii", $ratingType, $userID, $discussionID);
                $stmt->execute();
                // Decrement previous vote count
                $decrementType = ($row['voteType'] === 'upvote') ? 'upvotes' : 'downvotes';
                $stmt = $conn->prepare("UPDATE Discussions SET $decrementType = $decrementType - 1 WHERE discussionID = ?");
                $stmt->bind_param("i", $discussionID);
                $stmt->execute();
                // Increment new vote count
                $incrementType = ($ratingType === 'upvote') ? 'upvotes' : 'downvotes';
                $stmt = $conn->prepare("UPDATE Discussions SET $incrementType = $incrementType + 1 WHERE discussionID = ?");
                $stmt->bind_param("i", $discussionID);
                $stmt->execute(); 
            }
        // If user hasn't voted yet
        } else {
            // Insert new vote into UserVotes table
            $stmt = $conn->prepare("INSERT INTO UserVotes (userID, discussionID, voteType) VALUES (?, ?, ?)");
            $stmt->bind_param("iis", $userID, $discussionID, $ratingType);
            $stmt->execute();
            // Update discussions table
            $stmt2 = $conn->prepare("UPDATE Discussions SET $ratingType = $ratingType + 1 WHERE discussionID = ?");
            $stmt2->bind_param("i", $discussionID);
            $stmt2->execute(); 
        }
        // Commit the transaction
        $conn->commit(); 
        header("Location: view_post.php?discussionID=".$discussionID);
        exit();
    } catch (Exception $e) {
        $conn->rollback();
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Invalid request.";
}
?>
