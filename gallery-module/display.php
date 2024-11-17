<div id="display">
    <?php
    // Retrieve the list of art pieces in the gallery
    $art_pieces = $artPiece->list_gallery_pieces($id);
    if ($art_pieces !== false) {
        foreach ($art_pieces as $value) {
            extract($value);
            ?>
            <a href="index.php?page=art&subpage=art&action=profile&id=<?php echo $artpiece_id; ?>&gallery_id=<?php echo $gallery_id; ?>">
                <div class="gallery-art-item">
                    <div class="gallery-art-image">
                        <img src="processes/art/<?php echo htmlspecialchars($artpiece_image); ?>" alt="<?php echo htmlspecialchars($artpiece_title); ?>">
                    </div>
                    <div class="gallery-art-details">
                        <h2><?php echo htmlspecialchars($artpiece_title); ?></h2>
                        <h2><?php echo htmlspecialchars($artpiece_artist); ?></h2>
                        <p><?php echo htmlspecialchars($artpiece_description); ?></p>
                    </div>
                </div>
            </a>
            <?php
        }
    } else {
        echo "<p>No art pieces found.</p>";
    }
    ?>
</div>
