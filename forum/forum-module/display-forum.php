<?php include_once "forum/forum-module/read-forum.php";?>

<div id="forum-main-content">

    <div class="">
        <a href="index.php?page=posts&subpage=posts&action=create&forum_id=<?php echo $_GET['id'];?>" id="button">
            <button class="button">
                <i class="fas fa-comment"></i>
            </button>
        </a>
    </div>

    <div class="forum-details">
        <?php
        $forum_details = $forum->get_forum_details($id);
        
        if ($forum_details) {
            extract($forum_details);
            ?>
            <div class="forum-info">
                <h3><?php echo htmlspecialchars($forum_title); ?></h3>
                <p><strong>Description:</strong> <?php echo htmlspecialchars($forum_description); ?></p>
                <p><strong>Forum ID:</strong> <?php echo htmlspecialchars($id); ?></p>
            </div>
            <?php
        } else {
            echo "<p>Forum details not found.</p>";
        }
        ?>
    </div>

    <?php include_once "forum/post-module/read-post.php";?>

</div>
