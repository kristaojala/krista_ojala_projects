<?php
    function generateAdminTable($headers,$data){

        // Otetaan tämän hetken päivä ja kellonaika muuttujiin
        $currentday = strtotime(date('d.m.Y'));
        $timeOfDay = strtotime(date('H.i', strtotime('+2 hours')));
        
        // Määritellään nykyisen viikon alku ja lopetus taulukkoa varten
        // Tarkistetaan, onko maanantai
        if(date('D')!='Mon')
        {    
            // Jos ei ole maanantai tallenetaan muuttujaan viimeisin maanantai
            $staticstart = date('d.m.Y',strtotime('last Monday'));    
        }else{
            // Jos on maanantai tallennetaan muuttujaan nykyinen päivä
            $staticstart = date('d.m.Y');   
        }

        // Tarkistetaan, onko sunnuntai
        if(date('D')!='Sun')
        {
            // // Jos ei ole sunnuntai tallenetaan muuttujaan viimeisin sunnuntai
            $staticfinish = date('d.m.Y',strtotime('next Sunday'));
        }else{
            // Jos on sunnuntai tallennetaan muuttujaan nykyinen päivä
            $staticfinish = date('d.m.Y');
        }

        // Luodaan aluksi tyhjä taulukko viikonpäiville
        $datesThisWeek = array();
        // Määritellään missä muodossa päiväykset tallentuvat
        $format = 'd.m.Y';

        // Määritellään päiväyksille yhden päivän intervalli
        $interval = new DateInterval('P1D');
        $realEnd = new DateTime($staticfinish);
        $realEnd->add($interval);
        $period = new DatePeriod(new DateTime($staticstart), $interval, $realEnd);
        
        // Käydään silmukassa läpi viikon päivät ja tallebetaan taulukkoon
        foreach($period as $date){
            $datesThisWeek[] = $date->format($format);
        }

        $reservationIndex = 0;

        // Tehdään tässä kohtaa tietokanta haku
        require "db_conn.php";


        // Tässä haetaan tiedot varaustaulukon generointiin
        $stmt = $conn->prepare("SELECT * FROM sauna_reservations");
        $stmt->execute();
        $result = $stmt->get_result();
    
        // Generoidaan taulukon otsikkorivi
        $html = "<tr>";
        $html .= "<th>Kellon aika</th>";
        $dateIndex = 0;
        foreach($headers as $header){
            $date = $datesThisWeek[$dateIndex];
            $html .= "<th class='border-left'>$header<br> $date</th>";
            $dateIndex += 1;
        }
        $html .= "</tr>";

            // generoidaan data rivit
            $dateIndex2 = 0;
            while($slot = $result->fetch_assoc()){
                $slotNumber = $slot['reservation_slot'];
                $reservee = $slot['userID'];
                $weekday = $slot['weekday'];
                $currentHour = $slot['starting_hour'];
                $nextHour = $currentHour+1;
                $dbTimeAsString = "$currentHour.00";
                $timeOfReservation = strtotime($dbTimeAsString);

                if($weekday === 'Maanantai') {
                    $html .= "<tr>";
                    $html .= "<td>$currentHour.00-$nextHour.00</td>";
                }
                    
                $arraydate = $datesThisWeek[$dateIndex2];

                if($reservee == $_SESSION['user_apartment']){
                    //$html .= "<td class='border-left'><button class='reserved' disabled hx-vals='{\"reservationId\": \"$reservee\",\"reservationSlot\": \"$slotNumber\"}'>Varattu</button></td>";
                    //$html .= "<td class='border-left'><button class='reserved-for-user' hx-post='sauna/functions/unreserve.php' hx-target='table' hx-swap='innerHTML' hx-vals='{\"reservationId\": \"$reservee\",\"reservationSlot\": \"$slotNumber\"}'>Poista varaus</button></td>";
                    $html .= "<td class='border-left'><button class='not-available' disabled>Vapaa</button></td>";
                }else{
                    $html .= "<td class='border-left'><button class='available' hx-post='sauna/functions/reserve.php' hx-target='table' hx-swap='innerHTML' hx-vals='{\"reservationId\": \"$reservee\",\"reservationSlot\": \"$slotNumber\"}'>Varattu asunnolle: $reservee</button></td>";
                    //$html .= "<td class='border-left'><button class='reserved' disabled hx-vals='{\"reservationId\": \"$reservee\",\"reservationSlot\": \"$slotNumber\"}'>Varattu</button></td>";
                }
                
                $dateIndex2 += 1;

                if($weekday === 'Sunnuntai') {
                    $html .= "</tr>";
                    $dateIndex2 = 0;
                }
        }
        // Suljetaan tietokantayhteys
        $stmt->close();

        return $html;
    }
?>