<?php
include '../classes/class.forum.php';

$action = isset($_GET['action']) ? $_GET['action'] : '';

switch($action){
    case 'create':
        create_new_post();
        break;
    case 'update':
        update_post();
        break;
    case 'delete':
        delete_post();
        break;
}

function create_post() {
    $forum = new Forum();

    $post_title = ucwords($_POST['post_title']);
    $post_content = $_POST['post_content'];
    $user_id = $_SESSION['user_id'];

    if (isset($_FILES['post_image']) && $_FILES['post_image']['error'] !== UPLOAD_ERR_NO_FILE) {
        $img_name = $_FILES['post_image']['name'];
        $tmp_name = $_FILES['post_image']['tmp_name'];
        $error = $_FILES['post_image']['error'];

        if ($error === 0) {

            $img_ex_arr = explode('.', $img_name);
            $img_ex_lc = strtolower(end($img_ex_arr));
            $new_img_name = uniqid("IMG-", true).'.'.$img_ex_lc;
            $img_upload_path = 'uploads/'.$new_img_name;

            if (is_writable('uploads/')) {
                if (move_uploaded_file($tmp_name, $img_upload_path)) {
                    $result = $forum->new_post($post_title, $post_content, $user_id, $new_img_name);
                    header('location: ../index.php?page=forum&subpage=posts');
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
        $result = $forum->new_post($post_title, $post_content, $user_id, null);  
    }
}

function update_post(){
    $forum = new Forum();
    
    $post_id = $_POST['post_id'];
    $post_title = ucwords($_POST['post_title']);
    $post_content = $_POST['post_content'];

    $result = $forum->update_post($post_title, $post_content, $post_id);  

    if ($result) {
        // Redirect to the specific post page after update
        header('location: ../index.php?page=forum&subpage=posts&action=view&id=' . $post_id);
        exit;
    } else {
        echo "Error updating post!";
    }
}

function delete_post() {
    $forum = new Forum();
    $post_id = isset($_POST['post_id']) ? $_POST['post_id'] : null;

    if ($post_id !== null) {
        $result = $forum->delete_post($post_id);

        if ($result) {
            header('location: ../index.php?page=forum&subpage=posts');
            exit; 
        } else {
            echo "<p>Error: Unable to delete the post.</p>";
        }
    } else {
        echo "<p>Error: Post ID is missing.</p>";
    }
}

function get_post_image($id) {
    $query = "SELECT post_image FROM tbl_forum WHERE post_id = :id";
    $stmt = $this->db->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result ? $result['post_image'] : null;
}

function get_post_title($id) {
    $query = "SELECT post_title FROM tbl_forum WHERE post_id = :id";
    $stmt = $this->db->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result ? $result['post_title'] : null;
}

function get_post_content($id) {
    $query = "SELECT post_content FROM tbl_forum WHERE post_id = :id";
    $stmt = $this->db->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result ? $result['post_content'] : null;
}
?>
