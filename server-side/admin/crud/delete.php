<?php
include("../connection.php");

class Delete {
    private $conn;

    function __construct() {
        $this->conn = $GLOBALS['conn'];
    }

    function deleteFood($id) {
        $delete = $this->conn->prepare("DELETE FROM `foods` WHERE id = ?");
        $delete->execute([$id]);
        if($delete->rowCount() > 0){
             return ["message" => "Delete Food Success!"];
        }
        return ["message" => "Delete User Failed!"];
    }
}
?>
