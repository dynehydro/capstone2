<?php
class Gallery {
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
    public function new_gallery($gallery_name, $gallery_description, $gallery_curator, $gallery_link, $gallery_location, $gallery_contact_no, $image_url) {
        try {
            $stmt = $this->conn->prepare("
                INSERT INTO tbl_gallery 
                (gallery_name, gallery_description, gallery_curator, gallery_link, gallery_location, gallery_contact_no, gallery_image) 
                VALUES (?, ?, ?, ?, ?, ?, ?)
            ");
    
            $stmt->execute([$gallery_name, $gallery_description, $gallery_curator, $gallery_link, $gallery_location, $gallery_contact_no, $image_url]);
            return true;
        } catch (PDOException $e) {
            // Handle the exception, e.g., log the error or display an error message
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
    

    public function update_gallery($gallery_name, $gallery_description, $gallery_curator, $gallery_link, $gallery_location, $gallery_contact_no, $id) {
       
        $sql = "UPDATE tbl_gallery SET gallery_name=:gallery_name, gallery_description=:gallery_description, gallery_curator=:gallery_curator, gallery_link=:gallery_link, gallery_location=:gallery_location, gallery_contact_no=:gallery_contact_no WHERE gallery_id=:gallery_id";

        $q = $this->conn->prepare($sql);
        $q->execute(array(
            ':gallery_name' => $gallery_name,
            ':gallery_description' => $gallery_description,
            ':gallery_curator' => $gallery_curator,
            ':gallery_contact_no' => $gallery_contact_no,
            ':gallery_link' => $gallery_link,
            ':gallery_location' => $gallery_location,
            ':gallery_id' => $id
        ));
        return true;
    }

    public function list_gallery_search($keyword) {
        try {
            $keyword = "%{$keyword}%";
            $q = $this->conn->prepare('SELECT * FROM `tbl_gallery` WHERE `gallery_name` LIKE ?');
            $q->bindValue(1, $keyword, PDO::PARAM_STR);
            $q->execute();

            $data = array();
            while ($r = $q->fetch(PDO::FETCH_ASSOC)) {
                $data[] = $r;
            }

            return empty($data) ? false : $data;
        } catch (PDOException $e) {
            return array();
        }
    }

    public function list_galleries() {
        $sql = "SELECT * FROM tbl_gallery";
        $q = $this->conn->query($sql) or die("failed!");
        $data = [];
        while ($r = $q->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $r;
        }
        return empty($data) ? false : $data;
    }

    public function delete_gallery($id) {
        $sql = "DELETE FROM tbl_gallery WHERE gallery_id=:gallery_id";
        $q = $this->conn->prepare($sql);
        $q->execute(array(':gallery_id' => $id));
        return true;
    }    

    function get_gallery_name($id) {
        $sql = "SELECT gallery_name FROM tbl_gallery WHERE gallery_id = :id";
        $q = $this->conn->prepare($sql);
        $q->execute(['id' => $id]);
        return $q->fetchColumn();
    }

    function get_gallery_image($id) {
        $sql = "SELECT gallery_image FROM tbl_gallery WHERE gallery_id = :id";
        $q = $this->conn->prepare($sql);
        $q->execute(['id' => $id]);
        return $q->fetchColumn();
    }

    function get_gallery_description($id) {
        $sql = "SELECT gallery_description FROM tbl_gallery WHERE gallery_id = :id";
        $q = $this->conn->prepare($sql);
        $q->execute(['id' => $id]);
        return $q->fetchColumn();
    }

    function get_gallery_link($id) {
        $sql = "SELECT gallery_link FROM tbl_gallery WHERE gallery_id = :id";
        $q = $this->conn->prepare($sql);
        $q->execute(['id' => $id]);
        return $q->fetchColumn();
    }

    function get_gallery_location($id) {
        $sql = "SELECT gallery_location FROM tbl_gallery WHERE gallery_id = :id";
        $q = $this->conn->prepare($sql);
        $q->execute(['id' => $id]);
        return $q->fetchColumn();
    }

    function get_gallery_curator($id) {
        $sql = "SELECT gallery_curator FROM tbl_gallery WHERE gallery_id = :id";
        $q = $this->conn->prepare($sql);
        $q->execute(['id' => $id]);
        return $q->fetchColumn();
    }

    function get_gallery_contact_no($id) {
        $sql = "SELECT gallery_contact_no FROM tbl_gallery WHERE gallery_id = :id";
        $q = $this->conn->prepare($sql);
        $q->execute(['id' => $id]);
        return $q->fetchColumn();
    }
}
?>
