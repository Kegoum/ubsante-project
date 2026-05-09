<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

// This function will return  
  // A random string of specified length 
//  function random_code($limit)
//{
//    return substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, $limit);
//}

//Opérations sur les dates
// Set timezone
date_default_timezone_set("UTC");


//fonction pour calculer l'age
function ageBirthday($birthday) {
    //Create a DateTime object using the user's date of birth.
$dob = new DateTime($birthday);

//We need to compare the user's date of birth with today's date.
$now = new DateTime();

//Calculate the time difference between the two dates.
$difference = $now->diff($dob);

//Get the difference in years, as we are looking for the user's age.
    return $difference->y;
}

// Time format is UNIX timestamp or
// PHP strtotime compatible strings
function dateDiff($time1, $time2, $precision = 6) {
    if ($time1 <= $time2) {
        // If not numeric then convert texts to unix timestamps
        if (!is_int($time1)) {
            $time1 = strtotime($time1);
        }
        if (!is_int($time2)) {
            $time2 = strtotime($time2);
        }

        // If time1 is bigger than time2
        // Then swap time1 and time2
//        if ($time1 > $time2) {
//          $ttime = $time1;
//          $time1 = $time2;
//          $time2 = $ttime;
//        }
        // Set up intervals and diffs arrays
        $intervals = array('year', 'month', 'day', 'hour', 'minute', 'second');

        $diffs = array();

        // Loop thru all intervals
        foreach ($intervals as $interval) {
            // Set default diff to 0
            $diffs[$interval] = 0;
            // Create temp time from time1 and interval
            $ttime = strtotime("+1 " . $interval, $time1);
            // Loop until temp time is smaller than time2
            while ($time2 >= $ttime) {
                $time1 = $ttime;
                $diffs[$interval] ++;
                // Create new temp time from time1 and interval
                $ttime = strtotime("+1 " . $interval, $time1);
            }
        }

        $count = 0;
        $times = array();
        $temps = array();
        // Loop thru all diffs
        foreach ($diffs as $interval => $value) {
            // Break if we have needed precission
            if ($count >= $precision) {
                break;
            }
            // Add value and interval
            // if value is bigger than 0
//          if ($value > 0) {
            // Add s if value is not 1
            if ($value != 1) {
                $interval .= "s";
            }
            // Add value and interval to times array
//             $intervals_no['second'] = 'seconde';
//         $intervals_no['seconds'] = 'secondes';
//             
//             $intervals_no['minute'] = 'minute';
//         $intervals_no['minutes'] = 'minutes';
//             
//             $intervals_no['hour'] = 'heure';
//         $intervals_no['hours'] = 'heures';
//             
//             $intervals_no['day'] = 'jour';
//         $intervals_no['days'] = 'jours';
//             
//             $intervals_no['month'] = 'mois';
//         $intervals_no['months'] = 'mois';
//             
//             $intervals_no['year'] = 'an';
//         $intervals_no['years'] = 'ans';

            $intervals_no['second'] = 's';
            $intervals_no['seconds'] = 'S';

            $intervals_no['minute'] = 'm';
            $intervals_no['minutes'] = 'M';

            $intervals_no['hour'] = 'h';
            $intervals_no['hours'] = 'H';

            $intervals_no['day'] = 'j';
            $intervals_no['days'] = 'J';

            $intervals_no['month'] = 'm';
            $intervals_no['months'] = 'M';

            $intervals_no['year'] = 'a';
            $intervals_no['years'] = 'A';

            $times[] = $value . " " . $intervals_no[$interval];
            $temps[$count] = $value;

            $count++;
        }
//        }
        // Return string with times
//        return implode(", ", $times);
        return $temps;
    } else {
        return 0;
    }
}

function date_heure() {
    $heure = '<script type="text/javascript">document.write(""+h+":"+m+":"+s+"");</script>';
    return $heure;
}
function sommedatemois($dateDepart, $duree) {
    //la première étape est de transformer cette date en timestamp
    $dateDepartTimestamp = strtotime($dateDepart);

//on calcule la date de fin
    $dateFin = date('Y-m-d', strtotime('+' . $duree . ' month', $dateDepartTimestamp));
//echo $dateFin;

    return $dateFin;
}

