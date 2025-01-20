<?php
require_once '../config/db.php';
require_once 'user.php';


class Teacher extends User {
    public function __construct() {
        parent::__construct();
    }

    public function addCourse($title, $description, $photo, $contentType, $content, $category, $tags) {
        try {
            $teacherID = $_SESSION['user_id'];
    
            $query = "INSERT INTO courses (Title, Description, Photo, MediaType, MediaURL, Status, TeacherID, CatID) 
                      VALUES (:title, :description, :photo, :contentType, :content, 'Pending', :teacherID, :catID)";
            $stmt = $this->connection->prepare($query);
    
            $stmt->execute([
                ':title' => $title,
                ':description' => $description,
                ':photo' => $photo,
                ':contentType' => $contentType,
                ':content' => $content,
                ':teacherID' => $teacherID,
                ':catID' => $category,
            ]);
    
            $courseID = $this->connection->lastInsertId();
    
            if (!empty($tags)) {
                $tagQuery = "INSERT INTO CourseTags (CourseID, TagID) VALUES (:courseID, :tagID)";
                $tagStmt = $this->connection->prepare($tagQuery);
    
                foreach ($tags as $tagID) {
                    $tagStmt->execute([
                        ':courseID' => $courseID,
                        ':tagID' => $tagID
                    ]);
                }
            }
    
            return "Course successfully created!";
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
    public function updateCourse() {

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

