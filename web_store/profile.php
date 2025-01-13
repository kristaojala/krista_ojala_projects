<?php
session_start();
$servername = "localhost";
$databasename = "verkkokauppa";
$username = "root";
$password = "";

try {
    $DBconn = new PDO("mysql:host=$servername;dbname=$databasename", $username, $password);
    $DBconn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (isset($_SESSION["user_id"])) {
        $userID = $_SESSION["user_id"];
        $userQuery = $DBconn->prepare("SELECT * FROM users WHERE UserID = :userID");
        $userQuery->bindParam(':userID', $userID, PDO::PARAM_INT);
        $userQuery->execute();
        $userDetails = $userQuery->fetch(PDO::FETCH_ASSOC);
    }

    if (isset($userID)) {
        $orderQuery = $DBconn->prepare("SELECT * FROM orders WHERE UserID = :userID");
        $orderQuery->bindParam(':userID', $userID, PDO::PARAM_INT);
        $orderQuery->execute();
        $userOrders = $orderQuery->fetchAll(PDO::FETCH_ASSOC);
    }
} catch (PDOException $e) {
    echo "Connection failed:" . $e->getMessage();
} finally {
    $DBconn = null;
}
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/style.css">
    <link rel="shortcut icon" href="media/favicon.png" type="image/x-icon">
    <title>User Profile</title>
</head>
<body>
<?php
    include "header.php";
    ?>
    
<main class="simple-column">
<?php
   
   if (isset($userID)) {
        ?>
        
    <h2 class="center">Account Information</h2>
    <a href="edit_user.php?UserID=<?php echo $userID; ?>" class="center"><b>Edit Information</b></a>
    <div class="center">
    <table class="less-wide">
        <tr colspan="2"></tr>
    <tr>
        <th>First Name</th>
        <th>Last Name</th>
    </tr>
    <tr>
        <td><?php echo $userDetails["FirstName"]; ?></td>
        <td><?php echo $userDetails["LastName"]; ?></td>
    </tr>
    <tr>
        <th colspan="2">Email</th>
    </tr>
    <tr>
        <td colspan="2"><?php echo $userDetails["Email"]; ?></td>
    </tr>
    <tr>
        <th colspan="2">Address</th>
    </tr>
    <tr>
        <td colspan="2"><?php echo $userDetails["Address"]; ?></td>
    </tr>
</table>
</div>
<br>
<h2 class="center">Your Orders</h2>
<div class="center orders">
<?php
if (isset($userOrders) && $userOrders) {
    foreach ($userOrders as $order) {
        echo "<p>Order Date: " . $order["OrderDate"] ."<br>" ."Order ID: " . $order["OrderID"] ."<br>" . " Total Price: " . $order["TotalPrice"]. "€" ."<br>" . " Status: " . $order["Status"] . "</p>". "<br><br>";
    }
} else {
    echo "<p>No orders found.</p>";
}
?>
</div>
<?php
    }
 else {
  
    echo "<div class='user-page-login'>
    <p>Please log in to view your account information.</p>";
    if (isset($_GET["error"]) && $_GET["error"] == "login") {
        if (isset($_SESSION["errors_login"])) {
            foreach ($_SESSION["errors_login"] as $error) {
                echo "<p class='error-text'>$error</p>";
            }
        } else {
            echo "<p class='error-text'>E-mail and password do not match!</p>";
        }
    }
    echo "
    <form action='log_in.php' method='post'> 
    <input type='text' name='username' placeholder='Enter e-mail'>
    <input type='password' name='password' placeholder='Enter password'>
    <input type='submit' value='Log In' class='button' >
    </form>
    </div>"; ?>
    
    <p>Not a member yet? <a href="register.php"><b>Register a new account here!</b></a></p>
<?php 
    }
?>

</main>
<?php
   include "footer.php";
   ?>
</body>
</html>