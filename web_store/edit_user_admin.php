<?php
session_start();

if (!isset($_SESSION["user_id"]) || $_SESSION["user_type"] !== "Admin") {
    header("Location: index.php");
    exit();
}

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
function updateUserType($pdo, $userId, $newUserType){
    try {
        $stmt = $pdo->prepare("UPDATE users SET UserType = :user_type WHERE UserID = :user_id");
        $stmt->bindParam(':user_type', $newUserType, PDO::PARAM_STR);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $id = $_POST['UserId'];

    $newData = [
        'Firstname' => $_POST['Firstname'],
        'Lastname' => $_POST['Lastname'],
        'Email' => $_POST['Email'],
        'Address' => $_POST['Address'],
        'UserType' => $_POST['UserType']
    ];

    updateUserDetails($pdo_conn, $id, $newData);
    updateUserType($pdo_conn, $id, $_POST['UserType']);
}

    if(isset($_GET['UserID'])){
        
            $userId = $_GET['UserID'];
            $userDetails = getUserDetails($pdo_conn, $userId);
    }

    else{
        header("Location: admin_users.php");
            die();
    }
    ?>
    <html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/style.css">
    <link rel="shortcut icon" href="media/favicon.png" type="image/x-icon">
    <title>Edit User - Admin</title>
</head>
<body>
  <?php include 'header.php' ?>
  <main class="simple-column ">
  <a href="admin_users.php">Back to User Listing</a>
    <h2 class="center ">Edit User: <?php echo $userDetails['FirstName'] . " " . $userDetails['LastName'] ?></h2>
    <div class="center">
    <form action="edit_user_admin.php" method="post" class="less-wide register">

    <label for="UserId">User ID:</label>
      <input type="text" name="UserId" value="<?= $userDetails['UserID'] ?>" readonly>
        <label for="Firstname">Firstname:</label>
        <input type="text" name="Firstname" value="<?= htmlspecialchars($userDetails['FirstName']) ?>" required>

        <label for="Lastname">Lastname:</label>
        <input type="text" name="Lastname" value="<?= htmlspecialchars($userDetails['LastName']) ?>" required>

        <label for="Email">Email:</label>
        <input type="email" name="Email" value="<?= htmlspecialchars($userDetails['Email']) ?>" required>

        <label for="Address">Address:</label>
        <input type="text" name="Address" value="<?= htmlspecialchars($userDetails['Address']) ?>">

        <label for="UserType">User Type:</label>
     <select name="UserType" required>
    <option value="Customer" <?= ($userDetails['UserType'] == 'Customer') ? 'selected' : '' ?>>Customer</option>
    <option value="Admin" <?= ($userDetails['UserType'] == 'Admin') ? 'selected' : '' ?>>Admin</option>
     </select>
     <br> <br>
        <input type="submit" name="submit" value="Update" class="button">
    </form>
    </div>
    </main>
    <?php include 'footer.php' ?>
</body>
</html>
