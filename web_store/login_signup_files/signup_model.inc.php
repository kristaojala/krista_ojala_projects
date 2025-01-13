<?php

declare(strict_types=1);


function get_email(object $pdo, string $email) {
    $query = "SELECT UserID FROM users WHERE email= :Email";

    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":Email", $email);

    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    return $result;
}

function set_user(object $pdo, string $firstname, string $lastname, string $password, string $email) {
    $query = "INSERT INTO users (FirstName, LastName, Password, Email, UserType) VALUES (:firstname, :lastname, :hashedpwd, :email, 'Customer')";
    $stmt = $pdo->prepare($query);
    $options = ["cost" => 12];

    $hashedpwd = password_hash($password, PASSWORD_BCRYPT, $options);

    $stmt->bindParam(":firstname", $firstname);
    $stmt->bindParam(":lastname", $lastname);
    $stmt->bindParam(":hashedpwd", $hashedpwd);
    $stmt->bindParam(":email", $email);

    $stmt->execute();
}