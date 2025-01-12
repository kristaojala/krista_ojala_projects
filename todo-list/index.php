<?php
include "functions.php";
session_start();
if (!isset($_SESSION['posts']) || !is_array($_SESSION['posts'])) {
    $_SESSION['posts'] = [];
}
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TODO List</title>
    <script src="/htmx.js"></script>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>To Do List</h1>
        <p>Input your tasks, mark them as done and delete them when you no longer need them.</p>
    </header>
    <main>
        <section>
            <form id="todo-list" 
            hx-post="post.php" 
            hx-target="#posts" 
            hx-swap="beforeend"
            hx-on::after-request="this.reset();
            document.querySelector('input').focus();"
            hx-disabled-elt="#todo-list button">
                <label for="post">New task:</label>
                <input required type="text" id="post" name="post">
                <button type="submit">Add to List</button>
            </form>

        </section>

        <section>
            <ul id="posts">
            <?php
                foreach ($_SESSION["posts"] as $id => $post) {
                    echo generatePost($id, $post);
                }
                ?>
            </ul>
        </section>
        <section>
            
        <form hx-delete="delete-all.php" 
             hx-target="#posts" 
             hx-swap="innerHTML" 
             hx-disabled-elt="#delete-all" 
             hx-confirm="Are you sure you want to clear the list? This is irreversible.">
            <button id="delete-all" type="submit">Clear List</button>
        </form>    
        </section>
    </main>
    <script>
    document.addEventListener('htmx:beforeRequest', function(event) {
        var triggeredElement = event.target;  
        if (triggeredElement.tagName.toLowerCase() === 'button' && triggeredElement.closest('li')) {
            triggeredElement.setAttribute('disabled', 'true');
        }
    });
</script>
</body>
</html>