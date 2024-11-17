<?php
class Post {
    private $DB_SERVER = 'localhost';
    private $DB_USERNAME = 'root';
    private $DB_PASSWORD = '';
    private $DB_DATABASE = 'siremmanuel_db_wbapp';
    private $conn;

    public function __construct() {
        $this->conn = new PDO("mysql:host=" . $this->DB_SERVER . ";dbname=" . $this->DB_DATABASE, $this->DB_USERNAME, $this->DB_PASSWORD);
    }

    // Create a new post with title, content, image, user ID, and forum ID
    public function new_post($post_title, $post_content, $post_image, $user_id, $forum_id) {
        try {
            $stmt = $this->conn->prepare("INSERT INTO tbl_forum_posts (post_title, post_content, post_image, user_id, forum_id) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$post_title, $post_content, $post_image, $user_id, $forum_id]);
            return true;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    // Update an existing post with new title, content, and optional image
    public function update_post($post_title, $post_content, $post_image, $post_id) {
        try {
            $sql = "UPDATE tbl_forum_posts SET post_title = :post_title, post_content = :post_content, post_image = :post_image WHERE post_id = :post_id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':post_title' => $post_title,
                ':post_content' => $post_content,
                ':post_image' => $post_image,
                ':post_id' => $post_id
            ]);
            return true;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    // Delete a post by ID
    public function delete_post($post_id) {
        try {
            $sql = "DELETE FROM tbl_forum_posts WHERE post_id = :post_id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':post_id' => $post_id]);
            return true;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    // List all posts
    public function list_posts() {
        try {
            $sql = "SELECT * FROM tbl_forum_posts";
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
    public function list_forum_posts($forum_id) {
        $sql = "SELECT * FROM tbl_forum_posts WHERE forum_id = :forum_id";  // Added WHERE clause
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':forum_id', $forum_id, PDO::PARAM_INT);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return empty($data) ? false : $data;
    }

    public function list_post_search($keyword) {
        try {
            $keyword = "%{$keyword}%";
            $sql = "SELECT * FROM tbl_forum_posts WHERE post_title LIKE ? OR post_content LIKE ?";
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

    // Get post details (title, content, and image) by ID
    public function get_post_details($post_id) {
        try {
            $sql = "SELECT * FROM tbl_forum_posts WHERE post_id = :post_id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':post_id' => $post_id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return null;
        }
    }

    public function get_post_user($post_id) {
        $sql = "SELECT user_id FROM tbl_forum_posts WHERE post_id = :post_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':post_id', $post_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchColumn(); // Return the user_id
    }
    
}
?>
