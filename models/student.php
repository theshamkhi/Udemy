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

    }
}
?>

