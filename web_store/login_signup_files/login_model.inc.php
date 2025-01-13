<?php

declare(strict_types=1);
function get_user(object $pdo, string $username) {
    $query = "SELECT UserID, FirstName, LastName, Password , UserType,  deleted_at FROM users WHERE Email = :loginCredential";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":loginCredential", $username);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);


    return $result; 
}