<?php
// Include database connection and any necessary classes
require_once '../config.php';  // Adjust the path to your config file
require_once 'class.forum.php'; // Adjust the path to your Forum class file

// Check if a search query is passed
if (isset($_GET['q'])) {
    $searchQuery = mysqli_real_escape_string($con, $_GET['q']);  // Escape to prevent SQL injection

    // Create the Forum class object
    $forum = new Forum();

    // Get the search results
    $searchResults = $forum->search_posts($searchQuery);

    // Display results as HTML
    if ($searchResults) {
        foreach ($searchResults as $result) {
            extract($result);
            ?>
            <div class="search-result-item">
                <a href="index.php?page=forum&subpage=posts&action=profile&id=<?php echo $post_id; ?>">
                    <h3><?php echo htmlspecialchars($post_title); ?></h3>
                    <p><?php echo htmlspecialchars($post_content); ?></p>
                </a>
            </div>
            <?php
        }
    } else {
        echo '<div class="no-results"><p>No posts found for your search query.</p></div>';
    }
}
?>
