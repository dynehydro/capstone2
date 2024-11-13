<?php
// Include the forum class file
require_once 'classes/class.forum.php';

// Start session and check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // If not logged in, redirect to login page
    header("Location: login.php");
    exit();
}

// Create a new Forum object
$forum = new Forum();
?>

<script>
function showResults(str) {
  if (str.length == 0) {
    document.getElementById("search-result").innerHTML = "";
    document.getElementById("search-result").style.border = "0px";
    return;
  }

  var xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function() {
    if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
      document.getElementById("search-result").innerHTML = xmlhttp.responseText;
    }
  };

  xmlhttp.open("GET", "forum-module/search.php?q=" + str, true);
  xmlhttp.send();
}
</script>

<!-- Search Form -->
<form>
    <div id="search-box">
        <input type="text" id="search" name="search" onkeyup="showResults(this.value)" 
        placeholder="Search Forum Posts..."> 
        <a href="index.php?page=forum&subpage=posts" id="clear-button">Clear</a> 
    </div>
</form>

<!-- Search Results Area -->
<div id="search-result"></div>

<?php
// Check user access level and show the button for creating a post
$user_id = $_SESSION['user_id'];

if ($user->get_user_access($user_id) == "user" || $user->get_user_access($user_id) == "admin") {
    // Display the button to create a new post for both users and admins
    echo '<a href="index.php?page=forum&subpage=create_post">
            <button class="button">
                <i class="fas fa-plus"></i> Create Post
            </button>
          </a>';
}
?>

<!-- Forum Content -->
<div id="forumcontent">
    <?php
    $count = 1;
    // Ensure $forum is instantiated and has data to list
    if ($forum->list_posts() != false) {
        foreach ($forum->list_posts() as $value) {
            extract($value);
            ?>
                <div class="forum-item">
                    <a href="index.php?page=forum&subpage=posts&action=profile&id=<?php echo $post_id; ?>">
                        <div class="forum-details">
                            <h2><?php echo htmlspecialchars($post_title); ?></h2>
                            <p><?php echo htmlspecialchars($post_content); ?></p>
                        </div>
                    </a>
                </div>
            <?php
        }
    } else {
        echo '<div class="no-posts"><p>No forum posts found.</p></div>';
    }
    ?>
</div>
