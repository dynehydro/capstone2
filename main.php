<div id="wrap">    
    <div id="name">
        <p>Logged in as:</p>
        <?php
        // Check if the user is logged in
        if (isset($_SESSION['user_email'])) {
            // Get user ID and access level from the session
            $user_id = $_SESSION['user_id'];
            $user_access = $_SESSION['user_access'];  // This could be used to display different content for admins and users
            ?>
            <a id="white" href="index.php?page=users&subpage=users&action=profile&id=<?php echo $user_id; ?>">
                View Profile
            </a>
            <?php
            // Optionally, display a different message based on access level
            if ($user_access == 'admin') {
                echo "<p>You have admin access.</p>";
            } else {
                echo "<p>Regular user.</p>";
            }
        } else {
            echo "<p>Please log in</p>";
        }
        ?>
    </div>
</div>
