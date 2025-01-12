<?php
require './db_connection.php';
require 'profile/profile-shared-functions.php';

// Nimen muokkaus
//name edit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['edit_name']) && isset($_POST['new_name'])) {
    $new_name = htmlspecialchars(trim($_POST['new_name']));
    $apartment = $_SESSION['user_apartment'] ?? 1;

    // päivitä nimi DB
    //update name on DB
    $stmt = $mysqli->prepare("UPDATE users SET name = ? WHERE apartment = ?");
    $stmt->bind_param('si', $new_name, $apartment);
    $stmt->execute();

    // uuden nimen display palautus
    //new name display return
    echo '<div id="user-name-display-container">
              <p id="user-name-display">Nimi: ' . htmlspecialchars($new_name) . '</p>
              <button id="edit-name-button" 
              onclick="document.getElementById(\'edit-name-form\').classList.toggle(\'hidden\'); ">Muokkaa nimeä</button>
          </div>';
    exit();
}


// uuden auton lisäys
//new car adding
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['add_car']) && !empty($_POST['new_car'])) {
    $new_car = htmlspecialchars(trim($_POST['new_car']));
    $apartment = $_SESSION['user_apartment'] ?? 1;

    // uusi auto DBseen
    //new car to DB
    $stmt = $mysqli->prepare("INSERT INTO cars (registration_number, apartment) VALUES (?, ?)");
    $stmt->bind_param('si', $new_car, $apartment);
    $stmt->execute();

    // Autolistan uudelleenrenderöinti
    //re-render car list
    echo renderCarList($apartment); 
    exit();
}

// Auton poisto
// delete a car
if ($_SERVER['REQUEST_METHOD'] === 'DELETE' && isset($_GET['delete_car'])) {
    parse_str(file_get_contents('php://input'), $data);
    $car_to_delete = htmlspecialchars(trim($_GET['delete_car']));
    $apartment = $_SESSION['user_apartment'] ?? 1;

    try {
        $mysqli->begin_transaction();

        // Onko ko autolla varauksia
        //does the car have reservations
        $query = "SELECT parking_spot FROM parking_reservations WHERE car_registration_number = ? AND apartment = ?";
        $stmt = $mysqli->prepare($query);
        if (!$stmt) throw new Exception("Prepare failed for SELECT: " . $mysqli->error);
        $stmt->bind_param('si', $car_to_delete, $apartment);
        $stmt->execute();
        $result = $stmt->get_result();

        $reserved_spot = $result->fetch_assoc();
        if ($reserved_spot) {
            // Jos varauksia, poista ne
            //if reservations, delete them
            $query = "DELETE FROM parking_reservations WHERE car_registration_number = ? AND apartment = ?";
            $stmt = $mysqli->prepare($query);
            if (!$stmt) throw new Exception("Prepare failed for DELETE: " . $mysqli->error);
            $stmt->bind_param('si', $car_to_delete, $apartment);
            $stmt->execute();

            // Paikan statuksen muutos, koska ne ovat tyhmästi DBssä
            //Update the status of the spot, because it is stupidly in the database
            $query = "UPDATE parking_spaces SET status = 'available' WHERE parking_spot = ?";
            $stmt = $mysqli->prepare($query);
            if (!$stmt) throw new Exception("Prepare failed for UPDATE: " . $mysqli->error);
            $stmt->bind_param('i', $reserved_spot['parking_spot']);
            $stmt->execute();
        }

        // Poista auto 
        //delete car
        $query = "DELETE FROM cars WHERE registration_number = ? AND apartment = ?";
        $stmt = $mysqli->prepare($query);
        if (!$stmt) throw new Exception("Prepare failed for DELETE: " . $mysqli->error);
        $stmt->bind_param('si', $car_to_delete, $apartment);
        $stmt->execute();

        $mysqli->commit();

        // autolistan uudelleenrenderöinti
        //re-render car list
        echo renderCarList($apartment);
    } catch (Exception $e) {
        $mysqli->rollback();
        http_response_code(500);
        echo "<div class='error'>Error: " . $e->getMessage() . "</div>";
    }
    exit();
}

