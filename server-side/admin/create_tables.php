<?php
include ("connection.php");

function createEventTable($conn){
    $query = "CREATE TABLE IF NOT EXISTS events (
            id INT NOT NULL AUTO_INCREMENT,
            title VARCHAR(100) NOT NULL,
            event_date DATETIME NOT NULL,
            details VARCHAR(255),
            event_photo_path VARCHAR(100),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id))";

    try{
        $conn->exec($query);
        echo "Table Created Successfully!";
    } catch (PDOException $e) {
        echo "Error Creating table: " . $e->getMessage();
    }
}

function createCusionTable($conn){
    $query = "CREATE TABLE IF NOT EXISTS cousin_type (
        id INT NOT NULL AUTO_INCREMENT,
        cousin_type_name VARCHAR(20) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (id))";

    try{
    $conn->exec($query);
    echo "Table Created Successfully!";
    } catch (PDOException $e) {
    echo "Error Creating table: " . $e->getMessage();
    }
}

function createMealsTable($conn){
    $query = "CREATE TABLE IF NOT EXISTS meals (
        id INT NOT NULL AUTO_INCREMENT,
        meals_name VARCHAR(50) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (id))";

    try{
    $conn->exec($query);
    echo "Table Created Successfully!";
    } catch (PDOException $e) {
    echo "Error Creating table: " . $e->getMessage();
    }
}

function createMenuCategoryTable($conn){
    $query = "CREATE TABLE IF NOT EXISTS menu_categories (
        id INT NOT NULL AUTO_INCREMENT,
        menu_name VARCHAR(20) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (id))";

    try{
    $conn->exec($query);
    echo "Table Created Successfully!";
    } catch (PDOException $e) {
    echo "Error Creating table: " . $e->getMessage();
    }
}

function createFoodsTable($conn){
    $query = "CREATE TABLE IF NOT EXISTS foods (
        id INT NOT NULL AUTO_INCREMENT,
        food_name VARCHAR(50) NOT NULL,
        full_price INT NOT NULL,
        half_price INT,
        cousin_type_id INT,
        is_available BOOLEAN DEFAULT 0,  
        meals_id INT,
        food_images_path VARCHAR(100),
        pre_order BOOLEAN DEFAULT 0,
        menu_id INT NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (id),
        FOREIGN KEY (cousin_type_id) REFERENCES  cousin_type(id),
        FOREIGN KEY (meals_id) REFERENCES  meals(id),
        FOREIGN KEY (menu_id) REFERENCES menu_categories(id)";

    try{
    $conn->exec($query);
    echo "Table Created Successfully!";
    } catch (PDOException $e) {
    echo "Error Creating table: " . $e->getMessage();
    }
}

function createRolesTable($conn){
    $query = "CREATE TABLE IF NOT EXISTS roles (
        id INT NOT NULL AUTO_INCREMENT,
        role_name VARCHAR(20) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (id))";

    $check_query = "SELECT COUNT(*) FROM `roles` WHERE `role_name` = :role_name";
    $stmt = $conn->prepare($check_query);
    $stmt->execute(['role_name' => 'admin']);
    $count = $stmt->fetchColumn();

    $add_role_query = "INSERT INTO `roles`(role_name) VALUES ('admin')";
    try{
    $conn->exec($query);
    if($count == 0){
        $conn->exec($add_role_query);
    }
    echo "Table Created Successfully!";
    } catch (PDOException $e) {
    echo "Error Creating table: " . $e->getMessage();
    }
}


function createUsersTable($conn){
    $query = "CREATE TABLE IF NOT EXISTS users (
        id INT NOT NULL AUTO_INCREMENT,
        user_name VARCHAR(20) NOT NULL,
        full_name VARCHAR(50) NOT NULL,
        email VARCHAR(320) NOT NULL UNIQUE,
        phone_number BIGINT(12) UNIQUE NOT NULL,
        password VARCHAR(255) NOT NULL,
        role_id INT NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (id),
        FOREIGN KEY (role_id) REFERENCES roles(id))";

    $add_user_admin = "INSERT INTO `users`(`user_name`, `full_name`, `email`, `phone_number`, `password`, `role_id`) VALUES ('admin','super admin','superadmin@admin.com','94756975862','admin123', 1);";
    
    try{
        $conn->exec($query);
        $conn->exec($add_user_admin);
        echo "Table Created Successfully!";
    } catch (PDOException $e) {
        echo "Error Creating table: " . $e->getMessage();
    }
}

function createPerOrdersTable($conn){
    $query = "CREATE TABLE IF NOT EXISTS pre_orders (
        id INT NOT NULL AUTO_INCREMENT,
        food_id INT NOT NULL,
        user_id INT NOT NULL,
        date_time DATETIME NOT NULL,
        conformed BOOLEAN DEFAULT 0,
        cancelling BOOLEAN DEFAULT 0,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (id),
        FOREIGN KEY (food_id) REFERENCES foods(id),
        FOREIGN KEY (user_id) REFERENCES users(id))";
    try{
    $conn->exec($query);
    echo "Table Created Successfully!";
    } catch (PDOException $e) {
    echo "Error Creating table: " . $e->getMessage();
    }
}

function createTablesTable($conn){
    $query = "CREATE TABLE IF NOT EXISTS tables (
        id INT NOT NULL AUTO_INCREMENT,
        table_no INT NOT NULL,
        number_of_seats INT NOT NULL,
        is_availabile BOOLEAN DEFAULT 0,
        reservation_time DATETIME NOT NULL,
        user_id INT NOT NULL,
        table_images_path VARCHAR(100),
        conformed BOOLEAN DEFAULT 0,
        cancelling BOOLEAN DEFAULT 0,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (id),
        FOREIGN KEY (user_id) REFERENCES users(id))";
    try{
    $conn->exec($query);
    echo "Table Created Successfully!";
    } catch (PDOException $e) {
    echo "Error Creating table: " . $e->getMessage();
    }
}


function createPromotionTable($conn){
    $query = "CREATE TABLE IF NOT EXISTS promotion (
        id INT NOT NULL AUTO_INCREMENT,
        title VARCHAR(100) NOT NULL,
        promotion_date DATETIME NOT NULL,
        details VARCHAR(255),
        promotion_photo_path VARCHAR(100),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (id))";
    try{
        $conn->exec($query);
        echo "Table Created Successfully!";
    } catch (PDOException $e) {
        echo "Error Creating table: " . $e->getMessage();
    }
}

createEventTable($conn);
createMealsTable($conn);
createMenuCategoryTable($conn);
createCusionTable($conn);
createFoodsTable($conn);
createRolesTable($conn);
createUsersTable($conn);
createPerOrdersTable($conn);
createTablesTable($conn);
createPromotionTable($conn);