<?php
require_once '../config/db.php';


class User {
    protected $userID;
    protected $username;
    protected $role;
    protected $name;
    protected $email;
    protected $password;
    protected $connection;

    public function __construct() {
        $db = new DbConnection();
        $this->connection = $db->getConnection();
    }

    public function register($name, $username, $email, $password, $role) {
        try {
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $query = "INSERT INTO users (Name, Username, Email, PasswordHash, Role) VALUES (:name, :username, :email, :password, :role)";
            $stmt = $this->connection->prepare($query);
            $stmt->execute([
                ':name' => $name,
                ':username' => $username,
                ':email' => $email,
                ':password' => $hashedPassword,
                ':role' => $role
            ]);
            return true;
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }
    public function login($username, $password) {
        try {
            $query = "SELECT * FROM users WHERE Username = :username";
            $stmt = $this->connection->prepare($query);
            $stmt->execute([':username' => $username]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['PasswordHash'])) {
                $_SESSION['user_id'] = $user['UserID'];
                $_SESSION['username'] = $user['Username'];
                $_SESSION['role'] = $user['Role'];
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }
    public function getDashboard() {
        try {
            $query = "SELECT * FROM courses";
            $stmt = $this->connection->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return [];
        }
    }
    public function getUser() {
    
        $userID = $_SESSION['user_id'];
        $query = "SELECT * FROM Users WHERE UserID = :userID";
        $stmt = $this->connection->prepare($query);
        $stmt->execute([':userID' => $userID]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
}

?>