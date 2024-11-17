<?php
// Start the session


// Check if the user is logged in and has an 'admin' role
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true || $_SESSION['user_access'] !== 'admin') {
    // If not logged in or not an admin, redirect to the login page
    header("Location: login.php");
    exit();
}

/* Include the class files (global - within application) */
include_once 'classes/class.art.php';
include_once 'classes/class.gallery.php';
include_once 'classes/class.user.php';

include 'config/config.php';

$page = (isset($_GET['page']) && $_GET['page'] != '') ? $_GET['page'] : '';
$subpage = (isset($_GET['subpage']) && $_GET['subpage'] != '') ? $_GET['subpage'] : '';
$action = (isset($_GET['action']) && $_GET['action'] != '') ? $_GET['action'] : '';
$id = (isset($_GET['id']) && $_GET['id'] != '') ? $_GET['id'] : '';
$product_id = (isset($_GET['product_id']) && $_GET['product_id'] != '') ? $_GET['product_id'] : '';

$artPiece = new ArtPiece();
$gallery = new Gallery();
?>

<!DOCTYPE html>
<html>
<head>
    <div>
        <title>VISTA</title>
        <link rel="stylesheet" href="css/custom.css?<?php echo time();?>">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1"/>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    </head>
<body>        

    <?php include_once "header.php";?>

    <div id="wrapper">
        <div>

            <?php if (isset($_GET['error'])): ?>
                <p><?php echo $_GET['error']; ?></p>
            <?php endif ?>

            <?php
            // Handle page routing based on the query parameter 'page'
            switch($page){
                
                case 'gallery':
                    require_once 'gallery-module/index.php';
                    break; 

                case 'art':
                    require_once 'art-module/index.php';
                    break; 

                case 'auctions':
                    require_once 'logout.php';
                    break;

                case 'forums':
                    require_once 'logout.php';
                    break;

                case 'logout':
                    require_once 'logout.php';
                    break;

                default:
                    require_once 'main.php';
                    break; 
            }
            ?>
        </div>
    </div>
</div>
</body>
</html> 
