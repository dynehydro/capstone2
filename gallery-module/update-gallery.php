<?php
$gallery_name = $gallery->get_gallery_name($id);
$current_image = $gallery->get_gallery_image($id); 

$id = isset($_GET['id']) ? htmlspecialchars($_GET['id']) : '';
    ?>

<div id="gallery-container">
    <div id="gallery-details">
    <div id="breadcrumb">
        <a href="index.php?page=gallery&subpage=gallery" id="links">Home</a>
        <span> / </span>
        <a href="javascript:history.back()" id="links"><?php echo $gallery->get_gallery_name($id); ?></a>
        <span> / </span>
        <span>Updating <?php echo $gallery->get_gallery_name($id);?></span>
    </div>
    </div>
</div>

<div id="form-block">
    <form method="POST" action="processes/processes.gallery.php?action=update" enctype="multipart/form-data">
        <div id="update-block-half">

            <div>
                <div style="display: none;">
                    <img src="uploads/<?php echo $current_image; ?>" alt="Gallery Image" style="max-width: 200px; height: auto;">
                </div>
                <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
            </div>

                <label for="gallery_image">Upload New Image (optional):</label>
                <br>
                <input class = "input" type="file" id="gallery_image" name="gallery_image">
                <br>

            <label for="gallery_name">Gallery Name</label>
            <input type="text" id="gallery_name" class="input" name="gallery_name" value=
            "<?php echo $gallery->get_gallery_name($id); ?>" placeholder="Name of gallery.." required>

            <div>
            <label for="gallery_curator">Gallery Curator</label>
            <input type="text" id="gallery_curator" class="input" name="gallery_curator" value=
            "<?php echo $gallery->get_gallery_curator($id); ?>" placeholder="Name of gallery.." required>
            </div>

            <div>
            <label for="gallery_contact_no">Gallery Number</label>
            <input type="text" id="gallery_contact_no" class="input" name="gallery_contact_no" value=
            "<?php echo $gallery->get_gallery_contact_no($id); ?>" placeholder="Name of gallery.." required>
            </div>

            <div>
            <label for="gallery_link">Gallery Link</label>
            <input type="text" id="gallery_link" class="input" name="gallery_link" value=
            "<?php echo $gallery->get_gallery_link($id); ?>" placeholder="Name of gallery.." required>
            </div>

            <div>
            <label for="gallery_location">Gallery Location</label>
            <input type="text" id="gallery_location" class="input" name="gallery_location" value=
            "<?php echo $gallery->get_gallery_location($id); ?>" placeholder="Name of gallery.." required>
            </div>

            <div>
            <label for="gallery_description">Gallery Description</label>
            <textarea id="gallery_description" class="input" name="gallery_description" required>
            <?php echo $gallery->get_gallery_description($id); ?></textarea>
            </div>


            <div>
            <input type="hidden" id="gallery_id" class="input" name="gallery_id" value="<?php echo $id; ?>">
            </div>
        </div>     

        <div> 
            <input type="submit" value="Save">
        </div>
</div>