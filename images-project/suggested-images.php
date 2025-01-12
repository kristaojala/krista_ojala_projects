<?php

session_start();
include "data/images.php"; // $DATABASE_IMAGES muuttuja
include "components/image.php"; // renderImage()
include "funcs.php";
 
if($_SERVER['REQUEST_METHOD'] === 'GET'){  
    $suggestedImages = getSuggestedImages($DATABASE_IMAGES);

        foreach($suggestedImages as $image){
            echo renderImage($image);
        }
 
}
 
?>