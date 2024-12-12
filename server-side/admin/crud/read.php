<?php

class Read{
    private $conn;

    function __construct(){
        $this->conn = $GLOBALS['conn'];
    }
    function getFoods() {
        try {
            // Get Foods form `foods` table
            $get_data = $this->conn->prepare("SELECT * FROM `foods`");
            $get_data->execute();
    
            // Fetch all results as an associative array
            $foods = $get_data->fetchAll(PDO::FETCH_ASSOC);

            if ($foods) {
                return $foods;
            } else {
                return ["message" => "No foods found"];
            }
        } catch (PDOException $e) {
            return ["error" => $e->getMessage()];
        }
    }

    function getFoodById($id) {
        try {
            // Get Foods form `foods` table
            $get_data = $this->conn->prepare("SELECT * FROM `foods` WHERE id=?");
            $get_data->execute([$id]);
    
            // Fetch all results as an associative array
            $data = $get_data->fetchAll(PDO::FETCH_ASSOC);

            if ($data) {
                return $data;
            } else {
                return ["message" => "No foods found"];
            }
        } catch (PDOException $e) {
            return ["error" => $e->getMessage()];
        }
    }

    function getUserById($id) {
        try {
            // Get Foods form `foods` table
            $get_data = $this->conn->prepare("SELECT * FROM `users` WHERE id=?");
            $get_data->execute([$id]);
    
            // Fetch all results as an associative array
            $data = $get_data->fetchAll(PDO::FETCH_ASSOC);

            if ($data) {
                return $data;
            } else {
                return ["message" => "No Users found"];
            }
        } catch (PDOException $e) {
            return ["error" => $e->getMessage()];
        }
    }

    function getMenu($id){
        try {
            // Get Foods form `menu_categories` table
            $get_data = $this->conn->prepare("SELECT menu_name FROM `menu_categories` WHERE id=?");
            $get_data->execute([$id]);
    
            // Fetch results as an associative array
            $date = $get_data->fetch(PDO::FETCH_ASSOC);

            if ($date) {
                return $date;
            } else {
                return ["message" => "No Menu Found"];
            }
        } catch (PDOException $e) {
            return ["error" => $e->getMessage()];
        }
    }

    function getRole($id){
        try {
            // Get Foods form `menu_categories` table
            $get_data = $this->conn->prepare("SELECT role_name FROM `roles` WHERE id=?");
            $get_data->execute([$id]);
    
            // Fetch results as an associative array
            $data = $get_data->fetch(PDO::FETCH_ASSOC);

            if ($data) {
                return $data;
            } else {
                return ["message" => "No Menu Found"];
            }
        } catch (PDOException $e) {
            return ["error" => $e->getMessage()];
        }
    }
    function getEvent() {
        try {
            // Get Foods form `events` table
            $get_data = $this->conn->prepare("SELECT * FROM `events`");
            $get_data->execute();
    
            // Fetch all results as an associative array
            $event = $get_data->fetchAll(PDO::FETCH_ASSOC);

            if ($event) {
                return $event;
            } else {
                return ["message" => "No events found"];
            }
        } catch (PDOException $e) {
            return ["error" => $e->getMessage()];
        }
    }

    function getPromotion() {
        try {
            // Get Foods form `events` table
            $get_data = $this->conn->prepare("SELECT * FROM `promotion`");
            $get_data->execute();
    
            // Fetch all results as an associative array
            $promotion = $get_data->fetchAll(PDO::FETCH_ASSOC);

            if ($promotion) {
                return $promotion;
            } else {
                return ["message" => "No promotion found"];
            }
        } catch (PDOException $e) {
            return ["error" => $e->getMessage()];
        }
    }

    
    function getTable() {
        try {
            // Get tables form `table` table
            $get_data = $this->conn->prepare("SELECT * FROM `tables`");
            $get_data->execute();
    
            // Fetch all results as an associative array
            $table = $get_data->fetchAll(PDO::FETCH_ASSOC);

            if ($table) {
                return $table;
            } else {
                return ["message" => "No promotion found"];
            }
        } catch (PDOException $e) {
            return ["error" => $e->getMessage()];
        }
    }

    function checkCustomerLogin($email, $password) {
        try {
            // Get Foods form `foods` table
            $get_data = $this->conn->prepare("SELECT id FROM `users` WHERE email=? AND password=?");
            $get_data->execute([$email, $password]);
    
            // Fetch all results as an associative array
            $data = $get_data->fetch(PDO::FETCH_ASSOC);

            if ($data) {
                return $data;
            } else {
                return ["message" => "No Customer found"];
            }
        } catch (PDOException $e) {
            return ["error" => $e->getMessage()];
        }
    }
    function getCustomer($id) {
        try {
            // Get Foods form `foods` table
            $get_data = $this->conn->prepare("SELECT * FROM `users` WHERE id=?");
            $get_data->execute([$id]);
    
            // Fetch all results as an associative array
            $data = $get_data->fetch(PDO::FETCH_ASSOC);

            if ($data) {
                return $data;
            } else {
                return ["message" => "No Customer found"];
            }
        } catch (PDOException $e) {
            return ["error" => $e->getMessage()];
        }
    }
    function getFoodByIds($ids) {
        try {
            if (empty($ids)) {
                return ["message" => "No Any Orders for this Customer"];
            }
            $placeholders = implode(',', array_fill(0, count($ids), '?'));
            
            $get_data = $this->conn->prepare("SELECT * FROM `foods` WHERE id IN ($placeholders)");
            $get_data->execute($ids);
    
            $data = $get_data->fetchAll(PDO::FETCH_ASSOC);
    
            if ($data) {
                return $data;
            } else {
                return ["message" => "No Users found"];
            }
        } catch (PDOException $e) {
            return ["error" => $e->getMessage()];
        }
    }
    function getOrdersFromCustomers($id){
        try {
            // Get Foods form `foods` table
            $get_data = $this->conn->prepare("SELECT food_id FROM `pre_orders` WHERE user_id=?");
            $get_data->execute([$id]);
    
            // Fetch all results as an associative array
            $food_list = array_column($get_data->fetchAll(PDO::FETCH_ASSOC), "food_id");

            $data = $this->getFoodByIds($food_list);

            if ($data) {
                return $data;
            } else {
                return ["message" => "No Customer found"];
            }
        } catch (PDOException $e) {
            return ["error" => $e->getMessage()];
        }
    }
    
}

?>