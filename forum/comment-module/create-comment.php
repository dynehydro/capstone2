<?php
    $user_id = $_SESSION['user_id'];    
?>

<div id="gallery-container">
    <div id="gallery-details">
        <div id="breadcrumb">
            <a href="index.php?page=forums&subpage=forums" id="links">Cancel</a>
            <span> / </span>
            <span>New Comment</span>
        </div>
    </div>
</div>

<div id="form-block">
    <h3>Add Forum Comment</h3>

    <form method="POST" action="processes/process.comment.php?action=create">
        <div>
            <label for="comment_content">Comment Content</label>
            <textarea id="comment_content" class="input" name="comment_content" placeholder="Enter your comment" required></textarea>
        </div>

        <div>
            <!-- Hidden field to pass post_id from the URL -->
            <input type="hidden" name="post_id" value="<?php echo isset($_GET['post_id']) ? intval($_GET['post_id']) : 0; ?>">

            <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user_id);?>">
        </div>

        <div id="button-block">
            <input type="submit" value="Add Comment">
        </div>
    </form>
</div>
