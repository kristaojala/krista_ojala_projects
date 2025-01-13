<?php
declare(strict_types= 1);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $firstName = $_POST["firstName"];
    $lastName = $_POST["lastName"];
    $password = $_POST["password"];
    $email = $_POST["email"];

    try {
        require_once 'db_conn.inc.php';
        require_once 'signup_model.inc.php'; 
        require_once 'signup_controller.inc.php'; 

        $errors = []; 


function is_input_empty(string $firstName, string $lastName, string $password, string $email) {
    if (empty($firstName) ||empty($lastName) || empty($password) || empty($email)) {
        return true;
    } else {
        return false;
    }
}

function is_email_invalid(string $email) {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return true;
    } else {
        return false;
    }
}


function is_email_registered(object $pdo_conn, string $email) {
    if (get_email($pdo_conn, $email)) {
        return true;
    } else {
        return false;
    }
}

function create_user(object $pdo_conn, string $firstName, string $lastName, string $password, string $email) {
    set_user($pdo_conn, $firstName, $lastName, $password, $email);
}

if ($errors) {
    $_SESSION["errors_signup"] = $errors;

    $signupData = [
        "firstName" => $firstName,
        "lastName" => $lastName,
        "username" => $username,
        "email" => $email
    ];
    $_SESSION["signup_data"] = $signupData;

    header("Location: ../register.php");

    $pdo_conn = null;
    $stmt = null;

    die();
}


} catch (PDOException $e) {
die("Query failed: " . $e->getMessage());
}
} else {
header("Location: ../register.php");
die();
}