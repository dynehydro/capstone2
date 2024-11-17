
<div id="gallery-container">
<div id="gallery-details">
    <div id="breadcrumb">
                <a href="index.php?page=forums&subpage=forums" id="links">Cancel</a>
                <span> / </span>
                <span>New Forum</span>
    </div>
</div>
</div>
<div id="form-block">
    <h3>Add Forum</h3>

    <form method="POST" action="processes/process.forum.php?action=create">
        <div>
            <label for="forum_title">Forum Title</label>
            <input type="text" id="forum_title" class="input" name="forum_title" placeholder="Enter Forum Title" required>

        <label for="forum_description">Forum Description</label>
        <textarea id="forum_description" class="input" name="forum_description" placeholder="Enter a brief description of the forum" required></textarea>
        </div>

        <div id="button-block">
            <input type="submit" value="Add">
        </div>
    </form>
</div>
