<?php
require_once '../config/db.php';
require_once 'user.php';


class Teacher extends User {
    public function __construct() {
        parent::__construct();
    }

    public function addCourse($title, $description, $media, $content, $category) {
        try {
            $teacherID = $_SESSION['user_id'];
            $query = "INSERT INTO courses (Title, Description, Content, TeacherID, CatID, MediaURL) 
                      VALUES (:title, :description, :content, :teacherID, :catID, :mediaURL)";
            $stmt = $this->connection->prepare($query);
    
            $stmt->execute([
                ':title' => $title,
                ':description' => $description,
                ':content' => $content,
                ':teacherID' => $teacherID,
                ':catID' => $category,
                ':mediaURL' => $media
            ]);
    
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return "Failed to create course: " . $e->getMessage();
        }

    }
    public function getMyCourses() {
        try {
            $teacherID = $_SESSION['user_id'];
            $query = "SELECT * FROM courses
                    WHERE TeacherID = :teacherID";
            $stmt = $this->connection->prepare($query);
            $stmt->execute([':teacherID' => $teacherID]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return "Failure :" . $e->getMessage();
        }
    }
    public function modifyCourse() {

    }
    public function deleteCourse($CourseID) {
        try {
            $teacherID = $_SESSION['user_id'];
            $query = "DELETE FROM courses WHERE CourseID = :courseID AND TeacherID = :teacherID";
            $stmt = $this->connection->prepare($query);
            $stmt->execute([
                ':courseID' => $CourseID,
                ':teacherID' => $teacherID
            ]);
        
        } catch (PDOException $e) {
            $this->connection->rollBack();
            error_log($e->getMessage());
            return false;
        }
    }

    public function getStats() {

    }
    public function getStudents(){

    }
}
?>

