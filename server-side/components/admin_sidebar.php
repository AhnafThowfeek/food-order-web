<?php 
    include("./admin/connection.php");
    $admin_id = $_SESSION['admin_id'];
?>
<nav class="sidebar">
    <a href="../client-side/home.html"  class="logo"><img src="./images/Gallery-Cafe.png" /></a>
    <a href="dashboard.php">Dashboard</a>
    <?php
        $select_admin_role = $conn->prepare("SELECT role_name FROM roles r JOIN users u on r.id = u.role_id WHERE u.id = ? ");
        $select_admin_role->execute([$admin_id]);
        $admin_role = $select_admin_role->fetch(PDO::FETCH_ASSOC);
        if($admin_role['role_name'] == "admin"){
    ?>
        <a href="event.php">Events</a>
        <a href="promotion.php">Promotions</a>
        <a href="foods.php">Foods</a>
    <?php
        }
    ?>
    <a href="pre_order.php">Pre Order</a>
    <a href="tables.php">Tables</a>
    <?php
        $select_admin_role = $conn->prepare("SELECT role_name FROM roles r JOIN users u on r.id = u.role_id WHERE u.id = ? ");
        $select_admin_role->execute([$admin_id]);
        $admin_role = $select_admin_role->fetch(PDO::FETCH_ASSOC);
        if($admin_role['role_name'] == "admin"){
    ?>
        <a href="users.php">Users</a>
    <?php
        }
    ?>
    <a href="admin/admin_logout.php" class="btn logout">Log Out</a>

</nav>