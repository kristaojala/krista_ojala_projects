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

try {
    $pdo_conn = new PDO("mysql:host=$servername;dbname=$databasename", $dbusername, $dbpassword);
    $pdo_conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

require_once "edit_include_files/product_operations.inc.php";


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $id = $_POST['ProductID'];

    $newData = [
        'ProductName' => $_POST['ProductName'],
        'Description' => $_POST['Description'],
        'Price' => $_POST['Price'],
        'ImageURL' => '', 
        ];
    
        if (isset($_FILES["NewImage"]) && $_FILES["NewImage"]["error"] == UPLOAD_ERR_OK) {

            $targetFolder = "media/";
            if (!file_exists($targetFolder)) {
                die("Folder not set up on the server!");
            }
    
            $fileName = pathinfo($_FILES["NewImage"]["name"], PATHINFO_FILENAME);
            $fileName = basename($fileName);
            $fileName = str_replace(' ', '_', $fileName);
    
            $imageFileType = strtolower(pathinfo($_FILES["NewImage"]["name"], PATHINFO_EXTENSION));
    
            $allowedExtensions = ["jpg", "png"];
            if (!in_array($imageFileType, $allowedExtensions)) {
                die("Error: Not allowed filetype!");
            }
    
            $maxFileSize = 50 * 1024 * 1024;
    
            if ($_FILES["NewImage"]["size"] > $maxFileSize) {
                die("Error: File exceeds the maximum size!");
            }

        $targetFile = $targetFolder . $fileName . "." . $imageFileType;

                if (move_uploaded_file($_FILES["NewImage"]["tmp_name"], $targetFile)) {
                    $newData['ImageURL'] = $fileName . "." . $imageFileType;
        
                    updateProductDetails($pdo_conn, $id, $newData);
                } 
            } else {
                $existingProductData = getProductDetails($pdo_conn, $id);
                $newData['ImageURL'] = $existingProductData['ImageURL'];
            
                updateProductDetails($pdo_conn, $id, $newData);
            }
        }
    

 if(isset($_GET['ProductID'])){
    $productId = $_GET['ProductID'];
    $productDetails = getProductDetails($pdo_conn, $productId);
}

else{
    header("Location: admin_products.php");
        die();
}

    ?>
    <html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/style.css">
    <link rel="shortcut icon" href="media/favicon.png" type="image/x-icon">
    <title>Edit Product - Admin</title>
</head>
<body>
  <?php include 'header.php' ?>
  <main class="simple-column ">
    <a href="admin_products.php">Back to Product Listing</a>
      <h2 class="center ">Edit Item: <?php echo $productDetails['ProductName']  ?></h2>
     <br>
    <div class="center">

    <form action="edit_product_admin.php" method="post" class="less-wide register" enctype="multipart/form-data">
    <label for="ProductId">Item ID:</label>
    <input type="text" name="ProductID" value="<?= $productDetails['ProductID'] ?>" readonly>

    <label for="ProductName">Item Name:</label>
    <input type="text" name="ProductName" value="<?= htmlspecialchars($productDetails['ProductName']) ?>" required>

    <label for="Description">Description:</label>
    <textarea name="Description" rows="4" required><?= htmlspecialchars($productDetails['Description']) ?></textarea>

    <label for="Price">Price:</label>
    <input type="text" name="Price" value="<?= htmlspecialchars($productDetails['Price']) ?>" required>

    <label for="ImageURL">Current Image:</label>
    <img class="product-img" src="media/<?= htmlspecialchars($productDetails['ImageURL']) ?>" alt="Product Image">
    
    <label for="NewImage">New Image:</label>
    <input type="file" name="NewImage" accept="image/*">

    <input type="submit" name="submit" value="Update" class="button">
</form>

    </div>
    </main>
    <?php include 'footer.php' ?>
</body>
</html>