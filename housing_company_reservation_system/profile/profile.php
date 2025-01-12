<?php
require './db_connection.php';
require 'profile/profile-shared-functions.php';

if(!isset($_SESSION['user_apartment'])){
    header("Location: ./index.php?page=login");
}

$apartment = $_SESSION['user_apartment']; 

// Haetaan käyttäjän tiedot
//get user and information
$stmt = $mysqli->prepare("SELECT name, email FROM users WHERE apartment = ?");
$stmt->bind_param('i', $apartment);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

//  käyttäjän autot
//user cars
$stmt = $mysqli->prepare("SELECT registration_number FROM cars WHERE apartment = ?");
$stmt->bind_param('i', $apartment);
$stmt->execute();
$result = $stmt->get_result();
$cars = $result->fetch_all(MYSQLI_ASSOC);

// formin submittien hoitelu
//form submit handling
if ($_SERVER['HTTP_HX_REQUEST'] ?? false) {
    include 'profile/htmx-handler.php';
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="profile/profile.css">
    <script src="htmx.js" defer></script>
</head>
<body>

<div class="profile-main">

    <h2>Käyttäjä</h2>
<!-- käyttäjän perustiedot
      User info-->
    <div class="profile-info">
        <p>Asunto nro: <?php echo $apartment; ?></p>
        <div id="user-name-display-container">
            <p id="user-name-display">Nimi: <?php echo htmlspecialchars($user['name']); ?></p>
            <button id="edit-name-button" onclick="document.getElementById('edit-name-form').classList.toggle('hidden'); ">Muokkaa nimeä</button>
        </div>

        <form id="edit-name-form" class="hidden" hx-post="?edit_name=1" hx-target="#user-name-display-container" hx-swap="outerHTML">
            <input type="text" name="new_name" value="<?php echo htmlspecialchars($user['name']); ?>" required>
            <button type="submit">Tallenna</button>
        </form>
    </div>

    <div class="profile-auth">
    <h3>Kirjautumistiedot</h3>
<!-- email ja salasana
 Email and password  -->
    <div id="email-container">
        <p id="email-display">Sähköposti: <?php echo htmlspecialchars($user['email']); ?></p>
        <button id="edit-email-button" onclick="document.getElementById('email-edit-form').classList.toggle('hidden');">Muokkaa sähköpostia</button>
    </div>
    <form id="email-edit-form" class="hidden" hx-post="?edit_email=1" hx-target="#email-container" hx-swap="outerHTML">
        <input type="email" name="new_email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
        <button type="submit">Tallenna</button>
    </form>

<div id="password-container">
    
    <button id="edit-password-button" onclick="document.getElementById('password-edit-form').classList.toggle('hidden');">
    Muokkaa salasanaa
    </button>
    <form id="password-edit-form" class="hidden" hx-post="?edit_password=1" hx-target="#password-container" hx-swap="outerHTML">
        <input type="password" name="current_password" placeholder="Nykyinen salasana" required> <br><br>
        <input type="password" name="new_password" placeholder="Uusi salasana" required> <br>
        <input type="password" name="confirm_password" placeholder="Vahvista uusi salasana" required>
        <button type="submit">Tallenna</button>
    </form>
</div>

</div>
<!-- Autot
     Cars -->
    <div class="profile-cars">
        <h3>Autot</h3>
        <?php echo renderCarList($apartment); ?>

        <button id="add-new-car-button" onclick="document.getElementById('new-car-field').classList.toggle('hidden')">Uusi auto</button>

        <!-- uusi auto form 
            New car form-->
        <form id="new-car-field" class="hidden" hx-post="?add_car=1" hx-target="#car-list" hx-swap="outerHTML">
            <input type="text" id="new-car" name="new_car" placeholder="Syötä rekisterinumero" required>
            <button type="submit">Lisää auto</button>
        </form>
    </div>

</div>

</body>
<script>
    //toggleja
    //osassa ihan elementissäkin
    //Toggles
    //Some in the element itself
    document.querySelector('#new-car-field').addEventListener('htmx:afterRequest', function() {
        document.querySelector('#new-car-field').classList.add('hidden');
        document.querySelector('#new-car').value = '';
    });

    document.querySelector('#edit-name-form').addEventListener('htmx:afterRequest', function() {
        document.querySelector('#edit-name-form').classList.add('hidden');
    });
</script>
</html>