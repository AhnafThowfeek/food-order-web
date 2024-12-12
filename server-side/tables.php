<?php
include("./admin/connection.php");
session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
    header('location:./admin/admin_login.php');
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Tables</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
<?php include("./components/admin_sidebar.php"); ?>
<section class="header-container">
    <h1>Tables</h1>
    <?php
        $select_admin_role = $conn->prepare("SELECT role_name FROM roles r JOIN users u on r.id = u.role_id WHERE u.id = ? ");
        $select_admin_role->execute([$admin_id]);
        $admin_role = $select_admin_role->fetch(PDO::FETCH_ASSOC);
        if($admin_role['role_name'] == "admin"){
    ?>
    <div class="button-container">
        <button id="btn-add" class="btn add">Add A Table Reservation</button>
    <div>
    <?php
        }
    ?>
</section>
<hr />
<?php
    $select_admin_role = $conn->prepare("SELECT role_name FROM roles r JOIN users u on r.id = u.role_id WHERE u.id = ? ");
    $select_admin_role->execute([$admin_id]);
    $admin_role = $select_admin_role->fetch(PDO::FETCH_ASSOC);
    if($admin_role['role_name'] == "admin"){
?>
<div class="add-container">
    <button id="btn-x" class="btn-x">X</button>
    <div class="add-box">
        <form action="./admin/controlles/crud_table.php" method="post" enctype="multipart/form-data">
            <h3>Add New Table</h3>
            <input type="hidden" name="req" value="tables">
            <input type="text" name="table_no" required placeholder="Enter Table Number" class="box" maxlength="50" >
            <input type="text" name="number_of_seats" required placeholder="Enter Number of Seats" class="box" maxlength="50" >
            <input type="text" name="user_id" required placeholder="Enter User ID" class="box" maxlength="50" >
            <input type="datetime-local" name="reservation_date" required placeholder="Enter Reservation date" class="box">
            <input type="file" name="photo" accept=".jpg, .jpeg, .png" required class="box">

            <div>
                <label>Availability:</label>
                <label for="confirm_yes">Yes</label>
                <input type="radio" id="confirm_yes" name="availability" value="1" required>
                <label for="confirm_no">No</label>
                <input type="radio" id="confirm_no" name="availability" value="0" required>
            </div>

            <div>
                <label>Confirmation:</label>
                <label for="confirm_yes">Confirm</label>
                <input type="radio" id="confirm_yes" name="confirmation" value="1" required>
                <label for="confirm_no">Cancel</label>
                <input type="radio" id="confirm_no" name="confirmation" value="0" required>
            </div>
            <button type="submit">Add Now</button>
        </form>
    </div>
</div>
<?php
    }
?>


<section class="show-tables" style="padding-top: 0;">
   <div class="box-container">
   <?php
      $show_tables = $conn->prepare("SELECT * FROM `tables`");
      $show_tables->execute();

      $rows = $show_tables->fetchAll(PDO::FETCH_ASSOC);

      if(count($rows) > 0){
         foreach($rows as $index => $row){      
            $table_image_path = htmlspecialchars($row['table_images_path']);
            $table_no = htmlspecialchars($row['table_no']);   
            $number_of_seats = htmlspecialchars($row['number_of_seats']);   
            $is_available = htmlspecialchars($row['is_availabile']);   
            $reservation_date = htmlspecialchars($row['reservation_time']);
            $user_id = htmlspecialchars($row['user_id']);
   ?>
        <div class="box">
            <img src="<?=  $table_image_path?>" alt="<?=$table_no?>">
            <div class="flex">
                <div class="number"><span>Table Number - </span><?=  $table_no ?></div>
                <div class="number"><span>Number of seats - </span><?=  $number_of_seats ?></div>
                <div class="cat"><?= $is_available ?></div>
            </div>
            <div class="name-date"><?= $reservation_date ?></div>
            <div class="name"><?= $user_id ?></div>
            <div class="flex-btn">
                <a href="update_product.php?update=" class="option-btn">Update</a>
                <a href="table.php?delete=" class="delete-btn" onclick="return confirm('Delete this product?');">Delete</a>
            </div>
        </div>
   <?php
         }
      }else{
         echo '<p class="empty">No tables added yet!</p>';
      }
   ?>
   </div>
</section>

<script src="js/script.js"></script>
</body>
</html>