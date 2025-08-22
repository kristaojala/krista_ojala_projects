<?php
session_start();
if (!isset($_SESSION['orderConfirmed'])) {
    header("Location: index.php");
    exit();
}
$firstname = $_SESSION['firstname'] ?? '';
$lastname = $_SESSION['lastname'] ?? '';
$email = $_SESSION['email'] ?? '';
$address = $_SESSION['address'] ?? '';
$totalOrderPrice = $_SESSION['totalOrderPrice'] ?? '';

unset($_SESSION["product"]);
unset($_SESSION['orderConfirmed']);
unset($_SESSION['firstname']);
unset($_SESSION['lastname']);
unset($_SESSION['email']);
unset($_SESSION['address']);
unset($_SESSION['totalOrderPrice']);

$servername = "mysql_db";
$databasename = "verkkokauppa";
$dbusername = "root";
$dbpassword = "root";

try {
    $pdo_conn = new PDO("mysql:host=$servername;dbname=$databasename", $username, $password);
    $pdo_conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed:" . $e->getMessage();
}

?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/style.css">
    <link rel="shortcut icon" href="media/favicon.png" type="image/x-icon">
    <title>Order Confirmed</title>
</head>
<body>
    
<?php
    include "header.php";
?>

<main class="simple-column">
    <h2>Order confirmed</h2>
    <p>Your order has been confirmed. <br>
    We have sent a comfirmation email to <?php echo $email ?> </p> 
    <p>Your order will be shipped out in next 2-3 business days to address:</p>
   <?php echo "<p>".$firstname . " ". $lastname . "<br>" 
   . $address . "</p>" ?>
    <p> Thank you for doing business with Lorem Ipsum!</p>
    <div class="back-to-main">
    <a href="index.php"><button class="button">Back to Front Page</button></a>
    </div>
</main>

<?php
include "footer.php";
?>
</body>
</html>
