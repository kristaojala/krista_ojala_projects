<?php
session_start();
$servername = "localhost";
$databasename = "verkkokauppa";
$username = "root";
$password = "";

try{
    $DBconn = new PDO("mysql:host=$servername;dbname=$databasename", $username, $password); 
    $DBconn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $query = $DBconn->prepare("SELECT * FROM products WHERE deleted_at IS NULL ORDER BY RAND() LIMIT 6");
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
    <title>Lorem Ipsum</title>
</head>
<body>
    <?php
    include "header.php";
    ?>

    <main>
 
      <div class="title-texts">
      <h1>Lorem Ipsum</h1>
      <h2>- Your lifestyle store <br>since 2023</h2>
        <p>Welcome to Lorem Ipsum, your ultimate destination for style, luxury, and convenience. <br>
       Whether you're looking for a touch of class, a unique accessory, or a perfect gift, we've got you covered. <br>
       Shop with us and elevate your lifestyle with our curated selection of timeless and captivating products.</p>
       <p>Click <a href="all_products.php"><b>here</b></a> to see our collection!</p>
      </div>
    
        <div class="random-items">
        <?php
        
        while($row = $query->fetch()){
            echo "<div class='product'>";
            echo "<div class='product-title'>";
            echo "<a href='product.php?ProductID=" . $row["ProductID"] . "'>" . $row["ProductName"] . "</a>";
            echo  "<p>" . $row["Price"] . "€ </p>";
            echo "</div>";
            echo "<div class='product-image'>";
            echo "<a href='product.php?ProductID="  . $row["ProductID"] . "'>"."<img src=media/". $row["ImageURL"] .">". "</a>";
            echo "</div>";
            echo "<div class='product-info'>";
            
            echo "<p>" . $row["Description"] . "</p>";
            echo "</div>";
            echo "</div>";
        }
        ?>
         </div>
       <div class="main-right-side">
        <a href="lottery.php">
            <img src="media/advertisement.png" alt="">
        </a>
       </div>
    </main>

   <?php
   include "footer.php";
   ?>

</body>
</html>
