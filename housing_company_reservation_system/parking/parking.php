<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require './db_connection.php';

if (!isset($_SESSION['user_apartment'])) {
    header("Location: ./index.php?page=login");
}

$user_apartment = $_SESSION['user_apartment'];

// Haetaan autot
//Get cars
$query = "SELECT registration_number FROM cars WHERE apartment = ?";
$stmt = $mysqli->prepare($query);
$stmt->bind_param('i', $user_apartment);
$stmt->execute();
$result = $stmt->get_result();
$user_cars = $result->fetch_all(MYSQLI_ASSOC);

// Parkkipaikkojen haku
//Get parking spots
$query = "SELECT parking_spot, status FROM parking_spaces";
$result = $mysqli->query($query);
$parking_spots = $result->fetch_all(MYSQLI_ASSOC);

//Nykyisen käyttäjän varaukset
//Current users reservations
$query = "SELECT parking_spot, car_registration_number FROM parking_reservations WHERE apartment = ?";
$stmt = $mysqli->prepare($query);
$stmt->bind_param('i', $user_apartment);
$stmt->execute();
$reservations = $stmt->get_result();
$parking_reservations = $reservations->fetch_all(MYSQLI_ASSOC);

// Haetaan varaukset kaikkiin paikkoihin
//Get reservations for all spots
$query = "SELECT parking_spot, apartment FROM parking_reservations";
$reservations_all = $mysqli->query($query);
$all_reservations = $reservations_all->fetch_all(MYSQLI_ASSOC);


$user_role = $_SESSION['user_role'];
?>

<html lang="en">
<head>
    <link rel="stylesheet" href="parking/parking.css">
    <script src="htmx.js" defer></script>
</head>

<main class="parking-main">
    <h1>Parkkipaikan varaus</h1>
     <?php if ($user_role === 'admin'): ?>
            <h2>Kaikki varaukset</h2>
            <?php if (empty($all_reservations)): ?>
                <p>Ei varauksia.</p>
            <?php else: ?>
                <table>
                    <thead>
                        <tr>
                            <th>Parkkipaikka</th>
                            <th>Asunto</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($all_reservations as $reservation): ?>
                            <tr>
                                <td><?= htmlspecialchars($reservation['parking_spot']) ?></td>
                                <td><?= htmlspecialchars($reservation['apartment']) ?></td> 
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        <?php endif; ?>

    <!-- Tähän tulee viesti, jos kaikki paikat varattuna 
        A message will appear here if all places are reserved -->
    <div id="spots-status" hx-get="parking/check-spots-status.php" hx-trigger="load" hx-swap="innerHTML"></div>

    <div class="your-reservations" id="reservation-feedback">
        <!-- feedback varauksista ja vapautuksista 
         feedback on reservations and freeing spots-->
        <?php if (isset($_SESSION['feedback'])): ?>
            <div class="feedback"><?= $_SESSION['feedback'] ?></div>
            <?php unset($_SESSION['feedback']); ?>
        <?php endif; ?>

        <!-- käyttäjän varaukset 
         User's reservations -->
        <h2>Varauksesi</h2>
        <?php if (empty($parking_reservations)): ?>
            <p>Ei varauksia.</p>
        <?php else: ?>
            <?php foreach ($parking_reservations as $reservation): ?>
                <div class="reservation-wrapper">
                    <p>Paikka: <?= $reservation['parking_spot'] ?> <br> Auto: <?= htmlspecialchars($reservation['car_registration_number']) ?></p>
                    <form
                        hx-post='parking/release-reservation.php'
                        hx-target='#reservation-feedback, .your-reservations, #parking-layout'
                        hx-swap='innerHTML'>
                        <input type='hidden' name='spot' value='<?= $reservation["parking_spot"] ?>'>
                        <button type='submit'>Vapauta</button>
                    </form>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
        <!-- Parking layout -->
        <div id="parking-layout">
            <?php
            require_once 'parking-layout.php';
            echo generate_parking_layout($user_apartment, $parking_spots, $all_reservations);
            ?>
        </div>
    </div>


</main>
</body>
</html>
