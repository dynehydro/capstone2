<?php
include_once '../classes/class.art.php';

// Instantiate the ArtPiece class
$art = new ArtPiece();

// Get the search query from the URL parameter
$q = isset($_GET["q"]) ? $_GET["q"] : "";

// Container for the results
$hint = '<div id="search-result">';

// Fetch data based on the search query
$data = $art->list_art_piece_search($q);
if ($data != false) {
    foreach ($data as $value) {
        extract($value);

        // Each art piece result as a gallery-item div
        $hint .= '
        <div id="subcontent">
        <a href="index.php?page=art&subpage=art&action=profile&id=' . $artpiece_id . '">
            <div class="gallery-item">
                <div class="gallery-image">
                    <img src="processes/uploads/' . htmlspecialchars($artpiece_image) . '" alt="' . htmlspecialchars($artpiece_title) . '" />
                </div>
                <div class="gallery-details">
                    <h2>' . htmlspecialchars($artpiece_title) . '</h2>
                    <p>' . htmlspecialchars($artpiece_description) . '</p>
                </div>
            </div>
        </a>
        </div>';
    }
} else {
    $hint .= "<p>No Record Found.</p>";
}

$hint .= '</div>';

// Output the results
echo $hint;
?>
