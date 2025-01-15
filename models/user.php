<?php
require_once '../config/db.php';


class User {
    protected $connection;
    protected $userID;
    protected $name;
    protected $email;
    protected $username;
    protected $password;
    protected $role;

    public function __construct() {
        $db = new DbConnection();
        $this->connection = $db->getConnection();
    }

    public function login($username, $password) {
        try {
            $query = "SELECT * FROM users WHERE username = :username";
            $stmt = $this->connection->prepare($query);
            $stmt->execute([':username' => $username]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['Password'])) {
                $_SESSION['user_id'] = $user['UserID'];
                $this->userID = $user['UserID'];
                $this->name = $user['Name'];
                $this->username = $user['Username'];
                $this->role = $user['Role'];
                return $this;
            }

            return null;
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return null;
        }
    }

    public function getUserID() {
        return $this->userID;
    }

    public function getUsername() {
        return $this->username;
    }

    public function getRole() {
        return $this->role;
    }
}
?>