//Sähköpostin muokkaus
//email edit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['edit_email'])) {
    $new_email = filter_var($_POST['new_email'], FILTER_VALIDATE_EMAIL);
    $apartment = $_SESSION['user_apartment'] ?? 1;

    if (!$new_email) {
        echo '<p class="error">Virheellinen sähköpostiosoite.</p>';
        exit();
    }

      // päivitä DBseen
      //update to DB
      $stmt = $mysqli->prepare("UPDATE users SET email = ? WHERE apartment = ?");
      $stmt->bind_param('si', $new_email, $apartment);
      $stmt->execute();
  
      echo '<div id="email-container">
                <p id="email-display">Sähköposti: ' . htmlspecialchars($new_email) . '</p>
                <button onclick="document.getElementById(\'email-edit-form\').classList.toggle(\'hidden\');">Muokkaa sähköpostia</button>
            </div>';
      exit();
  }

//muokkaa salasanaa, vaatimus 8 merkkiä
//Change password, minumum 8 marks
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['edit_password'])) {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    $apartment = $_SESSION['user_apartment'] ;

    if (strlen($new_password) < 8) {
        echo '<div id="password-container">
           <button id="edit-password-button" onclick="document.getElementById(\'password-edit-form\').classList.toggle(\'hidden\');">
                      Muokkaa salasanaa
                  </button>
                  <form id="password-edit-form" hx-post="?edit_password=1" hx-target="#password-container" hx-swap="outerHTML">
                  <p class="error">Salasanan on oltava vähintään 8 merkkiä pitkä.</p>
            <input type="password" name="current_password" placeholder="Nykyinen salasana" required> <br><br>
            <input type="password" name="new_password" placeholder="Uusi salasana" required> <br>
            <input type="password" name="confirm_password" placeholder="Vahvista uusi salasana" required>
            <button type="submit">Tallenna</button>
        </form>
    </div>';
exit();
    }

    if ($new_password !== $confirm_password) {
        echo '<div id="password-container">
           <button id="edit-password-button" onclick="document.getElementById(\'password-edit-form\').classList.toggle(\'hidden\');">
                      Muokkaa salasanaa
                  </button>
                  <form id="password-edit-form" hx-post="?edit_password=1" hx-target="#password-container" hx-swap="outerHTML">
                  <p class="error">Salasanat eivät täsmää.</p>
            <input type="password" name="current_password" placeholder="Nykyinen salasana" required> <br><br>
            <input type="password" name="new_password" placeholder="Uusi salasana" required> <br>
            <input type="password" name="confirm_password" placeholder="Vahvista uusi salasana" required>
            <button type="submit">Tallenna</button>
        </form>
    </div>';
exit();
    }

    // Haetaan nykyinen hashatty salasana
    //get current hashed password
    $stmt = $mysqli->prepare("SELECT password FROM users WHERE apartment = ?");
    $stmt->bind_param('i', $apartment);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if (!$user || !password_verify($current_password, $user['password'])) {
        echo '<div id="password-container">
           <button id="edit-password-button" onclick="document.getElementById(\'password-edit-form\').classList.toggle(\'hidden\');">
                      Muokkaa salasanaa
                  </button>
                  <form id="password-edit-form" hx-post="?edit_password=1" hx-target="#password-container" hx-swap="outerHTML">
                  <p class="error">Virheellinen nykyinen salasana.</p>
                      <input type="password" name="current_password" placeholder="Nykyinen salasana" required> <br><br>
                      <input type="password" name="new_password" placeholder="Uusi salasana" required> <br>
                      <input type="password" name="confirm_password" placeholder="Vahvista uusi salasana" required>
                      <button type="submit">Tallenna</button>
                  </form>
              </div>';
        exit();
    }

    // Hashaa ja päivitä salasana
    //hash and update password
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
    $stmt = $mysqli->prepare("UPDATE users SET password = ? WHERE apartment = ?");
    $stmt->bind_param('si', $hashed_password, $apartment);
    $stmt->execute();

    echo '<div id="password-container">
       <button id="edit-password-button" onclick="document.getElementById(\'password-edit-form\').classList.toggle(\'hidden\');">
                      Muokkaa salasanaa
                  </button>
                  <form id="password-edit-form" hx-post="?edit_password=1" hx-target="#password-container" hx-swap="outerHTML">
                  <p class="success">Salasana päivitetty onnistuneesti.</p>
        <input type="password" name="current_password" placeholder="Nykyinen salasana" required> <br><br>
        <input type="password" name="new_password" placeholder="Uusi salasana" required> <br>
        <input type="password" name="confirm_password" placeholder="Vahvista uusi salasana" required>
        <button type="submit">Tallenna</button>
    </form>
</div>';
exit();
}

