<?php
include("../crud/create.php");
include("../crud/read.php");
include("../crud/update.php");
include("../crud/delete.php");

$create = new Create();
$update = new Update();

switch ($_SERVER["REQUEST_METHOD"]) {
    case "POST":
        if (isset($_POST["req"])) {
            switch ($_POST["req"]) {
                case "pre_order":
                    // Extract and sanitize form data
                    $food_id = htmlspecialchars(trim($_POST['food_id']));
                    $user_id = htmlspecialchars(trim($_POST['user_id']));
                    $datetime = htmlspecialchars(trim($_POST['order_date']));

                    $result = $create->addPreOrder($food_id, $user_id, $datetime);
                                
                    // Respond with success
                    $body = ["result" => $result];
                    header("Location: " . 'http://localhost/Assignment/server-side/pre_order.php');
                    echo json_encode($body);
                    break;
                case "confirm":
                    $id = htmlspecialchars(trim($_POST['id']));

                    $result = $update->updatePreOrderConfirm($id);
                                
                    // Respond with success
                    $body = $result;
                    echo json_encode($body);
                    break;

                case "cancel":
                    $id = htmlspecialchars(trim($_POST['id']));

                    $result = $update->updatePreOrderCancel($id);
                                
                    // Respond with success
                    $body = $result;
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
