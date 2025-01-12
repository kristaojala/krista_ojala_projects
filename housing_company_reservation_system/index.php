<?php
ob_start();
session_start();
if ($_SERVER['HTTP_HX_REQUEST'] ?? false) {
    include 'profile/htmx-handler.php';
    exit(); // tämä on tärkeä, ettei hajota profiilin toimintaa.
            // this is important so as not to break the profile's functionality.
}
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="logo.png" type="image/x-icon">
     <title>Housing Company</title>
    <?php include "header.php"; ?>
</head>
<body>

<?php
// routing:
$page = $_GET['page'] ?? 'home'; // Default: home.

switch ($page) {
    case 'parking':
        include 'parking/parking.php';
        break;
    case 'sauna':
        include 'sauna/sauna.php';
        break;
    case 'login': 
        include 'login/loginPage.php'; 
        break;
    case 'profile':
            include 'profile/profile.php';
            break;
     default:
        include 'home/home.php'; // Default content: home.php
        break;
}
?>

</body>
</html>
