<?php
session_start();
if(!isset($_SESSION['user_apartment'])){
    header("Location: ../index.php");
    exit();
} else{ // Tässä kohtaa ohjataan kirjautumisen jälkeiselle sivulle 
    header("Location: ../../index.php?page=home");
    exit();
}

?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logged In</title>
    <!--link rel="stylesheet" href="style.css">
    <script src="htmx.js" defer></script-->
</head>
<body>
    <main>
        <h1>Authenticated!</h1>
    </main>
    
</body>
</html>