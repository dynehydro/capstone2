<?php
$user_id = $_SESSION['user_id'];
?>

<div id="subcontent">
    <?php
      switch($action){
                case 'create':
                    require_once 'art-module/create-art.php';
                break; 
                case 'read':
                    require_once 'art-module/read-art.php';
                break;
                case 'update':
                    require_once 'art-module/update-art.php';
                break; 
                case 'delete':
                    require_once 'art-module/delete-art.php';
                break;

                case 'profile':{
                if ($user->get_user_access($user_id) == "user") {
                    
                        require_once 'art-module/display-art.php';
                    break;
    
                } else if ($user->get_user_access($user_id) == "admin") {

                        require_once 'art-module/update-art.php';
                    break;                
                }}


                default:
                    require_once 'art-module/read-art.php';
                break; 
            }
    ?>
    
</div>