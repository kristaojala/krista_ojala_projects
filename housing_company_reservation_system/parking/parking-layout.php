<?php
// Parkkipaikkanäkymän layout, jonka tein vaikeasti ihan haasteen vuoksi
// The layout of the parking lot view which I made difficulty just for the sake of the challenge
function generate_parking_layout($user_apartment, $parking_spots, $all_reservations) {
    $parkLayoutReturn = "";

    // Ylin rivi
    //Top row
    $parkLayoutReturn .=
    '<div class="parking-layout" id="parking-layout">
        <div class="top-row">
            <div class="house"><span class="parking-layout-text">Kotitalo</span></div>
            <div class="grass"></div>
        </div>';

    // Paikat 1-4
    //spots 1-4
    $parkLayoutReturn .= '<div class="parking-grid">';
    for ($i = 1; $i <= 4; $i++) {
        $spot_status = 'available';
        foreach ($parking_spots as $spot) {
            if ($spot['parking_spot'] == $i) {
                $spot_status = $spot['status']; // + status
                break;
            }
        }

        // luokkamuuttuja
        //class variable
        $reservation_class = '';

        // Onko varauksia
        //are there reservations
        foreach ($all_reservations as $reservation) {
            if ($reservation['parking_spot'] == $i) {
                if ($reservation['apartment'] == $user_apartment) { // Jos varattu käyttäjälle
                                                                    //If reserved to user
                    $reservation_class = 'reserved-to-user';
                } else { // Jos muu varaus
                         // If other reservation
                    $reservation_class = 'reserved';
                }
                break;
            }
        }

        // Jos ei ole varauksia, vapaa
        //If no reservations, free
        if (!$reservation_class) {
            $reservation_class = $spot_status === 'available' ? 'free' : $spot_status;
        }

        // Luokaksi tulee oikea luokka
        //Class will be the right class
        $class = $reservation_class;

        // Yksittäisen parkkipaikan koodi
        //code for singular parking spot
        $parkLayoutReturn .= '<div class="parking-spot border-top-spot ' . $class . '" 
                 id="spot-' . $i . '"
                 hx-get="parking/parking-reservation-modal.php?spot=' . $i . '"
                 hx-target="body"
                 hx-swap="beforeend">' . $i . '</div>';
    }
    $parkLayoutReturn .= '</div>'; // parking-grid end

    // tyhjä rivi
    //empty row
    $parkLayoutReturn .=
    '<div class="parking-grid empty-row">
        <span class="parking-layout-text">Kotikaduntie</span>
        <div class="parking-spot" id="empty"></div>
    </div>';

    // paikat 5 ja 6
    //spots 5 and 6
    $parkLayoutReturn .= '<div class="parking-grid">
        <div class="parking-spot border-bottom-spot" id="empty"></div>
        <div class="parking-spot border-bottom-spot" id="empty"></div>';
    for ($i = 5; $i <= 6; $i++) {
        $spot_status = 'available';
        foreach ($parking_spots as $spot) {
            if ($spot['parking_spot'] == $i) {
                $spot_status = $spot['status']; // + status
                break;
            }
        }

        // luokkamuuttuja
        //class variable
        $reservation_class = '';

        // Onko varaus
        //Is there a resrvation
        foreach ($all_reservations as $reservation) {
            if ($reservation['parking_spot'] == $i) {
                if ($reservation['apartment'] == $user_apartment) { // käyttäjän varaus
                                                                    //User reservation
                    $reservation_class = 'reserved-to-user';
                } else { // muu varaus
                         // other reservation
                    $reservation_class = 'reserved';
                }
                break;
            }
        }

        // Jos ei varauksia, vapaa
        //if no reservations, free
        if (!$reservation_class) {
            $reservation_class = $spot_status === 'available' ? 'free' : $spot_status;
        }

        // Lopullinen class
        //final class
        $class = $reservation_class;

        // yksittäisen parkkipaikan koodi
        //code for single parking spot
        $parkLayoutReturn .= '<div class="parking-spot border-top-spot ' . $class . '" 
                 id="spot-' . $i . '"
                 hx-get="parking/parking-reservation-modal.php?spot=' . $i . '"
                 hx-target="body"
                 hx-swap="beforeend">' . $i . '</div>';
    }
    $parkLayoutReturn .= '</div>'; // parking-grid

    $parkLayoutReturn .= '</div>';  // parking-layout div

    return $parkLayoutReturn;  // Palautus
                               //return
}
?>
