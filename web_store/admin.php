<?php
session_start();

if (!isset($_SESSION["user_id"]) || $_SESSION["user_type"] !== "Admin") {
    header("Location: index.php");
    exit();
}
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/style.css">
    <link rel="shortcut icon" href="media/favicon.png" type="image/x-icon">
    <title>Admin Page</title>
</head>
<body>
<?php
    include "header.php";

    ?>
<main class="simple-column">
    <h1 class=" center">Admin Page</h1>
    <?php echo "<h2 class='center'>" ."Welcome, " . $_SESSION["username"] . "</h2>"; ?>
    <br>
    <div class="center">
    <div class= "admin-links">
    <a href="admin_products.php">Admin - Products Page</a>
    <br>
    <a href="admin_users.php">Admin - Users Page</a>
    <br>
    <a href="admin_orders.php">Admin - Orders Page</a>
   </div>
   </div>
   <div class="admin-main-space"></div>
</main>
<?php
   include "footer.php";
   ?>
</body>
</html>