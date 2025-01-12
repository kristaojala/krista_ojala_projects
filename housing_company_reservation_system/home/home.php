<?php
require './db_connection.php';

if(!isset($_SESSION['user_apartment'])){
    header("Location: ./index.php?page=login");
}

$apartment = $_SESSION['user_apartment'];

try {
    // Haetaan käyttäjän data
    //Get user data
    $stmt = $mysqli->prepare("SELECT name FROM users WHERE apartment = ?");
    $stmt->bind_param('i', $apartment);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if (!$user) {
        throw new Exception("Käyttäjää ei löytynyt");
    }

    // Hae parkkipaikkavaraukset
    //Get parking reservations
    $stmt = $mysqli->prepare("
        SELECT pr.parking_spot, c.registration_number AS car
        FROM parking_reservations pr
        INNER JOIN cars c ON pr.car_registration_number = c.registration_number
        WHERE pr.apartment = ?
    ");
    $stmt->bind_param('i', $apartment);
    $stmt->execute();
    $result = $stmt->get_result();
    $parkingReservations = $result->fetch_all(MYSQLI_ASSOC);

 // hae saunavaraukset
 //Get sauna reservations
 $stmt = $mysqli->prepare("
 SELECT weekday, starting_hour
 FROM sauna_reservations
 WHERE userID = ?
");
$stmt->bind_param('i', $apartment);
$stmt->execute();
$result = $stmt->get_result();
$saunaReservations = $result->fetch_all(MYSQLI_ASSOC);

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
    exit();
}

//roolin tarkistus
//role check
  $query = "SELECT role FROM users WHERE apartment = ?";
  $stmt = $mysqli->prepare($query);
  $stmt->bind_param('i', $apartment);
  $stmt->execute();
  $result = $stmt->get_result();
  $user_data_role = $result->fetch_assoc();

  if ($user_data_role && isset($user_data_role['role'])) {
      $_SESSION['user_role'] = $user_data_role['role']; 
  } else {
      $_SESSION['user_role'] = 'user';
  }
  
  $user_role = $_SESSION['user_role'];
?>

<head>
    <link rel="stylesheet" href="home/home.css">
</head>

<main class="home-main">
    <h2>Hei, <?php echo htmlspecialchars($user['name']); ?>!</h2>
    <?php if ($user_role === 'user'): ?>
    <div class="users-reservations">
        <h3>Varauksesi</h3>

        <div id="home-parking-reservations">
            <h4>Parkkipaikat:</h4>
            <?php if (empty($parkingReservations)): ?>
                <p>Ei varauksia.</p>
            <?php else: ?>
                <?php foreach ($parkingReservations as $reservation): ?>
                    <p>Parkkipaikka: <?= htmlspecialchars($reservation['parking_spot']) ?><br>
                    Auto: <?= htmlspecialchars($reservation['car']) ?></p>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <div id="home-sauna-reservations">
            <h4>Saunavuoro:</h4>
            <?php if (empty($saunaReservations)): ?>
                <p>Ei varauksia.</p>
            <?php else: ?>
                    <?php foreach ($saunaReservations as $reservation): ?>
                       <p> <?= htmlspecialchars($reservation['weekday']. " klo " . $reservation['starting_hour'] . ":00") ?></p>
                    <?php endforeach; ?>
            <?php endif; ?>
        </div>

    </div>
    <?php endif; ?>
    <?php if ($user_role === 'admin'): ?>
        <p>Ei uusia tiedotteita.</p>
    <!-- Ajattelimme, että admin saisi ehkä admininasioita koskevia tiedotteita jostain ulkoisesta palvelusta. 
        We thought that maybe the admin would receive notifications about admin things from some external service. -->
        <?php endif; ?>
</main>
