<div id="subcontent">
    <?php
      switch($action){
          case 'create':
              require_once 'gallery-module/create-gallery.php';
          break; 
          case 'read':
              require_once 'gallery-module/read-gallery.php';
          break;
          case 'update':
              require_once 'gallery-module/update-gallery.php';
          break; 
          case 'delete':
              require_once 'gallery-module/delete-gallery.php';
          break;
          case 'profile':
              require_once 'gallery-module/display-gallery.php';
          break;
          default:
              require_once 'gallery-module/read-gallery.php';
          break; 
      }
    ?>
</div>
