<?php
class Forum {
    private $DB_SERVER = 'localhost';
    private $DB_USERNAME = 'root';
    private $DB_PASSWORD = '';
    private $DB_DATABASE = 'siremmanuel_db_wbapp';
    private $conn;

    public function __construct() {
        $this->conn = new PDO("mysql:host=" . $this->DB_SERVER . ";dbname=" . $this->DB_DATABASE, $this->DB_USERNAME, $this->DB_PASSWORD);
    }

    // Create a new forum with title and description
    public function new_forum($forum_title, $forum_description) {
        try {
            $stmt = $this->conn->prepare("INSERT INTO tbl_forums (forum_title, forum_description) VALUES (?, ?)");
            $stmt->execute([$forum_title, $forum_description]);
            return true;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    // Update an existing forum with new title and description
    public function update_forum($forum_title, $forum_description, $forum_id) {
        try {
            $sql = "UPDATE tbl_forums SET forum_title = :forum_title, forum_description = :forum_description WHERE forum_id = :forum_id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':forum_title' => $forum_title,
                ':forum_description' => $forum_description,
                ':forum_id' => $forum_id
            ]);
            return true;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    // Delete a forum
    public function delete_forum($forum_id) {
        try {
            $sql = "DELETE FROM tbl_forums WHERE forum_id = :forum_id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':forum_id' => $forum_id]);
            return true;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    // List all forums with title and description
    public function list_forums() {
        try {
            $sql = "SELECT * FROM tbl_forums";
            $stmt = $this->conn->query($sql);
            $data = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $data[] = $row;
            }
            return empty($data) ? false : $data;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return [];
        }
    }

    // Search forums by title or description
    public function list_forum_search($keyword) {
        try {
            $keyword = "%{$keyword}%";
            $sql = "SELECT * FROM tbl_forums WHERE forum_title LIKE ? OR forum_description LIKE ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$keyword, $keyword]);
            $data = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $data[] = $row;
            }
            return empty($data) ? false : $data;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return [];
        }
    }

    // Get forum details (title and description) by ID
    public function get_forum_details($forum_id) {
        try {
            $sql = "SELECT forum_title, forum_description FROM tbl_forums WHERE forum_id = :forum_id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':forum_id' => $forum_id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return null;
        }
    }
}
?>
