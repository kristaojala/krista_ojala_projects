<?php
    include "html_generator.php";
    include "admin_view.php";
    include "arrays.php";
    require "db_conn.php";
    // Täällä päivitetään varausten poisto tietokantaan
    
    // Aloitetaan sessio
    session_start();
    // Tarkistetaan pyyntömetodi
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        
        // Otetaan tietoa POST pyynnöstä
        $reservationIndex = $_POST['reservationSlot'];
        // Päivitetään session taulukoita
        //$_SESSION['reservationIds'][$reservationIndex] = 0;
        //$_SESSION['reservations'][$reservationIndex] = !$_SESSION['reservations'][$reservationIndex];
        
        // Jossain täällä varmaankin tehdään tietokannan päivitys
        $stmt = $conn->prepare("UPDATE sauna_reservations SET userID = 0 WHERE reservation_slot = ?");
        $stmt->bind_param("i", $reservationIndex);
        $stmt->execute();
        // Suljetaan tietokantayhteys
        $stmt->close();
        
        // echo palauttaa päivitetyn varaustaulukon
        if ($_SESSION['user_apartment'] != 0){
            echo generateTable($weekdays,$times_of_day); 
        }else{
            echo generateAdminTable($weekdays,$times_of_day);
        }
    }
?>