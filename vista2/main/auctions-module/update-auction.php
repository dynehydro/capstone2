<?php
$title = $artPiece->get_artpiece_title($id);

$id = isset($_GET['id']) ? htmlspecialchars($_GET['id']) : '';
echo "Debug: Art Piece ID is " . $id;
?>

<div id="gallery-container">
    <div id="gallery-details">
    <div id="breadcrumb">
        <a href="index.php?page=gallery&subpage=gallery" id="links">Home</a>
        <span> / </span>
        <a href="javascript:history.back()" id="links"><?php echo $gallery->get_gallery_name($id); ?></a>
        <span> / </span>
        <span> Updating Art Piece </span>
    </div>
    </div>
</div>

<div id="form-block">
    <form method="POST" action="processes/process.art.php?action=update" enctype="multipart/form-data">
        <div id="update-block-half">
            <!-- Art Piece Title -->
            <label for="artpiece_title">Art Piece Title</label>
            <input type="text" id="artpiece_title" class="input" name="artpiece_title" value="<?php echo htmlspecialchars($artPiece->get_artpiece_title($id)); ?>" placeholder="Name of artpiece.." required>
            
            <!-- Artist -->
            <label for="artpiece_artist">Artist</label>
            <input type="text" id="artpiece_artist" class="input" name="artpiece_artist" value="<?php echo htmlspecialchars($artPiece->get_artpiece_artist($id)); ?>" placeholder="Artist's name.." required>

            <!-- Medium -->
            <label for="artpiece_medium">Medium</label>
            <input type="text" id="artpiece_medium" class="input" name="artpiece_medium" value="<?php echo htmlspecialchars($artPiece->get_artpiece_medium($id)); ?>" placeholder="Medium (e.g., Oil on Canvas)" required>

            <!-- Creation Date -->
            <label for="artpiece_creation_date">Creation Date</label>
            <input type="date" id="artpiece_creation_date" class="input" name="artpiece_creation_date" value="<?php echo htmlspecialchars($artPiece->get_artpiece_creation_date($id)); ?>" placeholder="Creation date..." required>

            <!-- Price -->
            <label for="artpiece_price">Price</label>
            <input type="number" id="artpiece_price" class="input" name="artpiece_price" value="<?php echo htmlspecialchars($artPiece->get_artpiece_price($id)); ?>" placeholder="Price" step="0.01" required>

            <!-- Dimensions (Height, Width, Unit) -->
            <label for="artpiece_height">Dimensions</label>
            <div>
                <input type="number" id="artpiece_height" class="input" name="artpiece_height" value="<?php echo htmlspecialchars($gallery->get_artpiece_height($id)); ?>" placeholder="Height" required>
                <input type="number" id="artpiece_width" class="input" name="artpiece_width" value="<?php echo htmlspecialchars($gallery->get_artpiece_width($id)); ?>" placeholder="Width" required>
                <select id="artpiece_unit" name="artpiece_unit" class="input" required>
                    <option value="inches" <?php echo ($artPiece->get_artpiece_unit($id) == 'inches') ? 'selected' : ''; ?>>inches</option>
                    <option value="cm" <?php echo ($artPiece->get_artpiece_unit($id) == 'cm') ? 'selected' : ''; ?>>cm</option>
                    <option value="m" <?php echo ($artPiece->get_artpiece_unit($id) == 'm') ? 'selected' : ''; ?>>m</option>
                </select>
            </div>
            
            <!-- Description -->
            <div>

            <label for="artpiece_description">Description</label>
            <textarea id="artpiece_description" class="input" name="artpiece_description" placeholder="Enter a brief description of the art piece"><?php echo htmlspecialchars($artPiece->get_artpiece_description($id)); ?></textarea>

            <!-- Status -->
            <label for="artpiece_status">Status</label>
            <select id="artpiece_status" name="artpiece_status" class="input" required>
                <option value="Display" <?php echo ($artPiece->get_artpiece_status($id) == 'Display') ? 'selected' : ''; ?>>On Display</option>
                <option value="Sold" <?php echo ($artPiece->get_artpiece_status($id) == 'Sold') ? 'selected' : ''; ?>>Sold</option>
                <option value="Archived" <?php echo ($artPiece->get_artpiece_status($id) == 'Archived') ? 'selected' : ''; ?>>Archived</option>
            </select>
</div>
        </div>

        <!-- Gallery ID (readonly) -->
        <div>
            <label for="gallery_id">Gallery ID</label>
            <input type="input" id="gallery_id" class="input" name="gallery_id" value="<?php echo isset($_GET['gallery_id']) ? htmlspecialchars($_GET['gallery_id']) : ''; ?>" readonly required>
        </div>

        <!-- Art Piece Images -->
        <div id="form-block-half">
            <label for="artpiece_images">Art Piece Images</label>
            <input class="input" type="file" name="artpiece_images[]" multiple>
        </div>

        <!-- Hidden Input for Dimensions -->
        <input type="hidden" id="artpiece_dimensions" name="artpiece_dimensions">

        <!-- Submit Button -->
        <div id="button-block">
            <input type="submit" value="Save">
        </div>

        <!-- Include Delete Art Function -->
        <?php include_once "art-module/delete-art.php"; ?>
    </form>
</div>

<script>
// Function to combine height, width, and unit into one string for hidden input
function combineDimensions() {
    const height = document.getElementById("artpiece_height").value;
    const width = document.getElementById("artpiece_width").value;
    const unit = document.getElementById("artpiece_unit").value;
    
    // Combine into a single string (e.g., "24x36 inches")
    const dimensions = `${height}x${width} ${unit}`;
    document.getElementById("artpiece_dimensions").value = dimensions;
}

// Trigger the function when the form is submitted
document.querySelector("form").addEventListener("submit", combineDimensions);
</script>
