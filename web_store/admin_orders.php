<?php
session_start();

if (!isset($_SESSION["user_id"]) || $_SESSION["user_type"] !== "Admin") {
    header("Location: index.php");
    exit();
}

$servername = "localhost";
$databasename = "verkkokauppa";
$username = "root";
$password = "";

try {
    $pdo_conn = new PDO("mysql:host=$servername;dbname=$databasename", $username, $password);
    $pdo_conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $query = $pdo_conn->prepare("SELECT orders.*, 
                                       GROUP_CONCAT(products.ProductName, ' (', orderitems.Quantity, 'pcs) ' SEPARATOR ', ') AS Items, 
                                       IFNULL(users.FirstName, orders.NotRegisteredUserAddress) AS FirstName, 
                                       IFNULL(users.LastName, '') AS LastName, 
                                       IFNULL(users.Email, '') AS Email, 
                                       IFNULL(users.Address, '') AS Address
                                 FROM orders
                                 LEFT JOIN orderitems ON orders.OrderID = orderitems.OrderID
                                 LEFT JOIN products ON orderitems.ProductID = products.ProductID
                                 LEFT JOIN users ON orders.UserID = users.UserID
                                 GROUP BY orders.OrderID"); 
    $query->execute();
    $orders = $query->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Connection failed:" . $e->getMessage();
    exit();
}

$operationResult = ""; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($_POST['status'] as $orderID => $newStatus) {
        $updateQuery = $pdo_conn->prepare("UPDATE orders SET Status = :newStatus WHERE OrderID = :orderID");
        $updateQuery->bindParam(':newStatus', $newStatus, PDO::PARAM_STR);
        $updateQuery->bindParam(':orderID', $orderID, PDO::PARAM_INT);
        $updateQuery->execute();
    }

    header("Location: admin_orders.php");
    exit();
}

?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/style.css">
    <link rel="shortcut icon" href="media/favicon.png" type="image/x-icon">
    <title>Admin - Orders</title>
</head>
<body>
<?php
include "header.php";
?>
<main class="simple-column">
    <h1>Admin - Orders Page</h1>
    <div class="admin-links">
        <a href="admin.php">Admin - Main</a>
        <a href="admin_products.php">Admin - Products Page</a>
        <a href="admin_users.php">Admin - Users Page</a>
    </div>
<h2 class="center">Orders</h2>

<br>

    <table class="admin-table">
        <th>Order ID</th>
        <th>Date</th>
        <th>Items</th>
        <th>Price</th>
        <th>Ship to</th>
        <th>Current Status</th>
        <th>Change Status</th>

        <form action="admin_orders.php" method="post">
        <?php
   foreach ($orders as $order) {
    $statusClass = strtolower($order["Status"]);

    echo "<tr class='$statusClass'>";
    echo "<td>" . $order["OrderID"] . "</td>";
    echo "<td>" . $order["OrderDate"] . "</td>";
    echo "<td>" . $order["Items"] . "</td>";
    echo "<td>" . $order["TotalPrice"] . " €" . "</td>";
    echo "<td>" . $order["FirstName"] . " " . $order["LastName"] . "<br>" . $order["Address"] . "<br> <br>" . $order["Email"] . "</td>";
    echo "<td>" . $order["Status"] . "</td>";

    echo "<td>";
    echo "<select name='status[" . $order['OrderID'] . "]'>";
    $statusOptions = ['Pending', 'Shipped', 'Delivered'];
    foreach ($statusOptions as $option) {
        echo "<option value='$option'" . ($option === $order['Status'] ? ' selected' : '') . ">$option</option>";
    }
    echo "</select>";
    echo "<br> <br>";
    echo "<input type='submit' value='Update Status'>";
    echo "</td>";

    echo "</tr>";
}
?>
</form>
    </table>
</main>
<?php
include "footer.php";
?>
</body>
</html>
