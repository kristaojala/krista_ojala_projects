<?php

include "data/images.php"; // $DATABASE_IMAGES var
include "components/image.php"; // renderImage()
include "funcs.php";

session_start();

// Luodaan sessio muuttuja, jos sitä ei vielä ole
//make session variable if it doesn't already exist
if(!isset($_SESSION['selected-images'])){
    $_SESSION['selected-images'] = [];
}

?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cat Picker</title>
    <script src="/htmx.js" defer></script>
    <script src="main.js" defer></script>
    <script src="https://unpkg.com/htmx.org@1.9.12/dist/ext/debug.js" defer></script>
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="images/cat-logo.png" type="image/x-icon">
</head>

    <body>

    <header>
    <img class="logo" src="images/cat-logo.png" alt="Cat Logo">
    <h1>Cat Picker</h1>
    <p>Pick a collection of cats from the selection! <br>Simply click the cats you want to add or remove.</p>
    </header>
    <main>
        <section id="suggested-images-section">
            <h2>Currently Suggested</h2>
            <ul id="suggested-images"
            hx-get="suggested-images.php"
            hx-swap="innerHTML"
            hx-trigger="every 5s"
            >
            <?php 
            $suggestedImages = getSuggestedImages();
                    foreach( $suggestedImages as $image){
                        echo renderImage($image);
                    }
                ?>
            </ul>
            <div id="loading"></div>
        </section>

        <section id="selected-images-section">
            <h2>Selected Cats</h2>
            <ul id="selected-images">
                <?php 
                    foreach($_SESSION['selected-images'] as $image){
                        // generoi li-elementin HTML koodin, $image datan pohjalta
                        //generates the li-element's HTML code from $image's data
                        echo renderImage($image, false);
                    }
                ?>
            </ul>

           

        </section>
        <section>
             <h2>Available Cats</h2>
             <ul id="available-images">
                <?php 
                    // Käydään läpi /data/images.php tiedoston
                    // muuttujan $DATABASE_IMAGES taulukko
                    // "tietokannasta haettu"

                    //Go through /data/images.php file's
                    //variable $DATABASE_IMAGES array
                    //"fetch from database"

                    $selected = $_SESSION['selected-images'];
                    // suodattaa pois kuvat, jotka käyttäjä on jo valinnut
                    //filter out the images user has already selected
                    $availableImages = array_filter(
                        $DATABASE_IMAGES, 
                        function($image) use ($selected){
                            return !in_array($image, $selected);
                        }
                    );   

                    foreach($availableImages as $image){
                        echo renderImage($image);
                    }
                ?>
             </ul>
        </section>
    </main>
</body>
</html>