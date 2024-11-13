<div id="third-submenu">
    <a href="index.php?page=gallery&subpage=gallery" class="btn-cancel">Cancel</a>
</div>

<div id="form-block">
    <h3>Add Gallery</h3>

    <form method="POST" action="processes/processes.gallery.php?action=create" enctype="multipart/form-data">
        <div class="form-row">
            <input class="input" type="file" name="gallery_image" required>
        </div>

        <div id="form-block-half">
            <label for="gallery_name">Gallery Name</label>
            <input type="text" id="gallery_name" class="input" name="gallery_name" placeholder="Gallery Name" required>

            <label for="gallery_curator">Curator</label>
            <input type="text" id="gallery_curator" class="input" name="gallery_curator" placeholder="Curator Name" required>

            <label for="gallery_contact_no">Contact Number</label>
            <input type="text" id="gallery_contact_no" class="input" name="gallery_contact_no" placeholder="Contact Number" required>

            <label for="gallery_link">Relevant Links</label>
            <input type="text" id="gallery_link" class="input" name="gallery_link" placeholder="External Links" required>

            <label for="gallery_location">Location</label>
            <input type="text" id="gallery_location" class="input" name="gallery_location" placeholder="Gallery Location" required>

            <label for="gallery_description">Gallery Description</label>
            <textarea id="gallery_description" class="input" name="gallery_description" placeholder="Enter a brief description of the gallery" required></textarea>
        </div>

        <div id="button-block">
            <input type="submit" value="Save" class="btn-save">
        </div>
    </form>
</div>
