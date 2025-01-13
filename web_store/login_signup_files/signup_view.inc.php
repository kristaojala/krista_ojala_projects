<?php

declare(strict_types=1);

function check_signup_errors() {
    if(isset($_SESSION["errors_signup"])) {
        $errors = $_SESSION["errors_signup"];

        echo "<br>";

        foreach($errors as $error) {
            echo "<p class='error-text'>" . $error . "</p>";
        }

        unset($_SESSION["errors_signup"]);
    }
    else if (isset($_GET["signup"]) && $_GET["signup"] === "success") {
        echo "<br>";
        echo "<p>Account registered!</p>";
    }
}

function signup_inputs() {
    echo '<label for="firstName">First Name:</label>';
    if (isset($_SESSION["signup_data"]["firstName"]) && isset($_SESSION["errors_signup"]) === false) {
        echo '<input type="text" name="firstName" placeholder="First Name" value="'.htmlspecialchars($_SESSION["signup_data"]["firstName"]).'">';
    } else {
        echo '<input type="text" name="firstName" placeholder="First Name">';
    }

    echo '<label for="lastName">Last Name:</label>';
    if (isset($_SESSION["signup_data"]["lastName"]) && isset($_SESSION["errors_signup"]) === false) {
        echo '<input type="text" name="lastName" placeholder="Last Name" value="'.htmlspecialchars($_SESSION["signup_data"]["lastName"]).'">';
    } else {
        echo '<input type="text" name="lastName" placeholder="Last Name">';
    }

    echo '<label for="password">Password:</label>';
    echo '<input type="password" name="password" placeholder="Password">';

    echo '<label for="email">E-Mail:</label>';
    if (isset($_SESSION["signup_data"]["email"]) &&
        isset($_SESSION["errors_signup"]["email_used"]) === false &&
        isset($_SESSION["errors_signup"]["invalid_email"]) === false) {
            echo '<input type="text" name="email" placeholder="E-Mail" value="'. htmlspecialchars($_SESSION["signup_data"]["email"]) .'">';
    } else {
        echo '<input type="text" name="email" placeholder="E-Mail">';
    }

    unset($_SESSION["signup_data"]);
}
