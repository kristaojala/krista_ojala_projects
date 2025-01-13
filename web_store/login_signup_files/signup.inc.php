<?php
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

        if (is_input_empty($firstName, $lastName, $password, $email)) {
            $errors["empty_input"] = "Please fill in all fields.";
        }
        if (is_email_invalid($email)) {
            $errors["invalid_email"] = "Invalid email used.";
        }
       
        if (is_email_registered($pdo_conn, $email)) {
            $errors["email_used"] = "Email is already registered.";
        }

        require_once 'config_session.inc.php'; 

        if ($errors) {
            $_SESSION["errors_signup"] = $errors;
            $_SESSION["signup_data"] = [ 
                "firstName" => $firstName,
                "lastName" => $lastName,
                "email" => $email
            ];

            header("Location: ../register.php");
            die();
        }

        create_user($pdo_conn, $firstName, $lastName, $password, $email);
        header("Location: ../register.php?signup=success");
        die();

    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }
} else {
    header("Location: ../register.php");
    die();
}