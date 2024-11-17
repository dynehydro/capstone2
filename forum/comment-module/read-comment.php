<?php
$post_id = isset($_GET['id']) ? htmlspecialchars($_GET['id']) : '';

if (!$post_id) {
    die("Invalid post ID.");
}

$post_details = $post->get_post_details($post_id);

if (empty($post_details)) {
    header("Location: index.php?page=forum");
    exit;
}

$user_id = $post->get_post_user($post_id);

if (!$user_id) {
    die("User not found for this post.");
}

$fuser = $user->get_user_firstname($user_id);
$luser = $user->get_user_lastname($user_id);
?>

<div id="forum-details">
    <?php
    $forum_comments = $comment->list_comments_by_post($id);

    if ($forum_comments !== false) {
        foreach ($forum_comments as $value) {
            extract($value); // Extract variables like comment_content, comment_created_at, etc.
            ?>
                <div id="post-item">
                    <div>
                        <small><?php echo htmlspecialchars($fuser);?> (<?php echo htmlspecialchars($comment_created_at); ?>)</small>


                        <p><?php echo htmlspecialchars(substr($comment_content, 0, 150)) . '...'; // Display a snippet of the content ?></p>
                    </div>
                    <div>
                    </div>
                </div>
            <?php
        }
    } else {
        echo "<p>No comments found for this post.</p>";
    }
    ?>
</div>
