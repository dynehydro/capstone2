<?php
// Start the session
session_start();

// Check if the user is logged in; if not, redirect to login page
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: login.php");
    exit();
}


/* Include the class files (global - within application) */
include_once 'classes/class.art.php';
include_once 'classes/class.gallery.php';
include_once 'classes/class.user.php';
include_once 'classes/class.auction.php';
include_once 'classes/class.forum.php';


include 'config/config.php';

$page = (isset($_GET['page']) && $_GET['page'] != '') ? $_GET['page'] : '';
$subpage = (isset($_GET['subpage']) && $_GET['subpage'] != '') ? $_GET['subpage'] : '';
$action = (isset($_GET['action']) && $_GET['action'] != '') ? $_GET['action'] : '';
$id = (isset($_GET['id']) && $_GET['id'] != '') ? $_GET['id'] : '';

$artPiece = new ArtPiece();
$gallery = new Gallery();
$auction = new Auction();
$forums = new Forum();
$user = new User();

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

                case 'home':
                    // Users can view the homepage
                    require_once 'main/home.php';
                    break; 
                
                case 'gallery':
                    // Users can view the gallery
                    require_once 'gallery-module/index.php';
                    break; 

                case 'art':
                    // Users can view art details
                    require_once 'art-module/index.php';
                    break; 

                case 'forums':
                    // Users can participate in forums (modify this to reflect actual forum feature)
                    require_once 'forums-module/index.php';
                    break;
            
                 case 'auctions':
                     // Users can participate in forums (modify this to reflect actual forum feature)
                    require_once 'auctions-module/index.php';
                    break;
        

                case 'logout':
                    // Handle logout (this should log the user out and redirect to login)
                    require_once 'logout.php';
                    break;

                default:
                    // Default page if no specific page is set
                    require_once 'main.php';
                    break; 
            }
            ?>
        </div>
    </div>
</div>
</body>
</html>
