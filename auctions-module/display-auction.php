<?php
$auction_id = isset($_GET['id']) ? htmlspecialchars($_GET['id']) : '';

$art = $auction->get_artpiece_id($auction_id);
echo "Debug: Art ID is " . $art;


$gallery_id = $auction->get_gallery_id($auction_id);
$gallery_name = $gallery->get_gallery_name($gallery_id);
$starting_bid = $auction->get_gallery_id($auction_id);
$current_bid = $auction->get_gallery_id($auction_id);

echo " | Gallery ID is " . $gallery_id;
echo " | Auction ID is " . $auction_id;
?>

<div id="gallery-container">
    <div id="gallery-details">
        <div id="breadcrumb">
            <a href="index.php?page=auctions" id="links">Auctions</a>
            <span> / </span>
            <a href="index.php?page=gallery&subpage=gallery&action=profile&id=<?php echo $gallery_id?> "id="links">
                <?php echo htmlspecialchars($gallery_name); ?>
            </a>
            <span> / </span>            
            <span>Viewing Auction Of <?php echo htmlspecialchars($artPiece->get_artpiece_artist($art)); ?></span>
        </div>
    </div>
</div>

<a href="index.php?page=bids&subpage=bids&action=create&auction_id=<?php echo $auction_id;?>" id="button">
    <button class="edit-button">
        <i class="fas fa-plus"></i>
    </button>
</a>

<div id="form-block">
    <div>
        <strong>Art Piece Title:</strong> <?php echo htmlspecialchars($artPiece->get_artpiece_title($art)); ?>
    </div>
    
    <div>
        <strong>Artist:</strong> <?php echo htmlspecialchars($artPiece->get_artpiece_artist($art)); ?>
    </div>
    
    <div>
        <strong>Medium:</strong> <?php echo htmlspecialchars($artPiece->get_artpiece_medium($art)); ?>
    </div>
    
    <div>
        <strong>Creation Date:</strong> <?php echo htmlspecialchars($artPiece->get_artpiece_creation_date($art)); ?>
    </div>
    
    <div>
        <strong>Price:</strong> 
        <?php echo htmlspecialchars($artPiece->get_artpiece_price($art)); ?>
    </div>
    
    <div>
        <strong>Dimensions:</strong> 
        <?php echo htmlspecialchars($artPiece->get_artpiece_dimensions($art)); ?>
    </div>
    
    <div>
        <strong>Description:</strong> <?php echo htmlspecialchars($artPiece->get_artpiece_description($art)); ?>
    </div>
    
    <p><strong>Time Remaining:</strong> <span id="countdown"></span></p>

                            <script>
                            // Set the end date in JavaScript
                            const endDate = new Date("<?php echo date('Y-m-d H:i:s', strtotime($end_date)); ?>").getTime();

                            function updateCountdown() {
                                const now = new Date().getTime();
                                const timeRemaining = endDate - now;

                                if (timeRemaining < 0) {
                                    document.getElementById("countdown").innerHTML = "Auction Ended";
                                    return;
                                }

                                // Calculate days, hours, minutes, and seconds remaining
                                const days = Math.floor(timeRemaining / (1000 * 60 * 60 * 24));
                                const hours = Math.floor((timeRemaining % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                const minutes = Math.floor((timeRemaining % (1000 * 60 * 60)) / (1000 * 60));
                                const seconds = Math.floor((timeRemaining % (1000 * 60)) / 1000);

                                // Display the result in the element with id="countdown"
                                document.getElementById("countdown").innerHTML = days + "d " + hours + "h " +
                                minutes + "m " + seconds + "s ";
                            }

                            // Update the countdown every 1 second
                            setInterval(updateCountdown, 1000);
                            </script>

                            <p><strong>Starting Bid:</strong> $<?php echo number_format($starting_bid, 2); ?></p>
                            <p><strong>Current Bid:</strong> $<?php echo number_format($current_bid, 2); ?></p>
</div>
