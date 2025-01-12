<?php
include "html_generator.php";
include "admin_view.php";
include "arrays.php";
require "db_conn.php";

  // Aloitetaan sessio
  session_start();
  // Tarkistetaan pyyntömetodi
  if($_SERVER['REQUEST_METHOD'] === 'POST'){
      if ($_SESSION['userId'] == 0){
      
      // Otetaan tietoa POST pyynnöstä
      //$reservationIndex = $_POST['reservationSlot'];
      // Päivitetään session taulukoita
      //$_SESSION['reservationIds'][$reservationIndex] = 0;
      //$_SESSION['reservations'][$reservationIndex] = !$_SESSION['reservations'][$reservationIndex];
      
      // Jossain täällä varmaankin tehdään tietokannan päivitys
      $stmt = $conn->prepare("UPDATE sauna_reservations SET userID = 0 WHERE reservation_slot <> 0");
      //$stmt->bind_param("i", $reservationIndex);
      $stmt->execute();
      // Suljetaan tietokantayhteys
      $stmt->close();
      
          
          
          // echo palauttaa päivitetyn varaustaulukon
          echo generateAdminTable($weekdays,$times_of_day);
    } else{
        header("Location: ../../index.php");
    }
      
    }else{
        header("Location: ../../index.php");
    }
?>