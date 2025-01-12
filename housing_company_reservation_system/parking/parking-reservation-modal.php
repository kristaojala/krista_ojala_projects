<?php
require '../db_connection.php';
session_start();

$user_apartment = $_SESSION['user_apartment'] ;
$spot = $_GET['spot'] ;

//Haetaan kirjautuneen käyttäjän autot.
//Get logged in user's cars
$query = "
    SELECT c.registration_number 
    FROM cars c 
    LEFT JOIN parking_reservations r 
    ON c.registration_number = r.car_registration_number 
    WHERE c.apartment = ? 
    AND (r.car_registration_number IS NULL OR r.end_time < NOW())";

$stmt = $mysqli->prepare($query);
$stmt->bind_param('i', $user_apartment);
$stmt->execute();
$result = $stmt->get_result();


if (!$result) {
    die("Virhe autoja haettaessa: " . $mysqli->error);
}

$user_cars = $result->fetch_all(MYSQLI_ASSOC);


// Haetaan vain vapaat parkkipaikat:
//get only free parking spots:
$query = "SELECT parking_spot FROM parking_spaces WHERE status = 'available'";
$result = $mysqli->query($query);

if (!$result) {
    die("Tietokantavirhe: " . $mysqli->error);
}

$available_spots = $result->fetch_all(MYSQLI_ASSOC);


?>

<div id="reservation-modal" class="modal">
    <form id="reserve-form" 
          hx-post="parking/reserve-parking-spot.php" 
          hx-target="#reservation-feedback, .your-reservations" 
          hx-swap="innerHTML">
        <h2>Varaa parkkipaikka</h2>

        <!-- Paikan valinta 
         spot selection -->
        <label for="spot-select">Paikka:</label>
        <select class="parking-modal-select" id="spot-select" name="spot">
            <?php foreach ($available_spots as $spot_data): ?>
                <option value="<?= htmlspecialchars($spot_data['parking_spot']) ?>" 
                        <?= $spot_data['parking_spot'] == $spot ? 'selected' : '' ?>>
                    <?= htmlspecialchars($spot_data['parking_spot']) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <br><br>

        <!-- Auton valinta
         Car selection -->
        <label for="car-select">Valitse auto:</label>
        <select class="parking-modal-select" id="car-select" name="car">
            <?php foreach ($user_cars as $car): ?>
                <option value="<?= htmlspecialchars($car['registration_number']) ?>">
                    <?= htmlspecialchars($car['registration_number']) ?>
                </option>
            <?php endforeach; ?>
            <option value="add_new">Uusi auto</option>
        </select>

        <!-- Uusi auto 
         New car -->
        <div id="new-car-field" class="hidden">
            <label for="new-car">Lisää uusi auto:</label>
            <input type="text" id="new-car" name="new_car" placeholder="Syötä rekisterinumero">
        </div>

        <!-- Napit 
         Buttons -->
        <div class="button-group">
            <button id="modal-reserve-button" type="submit">Varaa</button>
            <button id="modal-cancel-button" type="button" onclick="closeReservationWindow()">Peru</button>
        </div>
    </form>
</div>

<script>
    // Näytä tai piilota uuden auton lisäys
    //Show or hide adding new car
    document.getElementById('car-select').addEventListener('change', function () {
        const newCarOption = this.value === 'add_new';
        const newCarField = document.getElementById('new-car-field');
        newCarField.classList.toggle('hidden', !newCarOption);
    });

    // Jos ei autoja, näytä uusi auto form defaulttina
    //If user doesn't have cars, show new car form as default
    <?php if (count($user_cars) === 0): ?>
        document.getElementById('new-car-field').classList.remove('hidden');
        document.getElementById('car-select').value = 'add_new';  
    <?php endif; ?>

    // modalin sulkeminen
    //modal closing
function closeReservationWindow() {
    const modal = document.getElementById('reservation-modal');
    if (modal) {
        modal.remove();
        
    }
}



</script>