function sommedateannee($dateDepart, $duree) {
    //la première étape est de transformer cette date en timestamp
    $dateDepartTimestamp = strtotime($dateDepart);

//on calcule la date de fin
    $dateFin = date('Y-m-d', strtotime('+' . $duree . ' year', $dateDepartTimestamp));
//echo $dateFin;

    return $dateFin;
}


/**************************************************************************************/
/*
     Titre  : Calculer le temps restant ou le temps ecoulé                                                                
                                                                                                                          
     URL    :  
     http://phpsources.org/code/php/date-heure/457_calculer-le-temps-restant-ou-le-temps-ecoule
     Auteur         : IlbeeNetwork                                                                                        
     Date edition   : 09 Sept 2008                                                                                        
*/
/**************************************************************************************/
function Date_ConvertSqlTab($date_sql) {
    $jour = substr($date_sql, 8, 2);
    $mois = substr($date_sql, 5, 2);
    $annee = substr($date_sql, 0, 4);
    $heure = substr($date_sql, 11, 2);
    $minute = substr($date_sql, 14, 2);
    $seconde = substr($date_sql, 17, 2);
    
    $key = array('annee', 'mois', 'jour', 'heure', 'minute', 'seconde');
    $value = array($annee, $mois, $jour, $heure, $minute, $seconde);
    
    $tab_retour = array_combine($key, $value);
    
    return $tab_retour;
}
function AuPluriel($chiffre) {
    if($chiffre>1) {
        return 's';
    };
}
function TimeToJourJ($date_sql) {
    $tab_date = Date_ConvertSqlTab($date_sql);
    $mkt_jourj = mktime($tab_date['heure'],
                    $tab_date['minute'],
                    $tab_date['seconde'],
                    $tab_date['mois'],
                    $tab_date['jour'],
                    $tab_date['annee']);
    $mkt_now = time();
    
    $diff = $mkt_jourj - $mkt_now;
    
    $unjour = 3600 * 24;
    
    if($diff>=$unjour) {
        // EN JOUR
        $calcul = $diff / $unjour;
        return 'Il reste <strong>'.ceil($calcul).' jour'.AuPluriel($calcul).'</strong>.';
    } elseif($diff<$unjour && $diff>=0 && $diff>=3600) {
        // EN HEURE
        $calcul = $diff / 3600;
        return 'Il reste <strong>'.ceil($calcul).' heure'.AuPluriel($calcul).'</strong>.';
    } elseif($diff<$unjour && $diff>=0 && $diff<3600) {
        // EN MINUTES
        $calcul = $diff / 60;
        return 'Il reste <strong>'.ceil($calcul).' minute'.AuPluriel($calcul).'</strong>.';
    } elseif($diff<0 && abs($diff)<3600) {
        // DEPUIS EN MINUTES
        $calcul = abs($diff) / 60;
        return 'Depuis <strong>'.ceil($calcul).' minute'.AuPluriel($calcul).'</strong>.';
    } elseif($diff<0 && abs($diff)<=3600) {
        // DEPUIS EN HEURES
        $calcul = abs($diff) / 3600;
        return 'Depuis <strong>'.ceil($calcul).' heure'.AuPluriel($calcul).'</strong>.';        
    } else {
        // DEPUIS EN JOUR
        $calcul = abs($diff) / $unjour;
        return 'Depuis <strong>'.ceil($calcul).' jour'.AuPluriel($calcul).'</strong>.';
    };
}

// EXEMPLE //
// Affiche le temps passé depuis le 28 juin 2008 a 14h //
// Le jour de mon mariage //
//echo 'Temps depuis le 28 juin 2008 à 14 heures : ';
//echo TimeToJourJ('2008-06-28 14:00:00');
//echo '<br /><br />';
// EXEMPLE //
// Affiche le temps restant jusqu'au 01 janvier prochain //
//$next_jourdelan = date('Y') + 1;
//echo 'Temps restant jusqu\'au prochain jour de l\'an : ';
//echo TimeToJourJ($next_jourdelan.'-01-01 00:00:00');
?>
