<?php
session_start();

$servername = "localhost";
$databasename = "verkkokauppa";
$username = "root";
$password = "";

try {
    $DBconn = new PDO("mysql:host=$servername;dbname=$databasename", $username, $password); 
    $DBconn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (isset($_GET['ProductID'])) {
        $productId = $_GET['ProductID'];
        
        $query = $DBconn->prepare("SELECT * FROM products WHERE ProductID = :productId AND deleted_at IS NULL");
        $query->bindParam(':productId', $productId, PDO::PARAM_INT);
        $query->execute();
        
        $product = $query->fetch(PDO::FETCH_ASSOC);

        $DBconn = null;
    } else {
        header("Location: all_products.php");
        exit();
    }
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/style.css">
    <link rel="shortcut icon" href="media/favicon.png" type="image/x-icon">
    <title>Product Details</title>
</head>
<body>
<?php
    include "header.php";
    ?>
<main class="simple-column product-page">
    <h1>Product Details</h1>

    <?php
    if ($product) {
        ?>
        <div class="product-details">
            <h2><?php echo $product['ProductName']; ?></h2>
            <img class="product-img" src="media/<?php echo $product['ImageURL']; ?>" alt="Product Image">
            <p><?php echo $product['Description']; ?></p>
            <form action="add_to_cart.php" method="post">
            <div class="add-to-cart">
            <p class="product-price"><b>Price: <?php echo $product['Price']; ?>€</b></p>
           <?php echo "<p>Add to Cart</p>" .  "<input type='hidden' name='itemID' value='" . $product['ProductID'] . "'>
            <button type='submit'><img class='cart-logo' src='media/cart.png'></button>";
      ?>
        </div>
        </form>
        </div>
        <?php
    } else {
        echo "<p>Product not found.</p>";
    }
    ?>
    <p>Click <a href="all_products.php"><b>here</b></a> to see all our products.</p>
</main>

<?php
   include "footer.php";
   ?>
</body>
</html>