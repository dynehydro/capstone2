<?php
// Retrieve art piece and gallery details
$art = isset($_GET['id']) ? htmlspecialchars($_GET['id']) : '';
echo "Art Piece ID is " . $art;

$artpiece_title = $artPiece->get_artpiece_title($art);
$gallery_id = isset($_GET['gallery_id']) ? htmlspecialchars($_GET['gallery_id']) : '';
$gallery_name = $gallery->get_gallery_name($gallery_id);

echo " | Gallery ID is " . $gallery_id;
echo " | Gallery Name is " . $gallery_name;
?>

<div id="gallery-container">
    <div id="gallery-details">
        <div id="breadcrumb">
            <a href="index.php?page=gallery&subpage=gallery" id="links">Home</a>
            <span> / </span>
            <a href="javascript:history.back()" id="links">
                <?php echo htmlspecialchars($gallery_name); ?>
            </a>
            <span> / </span>
            <span>Viewing <?php echo htmlspecialchars($artpiece_title); ?></span>
        </div>
    </div>
</div>

<div id="details-block">
    <!-- Art Piece Title -->
    <div>
        <strong>Art Piece Title:</strong> <?php echo htmlspecialchars($artpiece_title); ?>
    </div>
    
    <!-- Artist -->
    <div>
        <strong>Artist:</strong> <?php echo htmlspecialchars($artPiece->get_artpiece_artist($art)); ?>
    </div>
    
    <!-- Medium -->
    <div>
        <strong>Medium:</strong> <?php echo htmlspecialchars($artPiece->get_artpiece_medium($art)); ?>
    </div>
    
    <!-- Creation Date -->
    <div>
        <strong>Creation Date:</strong> <?php echo htmlspecialchars($artPiece->get_artpiece_creation_date($art)); ?>
    </div>
    
    <!-- Price -->
    <div>
        <strong>Price:</strong> <?php echo htmlspecialchars($artPiece->get_artpiece_price($art)); ?>
    </div>
    
    <!-- Dimensions -->
    <div>
        <strong>Dimensions:</strong> 
        <?php echo htmlspecialchars($gallery->get_artpiece_height($art)) . " x " . htmlspecialchars($gallery->get_artpiece_width($art)) . " " . htmlspecialchars($artPiece->get_artpiece_unit($art)); ?>
    </div>
    
    <!-- Description -->
    <div>
        <strong>Description:</strong> <?php echo htmlspecialchars($artPiece->get_artpiece_description($art)); ?>
    </div>
    
    <!-- Status -->
    <div>
        <strong>Status:</strong> <?php echo htmlspecialchars($artPiece->get_artpiece_status($art)); ?>
    </div>
    
    <!-- Gallery ID -->
    <div>
        <strong>Gallery ID:</strong> <?php echo htmlspecialchars($gallery_id); ?>
    </div>
    
    <!-- Art Piece Images -->
    <div>
        <strong>Art Piece Images:</strong> 
        <div id="image-gallery">
            <?php
            $images = $artPiece->get_artpiece_images($art); // Assuming this function returns an array of image paths
            foreach ($images as $image) {
                echo "<img src='processes/uploads/" . htmlspecialchars($image) . "' alt='" . htmlspecialchars($artpiece_title) . "' class='artpiece-image' />";
            }
            ?>
        </div>
    </div>
</div>
