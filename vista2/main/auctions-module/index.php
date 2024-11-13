<div id="subcontent">
    <?php
      switch($action){
                case 'create':
                    require_once 'auctions-module/create-auction.php';
                break; 
                case 'read':
                    require_once 'auctions-module/read-auction.php';
                break;
                case 'update':
                    require_once 'auctions-module/update-auction.php';
                break; 
                case 'delete':
                    require_once 'auctions-module/delete-auction.php';
                break;
                case 'profile':
                    require_once 'auctions-module/update-auction.php';
                break;
                default:
                    require_once 'auctions-module/read-auction.php';
                break; 
            }
    ?>
    
</div>