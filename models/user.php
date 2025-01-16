<?php
require_once '../config/db.php';


abstract class User {
    protected static $userID;
    protected static $username;
    protected static $role;
    protected $name;
    protected $email;
    protected $password;
    protected $connection;

    public function __construct(DbConnection $dbConnection) {
        $this->connection = $dbConnection->getConnection();
    }

    public static function register(DbConnection $dbConnection, $name, $username, $email, $password, $role) {
        try {
            $connection = $dbConnection->getConnection();
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $query = "INSERT INTO users (Name, Username, Email, PasswordHash, Role) VALUES (:name, :username, :email, :password, :role)";
            $stmt = $connection->prepare($query);
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
    public static function login(DbConnection $dbConnection, $username, $password) {
        try {
            $connection = $dbConnection->getConnection();

            $query = "SELECT * FROM users WHERE Username = :username";
            $stmt = $connection->prepare($query);
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
    public static function getUserID() {
        return self::$userID;
    }

    public static function getUsername() {
        return self::$username;
    }

    public static function getRole() {
        return self::$role;
    }
    public function logout() {
        session_start();
        session_unset();
        session_destroy();
    }

    public function getDashboard() {
        return [
            'userID' => $this->userID,
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
            'message' => 'Welcome to your dashboard!'
        ];
    }
}

?>