<?php
session_start();
$servername = "localhost";
$databasename = "verkkokauppa";
$dbusername = "root";
$dbpassword = "";

try {
    $pdo_conn = new PDO("mysql:host=$servername;dbname=$databasename", $dbusername, $dbpassword);
    $pdo_conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

require_once 'edit_include_files/user_operations.inc.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {

    $id = $_POST['UserId'];

    $newData = [
        'Firstname' => $_POST['Firstname'],
        'Lastname' => $_POST['Lastname'],
        'Email' => $_POST['Email'],
        'Address' => $_POST['Address']
    ];

    updateUserDetails($pdo_conn, $id, $newData);

}

    if(isset($_GET['UserID'])){
        
            $userId = $_GET['UserID'];
            $userDetails = getUserDetails($pdo_conn, $userId);
    }

    else{
        header("Location: profile.php");
            die();
    }

?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/style.css">
    <link rel="shortcut icon" href="media/favicon.png" type="image/x-icon">
    <title>Edit Information</title>
</head>
<body>
  <?php include 'header.php' ?>
  <main class="simple-column ">
    <h2 class="center ">Edit Information:</h2>
    <div class="center">
    <form action="edit_user.php" method="post" class="less-wide register">

      <input type="hidden" name="UserId" value="<?= $userDetails['UserID'] ?>">
        <label for="Firstname">Firstname:</label>
        <input type="text" name="Firstname" value="<?= htmlspecialchars($userDetails['FirstName']) ?>" required>

        <label for="Lastname">Lastname:</label>
        <input type="text" name="Lastname" value="<?= htmlspecialchars($userDetails['LastName']) ?>" required>

        <label for="Email">Email:</label>
        <input type="email" name="Email" value="<?= htmlspecialchars($userDetails['Email']) ?>" required>

        <label for="Address">Address:</label>
        <input type="text" name="Address" value="<?= htmlspecialchars($userDetails['Address']) ?>">

        <input type="submit" name="submit" value="Update" class="button">
    </form>
    </div>
    </main>
    <?php include 'footer.php' ?>
</body>
</html>
