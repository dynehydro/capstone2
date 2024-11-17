<?php

$art = isset($_GET['id']) ? htmlspecialchars($_GET['id']) : '';

$artpiece_title = $artPiece->get_artpiece_title($art);
$gallery_id = isset($_GET['gallery_id']) ? htmlspecialchars($_GET['gallery_id']) : '';
$gallery_name = $gallery->get_gallery_name($gallery_id);

?>

<div id="gallery-container">
    <div id="gallery-details">
        <div id="breadcrumb">
            <a href="index.php?page=gallery&subpage=gallery" id="links">Home</a>
            <span> / </span>
                <a href="javascript:history.back()" id="links">
                    <?php echo $gallery_name;?>
                </a>
            <span> / </span>
            <span>Art Pieces</span>
            <span> / </span>
            <span>Updating <?php echo $artpiece_title;?> </span>
        </div>
    </div>
</div>

    <div>
        <a href="index.php?page=auctions&subpage=auctions&action=create&artpiece_id=<?php echo $art; ?>&gallery_id=<?php echo $gallery_id; ?>"
            id="button">                
            <button class="auction-button">
                <i class="fas fa-plus"></i> Open Auction
            </button>
        </a>
    </div>

<div>
<button class="edit-button" onclick="deleteArtpiece(<?php echo $id; ?>)">
    <i class="fas fa-trash"></i>
</button>


<script>
                    function deleteArtpiece(art) {
                        if (confirm('Are you sure you want to delete this artpiece?')) {
                            // Prepare AJAX request
                            const xhr = new XMLHttpRequest();
                            xhr.open('POST', 'processes/process.art.php?action=delete', true);
                            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                            
                            // Handle the response
                            xhr.onload = function () {
                                if (xhr.status === 200) {
                                    javascript:history.back()
                                    document.getElementById(`art-${art}`).remove();
                                } else {
                                    alert('Failed to delete the artpiece. Please try again.');
                                }
                            };

                            // Send the request
                            xhr.send('artpiece_id=' + art);
                        }
                    }
                </script>

</div>


<div id="form-block">
    <form method="POST" action="processes/process.art.php?action=update">
        <div id="update-block-half">
            <!-- Art Piece Title -->
            <label for="artpiece_title">Art Piece Title</label>
            <input type="text" id="artpiece_title" class="input" name="artpiece_title" value="<?php echo htmlspecialchars($artPiece->get_artpiece_title($art)); ?>" readonly>

            <!-- Artist -->
            <label for="artpiece_artist">Artist</label>
            <input type="text" id="artpiece_artist" class="input" name="artpiece_artist" value="<?php echo htmlspecialchars($artPiece->get_artpiece_artist($art)); ?>" readonly>

            <!-- Medium -->
            <label for="artpiece_medium">Medium</label>
            <input type="text" id="artpiece_medium" class="input" name="artpiece_medium" value="<?php echo htmlspecialchars($artPiece->get_artpiece_medium($art)); ?>" readonly>

            <!-- Creation Date -->
            <label for="artpiece_creation_date">Creation Date</label>
            <input type="date" id="artpiece_creation_date" class="input" name="artpiece_creation_date" value="<?php echo htmlspecialchars($artPiece->get_artpiece_creation_date($art)); ?>" readonly>

            <!-- Price -->
            <label for="artpiece_price">Price</label>
            <input type="number" id="artpiece_price" class="input" name="artpiece_price" value="<?php echo htmlspecialchars($artPiece->get_artpiece_price($art)); ?>" readonly>
            
            <label for="artpiece_dimensions">Dimension</label>
            <textarea id="artpiece_dimensions" class="input" name="artpiece_dimensions" readonly><?php echo htmlspecialchars($artPiece->get_artpiece_dimensions($art)); ?></textarea>

            <!-- Description -->
            <label for="artpiece_description">Description</label>
            <textarea id="artpiece_description" class="input" name="artpiece_description" readonly><?php echo htmlspecialchars($artPiece->get_artpiece_description($art)); ?></textarea>

            <!-- Status -->
            <label for="artpiece_status">Status</label>
            <select id="artpiece_status" name="artpiece_status" class="input" required>
                <option value="Display" <?php echo ($artPiece->get_artpiece_status($art) == 'Display') ? 'selected' : ''; ?>>On Display</option>
                <option value="Sold" <?php echo ($artPiece->get_artpiece_status($art) == 'Sold') ? 'selected' : ''; ?>>Sold</option>
                <option value="Archived" <?php echo ($artPiece->get_artpiece_status($art) == 'Archived') ? 'selected' : ''; ?>>Archived</option>
            </select>
        </div>

        <!-- Submit Button -->
        <div>
            <input type="submit" value="Save">
        </div>
    </form>
</div>
