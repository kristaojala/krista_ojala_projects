<?php

declare(strict_types=1);
function is_username_wrong(bool|array $result) {
    return !$result;
}

function is_password_wrong(string $password, string $hashedPassword) {
    return !password_verify($password, $hashedPassword);
}

function is_input_empty(string $username, string $password) {
    return empty($username) || empty($password);
}