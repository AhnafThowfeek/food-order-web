<?php
include("../connection.php");

class Update{
    private $conn;

    function __construct(){
        $this->conn = $GLOBALS['conn'];
    }
    function updatePreOrderConfirm($id){
        try {
            $get_data = $this->conn->prepare("SELECT conformed FROM `pre_orders` WHERE id=?");
            $get_data->execute([$id]);

            $data = $get_data->fetch(PDO::FETCH_ASSOC);

            $put_data = $this->conn->prepare("UPDATE `pre_orders` SET conformed=?  WHERE id=?");
            $put_data->execute([!(boolean)$data['conformed'],$id]);

            if ($put_data->rowCount() > 0) {
                return ["message" => "Update Success."];
            }
            return ["message" => "Update Failed."];
        } catch (PDOException $e) {
            return ["error" => $e->getMessage()];
        }
    }
    function updatePreOrderCancel($id){
        try {
            $get_data = $this->conn->prepare("SELECT cancelling FROM `pre_orders` WHERE id=?");
            $get_data->execute([$id]);

            $data = $get_data->fetch(PDO::FETCH_ASSOC);

            $put_data = $this->conn->prepare("UPDATE `pre_orders` SET cancelling=?  WHERE id=?");
            $put_data->execute([!(boolean)$data['cancelling'],$id]);

            if ($put_data->rowCount() > 0) {
                return ["message" => "Update Success."];
            }
            return ["message" => "Update Failed."];
        } catch (PDOException $e) {
            return ["error" => $e->getMessage()];
        }
    }
    function updateFoodAvailable($id){
        try {
            $get_data = $this->conn->prepare("SELECT is_available FROM `foods` WHERE id=?");
            $get_data->execute([$id]);

            $data = $get_data->fetch(PDO::FETCH_ASSOC);

            $put_data = $this->conn->prepare("UPDATE `foods` SET is_available=?  WHERE id=?");
            $put_data->execute([!(boolean)$data['is_available'],$id]);

            if ($put_data->rowCount() > 0) {
                return ["message" => "Update Success."];
            }
            return ["message" => "Update Failed."];
        } catch (PDOException $e) {
            return ["error" => $e->getMessage()];
        }
    }
}
