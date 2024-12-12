<?php
include("../crud/create.php");
include("../crud/read.php");
include("../crud/update.php");
include("../crud/delete.php");

$create = new Create();

switch ($_SERVER["REQUEST_METHOD"]) {
    case "POST":
        if (isset($_POST["req"])) {
            switch ($_POST["req"]) {
                case "user":
                    // Extract and sanitize form data
                    $username = htmlspecialchars(trim($_POST['username']));
                    $fullname = htmlspecialchars(trim($_POST['fullname']));
                    $email = htmlspecialchars(trim($_POST['email']));
                    $phone_number = htmlspecialchars(trim($_POST['phone_number']));
                    $password = htmlspecialchars(trim($_POST['password']));
                    $role_id = htmlspecialchars(trim($_POST['role_id']));

                    $result = $create->addUser($username, $fullname, $email, $phone_number, $password, $role_id);
                                
                    // Respond with success
                    $body = ["result" => $result];
                    header("Location: " . 'http://localhost/Assignment/server-side/users.php');
                    echo json_encode($body);
                    break;
                
                case "role":
                    // Extract and sanitize form data
                    $role = htmlspecialchars(trim($_POST['role']));

                    $result = $create->addRole($role);
                                
                    // Respond with success
                    $body = ["result" => $result];
                    header("Location: " . 'http://localhost/Assignment/server-side/users.php');
                    echo json_encode($body);
                    break;

                default:
                    echo json_encode(["error" => "Invalid request type."]);
                    break;
            }
        } else {
            echo json_encode(["error" => "No request type specified."]);
        }
        break;
    
    default:
        echo json_encode(["error" => "Invalid request method."]);
        break;
}
?>
