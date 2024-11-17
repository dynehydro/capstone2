<?php
session_start();

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: login.php");
    exit();
}

include_once 'classes/class.art.php';
include_once 'classes/class.gallery.php';
include_once 'classes/class.user.php';
include_once 'classes/class.auction.php';
include_once 'classes/class.bid.php';
include_once 'classes/class.forum.php';
include_once 'classes/class.post.php';
include_once 'classes/class.comment.php';


include 'config/config.php';

$page = (isset($_GET['page']) && $_GET['page'] != '') ? $_GET['page'] : '';
$subpage = (isset($_GET['subpage']) && $_GET['subpage'] != '') ? $_GET['subpage'] : '';
$action = (isset($_GET['action']) && $_GET['action'] != '') ? $_GET['action'] : '';
$id = (isset($_GET['id']) && $_GET['id'] != '') ? $_GET['id'] : '';

$artPiece = new ArtPiece();
$gallery = new Gallery();
$auction = new Auction();
$user = new User();
$bid = new Bids();
$forum = new Forum();
$post = new Post();
$comment = new Comment();



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

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">

        <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css">


        <link rel="stylesheet" href="css/custom.css">

    </head>
<body>        

    <?php include_once "header.php";?>

    <div id="wrapper">
        <div>

            <?php if (isset($_GET['error'])): ?>
                <p><?php echo $_GET['error']; ?></p>
            <?php endif ?>

            <?php
            switch($page){

                case 'home':
                    require_once '/home.php';
                    break; 
                
                case 'gallery':
                    require_once 'gallery-module/index.php';
                    break; 

                case 'art':
                    require_once 'art-module/index.php';
                    break; 

                case 'forums':
                    require_once 'forum/forum-module/index.php';
                    break;
                
                case 'posts':
                    require_once 'forum/post-module/index.php';
                    break;

                    case 'comments':
                        require_once 'forum/comment-module/index.php';
                        break;
            
                 case 'auctions':
                    require_once 'auctions-module/index.php';
                    break;

                case 'bids':
                    require_once 'bids-module/index.php';
                    break;

                case 'forums':
                    require_once 'forums-module/index.php';
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


<?php include_once "footer.php";?>

</body>
</html>
