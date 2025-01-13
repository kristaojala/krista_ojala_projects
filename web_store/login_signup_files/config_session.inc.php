<?php

if (session_status() == PHP_SESSION_NONE) {
    ini_set("session.use_only_cookies", 1);
    ini_set("session.use_strict_mode", 1);

    session_set_cookie_params([
        "lifetime" => 1800,
        "domain" => "localhost",
        "path" => "/",
        "secure" => true,
        "httponly" => true
    ]);
    session_start();
}

$interval = 60 * 30;

if (!isset($_SESSION["last_generation"])) {
    regenerate_session_id();
} elseif (time() - $_SESSION["last_generation"] >= $interval) {
    regenerate_session_id();
}

function regenerate_session_id()
{
    session_regenerate_id(true);
    $_SESSION["last_generation"] = time();
}
function session_regenerate_id_loggedin()
{
    session_regenerate_id(true);

    $newSessionId = session_create_id();
    $sessionID = $newSessionId . "_" . $_SESSION["user_id"];
    session_id($sessionID);

    $_SESSION["last_generation"] = time();
}