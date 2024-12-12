<?php
include('../admin/crud/read.php');
include("../admin/connection.php");
include("../admin/crud/create.php");

$read = new Read();
$create = new Create();

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    if (isset($_GET["req"])) {
        switch ($_GET["req"]) {
            case "foods":
                try {
                    // Fetch foods from the database
                    $foods = $read->getFoods();

                    // Set header for JSON response
                    header("Content-Type: application/json");
                    http_response_code(200);

                    echo json_encode([
                        "success" => true,
                        "data" => $foods
                    ]);
                } catch (Exception $e) {
                    // Handle any exceptions that occur
                    header("Content-Type: application/json");
                    http_response_code(500);
                    echo json_encode([
                        "success" => false,
                        "message" => "An error occurred: " . $e->getMessage()
                    ]);
                }
                break;

            case "event":
                try {
                    // Fetch foods from the database
                    $event = $read->getEvent();

                

                    // Set header for JSON response
                    header("Content-Type: application/json");
                    http_response_code(200);

                    echo json_encode([
                        "success" => true,
                        "data" => $event
                    ]);
                } catch (Exception $e) {
                    // Handle any exceptions that occur
                    header("Content-Type: application/json");
                    http_response_code(500);
                    echo json_encode([
                        "success" => false,
                        "message" => "An error occurred: " . $e->getMessage()
                    ]);
                }
                break;    


            case "promotion":
                try {
                    // Fetch foods from the database
                    $promotion = $read->getPromotion();

                

                    // Set header for JSON response
                    header("Content-Type: application/json");
                    http_response_code(200);

                    echo json_encode([
                        "success" => true,
                        "data" => $promotion
                    ]);
                } catch (Exception $e) {
                    // Handle any exceptions that occur
                    header("Content-Type: application/json");
                    http_response_code(500);
                    echo json_encode([
                        "success" => false,
                        "message" => "An error occurred: " . $e->getMessage()
                    ]);
                }
                break;   
                
            case "table":
                try {
                    // Fetch foods from the database
                    $table = $read->getTable();

                    // Set header for JSON response
                    header("Content-Type: application/json");
                    http_response_code(200);

                    echo json_encode([
                        "success" => true,
                        "data" => $table
                    ]);
                } catch (Exception $e) {
                    // Handle any exceptions that occur
                    header("Content-Type: application/json");
                    http_response_code(500);
                    echo json_encode([
                        "success" => false,
                        "message" => "An error occurred: " . $e->getMessage()
                    ]);
                }
                break;  

            default:
                // Handle invalid request types
                header("Content-Type: application/json");
                http_response_code(400);
                echo json_encode([
                    "success" => false,
                    "message" => "Invalid request type."
                ]);
                break;

           
        }
    } else {
        // Handle cases where no 'req' parameter is provided
        header("Content-Type: application/json");
        http_response_code(400);
        echo json_encode([
            "success" => false,
            "message" => "No request type specified."
        ]);
    }

} else if($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["req"])) {
        switch ($_POST["req"]) {
            case "customer":
                // Extract and sanitize form data
                $username = htmlspecialchars(trim($_POST['username']));
                $fullname = htmlspecialchars(trim($_POST['fullname']));
                $email = htmlspecialchars(trim($_POST['email']));
                $phone_number = htmlspecialchars(trim($_POST['phone_number']));
                $password = htmlspecialchars(trim($_POST['password']));

                $result = $create->addCustomer($username, $fullname, $email, $phone_number, $password);
                            
                // Respond with success
                $body = ["result" => $result];
                header("Location: " . 'http://localhost/Assignment/client-side/login.html');
                echo json_encode($body);
                break;
               
            case "login":
                // Extract and sanitize form data
                $email = htmlspecialchars(trim($_POST['email']));
                $password = htmlspecialchars(trim($_POST['password']));

                $result = $read->checkCustomerLogin($email, $password);
                            
                // Respond with success
                $body = $result;
                echo json_encode($body);
                break;

            case "getcustomer":
                // Extract and sanitize form data
                $id = htmlspecialchars(trim($_POST['id']));

                $result = $read->getCustomer($id);
                            
                // Respond with success
                $body = $result;
                echo json_encode($body);
                break;

            case "pre_orders":
                // Extract and sanitize form data
                $id = htmlspecialchars(trim($_POST['id']));

                $result = $read->getOrdersFromCustomers($id);
                            
                // Respond with success
                $body = $result;
                echo json_encode($body);
                break;

            default:
                // Handle invalid request types
                header("Content-Type: application/json");
                http_response_code(400);
                echo json_encode([
                    "success" => false,
                    "message" => "Invalid request type."
                ]);
                break;

           
        }
    } else {
        // Handle cases where no 'req' parameter is provided
        header("Content-Type: application/json");
        http_response_code(400);
        echo json_encode([
            "success" => false,
            "message" => "No request type specified."
        ]);
    }
} else {
    // Handle methods other than GET
    header("Content-Type: application/json");
    http_response_code(405);
    echo json_encode([
        "success" => false,
        "message" => "Method not allowed."
    ]);
}

?>
