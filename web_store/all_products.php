<?php
session_start();
$servername = "mysql_db";
$databasename = "verkkokauppa";
$dbusername = "root";
$dbpassword = "root";

try{
    $DBconn = new PDO("mysql:host=$servername;dbname=$databasename", $dbusername, $dbpassword); 
    $DBconn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $query = $DBconn->prepare("SELECT * FROM products WHERE deleted_at IS NULL");
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
    <title>All Products</title>
</head>
<body>

<?php
    include "header.php";
    ?>

<main class="simple-column">
      
<h1>Explore Our Collection</h1>
<h2>- Uncover Lifestyle Elegance</h2>

    <table>
        <tr>
            <th>Item</th>
            <th>Image</th>
            <th>Description</th>
            <th>Price</th>
        </tr>
<?php
        
        while($product = $query->fetch()){
            echo "<tr>";
            echo "<td>" ."<a href='product.php?ProductID=" . $product["ProductID"] . "'>" . "<b>" . $product["ProductName"] . "</b>" . "</a>". "</td>";
            echo "<td>" ."<a href='product.php?ProductID="  . $product["ProductID"] . "'>"."<img src=media/". $product["ImageURL"] .">". "</a>". "</td>";
            echo "<td>" ."<p>" . $product["Description"] . "</p>". "</td>";
            echo "<td>". "<p>" . $product["Price"] . " € </p>". "</td>";
            echo "</tr>";  
           
        }
        ?>
        </table>
      
        </main>

        <?php
   include "footer.php";
   ?>
</body>
</html>