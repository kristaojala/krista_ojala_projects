<?php
require '../db_connection.php';
session_start();

$user_apartment = $_SESSION['user_apartment'] ;

//post data
$spot = $_POST['spot'] ?? null;
$car = $_POST['car'] ?? null;
$new_car = $_POST['new_car'] ?? null;

$current_time = date('Y-m-d H:i:s');  // start time
$end_time = date('Y-m-d H:i:s', strtotime('+1 hour'));  // endtime nyt näin, koska joku piti olla
                                                                                     // endtime like this, because it had to be there

// onko kaikki tarpeelliset muuttujat
//are there all the necessary variables

if (!$user_apartment || !$spot || (!$car && !$new_car)) {
    $_SESSION['feedback'] = "<div class='error'>Virheellistä dataa, tarkista valintasi.</div>";
    header("Location: index.php?page=parking");
    exit;
}

$feedback = "<div class='error'>Varaus ei onnistunut, yritä uudelleen.</div>";

try {
    $mysqli->begin_transaction();

    // Lisää uusi auto, jos on
    //ad new car, if there's one
    if ($new_car) {
        $stmt = $mysqli->prepare("INSERT INTO cars (registration_number, apartment) VALUES (?, ?)");
        if (!$stmt) {
            throw new Exception("Failed to prepare car insertion query: " . $mysqli->error);
        }
        $stmt->bind_param('si', $new_car, $user_apartment);
        $stmt->execute();
        $car = $new_car;
    }

    // Tarkista onko auto valittu
    //check if car is selected
    if (!$car) {
        $_SESSION['feedback'] = "<div class='error'>Autoa ei ole valittu.</div>";
        header("Location: index.php?page=parking");
        exit;
    }

    //Lisää varaus
    //add reservation
    $stmt = $mysqli->prepare("INSERT INTO parking_reservations (parking_spot, apartment, car_registration_number, start_time, end_time) VALUES (?, ?, ?, ?, ?)");
    if (!$stmt) {
        throw new Exception("Failed to prepare reservation query: " . $mysqli->error);
    }

    $stmt->bind_param('iisss', $spot, $user_apartment, $car, $current_time, $end_time);
    if (!$stmt->execute()) {
        throw new Exception("Failed to execute reservation query: " . $stmt->error);
    }

    // Paikan statuksen päivitys, koska se on tyhmästi databasessa
    //Update the status of the spot, because it is stupidly in the database

    $stmt = $mysqli->prepare("UPDATE parking_spaces SET status = 'reserved' WHERE parking_spot = ?");
    if (!$stmt) {
        throw new Exception("Failed to prepare update spot status query: " . $mysqli->error);
    }
    $stmt->bind_param('i', $spot);
    if (!$stmt->execute()) {
        throw new Exception("Failed to execute update spot status query: " . $stmt->error);
    }

    // Commit
    $mysqli->commit();

    // feedback
    $feedback = "<div class='success'>Varaus tehty paikalle $spot autolla $car.</div>";

} catch (Exception $e) {
    $mysqli->rollback();
    $_SESSION['feedback'] = "<div class='error'>An error occurred: " . $e->getMessage() . "</div>";
}

// default valuet muuttujille
//default values for variables
$allSpotsReservedHtml = "<div id='spots-status' hx-get='parking/check-spots-status.php' hx-trigger='load' hx-swap='innerHTML'></div>";
$updatedParkingHtml = '';

// HTML päivitys, varaukset
//HTML update, reservations
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

// Päivitetyt parkkipaikat
//updated parking spots
$query = "SELECT parking_spot, status FROM parking_spaces";
$result = $mysqli->query($query);
$parking_spots = $result->fetch_all(MYSQLI_ASSOC);

//Hae varaukset
//get reservations
$query = "SELECT parking_spot, apartment FROM parking_reservations";
$reservations_all = $mysqli->query($query);
$all_reservations = $reservations_all->fetch_all(MYSQLI_ASSOC);

require 'parking-layout.php';
$parkingLayoutHtml = generate_parking_layout($user_apartment, $parking_spots, $all_reservations);


// palautukset
//returns
echo $feedback;
echo $allSpotsReservedHtml; 
echo $parkingReservationsHtml;
echo $updatedParkingHtml;
echo $parkingLayoutHtml;


// Sulje modal
//close modal
echo "<script>document.getElementById('reservation-modal').remove();</script>";
?>
