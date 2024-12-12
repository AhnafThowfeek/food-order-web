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
                case "promotion":
                    // Extract and sanitize form data
                    $promotion_title = htmlspecialchars(trim($_POST['title']));
                    $promotion_date = htmlspecialchars(trim($_POST['promotion_date']));
                    $promotion_details = htmlspecialchars(trim($_POST['details']));

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
                                $result = $create->addPromotion($promotion_title, $promotion_date, $promotion_details, $photo_url);
                                
                                // Respond with success
                                $body = ["result" => $result];
                                header("Location: " . 'http://localhost/Assignment/server-side/promotion.php');
                                echo json_encode($body);
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
