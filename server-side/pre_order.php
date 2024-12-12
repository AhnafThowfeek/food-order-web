<?php
    include("./admin/connection.php");
    include("./admin/crud/read.php");
    $read = new Read();
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
   <title>Per Orders</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
<?php include("./components/admin_sidebar.php"); ?>
<section class="header-container">
    <h1>Pre Orders</h1>
    <?php
        $select_admin_role = $conn->prepare("SELECT role_name FROM roles r JOIN users u on r.id = u.role_id WHERE u.id = ? ");
        $select_admin_role->execute([$admin_id]);
        $admin_role = $select_admin_role->fetch(PDO::FETCH_ASSOC);
        if($admin_role['role_name'] == "admin"){
    ?>
    <div class="button-container">
        <button id="btn-add" class="btn add">Add A Pre Order</button>
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
<div class="add-container add-pre-order-container">
    <button id="btn-x" class="btn-x">X</button>
    <div class="add-pre-order">
        <?php
            $show_foods = $conn->prepare("SELECT * FROM `foods`");
            $show_foods->execute();
            $show_foods_row = $show_foods->fetchAll(PDO::FETCH_ASSOC);

            if(count($show_foods_row) > 0){
                foreach($show_foods_row as $food_index => $food_row){      
                    $food_image_path = htmlspecialchars($food_row['food_images_path']);
                    $full_price = htmlspecialchars($food_row['full_price']);   
                    $half_price = htmlspecialchars($food_row['half_price']);   
                    $cousin_type = htmlspecialchars($food_row['cousin_type_id']);   
                    $food_name = htmlspecialchars($food_row['food_name']);
                    $food_id = htmlspecialchars($food_row['id']);
                    $menu_name = htmlspecialchars($read->getMenu($food_row['menu_id'])['menu_name']);
        ?>
            <form action="./admin/controlles/crud_pre_order.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="food_id" value="<?=$food_id?>">
                <input type="hidden" name="req" value="pre_order">
                <img src="<?=$food_image_path?>" alt="<?=$food_name?>">
                <a href="#" class="cat"><?=$menu_name?></a>
                <div class="name"><?=$food_name?></div>
                <div class="flex">
                    <div class="price"><span>Rs.</span><?=$full_price?></div>
                    <div class="price"><span>Rs.</span><?=$half_price?></div>
                    <input type="number" name="qty" class="qty" min="1" max="99" value="1" onkeypress="if(this.value.length == 2) return false;">
                </div>
                <select name="user_id" required  class="box">
                    <option value="">Select Users</option>
                    <?php
                        $users = $conn->prepare("SELECT * FROM `users`");
                        $users->execute();
                        $users_row = $users->fetchAll(PDO::FETCH_ASSOC);
                        if(count($users_row ) > 0){
                            foreach($users_row as $user_index => $user_row){
                                $user_name = htmlspecialchars($user_row['user_name']);
                                $user_id = htmlspecialchars($user_row['id']);
                    ?>
                        <option value="<?=$user_id?>"><?=$user_name?></option>
                    <?php
                            }
                        } else {
                            echo "<option value='1' disabled>No Users Loaded</option>";
                        }
                    ?>
                </select>
                <input type="datetime-local"  required name="order_date" required placeholder="Enter Order date" class="box">
                <button type="submit">Add Pre Order</button>
            </form>
        <?php
                }
            }else{
                echo '<p class="empty">No foods added yet!</p>';
            }
        ?>
    </div>
</div>
<?php
    }
?>
<div class="show-container">
    <table>
        <tr>
            <th>ID</th>
            <th>Food</th>
            <th>User</th>
            <th>Date Time</th>
            <th>Is Confirm</th>
            <th>Is Cancel</th>
            <th>Created At</th>
            <th>Updated At</th>
            <th></th>
            <th></th>
        </tr>
        <?php
            $data = $conn->prepare("SELECT * FROM `pre_orders`");
            $data->execute();

            $rows = $data->fetchAll(PDO::FETCH_ASSOC);
            if(count($rows) > 0){
                foreach($rows as $index => $row){
                    $id = htmlspecialchars($row['id']);
                    $food = htmlspecialchars($read->getFoodById($row['food_id'])[0]["food_name"]);
                    $user = htmlspecialchars($read->getUserById($row['user_id'])[0]["user_name"]);
                    $datetime = htmlspecialchars($row['date_time']);
                    $confirm = htmlspecialchars($row['conformed']);
                    $cancel = htmlspecialchars($row['cancelling']);
                    $created_at = htmlspecialchars($row['created_at']);
                    $updated_at = htmlspecialchars($row['updated_at']);
        ?>
            <tr>
                <td><?= $id?></td>
                <td><?= $food?></td>
                <td><?= $user?></td>
                <td><?= $datetime?></td>
                <td><button id="btn-edit" class="btn edit" <?=$confirm == 1? 'disabled':''?> onclick="confirmOrder(<?= $id ?>)">Confirm</button></td>
                <td><button id="btn-delete" class="btn delete" <?=$cancel == 1 ? 'disabled':'' ?> onclick="cancelOrder(<?= $id ?>)">Cancel</button></td>
                <td><?= $created_at?></td>
                <td><?= $updated_at?></td>
                <td><button id="btn-edit" class="btn edit"><i class="fa-solid fa-user-pen" onclick="editOrder(<?= $id ?>)"></i></button></td>
                <td><button id="btn-delete" class="btn delete"><i class="fa-solid fa-user-xmark" onclick="deleteOrder(<?= $id ?>)"></i></button></td>
            </tr>
        <?php
                } 
            } else {
                echo "<td>No Menus</td>";
            }
        ?>
    </table>
</div>
<script src="js/script.js"></script>
</body>
</html>