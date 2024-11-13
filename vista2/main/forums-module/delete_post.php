<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $post_id = $_POST['post_id'];
    $user_id = $_POST['user_id'];
    $is_admin = $_POST['is_admin'];

    // Allow deletion if user is admin or owns the post
    $query = $is_admin ? "DELETE FROM tbl_forum_posts WHERE post_id = ?" : "DELETE FROM tbl_forum_posts WHERE post_id = ? AND user_id = ?";
    $stmt = $con->prepare($query);

    if ($is_admin) {
        $stmt->bind_param("i", $post_id);
    } else {
        $stmt->bind_param("ii", $post_id, $user_id);
    }

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Post deleted successfully"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to delete post"]);
    }

    $stmt->close();
}
?>
