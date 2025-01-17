<?php
require_once '../config/db.php';
require_once 'user.php';


class Student extends User {
    public function __construct() {
        parent::__construct();
    }

    public function joinCourse($courseID) {
        try {
            $studentID = $_SESSION['user_id'];
            $query = "INSERT INTO Enrollments (CourseID, StudentID) 
                      VALUES (:courseID, :studentID)";
            $stmt = $this->connection->prepare($query);
            $stmt->execute([':courseID' => $courseID, ':studentID' => $studentID]);
    
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return "Failed to enroll: " . $e->getMessage();
        }
    }
    public function getCourseDetails() {

    }
    public function getMyCourses() {
        try {
            $studentID = $_SESSION['user_id'];
            $query = "SELECT courses.*, enrollments.StudentID
                    FROM enrollments
                    JOIN courses ON courses.CourseID = enrollments.CourseID
                    WHERE enrollments.StudentID = :studentID";
            $stmt = $this->connection->prepare($query);
            $stmt->execute([':studentID' => $studentID]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return "Failed to enroll: " . $e->getMessage();
        }
    }
}
?>

