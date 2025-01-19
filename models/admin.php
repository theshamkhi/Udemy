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
    public function deleteCat($catID) {
        try {
            $query1 = "UPDATE Courses SET CatID = 5 WHERE CatID = :catID";
            $stmt1 = $this->connection->prepare($query1);
            $stmt1->execute([':catID' => $catID]);
    
            $query2 = "DELETE FROM Categories WHERE CatID = :catID";
            $stmt2 = $this->connection->prepare($query2);
            $stmt2->execute([':catID' => $catID]);
        } catch (PDOException $e) {
            throw new Exception("Database error: " . $e->getMessage());
        }
    }

    public function createTag($name) {
        try {
            $query = "INSERT INTO Tags (TagName) 
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
}
?>

