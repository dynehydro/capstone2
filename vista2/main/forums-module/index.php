<div id="subcontent">
    <?php
      switch($action){
          case 'create':
              require_once 'forums-module/create_post.php';
          break; 
          case 'read':
              require_once 'forums-module/read_posts.php';
          break;
          case 'update':
              require_once 'forums-module/update-post.php';
          break; 
          case 'delete':
              require_once 'forums-module/delete_post.php';
          break;
          case 'profile':
              require_once 'forums-module/display_post.php';
          break;
          case 'like':
              require_once 'forums-module/like_post.php';
          break;
          case 'dislike':
              require_once 'forums-module/dislike_post.php';
          break;
          case 'add_comment':
              require_once 'forums-module/add_comment.php';
          break;
          case 'delete_comment':
              require_once 'forums-module/delete_comment.php';
          break;
          default:
              require_once 'forums-module/read_posts.php';
          break; 
      }
    ?>
</div>
