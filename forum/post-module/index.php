<div id="subcontent">
    <?php
      switch($action){
          case 'create':
              require_once 'forum/post-module/create-post.php';
          break; 
          case 'read':
            require_once 'forum/post-module/read-post.php';
            break;
          case 'update':
            require_once 'forum/post-module/update-post.php';
            break; 
          case 'delete':
            require_once 'forum/post-module/delete-post.php';
            break;
          case 'profile':
            require_once 'forum/post-module/display-post.php';
            break;
          default:
            require_once 'forum/post-module/read-post.php';
          break; 
      }
    ?>
</div>
