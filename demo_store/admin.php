<?php
session_start();

// Ladataan tuotteet JSON-tiedostosta
// Load products from JSON file
$filename = 'products.json';
$products = json_decode(file_get_contents($filename), true);

// Ladataan myyntitiedot JSON-tiedostosta
// Load sales info from JSON file
$salesFilename = 'sales.json';
$sales = file_exists($salesFilename) ? json_decode(file_get_contents($salesFilename), true) : [];

// Funktio tuotteen nimen hakemiseen ID:n perusteella
// Function to get product by ID
function getProductNameById($productId, $products) {
    foreach ($products as $product) {
        if ($product['ProductID'] == $productId) {
            return $product['ProductName'];
        }
    }
    return "Tuntematon tuote";
}

// Tuotteen lisääminen
// Adding product
if (isset($_POST['add_product'])) {
    $newProduct = [
        'ProductID' => count($products) + 1,
        'ProductName' => $_POST['product_name'],
        'Description' => $_POST['product_description'],
        'Price' => $_POST['product_price']
    ];
    $products[] = $newProduct;
    file_put_contents($filename, json_encode($products, JSON_PRETTY_PRINT));

    // Estetään lomakkeen uudelleenlähetys
    // Prevent reform submission
    header("Location: admin.php");
    exit();
}

// Tuotteen poistaminen
// Deleting product
if (isset($_GET['delete_product'])) {
    $productIdToDelete = $_GET['delete_product'];
    $products = array_filter($products, function ($product) use ($productIdToDelete) {
        return $product['ProductID'] != $productIdToDelete;
    });
    $products = array_values($products); // Indeksit korjataan uudelleen
    file_put_contents($filename, json_encode($products, JSON_PRETTY_PRINT));
}

// Myyntitiedoston tyhjentäminen
// Emptying the sales file
if (isset($_POST['clear_sales'])) {
    // Tyhjennetään myyntitiedosto
    // Empty the sales file
    file_put_contents($salesFilename, json_encode([], JSON_PRETTY_PRINT));
    header('Location: admin.php'); // Päivitetään sivu, jotta muutokset näkyvät heti / Update the page to immediately see the changes
    exit();
}
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Tuotetiedot ja Myynnit</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Admin</h1>
    <h2 style="justify-self: center;"> - Tuotetiedot ja Myynnit</h2>
<div class="container">
    <!-- Myynnit / Sales -->
    <h2>Viimeisimmät myynnit</h2>

    <div id="salesContainer">
        <p>Haetaan myyntitietoja...</p>
    </div>

<br>
    <!-- Tyhjennä myyntitiedot / Empty sale info -->
    <h3>Tyhjennä myyntitiedot</h3>
    <form action="admin.php" method="post">
        <button type="submit" name="clear_sales" onclick="return confirm('Haluatko varmasti tyhjentää myyntitiedot?')">Tyhjennä myyntitiedot</button>
    </form>
    </div>

    <div class="container admin-form">
    <!-- Tuotteiden hallinta / Product management -->
    <h2>Tuotteen lisäys</h2>
    <form action="admin.php" method="post">
        <label for="product_name">Tuotteen nimi:</label>
        <input type="text" id="product_name" name="product_name" required>
        <br>
        <label for="product_description">Kuvaus:</label>
        <textarea id="product_description" name="product_description" required></textarea>
        <br>
        <label for="product_price">Hinta (€):</label>
        <input type="number" id="product_price" name="product_price" step="0.01" required>
        <br>
        <button type="submit" name="add_product">Lisää tuote</button>
    </form>
    </div>


    <br>
    <div class="product-details">
    <h2>Tuotteet</h2>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Tuotteen nimi</th>
                <th>Kuvaus</th>
                <th>Hinta (€)</th>
                <th>Toiminta</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $product): ?>
                <tr>
                    <td><?php echo $product['ProductID']; ?></td>
                    <td><?php echo $product['ProductName']; ?></td>
                    <td><?php echo $product['Description']; ?></td>
                    <td><?php echo $product['Price']; ?></td>
                    <td>
                        <!-- Muokkauslinkki / Edit link -->
                        <a href="update_product.php?productID=<?php echo $product['ProductID']; ?>">Muokkaa</a>

                        <!-- Poistaminen / Deleting -->
                        <a href="admin.php?delete_product=<?php echo $product['ProductID']; ?>" onclick="return confirm('Haluatko varmasti poistaa tämän tuotteen?')">Poista</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    </div>
<br><br>

<script>
    // Funktio päivittää myyntitiedot
    // Function updates the sales info
    function fetchSalesData() {
        $.ajax({
            url: 'get_sales.php', // Haetaan myyntitiedot / Get sales info
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                var container = $('#salesContainer');
                container.empty(); // Tyhjennetään vanhat tiedot / Empty old info

                // Tarkistetaan virheilmoitus
                // Checking the error message
                if (data.error) {
                    container.append('<p>' + data.error + '</p>');
                }
                // Jos data on tyhjä lista
                // If date is an empty array
                else if (data.length === 0) {
                    container.append('<p>Ei myyntitietoja löytynyt.</p>');
                }
                // Jos data sisältää myyntitietoja
                // If data has sales info
                else {
                    var table = $(`
                        <table class="sales-table">
                            <thead>
                                <tr>
                                    <th>Tuote</th>
                                    <th>Aikaleima</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    `);
                    data.forEach(function(sale) {
                        var row = '<tr><td>' + sale.ProductName + '</td><td>' + sale.Timestamp + '</td></tr>';
                        table.find('tbody').append(row);
                    });
                    container.append(table);
                }
            },
            error: function() {
                $('#salesContainer').html('<p style="color:red;">Myyntitietojen haku epäonnistui.</p>');
            }
        });
    }

    // Päivitetään myyntitiedot joka 5. sekunti
    // Updates sales info every 5 seconds
    setInterval(fetchSalesData, 5000); // Hakee tiedot 5 sekunnin välein / Gets info every 5 seconds

    // Haetaan heti sivun latauduttua
    // Retrieved immediately after page loads
    $(document).ready(fetchSalesData);
</script>

</body>
</html>
