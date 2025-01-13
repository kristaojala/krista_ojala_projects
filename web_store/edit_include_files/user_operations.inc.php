<?php

function delete_user($pdo, $id) {
    try { 
        $stmt = $pdo->prepare("UPDATE users SET deleted_at = :deleted_time WHERE UserID = :user_id");

        $deletedTime = date('Y-m-d H:i:s');
        $stmt->bindParam(':deleted_time', $deletedTime, PDO::PARAM_STR);
        $stmt->bindParam(':user_id', $id, PDO::PARAM_INT);

        $stmt->execute();
            
        return "User deleted successfully!";
    } catch(PDOException $e) {
        return "error: $e";
    }
} 

function restore_user($pdo, $id) {
    try { 
        $stmt = $pdo->prepare("UPDATE users SET deleted_at = :deleted_time WHERE UserID = :user_id");

        $deletedTime = null;
        $stmt->bindParam(':deleted_time', $deletedTime, PDO::PARAM_STR);
        $stmt->bindParam(':user_id', $id, PDO::PARAM_INT);

        $stmt->execute();
            
        return "User restored successfully!";
    } catch(PDOException $e) {
        return "error: $e";
    }
} 

function getUserDetails($pdo, $userId){
    try{
        $stmt = $pdo->prepare("SELECT * FROM users WHERE UserID = :user_id");

        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        $userDetails = $stmt->fetch(PDO::FETCH_ASSOC);

        return $userDetails;
    }
    catch(PDOException $e){
        echo "error: $e";
    }

} 

function updateUserDetails($pdo, $userId, $newData){
   
    $stmt = $pdo->prepare("UPDATE users SET Firstname = :firstname, Lastname = :lastname, Email = :email, Address = :address WHERE UserID = :user_id");
    $stmt->bindParam(':firstname', $newData['Firstname'], PDO::PARAM_STR);
    $stmt->bindParam(':lastname', $newData['Lastname'], PDO::PARAM_STR);
    $stmt->bindParam(':email', $newData['Email'], PDO::PARAM_STR);
    $stmt->bindParam(':address', $newData['Address'], PDO::PARAM_STR);
    $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);

    $stmt->execute();
} 