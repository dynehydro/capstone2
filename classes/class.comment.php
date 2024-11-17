<?php
class Comment {
    private $DB_SERVER = 'localhost';
    private $DB_USERNAME = 'root';
    private $DB_PASSWORD = '';
    private $DB_DATABASE = 'siremmanuel_db_wbapp';
    private $conn;

    public function __construct() {
        $this->conn = new PDO("mysql:host=" . $this->DB_SERVER . ";dbname=" . $this->DB_DATABASE, $this->DB_USERNAME, $this->DB_PASSWORD);
    }

    // Create a new comment for a post
    public function new_comment($post_id, $user_id, $comment_content) {
        try {
            $stmt = $this->conn->prepare("INSERT INTO tbl_forum_comments (post_id, user_id, comment_content) VALUES (?, ?, ?)");
            $stmt->execute([$post_id, $user_id, $comment_content]);
            return true;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    // Update an existing comment by ID
    public function update_comment($comment_id, $comment_content) {
        try {
            $sql = "UPDATE tbl_forum_comments SET comment_content = :comment_content WHERE comment_id = :comment_id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':comment_content' => $comment_content,
                ':comment_id' => $comment_id
            ]);
            return true;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    // Delete a comment by ID
    public function delete_comment($comment_id) {
        try {
            $sql = "DELETE FROM tbl_forum_comments WHERE comment_id = :comment_id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':comment_id' => $comment_id]);
            return true;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    // List all comments for a specific post
    public function list_comments_by_post($post_id) {
        try {
            $sql = "SELECT * FROM tbl_forum_comments WHERE post_id = :post_id ORDER BY comment_created_at DESC";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':post_id' => $post_id]);
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return empty($data) ? false : $data;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return [];
        }
    }

    // Get comment details by ID
    public function get_comment_details($comment_id) {
        try {
            $sql = "SELECT * FROM tbl_forum_comments WHERE comment_id = :comment_id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':comment_id' => $comment_id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return null;
        }
    }

    // Get the user ID of the author of a comment
    public function get_comment_user($comment_id) {
        try {
            $sql = "SELECT user_id FROM tbl_forum_comments WHERE comment_id = :comment_id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':comment_id', $comment_id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchColumn(); // Return the user_id
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return null;
        }
    }
}
?>
