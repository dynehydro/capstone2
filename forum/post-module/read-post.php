<div id="posts">
    <?php
    $forum_posts = $post->list_forum_posts($id);

    if ($forum_posts !== false) {
        foreach ($forum_posts as $value) {
            extract($value); // Extract variables like post_title, post_content, post_image, etc.
            ?>
            <a href="index.php?page=posts&subpage=posts&action=profile&id=<?php echo $post_id; ?>&forum_id=<?php echo $forum_id; ?>">
                <div id="post-item">
                    <div class="post-title">
                        <h2><?php echo htmlspecialchars($post_title); ?></h2>
                    </div>
                    <div class="forum-post-content">
                        <p><?php echo htmlspecialchars(substr($post_content, 0, 150)) . '...'; // Display a snippet of the content ?></p>
                    </div>
                    <?php if (!empty($post_image)) { ?>
                    <div class="post-image">
                        <img src="processes/uploads/<?php echo htmlspecialchars($post_image); ?>" alt="<?php echo htmlspecialchars($post_title); ?>">
                    </div>
                    <?php } ?>
                </div>
            </a>
            <?php
        }
    } else {
        echo "<p>No posts found for this forum.</p>";
    }
    ?>
</div>
