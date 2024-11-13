<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $comment_id = $_POST['comment_id'];
    $user_id = $_POST['user_id'];
    $is_admin = $_POST['is_admin'];

    $query = $is_admin ? "DELETE FROM tbl_forum_comments WHERE comment_id = ?" : "DELETE FROM tbl_forum_comments WHERE comment_id = ? AND user_id = ?";
    $stmt = $con->prepare($query);

    if ($is_admin) {
        $stmt->bind_param("i", $comment_id);
    } else {
        $stmt->bind_param("ii", $comment_id, $user_id);
    }

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Comment deleted successfully"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to delete comment"]);
    }

    $stmt->close();
}
?>
