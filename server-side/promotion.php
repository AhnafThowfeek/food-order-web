<?php
    include("./admin/connection.php");
    session_start();

    $admin_id = $_SESSION['admin_id'];

    if(!isset($admin_id)){
        header('location:./admin/admin_login.php');
    }

    $select_admin_role = $conn->prepare("SELECT role_name FROM roles r JOIN users u on r.id = u.role_id WHERE u.id = ? ");
    $select_admin_role->execute([$admin_id]);
    $admin_role = $select_admin_role->fetch(PDO::FETCH_ASSOC);
    if($admin_role['role_name'] != "admin"){
        echo "<p>Only Admin Can Access</p>";
        exit();
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Promotions</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">


   <link rel="stylesheet" href="css/style.css">

</head>
<body>
<?php include("./components/admin_sidebar.php"); ?>
<section class="header-container">
    <h1>Promotion</h1>
    <div class="button-container">
        <button id="btn-add" class="btn add">Add A New Promotion</button>
    <div>
</section>
<hr />
<div class="add-container">
    <button id="btn-x" class="btn-x">X</button>
    <div class="add-box">
        <form action="./admin/controlles/crud_promotion.php" method="post" enctype="multipart/form-data">
            <h3>Add Promotion Now</h3>
            <input type="hidden" name="req" value="promotion"/>
            <input type="text" name="title" required placeholder="Enter Promotion title" class="box" maxlength="100">
            <input type="datetime-local" name="promotion_date" required placeholder="Enter the promotion date" class="box">
            <textarea type="text" name="details" required placeholder="details of the promotion" class="box" maxlength="254"></textarea>
            <input type="file" name="photo" accept=".jpg, .jpeg, .png" required class="box">
            <button type="submit">Add Promotion</button>
        </form>
    </div>
</div>

<section class="show-promotions" style="padding-top: 0;">
   <div class="box-container">
   <?php
      $show_promotions = $conn->prepare("SELECT * FROM `promotion`");
      $show_promotions->execute();

      $rows = $show_promotions->fetchAll(PDO::FETCH_ASSOC);

      if(count($rows) > 0){
         foreach($rows as $index => $row){      
            $promotion_image_path = htmlspecialchars($row['promotion_photo_path']);
            $promotion_title = htmlspecialchars($row['title']);   
            $promotion_date = htmlspecialchars($row['promotion_date']);   
            $promotion_details = htmlspecialchars($row['details']);   
          
   ?>
        <div class="box">
            <img src="<?=  $promotion_image_path?>" alt="">
            <div class="flex">
                <div class="price"><span>Title - </span><?=  $promotion_title ?></div>
                <div class="price"><span>Date - </span><?=  $promotion_date ?></div>
                
            </div>
            <div class="name"><?=  $promotion_details  ?></div>
            <div class="flex-btn">
                <a href="update_product.php?update=" class="option-btn">Update</a>
                <a href="promotion.php?delete=" class="delete-btn" onclick="return confirm('Delete this product?');">Delete</a>
            </div>
        </div>
   <?php
         }
      }else{
         echo '<p class="empty">No promotions added yet!</p>';
      }
   ?>
   </div>
</section>





<script src="js/script.js"></script>
</body>
</html>