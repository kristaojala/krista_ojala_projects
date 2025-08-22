<?php
session_start();
date_default_timezone_set('Europe/Helsinki');

// Ladataan tuotteet JSON-tiedostosta
// Load products from JSON file
$filename = 'products.json';
$products = json_decode(file_get_contents($filename), true);

// Ladataan myyntitiedot JSON-tiedostosta
// Load sales info from JSON file
$salesFilename = 'sales.json';
$sales = file_exists($salesFilename) ? json_decode(file_get_contents($salesFilename), true) : [];

// Lisää tuote ostoskoriin
// Add product to cart
if (isset($_POST["itemID"])) {
    $ProductID = filter_var($_POST["itemID"], FILTER_VALIDATE_INT);

    if ($ProductID !== false && $ProductID > 0) {
        // Etsitään tuote oikealla ProductID:llä
        //Find product with the right ProductID
        $product = null;
        foreach ($products as $p) {
            if ($p["ProductID"] == $ProductID) {
                $product = $p;
                break;
            }
        }

        // Jos tuotetta ei löydy
        // If product is not found
        if ($product === null) {
            echo "Tuotetta ei löydy.";
            exit();
        }

        // Lisätään uusi tuote ostoskoriin
        // Add new item to cart
        $newProduct = [
            "itemID" => $product["ProductID"],
            "ProductName" => $product["ProductName"],
            "Price" => $product["Price"],
            "Quantity" => 1
        ];

        $productExists = false;

        // Jos ostoskori on jo olemassa
        //If cart already exists
        if (isset($_SESSION["product"])) {
            foreach ($_SESSION["product"] as &$existingProduct) {
                if ($existingProduct["itemID"] === $ProductID) {
                    $existingProduct["Quantity"]++;
                    $productExists = true;
                    break;
                }
            }
            unset($existingProduct); // Hyvä käytäntö viittausten kanssa / Good practice with references

            // Jos tuotetta ei ollut vielä ostoskorissa
            // If product wasn't in the cart already
            if (!$productExists) {
                $_SESSION["product"][] = $newProduct;
            }
        } else {
            // Jos ostoskori ei ole vielä luotu
            // If cart wasn't made already
            $_SESSION["product"] = [$newProduct];
        }

        // Lisää myyntitieto
        // Add sale info
        $sales[] = [
            'ProductID' => $product["ProductID"],
            'ProductName' => $product["ProductName"],
            'Timestamp' => date('d.m.Y H:i:s')  // Aikaleima / Timestamp
        ];

        // Tallenna myyntitiedot JSON-tiedostoon
        // Save sale info to JSON file
        file_put_contents($salesFilename, json_encode($sales, JSON_PRETTY_PRINT));
    }
}

// Palaa takaisin kauppaan
// Return back to store
header("Location: index.php");
exit();
?>
