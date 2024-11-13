<?php
include '../classes/class.gallery.php';

$action = isset($_GET['action']) ? $_GET['action'] : '';

switch($action){
    case 'create':
        create_new_gallery();
        break;
    case 'update':
        update_gallery();
        break;
    case 'delete':
        delete_gallery();
        break;
}

function create_new_gallery() {
    $gallery = new Gallery();

    $galleryname = ucwords($_POST['gallery_name']);
    $gallerydescription = ucwords($_POST['gallery_description']);
    $gallerycurator = ucwords($_POST['gallery_curator']);
    $gallerycontact = $_POST['gallery_contact_no'];
    $gallerylink = $_POST['gallery_link'];
    $gallerylocation = $_POST['gallery_location'];

    if (isset($_FILES['gallery_image']) && $_FILES['gallery_image']['error'] !== UPLOAD_ERR_NO_FILE) {
        $img_name = $_FILES['gallery_image']['name'];
        $tmp_name = $_FILES['gallery_image']['tmp_name'];
        $error = $_FILES['gallery_image']['error'];

        if ($error === 0) {

            $img_ex_arr = explode('.', $img_name);
            $img_ex_lc = strtolower(end($img_ex_arr));
            $new_img_name = uniqid("IMG-", true).'.'.$img_ex_lc;
            $img_upload_path = 'uploads/'.$new_img_name;

            if (is_writable('uploads/')) {
                if (move_uploaded_file($tmp_name, $img_upload_path)) {
                    $result = $gallery->new_gallery($galleryname, $gallerydescription, $gallerycurator, $gallerylink, $gallerylocation, $gallerycontact, $new_img_name);
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
        $result = $gallery->new_gallery($galleryname, $gallerydescription, $gallerycurator, $gallerylink, $gallerylocation, $gallerycontact, null);  
    }
}

function update_gallery(){
    $gallery = new Gallery();
    
    $galleryid = $_POST['gallery_id'];
    $galleryname = ucwords($_POST['gallery_name']);
    $gallerydescription = ucwords($_POST['gallery_description']);
    $gallerycurator = ucwords($_POST['gallery_curator']);
    $gallerycontact = $_POST['gallery_contact_no'];
    $gallerylink = $_POST['gallery_link'];
    $gallerylocation = $_POST['gallery_location'];

    $result = $gallery->update_gallery($galleryname, $gallerydescription, $gallerycurator, $gallerylink, $gallerylocation, $gallerycontact, $galleryid);  

    if ($result) {
        // Redirect to the specific gallery page after update
        header('location: ../index.php?page=gallery&subpage=detail&id=' . $galleryid);
        exit;
    } else {
        echo "Error!";
    }
}


    function delete_gallery() {
        $gallery = new Gallery();
        $galleryid = isset($_POST['gallery_id']) ? $_POST['gallery_id'] : null;
    
        if ($galleryid !== null) {
            $result = $gallery->delete_gallery($galleryid);
    
            if ($result) {
                header('location: ../index.php?page=gallery&subpage=gallery');
                exit; 
            } else {
                echo "<p>Error: Unable to delete the gallery.</p>";
            }
        } else {
            echo "<p>Error: Gallery ID is missing.</p>";
        }
    }
    

    function get_gallery_image($id) {
        $query = "SELECT gallery_image FROM tbl_gallery WHERE gallery_id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['gallery_image'] : null;
    }


    function get_gallery_name($id) {
        $query = "SELECT gallery_name FROM tbl_gallery WHERE gallery_id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['gallery_name'] : null;
    }

    function get_gallery_contact_no($id) {
        $query = "SELECT gallery_name FROM tbl_gallery WHERE gallery_id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['gallery_contact_no'] : null;
    }


    // Method to get the gallery description by ID
     function get_gallery_description($id) {
        $query = "SELECT gallery_description FROM tbl_gallery WHERE gallery_id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['gallery_description'] : null;
    }

    function get_gallery_link($id) {
        $query = "SELECT gallery_link FROM tbl_gallery WHERE gallery_id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['gallery_link'] : null;
    }
?>
