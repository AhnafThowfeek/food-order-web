<?php

$host = "localhost";
$database_name = "gallery_cafe";
$database_username = "gallery_cafe_admin";
$db_user_password = "";

try{
    $conn = new PDO("mysql:host=$host;dbname=$database_name", $database_username, $db_user_password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Connection is Success ";
} catch(PDOExcepiton $e) {
    echo "Connection failed: " . $e->getMessage();
}

?>