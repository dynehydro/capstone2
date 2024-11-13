<?php
include '../classes/class.user.php';

$action = isset($_GET['action']) ? $_GET['action'] : '';

switch($action){
	case 'new':
        create_new_user();
	break;
    case 'update':
        update_user();
	break;
    case 'delete':
        delete_user();
	break;
}

function create_new_user(){
	$user = new User();

    // Check if each POST field is set and assign default values if needed
    $email = isset($_POST['email']) ? $_POST['email'] : null;
    $lastname = isset($_POST['lastname']) ? ucwords($_POST['lastname']) : '';
    $firstname = isset($_POST['firstname']) ? ucwords($_POST['firstname']) : '';
    $access = isset($_POST['access']) ? ucwords($_POST['access']) : '';
    $password = isset($_POST['password']) ? ($_POST['password']) : ('');

    if ($email && $password) {
        $result = $user->new_user($email, $password, $lastname, $firstname, $access);
        if ($result) {
            $id = $user->get_user_id($email);
            header('location: ../index.php?page=gallery&subpage=gallery');
            exit();
        }
    } else {
        echo "Error: Email and password are required.";
    }
}



function update_user(){
	$user = new User();
    $user_id = $_POST['user_id'];
    $lastname = ucwords($_POST['lastname']);
    $firstname = ucwords($_POST['firstname']);
    $access = ucwords($_POST['access']);

    $result = $user->update_user($lastname,$firstname,$access,$user_id);
    if($result){
        header('location: ../index.php?page=users&subpage=users');
    }
}

function delete_user(){
    $user = new User();
    $user_id = $_POST['user_id'];

    $result = $user->delete_user($user_id);
    if($result){
        header('location: ../index.php?page=users&subpage=users');
    }
}



