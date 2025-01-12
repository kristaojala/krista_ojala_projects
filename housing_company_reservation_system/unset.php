<?php
//Session tuhoaminen tarvittaessa, for debugging
//Session destruction if necessary, for debugging

session_start();
session_unset();
session_destroy();

header("Location: index.php");
exit;
?>
