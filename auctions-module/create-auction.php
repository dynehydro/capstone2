<?php
$art = isset($_GET['artpiece_id']) ? htmlspecialchars($_GET['artpiece_id']) : '';
echo "Art Piece ID is " . $art;

$artpiece_title = $artPiece->get_artpiece_title($art);
$artpiece_price = $artPiece->get_artpiece_price($art);

$gallery_id = isset($_GET['gallery_id']) ? htmlspecialchars($_GET['gallery_id']) : '';
$gallery_name = $gallery->get_gallery_name($gallery_id);

echo " | Gallery ID is " . $gallery_id;
echo " | Gallery Name is " . $gallery_name;''
?>

<div id="gallery-container">
    <div id="gallery-details">
        <div id="breadcrumb">
            <a href="index.php?page=gallery&subpage=gallery" id="links">Home</a>
            <span> / </span>
                <a href="index.php?page=gallery&subpage=gallery&action=profile&id=<?php echo $gallery_id;?>" id="links"><?php echo $gallery_name;?>
                </a>
            <span> / </span>            
            <a href="javascript:history.back()" id="links"><?php echo $artpiece_title;?>
            </a>
            <span> / </span>
            <span>Opening Auction for <?php echo htmlspecialchars($artpiece_title); ?></span>
        </div>
    </div>
</div>

<div id="form-block">
    <form method="POST" action="processes/process.auction.php?action=create" enctype="multipart/form-data">
        <div>
            <label for="artpiece_title">Art Piece Title</label>
            <input type="text" id="artpiece_title" class="input" name="artpiece_title" value="<?php echo htmlspecialchars($artpiece_title); ?>" placeholder="Art Piece Title" required>

            <label for="artpiece_price">Estimated Price</label>
            <input type="number" id="artpiece_price" class="input" name="artpiece_price" value="<?php echo htmlspecialchars($artpiece_price); ?>" placeholder="Price" required>

            <label for="start_date">Auction Start Date</label>
            <input type="datetime-local" id="start_date" class="input" name="start_date" required>

            <label for="end_date">Auction End Date</label>
            <input type="datetime-local" id="end_date" class="input" name="end_date" required>

            <label for="starting_bid">Starting Bid</label>
            <input type="number" id="starting_bid" class="input" name="starting_bid" placeholder="Starting Bid" step="0.01" required>

            <label for="auction_description">Description</label>
            <textarea id="auction_description" class="input" name="auction_description" placeholder="Enter a brief description of the auction"></textarea>
        </div>

        <div>
            <input type="hidden" id="gallery_id" class="input" name="gallery_id" 
            value="<?php echo isset($_GET['gallery_id']) ? htmlspecialchars($_GET['gallery_id']) : ''; ?>" readonly required>
        </div>

        <div>
            <input type="hidden" id="artpiece_id" class="input" name="artpiece_id" 
            value="<?php echo isset($_GET['artpiece_id']) ? htmlspecialchars($_GET['artpiece_id']) : ''; ?>" readonly required>
        </div>

        <div id="button-block">
            <input type="submit" value="Save Auction">
        </div>
    </form>
</div>
