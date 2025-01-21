<?php
require_once '../config/db.php';


abstract class Course {
    protected $courseID;
    protected $title;
    protected $description;
    protected $content;
    protected $mediaURL;

    public function __construct($mediaURL) {
        $this->mediaURL = $mediaURL;
    }

    abstract public function displayMedia();
}

class VideoCourse extends Course {

    public function displayMedia() {
        $embedURL = preg_replace(
            '/https?:\/\/www\.youtube\.com\/watch\?v=([a-zA-Z0-9_-]+)/',
            'https://www.youtube.com/embed/$1',
            $this->mediaURL
        );
        return "<iframe width='560' height='315' src='$embedURL' frameborder='0' allowfullscreen></iframe>";
    }
    
}

class DocumentCourse extends Course {

    public function displayMedia() {
        return '<iframe src="' . $this->mediaURL . '" width="100%" height="600" style="border: none;"></iframe>';
    }
    
}





