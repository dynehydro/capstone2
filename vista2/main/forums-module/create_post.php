<?php
// Include the forum class file
require_once 'classes/class.forum.php';

// Start session and check if the user is logged in
session_start();
if (!isset($_SESSION['user_id'])) {
    // If not logged in, redirect to login page
    header("Location: login.php");
    exit();
}

// Create a new Forum object
$forum = new Forum();

// Process the post creation if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Process the post data
    $user_id = $_SESSION['user_id']; // Get the logged-in user's ID
    $title = $_POST['post_title'];
    $content = $_POST['post_content'];
    $post_image = $_FILES['post_image']['name'] ?? null; // Optional field for image upload

    // If there's an image, handle the upload
    if ($post_image) {
        $target_dir = "uploads/"; // Make sure this folder exists and is writable
        $target_file = $target_dir . basename($_FILES["post_image"]["name"]);
        
        // Move the uploaded file to the target directory
        if (move_uploaded_file($_FILES["post_image"]["tmp_name"], $target_file)) {
            // File upload was successful
        } else {
            // Handle file upload error (optional)
            echo "<p>Error uploading image.</p>";
        }
    }

    // Insert post data into the database
    $query = "INSERT INTO tbl_forum_posts (user_id, post_title, post_content, post_image) VALUES (?, ?, ?, ?)";
    $stmt = $con->prepare($query);
    $stmt->bind_param("isss", $user_id, $title, $content, $post_image);

    if ($stmt->execute()) {
        // Redirect to the forum posts page after successful creation
        header("Location: index.php?page=forums"); // Modify to match your forum's post list page URL
        exit();
    } else {
        echo "<p>Failed to create post. Please try again.</p>";
    }

    $stmt->close();
}
?>

<!-- Form and Layout Structure Like create_gallery.php -->

<div id="third-submenu"> 
    <a href="index.php?page=forum&subpage=create_post" class="btn-cancel">Cancel</a>
</div>

<div id="form-block">
    <h3>Create a New Post</h3>

    <form method="POST" action="" enctype="multipart/form-data">
        <div class="form-row">
            <label for="post_image">Upload Image (Optional)</label>
            <input class="input" type="file" name="post_image">
        </div>

        <div id="form-block-half">
            <label for="post_title">Post Title</label>
            <input type="text" id="post_title" class="input" name="post_title" placeholder="Enter Title" required>

            <label for="post_content">Content</label>
            <textarea id="post_content" class="input" name="post_content" placeholder="Enter Post Content" required></textarea>
        </div>

        <div id="button-block">
            <input type="submit" value="Create Post" class="btn-save">
        </div>
    </form>
</div>
