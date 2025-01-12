<?php
    if(isset($_SESSION['user_apartment'])){
        header("Location: ./index.php?page=home");
    }
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="login/login.css">
    <script src="htmx.js" defer></script>
    <script src="login/htmx-response-targets.js" defer></script>
</head>
<body>
<main class="login-main">
    <h1>Kirjautuminen</h1>
    <h3 class="notification" style="opacity:0;">text</h3>
    <div class="login-box">
        <h2>Kirjaudu</h2>
        <form
            hx-ext="response-targets"
            hx-post="login/functions/login.php" 
            hx-headers='{"x-csrf-token":"5jg6ft2qw7rd8yv"}'
            hx-target-4*="#extra-information"
            hx-target-5*=".control"
            hx-sync="this: replace"
        >
        <div class="control">
                    <label for="email">Email:</label>
                    <input id="email" type="email" name="email"
                        hx-post="login/functions/validate.php"
                        hx-target="next p"
                        hx-swap="outerHTML"
                        hx-params="email"
                        hx-headers='{"x-csrf-token":"5jg6ft2qw7rd8yv"}'
                    >
                    <p class="error hidden"> blanc message</p>
                </div>
                <div class="control">
                    <label for="password">Password:</label>
                    <input id ="password" type="password" name="password"
                        hx-post="login/functions/validate.php"
                        hx-target="next p"
                        hx-swap="outerHTML"
                        hx-params="password"
                        hx-headers='{"x-csrf-token":"5jg6ft2qw7rd8yv"}'
                    >
                    <p class="error hidden">blanc message</p>
                </div>
                <div id="extra-information"></div>
                <button type="submit">
                    Login
                </button>
        </form>
    </div>
</main>
</body>
</html>