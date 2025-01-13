<?php
session_start();
$errors = [];

try {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST['username'];
        $password = $_POST['password'];

        require_once 'login_signup_files/db_conn.inc.php';
        require_once 'login_signup_files/login_model.inc.php';
        require_once 'login_signup_files/login_controller.inc.php';


        if (is_input_empty($username, $password)) {
            $errors["empty_input"] = "Please fill in all the fields.";
        } else {
         
            if (!isset($pdo_conn)) {
                $errors["db_connection"] = "Database connection not established.";
            } else {
                $result = get_user($pdo_conn, $username);

                if ($result && $result['deleted_at'] !== null) {
                    $errors["account_deleted"] = "Your account has been deleted. Please contact support for assistance.";
                }

                
                if (is_username_wrong($result) || ($result["Password"] !== null && is_password_wrong($password, $result["Password"]))) {

                    $errors["login_incorrect"] = "E-mail and password do not match!";
                }
            }
        }
        require_once 'login_signup_files/config_session.inc.php';
        
        if ($errors) {
            $_SESSION["errors_login"] = $errors;
            $referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'index.php';
            $referer .= (strpos($referer, '?') !== false) ? '&' : '?';
            $referer .= 'error=login';
            header("Location: $referer");
            die();
        }
        
        if (isset($result["UserID"])) {
            $newSessionId = session_create_id();
            $sessionID = $newSessionId . "_" . $result["UserID"];
            session_id($sessionID);
        
            $_SESSION["user_id"] = $result["UserID"];
            $_SESSION["username"] = htmlspecialchars($result["FirstName"]);
            $_SESSION["user_type"] = $result["UserType"];
            $_SESSION["last_generation"] = time();
        }
        $referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'index.php';
        $referer .= (strpos($referer, '?') !== false) ? '&' : '?';
        $referer .= 'login=success';
        header("Location: $referer");

        die();
    }
} catch (Exception $e) {
    echo "Caught exception: " . $e->getMessage();
}


if (isset($result["id"])) {
    $newSessionId = session_create_id();
    $sessionID = $newSessionId . "_" . $result["UserID"];
    session_id($sessionID);

    $_SESSION["UserID"] = $result["UserID"];
    $_SESSION["username"] = htmlspecialchars($result["FirstName"]);

    $_SESSION["last_generation"] = time();

   
    die();
}
header("Location: $referer");
die();
?>