<?php
class Auction {
    private $DB_SERVER = 'localhost';
    private $DB_USERNAME = 'root';
    private $DB_PASSWORD = '';
    private $DB_DATABASE = 'siremmanuel_db_wbapp';
    private $conn;
    
    public function __construct() {
        $this->conn = new PDO("mysql:host=" . $this->DB_SERVER.";dbname=".$this->DB_DATABASE, $this->DB_USERNAME, $this->DB_PASSWORD);
    }

    public function new_auction($gallery_id, $artpiece_id, $artpiece_title, $artpiece_price, $start_date, $end_date, $starting_bid, $auction_description) {
        try {
            $stmt = $this->conn->prepare("
                INSERT INTO tbl_auctions 
                (gallery_id, artpiece_id, artpiece_title, artpiece_price, start_date, end_date, starting_bid, auction_description) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)
            ");
            $stmt->execute([$gallery_id, $artpiece_id, $artpiece_title, $artpiece_price, $start_date, $end_date, $starting_bid, $auction_description]);
            return true;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function update_auction($auction_id, $gallery_id, $artpiece_id, $artpiece_title, $artpiece_price, $start_date, $end_date, $starting_bid, $current_bid, $highestbidder_id, $auction_status, $auction_description) {
        $sql = "UPDATE tbl_auctions SET 
                    gallery_id = :gallery_id,
                    artpiece_id = :artpiece_id,
                    artpiece_title = :artpiece_title,
                    artpiece_price = :artpiece_price,
                    start_date = :start_date,
                    end_date = :end_date,
                    starting_bid = :starting_bid,
                    current_bid = :current_bid,
                    highestbidder_id = :highestbidder_id,
                    auction_status = :auction_status,
                    auction_description = :auction_description
                WHERE auction_id = :auction_id";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':gallery_id' => $gallery_id,
            ':artpiece_id' => $artpiece_id,
            ':artpiece_title' => $artpiece_title,
            ':artpiece_price' => $artpiece_price,
            ':start_date' => $start_date,
            ':end_date' => $end_date,
            ':starting_bid' => $starting_bid,
            ':current_bid' => $current_bid,
            ':highestbidder_id' => $highestbidder_id,
            ':auction_status' => $auction_status,
            ':auction_description' => $auction_description,
            ':auction_id' => $auction_id
        ]);
        return true;
    }

    public function list_auctions() {
        $sql = "SELECT * FROM tbl_auctions";
        $q = $this->conn->query($sql) or die("Failed!");
        $data = [];
        while ($r = $q->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $r;
        }
        return empty($data) ? false : $data;
    }

    public function get_auction_details($auction_id) {
        $sql = "SELECT * FROM tbl_auctions WHERE auction_id = :auction_id";
        $q = $this->conn->prepare($sql);
        $q->execute(['auction_id' => $auction_id]);
        return $q->fetch(PDO::FETCH_ASSOC);
    }

    public function delete_auction($auction_id) {
        $sql = "DELETE FROM tbl_auctions WHERE auction_id = :auction_id";
        $q = $this->conn->prepare($sql);
        $q->execute(['auction_id' => $auction_id]);
        return true;
    }

    function get_artpiece_dimensions($artpiece_id) {
        $sql = "SELECT artpiece_dimensions FROM tbl_art_pieces WHERE artpiece_id = :artpiece_id";
        $q = $this->conn->prepare($sql);
        $q->execute(['artpiece_id' => $artpiece_id]);
        return $q->fetchColumn();
    }

    function get_artpiece_id($auction_id) {
        $sql = "SELECT artpiece_id FROM tbl_auctions WHERE auction_id = :auction_id";
        $q = $this->conn->prepare($sql);
        $q->execute(['auction_id' => $auction_id]);
        return $q->fetchColumn();
    }

    function get_gallery_id($auction_id) {
        $sql = "SELECT gallery_id FROM tbl_auctions WHERE auction_id = :auction_id";
        $q = $this->conn->prepare($sql);
        $q->execute(['auction_id' => $auction_id]);
        return $q->fetchColumn();
    }

    function get_auction_status($auction_id) {
        $sql = "SELECT auction_status FROM tbl_auctions WHERE auction_id = :auction_id";
        $q = $this->conn->prepare($sql);
        $q->execute(['auction_id' => $auction_id]);
        return $q->fetchColumn();
    }

    function get_starting_bid($auction_id) {
        $sql = "SELECT starting_bid FROM tbl_auctions WHERE auction_id = :auction_id";
        $q = $this->conn->prepare($sql);
        $q->execute(['auction_id' => $auction_id]);
        return $q->fetchColumn();
    }

    function get_current_bid($auction_id) {
        $sql = "SELECT current_bid FROM tbl_auctions WHERE auction_id = :auction_id";
        $q = $this->conn->prepare($sql);
        $q->execute(['auction_id' => $auction_id]);
        return $q->fetchColumn();
    }

    function get_highest_bid($auction_id) {
        $sql = "SELECT current_bid FROM tbl_auctions WHERE auction_id = :auction_id";
        $q = $this->conn->prepare($sql);
        $q->execute(['auction_id' => $auction_id]);
        return $q->fetchColumn();
    }

    public function get_start_date($auction_id) {
        $sql = "SELECT start_date FROM tbl_auctions WHERE auction_id = :auction_id";
        $q = $this->conn->prepare($sql);
        $q->execute(['auction_id' => $auction_id]);
        return $q->fetch(PDO::FETCH_ASSOC);
    }

    public function search_auctions($keyword) {
        try {
            $keyword = "%{$keyword}%";
            $q = $this->conn->prepare("SELECT * FROM tbl_auctions WHERE artpiece_title LIKE ?");
            $q->bindValue(1, $keyword, PDO::PARAM_STR);
            $q->execute();

            $data = [];
            while ($r = $q->fetch(PDO::FETCH_ASSOC)) {
                $data[] = $r;
            }
            return empty($data) ? false : $data;
        } catch (PDOException $e) {
            return [];
        }
    }


}
?>
