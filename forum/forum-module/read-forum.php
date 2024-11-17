
<div id="forum-sidebar">



    <?php

    $user_id = $_SESSION['user_id'];    

    if ($user->get_user_access($user_id) == "user") {
        header("index.php?page=forums&subpage=forums");
    } else if ($user->get_user_access($user_id) == "admin") {
        ?>  
        <div class="create-forum-button">
        <a href="index.php?page=forums&subpage=forums&action=create" class="button-link">
            <button class="square-button">
                <i class="fas fa-plus"></i> Create New Forum
            </button>
        </a>
    </div>
    
        <?php
    }
    ?>

    <?php


    $count = 1;
    if ($forum->list_forums() != false) {
        foreach ($forum->list_forums() as $value) {
            extract($value);
    ?>
            <div class="forum-navigation-item">
                <a href="index.php?page=forums&subpage=forums&action=profile&id=<?php echo $forum_id; ?>" class="forum-link">
                    <?php echo htmlspecialchars($forum_title); ?>
                </a>
            </div>

    <?php
        }
    } else {
        echo '<div class="no-forums"><p>No forums found.</p></div>';
    }
    ?>
</div>
