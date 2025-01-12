<?php 

session_start();

include "data/images.php"; // $DATABASE_IMAGES 
include "components/image.php"; // renderImage()
include "funcs.php";

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    // Käyttäjän klikkaaman kuvan id
    //id of the image the user picked
    $imageId = $_POST['imageId'];

    $image = null;
    // Jos tietokanta olisi käytössä, tässä haetaan ID:n perusteella tietokannasta
    //If the database was in use, the database would be searched based on the ID
    foreach($DATABASE_IMAGES as $img){
        if($img['id'] === $imageId){
            $image = $img;
            break; //ID found, break
        }
    }
//add to selected-images
    if($image){
        $_SESSION['selected-images'][] = $image;
    }

    echo renderImage($image, false);

    // Lisätään OOB ominaisuus, joka poistaa valitun kuvan aiemmasta listasta
    //Add an OOB feature that removes the selected image from the previous list

    echo "<ul id=\"available-images\" hx-swap-oob=\"true\">";
        $selected = $_SESSION['selected-images'];
        $availableImages = array_filter(
            $DATABASE_IMAGES, 
            function($image) use ($selected){
                return !in_array($image, $selected);
            }
        );

        foreach($availableImages as $image){
            echo renderImage($image);
        }
    echo "</ul>";  

    //päivitetään suggested images section myös
    //also update suggested images section
    $suggestedImages = getSuggestedImages();

    echo "<ul id=\"suggested-images\" hx-swap-oob=\"innerHTML\">";
            foreach( $suggestedImages as $image){
                echo renderImage($image);
            }
   echo "</ul>";
}

if($_SERVER['REQUEST_METHOD'] === 'DELETE'){
    if(isset($_GET['id'])){
        $imageId = $_GET['id'];

        // Etsitään sen taulukon indeksi, jossa on valitun kuvan id
        //find the index of the table with the id of the selected image

        $imageIndex = null; // kuvan indeksi sessiossa
                            //image index in session
        foreach($_SESSION['selected-images'] as $index => $image){
            
            if($imageId === $image['id']){
                $imageIndex = $index;
                break; 
            }
        }

        // Poistetaan taulukosta elementti, indeksin perusteella
        //remove element from array based on index
        if($imageIndex !== null){
            array_splice($_SESSION['selected-images'], $imageIndex, 1);

            //OOB
            echo "<ul id=\"available-images\" hx-swap-oob=\"true\">";
                $selected = $_SESSION['selected-images'];
                $availableImages = array_filter(
                    $DATABASE_IMAGES, 
                    function($image) use ($selected){
                        return !in_array($image, $selected);
                    }
                );

                foreach($availableImages as $image){
                    echo renderImage($image);
                }
            echo "</ul>";


        }
    }

}

?>