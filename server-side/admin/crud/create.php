<?php
define('BASE_PATH_CONNECTION', $_SERVER['DOCUMENT_ROOT'] . '/assignment/server-side/admin/');
include_once BASE_PATH_CONNECTION . "connection.php";
class Create{
    private $conn;

    function __construct(){
        $this->conn = $GLOBALS['conn'];
    }

    function addUser($username, $fullname, $email, $phone_number, $password, $role_id){
        $insert_data = $this->conn->prepare("INSERT INTO `users`(user_name, full_name, email, phone_number, password, role_id) VALUES(?,?,?,?,?,?)");
        $insert_data->execute([$username, $fullname, $email, $phone_number, $password, $role_id]);
        return "Add User Success!";
    }
    function addRole($role_name){
        $insert_data = $this->conn->prepare("INSERT INTO `roles`(role_name) VALUES(?)");
        $insert_data->execute([$role_name]);
        return "Add User Role Success!";
    }
    function addFood($food_name, $full_price, $half_price, $cousin_type_id, $is_available, $meal_id, $pre_order, $food_image_path, $menu_id){
        $insert_data = $this->conn->prepare("INSERT INTO `foods`(food_name, full_price, half_price, cousin_type_id, is_available, meals_id, pre_order, food_images_path, menu_id) VALUES(?,?,?,?,?,?,?,?,?)");
        $insert_data->execute([$food_name, (int)$full_price, (int)$half_price, (int)$cousin_type_id, (int)$is_available, (int)$meal_id, (int)$pre_order, $food_image_path, (int)$menu_id]);
        return "Add User Success!";
    }
    function addMenu($menu_name){
        $insert_data = $this->conn->prepare("INSERT INTO `menu_categories`(menu_name) VALUES(?)");
        $insert_data->execute([$menu_name]);
       
        return "Add Menu Success!";
    }
    function addMeal($meal_name){
        $insert_data = $this->conn->prepare("INSERT INTO `meals`(meals_name) VALUES(?)");
        $insert_data->execute([$meal_name]);
       
        return "Add Meal Success!";
    }
    function addCousintype($cousintype_name){
        $insert_data = $this->conn->prepare("INSERT INTO `cousin_type`(cousin_type_name) VALUES(?)");
        $insert_data->execute([$cousintype_name]);
       
        return "Add cousintype Success!";
    }
    function addEvent($event_title, $event_date, $event_details,$event_photo_path){
        $insert_cart = $this->conn->prepare("INSERT INTO `events`(title, event_date,details,event_photo_path) VALUES(?,?,?,?)");
        $insert_cart->execute([$event_title, $event_date, $event_details,$event_photo_path]);
        return "Add User Success!";
    }
    function addPreOrder($food_id, $user_id, $datetime){
        $insert_cart = $this->conn->prepare("INSERT INTO `pre_orders`(food_id, user_id, date_time) VALUES(?,?,?)");
        $insert_cart->execute([$food_id, $user_id, $datetime]);
        return "Add User Success!";
    }
    function addPromotion($promotion_title, $poromotion_date, $promotion_details,$promotion_photo_path){
        $insert_cart = $this->conn->prepare("INSERT INTO `promotion`(title, promotion_date,details,promotion_photo_path) VALUES(?,?,?,?)");
        $insert_cart->execute([$promotion_title, $poromotion_date, $promotion_details,$promotion_photo_path]);
        return "Add User Success!";
    }
    function addTable($table_no, $number_of_seats, $avalability,$reserve_time, $user, $table_images_path){
        $insert_cart = $this->conn->prepare("INSERT INTO `tables`(table_no,	number_of_seats, is_availabile,	reservation_time, user_id,	table_images_path) VALUES(?,?,?,?,?,?)");
        $insert_cart->execute([$table_no, $number_of_seats, $avalability,$reserve_time, $user, $table_images_path]);
        return "Add User Success!";
    }
    function addCustomer($username, $fullname, $email, $phone_number, $password){
        $get_data = $this->conn->prepare("SELECT id FROM `roles` WHERE role_name = ?");
        $get_data->execute(["customer"]);
    
        // Fetch results as an associative array
        $role_id = $get_data->fetch(PDO::FETCH_ASSOC);
        $insert_data = $this->conn->prepare("INSERT INTO `users`(user_name, full_name, email, phone_number, password, role_id) VALUES(?,?,?,?,?,?)");
        $insert_data->execute([$username, $fullname, $email, $phone_number, $password, (int)$role_id['id']]);
        return "Add Customer Success!";
    }
  
}

?>