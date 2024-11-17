<div id="subcontent">
    <?php
      switch($action){
          case 'create':
              require_once 'forum/comment-module/create-comment.php';
              break; 
          case 'read':
              require_once 'forum/comment-module/read-comment.php';
              break;
          case 'update':
              require_once 'forum/comment-module/update-comment.php';
              break; 
          case 'delete':
              require_once 'forum/comment-module/delete-comment.php';
              break;
          case 'profile':
              require_once 'forum/comment-module/display-comment.php';
              break;
          default:
              require_once 'forum/comment-module/read-comment.php';
              break; 
      }
    ?>
</div>
