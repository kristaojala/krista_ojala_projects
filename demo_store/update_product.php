<?php
session_start();

// Ladataan tuotteet JSON-tiedostosta
//Load products from JSON file
$filename = 'products.json';
$products = json_decode(file_get_contents($filename), true);

// Varmistetaan, että productID on määritelty
// Ensure that productID is defined
if (isset($_GET['productID'])) {
    $productID = $_GET['productID'];
    $productToUpdate = null;

    // Haetaan muokattava tuote
    // Search for the product to be edited
    foreach ($products as &$product) {
        if ($product['ProductID'] == $productID) {
            $productToUpdate = &$product;  // Viitataan suoraan tuotteeseen /Refers directly to the product
            break;
        }
    }

    // Jos tuote ei löytynyt
    // If product is not found
    if ($productToUpdate === null) {
        echo "Tuotetta ei löytynyt.";
        exit;
    }

    // Päivitetään tuote, kun lomake lähetetään
    // Updating the product when the form is submitted
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Päivitetään tuotteen tiedot POST:in avulla 
        // Updating product information using POST
        $productToUpdate['ProductName'] = $_POST['ProductName'];
        $productToUpdate['Description'] = $_POST['Description'];
        $productToUpdate['Price'] = $_POST['Price'];

        // Tallennetaan päivitetyt tuotteet takaisin JSON-tiedostoon
        // Saving updated products back to JSON file
        if (file_put_contents($filename, json_encode($products, JSON_PRETTY_PRINT))) {
            // Ohjataan takaisin admin-sivulle (header tulee ennen kaikkea muuta)
            // Redirected back to the admin page (header comes before everything else)
            header('Location: admin.php');
            exit();
        } else {
            echo "Virhe tuotteen päivittämisessä.";
        }
    }
} else {
    echo "Tuotteen ID ei ole määritelty.";
    exit();
}
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="media/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="style.css">
    <title>Päivitä tuote</title>
</head>
<body>
<h1>Päivitä tuote</h1>
<form method="post">
    <label for="ProductName">Tuotteen nimi:</label><br>
    <input type="text" name="ProductName" value="<?php echo htmlspecialchars($productToUpdate['ProductName']); ?>" required><br>
    
    <label for="Description">Kuvaus:</label><br>
    <textarea name="Description" required><?php echo htmlspecialchars($productToUpdate['Description']); ?></textarea><br>
    
    <label for="Price">Hinta (€):</label><br>
    <input type="number" step="0.01" name="Price" value="<?php echo htmlspecialchars($productToUpdate['Price']); ?>" required><br>
    <br>
    <button type="submit">Päivitä tuote</button>
</form>
</body>