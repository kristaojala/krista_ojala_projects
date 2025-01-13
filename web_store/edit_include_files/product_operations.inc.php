<?php

function delete_product($pdo, $id) {
    try { 
        $stmt = $pdo->prepare("UPDATE products SET deleted_at = :deleted_time WHERE ProductID = :product_id");

        $deletedTime = date('Y-m-d H:i:s');
        $stmt->bindParam(':deleted_time', $deletedTime, PDO::PARAM_STR);
        $stmt->bindParam(':product_id', $id, PDO::PARAM_INT);

        $stmt->execute();
            
        return "Item deleted successfully!";
    } catch(PDOException $e) {
        return "error: $e";
    }
} 

function restore_product($pdo, $id) {
    try { 
        $stmt = $pdo->prepare("UPDATE products SET deleted_at = :deleted_time WHERE ProductID = :product_id");

        $deletedTime = null;
        $stmt->bindParam(':deleted_time', $deletedTime, PDO::PARAM_STR);
        $stmt->bindParam(':product_id', $id, PDO::PARAM_INT);

        $stmt->execute();
            
        return "Item restored successfully!";
    } catch(PDOException $e) {
        return "error: $e";
    }
} 
function getProductDetails($pdo, $productId){
    try {
        $stmt = $pdo->prepare("SELECT * FROM products WHERE ProductID = :product_id");

        $stmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
        $stmt->execute();
        $productDetails = $stmt->fetch(PDO::FETCH_ASSOC);

        return $productDetails;
    } catch(PDOException $e) {
        echo "error: $e";
    }
}


function updateProductDetails($pdo, $productId, $newData) {
    try {
        $productname = $newData['ProductName'];
        $description = $newData['Description'];
        $price = (string) $newData['Price'];
        $imageurl = $newData['ImageURL'];

        $stmt = $pdo->prepare("UPDATE products SET ProductName = :productname, Description = :description, Price = :price, ImageURL = :imageurl WHERE ProductID = :product_id");

        $stmt->bindParam(':productname', $productname, PDO::PARAM_STR);
        $stmt->bindParam(':description', $description, PDO::PARAM_STR);
        $stmt->bindParam(':price', $price, PDO::PARAM_STR);
        $stmt->bindParam(':imageurl', $imageurl, PDO::PARAM_STR);
        $stmt->bindParam(':product_id', $productId, PDO::PARAM_INT);

        $stmt->execute();
    } catch (PDOException $e) {
        echo "error: $e";
    }
}

function addNewProduct($pdo, $newProductData) {
    try {
        $stmt = $pdo->prepare("INSERT INTO products (ProductName, Description, Price, ImageURL) VALUES (:productName, :description, :price, :imageurl)");

        $stmt->bindParam(':productName', $newProductData['ProductName'], PDO::PARAM_STR);
        $stmt->bindParam(':description', $newProductData['Description'], PDO::PARAM_STR);
        $stmt->bindParam(':price', $newProductData['Price'], PDO::PARAM_STR);
        $stmt->bindParam(':imageurl', $newProductData['ImageURL'], PDO::PARAM_STR);

        $stmt->execute();

       return "New product added successfully!";
    } catch (PDOException $e) {
        return "Error adding new product: " . $e->getMessage();
    }
}
