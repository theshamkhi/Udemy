<?php
require_once '../config/db.php';
require_once 'user.php';
require_once 'course.php';


class Student extends User {
    public function __construct() {
        parent::__construct();
    }

    public function joinCourse($courseID) {
        try {
            $studentID = $_SESSION['user_id'];

            $query = "INSERT INTO Enrollments (CourseID, StudentID) VALUES (:courseID, :studentID)";
            $stmt = $this->connection->prepare($query);
            $stmt->execute([':courseID' => $courseID, ':studentID' => $studentID]);

            return "Enrollment successful!";
    
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return "Failed to enroll.";
        }
    }
    public function leaveCourse($courseID) {
        try {
            $studentID = $_SESSION['user_id'];
            $query = "DELETE FROM Enrollments 
                      WHERE CourseID = :courseID AND StudentID = :studentID";
            $stmt = $this->connection->prepare($query);
            $stmt->execute([':courseID' => $courseID, ':studentID' => $studentID]);
            header("Location: ../templates/myCourses.php");
    
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return "Failed to enroll: " . $e->getMessage();
        }
    }
    public function getCourseDetails($courseID) {
        try {
            $query = "SELECT users.Name, categories.CatName, courses.*, GROUP_CONCAT(tags.TagName) AS Tags
                      FROM courses
                      JOIN users ON users.UserID = courses.TeacherID
                      JOIN categories ON categories.CatID = courses.CatID
                      LEFT JOIN CourseTags ON CourseTags.CourseID = courses.CourseID
                      LEFT JOIN tags ON tags.TagID = CourseTags.TagID
                      WHERE courses.CourseID = :courseID
                      GROUP BY courses.CourseID";
    
            $stmt = $this->connection->prepare($query);
            $stmt->execute([':courseID' => $courseID]);
    
            $course = $stmt->fetch(PDO::FETCH_ASSOC);
    
            if ($course && !empty($course['Tags'])) {
                $course['Tags'] = explode(',', $course['Tags']);
            }
    
            if (preg_match('/(youtube)/', $course['MediaURL'])) {
                $course['MediaType'] = 'Video';
            } elseif (preg_match('/\.pdf$/', $course['MediaURL'])) {
                $course['MediaType'] = 'Document';
            } else {
                $course['MediaType'] = 'Unknown';
            }
    
            return $course;
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return "Failed to fetch course details.";
        }
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

