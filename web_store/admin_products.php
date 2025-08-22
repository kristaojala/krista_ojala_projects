<?php
session_start();

if (!isset($_SESSION["user_id"]) || $_SESSION["user_type"] !== "Admin") {
    header("Location: index.php");
    exit();
}

$servername = "mysql_db";
$databasename = "verkkokauppa";
$dbusername = "root";
$dbpassword = "root";

try{
    $pdo_conn = new PDO("mysql:host=$servername;dbname=$databasename", $dbusername, $dbpassword);
    $pdo_conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e){
    echo "Connection failed:" . $e->getMessage();
    exit();
}

require_once 'edit_include_files/product_operations.inc.php';

$operationResult = ""; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete'])) {
        $productIdToDelete = $_POST["product_id"];
        $operationResult = delete_product($pdo_conn, $productIdToDelete);
    }

    if (isset($_POST['restore'])) {
        $productIdToRestore = $_POST["product_id"];
        $operationResult = restore_product($pdo_conn, $productIdToRestore);
    }
    if (isset($_POST['addProduct'])) {
        $newProductData = [
            'ProductName' => $_POST['newProductName'],
            'Description' => $_POST['newDescription'],
            'Price' => $_POST['newPrice'],
            'ImageURL' => '', 
        ];
    
        if (isset($_FILES["newImage"]) && $_FILES["newImage"]["error"] == UPLOAD_ERR_OK) {
            $targetFolder = "media/";
    
            if (!file_exists($targetFolder)) {
                die("Folder not set up on the server!");
            }
    
            $fileName = pathinfo($_FILES["newImage"]["name"], PATHINFO_FILENAME);
            $fileName = basename($fileName);
            $fileName = str_replace(' ', '_', $fileName);
    
            $imageFileType = strtolower(pathinfo($_FILES["newImage"]["name"], PATHINFO_EXTENSION));
    
            $allowedExtensions = ["jpg", "png"];
            if (!in_array($imageFileType, $allowedExtensions)) {
                die("Error: Not allowed filetype!");
            }
    
            $maxFileSize = 50 * 1024 * 1024;
    
            if ($_FILES["newImage"]["size"] > $maxFileSize) {
                die("Error: File exceeds the maximum size!");
            }
    
            $targetFile = $targetFolder . $fileName . "." . $imageFileType;
    
            if (move_uploaded_file($_FILES["newImage"]["tmp_name"], $targetFile)) {
                $newProductData['ImageURL'] = $fileName . "." . $imageFileType;
                $operationResult = addNewProduct($pdo_conn, $newProductData);
            } else {
                $operationResult = "Error: Failed to move the uploaded file.";
            }
        } else {
            $operationResult = "Error: File not uploaded or other file-related error.";
        }
    }

}


try {
    $query = $pdo_conn->prepare("SELECT * FROM products");
    $query->execute();
    $productData = $query->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Query failed:" . $e->getMessage();
    exit();
}

?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/style.css">
    <link rel="shortcut icon" href="media/favicon.png" type="image/x-icon">
    <title>Admin - Products</title>
</head>
<body>
<?php
    include "header.php";
    ?>
    <main class="simple-column">
    <h1>Admin - Products Page</h1>
    <div class= "admin-links">
    <a href="admin.php">Admin - Main</a>
    <a href="admin_users.php">Admin - Users Page</a>
    <a href="admin_orders.php">Admin - Orders Page</a>
    </div>

    <h2  class="center">Products</h2>
    <div class="empty-space">
    <?php if(isset($operationResult)) { echo $operationResult; }  ?>
    </div>

    <table class='admin-table'>
        <tr>
            <th>ID</th>
            <th>Item</th>
            <th>Image</th>
            <th>Description</th>
            <th>Price</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
<?php
        
        foreach( $productData  as $product): ?>
            <tr <?php if( $product['deleted_at'] !== null ) echo "class='deleted'"; ?> > 
            <?php
            echo "<td>" .   $product["ProductID"] .  "</td>";
            echo "<td>" .   $product["ProductName"] .  "</td>";
            echo "<td>" ."<img src=media/". $product["ImageURL"] .">"."</td>";
            echo "<td>" ."<p>" . $product["Description"] . "</p>". "</td>";
            echo "<td>". "<p>" . $product["Price"] . " € </p>". "</td>";
            echo "<td class='edit_user_admin'>" ."<a href='edit_product_admin.php?ProductID=". $product["ProductID"] . "'>" . "Edit Item" . "</a>". "</td>";
            ?>
    <?php if($product['deleted_at'] === null): ?>
        <td class="delete_user"> 
        <form action="admin_products.php" method="post">
        <input type="hidden" name="product_id" value="<?= $product["ProductID"] ?>">
            <button class="admin-actions-button" name="delete" type="submit">Delete Item</button>
            </form>
            </td>
    <?php else: ?>
        <td class="restore_user"> 
        <form action="admin_products.php" method="post">
            <input type="hidden" name="product_id" value="<?= $product["ProductID"] ?>">
            <button class="admin-actions-button" name="restore" type="submit">Restore Item</button>
        </form>
        </td>
    <?php endif; ?>

            </tr> 
            <?php endforeach; ?>
           
        </table>
     
        <h2 class="center">Add New Product:</h2>
        <div class="center">
    <form class="less-wide register" action="admin_products.php" method="post" enctype="multipart/form-data">
        <label for="newProductName">Product Name:</label>
        <input type="text" name="newProductName" required>

        <label for="newDescription">Description:</label>
        <textarea name="newDescription" required></textarea>

        <label for="newPrice">Price:</label>
        <input type="text" name="newPrice" required>

        
        <label for="newImage">Choose an image:</label>
        <input type="file" name="newImage" accept="image/*">

        <br>

        <button class="button" type="submit" name="addProduct">Add Product</button>
    </form>
    </div>
    </main>
<?php
   include "footer.php";
   ?>
</body>
</html>