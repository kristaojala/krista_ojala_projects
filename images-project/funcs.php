<?php 
//funktio palauttaa taulukosta kaksi satunnaista vapaana olevaa kuvaa
//the function returns two random images of free cats
function getSuggestedImages(){

include "data/images.php"; 

$selected = $_SESSION['selected-images'];

$availableImages = array_filter(
    $DATABASE_IMAGES, 
    function($image) use ($selected){
        return !in_array($image, $selected);
    }
); 

//määritellään indeksi uudestaan
//re-define index
$availableImages = array_values($availableImages);

//jos vain 2 tai alle kuvaa, palautetaan koko availableImages
//palautetaan 0, 1 tai 2 kuvaa taulukosta
//if only 2 or less images, return the whole availableImages
//return 0, 1 or 2 images from the array
if(count($availableImages) <= 2){
    //palautetaan taulukko ja lopetetaan suoritus
    //return array and stop 
return $availableImages;
}

//Jos päästään tänne, kuvia on yli 2 kpl
//if we are here, there are more than 2 images


$suggestedImage1 = array_splice($availableImages, rand(0, count($availableImages) - 1), 1)[0];
$suggestedImage2 = array_splice($availableImages, rand(0, count($availableImages) - 1), 1)[0];

return [$suggestedImage1, $suggestedImage2];

} //getSuggestedImages() end

?>