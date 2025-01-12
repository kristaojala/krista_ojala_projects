<?php
session_start();
usleep(4000000);

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    if (isset($_GET['post'])) {
        $id = $_GET['post'];
        if (isset($_SESSION['posts'][$id])) {
            unset($_SESSION['posts'][$id]);
        } else {
            echo "Post not found";
        }
    } else {
        echo "No ID provided";
    }
} else {
    echo "Not a DELETE request method";
}

exit();
