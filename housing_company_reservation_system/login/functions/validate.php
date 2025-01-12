<?php

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(isset($_POST['email']) && strpos($_POST['email'], "@") === false){
        echo "<p class='error'>Email address is invalid.</p>";
    }elseif(isset($_POST['email']) && strpos($_POST['email'], "@") !== false){
        echo ""; // email ok
    }elseif(isset($_POST['password']) && strlen($_POST['password']) < 8){
        echo "<p class='error'>Password must be at least 8 characters long.</p>";
    }elseif(isset($_POST['password']) && strlen($_POST['password']) >= 8){
        echo ""; // salasana ok
    }else{
        echo ""; // varana else - kaikki ok
    }
}

?>