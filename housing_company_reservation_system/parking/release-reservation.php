<?php
require '../db_connection.php';
session_start();

$spot = $_POST['spot'] ?? null;
$user_apartment = $_SESSION['user_apartment'] ?? null;
//Jos paikka tai käyttäjä puuttuu
//If there's no spot or user
if (!$spot || !$user_apartment) {
    http_response_code(400);
    echo "<div id='reservation-feedback' class='error'>Virhe, paikka tai käyttäjä puuttuu.</div>";
    exit;
}

try {
    $mysqli->begin_transaction();

    // Poista varaus
    //delete reservartion
    $query = "DELETE FROM parking_reservations WHERE parking_spot = ? AND apartment = ?";
    $stmt = $mysqli->prepare($query);
    if (!$stmt) throw new Exception("Prepare failed for DELETE: " . $mysqli->error);
    $stmt->bind_param('ii', $spot, $user_apartment);
    $stmt->execute();
    if ($stmt->affected_rows === 0) throw new Exception("Poistettavaa varausta ei löytynyt.");

    // Päivitä status, koska status on tyhmästi tietokannassa
    // Update the status, because the status is stupidly in the database

    $query = "UPDATE parking_spaces SET status = 'available' WHERE parking_spot = ?";
    $stmt = $mysqli->prepare($query);
    if (!$stmt) throw new Exception("Prepare failed for UPDATE: " . $mysqli->error);
    $stmt->bind_param('i', $spot);
    $stmt->execute();
    if ($stmt->affected_rows === 0) throw new Exception("Failed to update parking spot status.");

    $mysqli->commit();
    $feedback = "<div id='reservation-feedback' class='success'>Paikka {$spot} vapautettu onnistuneesti!</div>";
} catch (Exception $e) {
    $mysqli->rollback();
    http_response_code(500);
    echo "<div id='reservation-feedback' class='error'>Error: " . $e->getMessage() . "</div>";
    exit;
}

// päivitys varauslistaan:
// Update on reservations list:
$parkingReservationsHtml = "<div class='your-reservations'>
                        <h2>Varauksesi</h2>";
$query = "SELECT * FROM parking_reservations WHERE apartment = ?";
$stmt = $mysqli->prepare($query);
$stmt->bind_param('i', $user_apartment);
$stmt->execute();
$reservation_result = $stmt->get_result();

if ($reservation_result->num_rows === 0) {
    $parkingReservationsHtml .= "<p>Ei varauksia.</p>";
} else {
    while ($reservation = $reservation_result->fetch_assoc()) {
        $parkingReservationsHtml .= "<div class='reservation-wrapper'>
            <p>Paikka: {$reservation['parking_spot']} <br> Auto: " . htmlspecialchars($reservation['car_registration_number']) . "</p>
             <form 
                    hx-post='parking/release-reservation.php'
                    hx-target='#reservation-feedback, .your-reservations, #parking-layout'
                    hx-swap='innerHTML'>
                    <input type='hidden' name='spot' value='{$reservation['parking_spot']}'>
                    <button type='submit'>Vapauta</button>
                </form></div>";
    }
}
$parkingReservationsHtml .= "</div>";

// Parkkipaikat ja varaukset uudelleenhaku
// parking spots and reservations re-search
$query = "SELECT parking_spot, status FROM parking_spaces";
$result = $mysqli->query($query);
$parking_spots = $result->fetch_all(MYSQLI_ASSOC);

$query = "SELECT parking_spot, apartment FROM parking_reservations";
$reservations_all = $mysqli->query($query);
$all_reservations = $reservations_all->fetch_all(MYSQLI_ASSOC);

require 'parking-layout.php';
$parkingLayoutHtml = generate_parking_layout($user_apartment, $parking_spots, $all_reservations);

//palautukset:
//returns:
echo $feedback;
echo $parkingReservationsHtml;
echo $parkingLayoutHtml;
