<?php
class Bids {
    private $DB_SERVER = 'localhost';
    //private $DB_USERNAME = 'siremmanuel_admin';
    //private $DB_PASSWORD = 'Sm2120257';
    private $DB_USERNAME = 'root';
    private $DB_PASSWORD = '';
    private $DB_DATABASE = 'siremmanuel_db_wbapp';
    private $conn;

    public function __construct() {
        $this->conn = new PDO("mysql:host=" . $this->DB_SERVER . ";dbname=" . $this->DB_DATABASE, $this->DB_USERNAME, $this->DB_PASSWORD);
    }

    // Method to place a new bid
    public function create_bid($auction_id, $user_id, $bid_amount) {
        try {
            $stmt = $this->conn->prepare("INSERT INTO tbl_bids (auction_id, user_id, bids_amount) VALUES (?, ?, ?)");
            $stmt->execute([$auction_id, $user_id, $bid_amount]);
            return true;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    // Method to get all bids for an auction
    public function get_bids_for_auction($auction_id) {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM tbl_bids WHERE auction_id = ?");
            $stmt->execute([$auction_id]);
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return empty($data) ? false : $data;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    // Method to get the highest bid for an auction
    public function get_highest_bid($auction_id) {
        try {
            $stmt = $this->conn->prepare("SELECT MAX(bids_amount) AS highest_bid FROM tbl_bids WHERE auction_id = ?");
            $stmt->execute([$auction_id]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['highest_bid'] ?? 0;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    // Method to get the current highest bidder for an auction
    public function get_highest_bidder($auction_id) {
        try {
            $stmt = $this->conn->prepare("SELECT user_id FROM tbl_bids WHERE auction_id = ? ORDER BY bids_amount DESC LIMIT 1");
            $stmt->execute([$auction_id]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['user_id'] ?? null;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    // Method to list all bids placed by a user
    public function list_user_bids($user_id) {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM tbl_bids WHERE user_id = ?");
            $stmt->execute([$user_id]);
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return empty($data) ? false : $data;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

}
?>
