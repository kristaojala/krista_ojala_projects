<?php
session_start();
include "functions.php"; 

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['post']) && isset($_GET['completed'])) {
        $id = $_GET['post'];
        $completed = $_GET['completed'] === '1';

        if (isset($_SESSION['posts'][$id])) {
            $_SESSION['posts'][$id]['completed'] = $completed;

            echo generatePost($id, $_SESSION['posts'][$id]);
        } else {
            echo "Post not found";
        }
    } else {
        echo "Invalid parameters";
    }
} else {
    echo "Not a GET request method";
}

exit();
