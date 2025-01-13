<?php
session_start();
$servername = "localhost";
$databasename = "verkkokauppa";
$username = "root";
$password = "";

try{
    $DBconn = new PDO("mysql:host=$servername;dbname=$databasename", $username, $password); 
    $DBconn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $keyword = strtolower($_GET['q']);

    $query = $DBconn->prepare("SELECT * FROM products WHERE (LOWER(ProductName) LIKE :keyword OR LOWER(Description) LIKE :keyword) AND deleted_at IS NULL");
    $query->bindValue(':keyword', '%' . $keyword . '%', PDO::PARAM_STR);
    $query->execute();
    $DBconn = null; 
}
catch(PDOException $e){
    echo "Connection failed:" . $e->getMessage();
}
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/style.css">
    <link rel="shortcut icon" href="media/favicon.png" type="image/x-icon">
    <title>Search results</title>
</head>
<body>
<?php
    include "header.php";
    ?>

<main class="simple-column">
<h2>Search Results: </h2>
<?php 
    if ($query->rowCount() > 0): 
    ?>
<table  class="less-wide">
    <tr>
    <th>Item</th>
    <th>Image</th>
    <th>Description</th>
    <th>Price</th>
    </tr>

<?php while ($row = $query->fetch()): ?>
    <tr>
        <td><a href='product.php?ProductID=<?= $row["ProductID"] ?>'><?= $row["ProductName"] ?></a></td>
        <td><a href='product.php?ProductID=<?= $row["ProductID"] ?>'><img src="media/<?= $row["ImageURL"] ?>"></a></td>
        <td><p><?= $row["Description"] ?></p></td>
        <td><p><?= $row["Price"] ?>€</p></td>
    </tr>
<?php endwhile; ?>
</table>
<?php else: ?>
<p>No products found!</p>
<?php endif; ?>
</main>

    <?php
   include "footer.php";
   ?>
</body>
</html>