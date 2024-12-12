<?php

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
   <title>Dashboard</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
<?php include("./components/admin_sidebar.php"); ?>
<section class="header-container">
    <h1>Dashboard</h1>
    <!-- <div class="button-container">
        <button id="btn-add-food" class="btn add"></button>
    <div> -->
</section>
<hr />

</body>
</html>