<?php
    include("./admin/connection.php");
    include("./admin/crud/read.php");
    $read = new Read();
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
   <title>Users</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

  
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
<?php include("./components/admin_sidebar.php"); ?>
<section class="header-container">
    <h1>Users</h1>
    <div class="button-container">
        <button id="btn-add" class="btn add">Add New User</button>
        <button id="btn-add-role" class="btn add">Add New User Role</button>
    <div>
</section>
<hr />
<div class="add-container-role">
    <button id="btn-x-role" class="btn-x">X</button>
    <div class="add-box-role">
        <form action="./admin/controlles/crud_users.php" method="post" enctype="multipart/form-data">
            <h3>Add New User Role</h3>
            <input type="hidden" name="req" value="role"/>
            <input type="text" name="role" required placeholder="Enter Role Name" class="box" maxlength="20" oninput="this.value = this.value.replace(/\s/g, '')">
            <button type="submit">Add User</button>
        </form>
    </div>
</div>
<div class="add-container">
    <button id="btn-x" class="btn-x">X</button>
    <div class="add-box">
        <form action="./admin/controlles/crud_users.php" method="post" enctype="multipart/form-data">
            <h3>Add User Now</h3>
            <input type="hidden" name="req" value="user"/>
            <input type="text" name="username" required placeholder="Enter your username" class="box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
            <input type="text" name="fullname" required placeholder="Enter your full name" class="box" maxlength="100">
            <input type="email" name="email" required placeholder="Enter your email" class="box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
            <input type="tel" name="phone_number" required placeholder="Enter your phone number with 94" class="box" minlength="11" maxlength="11" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
            <input type="password" name="password" required placeholder="Enter your password" class="box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
            <select name="role_id" required class="box">
                <option value="">Select Role</option>
                <?php
                    $roles = $conn->prepare("SELECT * FROM `roles`");
                    $roles->execute();

                    $roles_row = $roles->fetchAll(PDO::FETCH_ASSOC);
                    if(count($roles_row) > 0){
                        foreach($roles_row as $index => $row){
                            $role_id = htmlspecialchars($row['id']);
                            $role_name = htmlspecialchars($row['role_name']);
                ?>
                    <option value="<?= $role_id?>"><?= $role_name ?></option>
                <?php
                        } 
                    } else {
                        echo "<option value='1' disabled>No roles</option>";
                    }
                ?>
            </select>
            <button type="submit">Add User</button>
        </form>
    </div>
</div>
<div class="show-container">
    <table>
        <tr>
            <th>ID</th>
            <th>User Name</th>
            <th>Full Name</th>
            <th>Email</th>
            <th>Phone Number</th>
            <th>Password</th>
            <th>Role</th>
            <th>Created At</th>
            <th>Updated At</th>
            <th></th>
            <th></th>
        </tr>
        <?php
            $users = $conn->prepare("SELECT * FROM `users`");
            $users->execute();

            $rows = $users->fetchAll(PDO::FETCH_ASSOC);
            if(count($rows) > 0){
                foreach($rows as $index => $row){
                    $user_id = htmlspecialchars($row['id']);
                    $username = htmlspecialchars($row['user_name']);
                    $fullname = htmlspecialchars($row['full_name']);
                    $email = htmlspecialchars($row['email']);
                    $phone_number = htmlspecialchars($row['phone_number']);
                    $password = htmlspecialchars($row['password']);
                    $created_at = htmlspecialchars($row['created_at']);
                    $updated_at = htmlspecialchars($row['updated_at']);
                    $role = htmlspecialchars($read->getRole($row['role_id'])['role_name']);
        ?>
            <tr>
                <td><?= $user_id?></td>
                <td><?= $username?></td>
                <td><?= $fullname?></td>
                <td><?= $email?></td>
                <td><?= $phone_number?></td>
                <td><?= $password?></td>
                <td><?= $role?></td>
                <td><?= $created_at?></td>
                <td><?= $updated_at?></td>
                <td><button id="btn-edit" class="btn edit"><i class="fa-solid fa-user-pen"></i></button></td>
                <td><button id="btn-delete" class="btn delete"><i class="fa-solid fa-user-xmark"></i></button></td>
            </tr>
        <?php
                } 
            } else {
                echo "<option value='1' disabled>No Menus</option>";
            }
        ?>
    </table>
</div>
<script src="js/script.js"></script>
</body>
</html>