<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $post_id = $_POST['post_id'];
    $user_id = $_POST['user_id'];
    $content = $_POST['comment_content'];

    $query = "INSERT INTO tbl_forum_comments (post_id, user_id, comment_content) VALUES (?, ?, ?)";
    $stmt = $con->prepare($query);
    $stmt->bind_param("iis", $post_id, $user_id, $content);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Comment added successfully"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to add comment"]);
    }

    $stmt->close();
}
?>
