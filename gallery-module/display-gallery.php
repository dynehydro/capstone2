<?php
$gallery_name = $gallery->get_gallery_name($id);
$gallery_image = $gallery->get_gallery_image($id); 

$id = isset($_GET['id']) ? htmlspecialchars($_GET['id']) : '';
?>

<div id="gallery-container">
    <div id="gallery-details">
        
        <div id="breadcrumb">
            <a href="index.php?page=gallery" id="links">Home</a>
            <span> /</span>
            <span><?php echo $gallery->get_gallery_name($id); ?></span>
        </div>

        <div class="gallery-header">
            <div id="gallery-name">
                <?php echo $gallery->get_gallery_name($id); ?>
            </div>

            <?php

            $user_id = $_SESSION['user_id'];

            if ($user->get_user_access($user_id) == "user") {
                header("index.php?page=gallery&subpage=gallery");
            } else if ($user->get_user_access($user_id) == "admin") {
                // Display the button if the condition is false
                ?>
                <a href="index.php?page=gallery&subpage=gallery&action=update&id=<?php echo $id; ?>">
                    <button class="edit-button">
                        <i class="fas fa-pen"></i>
                    </button>
                </a>  
                <div>
                <!-- Delete Button -->
                <button class="edit-button" onclick="deleteGallery(<?php echo $id; ?>)">
                    <i class="fas fa-trash"></i>
                </button>

                <script>
                    function deleteGallery(galleryId) {
                        if (confirm('Are you sure you want to delete this gallery?')) {
                            // Prepare AJAX request
                            const xhr = new XMLHttpRequest();
                            xhr.open('POST', 'processes/processes.gallery.php?action=delete', true);
                            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                            
                            // Handle the response
                            xhr.onload = function () {
                                if (xhr.status === 200) {
                                    javascript:history.back()
                                    document.getElementById(`gallery-${galleryId}`).remove();
                                } else {
                                    alert('Failed to delete the gallery. Please try again.');
                                }
                            };

                            // Send the request
                            xhr.send('gallery_id=' + galleryId);
                        }
                    }
                </script>
                </div>
                <?php

            }
            ?>

        </div>
        
        <div id="gallery-bg">
            <div id="gallery-info">
                <br>
                <p><?php echo $gallery->get_gallery_description($id); ?></p>
                <br>
                <p> Find us at <?php echo $gallery->get_gallery_location($id); ?></p>
                <p> Or visit our website <a href="<?php echo $gallery->get_gallery_link($id); ?>" target="_blank" class="links">
                    <?php echo $gallery->get_gallery_link($id); ?>
                </a>


                <p><strong>Curator:</strong> <?php echo $gallery->get_gallery_curator($id); ?></p>
                <p> Contact us at <?php echo $gallery->get_gallery_contact_no($id); ?></p>
            </div>
        </div>
    </div>

    <div class="gallery-header">
            <div id="gallery-name">
                Our Art
            </div>

            <?php

            $user_id = $_SESSION['user_id'];

            if ($user->get_user_access($user_id) == "user") {
                // Redirect to index.php?page=users if the condition is true
                header("index.php?page=gallery&subpage=gallery");
            } else if ($user->get_user_access($user_id) == "admin") {
                // Display the button if the condition is false
                ?>
                <a href="index.php?page=art&subpage=art&action=create&gallery_id=<?php echo $_GET['id'];?>" id="button">
                    <button class="edit-button">
                        <i class="fas fa-plus"></i>
                    </button>
                </a>
                <?php

            }
            ?>
        
    </div>

    <div>
        <?php include_once "gallery-module/display.php";?>
    </div>
</div>

<div class="update-image">
    <img src="processes/uploads/<?php echo htmlspecialchars($gallery_image); ?>" alt="<?php echo htmlspecialchars($gallery_name); ?>" />
</div>


