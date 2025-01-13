<?php
session_start();

if (!isset($_SESSION["user_id"]) || $_SESSION["user_type"] !== "Admin") {
    header("Location: index.php");
    exit();
}

$servername = "localhost";
$databasename = "verkkokauppa";
$username = "root";
$password = "";

try {
    $pdo_conn = new PDO("mysql:host=$servername;dbname=$databasename", $username, $password);
    $pdo_conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed:" . $e->getMessage();
    exit();
}

require_once 'edit_include_files/user_operations.inc.php';

$operationResult = ""; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete'])) {
        $userIdToDelete = $_POST["user_id"];
        $operationResult = delete_user($pdo_conn, $userIdToDelete);
    }

    if (isset($_POST['restore'])) {
        $userIdToRestore = $_POST["user_id"];
        $operationResult = restore_user($pdo_conn, $userIdToRestore);
    }
}

try {
    $queryUsers = $pdo_conn->prepare("SELECT * FROM users");
    $queryUsers->execute();
    $usersData = $queryUsers->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Query failed:" . $e->getMessage();
    exit();
}
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/style.css">
    <link rel="shortcut icon" href="media/favicon.png" type="image/x-icon">
    <title>Admin - Users</title>
</head>
<body>
<?php
    include "header.php";
    ?>
    <main class="simple-column">
    <h1>Admin - Users Page</h1>
    <div class= "admin-links">
    <a href="admin.php">Admin - Main</a>
    <a href="admin_products.php">Admin - Products Page</a>
    <a href="admin_orders.php">Admin - Orders Page</a>
    </div>

    <h2 class="center">Users</h2>
    <div class="empty-space">
    <?php if(isset($operationResult)) { echo $operationResult; }  ?>
    </div>

         <table class='admin-table'>
            <tr>
            <th>Type</th>
            <th>ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>E-mail</th>
            <th>Address</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>

            <?php foreach ($usersData as $userinfo): ?>
                
                <tr <?php if( $userinfo['deleted_at'] !== null ) echo "class='deleted'"; ?> > 
                <?php 
                   echo "<td>" ."<p>" . $userinfo["UserType"] . "</p>". "</td>";
                echo "<td>" ."<p>" . $userinfo["UserID"] . "</p>". "</td>";
            echo "<td>". "<p>" . $userinfo["FirstName"] . "</p>". "</td>";
            echo "<td>" ."<p>" . $userinfo["LastName"] . "</p>". "</td>";
            echo "<td>". "<p>" . $userinfo["Email"] . "</p>". "</td>";
            echo "<td>" ."<p>" . $userinfo["Address"] . "</p>". "</td>";
            echo "<td class='edit_user_admin'>" ."<a href='edit_user_admin.php?UserID=". $userinfo["UserID"] . "'>" . "Edit User" . "</a>". "</td>";
            ?>
    <?php if($userinfo['deleted_at'] === null): ?>
        <td class="delete_user"> 
        <form action="admin_users.php" method="post">
        <input type="hidden" name="user_id" value="<?= $userinfo["UserID"] ?>">
            <button class="admin-actions-button" name="delete" type="submit">Delete User</button>
            </form>
            </td>
    <?php else: ?>
        <td class="restore_user"> 
        <form action="admin_users.php" method="post">
            <input type="hidden" name="user_id" value="<?= $userinfo["UserID"] ?>">
            <button class="admin-actions-button" name="restore" type="submit">Restore User</button>
        </form>
        </td>
    <?php endif; ?>

            </tr> 
            <?php endforeach; ?>
        </table>
    </main>
     <?php
   include "footer.php";
   ?>
</body>
</html>