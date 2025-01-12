<?php
//Tämä koodi tarkistaa parkkipaikkojen statuksen ja palauttaa ilmoituksen, 
//mikäöli kaikki ovat varattuja. 
//Jälkiviisaana en olisi tehnyt niitä DB näin, vaan paikka olisi varattu jos sille on varaus.
//mutta nyt menemme tällä.

//This code checks the status of the parking spaces and returns a notification, 
//if all are reserved. 
//In hindsight, I wouldn't have done them DB like this, but the place would have been reserved if there was a reservation for it.
//but for now we'll go with this.

session_start();
require '../db_connection.php'; 

//Hakee statukset
//Get status
$query = "SELECT status FROM parking_spaces";
$stmt = $mysqli->prepare($query);
$stmt->execute();
$result = $stmt->get_result();

$all_spots_reserved = true; // Aluksi oletus, että ovat varattuja, voisi olla myös false yhtä hyvin.
                            // Initially assumpt that they are all reserved, could be false just as well.

// Käy läpi statukset
//Go through the statuses
while ($row = $result->fetch_assoc()) {
    if ($row['status'] === 'available') { 
        $all_spots_reserved = false;
        break; // Ei tarvetta jatkaa pitemmälle, jos yksikin paikka on vapaa
               // No need to check further if even one spot is free
    }
}

// Jos kaikki täynnä, palautetaan tämä
//If all spots are reserved, return this
if ($all_spots_reserved) {
    echo '<div class="alert-warning"><strong>Kaikki paikat ovat varattuna.</strong></div>';
} else {
    echo '';
}
