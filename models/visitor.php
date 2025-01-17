<?php
require_once '../config/db.php';
require_once 'user.php';


class Visitor extends User {
    public function __construct() {
        parent::__construct();
    }

}
?>

