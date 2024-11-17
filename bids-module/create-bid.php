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

<div id="form-block">
    <form method="POST" action="processes/process.bids.php?action=create" enctype="multipart/form-data">
        <div>

        <div>
            <input type="hidden" id="auction_id" class="input" name="auction_id" 
            value="<?php echo isset($_GET['auction_id']) ? htmlspecialchars($_GET['auction_id']) : ''; ?>" readonly required>
        </div>

            <label for="auction_id">Auction ID</label>
            <input type="text" id="auction_id" class="input" name="auction_id" 
                value="<?php echo htmlspecialchars($_GET['auction_id'] ?? ''); ?>" readonly required>

            <label for="user_id">User ID</label>
            <input type="text" id="user_id" class="input" name="user_id" 
                value="<?php echo htmlspecialchars($user_id); ?>" readonly required>

            <label for="bid_amount">Bid Amount</label>
            <input type="number" id="bid_amount" class="input" name="bid_amount" 
                placeholder="Enter your bid amount" step="0.01" required>
        </div>

        <div id="button-block">
            <input type="submit" value="Place Bid">
        </div>
    </form>
</div>

