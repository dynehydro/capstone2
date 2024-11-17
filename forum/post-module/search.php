<?php
include_once '../classes/class.gallery.php';

// Instantiate the Gallery class
$gallery = new Gallery();

// Get the search query from the URL parameter
$q = isset($_GET["q"]) ? $_GET["q"] : "";

// Container for the results
$hint = '<div id="search-result">';

// Fetch data based on the search query
$data = $gallery->list_gallery_search($q);
if ($data != false) {
    foreach ($data as $value) {
        extract($value);

        // Each gallery result as a gallery-item div
        $hint .= '
        <div id="subcontent">
        <a href="index.php?page=gallery&subpage=gallery&action=profile&id=' . $gallery_id . '">
            <div class="gallery-item">
                <div class="gallery-image">
                    <img src="processes/uploads/' . htmlspecialchars($gallery_image) . '" alt="' . htmlspecialchars($gallery_name) . '" />
                </div>
                <div class="gallery-details">
                    <h2>' . htmlspecialchars($gallery_name) . '</h2>                </div>
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
