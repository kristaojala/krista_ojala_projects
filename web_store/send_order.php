<?php
session_start();

if (!isset($_POST['confirmOrder'])) {
    header("Location: index.php");
    exit();
}

$servername = "mysql_db";
$databasename = "verkkokauppa";
$dbusername = "root";
$dbpassword = "root";

try {
    $pdo_conn = new PDO("mysql:host=$servername;dbname=$databasename", $dbusername, $dbpassword);
    $pdo_conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed:" . $e->getMessage();
}

$firstname = $_POST['firstname'] ?? '';
$lastname = $_POST['lastname'] ?? '';
$email = $_POST['email'] ?? '';
$address = $_POST['address'] ?? '';

if (isset($_SESSION["user_id"])) {
    $userID = $_SESSION["user_id"];
    $userQuery = $pdo_conn->prepare("SELECT * FROM users WHERE UserID = :userID");
    $userQuery->bindParam(':userID', $userID, PDO::PARAM_INT);
    $userQuery->execute();
    $userDetails = $userQuery->fetch(PDO::FETCH_ASSOC);

    if (empty($userDetails['Address'])) { //Jos ei ole vielä osoitetta niin nyt on.
        $updateAddressQuery = $pdo_conn->prepare("UPDATE users SET Address = :address WHERE UserID = :userID");
        $updateAddressQuery->bindParam(':address', $address, PDO::PARAM_STR);
        $updateAddressQuery->bindParam(':userID', $userID, PDO::PARAM_INT);
        $updateAddressQuery->execute();
    }
}

$userID = isset($_SESSION["user_id"]) ? $_SESSION["user_id"] : null;

$shipping = 8.95;
$totalOrderPrice = 0;

$notRegisteredUserAddress = "$firstname $lastname, $address, $email";

$orderQuery = $pdo_conn->prepare("INSERT INTO orders (UserID, OrderDate, TotalPrice, NotRegisteredUserAddress) VALUES (:userID, NOW(), :totalPrice, :notRegisteredUserAddress)");
$orderQuery->bindParam(':userID', $userID, PDO::PARAM_INT);

if (!$userID) { //rekisteröitymätön
    $orderQuery->bindParam(':notRegisteredUserAddress', $notRegisteredUserAddress, PDO::PARAM_STR);
} else { // rekisteröitynyt käyttäjä
    $orderQuery->bindValue(':notRegisteredUserAddress', null, PDO::PARAM_NULL);
}

$orderQuery->bindParam(':totalPrice', $totalOrderPrice, PDO::PARAM_STR);
$orderQuery->execute();

$orderID = $pdo_conn->lastInsertId();

foreach ($_SESSION["product"] as $cartItem) {
    $itemID = $cartItem["itemID"];
    $quantity = $cartItem["Quantity"];

    $stmt = $pdo_conn->prepare("SELECT Price FROM products WHERE ProductID = :itemID");
    $stmt->bindParam(':itemID', $itemID, PDO::PARAM_INT);
    $stmt->execute();
    $productDetails = $stmt->fetch(PDO::FETCH_ASSOC);

    $subtotal = $quantity * $productDetails["Price"];

    $orderItemQuery = $pdo_conn->prepare("INSERT INTO orderitems (OrderID, ProductID, Quantity, Subtotal) VALUES (:orderID, :itemID, :quantity, :subtotal)");
    $orderItemQuery->bindParam(':orderID', $orderID, PDO::PARAM_INT);
    $orderItemQuery->bindParam(':itemID', $itemID, PDO::PARAM_INT);
    $orderItemQuery->bindParam(':quantity', $quantity, PDO::PARAM_INT);
    $orderItemQuery->bindParam(':subtotal', $subtotal, PDO::PARAM_STR);
    $orderItemQuery->execute();

    $totalOrderPrice += $subtotal;
}

$totalOrderPrice += $shipping;

$updateTotalPriceQuery = $pdo_conn->prepare("UPDATE orders SET TotalPrice = :totalPrice WHERE OrderID = :orderID");
$updateTotalPriceQuery->bindParam(':totalPrice', $totalOrderPrice, PDO::PARAM_STR);
$updateTotalPriceQuery->bindParam(':orderID', $orderID, PDO::PARAM_INT);
$updateTotalPriceQuery->execute();

$_SESSION['orderID'] = $orderID;
$_SESSION['orderConfirmed'] = true;
$_SESSION['firstname'] = $firstname;
$_SESSION['lastname'] = $lastname;
$_SESSION['email'] = $email;
$_SESSION['address'] = $address;
$_SESSION['totalOrderPrice'] = $totalOrderPrice;

header("Location: confirmation.php");
exit();
?>