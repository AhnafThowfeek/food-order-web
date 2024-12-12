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
   <title>Events</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
<?php include("./components/admin_sidebar.php"); ?>
<section class="header-container">
    <h1>Events</h1>
    <div class="button-container">
        <button id="btn-add" class="btn add">Add A New Event</button>
    <div>
</section>
<hr />
<div class="add-container">
<button id="btn-x" class="btn-x">X</button>
<div class="add-box">

    <form action="./admin/controlles/crud_event.php" method="post" enctype="multipart/form-data">
        <h3>Add Events Now</h3>
        <input type="hidden" name="req" value="event"/>
        <input type="text" name="title" required placeholder="Enter Title of the Event" class="box" maxlength="100">
        <input type="datetime-local" name="event_date" required placeholder="Enter the event date" class="box">
        <textarea type="text" name="details" required placeholder="details of the events" class="box" maxlength="254"></textarea>
        <input type="file" name="photo" accept=".jpg, .jpeg, .png" required class="box">
        <button type="submit">Add Event</button>
    </form>
</div>
</div>


<section class="show-events" style="padding-top: 0;">
   <div class="box-container">
   <?php
      $show_events = $conn->prepare("SELECT * FROM `events`");
      $show_events->execute();

      $rows = $show_events->fetchAll(PDO::FETCH_ASSOC);

      if(count($rows) > 0){
         foreach($rows as $index => $row){      
            $event_image_path = htmlspecialchars($row['event_photo_path']);
            $event_title = htmlspecialchars($row['title']);   
            $event_date = htmlspecialchars($row['event_date']);   
            $event_details = htmlspecialchars($row['details']);   
          
   ?>
        <div class="box">
            <img src="<?=  $event_image_path?>" alt="">
            <div class="flex">
                <div class="price"><span>Title - </span><?=  $event_title ?></div>
                <div class="price"><span>Date - </span><?=  $event_date ?></div>
                
            </div>
            <div class="name"><?=  $event_details  ?></div>
            <div class="flex-btn">
                <a href="update_event.php?update=" class="option-btn">Update</a>
                <a href="event.php?delete=" class="delete-btn" onclick="return confirm('Delete this product?');">Delete</a>
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

<script src="./js/script.js"></script>
</body>
</html>