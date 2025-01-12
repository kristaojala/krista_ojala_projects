<?php 
require './db_connection.php';
//autolistan renderöinti
//render car list
function renderCarList($apartment) {
    global $mysqli;
    $output = '';
    $stmt = $mysqli->prepare("SELECT registration_number FROM cars WHERE apartment = ?");
    $stmt->bind_param('i', $apartment);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $output .= '<ul id="car-list">';
        while ($car = $result->fetch_assoc()) {
            $output .= '<li>' . htmlspecialchars($car['registration_number']) . 
            ' <button hx-delete="?delete_car=' . urlencode($car['registration_number']) . '" 
                     hx-target="#car-list" 
                     hx-swap="outerHTML" 
                     hx-confirm="Oletko varma, että haluat poistaa auton ' . htmlspecialchars($car['registration_number']) . '?">Poista</button></li>';
        }
        $output .= '</ul>';
    } else {
        $output .= '<p>Autoja ei löytynyt.</p>';
    }
    return $output;
}
