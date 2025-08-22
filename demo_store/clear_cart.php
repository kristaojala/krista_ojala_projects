<?php
session_start();

// Tyhjennetään ostoskori
// Clean cart
unset($_SESSION["product"]);

// Ohjataan takaisin kaupalle
// Redirect back to the store
header("Location: index.php");
exit();
