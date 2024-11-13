<?php
$id = isset($_GET['id']) ? htmlspecialchars($_GET['id']) : '';
$art = isset($_GET['id']) ? htmlspecialchars($_GET['id']) : '';

$gallery_id = isset($_GET['gallery_id']) ? htmlspecialchars($_GET['gallery_id']) : '';
$gallery_name = $gallery->get_gallery_name($gallery_id);
?>

<div id="gallery-container">
    <div id="gallery-details">
        <div id="breadcrumb">
            <a href="index.php?page=gallery&subpage=gallery" id="links">Home</a>
            <span> / </span>
                <a href="javascript:history.back()" id="links">
                <?php
                    echo htmlspecialchars($gallery_name);
                ?>
                </a>
            <span> / </span>
            <span> Adding Art Piece </span>
        </div>
    </div>
</div>

<div>
    <?php 
    echo "Debug: Gallery ID is ";
    echo isset($_GET['gallery_id']) ? htmlspecialchars($_GET['gallery_id']) : ''; 
    ?>
</div>

<div id="form-block">
    <form method="POST" action="processes/process.art.php?action=create" enctype="multipart/form-data">
        <div>
            <label for="artpiece_title">Art Piece Title</label>
            <input type="text" id="artpiece_title" class="input" name="artpiece_title" placeholder="Art Piece Title" required>

            <label for="artpiece_artist">Artist</label>
            <input type="text" id="artpiece_artist" class="input" name="artpiece_artist" placeholder="Artist Name" required>

            <label for="artpiece_medium">Medium</label>
            <input type="text" id="artpiece_medium" class="input" name="artpiece_medium" placeholder="Medium (e.g., Oil on Canvas)" required>

            <label for="artpiece_creation_date">Creation Date</label>
            <input type="date" id="artpiece_creation_date" class="input" name="artpiece_creation_date" required>

            <label for="artpiece_price">Price</label>
            <input type="number" id="artpiece_price" class="input" name="artpiece_price" placeholder="Price" step="0.01">

            <label for="artpiece_height">Dimensions</label>
            <div>
                <input type="number" id="artpiece_height" class="input" name="artpiece_height" placeholder="Height" required>
                <input type="number" id="artpiece_width" class="input" name="artpiece_width" placeholder="Width" required>
                <select id="artpiece_unit" name="artpiece_unit" class="input">
                    <option value="inches">inches</option>
                    <option value="cm">cm</option>
                    <option value="m">m</option>
                </select>
            </div>

            <div>
                <input type="hidden" id="artpiece_dimensions" name="artpiece_dimensions">
                
                <label for="artpiece_description">Description</label>
                <textarea id="artpiece_description" class="input" name="artpiece_description" placeholder="Enter a brief description of the art piece"></textarea>

                <label for="artpiece_status">Status</label>
                <select id="type" name="artpiece_status" placeholder="Status...">
                <option value="Display">On Display</option>
                <option value="Sold">Sold</option>
                <option value="Archived">Archived</option>
                </select>        
            </div>

        <div>
            <input type="hidden" id="gallery_id" class="input" name="gallery_id" 
            value="<?php echo isset($_GET['gallery_id']) ? htmlspecialchars($_GET['gallery_id']) : ''; ?>" readonly required>
        </div>

        <div>
            <input class="input" type="file" name="artpiece_image" required>
        </div>

        <div id="button-block">
            <input type="submit" value="Save">
        </div>

    </form>
</div>

<script>
        // Function to combine height, width, and unit
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
