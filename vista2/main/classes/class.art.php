<?php
class ArtPiece {
    private $DB_SERVER = 'localhost';
    //private $DB_USERNAME = 'siremmanuel_admin';
    //private $DB_PASSWORD = 'Sm2120257';
    private $DB_USERNAME = 'root';
    private $DB_PASSWORD = '';
    private $DB_DATABASE = 'siremmanuel_db_wbapp';
    private $conn;
    
    public function __construct() {
        $this->conn = new PDO("mysql:host=" . $this->DB_SERVER.";dbname=".$this->DB_DATABASE, $this->DB_USERNAME, $this->DB_PASSWORD);
    }

    public function new_artpiece($title, $artist, $description, $medium, $creation_date, $price, $dimensions, $gallery_id, $image_url) {
        try {
            $stmt = $this->conn->prepare("
                INSERT INTO tbl_art_pieces
                (artpiece_title, artpiece_artist, artpiece_description, artpiece_medium, artpiece_creation_date, artpiece_price, artpiece_dimensions, gallery_id, artpiece_image) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");
    
            $stmt->execute([$title, $artist, $description, $medium, $creation_date, $price, $dimensions, $gallery_id, $image_url]);
            return true;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
    
    

    public function update_art_piece($artpiece_image, $artpiece_title, $artpiece_artist, $artpiece_description, $artpiece_status, $gallery_id, $artpiece_medium, $artpiece_creation_date, $artpiece_price, $artpiece_dimensions, $id) {
        $sql = "UPDATE tbl_art_pieces SET artpiece_image=:artpiece_image, artpiece_title=:artpiece_title, artpiece_artist=:artpiece_artist, artpiece_description=:artpiece_description, artpiece_status=:artpiece_status, gallery_id=:gallery_id, artpiece_medium=:artpiece_medium, artpiece_creation_date=:artpiece_creation_date, artpiece_price=:artpiece_price, artpiece_dimensions=:artpiece_dimensions WHERE artpiece_id=:artpiece_id";

        $q = $this->conn->prepare($sql);
        $q->execute(array(
            ':artpiece_image' => $artpiece_image,
            ':artpiece_title' => $artpiece_title,
            ':artpiece_artist' => $artpiece_artist,
            ':artpiece_description' => $artpiece_description,
            ':artpiece_status' => $artpiece_status,
            ':gallery_id' => $gallery_id,
            ':artpiece_medium' => $artpiece_medium,
            ':artpiece_creation_date' => $artpiece_creation_date,
            ':artpiece_price' => $artpiece_price,
            ':artpiece_dimensions' => $artpiece_dimensions,
            ':artpiece_id' => $id
        ));
        return true;
    }

    public function list_art_pieces() {
        $sql = "SELECT * FROM tbl_art_pieces";
        $q = $this->conn->query($sql) or die("failed!");
        $data = [];
        while ($r = $q->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $r;
        }
        return empty($data) ? false : $data;
    }

    public function list_gallery_pieces($gallery_id) {
        // Prepare the SQL statement with a placeholder for the gallery ID
        $sql = "SELECT * FROM tbl_art_pieces WHERE gallery_id = :gallery_id";
        $stmt = $this->conn->prepare($sql);
        
        // Bind the gallery ID parameter
        $stmt->bindParam(':gallery_id', $gallery_id, PDO::PARAM_INT);
        
        // Execute the prepared statement
        $stmt->execute();
        
        // Fetch all results into an array
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Return false if no data found, otherwise return the data array
        return empty($data) ? false : $data;
    }
    

    public function delete_art_piece($id) {
        $sql = "DELETE FROM tbl_art_pieces WHERE artpiece_id=:artpiece_id";
        $q = $this->conn->prepare($sql);
        $q->execute(array(':artpiece_id' => $id));
        return true;
    }

    function get_art_piece_details($id) {
        $sql = "SELECT * FROM tbl_art_pieces WHERE artpiece_id = :id";
        $q = $this->conn->prepare($sql);
        $q->execute(['id' => $id]);
        return $q->fetch(PDO::FETCH_ASSOC);
    }

    public function list_art_piece_search($keyword) {
        try {
            $keyword = "%{$keyword}%";
            $q = $this->conn->prepare('SELECT * FROM tbl_art_pieces WHERE artpiece_title LIKE ? OR artpiece_artist LIKE ?');
            $q->bindValue(1, $keyword, PDO::PARAM_STR);
            $q->bindValue(2, $keyword, PDO::PARAM_STR);
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

    // Getters for art piece data
function get_artpiece_title($artpiece_id) {
    $sql = "SELECT artpiece_title FROM tbl_art_pieces WHERE artpiece_id = :artpiece_id";
    $q = $this->conn->prepare($sql);
    $q->execute(['artpiece_id' => $artpiece_id]);
    return $q->fetchColumn();
}

function get_artpiece_artist($artpiece_id) {
    $sql = "SELECT artpiece_artist FROM tbl_art_pieces WHERE artpiece_id = :artpiece_id";
    $q = $this->conn->prepare($sql);
    $q->execute(['artpiece_id' => $artpiece_id]);
    return $q->fetchColumn();
}

function get_artpiece_description($artpiece_id) {
    $sql = "SELECT artpiece_description FROM tbl_art_pieces WHERE artpiece_id = :artpiece_id";
    $q = $this->conn->prepare($sql);
    $q->execute(['artpiece_id' => $artpiece_id]);
    return $q->fetchColumn();
}

function get_artpiece_status($artpiece_id) {
    $sql = "SELECT artpiece_status FROM tbl_art_pieces WHERE artpiece_id = :artpiece_id";
    $q = $this->conn->prepare($sql);
    $q->execute(['artpiece_id' => $artpiece_id]);
    return $q->fetchColumn();
}

function get_artpiece_medium($artpiece_id) {
    $sql = "SELECT artpiece_medium FROM tbl_art_pieces WHERE artpiece_id = :artpiece_id";
    $q = $this->conn->prepare($sql);
    $q->execute(['artpiece_id' => $artpiece_id]);
    return $q->fetchColumn();
}

function get_artpiece_creation_date($artpiece_id) {
    $sql = "SELECT artpiece_creation_date FROM tbl_art_pieces WHERE artpiece_id = :artpiece_id";
    $q = $this->conn->prepare($sql);
    $q->execute(['artpiece_id' => $artpiece_id]);
    return $q->fetchColumn();
}

function get_artpiece_price($artpiece_id) {
    $sql = "SELECT artpiece_price FROM tbl_art_pieces WHERE artpiece_id = :artpiece_id";
    $q = $this->conn->prepare($sql);
    $q->execute(['artpiece_id' => $artpiece_id]);
    return $q->fetchColumn();
}

function get_artpiece_dimensions($artpiece_id) {
    $sql = "SELECT artpiece_dimensions FROM tbl_art_pieces WHERE artpiece_id = :artpiece_id";
    $q = $this->conn->prepare($sql);
    $q->execute(['artpiece_id' => $artpiece_id]);
    return $q->fetchColumn();
}
}
?>
