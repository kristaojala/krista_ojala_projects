<?php
session_start();

// Ladataan tuotteet JSON-tiedostosta
// Load Products from JSON file
$filename = 'products.json';
$products = json_decode(file_get_contents($filename), true);

// Lasketaan ostoskorin sisältö
// Calculate contents of the cart
$totalItems = 0;
$totalPrice = 0.0;

if (isset($_SESSION["product"])) {
    foreach ($_SESSION["product"] as $item) {
        $totalItems += $item["Quantity"];
        $totalPrice += $item["Quantity"] * $item["Price"];
    }
}
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="media/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="style.css">
    <title>Kauppa</title>
</head>
<body>
    <h1>Kauppa</h1>
    
    <div class="container" id="top-container">

    <!-- Ostoskori-esikatselu / Cart preview -->
        <strong><?php echo $totalItems; ?> tuotetta</strong> (<?php echo number_format($totalPrice, 2); ?>€)
   
    <form action="clear_cart.php" method="post" >
        <button type="submit">Tyhjennä ostoskori</button>
    </form>
    </div>

    <div class="container">
    <?php
    if (!empty($products)) {
        foreach ($products as $product) {
            ?>
            <div class="product-details">
                <h2><?php echo $product['ProductName']; ?></h2>
                <p><?php echo $product['Description']; ?></p>
                <p class="product-price"><b>Price: <?php echo $product['Price']; ?>€</b></p>
                <form action="add_to_cart.php" method="post">
                    <input type="hidden" name="itemID" value="<?php echo $product['ProductID']; ?>">
                    <button type="submit">Osta</button>
                </form>
            </div>
            <?php
        }
    } else {
        echo "<p>Ei tuotteita.</p>";
    } ?>
    </div>
</body>
</html>
