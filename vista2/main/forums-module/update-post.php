<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $post_id = $_POST['post_id'];
    $user_id = $_POST['user_id'];
    $title = $_POST['post_title'];
    $content = $_POST['post_content'];
    $post_image = $_POST['post_image'] ?? null;

    $query = "UPDATE tbl_forum_posts SET post_title = ?, post_content = ?, post_image = ? WHERE post_id = ? AND user_id = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("sssii", $title, $content, $post_image, $post_id, $user_id);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Post updated successfully"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to update post"]);
    }

    $stmt->close();
}
?>
