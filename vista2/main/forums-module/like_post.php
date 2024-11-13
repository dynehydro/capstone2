<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $post_id = $_POST['post_id'];
    $user_id = $_POST['user_id'];
    $action = $_POST['action']; // 'like' or 'dislike'

    if ($action === 'like') {
        $query = "INSERT INTO tbl_likes (post_id, user_id) VALUES (?, ?)";
    } else {
        $query = "DELETE FROM tbl_likes WHERE post_id = ? AND user_id = ?";
    }

    $stmt = $con->prepare($query);
    $stmt->bind_param("ii", $post_id, $user_id);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => ucfirst($action) . " successful"]);
    } else {
        echo json_encode(["status" => "error", "message" => ucfirst($action) . " failed"]);
    }

    $stmt->close();
}
?>
