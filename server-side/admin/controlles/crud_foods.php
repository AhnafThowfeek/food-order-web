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
                case "food":
                    // Extract and sanitize form data
                    $food_name = htmlspecialchars(trim($_POST['food_name']));
                    $full_price = htmlspecialchars(trim($_POST['full_price']));
                    $half_price = htmlspecialchars(trim($_POST['half_price']));
                    $meal_id = htmlspecialchars(trim($_POST['meals_id']));
                    $menu_id = htmlspecialchars(trim($_POST['menu_id']));
                    $cousin_types_id = htmlspecialchars(trim($_POST['cousin_types_id']));
                    $is_available = htmlspecialchars(trim($_POST['availability']));
                    $pre_order = htmlspecialchars(trim($_POST['pre_order']));

                    // Handle the file upload
                    if (isset($_FILES['photo'])) {
                        $photo = $_FILES['photo'];
                        $photo_name = $photo['name'];
                        $photo_tmp_name = $photo['tmp_name'];
                        $photo_size = $photo['size'];
                        $photo_error = $photo['error'];
                        $photo_type = $photo['type'];

                        // Validate file upload
                        if ($photo_error === UPLOAD_ERR_OK) {
                            $upload_dir = '../../content/upload/';
                            $upload_file_path = $upload_dir . basename($photo_name);

                            
                            $project_root = '/Assignment/server-side';
                            $base_url = 'http://' . $_SERVER['HTTP_HOST'] . $project_root;
                            $photo_url = $base_url . '/content/upload/' . basename($photo_name);
                            
                            // Move the uploaded file
                            if (move_uploaded_file($photo_tmp_name, $upload_file_path)) {
                                // Call method to add food
                                $result = $create->addFood($food_name, $full_price, $half_price, $cousin_types_id, $is_available, $meal_id, $pre_order, $photo_url, $menu_id);
                                
                                // Respond with success
                                $body = ["result" => $result];
                                header("Location: " . 'http://localhost/Assignment/server-side/foods.php');
                                echo json_encode($body);
                                // Optionally, redirect to the same page
                                exit;
                            } else {
                                echo json_encode(["error" => "Failed to upload file."]);
                            }
                        } else {
                            echo json_encode(["error" => "Error in file upload."]);
                        }
                    } else {
                        echo json_encode(["error" => "No file uploaded."]);
                    }
                    break;

                case "menu":
                    $menu_name = htmlspecialchars(trim($_POST['menu_name']));
                    $result = $create->addMenu($menu_name);
                    
                    // Respond with success
                    header("Location: " . 'http://localhost/Assignment/server-side/foods.php');
                    echo json_encode(["message" => $result]);
                    break;
                case "meal":
                    $meal_name = htmlspecialchars(trim($_POST['meal_name']));
                    $result = $create->addMeal($meal_name);
                    
                    // Respond with success
                    header("Location: " . 'http://localhost/Assignment/server-side/foods.php');
                    echo json_encode(["message" => $result]);
                    break;
                case "cousintype":
                    $cousintype_name = htmlspecialchars(trim($_POST['cousintype_name']));
                    $result = $create->addCousintype($cousintype_name);
                    
                    // Respond with success
                    header("Location: " . 'http://localhost/Assignment/server-side/foods.php');
                    echo json_encode(["message" => $result]);
                    break;
                case "available":
                    $id = htmlspecialchars(trim($_POST['id']));
                    $result = $update->updateFoodAvailable($id);
                    
                    echo json_encode($result);
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
