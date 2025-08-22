<?php



session_start();

$servername = "mysql_db";
$databasename = "verkkokauppa";
$dbusername = "root";
$dbpassword = "root";

try {
    $pdo_conn = new PDO("mysql:host=$servername;dbname=$databasename", $dbusername, $dbpassword);
    $pdo_conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

$query = "SELECT * FROM products";
$stmt = $pdo_conn->prepare($query);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
$stmt = null;

if (isset($_POST["itemID"])) {
    $ProductID = filter_var($_POST["itemID"], FILTER_VALIDATE_INT);

    if ($ProductID !== false && $ProductID > 0) { 
        $newProduct = [
            "itemID" => $ProductID,
            "Quantity" => 1,
        ];

        $productExists = false;

        
    }
    if (isset($_SESSION["product"]) && count($_SESSION["product"]) > 0) {
        foreach ($_SESSION["product"] as &$existingProduct) {
           
            $itemID = $existingProduct["itemID"];
            $stmt = $pdo_conn->prepare("SELECT ProductName, Price FROM products WHERE ProductID = :itemID");
            $stmt->bindParam(':itemID', $itemID, PDO::PARAM_INT);
            $stmt->execute();
            $productDetails = $stmt->fetch(PDO::FETCH_ASSOC);
    
            $existingProduct["ProductName"] = $productDetails["ProductName"];
            $existingProduct["Price"] = $productDetails["Price"];
    
            if ($existingProduct["itemID"] === $newProduct["itemID"]) {
                $existingProduct["Quantity"]++;
                $productExists = true;
                break;
            }
        }
    
        if (!$productExists) {
            $newProduct["Quantity"] = 1; 
            $_SESSION["product"][] = $newProduct;
        }
    } else {
        $_SESSION["product"][] = $newProduct;
    }
}


header("Location: cart.php");
exit();
?>
