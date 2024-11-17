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


<?php include_once "forum/forum-module/read-forum.php";?>

<div id="forum-main-content">

    <div class="">
        <a href="index.php?page=comments&subpage=comments&action=create&post_id=<?php echo $_GET['id'];?>" id="button">
            <button class="button">
                <i class="fas fa-comment"></i>
            </button>
        </a>
    </div>

    <div id="forum-details">

        <div id="breadcrumb">
            <a href="javascript:history.back()" id="links">Back</a>
        </div>

        <div class="forum-info">
                <h3><?php echo htmlspecialchars($post_details['post_title']); ?></h3>
        </div>

        <div id="post-item">
            <div>
                <p><strong>Posted by <?php echo htmlspecialchars($fuser);?> <?php echo htmlspecialchars($luser);?>
                (<?php echo htmlspecialchars($user_id); echo htmlspecialchars($post_details['post_created_at']);?>)
            </strong></p>
                <p><?php echo htmlspecialchars($post_details['post_content']); ?></p>

            <?php if (!empty($post_details['post_image'])) : ?>
                <div class="post-image">
                    <img src="uploads/<?php echo htmlspecialchars($post_details['post_image']); ?>" alt="Post Image" style="max-width: 100%; height: auto;">
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php include_once "forum/comment-module/read-comment.php";?>


</div>
