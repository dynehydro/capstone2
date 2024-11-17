<div id="subcontent">
    <?php
      switch($action){
          case 'create':
              require_once 'forum/forum-module/create-forum.php';
          break; 
          case 'read':
            require_once 'forum/forum-module/read-forum.php';
            break;
          case 'update':
            require_once 'forum/forum-module/update-forum.php';
            break; 
          case 'delete':
            require_once 'forum/forum-module/delete-forum.php';
            break;
          case 'profile':
            require_once 'forum/forum-module/display-forum.php';
            break;
          default:
            require_once 'forum/forum-module/read-forum.php';
          break; 
      }
    ?>
</div>
