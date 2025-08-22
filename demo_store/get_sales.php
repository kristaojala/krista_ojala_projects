<?php
// Ladataan myyntitiedot JSON-tiedostosta
// Load sales info from JSON file
$salesFilename = 'sales.json';
$sales = file_exists($salesFilename) ? json_decode(file_get_contents($salesFilename), true) : [];

// Jos ei löydy myyntejä, palautetaan viesti
// If no sales, return message
if (empty($sales)) {
    echo json_encode(["error" => "Myyntitietoja ei löytynyt"]);
    exit;
}

// Ladataan tuotteet JSON-tiedostosta
// Load products from JSON file
$filename = 'products.json';
$products = json_decode(file_get_contents($filename), true);

// Rakennetaan myyntitiedot
// Build sales info
foreach ($sales as &$sale) {
    // Hae tuotteen nimi ID:n perusteella
    // Get product name by ID
    foreach ($products as $product) {
        if ($product['ProductID'] == $sale['ProductID']) {
            $sale['ProductName'] = $product['ProductName'];
            break;
        }
    }
}

// Palautetaan myyntitiedot JSON-muodossa
// Return sales info in JSON
echo json_encode($sales);
?>
