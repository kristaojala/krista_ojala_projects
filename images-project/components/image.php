<?php 

    function renderImage($image, $isAvailableImage = true){
        $title = $image['title'];
        $src = "images/" . $image['display']['src'];
        $alt = $image['display']['alt'];

        $id = $image['id'];

        if($isAvailableImage){
            $attributes = "hx-post=\"select-image.php\"
                    hx-vals='{\"imageId\": \"$id\"}'
                    hx-target=\"#selected-images\"
                    hx-swap=\"beforeend show:#selected-images-section:top\"
                   data-action=\"add\"
                    ";
        }
        else{
            $attributes = "
                hx-delete=\"select-image.php?id=$id\"
                hx-target=\"closest li\"
                hx-swap=\"outerHTML\"
                 data-action=\"remove\"
            ";
        }
        
        $html = "
            <li>
                <button
                    $attributes
                >
                    <img src=\"$src\" alt=\"$alt\">
                    <h3>$title</h3>
                </button>
            </li>
        ";
        
        return $html;
    }
?>