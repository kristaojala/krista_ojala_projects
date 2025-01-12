<?php
    include "html_generator.php";
    include "admin_view.php";
    include "arrays.php";
    require "db_conn.php";

    // Täällä päivitetään varaukset tietokantaan
    
    // Aloitetaan sessio
    session_start();
    // Tarkistetaan pyyntömetodi
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        
        $id = $_SESSION['user_apartment'];
        // Otetaan tietoa POST pyynnöstä
        $reservationIndex = $_POST['reservationSlot'];

        // Päivitetään session taulukoita
        //$_SESSION['reservationIds'][$reservationIndex] = $id;
        //$_SESSION['reservations'][$reservationIndex] = !$_SESSION['reservations'][$reservationIndex];

        $stmt = $conn->prepare("UPDATE sauna_reservations SET userID = ? WHERE reservation_slot = ?");
        $stmt->bind_param("ii", $id, $reservationIndex);
        $stmt->execute();
        // Suljetaan tietokantayhteys
        $stmt->close();
            
        // echo palauttaa päivitetyn taulukon
        if ($_SESSION['user_apartment'] != 0){
            echo generateTable($weekdays,$times_of_day); 
        }else{
            echo generateAdminTable($weekdays,$times_of_day);
        }
        
            
    }
?>