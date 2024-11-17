<?php

    $user_id = $_SESSION['user_id'];    
?>

<div id="gallery-container">
    <div id="gallery-details">
        <div id="breadcrumb">
            <a href="index.php?page=forums&subpage=forums" id="links">Cancel</a>
            <span> / </span>
            <span>New Post</span>
        </div>
    </div>
</div>

<div id="form-block">
    <h3>Add Forum Post</h3>

    <form method="POST" action="processes/process.post.php?action=create" enctype="multipart/form-data">
        <div>
            <label for="post_title">Post Title</label>
            <input type="text" id="post_title" class="input" name="post_title" placeholder="Enter Post Title" required>

            <label for="post_content">Post Content</label>
            <textarea id="post_content" class="input" name="post_content" placeholder="Enter the content of your post" required></textarea>
            
            <!-- Optional: File upload for post image -->
            <label for="post_image">Post Image (Optional)</label>
            <input type="file" id="post_image" name="post_image">
        </div>

        <div>
            <!-- Hidden field to pass forum_id from the URL -->
            <input type="hidden" name="forum_id" value="<?php echo isset($_GET['forum_id']) ? intval($_GET['forum_id']) : 0; ?>">

            <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user_id);?>">

        </div>

        <div id="button-block">
            <input type="submit" value="Add Post">
        </div>
    </form>
</div>
