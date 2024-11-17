<?php
$user_id = $_SESSION['user_id'];
?>


<div id="subcontent">
    <?php
      switch($action){
                case 'create':
                    require_once 'bids-module/create-bid.php';
                break; 
                case 'read':
                    require_once 'bids-module/read-bid.php';
                break;
                case 'update':
                    require_once 'bids-module/update-bid.php';
                break; 
                case 'delete':
                    require_once 'bids-module/delete-bid.php';
                break;
                case 'profile':
                    require_once 'bids-module/update-bid.php';
                break;
                default:
                    require_once 'bids-module/read-bid.php';
                break; 
            }
    ?>
    
</div>