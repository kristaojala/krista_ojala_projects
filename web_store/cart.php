<?php
session_start();
$servername = "mysql_db";
$databasename = "verkkokauppa";
$dbusername = "root";
$dbpassword = "root";

try {
    $pdo_conn = new PDO("mysql:host=$servername;dbname=$databasename", $dbusername, $dbpassword);
    $pdo_conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed:" . $e->getMessage();
}

if (isset($_SESSION["user_id"])) {
    $userID = $_SESSION["user_id"];
    $userQuery = $pdo_conn->prepare("SELECT * FROM users WHERE UserID = :userID");
    $userQuery->bindParam(':userID', $userID, PDO::PARAM_INT);
    $userQuery->execute();
    $userDetails = $userQuery->fetch(PDO::FETCH_ASSOC);
}



if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["deleteItem"])) {
    $itemID = $_GET["itemID"];


    $_SESSION["product"] = array_filter(
        $_SESSION["product"],
        function ($cartItem) use ($itemID) {
            return $cartItem["itemID"] != $itemID;
        }
    );

    $totalOrderPrice = calculateTotalOrderPrice($_SESSION["product"]);
    echo json_encode(["totalOrderPrice" => $totalOrderPrice]);
    exit();
}

function calculateTotalOrderPrice($cart) {
    $shipping = 8.95;
    $totalOrderPrice = 0;

    foreach ($cart as $cartItem) {
        $itemID = $cartItem["itemID"];
        $stmt = $GLOBALS["pdo_conn"]->prepare("SELECT Price FROM products WHERE ProductID = :itemID");
        $stmt->bindParam(':itemID', $itemID, PDO::PARAM_INT);
        $stmt->execute();
        $productDetails = $stmt->fetch(PDO::FETCH_ASSOC);
        $totalOrderPrice += $cartItem["Quantity"] * $productDetails["Price"];
    }

    $totalOrderPrice += $shipping;
    return $totalOrderPrice;
}
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/style.css">
    <link rel="shortcut icon" href="media/favicon.png" type="image/x-icon">
    <title>Shopping Cart</title>
</head>
<body>
 
<?php
    include "header.php";
    ?>
    <main class="simple-column less-wide">
    <h2>Your Cart</h2>
    <?php 
        $shipping = 8.95; //Tämä tulisi oikeasti varmaankin tietokannasta, mutta nyt mennään tällä
        $totalOrderPrice = 0; 
        
        if (!empty($_SESSION["product"])) :
        ?>
            <table>
                <tr>
                  <th>Product</th>
                 <th>Quantity</th>
                 <th>Price</th>
                <th> </th>
                </tr>
    
                <?php
                foreach ($_SESSION["product"] as $cartItem) :
                    $itemID = $cartItem["itemID"];
                    $stmt = $pdo_conn->prepare("SELECT ProductName, Price FROM products WHERE ProductID = :itemID");
                    $stmt->bindParam(':itemID', $itemID, PDO::PARAM_INT);
                    $stmt->execute();
                    $productDetails = $stmt->fetch(PDO::FETCH_ASSOC);
                    $totalItemPrice = $cartItem["Quantity"] * $productDetails["Price"];
                     $totalOrderPrice += $totalItemPrice;
                    ?>
    
                    <tr>
                        <td><?php echo $productDetails["ProductName"]; ?></td>
                        <td><?php echo $cartItem["Quantity"]; ?> </td>
                        <td><?php echo $totalItemPrice . "€"; ?> </td>
                        <td><a class="delete-link" href="cart.php"  data-itemid="<?php echo $itemID; ?>">Delete</a></td>
                    </tr>
    
                 <?php endforeach; ?>
    
            </table>
    
            <?php $totalOrderPrice += $shipping; ?>
    
            <p>Shipping: &nbsp;&nbsp;&nbsp;
                <?php echo $shipping . "€"; ?>
            </p>
    
            <p><b>Total Price: &nbsp;&nbsp;&nbsp;</b>
                <b><?php echo $totalOrderPrice . "€"; ?></b>
            </p>
    
        <?php else : ?>
    
            <p>Your cart is empty</p>
    
        <?php endif; ?>
    
        <?php 
        if (!empty($_SESSION["product"])) :
        ?>
            <div class="customer-info">
                <p>Ready to order? Please fill in your information below.</p>
                <h3>Shipping Address</h3>
                <form action="send_order.php" method="post">
                    <table>
                    <tr>
        <td><label for="firstname">First name:</label></td>
        <td><input type="text" id="firstname" name="firstname" value="<?php echo isset($userDetails['FirstName']) ? $userDetails['FirstName'] : ''; ?>"></td>
        <td><label for="lastname">Last name:</label></td>
        <td><input type="text" id="lastname" name="lastname" value="<?php echo isset($userDetails['LastName']) ? $userDetails['LastName'] : ''; ?>"></td>
      </tr>
      <tr>
        <td><label for="email">E-Mail:</label></td>
        <td colspan="3"><input type="text" id="email" name="email" class="wide-input" value="<?php echo isset($userDetails['Email']) ? $userDetails['Email'] : ''; ?>"></td>
      </tr>
      <tr>
      <td><label for="address">Address:</label></td>
      <td colspan="3"><input type="text" id="address" name="address" class="wide-input" value="<?php echo isset($userDetails['Address']) ? $userDetails['Address'] : ''; ?>"></td>
      </tr>
                    </table>
    
                    <label for="check">I agree to the <a href="terms.php" target="_blank"><b>Terms of Service</b></a></label>
                    <input type="checkbox" name="check" id="check" onclick="enable()">
                    <br>
                    <input type="hidden" name="orderConfirmed" value="1">
                    <button class="button" name="confirmOrder" disabled="true" id="confirmbtn">Confirm Order</button>
                </form>
            </div>
        <?php endif; ?>
    </main>
    
    <?php
   include "footer.php";
   ?>
  
</body>
<script>
function enable(){
    var  check= document.getElementById("check");
    var  confirmbtn= document.getElementById("confirmbtn");
    if(check.checked){
        confirmbtn.removeAttribute("disabled");
    }
    else{
        confirmbtn.disabled ="true";
    }
}


document.addEventListener("DOMContentLoaded", function() {
    document.querySelectorAll('.delete-link').forEach(function(link) {
        link.addEventListener('click', function(event) {
            event.preventDefault();
            removeFromCart(this);
        });
    });



    function removeFromCart(link) {
        var itemID = link.getAttribute('data-itemid');
     
        fetch('?deleteItem=1&itemID=' + itemID)
            .then(function(response) {
                return response.json();
            })
            .then(function(data) {
          
                location.reload();
            });
    }
});
</script>
</html>
