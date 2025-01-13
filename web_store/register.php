<?php
session_start();
require_once "login_signup_files/config_session.inc.php";
require_once "login_signup_files/signup_view.inc.php";
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/style.css">
    <link rel="shortcut icon" href="media/favicon.png" type="image/x-icon">
    <title>Register a New Account</title>
</head>
<body>
<?php
    include "header.php";
    ?>

<main class="simple-column">
<h2>Create Your Account</h2>
<p>Welcome to our exclusive community!
 By creating an account, you gain access to a world of curated elegance and personalized shopping. 
 <br>Simply fill in the details below to start your membership and enjoy a seamless shopping experience 
 with benefits tailored just for you!</p>

<div class="register">
<?php
    if (isset($_GET["signup"]) && $_GET["signup"] === "success") {
        echo "<p>Account registered!</p>";
    } else { 
    echo '<form action="login_signup_files/signup.inc.php" method="post">';
    
    signup_inputs();
   echo '<br>';
    echo '<button class="button">Create Account</button>';
echo '</form>';

    check_signup_errors();

    } ?>
</div>
<p>Already a member? <a href="profile.php"><b>Log in here!</b></a></p>
</main>

<?php
   include "footer.php";
   ?>
</body>
</html>