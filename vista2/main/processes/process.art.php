<?php
include '../classes/class.art.php'; // Assuming you have a class for handling gallery and art pieces

$action = isset($_GET['action']) ? $_GET['action'] : '';

switch($action) {
    case 'create':
        new_artpiece();
        break;
    case 'update':
        update_artpiece();
        break;
    case 'delete':
        delete_artpiece();
        break;
}

function new_artpiece() {
    $artPiece = new ArtPiece();

    // Retrieve form data
    $title = ucwords($_POST['artpiece_title']);
    $artist = ucwords($_POST['artpiece_artist']);
    $description = $_POST['artpiece_description'];
    $medium = ucwords($_POST['artpiece_medium']);
    $creation_date = $_POST['artpiece_creation_date'];
    $price = $_POST['artpiece_price'];
    $dimensions = $_POST['artpiece_dimensions'];
    $gallery_id = isset($_POST['gallery_id']) ? (int)$_POST['gallery_id'] : 0; // Default to 0 if not set

    if (isset($_FILES['artpiece_image']) && $_FILES['artpiece_image']['error'] !== UPLOAD_ERR_NO_FILE) {
        $img_name = $_FILES['artpiece_image']['name'];
        $tmp_name = $_FILES['artpiece_image']['tmp_name'];
        $error = $_FILES['artpiece_image']['error'];

        if ($error === 0) {

            $img_ex_arr = explode('.', $img_name);
            $img_ex_lc = strtolower(end($img_ex_arr));
            $new_img_name = uniqid("IMG-", true).'.'.$img_ex_lc;
            $img_upload_path = 'art/'.$new_img_name;

            if (is_writable('uploads/')) {
                if (move_uploaded_file($tmp_name, $img_upload_path)) {
                    $result = $artPiece->new_artpiece($title, $artist, $description, $medium, $creation_date, $price, $dimensions, $gallery_id, $new_img_name);
                    header('location: ../index.php?page=gallery&subpage=gallery');
                } else {
                    echo "Error moving uploaded file.";
                }
            } else {
                echo "Error: Uploads directory not writable.";
            }
        } else {
            echo "Error uploading image: " . $error;
        }
    } else {
        $result = $artPiece->new_artpiece($title, $artist, $description, $medium, $creation_date, $price, $dimensions, $gallery_id, null);  
    }

}


function update_artpiece() {
    $gallery = new Gallery();
    $artpiece_id = $_POST['artpiece_id'];
    $title = ucwords($_POST['artpiece_title']);
    $artist = ucwords($_POST['artpiece_artist']);
    $description = $_POST['artpiece_description'];
    $status = ucwords($_POST['artpiece_status']);
    $medium = ucwords($_POST['artpiece_medium']);
    $creation_date = $_POST['artpiece_creation_date'];
    $price = $_POST['artpiece_price'];
    $dimensions = $_POST['artpiece_dimensions'];

    $result = $gallery->update_artpiece(
        $artpiece_id, $title, $artist, $description, $status, $medium, $creation_date, $price, $dimensions
    );
    if ($result) {
        header('location: ../index.php?page=gallery&subpage=gallery');
    }
}

function delete_artpiece() {
    $artPiece = new Art();
    $artpiece_id = $_POST['artpiece_id'];

    $result = $artPiece->delete_artpiece($artpiece_id);
    if ($result) {
        header('location: ../index.php?page=gallery&subpage=gallery');
    }
}

function get_gallery_id($id) {

    if (isset($_GET['gallery_id'])) {
        $gallery_id = $_GET['gallery_id'];
    } else {
        // Handle the error if gallery_id is not set
        echo "Gallery ID not specified.";
        exit;
    }
}

?>
