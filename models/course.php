<?php
require_once '../config/db.php';


class Course {
    private $id;
    private $title;
    private $description;
    private $content;
    private $tags;
    private $category;

    public function __construct($id, $title, $description, $content, $tags, $category) {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->content = $content;
        $this->tags = $tags;
        $this->category = $category;
    }

    public function getDetails() {
        return [
            'title' => $this->title,
            'description' => $this->description,
            'content' => $this->content,
            'tags' => $this->tags,
            'category' => $this->category
        ];
    }

    public function updateDetails() {

    }

    public function deleteCourse() {

    }
}
?>