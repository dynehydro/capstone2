<?php
include '../classes/class.auction.php'; // Assuming you have a class for handling auctions

$action = isset($_GET['action']) ? $_GET['action'] : '';

switch($action) {
    case 'create':
        new_auction();
        break;
    case 'update':
        update_auction();
        break;
    case 'delete':
        delete_auction();
        break;
}

function new_auction() {
    $auction = new Auction();

    // Retrieve form data
    $gallery_id = isset($_POST['gallery_id']) ? (int)$_POST['gallery_id'] : 0;
    $artpiece_id = isset($_POST['artpiece_id']) ? (int)$_POST['artpiece_id'] : 0;
    $artpiece_title = ucwords($_POST['artpiece_title']);
    $artpiece_price = $_POST['artpiece_price'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $starting_bid = $_POST['starting_bid'];
    $auction_description = $_POST['auction_description'];

    $result = $auction->new_auction($gallery_id, $artpiece_id, $artpiece_title, $artpiece_price, $start_date, $end_date, $starting_bid, $auction_description);
    
    if ($result) {
        header('location: ../index.php?page=auctions&subpage=list');
    } else {
        echo "Error creating auction.";
    }
}

function update_auction() {
    $auction = new Auction();

    // Retrieve form data
    $auction_id = $_POST['auction_id'];
    $gallery_id = isset($_POST['gallery_id']) ? (int)$_POST['gallery_id'] : 0;
    $artpiece_id = isset($_POST['artpiece_id']) ? (int)$_POST['artpiece_id'] : 0;
    $artpiece_title = ucwords($_POST['artpiece_title']);
    $artpiece_price = $_POST['artpiece_price'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $starting_bid = $_POST['starting_bid'];
    $current_bid = $_POST['current_bid'];
    $highestbidder_id = $_POST['highestbidder_id'];
    $auction_status = $_POST['auction_status'];
    $auction_description = $_POST['auction_description'];

    $result = $auction->update_auction($auction_id, $gallery_id, $artpiece_id, $artpiece_title, $artpiece_price, $start_date, $end_date, $starting_bid, $current_bid, $highestbidder_id, $auction_status, $auction_description);
    
    if ($result) {
        header('location: ../index.php?page=auctions&subpage=list');
    } else {
        echo "Error updating auction.";
    }
}

function delete_auction() {
    $auction = new Auction();
    $auction_id = $_POST['auction_id'];

    $result = $auction->delete_auction($auction_id);
    if ($result) {
        header('location: ../index.php?page=auctions&subpage=list');
    } else {
        echo "Error deleting auction.";
    }
}

?>
