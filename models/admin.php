<?php
require_once '../config/db.php';
require_once 'user.php';


class Admin extends User {
    public function __construct() {
        parent::__construct();
    }

    public function manageAccounts($userID, $newStatus) {
        try {
            $query = "UPDATE users SET Status = :status WHERE UserID = :userID";
            $stmt = $this->connection->prepare($query);
            $stmt->execute([':status' => $newStatus, ':userID' => $userID]);
        } catch (PDOException $e) {
            error_log($e->getMessage());
        }
    }
    public function getAccounts(){
        try {
            $query = "SELECT * FROM users WHERE Role != 'Admin'";
            $stmt = $this->connection->prepare($query);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return [];
        }
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
    public function TotalCourses(){
        try {
            $query = "SELECT COUNT(*) AS TotalCourses FROM courses";
            $stmt = $this->connection->prepare($query);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return null;
        }
    }
    public function TotalCoursesByCat() {
        try {
            $query = "SELECT categories.CatName, COUNT(*) AS TotalCourses
                    FROM courses
                    JOIN categories ON categories.CatID = courses.CatID
                    GROUP BY courses.CatID";
            $stmt = $this->connection->query($query);
    
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return null;
        }
    }
    public function getCourseWithMostStudents() {
        try {
            $query = "SELECT courses.Title, COUNT(enrollments.StudentID) AS StudentCount
                    FROM courses
                    JOIN enrollments ON courses.CourseID = enrollments.CourseID
                    GROUP BY courses.CourseID
                    ORDER BY StudentCount DESC
                    LIMIT 1";
            $stmt = $this->connection->query($query);
    
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return null;
        }
    }
    
    
}
?>

