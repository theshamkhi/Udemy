<?php
require_once '../config/db.php';
require_once 'user.php';


class Admin extends User {
    public function __construct() {
        parent::__construct();
    }

    public function validateTeacherAccount() {

    }

    public function createCat($name) {
        try {
            $query = "INSERT INTO Categories (CatName) 
                        VALUES (:name)";
            $stmt = $this->connection->prepare($query);
    
            $stmt->execute([
                ':name' => $name
            ]);
    
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return "Failed to create category: " . $e->getMessage();
        }
    }
    public function deleteCat() {

    }

    public function createTag() {

    }
}
?>

