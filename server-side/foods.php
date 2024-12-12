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
   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>orders</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
<?php include("./components/admin_sidebar.php"); ?>
<section class="header-container">
    <h1>Foods</h1>
    <div class="button-container">
        <button id="btn-add" class="btn add">Add A Food</button>
    <div>
</section>
<hr />
<div class="add-container">
    <button id="btn-x" class="btn-x">X</button>
    <div class="add-box">
            <h3>Add Foods Now</h3>
            <form action="./admin/controlles/crud_foods.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="req" value="food"/>
                <input type="text" name="food_name" required placeholder="Enter Food Name" class="box" maxlength="100">
                <input type="number" name="full_price" required placeholder="Enter Full Price of the Food" class="box" maxlength="100" oninput="this.value = this.value.replace(/\s/g, '')">
                <input type="number" name="half_price"  placeholder="Enter Half Price of the Food" class="box" maxlength="100" oninput="this.value = this.value.replace(/\s/g, '')">
                <select name="meals_id" class="box">
                    <option value="">Select Meal</option>
                    <?php
                        $meals = $conn->prepare("SELECT * FROM `meals`");
                        $meals->execute();

                        $rows = $meals->fetchAll(PDO::FETCH_ASSOC);
                        if(count($rows) > 0){
                            foreach($rows as $index => $row){
                                $meal_id = htmlspecialchars($row['id']);
                                $meal_name = htmlspecialchars($row['meals_name']);
                    ?>
                            <option value="<?= $meal_id?>"><?= $meal_name ?></option>
                    <?php
                            } 
                        } else {
                            echo "<option value='1' disabled>No Meals</option>";
                        }
                    ?>
                </select>
            
                <select name="menu_id" required class="box">
                    <option value="">Select Menu</option>
                    <?php
                        $menus = $conn->prepare("SELECT * FROM `menu_categories`");
                        $menus->execute();

                        $rows = $menus->fetchAll(PDO::FETCH_ASSOC);
                        if(count($rows) > 0){
                            foreach($rows as $index => $row){
                                $menu_id = htmlspecialchars($row['id']);
                                $menu_name = htmlspecialchars($row['menu_name']);
                    ?>
                            <option value="<?= $menu_id?>"><?= $menu_name ?></option>
                    <?php
                            } 
                        } else {
                            echo "<option value='1' disabled>No Menus</option>";
                        }
                    ?>
                </select>

                <input type="file" name="photo" accept=".jpg, .jpeg, .png" required class="box">
                <select name="cousin_types_id" class="box">
                    <option value="">Select Cousin Type</option>
                    <?php
                        $cousintypes = $conn->prepare("SELECT * FROM `cousin_type`");
                        $cousintypes->execute();

                        $rows = $cousintypes->fetchAll(PDO::FETCH_ASSOC);
                        if(count($rows) > 0){
                            foreach($rows as $index => $row){
                                $cousin_id = htmlspecialchars($row['id']);
                                $cousin_name = htmlspecialchars($row['cousin_type_name']);
                    ?>
                            <option value="<?= $cousin_id?>"><?= $cousin_name ?></option>
                    <?php
                            } 
                        } else {
                            echo "<option value='1' disabled>No Cousin Types</option>";
                        }
                    ?>
                </select>

                <div>
                    <label>Availability:</label>
                    <label for="availability_yes">Yes</label>
                    <input type="radio" id="availability_yes" name="availability" value="1" required>
                    <label for="availability_no">No</label>
                    <input type="radio" id="availability_no" name="availability" value="0" required>
                </div>
            
                <div>
                    <label>Pre Order:</label>
                    <label for="preorder_yes">Yes</label>
                    <input type="radio" id="preorder_yes" name="pre_order" value="1" required>
                    <label for="preorder_no">No</label>
                    <input type="radio" id="preorder_no" name="pre_order" value="0" required>
                </div>
                <button type="submit">Add Food</button>
            </form>
            <div>
        </div>
    </div>
</div>

<div class="add-foods-categories-container">
    <div class="add-menu">
        <h3>New Menu</h3>
        <form action="./admin/controlles/crud_foods.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="req" value="menu"/>
                <input type="text" name="menu_name" required placeholder="Enter Menu Name" class="box" maxlength="100">
                <button type="submit">Add Menu</button>
        </form>
    </div>
    <div class="add-meal">
        <h3>New Meal</h3>
        <form action="./admin/controlles/crud_foods.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="req" value="meal"/>
            <input type="text" name="meal_name" required placeholder="Enter meal Name" class="box" maxlength="100">
            <button type="submit">Add Meal</button>
        </form>
    </div>
    <div class="add-cousintype">
        <h3>New Cousin Type</h3>
        <form action="./admin/controlles/crud_foods.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="req" value="cousintype"/>
            <input type="text" name="cousintype_name" required placeholder="Enter Cousin Type Name" class="box" maxlength="100">
            <button type="submit">Add Cousin Type</button>
        </form>
    </div>
</div>

<!-- Display foods -->
<section class="show-foods" style="padding-top: 0;">
   <div class="box-container">
   <?php
      $show_foods = $conn->prepare("SELECT * FROM `foods`");
      $show_foods->execute();

      $rows = $show_foods->fetchAll(PDO::FETCH_ASSOC);

      if(count($rows) > 0){
         foreach($rows as $index => $row){      
            $food_image_path = htmlspecialchars($row['food_images_path']);
            $full_price = htmlspecialchars($row['full_price']);   
            $half_price = htmlspecialchars($row['half_price']);   
            $cousin_type = htmlspecialchars($row['cousin_type_id']);   
            $food_name = htmlspecialchars($row['food_name']);
            $id = htmlspecialchars($row['id']);
            $available = htmlspecialchars($row['is_available']);
   ?>
        <div class="box <?= (boolean)$available? '':'unable'?>">
            <img src="<?=  $food_image_path?>" alt="<?=$food_name?>">
            <div class="flex">
                <div class="price"><span>Rs.</span><?=  $full_price ?><span>/-</span></div>
                <div class="price"><span>Rs.</span><?= $half_price ?><span>/-</span></div>
                <div class="cat"><?= $cousin_type ?></div>
            </div>
            <div class="name"><?= $food_name  ?></div>
            <div class="flex-btn">
                <a class="option-btn">Update</a>
                <?php
                    if((boolean)$available){
                ?>
                    <a class="delete-btn" onclick="availableFood(<?= $id?>)">Unable</a>
                <?php   
                    } else {
                ?>
                    <a class="delete-btn available" onclick="availableFood(<?= $id?>)">Available</a>
                <?php    
                    }
                ?>
            </div>
        </div>
   <?php
         }
      }else{
         echo '<p class="empty">No foods added yet!</p>';
      }
   ?>
   </div>
</section>
<script src="js/script.js"></script>
</body>
</html>