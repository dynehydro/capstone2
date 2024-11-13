<?php
class Forum {
    private $DB_SERVER = 'localhost';
    private $DB_USERNAME = 'root';
    private $DB_PASSWORD = '';
    private $DB_DATABASE = 'siremmanuel_db_wbapp'; // Adjust this to match your database
    private $conn;

    public function __construct() {
        $this->conn = new PDO("mysql:host=" . $this->DB_SERVER . ";dbname=" . $this->DB_DATABASE, $this->DB_USERNAME, $this->DB_PASSWORD);
    }

    // Create a new forum post
    public function new_post($title, $content, $author_id, $image_url) {
        try {
            $stmt = $this->conn->prepare("
                INSERT INTO tbl_forum (post_title, post_content, author_id, post_image) 
                VALUES (?, ?, ?, ?)
            ");
            $stmt->execute([$title, $content, $author_id, $image_url]);
            return true;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    // Update an existing forum post
    public function update_post($title, $content, $image_url, $post_id) {
        try {
            $stmt = $this->conn->prepare("
                UPDATE tbl_forum 
                SET post_title = ?, post_content = ?, post_image = ? 
                WHERE post_id = ?
            ");
            $stmt->execute([$title, $content, $image_url, $post_id]);
            return true;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    // Delete a forum post
    public function delete_post($post_id) {
        try {
            $stmt = $this->conn->prepare("DELETE FROM tbl_forum WHERE post_id = ?");
            $stmt->execute([$post_id]);
            return true;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    // List all forum posts
    public function list_posts() {
        try {
            $stmt = $this->conn->query("SELECT * FROM tbl_forum ORDER BY post_date DESC");
            $data = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $data[] = $row;
            }
            return !empty($data) ? $data : false;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    // List posts by a specific author
    public function list_posts_by_author($author_id) {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM tbl_forum WHERE author_id = ? ORDER BY post_date DESC");
            $stmt->execute([$author_id]);
            $data = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $data[] = $row;
            }
            return !empty($data) ? $data : false;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    // Search forum posts by keyword
    public function search_posts($keyword) {
        try {
            $keyword = "%" . $keyword . "%";
            $stmt = $this->conn->prepare("SELECT * FROM tbl_forum WHERE post_title LIKE ? OR post_content LIKE ?");
            $stmt->execute([$keyword, $keyword]);
            $data = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $data[] = $row;
            }
            return !empty($data) ? $data : false;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    // Get details of a specific post
    public function get_post_details($post_id) {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM tbl_forum WHERE post_id = ?");
            $stmt->execute([$post_id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    // Like a post (This can be expanded with a separate Likes table)
    public function like_post($post_id, $user_id) {
        try {
            $stmt = $this->conn->prepare("INSERT INTO tbl_likes (post_id, user_id) VALUES (?, ?)");
            $stmt->execute([$post_id, $user_id]);
            return true;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    // Unlike a post
    public function unlike_post($post_id, $user_id) {
        try {
            $stmt = $this->conn->prepare("DELETE FROM tbl_likes WHERE post_id = ? AND user_id = ?");
            $stmt->execute([$post_id, $user_id]);
            return true;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    // Get number of likes for a post
    public function get_likes_count($post_id) {
        try {
            $stmt = $this->conn->prepare("SELECT COUNT(*) FROM tbl_likes WHERE post_id = ?");
            $stmt->execute([$post_id]);
            return $stmt->fetchColumn();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    // Get the author's name for a given post
    public function get_post_author($post_id) {
        try {
            $stmt = $this->conn->prepare("SELECT author_name FROM tbl_forum WHERE post_id = ?");
            $stmt->execute([$post_id]);
            return $stmt->fetchColumn();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
}
?>
