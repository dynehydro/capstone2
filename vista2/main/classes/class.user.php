<?php
class User {
    private $DB_SERVER = 'localhost';
    private $DB_USERNAME = 'root';
    private $DB_PASSWORD = '';
    private $DB_DATABASE = 'siremmanuel_db_wbapp';
    private $conn;

    public function __construct() {
        $this->conn = new PDO("mysql:host=" . $this->DB_SERVER . ";dbname=" . $this->DB_DATABASE, $this->DB_USERNAME, $this->DB_PASSWORD);
    }

    public function new_user($email, $password, $lastname, $firstname, $access = 'user') {
        $NOW = new DateTime('now', new DateTimeZone('Asia/Manila'));
        $NOW = $NOW->format('Y-m-d H:i:s');
        
        // Hash the password before storing it
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Check if this is the first user
        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM tbl_users");
        $stmt->execute();
        $user_count = $stmt->fetchColumn();

        // If it's the first user, set them as admin
        if ($user_count == 0) {
            $access = 'admin'; // Set first user as admin
        } else {
            $access = 'user'; // Default access level for other users
        }

        // Prepare data for insertion
        $data = [$lastname, $firstname, $email, $hashed_password, $NOW, $NOW, '1', $access];

        // Insert user into the database
        $stmt = $this->conn->prepare("INSERT INTO tbl_users (user_lastname, user_firstname, user_email, user_password, user_added, user_updated, user_status, user_access) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

        try {
            $this->conn->beginTransaction();
            $stmt->execute($data);
            $this->conn->commit();
        } catch (Exception $e) {
            $this->conn->rollback();
            throw $e;
        }

        return true;
    }

    public function update_user($lastname, $firstname, $access, $id) {
        $NOW = new DateTime('now', new DateTimeZone('Asia/Manila'));
        $NOW = $NOW->format('Y-m-d H:i:s');

        $sql = "UPDATE tbl_users SET user_firstname=:user_firstname, user_lastname=:user_lastname, user_updated=:user_updated, user_access=:user_access WHERE user_id=:user_id";

        $q = $this->conn->prepare($sql);
        $q->execute(array(':user_firstname' => $firstname, ':user_lastname' => $lastname, ':user_updated' => $NOW, ':user_access' => $access, ':user_id' => $id));

        return true;
    }

    public function list_users() {
        $sql = "SELECT * FROM tbl_users";
        $q = $this->conn->query($sql) or die("Failed to retrieve users.");
        $data = $q->fetchAll(PDO::FETCH_ASSOC);
        return empty($data) ? false : $data;
    }

    public function delete_user($id) {
        $sql = "DELETE FROM tbl_users WHERE user_id=:user_id";
        $q = $this->conn->prepare($sql);
        $q->execute(array(':user_id' => $id));
        return true;
    }

    function get_user_id($email) {
        $sql = "SELECT user_id FROM tbl_users WHERE user_email = :email";
        $q = $this->conn->prepare($sql);
        $q->execute(['email' => $email]);
        return $q->fetchColumn();
    }

    function get_user_email($id) {
        $sql = "SELECT user_email FROM tbl_users WHERE user_id = :id";
        $q = $this->conn->prepare($sql);
        $q->execute(['id' => $id]);
        return $q->fetchColumn();
    }

    function get_user_firstname($id) {
        $sql = "SELECT user_firstname FROM tbl_users WHERE user_id = :id";
        $q = $this->conn->prepare($sql);
        $q->execute(['id' => $id]);
        return $q->fetchColumn();
    }

    function get_user_lastname($id) {
        $sql = "SELECT user_lastname FROM tbl_users WHERE user_id = :id";
        $q = $this->conn->prepare($sql);
        $q->execute(['id' => $id]);
        return $q->fetchColumn();
    }

    function get_user_access($id) {
        $sql = "SELECT user_access FROM tbl_users WHERE user_id = :id";
        $q = $this->conn->prepare($sql);
        $q->execute(['id' => $id]);
        return $q->fetchColumn();
    }

    function get_user_status($id) {
        $sql = "SELECT user_status FROM tbl_users WHERE user_id = :id";
        $q = $this->conn->prepare($sql);
        $q->execute(['id' => $id]);
        return $q->fetchColumn();
    }

    function get_session() {
        return isset($_SESSION['login']) && $_SESSION['login'] === true;
    }

	public function check_login($email, $password) {
		$sql = "SELECT user_id, user_password, user_access FROM tbl_users WHERE user_email = :email";
		$q = $this->conn->prepare($sql);
		$q->execute(['email' => $email]);
	
		$user = $q->fetch(PDO::FETCH_ASSOC);
		
		if ($user && password_verify($password, $user['user_password'])) {
			$_SESSION['login'] = true;
			$_SESSION['user_email'] = $email;
			$_SESSION['user_id'] = $user['user_id'];  // Store user_id in session
			$_SESSION['user_access'] = $user['user_access'];  // Store user_access in session
			return true;
		} else {
			return false;
		}
	}
	
    public function list_user_search($keyword) {
        try {
            $keyword = "%{$keyword}%";
            $sql = "SELECT * FROM tbl_users WHERE user_lastname LIKE ?";
            $q = $this->conn->prepare($sql);
            $q->bindValue(1, $keyword, PDO::PARAM_STR);
            $q->execute();

            $data = $q->fetchAll(PDO::FETCH_ASSOC);
            return empty($data) ? false : $data;
        } catch (PDOException $e) {
            return array();
        }
    }
}
?>
