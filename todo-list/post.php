<?php
include "functions.php";
session_start();
usleep(400000);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['post']) && is_string($_POST['post'])) {
        $id = uniqid(); 
        $_SESSION['posts'][$id] = ['text' => $_POST['post'], 'completed' => false];

        echo generatePost($id, $_SESSION['posts'][$id]);
    } else {
        echo "Invalid post data";
    }
} else {
    echo "Not a POST request method";
}

exit();
