<?php
    //session_start();
    // Sessiossa "kirjautuneen käyttäjän ID"
    if(!isset($_SESSION['user_apartment'])){
        header("Location: ./index.php?page=login");
    } 
    include "functions/html_generator.php";
    include "functions/admin_view.php";
    
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sauna reservations</title>
    <link rel="stylesheet" href="sauna/sauna.css">
    <script src="htmx.js" defer></script>
</head>
<body>
    <main class="sauna-main">
    <?php
        include "functions/arrays.php";
    ?>
    <h1>Saunavuorot</h1>
    <h3 class="notification" style="opacity:0;">text</h3>
    <table>
        <!-- Tähän kohtaan if-else rakenne ja echo adminia varten -->
        <?php 
        if ($_SESSION['user_apartment'] != 0){
            echo generateTable($weekdays,$times_of_day); 
        }else{
            echo generateAdminTable($weekdays,$times_of_day);
        }
        ?>
    </table>
    <?php
        if ($_SESSION['user_apartment'] == 0){
                echo "<button class='reserved reset' hx-post='sauna/functions/reset.php' hx-target='table' hx-swap='innerHTML'>Nollaa taulukko</button>"; 
            }
    ?>
    <main>
</body>
</html>