<?php

include './connection.php';

session_start();

if(isset($_POST['submit'])){
   $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
   $pass = filter_var($_POST['pass'], FILTER_SANITIZE_STRING);

   try{
      $select_admin = $conn->prepare("SELECT * FROM users WHERE user_name = ? AND password = ?");
      $select_admin->execute([$name, $pass]);
      $admin = $select_admin->fetch(PDO::FETCH_ASSOC);
      
      if($admin){
         $_SESSION['admin_id'] = $admin['id'];
         header('location:../dashboard.php');
         exit();
      } else {
         $message[] = 'incorrect username or password!';
      }
   } catch(PDOException $e) {
      $message[] = 'Database Error! '. $e->getMessage();
   }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>login</title>


   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">


   <link rel="stylesheet" href="../css/style.css">

</head>
<body>

<?php
if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <button id="btn-x-role" class="btn-x" onclick="this.parentElement.remove();">X</button>
      </div>
      ';
   }
}
?>



<section class="form-container">

   <form action="" method="POST">
      <h3>login now</h3>
      <input type="text" name="name" maxlength="20" required placeholder="enter your username" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="pass" maxlength="20" required placeholder="enter your password" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="submit" value="login now" name="submit" class="btn">
   </form>

</section>




</body>
</html>