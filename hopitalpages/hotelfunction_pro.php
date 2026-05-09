<?php
//Opérations sur les dates
// Set timezone
date_default_timezone_set("UTC");

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

function dates_range($debut, $fin) {

    if ($debut < $fin) {
        $tDeb = explode("-", $debut);
        $tFin = explode("-", $fin);

        $diff = mktime(0, 0, 0, $tFin[1], $tFin[2], $tFin[0]) -
                mktime(0, 0, 0, $tDeb[1], $tDeb[2], $tDeb[0]);

        return(($diff / 86400) + 1);
    } else {
        return 0;
    }
}

function dates_range11111($date1, $date2) {
    $jour = 0;
    if ($date1 < $date2) {
        $dates_range[] = $date1;
        $date1 = strtotime($date1);
        $date2 = strtotime($date2);
        while ($date1 != $date2) {
            $date1 = mktime(0, 0, 0, date("m", $date1), date("d", $date1) + 1, date("Y", $date1));
            $dates_range[] = date('Y-m-d', $date1);
            $jour = $jour + 1;
        }
    }
    return $jour;
}

function sommedatejour($dateDepart, $duree) {
    //la première étape est de transformer cette date en timestamp
    $dateDepartTimestamp = strtotime($dateDepart);

//on calcule la date de fin
    $dateFin = date('Y-m-d', strtotime('+' . $duree . ' day', $dateDepartTimestamp));
//echo $dateFin;

    return $dateFin;
}

function sommedatemois($dateDepart, $duree) {
    //la première étape est de transformer cette date en timestamp
    $dateDepartTimestamp = strtotime($dateDepart);

//on calcule la date de fin
    $dateFin = date('Y-m-d', strtotime('+' . $duree . ' month', $dateDepartTimestamp));
//echo $dateFin;

    return $dateFin;
}

//gestion des Regions
//fonction pour ajouter une Region
function ajouter_region($coder, $libr, $cheflr, $con) {
    $req = $con->query("select * from hotel_region where code_reg= '" . $coder . "' or nom_reg= '" . $libr . "' "
            . "or chef_lieu_reg= '" . $cheflr . "'") or die(mysqli_error($con));
    $nb = mysqli_num_rows($req);
    if (($nb == 0)) {
        $rslt = $con->query("insert into hotel_region(code_reg, nom_reg, chef_lieu_reg) values('" . $coder . "', "
                . "'" . $libr . "', '" . $cheflr . "')") or die(mysqli_error($con));
        echo "<script language='javascript'>$('div.alertuseraddbon').show('slow').delay(8000).hide('slow');</script>";
    } else {
        echo "<script language='javascript'>$('div.alertaddmauv').show('slow').delay(8000).hide('slow');</script>";
    }
}

//parametre de l'ecole
function update_hotel($id, $hotel, $codeho, $codeposho, $typeho, $sloganh, $telh, $adresseh, $logoa, $logon, $con) {
    $hotel = addslashes($hotel);
    $sloganh = addslashes($sloganh);
    if ($id == NULL) {
        if ($logon != NULL) {
// On peut valider le fichier et le stocker définitivement
            move_uploaded_file($_FILES['logon']['tmp_name'], "hotelimages/logo/" . basename($_FILES['logon']['name']));
        } else {
            $logon = "logo.jpeg";
        }
        $rslt = $con->query("insert into hotel_proprietaire(email_p,tel_p,hotel,code_h,type_h,code_postal_h,slogan_h,logo_h) 
				  values('" . $adresseh . "','" . $telh . "','" . $hotel . "','" . $codeho . "','" . $typeho . "',"
                . "'" . $codeposho . "', '" . $sloganh . "','" . $logon . "')") or die(mysqli_error($con));
        echo "<script language='javascript'>$('div.alertuseraddbon').show('slow').delay(8000).hide('slow');</script>";
//echo "bien";
    } else {
        if ($logon != NULL) {
            if ($logoa != "logo.jpeg") {
                unlink("hotelimages/logo/" . $logoa);
            }
            // On peut valider le fichier et le stocker définitivement
            move_uploaded_file($_FILES['logon']['tmp_name'], "hotelimages/logo/" . basename($_FILES['logon']['name']));
        } else {
            $logon = $logoa;
        }
        $rslt = $con->query("update hotel_proprietaire set email_p='" . $adresseh . "', tel_p='" . $telh . "', hotel='" . $hotel . "', "
                . "code_h='" . $codeho . "', type_h='" . $typeho . "', code_postal_h='" . $codeposho . "', slogan_h='" . $sloganh . "', "
                . "logo_h='" . $logon . "' where id_proprietaire='" . $id . "'") or die(mysqli_error($con));
        echo "<script language='javascript'>$('div.alertuseraddbon').show('slow').delay(8000).hide('slow');</script>";
//echo "bon";
    }
}

//fonction pour lister les Regions
function lister_region($con) {
    $rsltuser = $con->query('select * from hotel_region') or die(mysqli_error($con));
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        ?>

        <tr >
            <td><?php print nl2br(htmlspecialchars($recuser["id_region"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["code_reg"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["nom_reg"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["chef_lieu_reg"])) ?></td>
            <td>
                <?php
                if (isset($_SESSION["loginproprietaire"])) {
                    ?>

                    <a href="indexproprietaire.php?page=<?php echo base64_encode('hotelpages/regionhotel/editer_region') ?>&region=<?php echo $recuser["id_region"] ?>">
                        <span title="Modifier cette r&eacute;gion" alt="editer"><i class="glyphicon glyphicon-edit"></i></span>
                    </a>&nbsp;&nbsp;
                    <a href='#' onclick=del_hotel_region(<?php echo $recuser["id_region"] ?>)>
                        <span title="Supprimer cette region" alt="suppr"><i class="glyphicon glyphicon-remove"></i></span>
                    </a>
                    <?php
                } else {
                    ?>
            <!--                        <a href="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/regionhotel/editer_region') ?>&region=<?php echo $recuser["id_region"] ?>">
                            <span title="Modifier cette r&eacute;gion" alt="editer"><i class="glyphicon glyphicon-edit"></i></span>
                        </a>-->
                    <?php
                }
                ?>
            </td>
        </tr>

        <?php
    }
}

//fonction pour modifier une Region
function editer_region($id, $coder, $libr, $cheflr, $con) {
    $req = $con->query("select * from hotel_region where code_reg = '" . $coder . "' or nom_reg = '" . $libr . "' "
            . "or chef_lieu_reg = '" . $cheflr . "'") or die(mysqli_error($con));
    $nb = mysqli_num_rows($req);
    if (($nb == 0)) {
        $rslt = $con->query("update hotel_region set code_reg='" . $coder . "', nom_reg='" . $libr . "', "
                . "chef_lieu_reg='" . $cheflr . "' where id_region='" . $id . "'") or die(mysqli_error($con));
        echo "<script language='javascript'>$('div.alertmodifbon').show('slow').delay(8000).hide('slow');</script>";
    } else {
        $recuser = mysqli_fetch_array($req);
        if ($id == $recuser["id_region"]) {
            $rslt = $con->query("update hotel_region set code_reg='" . $coder . "', nom_reg='" . $libr . "', "
                    . "chef_lieu_reg='" . $cheflr . "' where id_region='" . $id . "'") or die(mysqli_error($con));
            echo "<script language='javascript'>$('div.alertmodifbon').show('slow').delay(8000).hide('slow');</script>";
        } else {
            echo "<script language='javascript'>$('div.alertaddmauv').show('slow').delay(8000).hide('slow');</script>";
        }
    }
}

//gestion des Departements
//fonction pour ajouter une Repartement
function ajouter_departement($reg, $libdep, $chefldep, $con) {
    $req = $con->query("select * from hotel_departement where libelle_de= '" . $libdep . "' "
            . "or chef_lieu_de= '" . $chefldep . "'") or die(mysqli_error($con));
    $nb = mysqli_num_rows($req);
    if (($nb == 0)) {
        $rslt = $con->query("insert into hotel_departement(id_region, libelle_de, chef_lieu_de) values('" . $reg . "', '" . $libdep . "', '" . $chefldep . "')") or die(mysqli_error($con));
        echo "<script language='javascript'>$('div.alertuseraddbon').show('slow').delay(8000).hide('slow');</script>";
    } else {
        echo "<script language='javascript'>$('div.alertaddmauv').show('slow').delay(8000).hide('slow');</script>";
    }
}

//fonction pour lister les Departements
function lister_departement($con) {
    $rsltuser = $con->query('select * from hotel_departement as d left join hotel_region as r on d.id_region=r.id_region') or die(mysqli_error($con));
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        ?>

        <tr >
            <td><?php print nl2br(htmlspecialchars($recuser["id_departement"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["libelle_de"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["chef_lieu_de"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["nom_reg"])) ?></td>
            <td>
                <?php
                if (isset($_SESSION["loginproprietaire"])) {
                    ?>

                    <a href="indexproprietaire.php?page=<?php echo base64_encode('hotelpages/departementhotel/editer_departement') ?>&departement=<?php echo $recuser["id_departement"] ?>">
                        <span title="Modifier ce D&eacute;partement" alt="editer"><i class="glyphicon glyphicon-edit"></i></span>
                    </a>&nbsp;&nbsp;
                    <a href='#' onclick=del_hotel_departement(<?php echo $recuser["id_departement"] ?>)>
                        <span title="Supprimer ce D&eacute;partement" alt="suppr"><i class="glyphicon glyphicon-remove"></i></span>
                    </a>
                    <?php
                } else {
                    ?>
            <!--                        <a href="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/departementhotel/editer_departement') ?>&departement=<?php echo $recuser["id_departement"] ?>">
                            <span title="Modifier ce D&eacute;partement" alt="editer"><i class="glyphicon glyphicon-edit"></i></span>
                        </a>-->
                    <?php
                }
                ?>
            </td>
        </tr>

        <?php
    }
}

//fonction pour modifier une Departement
function editer_departement($id, $reg, $libdep, $chefldep, $con) {
    $req = $con->query("select * from hotel_departement where libelle_de = '" . $libdep . "' "
            . "or chef_lieu_de = '" . $chefldep . "'") or die(mysqli_error($con));
    $nb = mysqli_num_rows($req);
    if (($nb == 0)) {
        $rslt = $con->query("update hotel_departement set id_region='" . $reg . "', libelle_de='" . $libdep . "', "
                . "chef_lieu_de='" . $chefldep . "' where id_departement='" . $id . "'") or die(mysqli_error($con));
        echo "<script language='javascript'>$('div.alertmodifbon').show('slow').delay(8000).hide('slow');</script>";
    } else {
        $recuser = mysqli_fetch_array($req);
        if ($id == $recuser["id_departement"]) {
            $rslt = $con->query("update hotel_departement set id_region='" . $reg . "', libelle_de='" . $libdep . "', "
                    . "chef_lieu_de='" . $chefldep . "' where id_departement='" . $id . "'") or die(mysqli_error($con));
            echo "<script language='javascript'>$('div.alertmodifbon').show('slow').delay(8000).hide('slow');</script>";
        } else {
            echo "<script language='javascript'>$('div.alertaddmauv').show('slow').delay(8000).hide('slow');</script>";
        }
    }
}

//gestion des Services
//fonction pour ajouter un Service
function ajouter_service($codes, $noms, $contact, $con) {
    $noms = addslashes($noms);
//    $domaines = addslashes($domaines);
    $req = $con->query("select * from hotel_service where nom_service= '" . $noms . "'") or die(mysqli_error($con));
    $nb = mysqli_num_rows($req);
    if (($nb == 0)) {
        $rslt = $con->query("insert into hotel_service(code_service, nom_service, contact_serv, date_service) "
                . "values('" . $codes . "', '" . $noms . "', '" . $contact . "', NOW())") or die(mysqli_error($con));
        echo "<script language='javascript'>$('div.alertuseraddbon').show('slow').delay(8000).hide('slow');</script>";
    } else {
        echo "<script language='javascript'>$('div.alertaddmauv').show('slow').delay(8000).hide('slow');</script>";
    }
}

//fonction pour lister les Services
function lister_service($con) {
    $rsltuser = $con->query('select * from hotel_service') or die(mysqli_error($con));
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        ?>

        <tr >
            <td><?php print nl2br(htmlspecialchars($recuser["code_service"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["nom_service"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["contact_serv"])) ?></td>
            <td>
                <?php
                if (isset($_SESSION["loginproprietaire"])) {
                    ?>
                    <a href="indexproprietaire.php?page=<?php echo base64_encode('hotelpages/servicehotel/editer_service') ?>&service=<?php echo $recuser["id_service"] ?>">
                        <span title="Modifier ce Service" alt="editer"><i class="glyphicon glyphicon-edit"></i></span>
                    </a>&nbsp;&nbsp;
                    <a href='#' onclick=del_service(<?php echo $recuser["id_service"] ?>)>
                        <span title="Supprimer ce Service" alt="suppr"><i class="glyphicon glyphicon-remove"></i></span>
                    </a>
                    <?php
                } else {
                    ?>
                    <?php
                }
                ?>
            </td>
        </tr>

        <?php
    }
}

//fonction pour modifier un Service
function editer_service($id, $codes, $noms, $contact, $con) {
    $noms = addslashes($noms);
//    $domaines = addslashes($domaines);
    $req = $con->query("select * from hotel_service where nom_service = '" . $noms . "'") or die(mysqli_error($con));
    $nb = mysqli_num_rows($req);
    if (($nb == 0)) {
        $rslt = $con->query("update hotel_service set code_service='" . $codes . "', nom_service='" . $noms . "', contact_serv='" . $contact . "' where id_service='" . $id . "'") or die(mysqli_error($con));
        echo "<script language='javascript'>$('div.alertmodifbon').show('slow').delay(8000).hide('slow');</script>";
    } else {
        $recuser = mysqli_fetch_array($req);
        if ($id == $recuser["id_service"]) {
            $rslt = $con->query("update hotel_service set code_service='" . $codes . "', nom_service='" . $noms . "', contact_serv='" . $contact . "' where id_service='" . $id . "'") or die(mysqli_error($con));
            echo "<script language='javascript'>$('div.alertmodifbon').show('slow').delay(8000).hide('slow');</script>";
        } else {
            echo "<script language='javascript'>$('div.alertaddmauv').show('slow').delay(8000).hide('slow');</script>";
        }
    }
}

//fonction pour ajouter un Service
function ajouter_servicepa($idpointa, $serv, $i, $con) {
    for ($j = 0; $j < $i; $j++) {
        $req = $con->query("select * from service_point_hotel where id_point_hotel= '" . $idpointa . "' and id_service= '" . $serv[$j] . "'") or die(mysqli_error($con));
        $nb = mysqli_num_rows($req);
        if (($nb == 0)) {
            $rslt = $con->query("insert into service_point_hotel(id_point_hotel, id_service) values('" . $idpointa . "', "
                    . "'" . $serv[$j] . "')") or die(mysqli_error($con));
        } else {
            echo "<script language='javascript'>$('div.alertaddmauv').show('slow').delay(8000).hide('slow');</script>";
        }
    }
    echo "<script language='javascript'>$('div.alertuseraddbon').show('slow').delay(8000).hide('slow');</script>";
}

//fonction pour lister les Services
function lister_servicepa($idpointa, $con) {
    $rsltuser = $con->query('select * from service_point_hotel as spa left join hotel_service as s on '
            . 'spa.id_service=s.id_service where spa.id_point_hotel=' . $idpointa . '') or die(mysqli_error($con));
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        ?>

        <tr >
            <td><?php print nl2br(htmlspecialchars($recuser["nom_service"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["contact_serv"])) ?></td>
            <td>
                <?php
                if (isset($_SESSION["loginproprietaire"])) {
                    ?>
                    <a href='#' onclick=del_service(<?php echo $recuser["id_service"] ?>,<?php echo $idpointa ?>)>
                        <span title="Supprimer un Service" alt="suppr"><i class="glyphicon glyphicon-remove"></i></span>
                    </a>
                    <?php
                } else {
                    ?>
                    <!--                        
                                        <a href='#' onclick=del_service(<?php echo $recuser["id_service"] ?>,<?php echo $idpointa ?>)>
                                            <span title="Supprimer un Service" alt="suppr"><i class="glyphicon glyphicon-remove"></i></span>
                                        </a>-->
                    <?php
                }
                ?>
            </td>
        </tr>

        <?php
    }
}

//gestion des Pointhotels
//fonction pour ajouter un Pointhotel
function ajouter_pointhotel($nom_ph, $quartier_ph, $deppa, $con) {
    $nom_ph = addslashes($nom_ph);
    $quartier_ph = addslashes($quartier_ph);
    $req = $con->query("select * from hotel_point_hotel where nom_ph= '" . $nom_ph . "'") or die(mysqli_error($con));
    $nb = mysqli_num_rows($req);
    if (($nb == 0)) {
        $rslt = $con->query("insert into hotel_point_hotel(nom_ph, quartier_ph, id_proprietaire, id_departement, date_creation_ph) "
                . "values('" . $nom_ph . "', '" . $quartier_ph . "', '" . $_SESSION["id_proprietaire"] . "','" . $deppa . "', NOW())") or die(mysqli_error($con));
        echo "<script language='javascript'>$('div.alertuseraddbon').show('slow').delay(8000).hide('slow');</script>";
    } else {
        echo "<script language='javascript'>$('div.alertaddmauv').show('slow').delay(8000).hide('slow');</script>";
    }
}

//fonction pour lister les Pointhotels
function lister_pointhotel($con) {
    $rsltuser = $con->query('select * from hotel_point_hotel as pa left join hotel_proprietaire as p on pa.id_proprietaire=p.id_proprietaire '
            . 'where pa.id_proprietaire=' . $_SESSION["id_proprietaire"] . '') or die(mysqli_error($con));
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        $rsltreg = $con->query('select * from hotel_departement as d left join hotel_region as r on d.id_region=r.id_region where d.id_departement=' . $recuser["id_departement"] . '') or die(mysqli_error($con));
        $recreg = mysqli_fetch_assoc($rsltreg);
        ?>

        <tr >
            <td><?php print nl2br(htmlspecialchars($recuser["nom_ph"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["quartier_ph"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["nom_p"])) ?> <?php print nl2br(htmlspecialchars($recuser["prenom_p"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recreg["libelle_de"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recreg["nom_reg"])) ?></td>
            <td>
                <?php
                if (isset($_SESSION["loginproprietaire"])) {
                    ?>
                    <a href="indexproprietaire.php?page=<?php echo base64_encode('hotelpages/pointhotelhotel/editer_pointhotel') ?>&pointhotel=<?php echo $recuser["id_point_hotel"] ?>">
                        <span title="Modifier ce Point hotel" alt="editer"><i class="glyphicon glyphicon-edit"></i></span>
                    </a>&nbsp;&nbsp;
                    <a href="indexproprietaire.php?page=<?php echo base64_encode('hotelpages/pointhotelhotel/ajouter_service') ?>&pointhotel=<?php echo $recuser["id_point_hotel"] ?>">
                        <span title="Associer un service &agrave; ce Point hotel" alt="associer"><i class="glyphicon glyphicon-plus"></i></span>
                    </a>&nbsp;&nbsp;
                    <a href="indexproprietaire.php?page=<?php echo base64_encode('hotelpages/pointhotelhotel/lister_service') ?>&pointhotel=<?php echo $recuser["id_point_hotel"] ?>">
                        <span title="Lister les services de ce Point hotel" alt="lister"><i class="glyphicon glyphicon-list"></i></span>
                    </a>&nbsp;&nbsp;
                    <a href='#' onclick=del_pointhotel(<?php echo $recuser["id_point_hotel"] ?>)>
                        <span title="Supprimer un Point hotel" alt="suppr"><i class="glyphicon glyphicon-remove"></i></span>
                    </a>
                    <?php
                } else {
                    ?>
                    <?php
                }
                ?>
            </td>
        </tr>

        <?php
    }
}

//fonction pour modifier un Pointhotel
function editer_pointhotel($id, $nom_ph, $quartier_ph, $deppa, $con) {
    $nom_ph = addslashes($nom_ph);
    $quartier_ph = addslashes($quartier_ph);
    $req = $con->query("select * from hotel_point_hotel where nom_ph = '" . $nom_ph . "'") or die(mysqli_error($con));
    $nb = mysqli_num_rows($req);
    if (($nb == 0)) {
        $rslt = $con->query("update hotel_point_hotel set nom_ph='" . $nom_ph . "', quartier_ph='" . $quartier_ph . "', "
                . "id_departement='" . $deppa . "' where id_point_hotel='" . $id . "'") or die(mysqli_error($con));
        echo "<script language='javascript'>$('div.alertmodifbon').show('slow').delay(8000).hide('slow');</script>";
    } else {
        $recuser = mysqli_fetch_array($req);
        if ($id == $recuser["id_point_hotel"]) {
            $rslt = $con->query("update hotel_point_hotel set nom_ph='" . $nom_ph . "', quartier_ph='" . $quartier_ph . "', "
                    . "id_departement='" . $deppa . "' where id_point_hotel='" . $id . "'") or die(mysqli_error($con));
            echo "<script language='javascript'>$('div.alertmodifbon').show('slow').delay(8000).hide('slow');</script>";
        } else {
            echo "<script language='javascript'>$('div.alertaddmauv').show('slow').delay(8000).hide('slow');</script>";
        }
    }
}

//gestion des Chambres
//fonction pour ajouter une Chambre
function ajouter_chambre($codec, $niveauc, $prixc, $typec, $pointh, $con) {
    $req = $con->query("select * from hotel_chambre where code_c= '" . $codec . "' and id_point_hotel= '" . $pointh . "' ") or die(mysqli_error($con));
    $nb = mysqli_num_rows($req);
    if (($nb == 0)) {
        $rslt = $con->query("insert into hotel_chambre(id_point_hotel, code_c, niveau_c, prix_c, type_c, date_c) values('" . $pointh . "', "
                . "'" . $codec . "', '" . $niveauc . "', '" . $prixc . "', '" . $typec . "', NOW())") or die(mysqli_error($con));
        echo "<script language='javascript'>$('div.alertuseraddbon').show('slow').delay(8000).hide('slow');</script>";
    } else {
        echo "<script language='javascript'>$('div.alertaddmauv').show('slow').delay(8000).hide('slow');</script>";
    }
}

//fonction pour lister les Chambres
function lister_chambre($con) {
    $rsltuser = $con->query("select * from hotel_chambre as c left join hotel_point_hotel as ph on "
            . "c.id_point_hotel=ph.id_point_hotel left join hotel_departement as d on ph.id_departement=d.id_departement "
            . "left join hotel_region as r on d.id_region=r.id_region") or die(mysqli_error($con));

//$lettre=new ChiffreEnLettre();
//$lettre->Conversion($chiffre); 
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        ?>

        <tr >
            <td><?php print nl2br(htmlspecialchars($recuser["code_c"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["niveau_c"])) ?></td>
            <td><?php print number_format($recuser["prix_c"], 0, ',', ' ') ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["type_c"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["nom_ph"])) ?></td>
            <td>
                <?php
                if ($recuser["etat_c"]) {
                    ?>
                    <a href="#" onclick=liberer_cha(<?php echo $recuser["id_chambre"] ?>)>
                        Occup&eacute;e
                    </a>
                    <?php
                } else if ($recuser["reserve_c"]) {
                    ?>
                    <a href="#" onclick=occuper_cha(<?php echo $recuser["id_chambre"] ?>)>
                        R&eacute;serv&eacute;e
                    </a>
                    <?php
                } else {
                    ?>
                    Libre
                    <?php
                }
                ?>
            </td>
            <td>
                <?php
                if (isset($_SESSION["loginproprietaire"])) {
                    ?>

                    <a href="indexproprietaire.php?page=<?php echo base64_encode('hotelpages/logementhotel/editer_chambre') ?>&chambre=<?php echo $recuser["id_chambre"] ?>">
                        <span title="Modifier cette Chambre" ><i class="glyphicon glyphicon-edit"></i></span>
                    </a>&nbsp;&nbsp;
                    <a href='#' onclick=del_hotel_chambre(<?php echo $recuser["id_chambre"] ?>)>
                        <span title="Supprimer cette Chambre" ><i class="glyphicon glyphicon-remove"></i></span>
                    </a>
                    <?php
                } else {
                    ?>
            <!--                        <a href="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/logementhotel/editer_chambre') ?>&chambre=<?php echo $recuser["id_chambre"] ?>">
                            <span title="Modifier cette Chambre" alt="editer"><i class="glyphicon glyphicon-edit"></i></span>
                        </a>-->
                    <?php
                }
                ?>
            </td>
        </tr>

        <?php
    }
}

//fonction pour modifier une Chambre
function editer_chambre($id, $codec, $niveauc, $prixc, $typec, $pointh, $con) {
    $req = $con->query("select * from hotel_chambre where code_c= '" . $codec . "' and id_point_hotel= '" . $pointh . "' ") or die(mysqli_error($con));
    $nb = mysqli_num_rows($req);
    if (($nb == 0)) {
        $rslt = $con->query("update hotel_chambre set id_point_hotel='" . $pointh . "', code_c='" . $codec . "', "
                . "niveau_c='" . $niveauc . "', prix_c='" . $prixc . "', type_c='" . $typec . "' where id_chambre='" . $id . "'") or die(mysqli_error($con));
        echo "<script language='javascript'>$('div.alertmodifbon').show('slow').delay(8000).hide('slow');</script>";
    } else {
        $recuser = mysqli_fetch_array($req);
        if ($id == $recuser["id_chambre"]) {
            $rslt = $con->query("update hotel_chambre set id_point_hotel='" . $pointh . "', code_c='" . $codec . "', "
                    . "niveau_c='" . $niveauc . "', prix_c='" . $prixc . "', type_c='" . $typec . "' where id_chambre='" . $id . "'") or die(mysqli_error($con));
            echo "<script language='javascript'>$('div.alertmodifbon').show('slow').delay(8000).hide('slow');</script>";
        } else {
            echo "<script language='javascript'>$('div.alertaddmauv').show('slow').delay(8000).hide('slow');</script>";
        }
    }
}

//gestion des Studios
//fonction pour ajouter une Studio
function ajouter_studio($codec, $niveauc, $prixc, $typec, $pointh, $con) {
    $req = $con->query("select * from hotel_studio where code_s= '" . $codec . "' and id_point_hotel= '" . $pointh . "' ") or die(mysqli_error($con));
    $nb = mysqli_num_rows($req);
    if (($nb == 0)) {
        $rslt = $con->query("insert into hotel_studio(id_point_hotel, code_s, niveau_s, prix_s, type_s, date_s) values('" . $pointh . "', "
                . "'" . $codec . "', '" . $niveauc . "', '" . $prixc . "', '" . $typec . "', NOW())") or die(mysqli_error($con));
        echo "<script language='javascript'>$('div.alertuseraddbon').show('slow').delay(8000).hide('slow');</script>";
    } else {
        echo "<script language='javascript'>$('div.alertaddmauv').show('slow').delay(8000).hide('slow');</script>";
    }
}

//fonction pour lister les Studios
function lister_studio($con) {
    $rsltuser = $con->query("select * from hotel_studio as c left join hotel_point_hotel as ph on "
            . "c.id_point_hotel=ph.id_point_hotel left join hotel_departement as d on ph.id_departement=d.id_departement "
            . "left join hotel_region as r on d.id_region=r.id_region ") or die(mysqli_error($con));
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        ?>

        <tr >
            <td><?php print nl2br(htmlspecialchars($recuser["code_s"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["niveau_s"])) ?></td>
            <td><?php print number_format($recuser["prix_s"], 0, ',', ' ') ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["type_s"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["nom_ph"])) ?></td>
            <td>
                <?php
                if ($recuser["etat_s"]) {
                    ?>
                    <a href="#" onclick=liberer_std(<?php echo $recuser["id_studio"] ?>)>
                        Occup&eacute;
                    </a>
                    <?php
                } else if ($recuser["reserve_s"]) {
                    ?>
                    <a href="#" onclick=occuper_std(<?php echo $recuser["id_studio"] ?>)>
                        R&eacute;serv&eacute;
                    </a>
                    <?php
                } else {
                    ?>
                    Libre
                    <?php
                }
                ?>
            </td>
            <td>
                <?php
                if (isset($_SESSION["loginproprietaire"])) {
                    ?>

                    <a href="indexproprietaire.php?page=<?php echo base64_encode('hotelpages/logementhotel/editer_studio') ?>&studio=<?php echo $recuser["id_studio"] ?>">
                        <span title="Modifier ce Studio" alt="editer"><i class="glyphicon glyphicon-edit"></i></span>
                    </a>&nbsp;&nbsp;
                    <a href='#' onclick=del_hotel_studio(<?php echo $recuser["id_studio"] ?>)>
                        <span title="Supprimer ce Studio" alt="suppr"><i class="glyphicon glyphicon-remove"></i></span>
                    </a>
                    <?php
                } else {
                    ?>
            <!--                        <a href="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/logementhotel/editer_studio') ?>&studio=<?php echo $recuser["id_studio"] ?>">
                            <span title="Modifier ce Studio" alt="editer"><i class="glyphicon glyphicon-edit"></i></span>
                        </a>-->
                    <?php
                }
                ?>
            </td>
        </tr>

        <?php
    }
}

//fonction pour modifier une Studio
function editer_studio($id, $codec, $niveauc, $prixc, $typec, $pointh, $con) {
    $req = $con->query("select * from hotel_studio where code_s= '" . $codec . "' and id_point_hotel= '" . $pointh . "' ") or die(mysqli_error($con));
    $nb = mysqli_num_rows($req);
    if (($nb == 0)) {
        $rslt = $con->query("update hotel_studio set id_point_hotel='" . $pointh . "', code_s='" . $codec . "', "
                . "niveau_s='" . $niveauc . "', prix_s='" . $prixc . "', type_s='" . $typec . "' where id_studio='" . $id . "'") or die(mysqli_error($con));
        echo "<script language='javascript'>$('div.alertmodifbon').show('slow').delay(8000).hide('slow');</script>";
    } else {
        $recuser = mysqli_fetch_array($req);
        if ($id == $recuser["id_studio"]) {
            $rslt = $con->query("update hotel_studio set id_point_hotel='" . $pointh . "', code_s='" . $codec . "', "
                    . "niveau_s='" . $niveauc . "', prix_s='" . $prixc . "', type_s='" . $typec . "' where id_studio='" . $id . "'") or die(mysqli_error($con));
            echo "<script language='javascript'>$('div.alertmodifbon').show('slow').delay(8000).hide('slow');</script>";
        } else {
            echo "<script language='javascript'>$('div.alertaddmauv').show('slow').delay(8000).hide('slow');</script>";
        }
    }
}

//gestion des Appartements
//fonction pour ajouter une Appartement
function ajouter_appartement($codec, $niveauc, $prixc, $typec, $nbch, $nbs, $nbd, $nbcu, $pointh, $con) {
    $req = $con->query("select * from hotel_appartement where code_a= '" . $codec . "' and id_point_hotel= '" . $pointh . "' ") or die(mysqli_error($con));
    $nb = mysqli_num_rows($req);
    if (($nb == 0)) {
        $rslt = $con->query("insert into hotel_appartement(id_point_hotel, code_a, niveau_a, prix_a, type_a, nbchambre_a, "
                . "nbsalon_a, nbdouche_a, nbcuisine_a, date_a) values('" . $pointh . "', '" . $codec . "', '" . $niveauc . "', "
                . "'" . $prixc . "', '" . $typec . "', '" . $nbch . "', '" . $nbs . "', '" . $nbd . "', '" . $nbcu . "', NOW())") or die(mysqli_error($con));
        echo "<script language='javascript'>$('div.alertuseraddbon').show('slow').delay(8000).hide('slow');</script>";
    } else {
        echo "<script language='javascript'>$('div.alertaddmauv').show('slow').delay(8000).hide('slow');</script>";
    }
}

//fonction pour lister les Appartements
function lister_appartement($con) {
    $rsltuser = $con->query("select * from hotel_appartement as c left join hotel_point_hotel as ph on "
            . "c.id_point_hotel=ph.id_point_hotel left join hotel_departement as d on ph.id_departement=d.id_departement "
            . "left join hotel_region as r on d.id_region=r.id_region ") or die(mysqli_error($con));
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        ?>

        <tr >
            <td><?php print nl2br(htmlspecialchars($recuser["code_a"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["niveau_a"])) ?></td>
            <td><?php print number_format($recuser["prix_a"], 0, ',', ' ') ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["type_a"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["nbchambre_a"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["nbsalon_a"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["nbdouche_a"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["nbcuisine_a"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["nom_ph"])) ?></td>
            <td>
                <?php
                if ($recuser["etat_a"]) {
                    ?>
                    <a href="#" onclick=liberer_app(<?php echo $recuser["id_appartement"] ?>)>
                        Occup&eacute;e
                    </a>
                    <?php
                } else if ($recuser["reserve_a"]) {
                    ?>
                    <a href="#" onclick=occuper_app(<?php echo $recuser["id_appartement"] ?>)>
                        R&eacute;serv&eacute;
                    </a>
                    <?php
                } else {
                    ?>
                    Libre
                    <?php
                }
                ?>
            </td>
            <td>
                <?php
                if (isset($_SESSION["loginproprietaire"])) {
                    ?>

                    <a href="indexproprietaire.php?page=<?php echo base64_encode('hotelpages/logementhotel/editer_appartement') ?>&appartement=<?php echo $recuser["id_appartement"] ?>">
                        <span title="Modifier cette Appartement" alt="editer"><i class="glyphicon glyphicon-edit"></i></span>
                    </a>&nbsp;&nbsp;
                    <a href='#' onclick=del_hotel_appartement(<?php echo $recuser["id_appartement"] ?>)>
                        <span title="Supprimer cette Appartement" alt="suppr"><i class="glyphicon glyphicon-remove"></i></span>
                    </a>
                    <?php
                } else {
                    ?>
            <!--                        <a href="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/logementhotel/editer_appartement') ?>&appartement=<?php echo $recuser["id_appartement"] ?>">
                            <span title="Modifier cette Appartement" alt="editer"><i class="glyphicon glyphicon-edit"></i></span>
                        </a>-->
                    <?php
                }
                ?>
            </td>
        </tr>

        <?php
    }
}

//fonction pour modifier une Appartement
function editer_appartement($id, $codec, $niveauc, $prixc, $typec, $nbch, $nbs, $nbd, $nbcu, $pointh, $con) {
    $req = $con->query("select * from hotel_appartement where code_a= '" . $codec . "' and id_point_hotel= '" . $pointh . "' ") or die(mysqli_error($con));
    $nb = mysqli_num_rows($req);
    if (($nb == 0)) {
        $rslt = $con->query("update hotel_appartement set id_point_hotel='" . $pointh . "', code_a='" . $codec . "', "
                . "niveau_a='" . $niveauc . "', prix_a='" . $prixc . "', type_a='" . $typec . "', nbchambre_a='" . $nbch . "', "
                . "nbsalon_a='" . $nbs . "', nbdouche_a='" . $nbd . "', nbcuisine_a='" . $nbcu . "' where id_appartement='" . $id . "'") or die(mysqli_error($con));
        echo "<script language='javascript'>$('div.alertmodifbon').show('slow').delay(8000).hide('slow');</script>";
    } else {
        $recuser = mysqli_fetch_array($req);
        if ($id == $recuser["id_appartement"]) {
            $rslt = $con->query("update hotel_appartement set id_point_hotel='" . $pointh . "', code_a='" . $codec . "', "
                    . "niveau_a='" . $niveauc . "', prix_a='" . $prixc . "', type_a='" . $typec . "', nbchambre_a='" . $nbch . "', "
                    . "nbsalon_a='" . $nbs . "', nbdouche_a='" . $nbd . "', nbcuisine_a='" . $nbcu . "' where id_appartement='" . $id . "'") or die(mysqli_error($con));
            echo "<script language='javascript'>$('div.alertmodifbon').show('slow').delay(8000).hide('slow');</script>";
        } else {
            echo "<script language='javascript'>$('div.alertaddmauv').show('slow').delay(8000).hide('slow');</script>";
        }
    }
}

//gestion des Clients
//fonction pour ajouter une Client
function ajouter_client($client, $con) {
    if (($client != NULL) && isset($client["1"])) {
        if (!($client["2"]["ancien"])) {
            $rsltcl = $con->query("insert into hotel_client(nom_client, prenom_client, civilite_client, telephone_client, "
                    . "cni_client, ville_client, date_naissance, profession_client, date_client) values('" . $client["1"]["nomcl"] . "', "
                    . "'" . $client["1"]["prenomcl"] . "', '" . $client["1"]["civilitecl"] . "', '" . $client["1"]["telcl"] . "', "
                    . "'" . $client["1"]["cnicl"] . "', '" . $client["1"]["villecl"] . "', '" . $client["1"]["datenaiscl"] . "', "
                    . "'" . $client["1"]["profcl"] . "', NOW())") or die(mysqli_error($con));
        }
        $reqcl = $con->query("select * from hotel_client where cni_client= '" . $client["1"]["cnicl"] . "' ") or die(mysqli_error($con));
        $rowcl = mysqli_fetch_assoc($reqcl);

        $rowplo = NULL;

        $an = date('Y');
        $numid = date('Y', time()) . sprintf("%08d", 1);
        $req1 = $con->query("select * from hotel_paye_logement where YEAR(date_pl)='" . $an . "'") or die(mysqli_error($con));
        $i = 0;
        while ($reqte = mysqli_fetch_assoc($req1)) {
            $i = $i + 1;
        }
        $numid = date('Y', time()) . sprintf("%08d", $i + 1);
        $occupe = 1;
        $op = "Logement";
        if ($client["1"]["reserve"]) {
            $occupe = 0;
            $op = "Réserver";
        }

        $obh = "";
        $contenu = NULL;
        $dif1 = dates_range(date('Y-m-d', strtotime($client["1"]["datedpl"])), date('Y-m-d', strtotime($client["1"]["datefpl"])));
        $dif = $dif1 - 1;
        $prixpl = 0;
        if ($client["1"]["prixl"] != NULL) {
            $prixpl = $dif * $client["1"]["prixl"];
            if ($client["1"]["cha"] != NULL) {
                $reqch = $con->query("select * from hotel_chambre where id_chambre= '" . $client["1"]["cha"] . "' ") or die(mysqli_error($con));
                $rowch = mysqli_fetch_assoc($reqch);
                $obh = $rowch["code_c"];

                $rsltpl = $con->query("insert into hotel_paye_logement(id_chambre, id_client, code_pl, prix_u, prix_pl, nbpers, date_debut_pl, "
                        . "date_fin_pl, reserve_pl, date_pl) values('" . $client["1"]["cha"] . "', '" . $rowcl["id_client"] . "', '" . $numid . "', "
                        . "'" . $client["1"]["prixl"] . "', '" . $prixpl . "', '" . $client["1"]["nbpers"] . "', '" . $client["1"]["datedpl"] . "', "
                        . "'" . $client["1"]["datefpl"] . "', '" . $client["1"]["reserve"] . "', NOW())") or die(mysqli_error($con));
                $reqpl = $con->query("select * from hotel_paye_logement where code_pl= '" . $numid . "' ") or die(mysqli_error($con));
                $rowpl = mysqli_fetch_assoc($reqpl);

                $rsltch = $con->query("update hotel_chambre set etat_c='" . $occupe . "' ,reserve_c='" . $client["1"]["reserve"] . "' "
                        . "where id_chambre= '" . $client["1"]["cha"] . "'") or die(mysqli_error($con));

                $rsltre = $con->query("insert into hotel_recu(id_paye_logement, montant, date_debut_re, date_fin_re, date_recu) "
                        . "values('" . $rowpl["id_paye_logement"] . "', '" . $client["1"]["prixl"] . "', "
                        . "'" . $client["1"]["datedpl"] . "', '" . $client["1"]["datefpl"] . "', NOW())") or die(mysqli_error($con));

                $contenu = "Bonjour M. /Mme. " . $rowcl["nom_client"] . " " . $rowcl["prenom_client"] . " Votre chambre numéro "
                        . "" . $rowch["code_c"] . " est située au niveau " . $rowch["niveau_c"] . ". Merci d'avoir choisi notre HOTEL "
                        . "pour votre séjour.";
            } else if ($client["1"]["std"] != NULL) {
                $reqst = $con->query("select * from hotel_studio where id_studio= '" . $client["1"]["std"] . "' ") or die(mysqli_error($con));
                $rowst = mysqli_fetch_assoc($reqst);
                $obh = $rowst["code_s"];

                $rsltpl = $con->query("insert into hotel_paye_logement(id_studio, id_client, code_pl; prix_u, prix_pl, nbpers, date_debut_pl, "
                        . "date_fin_pl, reserve_pl, date_pl) values('" . $client["1"]["std"] . "', '" . $rowcl["id_client"] . "', '" . $numid . "', "
                        . "'" . $client["1"]["prixl"] . "', '" . $prixpl . "', '" . $client["1"]["nbpers"] . "', '" . $client["1"]["datedpl"] . "', "
                        . "'" . $client["1"]["datefpl"] . "', '" . $client["1"]["reserve"] . "', NOW())") or die(mysqli_error($con));
                $reqpl = $con->query("select * from hotel_paye_logement where code_pl= '" . $numid . "' ") or die(mysqli_error($con));
                $rowpl = mysqli_fetch_assoc($reqpl);

                $rsltch = $con->query("update hotel_studio set etat_s='" . $occupe . "' ,reserve_s='" . $client["1"]["reserve"] . "' "
                        . "where id_studio= '" . $client["1"]["std"] . "'") or die(mysqli_error($con));

                $rsltre = $con->query("insert into hotel_recu(id_paye_logement, montant, date_debut_re, date_fin_re, date_recu) "
                        . "values('" . $rowpl["id_paye_logement"] . "', '" . $client["1"]["prixl"] . "', "
                        . "'" . $client["1"]["datedpl"] . "', '" . $client["1"]["datefpl"] . "', NOW())") or die(mysqli_error($con));

                $contenu = "Bonjour M. /Mme. " . $rowcl["nom_client"] . " " . $rowcl["prenom_client"] . " Votre studio "
                        . "" . $rowst["code_s"] . " est situé au niveau " . $rowst["niveau_s"] . ". Merci d'avoir choisi notre HOTEL "
                        . "pour votre séjour.";
            } else if ($client["1"]["app"] != NULL) {
                $reqap = $con->query("select * from hotel_appartement where id_appartement= '" . $client["1"]["app"] . "' ") or die(mysqli_error($con));
                $rowap = mysqli_fetch_assoc($reqap);
                $obh = $rowap["code_a"];

                $rsltpl = $con->query("insert into hotel_paye_logement(id_appartement, id_client, code_pl, prix_u, prix_pl, nbpers, date_debut_pl, "
                        . "date_fin_pl, reserve_pl, date_pl) values('" . $client["1"]["app"] . "', '" . $rowcl["id_client"] . "', '" . $numid . "', "
                        . "'" . $client["1"]["prixl"] . "', '" . $prixpl . "', '" . $client["1"]["nbpers"] . "', '" . $client["1"]["datedpl"] . "', "
                        . "'" . $client["1"]["datefpl"] . "', '" . $client["1"]["reserve"] . "', NOW())") or die(mysqli_error($con));
                $reqpl = $con->query("select * from hotel_paye_logement where code_pl= '" . $numid . "' ") or die(mysqli_error($con));
                $rowpl = mysqli_fetch_assoc($reqpl);

                $rsltch = $con->query("update hotel_appartement set etat_a='" . $occupe . "' ,reserve_a='" . $client["1"]["reserve"] . "' w"
                        . "here id_appartement= '" . $client["1"]["app"] . "'") or die(mysqli_error($con));

                $rsltre = $con->query("insert into hotel_recu(id_paye_logement, montant, date_debut_re, date_fin_re, date_recu) "
                        . "values('" . $rowpl["id_paye_logement"] . "', '" . $client["1"]["prixl"] . "', "
                        . "'" . $client["1"]["datedpl"] . "', '" . $client["1"]["datefpl"] . "', NOW())") or die(mysqli_error($con));

                $contenu = "Bonjour M. /Mme. " . $rowcl["nom_client"] . " " . $rowcl["prenom_client"] . " Votre appartement "
                        . "" . $rowap["code_a"] . " est situé au niveau " . $rowap["niveau_a"] . ". Merci d'avoir choisi notre HOTEL "
                        . "pour votre séjour.";
            } else if ($client["1"]["sal"] != NULL) {
                $reqst = $con->query("select * from hotel_salle where id_salle= '" . $client["1"]["sal"] . "' ") or die(mysqli_error($con));
                $rowst = mysqli_fetch_assoc($reqst);
                $obh = $rowst["code_salle"];

                $rsltpl = $con->query("insert into hotel_paye_logement(id_salle, id_client, code_pl, prix_u, prix_pl, nbpers, date_debut_pl, "
                        . "date_fin_pl, reserve_pl, date_pl) values('" . $client["1"]["sal"] . "', '" . $rowcl["id_client"] . "', '" . $numid . "', "
                        . "'" . $client["1"]["prixl"] . "', '" . $prixpl . "', '" . $client["1"]["nbpers"] . "', '" . $client["1"]["datedpl"] . "', "
                        . "'" . $client["1"]["datefpl"] . "', '" . $client["1"]["reserve"] . "', NOW())") or die(mysqli_error($con));
                $reqpl = $con->query("select * from hotel_paye_logement where code_pl= '" . $numid . "' ") or die(mysqli_error($con));
                $rowpl = mysqli_fetch_assoc($reqpl);

                $rsltch = $con->query("update hotel_salle set etat_salle='" . $occupe . "' ,reserve_salle='" . $client["1"]["reserve"] . "' "
                        . "where id_salle= '" . $client["1"]["sal"] . "'") or die(mysqli_error($con));

                $rsltre = $con->query("insert into hotel_recu(id_paye_logement, montant, date_debut_re, date_fin_re, date_recu) "
                        . "values('" . $rowpl["id_paye_logement"] . "', '" . $client["1"]["prixl"] . "', "
                        . "'" . $client["1"]["datedpl"] . "', '" . $client["1"]["datefpl"] . "', NOW())") or die(mysqli_error($con));

                $contenu = "Bonjour M. /Mme. " . $rowcl["nom_client"] . " " . $rowcl["prenom_client"] . " Votre salle "
                        . "" . $rowst["code_salle"] . " est située au niveau " . $rowst["niveau_salle"] . ". Merci d'avoir "
                        . "choisi notre HOTEL pour votre séjour.";
            }

            $reqplo = $con->query("select * from hotel_paye_logement where code_pl= '" . $numid . "' ") or die(mysqli_error($con));
            $rowplo = mysqli_fetch_assoc($reqplo);
            if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                $rsltreg = $con->query("insert into hotel_registre_client(id_paye_logement, montant_reg, operation_reg, date_registre) "
                        . "values('" . $rowpl["id_paye_logement"] . "', '" . $client["1"]["prixl"] . "', '" . $op . "', NOW())") or die(mysqli_error($con));
            } else if (isset($_SESSION["login_personnel"]) && (isset($_SESSION["mot_de_passe_personnel"])) && ($_SESSION["etat_compte_personnel"])) {
                $rsltreg = $con->query("insert into hotel_registre_client(id_paye_logement, id_compte_personnel, "
                        . "montant_reg, operation_reg, date_registre) values('" . $rowpl["id_paye_logement"] . "', "
                        . "'" . $_SESSION["id_compte_personnel"] . "', '" . $client["1"]["prixl"] . "', '" . $op . "', "
                        . "NOW())") or die(mysqli_error($con));
            }
        } else {

            if ($client["1"]["cha"] != NULL) {
                $reqch = $con->query("select * from hotel_chambre where id_chambre= '" . $client["1"]["cha"] . "' ") or die(mysqli_error($con));
                $rowch = mysqli_fetch_assoc($reqch);
                $obh = $rowch["code_c"];
                $prixpl = $dif * $rowch["prix_c"];
                $rsltpl = $con->query("insert into hotel_paye_logement(id_chambre, id_client, code_pl, prix_u, prix_pl, nbpers, date_debut_pl, "
                        . "date_fin_pl, date_pl) values('" . $client["1"]["cha"] . "', '" . $rowcl["id_client"] . "', '" . $numid . "', "
                        . "'" . $rowch["prix_c"] . "', '" . $prixpl . "', '" . $client["1"]["nbpers"] . "', '" . $client["1"]["datedpl"] . "', '" . $client["1"]["datefpl"] . "', "
                        . "NOW())") or die(mysqli_error($con));
                $reqpl = $con->query("select * from hotel_paye_logement where code_pl= '" . $numid . "' ") or die(mysqli_error($con));
                $rowpl = mysqli_fetch_assoc($reqpl);

                $rsltch = $con->query("update hotel_chambre set etat_c='" . $occupe . "' ,reserve_c='" . $client["1"]["reserve"] . "' "
                        . "where id_chambre= '" . $client["1"]["cha"] . "'") or die(mysqli_error($con));

                $rsltre = $con->query("insert into hotel_recu(id_paye_logement, montant, date_debut_re, date_fin_re, date_recu) "
                        . "values('" . $rowpl["id_paye_logement"] . "', '" . $prixpl . "', '" . $client["1"]["datedpl"] . "', "
                        . "'" . $client["1"]["datefpl"] . "', NOW())") or die(mysqli_error($con));

                $reqplo = $con->query("select * from hotel_paye_logement where code_pl= '" . $numid . "' ") or die(mysqli_error($con));
                $rowplo = mysqli_fetch_assoc($reqplo);
                if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                    $rsltreg = $con->query("insert into hotel_registre_client(id_paye_logement, montant_reg, operation_reg, date_registre) "
                            . "values('" . $rowpl["id_paye_logement"] . "', '" . $prixpl . "', '" . $op . "', NOW())") or die(mysqli_error($con));
                } else if (isset($_SESSION["login_personnel"]) && (isset($_SESSION["mot_de_passe_personnel"])) && ($_SESSION["etat_compte_personnel"])) {
                    $rsltreg = $con->query("insert into hotel_registre_client(id_paye_logement, id_compte_personnel, montant_reg, "
                            . "operation_reg, date_registre) values('" . $rowpl["id_paye_logement"] . "', "
                            . "'" . $_SESSION["id_compte_personnel"] . "', '" . $prixpl . "', '" . $op . "', NOW())") or die(mysqli_error($con));
                }
                $contenu = "Bonjour M. /Mme. " . $rowcl["nom_client"] . " " . $rowcl["prenom_client"] . " Votre chambre "
                        . "" . $rowch["code_c"] . " est située au niveau " . $rowch["niveau_c"] . ". Merci d'avoir choisi notre HOTEL "
                        . "pour votre séjour.";
            } else if ($client["1"]["std"] != NULL) {
                $reqst = $con->query("select * from hotel_studio where id_studio= '" . $client["1"]["std"] . "' ") or die(mysqli_error($con));
                $rowst = mysqli_fetch_assoc($reqst);
                $obh = $rowst["code_s"];
                $prixpl = $dif * $rowst["prix_s"];
                $rsltpl = $con->query("insert into hotel_paye_logement(id_studio, id_client, code_pl, prix_u, prix_pl, nbpers, date_debut_pl, "
                        . "date_fin_pl, date_pl) values('" . $client["1"]["std"] . "', '" . $rowcl["id_client"] . "', '" . $numid . "', "
                        . "'" . $rowst["prix_s"] . "', '" . $prixpl . "', '" . $client["1"]["nbpers"] . "', '" . $client["1"]["datedpl"] . "', '" . $client["1"]["datefpl"] . "', "
                        . "NOW())") or die(mysqli_error($con));
                $reqpl = $con->query("select * from hotel_paye_logement where code_pl= '" . $numid . "' ") or die(mysqli_error($con));
                $rowpl = mysqli_fetch_assoc($reqpl);

                $rsltch = $con->query("update hotel_studio set etat_s='" . $occupe . "' ,reserve_s='" . $client["1"]["reserve"] . "' "
                        . "where id_studio= '" . $client["1"]["std"] . "'") or die(mysqli_error($con));

                $rsltre = $con->query("insert into hotel_recu(id_paye_logement, montant, date_debut_re, date_fin_re, date_recu) "
                        . "values('" . $rowpl["id_paye_logement"] . "', '" . $prixpl . "', '" . $client["1"]["datedpl"] . "', "
                        . "'" . $client["1"]["datefpl"] . "', NOW())") or die(mysqli_error($con));

                $reqplo = $con->query("select * from hotel_paye_logement where code_pl= '" . $numid . "' ") or die(mysqli_error($con));
                $rowplo = mysqli_fetch_assoc($reqplo);
                if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                    $rsltreg = $con->query("insert into hotel_registre_client(id_paye_logement, montant_reg, operation_reg, date_registre) "
                            . "values('" . $rowpl["id_paye_logement"] . "', '" . $prixpl . "', '" . $op . "', NOW())") or die(mysqli_error($con));
                } else if (isset($_SESSION["login_personnel"]) && (isset($_SESSION["mot_de_passe_personnel"])) && ($_SESSION["etat_compte_personnel"])) {
                    $rsltreg = $con->query("insert into hotel_registre_client(id_paye_logement, id_compte_personnel, montant_reg, "
                            . "operation_reg, date_registre) values('" . $rowpl["id_paye_logement"] . "', "
                            . "'" . $_SESSION["id_compte_personnel"] . "', '" . $prixpl . "', '" . $op . "', NOW())") or die(mysqli_error($con));
                }
                $contenu = "Bonjour M. /Mme. " . $rowcl["nom_client"] . " " . $rowcl["prenom_client"] . " Votre studio "
                        . "" . $rowst["code_s"] . " est situé au niveau " . $rowst["niveau_s"] . ". Merci d'avoir choisi notre HOTEL "
                        . "pour votre séjour.";
            } else if ($client["1"]["app"] != NULL) {
                $reqap = $con->query("select * from hotel_appartement where id_appartement= '" . $client["1"]["app"] . "' ") or die(mysqli_error($con));
                $rowap = mysqli_fetch_assoc($reqap);
                $obh = $rowap["code_a"];
                $prixpl = $dif * $rowap["prix_a"];
                $rsltpl = $con->query("insert into hotel_paye_logement(id_appartement, id_client, code_pl, prix_u, prix_pl, nbpers, date_debut_pl, "
                        . "date_fin_pl, date_pl) values('" . $client["1"]["app"] . "', '" . $rowcl["id_client"] . "', '" . $numid . "', "
                        . "'" . $rowap["code_a"] . "', '" . $prixpl . "', '" . $client["1"]["nbpers"] . "', '" . $client["1"]["datedpl"] . "', '" . $client["1"]["datefpl"] . "', "
                        . "NOW())") or die(mysqli_error($con));
                $reqpl = $con->query("select * from hotel_paye_logement where code_pl= '" . $numid . "' ") or die(mysqli_error($con));
                $rowpl = mysqli_fetch_assoc($reqpl);

                $rsltch = $con->query("update hotel_appartement set etat_a='" . $occupe . "' ,reserve_a='" . $client["1"]["reserve"] . "' "
                        . "where id_appartement= '" . $client["1"]["app"] . "'") or die(mysqli_error($con));

                $rsltre = $con->query("insert into hotel_recu(id_paye_logement, montant, date_debut_re, date_fin_re, date_recu) "
                        . "values('" . $rowpl["id_paye_logement"] . "', '" . $prixpl . "', '" . $client["1"]["datedpl"] . "', "
                        . "'" . $client["1"]["datefpl"] . "', NOW())") or die(mysqli_error($con));

                $reqplo = $con->query("select * from hotel_paye_logement where code_pl= '" . $numid . "' ") or die(mysqli_error($con));
                $rowplo = mysqli_fetch_assoc($reqplo);
                if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                    $rsltreg = $con->query("insert into hotel_registre_client(id_paye_logement, montant_reg, operation_reg, date_registre) "
                            . "values('" . $rowpl["id_paye_logement"] . "', '" . $prixpl . "', '" . $op . "', NOW())") or die(mysqli_error($con));
                } else if (isset($_SESSION["login_personnel"]) && (isset($_SESSION["mot_de_passe_personnel"])) && ($_SESSION["etat_compte_personnel"])) {
                    $rsltreg = $con->query("insert into hotel_registre_client(id_paye_logement, id_compte_personnel, montant_reg, "
                            . "operation_reg, date_registre) values('" . $rowpl["id_paye_logement"] . "', "
                            . "'" . $_SESSION["id_compte_personnel"] . "', '" . $prixpl . "', '" . $op . "', NOW())") or die(mysqli_error($con));
                }
                $contenu = "Bonjour M. /Mme. " . $rowcl["nom_client"] . " " . $rowcl["prenom_client"] . " Votre appartement "
                        . "" . $rowap["code_a"] . " est situé au niveau " . $rowap["niveau_a"] . ". Merci d'avoir choisi notre HOTEL "
                        . "pour votre séjour.";
            } else if ($client["1"]["sal"] != NULL) {
                $reqst = $con->query("select * from hotel_salle where id_salle= '" . $client["1"]["sal"] . "' ") or die(mysqli_error($con));
                $rowst = mysqli_fetch_assoc($reqst);
                $obh = $rowst["code_salle"];
                $prixpl = $dif * $rowst["prix_salle"];
                $rsltpl = $con->query("insert into hotel_paye_logement(id_salle, id_client, code_pl, prix_u, prix_pl, nbpers, date_debut_pl, "
                        . "date_fin_pl, date_pl) values('" . $client["1"]["sal"] . "', '" . $rowcl["id_client"] . "', '" . $numid . "', "
                        . "'" . $rowst["prix_salle"] . "', '" . $prixpl . "', '" . $client["1"]["nbpers"] . "', '" . $client["1"]["datedpl"] . "', '" . $client["1"]["datefpl"] . "', "
                        . "NOW())") or die(mysqli_error($con));
                $reqpl = $con->query("select * from hotel_paye_logement where code_pl= '" . $numid . "' ") or die(mysqli_error($con));
                $rowpl = mysqli_fetch_assoc($reqpl);

                $rsltch = $con->query("update hotel_salle set etat_salle='" . $occupe . "' ,reserve_salle='" . $client["1"]["reserve"] . "' "
                        . "where id_salle= '" . $client["1"]["sal"] . "'") or die(mysqli_error($con));

                $rsltre = $con->query("insert into hotel_recu(id_paye_logement, montant, date_debut_re, date_fin_re, date_recu) "
                        . "values('" . $rowpl["id_paye_logement"] . "', '" . $prixpl . "', '" . $client["1"]["datedpl"] . "', "
                        . "'" . $client["1"]["datefpl"] . "', NOW())") or die(mysqli_error($con));

                $reqplo = $con->query("select * from hotel_paye_logement where code_pl= '" . $numid . "' ") or die(mysqli_error($con));
                $rowplo = mysqli_fetch_assoc($reqplo);
                if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                    $rsltreg = $con->query("insert into hotel_registre_client(id_paye_logement, montant_reg, operation_reg, date_registre) "
                            . "values('" . $rowpl["id_paye_logement"] . "', '" . $prixpl . "', '" . $op . "', NOW())") or die(mysqli_error($con));
                } else if (isset($_SESSION["login_personnel"]) && (isset($_SESSION["mot_de_passe_personnel"])) && ($_SESSION["etat_compte_personnel"])) {
                    $rsltreg = $con->query("insert into hotel_registre_client(id_paye_logement, id_compte_personnel, montant_reg, "
                            . "operation_reg, date_registre) values('" . $rowpl["id_paye_logement"] . "', "
                            . "'" . $_SESSION["id_compte_personnel"] . "', '" . $prixpl . "', '" . $op . "', NOW())") or die(mysqli_error($con));
                }
                $contenu = "Bonjour M. /Mme. " . $rowcl["nom_client"] . " " . $rowcl["prenom_client"] . " Votre salle "
                        . "" . $rowst["code_salle"] . " est située au niveau " . $rowst["niveau_salle"] . ". Merci d'avoir "
                        . "choisi notre HOTEL pour votre séjour.";
            }
        }
        $reqr = $con->query("select * from hotel_recu where id_paye_logement= '" . $rowpl["id_paye_logement"] . "' order by date_recu desc "
                . "LIMIT 0,1") or die(mysqli_error($con));
        $rowr = mysqli_fetch_assoc($reqr);
        $numero = $rowcl["telephone_client"];
        if ($numero != NULL) {
            if (strlen($numero) <= 9) {
                $numero = "237" . $numero;
            }

            $smsObj = new Sender('martial_ngueto', 'nguetongueto@@1989', 'UB', $contenu, $numero, '1', '1');

//            print_r($numero);
//            print_r($contenu);
            try {
                //Envoyer le SMS
                $smsObj->Submit();
                $result = $smsObj->response;
                echo "<script language='javascript'>$('div.alertsmsbon').show('slow').delay(8000).hide('slow');</script>";
            } catch (Exception $e) {
                dd($e->getMessage());
            }
        }
        $oph = "Loger";
        if (isset($_SESSION["loginproprietaire"]) && isset($_SESSION["id_proprietaire"])) {
            $rslthisto = $con->query("insert into hotel_historique(id_proprietaire, id_client, operation_h, objet_h, date_histo) "
                    . "values('" . $_SESSION["id_proprietaire"] . "', '" . $rowcl["id_client"] . "', '" . $oph . "', '" . $obh . "', NOW())") or die(mysqli_error($con));
        }

        echo "<script language='javascript'>$('div.alertuseraddbon').show('slow').delay(8000).hide('slow');</script>";
        unset($_SESSION['formlog']);
        ?>
        <a href="hotelpages/clienthotel/facture_client_inc_pdf.php?recu=<?php echo $rowr["id_recu"] ?>" class="btn btn-lg btn-success" target="_blank">
            <span title="Imprimer la facture du client" alt="editer"><i class="fa fa-file-pdf-o"></i> Impriner la facture</span>
        </a>
        <?php
    } else {
        echo "<script language='javascript'>$('div.alertclformvide').show('slow').delay(8000).hide('slow');</script>";
    }
}

function ajouter_client_p($client, $con) {
    if (($client != NULL) && isset($client["1"])) {
        if (!($client["2"]["ancien"])) {
            $rsltcl = $con->query("insert into hotel_client(nom_client, prenom_client, civilite_client, telephone_client, "
                    . "cni_client, ville_client, date_naissance, profession_client, date_client) values('" . $client["1"]["nomcl"] . "', "
                    . "'" . $client["1"]["prenomcl"] . "', '" . $client["1"]["civilitecl"] . "', '" . $client["1"]["telcl"] . "', "
                    . "'" . $client["1"]["cnicl"] . "', '" . $client["1"]["villecl"] . "', '" . $client["1"]["datenaiscl"] . "', "
                    . "'" . $client["1"]["profcl"] . "', NOW())") or die(mysqli_error($con));
        }
        $reqcl = $con->query("select * from hotel_client where cni_client= '" . $client["1"]["cnicl"] . "' ") or die(mysqli_error($con));
        $rowcl = mysqli_fetch_assoc($reqcl);

        $rowplo = NULL;

        $an = date('Y');
        $numid = date('Y', time()) . sprintf("%08d", 1);
        $req1 = $con->query("select * from hotel_paye_logement where YEAR(date_pl)='" . $an . "'") or die(mysqli_error($con));
        $i = 0;
        while ($reqte = mysqli_fetch_assoc($req1)) {
            $i = $i + 1;
        }
        $numid = date('Y', time()) . sprintf("%08d", $i + 1);
        $occupe = 1;
        $op = "Logement";
        if ($client["1"]["reserve"]) {
            $occupe = 0;
            $op = "Réserver";
        }
        $contenu = NULL;
        $obh = "";

        $dif1 = dates_range(date('Y-m-d', strtotime($client["1"]["datedpl"])), date('Y-m-d', strtotime($client["1"]["datefpl"])));
        $dif = $dif1 - 1;
        $prixpl = 0;
        if ($client["1"]["cha"] != NULL) {
            $reqch = $con->query("select * from hotel_chambre where id_chambre= '" . $client["1"]["cha"] . "' ") or die(mysqli_error($con));
            $rowch = mysqli_fetch_assoc($reqch);
            $obh = $rowch["code_c"];
            $prixpl = $dif * $rowch["prix_c"];
            $rsltpl = $con->query("insert into hotel_paye_logement(id_chambre, id_client, code_pl, prix_u, prix_pl, receptionniste, nbpers, date_debut_pl, "
                    . "date_fin_pl, date_pl) values('" . $client["1"]["cha"] . "', '" . $rowcl["id_client"] . "', '" . $numid . "', "
                    . "'" . $rowch["prix_c"] . "', '" . $prixpl . "', '" . $_SESSION["id_compte_personnel"] . "', '" . $client["1"]["nbpers"] . "', '" . $client["1"]["datedpl"] . "', '" . $client["1"]["datefpl"] . "', "
                    . "NOW())") or die(mysqli_error($con));
            $reqpl = $con->query("select * from hotel_paye_logement where code_pl= '" . $numid . "' ") or die(mysqli_error($con));
            $rowpl = mysqli_fetch_assoc($reqpl);

            $rsltch = $con->query("update hotel_chambre set etat_c='" . $occupe . "' ,reserve_c='" . $client["1"]["reserve"] . "' "
                    . "where id_chambre= '" . $client["1"]["cha"] . "'") or die(mysqli_error($con));

            $rsltre = $con->query("insert into hotel_recu(id_paye_logement, montant, date_debut_re, date_fin_re, date_recu) "
                    . "values('" . $rowpl["id_paye_logement"] . "', '" . $prixpl . "', '" . $client["1"]["datedpl"] . "', "
                    . "'" . $client["1"]["datefpl"] . "', NOW())") or die(mysqli_error($con));

            $reqplo = $con->query("select * from hotel_paye_logement where code_pl= '" . $numid . "' ") or die(mysqli_error($con));
            $rowplo = mysqli_fetch_assoc($reqplo);
            if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                $rsltreg = $con->query("insert into hotel_registre_client(id_paye_logement, montant_reg, operation_reg, date_registre) "
                        . "values('" . $rowpl["id_paye_logement"] . "', '" . $prixpl . "', '" . $op . "', NOW())") or die(mysqli_error($con));
            } else if (isset($_SESSION["login_personnel"]) && (isset($_SESSION["mot_de_passe_personnel"])) && ($_SESSION["etat_compte_personnel"])) {
                $rsltreg = $con->query("insert into hotel_registre_client(id_paye_logement, id_compte_personnel, montant_reg, "
                        . "operation_reg, date_registre) values('" . $rowpl["id_paye_logement"] . "', "
                        . "'" . $_SESSION["id_compte_personnel"] . "', '" . $prixpl . "', '" . $op . "', NOW())") or die(mysqli_error($con));
            }
            $contenu = "Bonjour M. /Mme. " . $rowcl["nom_client"] . " " . $rowcl["prenom_client"] . " Votre chambre "
                    . "" . $rowch["code_c"] . " est situé au niveau " . $rowch["niveau_c"] . ". Merci d'avoir choisi notre HOTEL "
                    . "pour votre séjour.";
        } else if ($client["1"]["std"] != NULL) {
            $reqst = $con->query("select * from hotel_studio where id_studio= '" . $client["1"]["std"] . "' ") or die(mysqli_error($con));
            $rowst = mysqli_fetch_assoc($reqst);
            $obh = $rowst["code_s"];
            $prixpl = $dif * $rowst["prix_s"];
            $rsltpl = $con->query("insert into hotel_paye_logement(id_studio, id_client, code_pl, prix_u, prix_pl, receptionniste, nbpers, date_debut_pl, "
                    . "date_fin_pl, date_pl) values('" . $client["1"]["std"] . "', '" . $rowcl["id_client"] . "', '" . $numid . "', "
                    . "'" . $rowst["prix_s"] . "', '" . $prixpl . "', '" . $_SESSION["id_compte_personnel"] . "', '" . $client["1"]["nbpers"] . "', '" . $client["1"]["datedpl"] . "', '" . $client["1"]["datefpl"] . "', "
                    . "NOW())") or die(mysqli_error($con));
            $reqpl = $con->query("select * from hotel_paye_logement where code_pl= '" . $numid . "' ") or die(mysqli_error($con));
            $rowpl = mysqli_fetch_assoc($reqpl);

            $rsltch = $con->query("update hotel_studio set etat_s='" . $occupe . "' ,reserve_s='" . $client["1"]["reserve"] . "' "
                    . "where id_studio= '" . $client["1"]["std"] . "'") or die(mysqli_error($con));

            $rsltre = $con->query("insert into hotel_recu(id_paye_logement, montant, date_debut_re, date_fin_re, date_recu) "
                    . "values('" . $rowpl["id_paye_logement"] . "', '" . $prixpl . "', '" . $client["1"]["datedpl"] . "', "
                    . "'" . $client["1"]["datefpl"] . "', NOW())") or die(mysqli_error($con));

            $reqplo = $con->query("select * from hotel_paye_logement where code_pl= '" . $numid . "' ") or die(mysqli_error($con));
            $rowplo = mysqli_fetch_assoc($reqplo);
            if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                $rsltreg = $con->query("insert into hotel_registre_client(id_paye_logement, montant_reg, operation_reg, date_registre) "
                        . "values('" . $rowpl["id_paye_logement"] . "', '" . $prixpl . "', '" . $op . "', NOW())") or die(mysqli_error($con));
            } else if (isset($_SESSION["login_personnel"]) && (isset($_SESSION["mot_de_passe_personnel"])) && ($_SESSION["etat_compte_personnel"])) {
                $rsltreg = $con->query("insert into hotel_registre_client(id_paye_logement, id_compte_personnel, montant_reg, "
                        . "operation_reg, date_registre) values('" . $rowpl["id_paye_logement"] . "', "
                        . "'" . $_SESSION["id_compte_personnel"] . "', '" . $prixpl . "', '" . $op . "', NOW())") or die(mysqli_error($con));
            }
            $contenu = "Bonjour M. /Mme. " . $rowcl["nom_client"] . " " . $rowcl["prenom_client"] . " Votre studio "
                    . "" . $rowst["code_s"] . " est situé au niveau " . $rowst["niveau_s"] . ". Merci d'avoir choisi notre HOTEL "
                    . "pour votre séjour.";
        } else if ($client["1"]["app"] != NULL) {
            $reqap = $con->query("select * from hotel_appartement where id_appartement= '" . $client["1"]["app"] . "' ") or die(mysqli_error($con));
            $rowap = mysqli_fetch_assoc($reqap);
            $obh = $rowap["code_a"];
            $prixpl = $dif * $rowap["prix_a"];
            $rsltpl = $con->query("insert into hotel_paye_logement(id_appartement, id_client, code_pl, prix_u, prix_pl, receptionniste, nbpers, date_debut_pl, "
                    . "date_fin_pl, date_pl) values('" . $client["1"]["app"] . "', '" . $rowcl["id_client"] . "', '" . $numid . "', "
                    . "'" . $rowap["prix_a"] . "', '" . $prixpl . "', '" . $_SESSION["id_compte_personnel"] . "', '" . $client["1"]["nbpers"] . "', '" . $client["1"]["datedpl"] . "', '" . $client["1"]["datefpl"] . "', "
                    . "NOW())") or die(mysqli_error($con));
            $reqpl = $con->query("select * from hotel_paye_logement where code_pl= '" . $numid . "' ") or die(mysqli_error($con));
            $rowpl = mysqli_fetch_assoc($reqpl);

            $rsltch = $con->query("update hotel_appartement set etat_a='" . $occupe . "' ,reserve_a='" . $client["1"]["reserve"] . "' "
                    . "where id_appartement= '" . $client["1"]["app"] . "'") or die(mysqli_error($con));

            $rsltre = $con->query("insert into hotel_recu(id_paye_logement, montant, date_debut_re, date_fin_re, date_recu) "
                    . "values('" . $rowpl["id_paye_logement"] . "', '" . $prixpl . "', '" . $client["1"]["datedpl"] . "', "
                    . "'" . $client["1"]["datefpl"] . "', NOW())") or die(mysqli_error($con));

            $reqplo = $con->query("select * from hotel_paye_logement where code_pl= '" . $numid . "' ") or die(mysqli_error($con));
            $rowplo = mysqli_fetch_assoc($reqplo);
            if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                $rsltreg = $con->query("insert into hotel_registre_client(id_paye_logement, montant_reg, operation_reg, date_registre) "
                        . "values('" . $rowpl["id_paye_logement"] . "', '" . $prixpl . "', '" . $op . "', NOW())") or die(mysqli_error($con));
            } else if (isset($_SESSION["login_personnel"]) && (isset($_SESSION["mot_de_passe_personnel"])) && ($_SESSION["etat_compte_personnel"])) {
                $rsltreg = $con->query("insert into hotel_registre_client(id_paye_logement, id_compte_personnel, montant_reg, "
                        . "operation_reg, date_registre) values('" . $rowpl["id_paye_logement"] . "', "
                        . "'" . $_SESSION["id_compte_personnel"] . "', '" . $prixpl . "', '" . $op . "', NOW())") or die(mysqli_error($con));
            }
            $contenu = "Bonjour M. /Mme. " . $rowcl["nom_client"] . " " . $rowcl["prenom_client"] . " Votre appartement "
                    . "" . $rowap["code_a"] . " est situé au niveau " . $rowap["niveau_a"] . ". Merci d'avoir choisi notre HOTEL "
                    . "pour votre séjour.";
        } else if ($client["1"]["sal"] != NULL) {
            $reqst = $con->query("select * from hotel_salle where id_salle= '" . $client["1"]["sal"] . "' ") or die(mysqli_error($con));
            $rowst = mysqli_fetch_assoc($reqst);
            $obh = $rowst["code_salle"];
            $prixpl = $dif * $rowst["prix_salle"];
            $rsltpl = $con->query("insert into hotel_paye_logement(id_salle, id_client, code_pl, prix_u, prix_pl, receptionniste, nbpers, date_debut_pl, "
                    . "date_fin_pl, date_pl) values('" . $client["1"]["sal"] . "', '" . $rowcl["id_client"] . "', '" . $numid . "', "
                    . "'" . $rowst["prix_salle"] . "', '" . $prixpl . "', '" . $_SESSION["id_compte_personnel"] . "', '" . $client["1"]["nbpers"] . "', '" . $client["1"]["datedpl"] . "', '" . $client["1"]["datefpl"] . "', "
                    . "NOW())") or die(mysqli_error($con));
            $reqpl = $con->query("select * from hotel_paye_logement where code_pl= '" . $numid . "' ") or die(mysqli_error($con));
            $rowpl = mysqli_fetch_assoc($reqpl);

            $rsltch = $con->query("update hotel_studio set etat_salle='" . $occupe . "' ,reserve_salle='" . $client["1"]["reserve"] . "' "
                    . "where id_salle= '" . $client["1"]["sal"] . "'") or die(mysqli_error($con));

            $rsltre = $con->query("insert into hotel_recu(id_paye_logement, montant, date_debut_re, date_fin_re, date_recu) "
                    . "values('" . $rowpl["id_paye_logement"] . "', '" . $prixpl . "', '" . $client["1"]["datedpl"] . "', "
                    . "'" . $client["1"]["datefpl"] . "', NOW())") or die(mysqli_error($con));

            $reqplo = $con->query("select * from hotel_paye_logement where code_pl= '" . $numid . "' ") or die(mysqli_error($con));
            $rowplo = mysqli_fetch_assoc($reqplo);
            if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                $rsltreg = $con->query("insert into hotel_registre_client(id_paye_logement, montant_reg, operation_reg, date_registre) "
                        . "values('" . $rowpl["id_paye_logement"] . "', '" . $prixpl . "', '" . $op . "', NOW())") or die(mysqli_error($con));
            } else if (isset($_SESSION["login_personnel"]) && (isset($_SESSION["mot_de_passe_personnel"])) && ($_SESSION["etat_compte_personnel"])) {
                $rsltreg = $con->query("insert into hotel_registre_client(id_paye_logement, id_compte_personnel, montant_reg, "
                        . "operation_reg, date_registre) values('" . $rowpl["id_paye_logement"] . "', "
                        . "'" . $_SESSION["id_compte_personnel"] . "', '" . $prixpl . "', '" . $op . "', NOW())") or die(mysqli_error($con));
            }
            $contenu = "Bonjour M. /Mme. " . $rowcl["nom_client"] . " " . $rowcl["prenom_client"] . " Votre studio "
                    . "" . $rowst["code_s"] . " est situé au niveau " . $rowst["niveau_s"] . ". Merci d'avoir choisi notre HOTEL "
                    . "pour votre séjour.";
        }
        $reqr = $con->query("select * from hotel_recu where id_paye_logement= '" . $rowpl["id_paye_logement"] . "' order by date_recu desc "
                . "LIMIT 0,1") or die(mysqli_error($con));
        $rowr = mysqli_fetch_assoc($reqr);
        $numero = $rowcl["telephone_client"];
        if ($numero != NULL) {
            if (strlen($numero) <= 9) {
                $numero = "237" . $numero;
            }

            $smsObj = new Sender('martial_ngueto', 'nguetongueto@@1989', 'UB', $contenu, $numero, '1', '1');

//            print_r($numero);
//            print_r($contenu);
            try {
                //Envoyer le SMS
                $smsObj->Submit();
                $result = $smsObj->response;
                echo "<script language='javascript'>$('div.alertsmsbon').show('slow').delay(8000).hide('slow');</script>";
            } catch (Exception $e) {
                dd($e->getMessage());
            }
        }
        $oph = "Loger";
        if (isset($_SESSION["login_personnel"]) && isset($_SESSION["id_compte_personnel"])) {
            $rslthisto = $con->query("insert into hotel_historique(id_compte_personnel, id_client, operation_h, objet_h, date_histo) "
                    . "values('" . $_SESSION["id_compte_personnel"] . "', '" . $rowcl["id_client"] . "', '" . $oph . "', '" . $obh . "', NOW())") or die(mysqli_error($con));
        }
        echo "<script language='javascript'>$('div.alertuseraddbon').show('slow').delay(8000).hide('slow');</script>";
        unset($_SESSION['formlog']);
        ?>
        <a href="hotelpages/clienthotel/facture_client_inc_pdf.php?recu=<?php echo $rowr["id_recu"] ?>" class="btn btn-lg btn-success" target="_blank">
            <span title="Imprimer la facture du client" alt="editer"><i class="fa fa-file-pdf-o"></i> Impriner la facture</span>
        </a>
        <?php
    } else {
        echo "<script language='javascript'>$('div.alertclformvide').show('slow').delay(8000).hide('slow');</script>";
    }
}

//gestion des Clients
//fonction pour ajouter une Client
function ajouter_jour_client($id, $prixl, $datefpl2, $con) {
    $rsltpl2 = $con->query("select * from hotel_paye_logement as pl left join hotel_client as c on pl.id_client=c.id_client "
            . "where pl.id_client='" . $id . "' order by pl.date_pl desc LIMIT 0,1") or die(mysqli_error($con));
    $rowpl2 = mysqli_fetch_assoc($rsltpl2);
    $contenu = NULL;
    $op = "Ajout Jour";
    $obh = "";
    $datedpl2 = $rowpl2["date_fin_pl"];
    if ($rowpl2["id_chambre"] != NULL) {
        $reqch1 = $con->query("select * from hotel_chambre where id_chambre= '" . $rowpl2["id_chambre"] . "' ") or die(mysqli_error($con));
        $rowch1 = mysqli_fetch_assoc($reqch1);
        $obh = $rowch1["code_c"];
    } else if ($rowpl2["id_studio"] != NULL) {
        $reqst1 = $con->query("select * from hotel_studio where id_studio= '" . $rowpl2["id_studio"] . "' ") or die(mysqli_error($con));
        $rowst1 = mysqli_fetch_assoc($reqst1);
        $obh = $rowst1["code_s"];
    } else if ($rowpl2["id_appartement"] != NULL) {
        $reqap1 = $con->query("select * from hotel_appartement where id_appartement= '" . $rowpl2["id_appartement"] . "' ") or die(mysqli_error($con));
        $rowap1 = mysqli_fetch_assoc($reqap1);
        $obh = $rowap1["code_a"];
    } else if ($rowpl2["id_salle"] != NULL) {
        $reqsa1 = $con->query("select * from hotel_salle where id_salle= '" . $rowpl2["id_salle"] . "' ") or die(mysqli_error($con));
        $rowsa1 = mysqli_fetch_assoc($reqsa1);
        $obh = $rowsa1["code_salle"];
    }
    $dif1 = dates_range(date('Y-m-d', strtotime($rowpl2["date_fin_pl"])), date('Y-m-d', strtotime($datefpl2)));
    $dif = $dif1 - 1;
    $prixpl = 0;
    $prixpl = $dif * $rowpl2["prix_u"];
    $pri = $prixpl + $rowpl2["prix_pl"];
    $rsltpl = $con->query("update hotel_paye_logement set prix_pl='" . $pri . "', date_fin_pl= '" . $datefpl2 . "' "
            . "where id_paye_logement='" . $rowpl2["id_paye_logement"] . "'") or die(mysqli_error($con));

    $rsltre = $con->query("insert into hotel_recu(id_paye_logement, montant, date_debut_re, date_fin_re, date_recu) "
            . "values('" . $rowpl2["id_paye_logement"] . "', '" . $prixpl . "', '" . $datedpl2 . "', "
            . "'" . $datefpl2 . "', NOW())") or die(mysqli_error($con));

    if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
        $rsltreg = $con->query("insert into hotel_registre_client(id_paye_logement, montant_reg, operation_reg, date_registre) "
                . "values('" . $rowpl2["id_paye_logement"] . "', '" . $prixpl . "', '" . $op . "', NOW())") or die(mysqli_error($con));
    } else if (isset($_SESSION["login_personnel"]) && (isset($_SESSION["mot_de_passe_personnel"])) && ($_SESSION["etat_compte_personnel"])) {
        $rsltreg = $con->query("insert into hotel_registre_client(id_paye_logement, id_compte_personnel, montant_reg, "
                . "operation_reg, date_registre) values('" . $rowpl2["id_paye_logement"] . "', "
                . "'" . $_SESSION["id_compte_personnel"] . "', '" . $prixpl . "', '" . $op . "', NOW())") or die(mysqli_error($con));
    }
    $contenu = "Bonjour M. /Mme. " . $rowpl2["nom_client"] . " " . $rowpl2["prenom_client"] . " Vous avez prolongé votre séjour.";

    $reqr = $con->query("select * from hotel_recu where id_paye_logement= '" . $rowpl2["id_paye_logement"] . "' order by date_recu desc LIMIT 0,1") or die(mysqli_error($con));
    $rowr = mysqli_fetch_assoc($reqr);

    $numero = $rowpl2["telephone_client"];
    if ($numero != NULL) {
        if (strlen($numero) <= 9) {
            $numero = "237" . $numero;
        }

        $smsObj = new Sender('martial_ngueto', 'nguetongueto@@1989', 'UB', $contenu, $numero, '1', '1');

//            print_r($numero);
//            print_r($contenu);
        try {
            //Envoyer le SMS
            $smsObj->Submit();
            $result = $smsObj->response;
            echo "<script language='javascript'>$('div.alertsmsbon').show('slow').delay(8000).hide('slow');</script>";
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
    $oph = "Loger";
    if (isset($_SESSION["loginproprietaire"]) && isset($_SESSION["id_proprietaire"])) {
        $rslthisto = $con->query("insert into hotel_historique(id_proprietaire, id_client, operation_h, objet_h, date_histo) "
                . "values('" . $_SESSION["id_proprietaire"] . "', '" . $rowpl2["id_client"] . "', '" . $oph . "', '" . $obh . "', NOW())") or die(mysqli_error($con));
    }
    echo "<script language='javascript'>$('div.alertuseraddbon').show('slow').delay(8000).hide('slow');</script>";
    ?>
    <a href="hotelpages/clienthotel/facture_client_inc_pdf.php?recu=<?php echo $rowr["id_recu"] ?>" class="btn btn-lg btn-success" target="_blank">
        <span title="Imprimer la facture du client" alt="editer"><i class="fa fa-file-pdf-o"></i> Impriner la facture</span>
    </a>
    <?php
}

function ajouter_jour_client_p($id, $datefpl2, $con) {
    $rsltpl2 = $con->query("select * from hotel_paye_logement as pl left join hotel_client as c on pl.id_client=c.id_client "
            . "left join hotel_recu as r on pl.id_paye_logement=r.id_paye_logement "
            . "where pl.id_client='" . $id . "' order by pl.date_pl desc LIMIT 0,1") or die(mysqli_error($con));
    $rowpl2 = mysqli_fetch_assoc($rsltpl2);
    $contenu = NULL;
    $op = "Ajout Jour";
    $obh = "";
    $datedpl2 = $rowpl2["date_fin_pl"];
    $dif = dates_range(date('Y-m-d', strtotime($rowpl2["date_fin_pl"])), date('Y-m-d', strtotime($datefpl2)));

    if ($rowpl2["id_chambre"] != NULL) {
        $reqch = $con->query("select * from hotel_chambre where id_chambre= '" . $rowpl2["id_chambre"] . "' ") or die(mysqli_error($con));
        $rowch = mysqli_fetch_assoc($reqch);
        $obh = $rowch["code_c"];
    } else if ($rowpl2["id_studio"] != NULL) {
        $reqst = $con->query("select * from hotel_studio where id_studio= '" . $rowpl2["id_studio"] . "' ") or die(mysqli_error($con));
        $rowst = mysqli_fetch_assoc($reqst);
        $obh = $rowst["code_s"];
    } else if ($rowpl2["id_appartement"] != NULL) {
        $reqap = $con->query("select * from hotel_appartement where id_appartement= '" . $rowpl2["id_appartement"] . "' ") or die(mysqli_error($con));
        $rowap = mysqli_fetch_assoc($reqap);
        $obh = $rowap["code_a"];
    } else if ($rowpl2["id_salle"] != NULL) {
        $reqsa = $con->query("select * from hotel_salle where id_salle= '" . $rowpl2["id_salle"] . "' ") or die(mysqli_error($con));
        $rowsa = mysqli_fetch_assoc($reqsa);
        $obh = $rowsa["code_salle"];
    }
    $prixpl = $dif * $rowpl2["prix_u"];
    $pri = $prixpl + $rowpl2["prix_pl"];
    $rsltpl = $con->query("update hotel_paye_logement set prix_pl='" . $pri . "', date_fin_pl= '" . $datefpl2 . "' "
            . "where id_paye_logement='" . $rowpl2["id_paye_logement"] . "'") or die(mysqli_error($con));

    $rsltre = $con->query("insert into hotel_recu(id_paye_logement, montant, date_debut_re, date_fin_re, date_recu) "
            . "values('" . $rowpl2["id_paye_logement"] . "', '" . $prixpl . "', '" . $datedpl2 . "', "
            . "'" . $datefpl2 . "', NOW())") or die(mysqli_error($con));

    if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
        $rsltreg = $con->query("insert into hotel_registre_client(id_paye_logement, montant_reg, operation_reg, date_registre) "
                . "values('" . $rowpl2["id_paye_logement"] . "', '" . $prixpl . "', '" . $op . "', NOW())") or die(mysqli_error($con));
    } else if (isset($_SESSION["login_personnel"]) && (isset($_SESSION["mot_de_passe_personnel"])) && ($_SESSION["etat_compte_personnel"])) {
        $rsltreg = $con->query("insert into hotel_registre_client(id_paye_logement, id_compte_personnel, montant_reg, "
                . "operation_reg, date_registre) values('" . $rowpl2["id_paye_logement"] . "', "
                . "'" . $_SESSION["id_compte_personnel"] . "', '" . $prixpl . "', '" . $op . "', NOW())") or die(mysqli_error($con));
    }
    $contenu = "Bonjour M. /Mme. " . $rowpl2["nom_client"] . " " . $rowpl2["prenom_client"] . " Vous avez prolongé votre séjour.";

    $reqr = $con->query("select * from hotel_recu where id_paye_logement= '" . $rowpl2["id_paye_logement"] . "' order by date_recu desc LIMIT 0,1") or die(mysqli_error($con));
    $rowr = mysqli_fetch_assoc($reqr);

    $numero = $rowpl2["telephone_client"];
    if ($numero != NULL) {
        if (strlen($numero) <= 9) {
            $numero = "237" . $numero;
        }

        $smsObj = new Sender('martial_ngueto', 'nguetongueto@@1989', 'UB', $contenu, $numero, '1', '1');

//            print_r($numero);
//            print_r($contenu);
        try {
            //Envoyer le SMS
            $smsObj->Submit();
            $result = $smsObj->response;
            echo "<script language='javascript'>$('div.alertsmsbon').show('slow').delay(8000).hide('slow');</script>";
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
    $oph = "Ajouter jour";
    if (isset($_SESSION["login_personnel"]) && isset($_SESSION["id_compte_personnel"])) {
        $rslthisto = $con->query("insert into hotel_historique(id_compte_personnel, id_client, operation_h, objet_h, date_histo) "
                . "values('" . $_SESSION["id_compte_personnel"] . "', '" . $rowpl2["id_client"] . "', '" . $oph . "', '" . $obh . "', NOW())") or die(mysqli_error($con));
    }
    echo "<script language='javascript'>$('div.alertuseraddbon').show('slow').delay(8000).hide('slow');</script>";
    ?>
    <a href="hotelpages/clienthotel/facture_client_inc_pdf.php?recu=<?php echo $rowr["id_recu"] ?>" class="btn btn-lg btn-success" target="_blank">
        <span title="Imprimer la facture du client" alt="editer"><i class="fa fa-file-pdf-o"></i> Impriner la facture</span>
    </a>
    <?php
}

function ajouter_versement_client_p($vers, $con) {
    if (($vers != NULL) && isset($vers["1"])) {
        $rsltpl2 = $con->query("select * from hotel_paye_logement as pl left join hotel_client as c on pl.id_client=c.id_client "
                . "left join hotel_recu as r on pl.id_paye_logement=r.id_paye_logement "
                . "where pl.id_client='" . $vers[1]["client"] . "' order by pl.date_pl desc LIMIT 0,1") or die(mysqli_error($con));
        $rowpl2 = mysqli_fetch_assoc($rsltpl2);
        $contenu = NULL;

        $op = "Versement";
        $obh = "";
        if ($rowpl2["id_chambre"] != NULL) {
            $reqch1 = $con->query("select * from hotel_chambre where id_chambre= '" . $rowpl2["id_chambre"] . "' ") or die(mysqli_error($con));
            $rowch1 = mysqli_fetch_assoc($reqch1);
            $obh = $rowch1["code_c"];
        } else if ($rowpl2["id_studio"] != NULL) {
            $reqst1 = $con->query("select * from hotel_studio where id_studio= '" . $rowpl2["id_studio"] . "' ") or die(mysqli_error($con));
            $rowst1 = mysqli_fetch_assoc($reqst1);
            $obh = $rowst1["code_s"];
        } else if ($rowpl2["id_appartement"] != NULL) {
            $reqap1 = $con->query("select * from hotel_appartement where id_appartement= '" . $rowpl2["id_appartement"] . "' ") or die(mysqli_error($con));
            $rowap1 = mysqli_fetch_assoc($reqap1);
            $obh = $rowap1["code_a"];
        } else if ($rowpl2["id_salle"] != NULL) {
            $reqsa1 = $con->query("select * from hotel_salle where id_salle= '" . $rowpl2["id_salle"] . "' ") or die(mysqli_error($con));
            $rowsa1 = mysqli_fetch_assoc($reqsa1);
            $obh = $rowsa1["code_salle"];
        }

        if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
            $rsltreg = $con->query("insert into hotel_registre_client(id_paye_logement, montant_reg, operation_reg, "
                    . "date_registre) values('" . $rowpl2["id_paye_logement"] . "', '" . $vers[1]["montant"] . "', "
                    . "'" . $op . "', NOW())") or die(mysqli_error($con));
        } else if (isset($_SESSION["login_personnel"]) && (isset($_SESSION["mot_de_passe_personnel"])) && ($_SESSION["etat_compte_personnel"])) {
            if (($_SESSION["code_service"] == "RECEP")) {
                $rsltreg = $con->query("insert into hotel_registre_client(id_paye_logement, id_compte_personnel, "
                        . "montant_reg, operation_reg, date_registre) values('" . $rowpl2["id_paye_logement"] . "', "
                        . "'" . $_SESSION["id_compte_personnel"] . "', '" . $vers[1]["montant"] . "', '" . $op . "',"
                        . " NOW())") or die(mysqli_error($con));
            }
        }
        $contenu = "Bonjour M. /Mme. " . $rowpl2["nom_client"] . " " . $rowpl2["prenom_client"] . " Vous avez effectué un versement de  " . $vers[1]["montant"] . ".";

        $numero = $rowpl2["telephone_client"];
        if ($numero != NULL) {
            if (strlen($numero) <= 9) {
                $numero = "237" . $numero;
            }

            $smsObj = new Sender('martial_ngueto', 'nguetongueto@@1989', 'UB', $contenu, $numero, '1', '1');

//            print_r($numero);
//            print_r($contenu);
            try {
                //Envoyer le SMS
                $smsObj->Submit();
                $result = $smsObj->response;
                echo "<script language='javascript'>$('div.alertsmsbon').show('slow').delay(8000).hide('slow');</script>";
            } catch (Exception $e) {
                dd($e->getMessage());
            }
        }
        $oph = "Versement " . $obh;
        if (isset($_SESSION["loginproprietaire"]) && isset($_SESSION["id_proprietaire"])) {
            $rslthisto = $con->query("insert into hotel_historique(id_proprietaire, id_client, operation_h, objet_h, date_histo) "
                    . "values('" . $_SESSION["id_proprietaire"] . "', '" . $rowpl2["id_client"] . "', '" . $oph . "', '" . $obh . "', NOW())") or die(mysqli_error($con));
        } else if (isset($_SESSION["login_personnel"]) && isset($_SESSION["id_compte_personnel"])) {
            $rslthisto = $con->query("insert into hotel_historique(id_compte_personnel, id_client, operation_h, objet_h, date_histo) "
                    . "values('" . $_SESSION["id_compte_personnel"] . "', '" . $rowpl2["id_client"] . "', '" . $oph . "', '" . $obh . "', NOW())") or die(mysqli_error($con));
        }
        echo "<script language='javascript'>$('div.alertuseraddbon').show('slow').delay(8000).hide('slow');</script>";
        unset($_SESSION['formvoyp']);
        ?>
                                                                                                                                                                            <!--        <a href="hotelpages/clienthotel/facture_client_inc_pdf.php?recu=<?php echo $rowr["id_recu"] ?>" class="btn btn-lg btn-success" target="_blank">
                                                                                                                                                                                    <span title="Imprimer la facture du client" alt="editer"><i class="fa fa-file-pdf-o"></i> Impriner la facture</span>
                                                                                                                                                                                </a>-->
        <?php
    } else {
        echo "<script language='javascript'>$('div.alertclformvide').show('slow').delay(8000).hide('slow');</script>";
    }
}

//fonction pour lister les Clients
function lister_client($con) {
    $rsltuser = $con->query("select * from hotel_client order by date_client ") or die(mysqli_error($con));
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        $rsltpl = $con->query("select * from hotel_paye_logement as pl left join hotel_recu as r on pl.id_paye_logement=r.id_paye_logement "
                . "where pl.id_client='" . $recuser["id_client"] . "' and pl.date_fin_pl >= NOW() order by pl.date_pl desc ") or die(mysqli_error($con));
        $rowpl = mysqli_fetch_assoc($rsltpl);
        $rsltpl2 = $con->query("select * from hotel_paye_logement as pl left join hotel_recu as r on pl.id_paye_logement=r.id_paye_logement "
                . "where pl.id_client='" . $recuser["id_client"] . "' order by pl.date_pl desc limit 0,1") or die(mysqli_error($con));
        $rowpl2 = mysqli_fetch_assoc($rsltpl2);
        $today = date('Y-m-d H:i:s');
        $dif = dateDiff($today, $rowpl["date_fin_pl"]);
        ?>

        <tr >
            <td>
                <?php
                if ($rowpl2["id_chambre"] != NULL) {
                    $reqch = $con->query("select * from hotel_chambre as c left join hotel_point_hotel as ph on c.id_point_hotel=ph.id_point_hotel "
                            . "left join hotel_proprietaire as p on ph.id_proprietaire=p.id_proprietaire where c.id_chambre= '" . $rowpl2["id_chambre"] . "' ") or die(mysqli_error($con));
                    $rowch = mysqli_fetch_assoc($reqch);
                    ?>
                    <?php print nl2br(htmlspecialchars($rowch["code_c"])) ?>
                    <?php
                } else if ($rowpl2["id_studio"] != NULL) {
                    $reqst = $con->query("select * from hotel_studio as s left join hotel_point_hotel as ph on s.id_point_hotel=ph.id_point_hotel "
                            . "left join hotel_proprietaire as p on ph.id_proprietaire=p.id_proprietaire where s.id_studio= '" . $rowpl2["id_studio"] . "' ") or die(mysqli_error($con));
                    $rowst = mysqli_fetch_assoc($reqst);
                    ?>
                    <?php print nl2br(htmlspecialchars($rowst["code_s"])) ?>
                    <?php
                } else if ($rowpl2["id_appartement"] != NULL) {
                    $reqap = $con->query("select * from hotel_appartement as a left join hotel_point_hotel as ph on a.id_point_hotel=ph.id_point_hotel "
                            . "left join hotel_proprietaire as p on ph.id_proprietaire=p.id_proprietaire where a.id_appartement= '" . $rowpl2["id_appartement"] . "' ") or die(mysqli_error($con));
                    $rowap = mysqli_fetch_assoc($reqap);
                    ?>
                    <?php print nl2br(htmlspecialchars($rowap["code_a"])) ?> 
                    <?php print $rowap["nbchambre_a"] ?>Ch  
                    <?php echo $rowap["nbsalon_a"] ?>S  
                    <?php echo $rowap["nbdouche_a"] ?>D  
                    <?php echo $rowap["nbcuisine_a"] ?>Cu 
                    <?php
                } else if ($rowpl2["id_salle"] != NULL) {
                    $reqsa = $con->query("select * from hotel_salle as s left join hotel_point_hotel as ph on s.id_point_hotel=ph.id_point_hotel "
                            . "left join hotel_proprietaire as p on ph.id_proprietaire=p.id_proprietaire where s.id_salle= '" . $rowpl2["id_salle"] . "' ") or die(mysqli_error($con));
                    $rowsa = mysqli_fetch_assoc($reqsa);
                    ?>
                    <?php print nl2br(htmlspecialchars($rowsa["code_salle"])) ?>
                    <?php
                }
                ?>
            </td>
            <td><?php print nl2br(htmlspecialchars($recuser["nom_client"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["prenom_client"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["civilite_client"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["telephone_client"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["cni_client"])) ?></td>
            <td>
                <?php
                if (!$rowpl["reserve_pl"]) {
                    if (isset($_SESSION["loginproprietaire"])) {
                        ?>

                        <a href="indexproprietaire.php?page=<?php echo base64_encode('hotelpages/clienthotel/editer_client') ?>&client=<?php echo $recuser["id_client"] ?>">
                            <span title="Modifier ce Client" ><i class="glyphicon glyphicon-edit"></i></span>
                        </a>&nbsp;&nbsp;
                        <a href="indexproprietaire.php?page=<?php echo base64_encode('hotelpages/clienthotel/dossierclienthotel/lister_dossier_client') ?>&client=<?php echo $recuser["id_client"] ?>">
                            <span title="Ouvrir le dossier de ce Client" ><i class="glyphicon glyphicon-folder-open"></i></span>
                        </a>

                        <?php
                        if (!$rowpl2["regle_pl"]) {
                            ?>&nbsp;&nbsp;
                            <a href="indexproprietaire.php?page=<?php echo base64_encode('hotelpages/clienthotel/deplacer_client') ?>&client=<?php echo $recuser["id_client"] ?>">
                                <span title="D&eacute;placer ce Client" ><i class="glyphicon glyphicon-move"></i></span>
                            </a>&nbsp;&nbsp;
                            <a href="indexproprietaire.php?page=<?php echo base64_encode('hotelpages/clienthotel/dossierclienthotel/ajouter_loyer_client') ?>&client=<?php echo $recuser["id_client"] ?>">
                                <span title="Ajouter les jours de ce Client" ><i class="glyphicon glyphicon-plus"></i></span>
                            </a>
                            <!--                            &nbsp;&nbsp;
                                                        <a href="indexproprietaire.php?page=<?php echo base64_encode('hotelpages/clienthotel/commandeclienthotel/commander_client') ?>&client=<?php echo $recuser["id_client"] ?>">
                                                            <span title="Commande de ce client" alt="commander"><i class="glyphicon glyphicon-file"></i></span>
                                                        </a>-->
                            &nbsp;&nbsp;
                            <a href="indexproprietaire.php?page=<?php echo base64_encode('hotelpages/clienthotel/dossierclienthotel/ajout_versement_p') ?>&client=<?php echo $recuser["id_client"] ?>">
                                <span title="Ajouter le versement de ce client" ><i class="glyphicon glyphicon-credit-card"></i></span>
                            </a>
                            &nbsp;&nbsp;
                            <a href="indexproprietaire.php?page=<?php echo base64_encode('hotelpages/clienthotel/dossierclienthotel/affiche_registre') ?>&client=<?php echo $recuser["id_client"] ?>">
                                <span title="Afficher le registre de ce client" ><i class="glyphicon glyphicon-book"></i></span>
                            </a>
                            <?php
                        } else {
                            ?>&nbsp;&nbsp;
                    <!--                            <a href="indexproprietaire.php?page=<?php echo base64_encode('hotelpages/clienthotel/dossierclienthotel/loger_client') ?>&client=<?php echo $recuser["id_client"] ?>">
                                <span title="Loger ce Client" alt="loyer"><i class="glyphicon glyphicon-pushpin"></i></span>
                            </a>-->
                            <?php
                        }
                        ?>
                        &nbsp;&nbsp;
                <!--                        <a href='#' onclick=archive_client(<?php echo $recuser["id_client"] ?>)>
                            <span title="Archiver ce Client" alt="suppr"><i class="glyphicon glyphicon-archive"></i></span>
                        </a>-->
                        <?php
                    } else {
                        if (($_SESSION["code_service"] == "RECEP")) {
                            ?>
                            <a href="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/clienthotel/editer_client') ?>&client=<?php echo $recuser["id_client"] ?>">
                                <span title="Modifier ce Client" ><i class="glyphicon glyphicon-edit"></i></span>
                            </a>
                            <?php
                        }
                        ?>
                        &nbsp;&nbsp;
                        <a href="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/clienthotel/dossierclienthotel/lister_dossier_client') ?>&client=<?php echo $recuser["id_client"] ?>">
                            <span title="Ouvrir le dossier de ce Client" ><i class="glyphicon glyphicon-folder-open"></i></span>
                        </a>
                        <?php
                        if (($_SESSION["code_service"] == "RECEP")) {
                            ?>
                            <?php
                            if (!$rowpl2["regle_pl"]) {
                                ?>
                                &nbsp;&nbsp;
                                <a href="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/clienthotel/deplacer_client') ?>&client=<?php echo $recuser["id_client"] ?>">
                                    <span title="D&eacute;placer ce Client" ><i class="glyphicon glyphicon-move"></i></span>
                                </a>
                                &nbsp;&nbsp;
                                <a href="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/clienthotel/ajouter_loyer_client_p') ?>&client=<?php echo $recuser["id_client"] ?>">
                                    <span title="Ajouter les jours de ce Client" ><i class="glyphicon glyphicon-plus"></i></span>
                                </a>
                                <?php
                            }
                        } else if (($_SESSION["code_service"] == "RESTO") || ($_SESSION["code_service"] == "BARESTO")) {
                            ?>
                            <?php
                            if (!$rowpl2["regle_pl"]) {
                                ?>
                                &nbsp;&nbsp;
                                <a href="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/clienthotel/commandeclienthotel/commander_client') ?>&client=<?php echo $recuser["id_client"] ?>">
                                    <span title="Commande de ce client" ><i class="glyphicon glyphicon-file"></i></span>
                                </a>
                                <!--                                &nbsp;&nbsp;
                                                                <a href="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/clienthotel/achatclienthotel/achat_client') ?>&client=<?php echo $recuser["id_client"] ?>">
                                                                    <span title="Achat de ce client" ><i class="glyphicon glyphicon-phone"></i></span>
                                                                </a>-->
                                <!--                                &nbsp;&nbsp;
                                                                <a href="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/clienthotel/dossierclienthotel/ajout_versement_p') ?>&client=<?php echo $recuser["id_client"] ?>">
                                                                    <span title="Ajouter le versement de ce client" ><i class="glyphicon glyphicon-credit-card"></i></span>
                                                                </a>-->
                                &nbsp;&nbsp;
                                <a href="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/clienthotel/dossierclienthotel/affiche_registre') ?>&client=<?php echo $recuser["id_client"] ?>">
                                    <span title="Afficher le registre de ce client" ><i class="glyphicon glyphicon-book"></i></span>
                                </a>
                                <?php
                            }
                        } else if (($_SESSION["code_service"] == "BAR") || ($_SESSION["code_service"] == "BARESTO")) {
                            ?>
                            <?php
                            if (!$rowpl2["regle_pl"]) {
                                ?>
                                &nbsp;&nbsp;
                                <a href="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/clienthotel/commandebarclienthotel/commander_client') ?>&client=<?php echo $recuser["id_client"] ?>">
                                    <span title="Commande de ce client" ><i class="glyphicon glyphicon-file"></i></span>
                                </a>
                                <!--                                &nbsp;&nbsp;
                                                                <a href="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/clienthotel/dossierclienthotel/ajout_versement_p') ?>&client=<?php echo $recuser["id_client"] ?>">
                                                                    <span title="Ajouter le versement de ce client" ><i class="glyphicon glyphicon-credit-card"></i></span>
                                                                </a>-->
                                &nbsp;&nbsp;
                                <a href="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/clienthotel/dossierclienthotel/affiche_registre') ?>&client=<?php echo $recuser["id_client"] ?>">
                                    <span title="Afficher le registre de ce client" ><i class="glyphicon glyphicon-book"></i></span>
                                </a>
                                <?php
                            }
                        }
                    }
//                    echo $dif;
//                    foreach ($dif as $interval => $value) {
//                        echo $value." ";
//                    }
                    if ($dif[0] != 0) {
                        ?>
                        &nbsp;&nbsp;
                        <label class="label-primary">
                            <?php echo $dif[0] . "A " . $dif[1] . "M " . $dif[2] . "J " . $dif[3] . "H " . $dif[4] . "m " . $dif[5] . "S"; ?>
                        </label>
                        <?php
                    } else if ($dif[1] != 0) {
                        ?>
                        &nbsp;&nbsp;
                        <label class="label-success">
                            <?php echo $dif[1] . "M " . $dif[2] . "J " . $dif[3] . "H " . $dif[4] . "m " . $dif[5] . "S"; ?>
                        </label>
                        <?php
                    } else if ($dif[2] != 0) {
                        ?>
                        &nbsp;&nbsp;
                        <label class="label-success">
                            <?php echo $dif[2] . "J " . $dif[3] . "H " . $dif[4] . "m " . $dif[5] . "S"; ?>
                        </label>
                        <?php
                    } else if ($dif[3] != 0) {
                        ?>
                        &nbsp;&nbsp;
                        <label class="label-warning">
                            <?php echo $dif[3] . "H " . $dif[4] . "m " . $dif[5] . "S"; ?>
                        </label>
                        <?php
                    } else if ($dif[4] != 0) {
                        ?>
                        &nbsp;&nbsp;
                        <label class="label-danger">
                            <?php echo $dif[4] . "m " . $dif[5] . "S"; ?>
                        </label>
                        <?php
                    } else if ($dif[5] != 0) {
                        ?>
                        &nbsp;&nbsp;
                        <label class="label-danger">
                            <?php echo $dif[5] . "S"; ?>
                        </label>
                        <?php
                    } else {
                        if ($rowpl2["id_chambre"] != NULL) {
                            $reqch = $con->query("select * from hotel_chambre as c left join hotel_point_hotel as ph on "
                                    . "c.id_point_hotel=ph.id_point_hotel left join hotel_proprietaire as p on "
                                    . "ph.id_proprietaire=p.id_proprietaire where c.id_chambre= '" . $rowpl2["id_chambre"] . "' ")
                                    or die(mysqli_error($con));
                            $rowch = mysqli_fetch_assoc($reqch);
                            ?>
                            &nbsp;&nbsp;
                            <a href="#" onclick=liberer_cha(<?php echo $rowch["id_chambre"] ?>)>
                                <label class="label-danger">
                                    <?php echo "0S Liberer"; ?>
                                </label>
                            </a>
                            <?php
                        } else if ($rowpl2["id_studio"] != NULL) {
                            $reqst = $con->query("select * from hotel_studio as s left join hotel_point_hotel as ph on "
                                    . "s.id_point_hotel=ph.id_point_hotel left join hotel_proprietaire as p on "
                                    . "ph.id_proprietaire=p.id_proprietaire where s.id_studio= '" . $rowpl2["id_studio"] . "' ")
                                    or die(mysqli_error($con));
                            $rowst = mysqli_fetch_assoc($reqst);
                            ?>
                            &nbsp;&nbsp;
                            <a href="#" onclick=liberer_std(<?php echo $rowst["id_studio"] ?>)>
                                <label class="label-danger">
                                    <?php echo "0S Liberer"; ?>
                                </label>
                            </a>
                            <?php
                        } else if ($rowpl2["id_appartement"] != NULL) {
                            $reqap = $con->query("select * from hotel_appartement as a left join hotel_point_hotel as ph on "
                                    . "a.id_point_hotel=ph.id_point_hotel left join hotel_proprietaire as p on "
                                    . "ph.id_proprietaire=p.id_proprietaire where a.id_appartement= '" . $rowpl2["id_appartement"] . "' ")
                                    or die(mysqli_error($con));
                            $rowap = mysqli_fetch_assoc($reqap);
                            ?>
                            &nbsp;&nbsp;
                            <a href="#" onclick=liberer_app(<?php echo $rowap["id_appartement"] ?>)>
                                <label class="label-danger">
                                    <?php echo "0S Liberer"; ?>
                                </label>
                            </a>
                            <?php
                        } else if ($rowpl2["id_salle"] != NULL) {
                            $reqst = $con->query("select * from hotel_salle as s left join hotel_point_hotel as ph on "
                                    . "s.id_point_hotel=ph.id_point_hotel left join hotel_proprietaire as p on "
                                    . "ph.id_proprietaire=p.id_proprietaire where s.id_salle= '" . $rowpl2["id_salle"] . "' ")
                                    or die(mysqli_error($con));
                            $rowst = mysqli_fetch_assoc($reqst);
                            ?>
                            &nbsp;&nbsp;
                            <a href="#" onclick=liberer_sal(<?php echo $rowst["id_salle"] ?>)>
                                <label class="label-danger">
                                    <?php echo "0S Liberer"; ?>
                                </label>
                            </a>
                            <?php
                        }
                    }
                } else {
                    ?>R&eacute;serv&eacute;<?php
                }
                ?>
            </td>
        </tr>

        <?php
    }
}

//fonction pour lister les Clients
function lister_client_r($con) {
    $date = date('Y-m-d');
//    $rsltuser = $con->query("SELECT * FROM hotel_paye_logement as pl left join hotel_client as c "
//            . "on c.id_client=pl.id_client where pl.receptionniste='" . $_SESSION["id_compte_personnel"] . "' and "
//            . "DATE(pl.date_pl)='" . $date . "' order by c.date_client desc ") or die(mysqli_error($con));
    $rsltuser = $con->query("SELECT * FROM hotel_paye_logement as pl left join hotel_client as c "
            . "on c.id_client=pl.id_client where pl.receptionniste='" . $_SESSION["id_compte_personnel"] . "' and "
            . "(pl.regle_pl)=false order by c.date_client desc ") or die(mysqli_error($con));
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        ?>

        <tr >
            <td><?php print nl2br(htmlspecialchars($recuser["nom_client"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["prenom_client"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["civilite_client"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["telephone_client"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["cni_client"])) ?></td>
            <td>
                <?php
                if (($_SESSION["code_service"] == "RECEP")) {
                    ?>
                    <a href="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/clienthotel/editer_client') ?>&client=<?php echo $recuser["id_client"] ?>">
                        <span title="Modifier ce Client" alt="editer"><i class="glyphicon glyphicon-edit"></i></span>
                    </a>
                    <?php
                }
                ?>
                &nbsp;&nbsp;
                <a href="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/clienthotel/dossierclienthotel/lister_dossier_client') ?>&client=<?php echo $recuser["id_client"] ?>">
                    <span title="Ouvrir le dossier de ce Client" alt="dossier"><i class="glyphicon glyphicon-folder-open"></i></span>
                </a>
                <?php
                $rsltpl = $con->query("select * from hotel_paye_logement as pl left join hotel_recu as r on pl.id_paye_logement=r.id_paye_logement "
                        . "where pl.id_client='" . $recuser["id_client"] . "' and pl.date_fin_pl >= NOW() order by pl.date_pl desc ") or die(mysqli_error($con));
                $rowpl = mysqli_fetch_assoc($rsltpl);
                $rsltpl2 = $con->query("select * from hotel_paye_logement as pl left join hotel_recu as r on pl.id_paye_logement=r.id_paye_logement "
                        . "where pl.id_client='" . $recuser["id_client"] . "' order by pl.date_pl desc limit 0,1") or die(mysqli_error($con));
                $rowpl2 = mysqli_fetch_assoc($rsltpl2);
                $today = date('Y-m-d H:i:s');
                $dif = dateDiff($today, $rowpl["date_fin_pl"]);
                if (($_SESSION["code_service"] == "RECEP")) {
                    ?>
                    <?php
                    if (!$rowpl2["regle_pl"]) {
                        ?>&nbsp;&nbsp;
                        <a href="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/clienthotel/deplacer_client') ?>&client=<?php echo $recuser["id_client"] ?>">
                            <span title="D&eacute;placer ce Client" alt="deplacer"><i class="glyphicon glyphicon-move"></i></span>
                        </a>&nbsp;&nbsp;
                        <a href="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/clienthotel/dossierclienthotel/ajouter_loyer_client_p') ?>&client=<?php echo $recuser["id_client"] ?>">
                            <span title="Ajouter les jours de ce Client" alt="loyer"><i class="glyphicon glyphicon-plus"></i></span>
                        </a>
                        &nbsp;&nbsp;
                        <a href="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/clienthotel/dossierclienthotel/ajout_versement_p') ?>&client=<?php echo $recuser["id_client"] ?>">
                            <span title="Ajouter le versement de ce client" alt="verser"><i class="glyphicon glyphicon-credit-card"></i></span>
                        </a>
                        &nbsp;&nbsp;
                        <a href="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/clienthotel/dossierclienthotel/affiche_registre') ?>&client=<?php echo $recuser["id_client"] ?>">
                            <span title="Afficher le registre de ce client" alt="registre"><i class="glyphicon glyphicon-book"></i></span>
                        </a>
                        &nbsp;&nbsp;
                        <a href="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/clienthotel/achatclienthotel/achat_client') ?>&client=<?php echo $recuser["id_client"] ?>">
                            <span title="Achat divers pour ce client" alt="divers"><i class="glyphicon glyphicon-file"></i></span>
                        </a>
                        <?php
                    } else {
                        ?>
                        <!--                            &nbsp;&nbsp;
                                                    <a href="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/clienthotel/dossierclienthotel/loger_client') ?>&client=<?php echo $recuser["id_client"] ?>">
                                                        <span title="Loger ce Client" alt="loyer"><i class="glyphicon glyphicon-pushpin"></i></span>
                                                    </a>-->
                        <?php
                    }
                } else
                if (($_SESSION["code_service"] == "RESTO") || ($_SESSION["code_service"] == "BARESTO")) {
                    ?>
                    <?php
                    if (!$rowpl2["regle_pl"]) {
                        ?>
                        &nbsp;&nbsp;
                        <a href="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/clienthotel/commandeclienthotel/commander_client') ?>&client=<?php echo $recuser["id_client"] ?>">
                            <span title="Commande de ce client" alt="commander"><i class="glyphicon glyphicon-file"></i></span>
                        </a>
                        &nbsp;&nbsp;
                        <a href="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/clienthotel/achatclienthotel/achat_client') ?>&client=<?php echo $recuser["id_client"] ?>">
                            <span title="Achat de ce client" alt="acheter"><i class="glyphicon glyphicon-phone"></i></span>
                        </a>
                        &nbsp;&nbsp;
                        <a href="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/clienthotel/dossierclienthotel/ajout_versement_p') ?>&client=<?php echo $recuser["id_client"] ?>">
                            <span title="Ajouter le versement de ce client" alt="verser"><i class="glyphicon glyphicon-credit-card"></i></span>
                        </a>
                        &nbsp;&nbsp;
                        <a href="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/clienthotel/dossierclienthotel/affiche_registre') ?>&client=<?php echo $recuser["id_client"] ?>">
                            <span title="Afficher le registre de ce client" alt="registre"><i class="glyphicon glyphicon-book"></i></span>
                        </a>
                        <?php
                    }
                }

                if ($dif[0] != 0) {
                    ?>
                    &nbsp;&nbsp;
                    <label class="label-primary">
                        <?php echo $dif[0] . "A " . $dif[1] . "M " . $dif[2] . "J " . $dif[3] . "H " . $dif[4] . "m " . $dif[5] . "S"; ?>
                    </label>
                    <?php
                } else if ($dif[1] != 0) {
                    ?>
                    &nbsp;&nbsp;
                    <label class="label-success">
                        <?php echo $dif[1] . "M " . $dif[2] . "J " . $dif[3] . "H " . $dif[4] . "m " . $dif[5] . "S"; ?>
                    </label>
                    <?php
                } else if ($dif[2] != 0) {
                    ?>
                    &nbsp;&nbsp;
                    <label class="label-success">
                        <?php echo $dif[2] . "J " . $dif[3] . "H " . $dif[4] . "m " . $dif[5] . "S"; ?>
                    </label>
                    <?php
                } else if ($dif[3] != 0) {
                    ?>
                    &nbsp;&nbsp;
                    <label class="label-warning">
                        <?php echo $dif[3] . "H " . $dif[4] . "m " . $dif[5] . "S"; ?>
                    </label>
                    <?php
                } else if ($dif[4] != 0) {
                    ?>
                    &nbsp;&nbsp;
                    <label class="label-danger">
                        <?php echo $dif[4] . "m " . $dif[5] . "S"; ?>
                    </label>
                    <?php
                } else if ($dif[5] != 0) {
                    ?>
                    &nbsp;&nbsp;
                    <label class="label-danger">
                        <?php echo $dif[5] . "S"; ?>
                    </label>
                    <?php
                } else {
                    if ($rowpl2["id_chambre"] != NULL) {
                        $reqch = $con->query("select * from hotel_chambre as c left join hotel_point_hotel as ph on "
                                . "c.id_point_hotel=ph.id_point_hotel left join hotel_proprietaire as p on "
                                . "ph.id_proprietaire=p.id_proprietaire where c.id_chambre= '" . $rowpl2["id_chambre"] . "' ")
                                or die(mysqli_error($con));
                        $rowch = mysqli_fetch_assoc($reqch);
                        ?>
                        &nbsp;&nbsp;
                        <a href="#" onclick=liberer_cha(<?php echo $rowch["id_chambre"] ?>)>
                            <label class="label-danger">
                                <?php echo "0S Liberer"; ?>
                            </label>
                        </a>
                        <?php
                    } else if ($rowpl2["id_studio"] != NULL) {
                        $reqst = $con->query("select * from hotel_studio as s left join hotel_point_hotel as ph on "
                                . "s.id_point_hotel=ph.id_point_hotel left join hotel_proprietaire as p on "
                                . "ph.id_proprietaire=p.id_proprietaire where s.id_studio= '" . $rowpl2["id_studio"] . "' ")
                                or die(mysqli_error($con));
                        $rowst = mysqli_fetch_assoc($reqst);
                        ?>
                        &nbsp;&nbsp;
                        <a href="#" onclick=liberer_std(<?php echo $rowst["id_studio"] ?>)>
                            <label class="label-danger">
                                <?php echo "0S Liberer"; ?>
                            </label>
                        </a>
                        <?php
                    } else if ($rowpl2["id_appartement"] != NULL) {
                        $reqap = $con->query("select * from hotel_appartement as a left join hotel_point_hotel as ph on "
                                . "a.id_point_hotel=ph.id_point_hotel left join hotel_proprietaire as p on "
                                . "ph.id_proprietaire=p.id_proprietaire where a.id_appartement= '" . $rowpl2["id_appartement"] . "' ")
                                or die(mysqli_error($con));
                        $rowap = mysqli_fetch_assoc($reqap);
                        ?>
                        &nbsp;&nbsp;
                        <a href="#" onclick=liberer_app(<?php echo $rowap["id_appartement"] ?>)>
                            <label class="label-danger">
                                <?php echo "0S Liberer"; ?>
                            </label>
                        </a>
                        <?php
                    } else if ($rowpl2["id_salle"] != NULL) {
                        $reqst = $con->query("select * from hotel_salle as s left join hotel_point_hotel as ph on "
                                . "s.id_point_hotel=ph.id_point_hotel left join hotel_proprietaire as p on "
                                . "ph.id_proprietaire=p.id_proprietaire where s.id_salle= '" . $rowpl2["id_salle"] . "' ")
                                or die(mysqli_error($con));
                        $rowst = mysqli_fetch_assoc($reqst);
                        ?>
                        &nbsp;&nbsp;
                        <a href="#" onclick=liberer_sal(<?php echo $rowst["id_salle"] ?>)>
                            <label class="label-danger">
                                <?php echo "0S Liberer"; ?>
                            </label>
                        </a>
                        <?php
                    }
                }
                ?>
            </td>
        </tr>

        <?php
    }
}

//fonction pour modifier une Client
function editer_client($id, $nomcl, $prenomcl, $civilitecl, $telcl, $cnicl, $datenaiscl, $villecl, $profcl, $con) {
    $req = $con->query("select * from hotel_client where cni_client= '" . $cnicl . "' ") or die(mysqli_error($con));
    $nb = mysqli_num_rows($req);
    if (($nb == 0)) {
        $rslt = $con->query("update hotel_client set nom_client='" . $nomcl . "', prenom_client='" . $prenomcl . "', "
                . "civilite_client='" . $civilitecl . "', telephone_client='" . $telcl . "', cni_client='" . $cnicl . "', "
                . "ville_client='" . $villecl . "', date_naissance='" . $datenaiscl . "', profession_client='" . $profcl . "' "
                . "where id_client='" . $id . "'") or die(mysqli_error($con));
        echo "<script language='javascript'>$('div.alertmodifbon').show('slow').delay(8000).hide('slow');</script>";
    } else {
        $recuser = mysqli_fetch_array($req);
        if ($id == $recuser["id_client"]) {
            $rslt = $con->query("update hotel_client set nom_client='" . $nomcl . "', prenom_client='" . $prenomcl . "', "
                    . "civilite_client='" . $civilitecl . "', telephone_client='" . $telcl . "', cni_client='" . $cnicl . "', "
                    . "ville_client='" . $villecl . "', date_naissance='" . $datenaiscl . "', profession_client='" . $profcl . "' "
                    . "where id_client='" . $id . "'") or die(mysqli_error($con));
            echo "<script language='javascript'>$('div.alertmodifbon').show('slow').delay(8000).hide('slow');</script>";
        } else {
            echo "<script language='javascript'>$('div.alertaddmauv').show('slow').delay(8000).hide('slow');</script>";
        }
    }
}

//fonction pour lister les Clients
function lister_dossier_client($cl, $con) {
    $rsltuser = $con->query("select * from hotel_paye_logement as pl left join hotel_recu as r on pl.id_paye_logement=r.id_paye_logement "
            . "where pl.id_client='" . $cl . "' order by pl.date_pl desc ") or die(mysqli_error($con));
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        $reqr = $con->query("select * from hotel_recu where id_paye_logement= '" . $recuser["id_paye_logement"] . "' order by date_recu desc LIMIT 0,1") or die(mysqli_error($con));
        $rowr = mysqli_fetch_assoc($reqr);
        ?>

        <tr >
            <td><?php print nl2br(htmlspecialchars($recuser["code_pl"])) ?></td>
            <?php
            if ($recuser["id_chambre"] != NULL) {
                $reqch = $con->query("select * from hotel_chambre as c left join hotel_point_hotel as ph on c.id_point_hotel=ph.id_point_hotel "
                        . "left join hotel_proprietaire as p on ph.id_proprietaire=p.id_proprietaire where c.id_chambre= '" . $recuser["id_chambre"] . "' ") or die(mysqli_error($con));
                $rowch = mysqli_fetch_assoc($reqch);
                ?>
                <td><?php print nl2br(htmlspecialchars($rowch["hotel"])) ?></td>
                <td><?php print nl2br(htmlspecialchars($rowch["code_c"])) ?></td>
                <?php
            } else if ($recuser["id_studio"] != NULL) {
                $reqst = $con->query("select * from hotel_studio as s left join hotel_point_hotel as ph on s.id_point_hotel=ph.id_point_hotel "
                        . "left join hotel_proprietaire as p on ph.id_proprietaire=p.id_proprietaire where s.id_studio= '" . $recuser["id_studio"] . "' ") or die(mysqli_error($con));
                $rowst = mysqli_fetch_assoc($reqst);
                ?>
                <td><?php print nl2br(htmlspecialchars($rowst["hotel"])) ?></td>
                <td><?php print nl2br(htmlspecialchars($rowst["code_s"])) ?></td>
                <?php
            } else if ($recuser["id_appartement"] != NULL) {
                $reqap = $con->query("select * from hotel_appartement as a left join hotel_point_hotel as ph on a.id_point_hotel=ph.id_point_hotel "
                        . "left join hotel_proprietaire as p on ph.id_proprietaire=p.id_proprietaire where a.id_appartement= '" . $recuser["id_appartement"] . "' ") or die(mysqli_error($con));
                $rowap = mysqli_fetch_assoc($reqap);
                ?>
                <td><?php print nl2br(htmlspecialchars($rowap["hotel"])) ?></td>
                <td><?php print nl2br(htmlspecialchars($rowap["code_a"])) ?> <?php print $rowap["nbchambre_a"] ?>Ch  <?php echo $rowap["nbsalon_a"] ?>S  <?php echo $rowap["nbdouche_a"] ?>D  <?php echo $rowap["nbcuisine_a"] ?>Cu </td>
                <?php
            } else if ($recuser["id_salle"] != NULL) {
                $reqst = $con->query("select * from hotel_salle as s left join hotel_point_hotel as ph on s.id_point_hotel=ph.id_point_hotel "
                        . "left join hotel_proprietaire as p on ph.id_proprietaire=p.id_proprietaire where s.id_salle= '" . $recuser["id_salle"] . "' ") or die(mysqli_error($con));
                $rowst = mysqli_fetch_assoc($reqst);
                ?>
                <td><?php print nl2br(htmlspecialchars($rowst["hotel"])) ?></td>
                <td><?php print nl2br(htmlspecialchars($rowst["code_salle"])) ?></td>
                <?php
            }
            ?>
            <td><?php print nl2br(htmlspecialchars($recuser["prix_u"])) ?></td>
            <td><?php print number_format($recuser["montant"], 0, ',', ' ') ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["nbpers"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["date_debut_pl"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["date_fin_pl"])) ?></td>
            <td>

                <?php
                if (isset($_SESSION["loginproprietaire"])) {
                    if (!$recuser["regle_pl"]) {
                        if ($recuser["id_chambre"] != NULL) {
                            $reqch = $con->query("select * from hotel_chambre as c left join hotel_point_hotel as ph on "
                                    . "c.id_point_hotel=ph.id_point_hotel left join hotel_proprietaire as p on "
                                    . "ph.id_proprietaire=p.id_proprietaire where c.id_chambre= '" . $recuser["id_chambre"] . "' ")
                                    or die(mysqli_error($con));
                            $rowch = mysqli_fetch_assoc($reqch);
                            ?>
                            &nbsp;&nbsp;
                            <a href="#" onclick=liberer_cha(<?php echo $rowch["id_chambre"] ?>)>
                                <span title="D&eacute;loger ce Client" alt="deloger"><i class="glyphicon glyphicon-remove"></i></span>
                            </a>
                            <?php
                        } else if ($recuser["id_studio"] != NULL) {
                            $reqst = $con->query("select * from hotel_studio as s left join hotel_point_hotel as ph on "
                                    . "s.id_point_hotel=ph.id_point_hotel left join hotel_proprietaire as p on "
                                    . "ph.id_proprietaire=p.id_proprietaire where s.id_studio= '" . $recuser["id_studio"] . "' ")
                                    or die(mysqli_error($con));
                            $rowst = mysqli_fetch_assoc($reqst);
                            ?>
                            &nbsp;&nbsp;
                            <a href="#" onclick=liberer_std(<?php echo $rowst["id_studio"] ?>)>
                                <span title="D&eacute;loger ce Client" alt="deloger"><i class="glyphicon glyphicon-remove"></i></span>
                            </a>
                            <?php
                        } else if ($recuser["id_appartement"] != NULL) {
                            $reqap = $con->query("select * from hotel_appartement as a left join hotel_point_hotel as ph on "
                                    . "a.id_point_hotel=ph.id_point_hotel left join hotel_proprietaire as p on "
                                    . "ph.id_proprietaire=p.id_proprietaire where a.id_appartement= '" . $recuser["id_appartement"] . "' ")
                                    or die(mysqli_error($con));
                            $rowap = mysqli_fetch_assoc($reqap);
                            ?>
                            &nbsp;&nbsp;
                            <a href="#" onclick=liberer_app(<?php echo $rowap["id_appartement"] ?>)>
                                <span title="D&eacute;loger ce Client" alt="deloger"><i class="glyphicon glyphicon-remove"></i></span>
                            </a>
                            <?php
                        } else if ($recuser["id_salle"] != NULL) {
                            $reqst = $con->query("select * from hotel_salle as s left join hotel_point_hotel as ph on "
                                    . "s.id_point_hotel=ph.id_point_hotel left join hotel_proprietaire as p on "
                                    . "ph.id_proprietaire=p.id_proprietaire where s.id_salle= '" . $recuser["id_salle"] . "' ")
                                    or die(mysqli_error($con));
                            $rowst = mysqli_fetch_assoc($reqst);
                            ?>
                            &nbsp;&nbsp;
                            <a href="#" onclick=liberer_sal(<?php echo $rowst["id_salle"] ?>)>
                                <span title="D&eacute;loger ce Client" alt="deloger"><i class="glyphicon glyphicon-remove"></i></span>
                            </a>
                            <?php
                        }
                    }
                    ?>&nbsp;&nbsp;
                    <a href="hotelpages/clienthotel/facture_client_inc_pdf.php?recu=<?php echo $rowr["id_recu"] ?>" target="_blank">
                        <span title="Imprimer la facture du client" alt="imprimer"><i class="glyphicon glyphicon-print"></i></span>
                    </a>
                    <?php
                } else {
                    ?>
                    <?php
                    if (($_SESSION["code_service"] == "RECEP")) {

                        if (!$recuser["regle_pl"]) {
                            if ($recuser["id_chambre"] != NULL) {
                                $reqch = $con->query("select * from hotel_chambre as c left join hotel_point_hotel as ph on "
                                        . "c.id_point_hotel=ph.id_point_hotel left join hotel_proprietaire as p on "
                                        . "ph.id_proprietaire=p.id_proprietaire where c.id_chambre= '" . $recuser["id_chambre"] . "' ")
                                        or die(mysqli_error($con));
                                $rowch = mysqli_fetch_assoc($reqch);
                                ?>
                                &nbsp;&nbsp;
                                <a href="#" onclick=liberer_cha(<?php echo $rowch["id_chambre"] ?>)>
                                    <span title="D&eacute;loger ce Client" alt="deloger"><i class="glyphicon glyphicon-remove"></i></span>
                                </a>
                                <?php
                            } else if ($recuser["id_studio"] != NULL) {
                                $reqst = $con->query("select * from hotel_studio as s left join hotel_point_hotel as ph on "
                                        . "s.id_point_hotel=ph.id_point_hotel left join hotel_proprietaire as p on "
                                        . "ph.id_proprietaire=p.id_proprietaire where s.id_studio= '" . $recuser["id_studio"] . "' ")
                                        or die(mysqli_error($con));
                                $rowst = mysqli_fetch_assoc($reqst);
                                ?>
                                &nbsp;&nbsp;
                                <a href="#" onclick=liberer_std(<?php echo $rowst["id_studio"] ?>)>
                                    <span title="D&eacute;loger ce Client" alt="deloger"><i class="glyphicon glyphicon-remove"></i></span>
                                </a>
                                <?php
                            } else if ($recuser["id_appartement"] != NULL) {
                                $reqap = $con->query("select * from hotel_appartement as a left join hotel_point_hotel as ph on "
                                        . "a.id_point_hotel=ph.id_point_hotel left join hotel_proprietaire as p on "
                                        . "ph.id_proprietaire=p.id_proprietaire where a.id_appartement= '" . $recuser["id_appartement"] . "' ")
                                        or die(mysqli_error($con));
                                $rowap = mysqli_fetch_assoc($reqap);
                                ?>
                                &nbsp;&nbsp;
                                <a href="#" onclick=liberer_app(<?php echo $rowap["id_appartement"] ?>)>
                                    <span title="D&eacute;loger ce Client" alt="deloger"><i class="glyphicon glyphicon-remove"></i></span>
                                </a>
                                <?php
                            } else if ($recuser["id_salle"] != NULL) {
                                $reqst = $con->query("select * from hotel_salle as s left join hotel_point_hotel as ph on "
                                        . "s.id_point_hotel=ph.id_point_hotel left join hotel_proprietaire as p on "
                                        . "ph.id_proprietaire=p.id_proprietaire where s.id_salle= '" . $recuser["id_salle"] . "' ")
                                        or die(mysqli_error($con));
                                $rowst = mysqli_fetch_assoc($reqst);
                                ?>
                                &nbsp;&nbsp;
                                <a href="#" onclick=liberer_sal(<?php echo $rowst["id_salle"] ?>)>
                                    <span title="D&eacute;loger ce Client" alt="deloger"><i class="glyphicon glyphicon-remove"></i></span>
                                </a>
                                <?php
                            }
                        }
                        ?>&nbsp;&nbsp;
                        <a href="hotelpages/clienthotel/facture_client_inc_pdf.php?recu=<?php echo $rowr["id_recu"] ?>" target="_blank">
                            <span title="Imprimer la facture du client" alt="imprimer"><i class="glyphicon glyphicon-print"></i></span>
                        </a><?php
                    }
                }
                ?>
            </td>
        </tr>

        <?php
    }
}

function affiche_registre_client($cl, $con) {
    $rsltuser = $con->query("select * from hotel_registre_client as rc left join hotel_paye_logement as pl on "
            . "rc.id_paye_logement=pl.id_paye_logement left join hotel_client as cl on pl.id_client=cl.id_client "
            . "where pl.id_client='" . $cl . "' order by rc.date_registre desc ") or die(mysqli_error($con));
    $tpaye = 0;
    $date = date('d-m-Y');
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        ?>
        <tr >
            <td><?php print nl2br(htmlspecialchars($recuser["date_registre"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["nom_client"])) ?> 
                <?php print nl2br(htmlspecialchars($recuser["prenom_client"])) ?>
                <?php print nl2br(htmlspecialchars($recuser["cni_client"])) ?>
            </td>
            <td><?php print nl2br(htmlspecialchars($recuser["operation_reg"])) ?></td>
            <td>
                <?php
                if ($recuser["operation_reg"] == "Versement") {
                    print "-" . number_format($recuser["montant_reg"], 0, ',', ' ');
                    $tpaye = $tpaye - $recuser["montant_reg"];
                } else {
                    print number_format($recuser["montant_reg"], 0, ',', ' ');
                    $tpaye = $tpaye + $recuser["montant_reg"];
                }
                ?>
            </td>
        </tr>
        <?php
    }
    ?>
    <tr >
        <td><?php echo $date; ?></td>
        <td></td>
        <td></td>
        <td>
            <?php
            echo number_format($tpaye, 0, ',', ' ');
            ?>
        </td>
    </tr>
    <?php
}

//fonction pour deplacer une Client
function deplacer_client($id, $cha, $std, $app, $sal, $con) {
    $reqpl = $con->query("select * from hotel_paye_logement as pl left join hotel_recu as r on pl.id_paye_logement=r.id_paye_logement "
            . "where pl.id_client='" . $id . "' order by pl.date_pl desc LIMIT 0,1") or die(mysqli_error($con));
    $rowlo = mysqli_fetch_assoc($reqpl);
    $eta = 0;
    $reserve = 0;

    $datedpl21 = date("Y-m-d");
    $dif21 = dates_range(date('Y-m-d', strtotime($rowlo["date_debut_pl"])), date('Y-m-d', strtotime($datedpl21)));
    $dif2 = $dif21 - 1;
    $prixpl2 = 0;

    $obh = "";
    if ($rowlo["id_chambre"] != NULL) {
        $reqch2 = $con->query("select * from hotel_chambre where id_chambre= '" . $rowlo["id_chambre"] . "' ") or die(mysqli_error($con));
        $rowch2 = mysqli_fetch_assoc($reqch2);
        $obh = $rowch2["code_c"];
        if ($dif2 >= 0) {
            $prixpl2 = $dif2 * $rowch2["prix_c"];
        }
        $rsltch = $con->query("update hotel_chambre set etat_c='" . $eta . "', reserve_c='" . $reserve . "' where id_chambre= '" . $rowlo["id_chambre"] . "' ") or die(mysqli_error($con));
    } else if ($rowlo["id_studio"] != NULL) {
        $reqch2 = $con->query("select * from hotel_studio where id_studio= '" . $rowlo["id_studio"] . "' ") or die(mysqli_error($con));
        $rowch2 = mysqli_fetch_assoc($reqch2);
        $obh = $rowch2["code_s"];
        if ($dif2 >= 0) {
            $prixpl2 = $dif2 * $rowch2["prix_s"];
        }

        $reqst = $con->query("update hotel_studio set etat_s='" . $eta . "', reserve_s='" . $reserve . "' where id_studio= '" . $rowlo["id_studio"] . "' ") or die(mysqli_error($con));
    } else if ($rowlo["id_appartement"] != NULL) {
        $reqch2 = $con->query("select * from hotel_appartement where id_appartement= '" . $rowlo["id_appartement"] . "' ") or die(mysqli_error($con));
        $rowch2 = mysqli_fetch_assoc($reqch2);
        $obh = $rowch2["code_a"];
        if ($dif2 >= 0) {
            $prixpl2 = $dif2 * $rowch2["prix_a"];
        }
        $reqap = $con->query("update hotel_appartement set etat_a='" . $eta . "', reserve_a='" . $reserve . "' where id_appartement= '" . $rowlo["id_appartement"] . "' ") or die(mysqli_error($con));
    } else if ($rowlo["id_salle"] != NULL) {
        $reqch2 = $con->query("select * from hotel_salle where id_salle= '" . $rowlo["id_salle"] . "' ") or die(mysqli_error($con));
        $rowch2 = mysqli_fetch_assoc($reqch2);
        $obh = $rowch2["code_salle"];
        if ($dif2 >= 0) {
            $prixpl2 = $dif2 * $rowch2["prix_salle"];
        }
        $reqst = $con->query("update hotel_salle set etat_salle='" . $eta . "', reserve_salle='" . $reserve . "' "
                . "where id_salle= '" . $rowlo["id_salle"] . "' ") or die(mysqli_error($con));
    }

    $rowplo = NULL;
    $op = "Déplacement";

    $an = date('Y');
    $numid = date('Y', time()) . sprintf("%08d", 1);
    $req1 = $con->query("select * from hotel_paye_logement where YEAR(date_pl)='" . $an . "'") or die(mysqli_error($con));
    $i = 0;
    while ($reqte = mysqli_fetch_assoc($req1)) {
        $i = $i + 1;
    }
    $numid = date('Y', time()) . sprintf("%08d", $i + 1);
    $occupe = 1;
    $datedpl2 = date("Y-m-d");
    $dif1 = dates_range(date('Y-m-d', strtotime($datedpl2)), date('Y-m-d', strtotime($rowlo["date_fin_pl"])));
    $dif = $dif1 - 1;
    $prixpl = 0;

    if ($cha != NULL) {
        $reqch = $con->query("select * from hotel_chambre where id_chambre= '" . $cha . "' ") or die(mysqli_error($con));
        $rowch = mysqli_fetch_assoc($reqch);
        $obh = $obh . "-->" . $rowch["code_c"];
        if ($dif >= 0) {
            $prixpl = $dif * $rowch["prix_c"];
        }
        if (isset($_SESSION["login_personnel"]) && isset($_SESSION["id_compte_personnel"])) {
            $rsltpl = $con->query("insert into hotel_paye_logement(id_chambre, id_client, code_pl, prix_u, prix_pl, receptionniste, nbpers, date_debut_pl, "
                    . "date_fin_pl, date_pl) values('" . $cha . "', '" . $id . "', '" . $numid . "', '" . $rowch["prix_c"] . "', '" . $prixpl . "', "
                    . "'" . $_SESSION["id_compte_personnel"] . "', '" . $rowlo["nbpers"] . "', NOW(), "
                    . "'" . $rowlo["date_fin_pl"] . "', NOW())") or die(mysqli_error($con));
        } else {

            $rsltpl = $con->query("insert into hotel_paye_logement(id_chambre, id_client, code_pl, prix_u, prix_pl, nbpers, date_debut_pl, "
                    . "date_fin_pl, date_pl) values('" . $cha . "', '" . $id . "', '" . $numid . "', '" . $rowch["prix_c"] . "', '" . $prixpl . "', "
                    . "'" . $rowlo["nbpers"] . "', NOW(), '" . $rowlo["date_fin_pl"] . "', NOW())") or die(mysqli_error($con));
        }
        $reqpl = $con->query("select * from hotel_paye_logement where code_pl= '" . $numid . "' ") or die(mysqli_error($con));
        $rowpl = mysqli_fetch_assoc($reqpl);

        $rsltch = $con->query("update hotel_chambre set etat_c='" . $occupe . "' where id_chambre= '" . $cha . "'") or die(mysqli_error($con));

        $rsltre = $con->query("insert into hotel_recu(id_paye_logement, montant, date_debut_re, date_fin_re, date_recu) "
                . "values('" . $rowpl["id_paye_logement"] . "', '" . $prixpl . "', NOW(), "
                . "'" . $rowlo["date_fin_pl"] . "', NOW())") or die(mysqli_error($con));
        if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
            $rsltreg = $con->query("insert into hotel_registre_client(id_paye_logement, montant_reg, operation_reg, date_registre) "
                    . "values('" . $rowpl["id_paye_logement"] . "', '" . $prixpl . "', '" . $op . "', NOW())") or die(mysqli_error($con));
        } else if (isset($_SESSION["login_personnel"]) && (isset($_SESSION["mot_de_passe_personnel"])) && ($_SESSION["etat_compte_personnel"])) {
            $rsltreg = $con->query("insert into hotel_registre_client(id_paye_logement, id_compte_personnel, montant_reg, "
                    . "operation_reg, date_registre) values('" . $rowpl["id_paye_logement"] . "', "
                    . "'" . $_SESSION["id_compte_personnel"] . "', '" . $prixpl . "', '" . $op . "', NOW())") or die(mysqli_error($con));
        }
        $reqplo = $con->query("select * from hotel_paye_logement where code_pl= '" . $numid . "' ") or die(mysqli_error($con));
        $rowplo = mysqli_fetch_assoc($reqplo);
    } else if ($std != NULL) {
        $reqst = $con->query("select * from hotel_studio where id_studio= '" . $std . "' ") or die(mysqli_error($con));
        $rowst = mysqli_fetch_assoc($reqst);
        $obh = $obh . "-->" . $rowst["code_s"];
        if ($dif >= 0) {
            $prixpl = $dif * $rowst["prix_s"];
        }
        if (isset($_SESSION["login_personnel"]) && isset($_SESSION["id_compte_personnel"])) {
            $rsltpl = $con->query("insert into hotel_paye_logement(id_studio, id_client, code_pl, prix_u, prix_pl, receptionniste, nbpers, date_debut_pl, "
                    . "date_fin_pl, date_pl) values('" . $std . "', '" . $id . "', '" . $numid . "', '" . $rowst["prix_s"] . "', '" . $prixpl . "', "
                    . "'" . $_SESSION["id_compte_personnel"] . "', '" . $rowlo["nbpers"] . "', NOW(), "
                    . "'" . $rowlo["date_fin_pl"] . "', NOW())") or die(mysqli_error($con));
        } else {
            $rsltpl = $con->query("insert into hotel_paye_logement(id_studio, id_client, code_pl, prix_u, prix_pl, nbpers, date_debut_pl, "
                    . "date_fin_pl, date_pl) values('" . $std . "', '" . $id . "', '" . $numid . "', '" . $rowst["prix_s"] . "', '" . $prixpl . "', "
                    . "'" . $rowlo["nbpers"] . "', NOW(), '" . $rowlo["date_fin_pl"] . "', NOW())") or die(mysqli_error($con));
        }
        $reqpl = $con->query("select * from hotel_paye_logement where code_pl= '" . $numid . "' ") or die(mysqli_error($con));
        $rowpl = mysqli_fetch_assoc($reqpl);

        $rsltch = $con->query("update hotel_studio set etat_s='" . $occupe . "' where id_studio= '" . $std . "'") or die(mysqli_error($con));

        $rsltre = $con->query("insert into hotel_recu(id_paye_logement, montant, date_debut_re, date_fin_re, date_recu) "
                . "values('" . $rowpl["id_paye_logement"] . "', '" . $prixpl . "', NOW(), "
                . "'" . $rowlo["date_fin_pl"] . "', NOW())") or die(mysqli_error($con));
        if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
            $rsltreg = $con->query("insert into hotel_registre_client(id_paye_logement, montant_reg, operation_reg, date_registre) "
                    . "values('" . $rowpl["id_paye_logement"] . "', '" . $prixpl . "', '" . $op . "', NOW())") or die(mysqli_error($con));
        } else if (isset($_SESSION["login_personnel"]) && (isset($_SESSION["mot_de_passe_personnel"])) && ($_SESSION["etat_compte_personnel"])) {
            $rsltreg = $con->query("insert into hotel_registre_client(id_paye_logement, id_compte_personnel, montant_reg, "
                    . "operation_reg, date_registre) values('" . $rowpl["id_paye_logement"] . "', "
                    . "'" . $_SESSION["id_compte_personnel"] . "', '" . $prixpl . "', '" . $op . "', NOW())") or die(mysqli_error($con));
        }
        $reqplo = $con->query("select * from hotel_paye_logement where code_pl= '" . $numid . "' ") or die(mysqli_error($con));
        $rowplo = mysqli_fetch_assoc($reqplo);
    } else if ($app != NULL) {
        $reqap = $con->query("select * from hotel_appartement where id_appartement= '" . $app . "' ") or die(mysqli_error($con));
        $rowap = mysqli_fetch_assoc($reqap);
        $obh = $obh . "-->" . $rowap["code_a"];
        if ($dif >= 0) {
            $prixpl = $dif * $rowap["prix_a"];
        }
        if (isset($_SESSION["login_personnel"]) && isset($_SESSION["id_compte_personnel"])) {
            $rsltpl = $con->query("insert into hotel_paye_logement(id_appartement, id_client, code_pl, prix_u, prix_pl, receptionniste, nbpers, date_debut_pl, "
                    . "date_fin_pl, date_pl) values('" . $app . "', '" . $id . "', '" . $numid . "', '" . $rowap["prix_a"] . "', '" . $prixpl . "', "
                    . "'" . $_SESSION["id_compte_personnel"] . "', '" . $rowlo["nbpers"] . "', NOW(), "
                    . "'" . $rowlo["date_fin_pl"] . "', NOW())") or die(mysqli_error($con));
        } else {
            $rsltpl = $con->query("insert into hotel_paye_logement(id_appartement, id_client, code_pl, prix_u, prix_pl, nbpers, date_debut_pl, "
                    . "date_fin_pl, date_pl) values('" . $app . "', '" . $id . "', '" . $numid . "', '" . $rowap["prix_a"] . "', '" . $prixpl . "', "
                    . "'" . $rowlo["nbpers"] . "', NOW(), '" . $rowlo["date_fin_pl"] . "', NOW())") or die(mysqli_error($con));
        }
        $reqpl = $con->query("select * from hotel_paye_logement where code_pl= '" . $numid . "' ") or die(mysqli_error($con));
        $rowpl = mysqli_fetch_assoc($reqpl);

        $rsltch = $con->query("update hotel_appartement set etat_a='" . $occupe . "' where id_appartement= '" . $app . "'") or die(mysqli_error($con));

        $rsltre = $con->query("insert into hotel_recu(id_paye_logement, montant, date_debut_re, date_fin_re, date_recu) "
                . "values('" . $rowpl["id_paye_logement"] . "', '" . $prixpl . "', NOW(), "
                . "'" . $rowlo["date_fin_pl"] . "', NOW())") or die(mysqli_error($con));
        if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
            $rsltreg = $con->query("insert into hotel_registre_client(id_paye_logement, montant_reg, operation_reg, date_registre) "
                    . "values('" . $rowpl["id_paye_logement"] . "', '" . $prixpl . "', '" . $op . "', NOW())") or die(mysqli_error($con));
        } else if (isset($_SESSION["login_personnel"]) && (isset($_SESSION["mot_de_passe_personnel"])) && ($_SESSION["etat_compte_personnel"])) {
            $rsltreg = $con->query("insert into hotel_registre_client(id_paye_logement, id_compte_personnel, montant_reg, "
                    . "operation_reg, date_registre) values('" . $rowpl["id_paye_logement"] . "', "
                    . "'" . $_SESSION["id_compte_personnel"] . "', '" . $prixpl . "', '" . $op . "', NOW())") or die(mysqli_error($con));
        }
        $reqplo = $con->query("select * from hotel_paye_logement where code_pl= '" . $numid . "' ") or die(mysqli_error($con));
        $rowplo = mysqli_fetch_assoc($reqplo);
    } else if ($sal != NULL) {
        $reqst = $con->query("select * from hotel_salle where id_salle= '" . $sal . "' ") or die(mysqli_error($con));
        $rowst = mysqli_fetch_assoc($reqst);
        $obh = $obh . "-->" . $rowst["code_salle"];
        if ($dif >= 0) {
            $prixpl = $dif * $rowst["prix_salle"];
        }
        if (isset($_SESSION["login_personnel"]) && isset($_SESSION["id_compte_personnel"])) {
            $rsltpl = $con->query("insert into hotel_paye_logement(id_salle, id_client, code_pl, prix_u, prix_pl, receptionniste, nbpers, date_debut_pl, "
                    . "date_fin_pl, date_pl) values('" . $sal . "', '" . $id . "', '" . $numid . "', '" . $rowst["prix_salle"] . "', '" . $prixpl . "', "
                    . "'" . $_SESSION["id_compte_personnel"] . "', '" . $rowlo["nbpers"] . "', NOW(), "
                    . "'" . $rowlo["date_fin_pl"] . "', NOW())") or die(mysqli_error($con));
        } else {
            $rsltpl = $con->query("insert into hotel_paye_logement(id_salle, id_client, code_pl, prix_u, prix_pl, nbpers, date_debut_pl, "
                    . "date_fin_pl, date_pl) values('" . $sal . "', '" . $id . "', '" . $numid . "', '" . $rowst["prix_salle"] . "', '" . $prixpl . "', "
                    . "'" . $rowlo["nbpers"] . "', NOW(), '" . $rowlo["date_fin_pl"] . "', NOW())") or die(mysqli_error($con));
        }
        $reqpl = $con->query("select * from hotel_paye_logement where code_pl= '" . $numid . "' ") or die(mysqli_error($con));
        $rowpl = mysqli_fetch_assoc($reqpl);

        $rsltch = $con->query("update hotel_salle set etat_salle='" . $occupe . "' where id_salle= '" . $sal . "'") or die(mysqli_error($con));

        $rsltre = $con->query("insert into hotel_recu(id_paye_logement, montant, date_debut_re, date_fin_re, date_recu) "
                . "values('" . $rowpl["id_paye_logement"] . "', '" . $prixpl . "', NOW(), "
                . "'" . $rowlo["date_fin_pl"] . "', NOW())") or die(mysqli_error($con));
        if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
            $rsltreg = $con->query("insert into hotel_registre_client(id_paye_logement, montant_reg, operation_reg, date_registre) "
                    . "values('" . $rowpl["id_paye_logement"] . "', '" . $prixpl . "', '" . $op . "', NOW())") or die(mysqli_error($con));
        } else if (isset($_SESSION["login_personnel"]) && (isset($_SESSION["mot_de_passe_personnel"])) && ($_SESSION["etat_compte_personnel"])) {
            $rsltreg = $con->query("insert into hotel_registre_client(id_paye_logement, id_compte_personnel, montant_reg, "
                    . "operation_reg, date_registre) values('" . $rowpl["id_paye_logement"] . "', "
                    . "'" . $_SESSION["id_compte_personnel"] . "', '" . $prixpl . "', '" . $op . "', NOW())") or die(mysqli_error($con));
        }
        $reqplo = $con->query("select * from hotel_paye_logement where code_pl= '" . $numid . "' ") or die(mysqli_error($con));
        $rowplo = mysqli_fetch_assoc($reqplo);
    }
    $regle = 1;
    $rsltcpl = $con->query("update hotel_paye_logement set regle_pl='" . $regle . "', prix_pl='" . $prixpl2 . "', "
            . "date_fin_pl=NOW() where id_paye_logement= '" . $rowlo["id_paye_logement"] . "'") or die(mysqli_error($con));
    $log = "Logement";
    $rese = "Réserver";
    $depl = "Déplacement";
    $rsltcre = $con->query("update hotel_registre_client set montant_reg='" . $prixpl2 . "' where "
            . "id_paye_logement='" . $rowlo["id_paye_logement"] . "' and (operation_reg= '" . $log . "' "
            . "or operation_reg='" . $rese . "' or operation_reg='" . $depl . "')") or die(mysqli_error($con));

    $reqr = $con->query("select * from hotel_recu where id_paye_logement= '" . $rowplo["id_paye_logement"] . "' order by date_recu desc LIMIT 0,1") or die(mysqli_error($con));
    $rowr = mysqli_fetch_assoc($reqr);
    $oph = "Déplacement";
    if (isset($_SESSION["loginproprietaire"]) && isset($_SESSION["id_proprietaire"])) {
        $rslthisto = $con->query("insert into hotel_historique(id_proprietaire, id_client, operation_h, objet_h, date_histo) "
                . "values('" . $_SESSION["id_proprietaire"] . "', '" . $id . "', '" . $oph . "', '" . $obh . "', NOW())") or die(mysqli_error($con));
    } else if (isset($_SESSION["login_personnel"]) && isset($_SESSION["id_compte_personnel"])) {
        $rslthisto = $con->query("insert into hotel_historique(id_compte_personnel, id_client, operation_h, objet_h, date_histo) "
                . "values('" . $_SESSION["id_compte_personnel"] . "', '" . $id . "', '" . $oph . "', '" . $obh . "', NOW())") or die(mysqli_error($con));
    }
    echo "<script language='javascript'>$('div.alertuseraddbon').show('slow').delay(8000).hide('slow');</script>";
    ?>
    <a href="hotelpages/clienthotel/facture_client_inc_pdf.php?recu=<?php echo $rowr["id_recu"] ?>" class="btn btn-lg btn-success" target="_blank">
        <span title="Imprimer la facture du client" alt="editer"><i class="fa fa-file-pdf-o"></i> Impriner la facture</span>
    </a>
    <?php
}

function ajouter_commande_client($cli, $prixtb, $com, $con) {
    if (($com != NULL)) {
        $rsltpl2 = $con->query("select * from hotel_paye_logement as pl left join hotel_recu as r on pl.id_paye_logement=r.id_paye_logement "
                . "left join hotel_client as c on pl.id_client=c.id_client where pl.id_client='" . $cli . "' order by pl.date_pl desc limit 0,1") or die(mysqli_error($con));
        $rowpl2 = mysqli_fetch_assoc($rsltpl2);
        $an = date('Y');
        $obh = "";
        $numid = date('Y', time()) . sprintf("%08d", 1);
        $req1 = $con->query("select * from hotel_facture_m where YEAR(date_facture_m)='" . $an . "'") or die(mysqli_error($con));
        $i = 0;
        while ($reqte = mysqli_fetch_assoc($req1)) {
            $i = $i + 1;
        }
        $numid = date('Y', time()) . sprintf("%08d", $i + 1);
        if (isset($_SESSION["id_compte_personnel"])) {
            $rsltf = $con->query("insert into hotel_facture_m(id_compte_personnel, id_paye_logement, num_fact_m, montant_fact_m, date_facture_m) "
                    . "values('" . $_SESSION["id_compte_personnel"] . "','" . $rowpl2["id_paye_logement"] . "', '" . $numid . "', '" . $prixtb . "', NOW())") or die(mysqli_error($con));
        } else {
            $rsltf = $con->query("insert into hotel_facture_m(id_paye_logement, num_fact_m, montant_fact_m, date_facture_m) "
                    . "values('" . $rowpl2["id_paye_logement"] . "', '" . $numid . "', '" . $prixtb . "', NOW())") or die(mysqli_error($con));
        }
        $rsltfa = $con->query("select * from hotel_facture_m where num_fact_m='" . $numid . "'") or die(mysqli_error($con));
        $rowfa = mysqli_fetch_assoc($rsltfa);
        $prixt = 0;
        foreach ($_SESSION["cart_prodv" . $cli] as $prod) {
            $rsltreg = $con->query("insert into hotel_ligne_m(id_menu, id_facture_m, qte_fmr, prix_fmr) "
                    . "values('" . $prod["idart"] . "', '" . $rowfa["id_facture_m"] . "', '" . $prod["qteart"] . "', "
                    . "'" . $prod["prixart"] . "')") or die(mysqli_error($con));
            $prixt = $prixt + ($prod["prixart"] * $prod["qteart"]);
            $obh = $prod["qteart"] . "-" . $prod["designationart"];
        }
        ?>
        <?php
        $contenu = NULL;
        $op = "Restaurant";
        if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
            $rsltreg = $con->query("insert into hotel_registre_client(id_paye_logement, montant_reg, operation_reg, date_registre) "
                    . "values('" . $rowpl2["id_paye_logement"] . "', '" . $prixt . "', '" . $op . "', NOW())") or die(mysqli_error($con));
        } else if (isset($_SESSION["login_personnel"]) && (isset($_SESSION["mot_de_passe_personnel"])) && ($_SESSION["etat_compte_personnel"])) {
            $rsltreg = $con->query("insert into hotel_registre_client(id_paye_logement, id_compte_personnel, montant_reg, "
                    . "operation_reg, date_registre) values('" . $rowpl2["id_paye_logement"] . "', "
                    . "'" . $_SESSION["id_compte_personnel"] . "', '" . $prixt . "', '" . $op . "', NOW())") or die(mysqli_error($con));
        }
        $oph = "Commande";
        if (isset($_SESSION["loginproprietaire"]) && isset($_SESSION["id_proprietaire"])) {
            $rslthisto = $con->query("insert into hotel_historique(id_proprietaire, id_client, operation_h, objet_h, date_histo) "
                    . "values('" . $_SESSION["id_proprietaire"] . "', '" . $cli . "', '" . $oph . "', '" . $obh . "', NOW())") or die(mysqli_error($con));
        } else if (isset($_SESSION["login_personnel"]) && isset($_SESSION["id_compte_personnel"])) {
            $rslthisto = $con->query("insert into hotel_historique(id_compte_personnel, id_client, operation_h, objet_h, date_histo) "
                    . "values('" . $_SESSION["id_compte_personnel"] . "', '" . $cli . "', '" . $oph . "', '" . $obh . "', NOW())") or die(mysqli_error($con));
        }
        unset($_SESSION["cart_prodv" . $cli]);
        echo "<script language='javascript'>$('div.alertuseraddbon').show('slow').delay(8000).hide('slow');</script>";
        ?>
        <a href="hotelpages/clienthotel/commandeclienthotel/facture_commande_pdf.php?commande=<?php echo $rowfa["id_facture_m"] ?>" class="btn btn-lg btn-success" target="_blank">
            <span title="Imprimer la facture du client" alt="editer"><i class="fa fa-file-pdf-o"></i> Impriner la facture</span>
        </a>
        <?php
    } else {
        echo "<script language='javascript'>$('div.alertclformvide').show('slow').delay(8000).hide('slow');</script>";
    }
}

function ajouter_commande_restaurant_divers($prixtb, $com, $con) {
    if (($com != NULL)) {
        $an = date('Y');
        $obh = "";
        $numid = date('Y', time()) . sprintf("%08d", 1);
        $req1 = $con->query("select * from hotel_facture_m where YEAR(date_facture_m)='" . $an . "'") or die(mysqli_error($con));
        $i = 0;
        while ($reqte = mysqli_fetch_assoc($req1)) {
            $i = $i + 1;
        }
        $numid = date('Y', time()) . sprintf("%08d", $i + 1);
        if (isset($_SESSION["id_compte_personnel"])) {
            $rsltf = $con->query("insert into hotel_facture_m(id_compte_personnel, num_fact_m, montant_fact_m, date_facture_m) "
                    . "values('" . $_SESSION["id_compte_personnel"] . "', '" . $numid . "', '" . $prixtb . "', NOW())") or die(mysqli_error($con));
        } else {
            $rsltf = $con->query("insert into hotel_facture_m(num_fact_m, montant_fact_m, date_facture_m) "
                    . "values('" . $numid . "', '" . $prixtb . "', NOW())") or die(mysqli_error($con));
        }
        $rsltfa = $con->query("select * from hotel_facture_m where num_fact_m='" . $numid . "'") or die(mysqli_error($con));
        $rowfa = mysqli_fetch_assoc($rsltfa);
        $prixt = 0;
        foreach ($_SESSION["cart_prodv"] as $prod) {
            $rsltreg = $con->query("insert into hotel_ligne_m(id_menu, id_facture_m, qte_fmr, prix_fmr) "
                    . "values('" . $prod["idart"] . "', '" . $rowfa["id_facture_m"] . "', '" . $prod["qteart"] . "', "
                    . "'" . $prod["prixart"] . "')") or die(mysqli_error($con));
            $prixt = $prixt + ($prod["prixart"] * $prod["qteart"]);
            $obh = $prod["qteart"] . "-" . addslashes($prod["designationart"]);
        }

        $oph = "Commande restaurant";
        if (isset($_SESSION["loginproprietaire"]) && isset($_SESSION["id_proprietaire"])) {
            $rslthisto = $con->query("insert into hotel_historique(id_proprietaire, operation_h, objet_h, date_histo) "
                    . "values('" . $_SESSION["id_proprietaire"] . "', '" . $oph . "', '" . $obh . "', NOW())") or die(mysqli_error($con));
        } else if (isset($_SESSION["login_personnel"]) && isset($_SESSION["id_compte_personnel"])) {
            $rslthisto = $con->query("insert into hotel_historique(id_compte_personnel, operation_h, objet_h, date_histo) "
                    . "values('" . $_SESSION["id_compte_personnel"] . "', '" . $oph . "', '" . $obh . "', NOW())") or die(mysqli_error($con));
        }
        unset($_SESSION["cart_prodv"]);
        echo "<script language='javascript'>$('div.alertuseraddbon').show('slow').delay(8000).hide('slow');</script>";
        ?>
        <a href="hotelpages/restauranthotel/commanderestauranthotel/facture_commande_pdf.php?commande=<?php echo $rowfa["id_facture_m"] ?>" class="btn btn-lg btn-success" target="_blank">
            <span title="Imprimer la facture du client" alt="editer"><i class="fa fa-file-pdf-o"></i> Impriner la facture</span>
        </a>
        <?php
    } else {
        echo "<script language='javascript'>$('div.alertclformvide').show('slow').delay(8000).hide('slow');</script>";
    }
}

function ajouter_commande_bar_client($cli, $prixtb, $com, $con) {
    if (($com != NULL)) {
        $rsltpl2 = $con->query("select * from hotel_paye_logement as pl left join hotel_recu as r on pl.id_paye_logement=r.id_paye_logement "
                . "where pl.id_client='" . $cli . "' order by pl.date_pl desc limit 0,1") or die(mysqli_error($con));
        $rowpl2 = mysqli_fetch_assoc($rsltpl2);
//        echo "<script language='javascript'>alert('ouppps')</script>";
        $an = date('Y');
        $obh = "";
        $numid = date('Y', time()) . sprintf("%08d", 1);
        $req1 = $con->query("select * from hotel_commande_bar where YEAR(date_commande_bar)='" . $an . "'") or die(mysqli_error($con));
        $i = 0;
        while ($reqte = mysqli_fetch_assoc($req1)) {
            $i = $i + 1;
        }
        $numid = date('Y', time()) . sprintf("%08d", ($i + 1));

        if (isset($_SESSION["id_compte_personnel"])) {
            $rsltf = $con->query("insert into hotel_commande_bar(id_compte_personnel, id_paye_logement, reference_commande_bar, "
                    . "montant_commande_bar, date_commande_bar) values('" . $_SESSION["id_compte_personnel"] . "', "
                    . "'" . $rowpl2["id_paye_logement"] . "', '" . $numid . "', '" . $prixtb . "', NOW())") or die(mysqli_error($con));
        } else {
            $rsltf = $con->query("insert into hotel_commande_bar(id_paye_logement, reference_commande_bar, montant_commande_bar, "
                    . "date_commande_bar) values('" . $rowpl2["id_paye_logement"] . "', '" . $numid . "', '" . $prixtb . "', "
                    . "NOW())") or die(mysqli_error($con));
        }
        $rsltfa = $con->query("select * from hotel_commande_bar where reference_commande_bar='" . $numid . "'") or die(mysqli_error($con));
        $rowfa = mysqli_fetch_assoc($rsltfa);
        $prixt = 0;
        foreach ($_SESSION["cart_prodvb" . $cli] as $prod) {
            $reqar = $con->query("select * from hotel_magasin_bar where id_magasin_bar='" . $prod["idart"] . "'") or die(mysqli_error($con));
            $rowar = mysqli_fetch_assoc($reqar);

            $rsltreg = $con->query("insert into hotel_ligne_commande_bar(id_magasin_bar, id_commande_bar, stock_ligne_cb, "
                    . "prix_ligne_cb) values('" . $prod["idart"] . "', '" . $rowfa["id_commande_bar"] . "', "
                    . "'" . $prod["qteart"] . "', '" . $prod["prixart"] . "')") or die(mysqli_error($con));
            $prixt = $prixt + ($prod["prixart"] * $prod["qteart"]);
            $obh = $prod["qteart"] . "-" . addcslashes($prod["designationart"]);

            $stockar = $rowar["stock_article_mb"] - $prod["qteart"];
            $rsltar = $con->query("update hotel_magasin_bar set stock_article_mb='" . $stockar . "' where "
                    . "id_magasin_bar='" . $prod["idart"] . "'") or die(mysqli_error($con));
        }
        ?>
        <?php
        $contenu = NULL;
        $op = "Bar";
        if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
            $rsltreg = $con->query("insert into hotel_registre_client(id_paye_logement, montant_reg, operation_reg, date_registre) "
                    . "values('" . $rowpl2["id_paye_logement"] . "', '" . $prixtb . "', '" . $op . "', NOW())") or die(mysqli_error($con));
        } else if (isset($_SESSION["login_personnel"]) && (isset($_SESSION["mot_de_passe_personnel"])) && ($_SESSION["etat_compte_personnel"])) {
            $rsltreg = $con->query("insert into hotel_registre_client(id_paye_logement, id_compte_personnel, montant_reg, "
                    . "operation_reg, date_registre) values('" . $rowpl2["id_paye_logement"] . "', "
                    . "'" . $_SESSION["id_compte_personnel"] . "', '" . $prixtb . "', '" . $op . "', NOW())") or die(mysqli_error($con));
        }
        $oph = "Commande";
        if (isset($_SESSION["loginproprietaire"]) && isset($_SESSION["id_proprietaire"])) {
            $rslthisto = $con->query("insert into hotel_historique(id_proprietaire, id_client, operation_h, objet_h, date_histo) "
                    . "values('" . $_SESSION["id_proprietaire"] . "', '" . $cli . "', '" . $oph . "', '" . $obh . "', NOW())") or die(mysqli_error($con));
        } else if (isset($_SESSION["login_personnel"]) && isset($_SESSION["id_compte_personnel"])) {
            $rslthisto = $con->query("insert into hotel_historique(id_compte_personnel, id_client, operation_h, objet_h, date_histo) "
                    . "values('" . $_SESSION["id_compte_personnel"] . "', '" . $cli . "', '" . $oph . "', '" . $obh . "', NOW())") or die(mysqli_error($con));
        }
        unset($_SESSION["cart_prodvb" . $cli]);
        echo "<script language='javascript'>$('div.alertuseraddbon').show('slow').delay(8000).hide('slow');</script>";
        ?>
        <a href="hotelpages/clienthotel/commandebarclienthotel/facture_commande_pdf.php?commande=<?php echo $rowfa["id_commande_bar"] ?>" class="btn btn-lg btn-success" target="_blank">
            <span title="Imprimer la facture du client" alt="editer"><i class="fa fa-file-pdf-o"></i> Impriner la facture</span>
        </a>
        <?php
    } else {
        echo "<script language='javascript'>$('div.alertclformvide').show('slow').delay(8000).hide('slow');</script>";
    }
}

function ajouter_commande_bar_divers($prixtb, $com, $con) {
    if (($com != NULL)) {
        $an = date('Y');
        $obh = "";
        $numid = date('Y', time()) . sprintf("%08d", 1);
        $req1 = $con->query("select * from hotel_commande_bar where YEAR(date_commande_bar)='" . $an . "'") or die(mysqli_error($con));
        $i = 0;
        while ($reqte = mysqli_fetch_assoc($req1)) {
            $i = $i + 1;
        }
        $numid = date('Y', time()) . sprintf("%08d", ($i + 1));
        if (isset($_SESSION["id_compte_personnel"])) {
            $rsltf = $con->query("insert into hotel_commande_bar(id_compte_personnel, reference_commande_bar, "
                    . "montant_commande_bar, date_commande_bar) values('" . $_SESSION["id_compte_personnel"] . "', "
                    . "'" . $numid . "', '" . $prixtb . "', NOW())") or die(mysqli_error($con));
        } else {
            $rsltf = $con->query("insert into hotel_commande_bar(reference_commande_bar, montant_commande_bar, "
                    . "date_commande_bar) values('" . $numid . "', '" . $prixtb . "', "
                    . "NOW())") or die(mysqli_error($con));
        }
        $rsltfa = $con->query("select * from hotel_commande_bar where reference_commande_bar='" . $numid . "'") or die(mysqli_error($con));
        $rowfa = mysqli_fetch_assoc($rsltfa);
        $prixt = 0;
        foreach ($_SESSION["cart_prodvb"] as $prod) {
            $reqar = $con->query("select * from hotel_magasin_bar where id_magasin_bar='" . $prod["idart"] . "'") or die(mysqli_error($con));
            $rowar = mysqli_fetch_assoc($reqar);

            $rsltreg = $con->query("insert into hotel_ligne_commande_bar(id_magasin_bar, id_commande_bar, stock_ligne_cb, "
                    . "prix_ligne_cb) values('" . $prod["idart"] . "', '" . $rowfa["id_commande_bar"] . "', "
                    . "'" . $prod["qteart"] . "', '" . $prod["prixart"] . "')") or die(mysqli_error($con));
            $prixt = $prixt + ($prod["prixart"] * $prod["qteart"]);
            $obh = $prod["qteart"] . "-" . $prod["designationart"];

            $stockar = $rowar["stock_article_mb"] - $prod["qteart"];
            $rsltar = $con->query("update hotel_magasin_bar set stock_article_mb='" . $stockar . "' where "
                    . "id_magasin_bar='" . $prod["idart"] . "'") or die(mysqli_error($con));
        }

        $oph = "Commande Diverse";
        if (isset($_SESSION["loginproprietaire"]) && isset($_SESSION["id_proprietaire"])) {
            $rslthisto = $con->query("insert into hotel_historique(id_proprietaire, operation_h, objet_h, date_histo) "
                    . "values('" . $_SESSION["id_proprietaire"] . "', '" . $oph . "', '" . $obh . "', NOW())") or die(mysqli_error($con));
        } else if (isset($_SESSION["login_personnel"]) && isset($_SESSION["id_compte_personnel"])) {
            $rslthisto = $con->query("insert into hotel_historique(id_compte_personnel, operation_h, objet_h, date_histo) "
                    . "values('" . $_SESSION["id_compte_personnel"] . "', '" . $oph . "', '" . $obh . "', NOW())") or die(mysqli_error($con));
        }
        unset($_SESSION["cart_prodvb"]);
        echo "<script language='javascript'>$('div.alertuseraddbon').show('slow').delay(8000).hide('slow');</script>";
        ?>
        <a href="hotelpages/barhotel/commandebarhotel/facture_commande_pdf.php?commande=<?php echo $rowfa["id_commande_bar"] ?>" class="btn btn-lg btn-success" target="_blank">
            <span title="Imprimer la facture du client" alt="editer"><i class="fa fa-file-pdf-o"></i> Impriner la facture</span>
        </a>
        <?php
    } else {
        echo "<script language='javascript'>$('div.alertclformvide').show('slow').delay(8000).hide('slow');</script>";
    }
}

function ajouter_commande_divers($com, $con) {
    if (($com != NULL)) {

        $an = date('Y');
        $obh = "";
        $numid = date('Y', time()) . sprintf("%08d", 1);
        $req1 = $con->query("select * from hotel_facture_m where YEAR(date_facture_m)='" . $an . "'") or die(mysqli_error($con));
        $i = 0;
        while ($reqte = mysqli_fetch_assoc($req1)) {
            $i = $i + 1;
        }
        $numid = date('Y', time()) . sprintf("%08d", $i + 1);
        if (isset($_SESSION["id_compte_personnel"])) {
            $rsltf = $con->query("insert into hotel_facture_m(id_compte_personnel, num_fact_m, date_facture_m) "
                    . "values('" . $_SESSION["id_compte_personnel"] . "', '" . $numid . "', NOW())") or die(mysqli_error($con));
        } else {
            $rsltf = $con->query("insert into hotel_facture_m(num_fact_m, date_facture_m) "
                    . "values('" . $numid . "', NOW())") or die(mysqli_error($con));
        }
        $rsltfa = $con->query("select * from hotel_facture_m where num_fact_m='" . $numid . "'") or die(mysqli_error($con));
        $rowfa = mysqli_fetch_assoc($rsltfa);
        $prixt = 0;
        foreach ($_SESSION["cart_prodv"] as $prod) {
            $rsltreg = $con->query("insert into hotel_ligne_m(id_menu_r, id_facture_m, qte_fmr, prix_fmr) "
                    . "values('" . $prod["idart"] . "', '" . $rowfa["id_facture_m"] . "', '" . $prod["qteart"] . "', "
                    . "'" . $prod["prixart"] . "')") or die(mysqli_error($con));
            $prixt = $prixt + ($prod["prixart"] * $prod["qteart"]);
            $obh = $prod["qteart"] . "-" . $prod["designationart"];
        }
        ?>
        <?php
        $contenu = NULL;
        $op = "Restaurant";

        $oph = "Commande";
        if (isset($_SESSION["loginproprietaire"]) && isset($_SESSION["id_proprietaire"])) {
            $rslthisto = $con->query("insert into hotel_historique(id_proprietaire, operation_h, objet_h, date_histo) "
                    . "values('" . $_SESSION["id_proprietaire"] . "', '" . $oph . "', '" . $obh . "', NOW())") or die(mysqli_error($con));
        } else if (isset($_SESSION["login_personnel"]) && isset($_SESSION["id_compte_personnel"])) {
            $rslthisto = $con->query("insert into hotel_historique(id_compte_personnel, operation_h, objet_h, date_histo) "
                    . "values('" . $_SESSION["id_compte_personnel"] . "', '" . $oph . "', '" . $obh . "', NOW())") or die(mysqli_error($con));
        }
        unset($_SESSION["cart_prodv"]);
        echo "<script language='javascript'>$('div.alertuseraddbon').show('slow').delay(8000).hide('slow');</script>";
        ?>
        <a href="hotelpages/commandehotel/facture_commande_pdf.php?facture=<?php echo $rowfa["id_facture_m"] ?>" class="btn btn-lg btn-success" target="_blank">
            <span title="Imprimer la facture du client" alt="editer"><i class="fa fa-file-pdf-o"></i> Impriner la facture</span>
        </a>
        <?php
    } else {
        echo "<script language='javascript'>$('div.alertclformvide').show('slow').delay(8000).hide('slow');</script>";
    }
}

function ajouter_commande_divers222($com, $con) {
    if (($com != NULL)) {

        $obh = "";
        $an = date('Y');
        $numid = date('Y', time()) . sprintf("%08d", 1);
        $req1 = $con->query("select * from hotel_facture_m where YEAR(date_facture_m)='" . $an . "'") or die(mysqli_error($con));
        $i = 0;
        while ($reqte = mysqli_fetch_assoc($req1)) {
            $i = $i + 1;
        }
        $numid = date('Y', time()) . sprintf("%08d", $i + 1);
        if (isset($_SESSION["id_compte_personnel"])) {
            $rsltf = $con->query("insert into hotel_facture_m(id_compte_personnel, num_fact_m, date_facture_m) "
                    . "values('" . $_SESSION["id_compte_personnel"] . "', '" . $numid . "', NOW())") or die(mysqli_error($con));
        } else {
            $rsltf = $con->query("insert into hotel_facture_m(num_fact_m, date_facture_m) "
                    . "values( '" . $numid . "', NOW())") or die(mysqli_error($con));
        }
        $rsltfa = $con->query("select * from hotel_facture_m where num_fact_m='" . $numid . "'") or die(mysqli_error($con));
        $rowfa = mysqli_fetch_assoc($rsltfa);
        $prixt = 0;
        if ($com[1]["cpdej"]) {
            $rsltpde = $con->query("select * from hotel_menu_r as mr left join hotel_menu as m on mr.id_menu=m.id_menu "
                    . "where mr.id_menu_r='" . $com[1]["pdej"] . "'") or die(mysqli_error($con));
            $rowpde = mysqli_fetch_assoc($rsltpde);
            $rsltreg = $con->query("insert into hotel_ligne_m(id_menu_r, id_facture_m, qte_fmr, prix_fmr) "
                    . "values('" . $com[1]["pdej"] . "', '" . $rowfa["id_facture_m"] . "', '" . $com[1]["qtepde"] . "', '" . $rowpde["prix_mr"] . "')") or die(mysqli_error($con));
            $prixt = $prixt + ($rowpde["prix_mr"] * $com[1]["qtepde"]);
            $obh = $obh . "-" . $com[1]["qtepde"] . "-" . $rowpde["nom_m"];
        }
        ?> 
        <?php
        if ($com[1]["cdej"]) {
            $rsltpde = $con->query("select * from hotel_menu_r as mr left join hotel_menu as m on mr.id_menu=m.id_menu "
                    . "where mr.id_menu_r='" . $com[1]["dej"] . "'") or die(mysqli_error($con));
            $rowpde = mysqli_fetch_assoc($rsltpde);
            $rsltreg = $con->query("insert into hotel_ligne_m(id_menu_r, id_facture_m, qte_fmr, prix_fmr) "
                    . "values('" . $com[1]["dej"] . "', '" . $rowfa["id_facture_m"] . "', '" . $com[1]["qtede"] . "', '" . $rowpde["prix_mr"] . "')") or die(mysqli_error($con));
            $prixt = $prixt + ($rowpde["prix_mr"] * $com[1]["qtede"]);
            $obh = $obh . "-" . $com[1]["qtede"] . "-" . $rowpde["nom_m"];
        }
        ?> 
        <?php
        if ($com[1]["cdine"]) {
            $rsltpde = $con->query("select * from hotel_menu_r as mr left join hotel_menu as m on mr.id_menu=m.id_menu "
                    . "where mr.id_menu_r='" . $com[1]["dine"] . "'") or die(mysqli_error($con));
            $rowpde = mysqli_fetch_assoc($rsltpde);
            $rsltreg = $con->query("insert into hotel_ligne_m(id_menu_r, id_facture_m, qte_fmr, prix_fmr) "
                    . "values('" . $com[1]["dine"] . "', '" . $rowfa["id_facture_m"] . "', '" . $com[1]["qtedi"] . "', '" . $rowpde["prix_mr"] . "')") or die(mysqli_error($con));
            $prixt = $prixt + ($rowpde["prix_mr"] * $com[1]["qtedi"]);
            $obh = $obh . "-" . $com[1]["qtedi"] . "-" . $rowpde["nom_m"];
        }
        ?> 
        <?php
        if ($com[1]["cbar"]) {
            $rsltpde = $con->query("select * from hotel_menu_r as mr left join hotel_menu as m on mr.id_menu=m.id_menu "
                    . "where mr.id_menu_r='" . $com[1]["bar"] . "'") or die(mysqli_error($con));
            $rowpde = mysqli_fetch_assoc($rsltpde);
            $rsltreg = $con->query("insert into hotel_ligne_m(id_menu_r, id_facture_m, qte_fmr, prix_fmr) "
                    . "values('" . $com[1]["bar"] . "', '" . $rowfa["id_facture_m"] . "', '" . $com[1]["qteba"] . "', '" . $rowpde["prix_mr"] . "')") or die(mysqli_error($con));
            $prixt = $prixt + ($rowpde["prix_mr"] * $com[1]["qteba"]);
            $obh = $obh . "-" . $com[1]["qteba"] . "-" . $rowpde["nom_m"];
        }
        ?> 
        <?php
        if ($com[1]["ccave"]) {
            $rsltpde = $con->query("select * from hotel_menu_r as mr left join hotel_menu as m on mr.id_menu=m.id_menu "
                    . "where mr.id_menu_r='" . $com[1]["cave"] . "'") or die(mysqli_error($con));
            $rowpde = mysqli_fetch_assoc($rsltpde);
            $rsltreg = $con->query("insert into hotel_ligne_m(id_menu_r, id_facture_m, qte_fmr, prix_fmr) "
                    . "values('" . $com[1]["cave"] . "', '" . $rowfa["id_facture_m"] . "', '" . $com[1]["qteca"] . "', '" . $rowpde["prix_mr"] . "')") or die(mysqli_error($con));
            $prixt = $prixt + ($rowpde["prix_mr"] * $com[1]["qteca"]);
            $obh = $obh . "-" . $com[1]["qteca"] . "-" . $rowpde["nom_m"];
        }

        $oph = "Commande";
        if (isset($_SESSION["loginproprietaire"]) && isset($_SESSION["id_proprietaire"])) {
            $rslthisto = $con->query("insert into hotel_historique(id_proprietaire, operation_h, objet_h, date_histo) "
                    . "values('" . $_SESSION["id_proprietaire"] . "', '" . $oph . "', '" . $obh . "', NOW())") or die(mysqli_error($con));
        } else if (isset($_SESSION["login_personnel"]) && isset($_SESSION["id_compte_personnel"])) {
            $rslthisto = $con->query("insert into hotel_historique(id_compte_personnel, operation_h, objet_h, date_histo) "
                    . "values('" . $_SESSION["id_compte_personnel"] . "', '" . $oph . "', '" . $obh . "', NOW())") or die(mysqli_error($con));
        }
        unset($_SESSION['formcom']);
        echo "<script language='javascript'>$('div.alertuseraddbon').show('slow').delay(8000).hide('slow');</script>";
        ?>
        <a href="hotelpages/commandehotel/facture_commande_pdf.php?facture=<?php echo $rowfa["id_facture_m"] ?>" class="btn btn-lg btn-success" target="_blank">
            <span title="Imprimer la facture du client" alt="editer"><i class="fa fa-file-pdf-o"></i> Impriner la facture</span>
        </a>
        <?php
    } else {
        echo "<script language='javascript'>$('div.alertclformvide').show('slow').delay(8000).hide('slow');</script>";
    }
}

//fonction pour lister les Factures menu
function lister_facture_commande_bar($con) {
    $rsltuser = $con->query("select * from hotel_commande_bar order by date_commande_bar desc ") or die(mysqli_error($con));
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        ?>

        <tr >
            <td><?php print nl2br(htmlspecialchars($recuser["reference_commande_bar"])) ?></td>
            <td>
                <?php
                if (($recuser["id_paye_logement"] != NULL) && ($recuser["id_paye_logement"] != 0)) {

                    $rsltcl = $con->query("select * from hotel_paye_logement as pl left join hotel_client as c on pl.id_client=c.id_client "
                            . "where pl.id_paye_logement='" . $recuser["id_paye_logement"] . "' ") or die(mysqli_error($con));
                    $rowcl = mysqli_fetch_assoc($rsltcl);
                    ?>
                    <?php print nl2br(htmlspecialchars($rowcl["nom_client"])) ?> 
                    <?php print nl2br(htmlspecialchars($rowcl["prenom_client"])) ?> - 
                    <?php print nl2br(htmlspecialchars($rowcl["cni_client"])) ?> --
                    <?php
                    if ($rowcl["id_chambre"] != NULL) {
                        $reqch = $con->query("select * from hotel_chambre as c left join hotel_point_hotel as ph on "
                                . "c.id_point_hotel=ph.id_point_hotel left join hotel_proprietaire as p on "
                                . "ph.id_proprietaire=p.id_proprietaire where c.id_chambre= '" . $rowcl["id_chambre"] . "' ")
                                or die(mysqli_error($con));
                        $rowch = mysqli_fetch_assoc($reqch);
                        ?>
                        &nbsp;
                        <?php print nl2br(htmlspecialchars($rowch["code_c"])) ?>
                        <?php
                    } else if ($rowcl["id_studio"] != NULL) {
                        $reqst = $con->query("select * from hotel_studio as s left join hotel_point_hotel as ph on "
                                . "s.id_point_hotel=ph.id_point_hotel left join hotel_proprietaire as p on "
                                . "ph.id_proprietaire=p.id_proprietaire where s.id_studio= '" . $rowcl["id_studio"] . "' ")
                                or die(mysqli_error($con));
                        $rowst = mysqli_fetch_assoc($reqst);
                        ?>
                        &nbsp;
                        <?php print nl2br(htmlspecialchars($rowst["code_s"])) ?>
                        <?php
                    } else if ($rowcl["id_appartement"] != NULL) {
                        $reqap = $con->query("select * from hotel_appartement as a left join hotel_point_hotel as ph on "
                                . "a.id_point_hotel=ph.id_point_hotel left join hotel_proprietaire as p on "
                                . "ph.id_proprietaire=p.id_proprietaire where a.id_appartement= '" . $rowcl["id_appartement"] . "' ")
                                or die(mysqli_error($con));
                        $rowap = mysqli_fetch_assoc($reqap);
                        ?>
                        &nbsp;
                        <?php print nl2br(htmlspecialchars($rowap["code_a"])) ?> 
                        <?php print nl2br(htmlspecialchars($rowap["nbchambre_a"])) ?> C 
                        <?php print nl2br(htmlspecialchars($rowap["nbsalon_a"])) ?> S 
                        <?php print nl2br(htmlspecialchars($rowap["nbcuisine_a"])) ?> CU
                        <?php print nl2br(htmlspecialchars($rowap["nbdouche_a"])) ?> D
                        <?php
                    } else if ($rowcl["id_salle"] != NULL) {
                        $reqst = $con->query("select * from hotel_salle as s left join hotel_point_hotel as ph on "
                                . "s.id_point_hotel=ph.id_point_hotel left join hotel_proprietaire as p on "
                                . "ph.id_proprietaire=p.id_proprietaire where s.id_salle= '" . $rowcl["id_salle"] . "' ")
                                or die(mysqli_error($con));
                        $rowst = mysqli_fetch_assoc($reqst);
                        ?>
                        &nbsp;
                        <?php print nl2br(htmlspecialchars($rowst["code_salle"])) ?>
                        <?php
                    }
                }
                ?>
            </td>
            <td>
                <?php
                if (($recuser["id_compte_personnel"] != NULL) && ($recuser["id_compte_personnel"] != 0)) {

                    $rsltpe = $con->query("select * from hotel_compte_personnel as cp left join hotel_personnel as p on "
                            . "cp.id_personnel=p.id_personnel where cp.id_compte_personnel='" . $recuser["id_compte_personnel"] . "' ")
                            or die(mysqli_error($con));
                    $rowpe = mysqli_fetch_assoc($rsltpe);
                    ?>
                    <?php print nl2br(htmlspecialchars($rowpe["nom_pe"])) ?> 
                    <?php print nl2br(htmlspecialchars($rowpe["prenom_pe"])) ?> - 
                    <?php print nl2br(htmlspecialchars($rowpe["login_pe"])) ?> --
                    <?php
                    $reqs = $con->query("select * from hotel_affectation as a left join service_point_hotel as sph on "
                            . "a.id_point_hotel=sph.id_point_hotel and a.id_service=sph.id_service left join hotel_service "
                            . "as s on sph.id_service=s.id_service where a.id_personnel= '" . $rowpe["id_personnel"] . "' "
                            . "order by a.date_affectation desc limit 0,1 ")
                            or die(mysqli_error($con));
                    $rows = mysqli_fetch_assoc($reqs);
                    ?>
                    &nbsp;
                    <?php print nl2br(htmlspecialchars($rows["code_service"])) ?>
                    <?php
                }
                ?>
            </td>
            <td><?php print nl2br(htmlspecialchars($recuser["montant_commande_bar"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["etat_commande_bar"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["date_commande_bar"])) ?></td>
            <td>
                <?php
//                    $rsltpl = $con->query("select * from hotel_paye_logement as pl left join hotel_recu as r on pl.id_paye_logement=r.id_paye_logement "
//                            . "where pl.id_facture_m='" . $recuser["id_facture_m"] . "' and pl.date_fin_pl >= NOW() order by pl.date_pl desc ") or die(mysqli_error($con));
//                    $rowpl = mysqli_fetch_assoc($rsltpl);
//                    $rsltpl2 = $con->query("select * from hotel_paye_logement as pl left join hotel_recu as r on pl.id_paye_logement=r.id_paye_logement "
//                            . "where pl.id_facture_m='" . $recuser["id_facture_m"] . "' order by pl.date_pl desc limit 0,1") or die(mysqli_error($con));
//                    $rowpl2 = mysqli_fetch_assoc($rsltpl2);
//                    $today = date('Y-m-d H:i:s');
//                    $dif = dateDiff($today, $rowpl["date_fin_pl"]);
                if (isset($_SESSION["loginproprietaire"])) {
                    ?>
                            <!--                    <a href="indexproprietaire.php?page=<?php echo base64_encode('hotelpages/barhotel/commandebarhotel/editer_commandes') ?>&commande=<?php echo $recuser["id_commande_bar"] ?>">
                                            <span title="Modifier cette Facture" alt="editer"><i class="glyphicon glyphicon-edit"></i></span>
                                        </a>&nbsp;&nbsp;-->
                    <a href="indexproprietaire.php?page=<?php echo base64_encode('hotelpages/barhotel/commandebarhotel/lister_ligne_commandes') ?>&commande=<?php echo $recuser["id_commande_bar"] ?>">
                        <span title="Lister les lignes de cette Commande" alt="dossier"><i class="glyphicon glyphicon-folder-open"></i></span>
                    </a>
                    <?php
                } else {
                    if (($_SESSION["code_service"] == "BAR") || ($_SESSION["code_service"] == "BARESTO")) {
                        ?>
                                <!--                        <a href="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/barhotel/commandebarhotel/editer_commandes') ?>&commande=<?php echo $recuser["id_commande_bar"] ?>">
                                                <span title="Modifier cette Facture" alt="editer"><i class="glyphicon glyphicon-edit"></i></span>
                                            </a>-->
                        <?php
                    }
                    ?>&nbsp;&nbsp;
                    <a href="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/barhotel/commandebarhotel/lister_ligne_commandes') ?>&commande=<?php echo $recuser["id_commande_bar"] ?>">
                        <span title="Lister les lignes de cette Facture" alt="dossier"><i class="glyphicon glyphicon-folder-open"></i></span>
                    </a>
                    <?php
                }

                if (($recuser["id_paye_logement"] != NULL) && ($recuser["id_paye_logement"] != 0)) {
                    ?>&nbsp;&nbsp;
                    <a href="hotelpages/clienthotel/commandebarclienthotel/facture_commande_pdf.php?commande=<?php echo $recuser["id_commande_bar"] ?>" target="_blank">
                        <span title="Imprimer la facture du client" alt="editer"><i class="glyphicon glyphicon-print"></i></span>
                    </a>
                    <?php
                } else {
                    ?>&nbsp;&nbsp;
                    <a href="hotelpages/barhotel/commandebarhotel/facture_commande_pdf.php?commande=<?php echo $recuser["id_commande_bar"] ?>" target="_blank">
                        <span title="Imprimer la facture du client" alt="editer"><i class="glyphicon glyphicon-print"></i></span>
                    </a>
                    <?php
                }
                ?>
            </td>
        </tr>

        <?php
    }
}

function lister_facture_commande_bar_ligne($fact, $con) {
    $rsltuser = $con->query("select * from hotel_ligne_commande_bar as l left join hotel_magasin_bar as mr on "
            . "l.id_magasin_bar=mr.id_magasin_bar left join hotel_article as m on mr.id_article=m.id_article "
            . "left join hotel_categorie as c on m.id_categorie=c.id_categorie where "
            . "l.id_commande_bar='" . $fact . "'") or die(mysqli_error($con));
//    $row = mysqli_fetch_assoc($rslt);
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        ?>

        <tr >
            <td><?php print nl2br(htmlspecialchars($recuser["code_article"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["libelle_article"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["libelle_categorie"])) ?></td>
            <td>
                <?php print nl2br(htmlspecialchars($recuser["stock_ligne_cb"])) ?> 
            </td>
            <td><?php print nl2br(htmlspecialchars($recuser["prix_ligne_cb"])) ?></td>
            <td><?php echo $recuser["stock_ligne_cb"] * $recuser["prix_ligne_cb"] ?></td>
        </tr>

        <?php
    }
}

//fonction pour lister les Factures menu
function lister_facture_commande_restaurant($con) {
    $rsltuser = $con->query("select * from hotel_facture_m order by date_facture_m desc ") or die(mysqli_error($con));
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        ?>

        <tr >
            <td><?php print nl2br(htmlspecialchars($recuser["num_fact_m"])) ?></td>
            <td>
                <?php
                if (($recuser["id_paye_logement"] != NULL) && ($recuser["id_paye_logement"] != 0)) {

                    $rsltcl = $con->query("select * from hotel_paye_logement as pl left join hotel_client as c on pl.id_client=c.id_client "
                            . "where pl.id_paye_logement='" . $recuser["id_paye_logement"] . "' ") or die(mysqli_error($con));
                    $rowcl = mysqli_fetch_assoc($rsltcl);
                    ?>
                    <?php print nl2br(htmlspecialchars($rowcl["nom_client"])) ?> 
                    <?php print nl2br(htmlspecialchars($rowcl["prenom_client"])) ?> - 
                    <?php print nl2br(htmlspecialchars($rowcl["cni_client"])) ?> --
                    <?php
                    if ($rowcl["id_chambre"] != NULL) {
                        $reqch = $con->query("select * from hotel_chambre as c left join hotel_point_hotel as ph on "
                                . "c.id_point_hotel=ph.id_point_hotel left join hotel_proprietaire as p on "
                                . "ph.id_proprietaire=p.id_proprietaire where c.id_chambre= '" . $rowcl["id_chambre"] . "' ")
                                or die(mysqli_error($con));
                        $rowch = mysqli_fetch_assoc($reqch);
                        ?>
                        &nbsp;
                        <?php print nl2br(htmlspecialchars($rowch["code_c"])) ?>
                        <?php
                    } else if ($rowcl["id_studio"] != NULL) {
                        $reqst = $con->query("select * from hotel_studio as s left join hotel_point_hotel as ph on "
                                . "s.id_point_hotel=ph.id_point_hotel left join hotel_proprietaire as p on "
                                . "ph.id_proprietaire=p.id_proprietaire where s.id_studio= '" . $rowcl["id_studio"] . "' ")
                                or die(mysqli_error($con));
                        $rowst = mysqli_fetch_assoc($reqst);
                        ?>
                        &nbsp;
                        <?php print nl2br(htmlspecialchars($rowst["code_s"])) ?>
                        <?php
                    } else if ($rowcl["id_appartement"] != NULL) {
                        $reqap = $con->query("select * from hotel_appartement as a left join hotel_point_hotel as ph on "
                                . "a.id_point_hotel=ph.id_point_hotel left join hotel_proprietaire as p on "
                                . "ph.id_proprietaire=p.id_proprietaire where a.id_appartement= '" . $rowcl["id_appartement"] . "' ")
                                or die(mysqli_error($con));
                        $rowap = mysqli_fetch_assoc($reqap);
                        ?>
                        &nbsp;
                        <?php print nl2br(htmlspecialchars($rowap["code_a"])) ?> 
                        <?php print nl2br(htmlspecialchars($rowap["nbchambre_a"])) ?> C 
                        <?php print nl2br(htmlspecialchars($rowap["nbsalon_a"])) ?> S 
                        <?php print nl2br(htmlspecialchars($rowap["nbcuisine_a"])) ?> CU
                        <?php print nl2br(htmlspecialchars($rowap["nbdouche_a"])) ?> D
                        <?php
                    } else if ($rowcl["id_salle"] != NULL) {
                        $reqst = $con->query("select * from hotel_salle as s left join hotel_point_hotel as ph on "
                                . "s.id_point_hotel=ph.id_point_hotel left join hotel_proprietaire as p on "
                                . "ph.id_proprietaire=p.id_proprietaire where s.id_salle= '" . $rowcl["id_salle"] . "' ")
                                or die(mysqli_error($con));
                        $rowst = mysqli_fetch_assoc($reqst);
                        ?>
                        &nbsp;
                        <?php print nl2br(htmlspecialchars($rowst["code_salle"])) ?>
                        <?php
                    }
                }
                ?>
            </td>
            <td>
                <?php
                if (($recuser["id_compte_personnel"] != NULL) && ($recuser["id_compte_personnel"] != 0)) {

                    $rsltpe = $con->query("select * from hotel_compte_personnel as cp left join hotel_personnel as p on "
                            . "cp.id_personnel=p.id_personnel where cp.id_compte_personnel='" . $recuser["id_compte_personnel"] . "' ")
                            or die(mysqli_error($con));
                    $rowpe = mysqli_fetch_assoc($rsltpe);
                    ?>
                    <?php print nl2br(htmlspecialchars($rowpe["nom_pe"])) ?> 
                    <?php print nl2br(htmlspecialchars($rowpe["prenom_pe"])) ?> - 
                    <?php print nl2br(htmlspecialchars($rowpe["login_pe"])) ?> --
                    <?php
                    $reqs = $con->query("select * from hotel_affectation as a left join service_point_hotel as sph on "
                            . "a.id_point_hotel=sph.id_point_hotel and a.id_service=sph.id_service left join hotel_service "
                            . "as s on sph.id_service=s.id_service where a.id_personnel= '" . $rowpe["id_personnel"] . "' "
                            . "order by a.date_affectation desc limit 0,1 ")
                            or die(mysqli_error($con));
                    $rows = mysqli_fetch_assoc($reqs);
                    ?>
                    &nbsp;
                    <?php print nl2br(htmlspecialchars($rows["code_service"])) ?>
                    <?php
                }
                ?>
            </td>
            <td><?php print nl2br(htmlspecialchars($recuser["montant_fact_m"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["date_facture_m"])) ?></td>
            <td>
                <?php
//                    $rsltpl = $con->query("select * from hotel_paye_logement as pl left join hotel_recu as r on pl.id_paye_logement=r.id_paye_logement "
//                            . "where pl.id_facture_m='" . $recuser["id_facture_m"] . "' and pl.date_fin_pl >= NOW() order by pl.date_pl desc ") or die(mysqli_error($con));
//                    $rowpl = mysqli_fetch_assoc($rsltpl);
//                    $rsltpl2 = $con->query("select * from hotel_paye_logement as pl left join hotel_recu as r on pl.id_paye_logement=r.id_paye_logement "
//                            . "where pl.id_facture_m='" . $recuser["id_facture_m"] . "' order by pl.date_pl desc limit 0,1") or die(mysqli_error($con));
//                    $rowpl2 = mysqli_fetch_assoc($rsltpl2);
//                    $today = date('Y-m-d H:i:s');
//                    $dif = dateDiff($today, $rowpl["date_fin_pl"]);
                if (isset($_SESSION["loginproprietaire"])) {
                    ?>
                            <!--                    <a href="indexproprietaire.php?page=<?php echo base64_encode('hotelpages/restauranthotel/commanderestauranthotel/editer_commandes') ?>&commande=<?php echo $recuser["id_facture_m"] ?>">
                                            <span title="Modifier cette Facture" alt="editer"><i class="glyphicon glyphicon-edit"></i></span>
                                        </a>&nbsp;&nbsp;-->
                    <a href="indexproprietaire.php?page=<?php echo base64_encode('hotelpages/restauranthotel/commanderestauranthotel/lister_ligne_commandes') ?>&commande=<?php echo $recuser["id_facture_m"] ?>">
                        <span title="Lister les lignes de cette Commande" alt="dossier"><i class="glyphicon glyphicon-folder-open"></i></span>
                    </a>
                    <?php
                } else {
                    if (($_SESSION["code_service"] == "RESTO") || ($_SESSION["code_service"] == "BARESTO")) {
                        ?>
                                <!--                        <a href="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/restauranthotel/commanderestauranthotel/editer_commandes') ?>&commande=<?php echo $recuser["id_facture_m"] ?>">
                                                <span title="Modifier cette Facture" alt="editer"><i class="glyphicon glyphicon-edit"></i></span>
                                            </a>-->
                        <?php
                    }
                    ?>&nbsp;&nbsp;
                    <a href="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/restauranthotel/commanderestauranthotel/lister_ligne_commandes') ?>&commande=<?php echo $recuser["id_facture_m"] ?>">
                        <span title="Lister les lignes de cette Facture" alt="dossier"><i class="glyphicon glyphicon-folder-open"></i></span>
                    </a>
                    <?php
                }

                if (($recuser["id_paye_logement"] != NULL) && ($recuser["id_paye_logement"] != 0)) {
                    ?>&nbsp;&nbsp;
                    <a href="hotelpages/clienthotel/commandeclienthotel/facture_commande_pdf.php?commande=<?php echo $recuser["id_facture_m"] ?>" target="_blank">
                        <span title="Imprimer la facture du client" alt="editer"><i class="glyphicon glyphicon-print"></i></span>
                    </a>
                    <?php
                } else {
                    ?>&nbsp;&nbsp;
                    <a href="hotelpages/restauranthotel/commanderestauranthotel/facture_commande_pdf.php?commande=<?php echo $recuser["id_facture_m"] ?>" target="_blank">
                        <span title="Imprimer la facture du client" alt="editer"><i class="glyphicon glyphicon-print"></i></span>
                    </a>
                    <?php
                }
                ?>
            </td>
        </tr>

        <?php
    }
}

function lister_facture_commande_restaurant_ligne($fact, $con) {
    $rsltuser = $con->query("select * from hotel_ligne_commande_bar as l left join hotel_magasin_bar as mr on "
            . "l.id_magasin_bar=mr.id_magasin_bar left join hotel_article as m on mr.id_article=m.id_article "
            . "left join hotel_categorie as c on m.id_categorie=c.id_categorie where "
            . "l.id_commande_bar='" . $fact . "'") or die(mysqli_error($con));
//    $row = mysqli_fetch_assoc($rslt);
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        ?>

        <tr >
            <td><?php print nl2br(htmlspecialchars($recuser["code_article"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["libelle_article"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["libelle_categorie"])) ?></td>
            <td>
                <?php print nl2br(htmlspecialchars($recuser["stock_ligne_cb"])) ?> 
            </td>
            <td><?php print nl2br(htmlspecialchars($recuser["prix_ligne_cb"])) ?></td>
            <td><?php echo $recuser["stock_ligne_cb"] * $recuser["prix_ligne_cb"] ?></td>
        </tr>

        <?php
    }
}

//gestion des Personnels
//fonction pour ajouter un Personnel
function ajouter_personnel($nomp, $prenomp, $emailp, $telp, $pointap, $servpa, $con) {
    $req = $con->query("select * from hotel_personnel where email_pe= '" . $emailp . "'") or die(mysqli_error($con));
    $nb = mysqli_num_rows($req);
    $but = "Recrutement";
    if (($nb == 0)) {
        $reqs = $con->query("select * from service_point_hotel as sph left join hotel_service as s on "
                . "sph.id_service=s.id_servise where sph.id_service_point_hotel= '" . $servpa . "'") 
                or die(mysqli_error($con));
    $rows = mysqli_fetch_assoc($reqs);
    $co=$rows["code_service"];
        $numid = strtoupper(substr($co, 0, 2)) . sprintf("%04d", 1);
        $req1 = $con->query("select * from hotel_personnel ") or die(mysqli_error($con));
        $i = 0;
        while ($reqte = mysqli_fetch_assoc($req1)) {
            $i = $reqte["id_personnel"];
        }
        $i = $i + 1;
        $numid = strtoupper(substr($co, 0, 2)) . sprintf("%04d", $i);
        $rslt = $con->query("insert into hotel_personnel(nom_pe, prenom_pe, tel_pe, email_pe, code_pe, date_insertion_pe) "
                . "values('" . $nomp . "', '" . $prenomp . "','" . $telp . "', '" . $emailp . "', '" . $numid . "', NOW())")
                or die(mysqli_error($con));
        $resultat2 = $con->query("SELECT * FROM hotel_personnel where email_pe='" . $emailp . "'") or die(mysqli_error($con));
        $row2 = mysqli_fetch_assoc($resultat2);
        $rsltaf = $con->query("insert into hotel_affectation(id_point_hotel, id_service_point_hotel, id_personnel, date_affectation, but) "
                . "values('" . $pointap . "', '" . $servpa . "', '" . $row2["id_personnel"] . "',NOW(),'" . $but . "')") or die(mysqli_error($con));
        echo "<script language='javascript'>$('div.alertuseraddbon').show('slow').delay(8000).hide('slow');</script>";
    } else {
        echo "<script language='javascript'>$('div.alertaddmauv').show('slow').delay(8000).hide('slow');</script>";
    }
}

//fonction pour ajouter compte a un Personnel
function ajouter_compte($idpers, $loginp, $pas1, $con) {
    $req = $con->query("select * from hotel_proprietaire where login_p= '" . $loginp . "' or password_p= '" . $pas1 . "'") or die(mysqli_error($con));
    $nb = mysqli_num_rows($req);
    $reqc = $con->query("select * from hotel_compte_client where login_cl= '" . $loginp . "' or password_cl= '" . $pas1 . "'") or die(mysqli_error($con));
    $nbc = mysqli_num_rows($reqc);
    $reqp = $con->query("select * from hotel_compte_personnel where login_pe= '" . $loginp . "' or password_pe= '" . $pas1 . "'") or die(mysqli_error($con));
    $nbp = mysqli_num_rows($reqp);

    $reqem = $con->query("select * from hotel_compte_personnel where id_personnel= '" . $idpers . "'") or die(mysqli_error($con));
    $nbem = mysqli_num_rows($reqem);
    if (($nb == 0) && ($nbem == 0) && ($nbc == 0) && ($nbp == 0)) {
        $rslt = $con->query("insert into hotel_compte_personnel(id_personnel, login_pe, password_pe, date_personnel) "
                . "values('" . $idpers . "', '" . $loginp . "','" . $pas1 . "', NOW())") or die(mysqli_error($con));
        echo "<script language='javascript'>$('div.alertuseraddbon').show('slow').delay(8000).hide('slow');</script>";
    } else {
        echo "<script language='javascript'>$('div.alertaddmauv').show('slow').delay(8000).hide('slow');</script>";
    }
}

//fonction pour lister les Personnels
function lister_personnel($con) {
    $rsltuser = $con->query("select * from hotel_personnel as pe left join hotel_affectation as af on "
            . "pe.id_personnel=af.id_personnel left join service_point_hotel as spa on "
            . "af.id_service_point_hotel=spa.id_service_point_hotel left join hotel_point_hotel as pa on "
            . "spa.id_point_hotel=pa.id_point_hotel left join hotel_service as s on spa.id_service=s.id_service "
            . "where pa.id_proprietaire='" . $_SESSION["id_proprietaire"] . "' and af.etat_affectation=true ") or die(mysqli_error($con));
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        $rsltcompte = $con->query('select * from hotel_compte_personnel where id_personnel=' . $recuser['id_personnel'] . '') or die(mysqli_error($con));
        $nbcompte = mysqli_num_rows($rsltcompte);
        ?>

        <tr >
            <td><?php print nl2br(htmlspecialchars($recuser["code_pe"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["nom_pe"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["prenom_pe"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["tel_pe"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["email_pe"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["nom_ph"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["nom_service"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["date_insertion_pe"])) ?></td>
            <td>
                <?php
                if (isset($_SESSION["loginproprietaire"])) {
                    if ($nbcompte == 0) {
                        ?>&nbsp;&nbsp;
                        <a href="indexproprietaire.php?page=<?php echo base64_encode('hotelpages/personnelhotel/ajouter_compte') ?>&personnel=<?php echo $recuser["id_personnel"] ?>">
                            <span title="Attribuer un Compte" alt="editer"><i class="glyphicon glyphicon-plus"></i></span>
                        </a>
                        <?php
                    } else {
                        $rowcompte = mysqli_fetch_assoc($rsltcompte);
                        print nl2br(htmlspecialchars($rowcompte["login_pe"]));
                        if ($rowcompte['etat_personnel']) {
                            ?>&nbsp;&nbsp;
                            <a href='#' onclick=desactive_compte_pers(<?php echo $rowcompte["id_compte_personnel"] ?>)>
                                <span title="D&eacute;sactiver ce Compte" alt="desactiver"><i class="glyphicon glyphicon-check"></i></span>
                            </a>
                            <?php
                        } else {
                            ?>
                            &nbsp;&nbsp;
                            <a href='#' onclick=active_compte_pers(<?php echo $rowcompte["id_compte_personnel"] ?>)>
                                <span title="Activer ce Compte" alt="activer"><i class="glyphicon glyphicon-remove"></i></span>
                            </a>
                            <?php
                        }
                    }
                } else {
                    ?>
                    <?php
                }
                ?>
            </td>
            <td>
                <?php
                if (isset($_SESSION["loginproprietaire"])) {
                    ?>
                    <a href="indexproprietaire.php?page=<?php echo base64_encode('hotelpages/personnelhotel/editer_personnel') ?>&personnel=<?php echo $recuser["id_personnel"] ?>">
                        <span title="Modifier un Personnel" alt="editer"><i class="glyphicon glyphicon-edit"></i></span>
                    </a>&nbsp;&nbsp;
                    <a href="indexproprietaire.php?page=<?php echo base64_encode('hotelpages/personnelhotel/lister_affectation_personnel') ?>&personnel=<?php echo $recuser["id_personnel"] ?>">
                        <span title="Lister les affectations de ce Personnel" alt="listaffecter"><i class="glyphicon glyphicon-send"></i></span>
                    </a>&nbsp;&nbsp;
                    <a href="indexproprietaire.php?page=<?php echo base64_encode('hotelpages/parcautohotel/parcautopersonnelhotel/lister_parcauto_personnel') ?>&personnel=<?php echo $recuser["id_personnel"] ?>">
                        <span title="Gerer le parc auto de ce Personnel" alt="parcauto"><i class="fa fa-car"></i></span>
                    </a>
                    <?php
                    if ($nbcompte != 0) {
                        if ($recuser["code_service"] == "RESTO") {
                            $reqrest = $con->query("select * from hotel_restaurant as r left join utilisateur_rest as u on r.id_restaurant=u.id_restaurant "
                                    . "where u.id_personnel='" . $recuser["id_personnel"] . "'") or die(mysqli_error($con));
                            $nbrest = mysqli_num_rows($reqrest);
                            if ($nbrest != 0) {
                                $rowrest = mysqli_fetch_assoc($reqrest);
//                                
                                ?>&nbsp;&nbsp;
                                <a href="indexproprietaire.php?page=<?php echo base64_encode('hotelpages/personnelhotel/personnel_resto_edit') ?>&personnel=<?php echo $recuser["id_personnel"] ?>&restaurant=<?php echo $rowrest["id_restaurant"] ?>">
                                    <?php
                                    print nl2br(htmlspecialchars($rowrest["nom_rest"]));
//                                
                                    ?>
                                </a>
                                <?php
                            } else {
                                ?>&nbsp;&nbsp;
                                <a href="indexproprietaire.php?page=<?php echo base64_encode('hotelpages/personnelhotel/personnel_resto') ?>&personnel=<?php echo $recuser["id_personnel"] ?>">
                                    <span title="Choisir un restaurant" alt="resto"><i class="glyphicon glyphicon-home"></i></span>
                                </a>
                                <?php
                            }
                        }
                        if ($recuser["code_service"] == "BAR") {
                            $reqrest = $con->query("select * from hotel_bar as r left join utilisateur_bar as u on r.id_bar=u.id_bar "
                                    . "where u.id_personnel='" . $recuser["id_personnel"] . "'") or die(mysqli_error($con));
                            $nbrest = mysqli_num_rows($reqrest);
                            if ($nbrest != 0) {
                                $rowrest = mysqli_fetch_assoc($reqrest);
//                                
                                ?>&nbsp;&nbsp;
                                <a href="indexproprietaire.php?page=<?php echo base64_encode('hotelpages/personnelhotel/personnel_bar_edit') ?>&personnel=<?php echo $recuser["id_personnel"] ?>&bar=<?php echo $rowrest["id_bar"] ?>">
                                    <?php
                                    print nl2br(htmlspecialchars($rowrest["nom_bar"]));
//                                
                                    ?>
                                </a>
                                <?php
                            } else {
                                ?>&nbsp;&nbsp;
                                <a href="indexproprietaire.php?page=<?php echo base64_encode('hotelpages/personnelhotel/personnel_bar') ?>&personnel=<?php echo $recuser["id_personnel"] ?>">
                                    <span title="Choisir un bar" alt="bar"><i class="glyphicon glyphicon-home"></i></span>
                                </a>
                                <?php
                            }
                        }
                        if ($recuser["code_service"] == "BARESTO") {
                            $reqrest = $con->query("select * from hotel_restaurant as r left join utilisateur_rest as u on r.id_restaurant=u.id_restaurant "
                                    . "where u.id_personnel='" . $recuser["id_personnel"] . "'") or die(mysqli_error($con));
                            $nbrest = mysqli_num_rows($reqrest);
                            if ($nbrest != 0) {
                                $rowrest = mysqli_fetch_assoc($reqrest);
//                                
                                ?>&nbsp;&nbsp;
                                <a href="indexproprietaire.php?page=<?php echo base64_encode('hotelpages/personnelhotel/personnel_resto_edit') ?>&personnel=<?php echo $recuser["id_personnel"] ?>&restaurant=<?php echo $rowrest["id_restaurant"] ?>">
                                    <?php
                                    print nl2br(htmlspecialchars($rowrest["nom_rest"]));
//                                
                                    ?>
                                </a>
                                <?php
                            } else {
                                ?>&nbsp;&nbsp;
                                <a href="indexproprietaire.php?page=<?php echo base64_encode('hotelpages/personnelhotel/personnel_resto') ?>&personnel=<?php echo $recuser["id_personnel"] ?>">
                                    <span title="Choisir un restaurant" alt="resto"><i class="glyphicon glyphicon-home"></i></span>
                                </a>
                                <?php
                            }
                            
                            $reqrestb = $con->query("select * from hotel_bar as r left join utilisateur_bar as u on r.id_bar=u.id_bar "
                                    . "where u.id_personnel='" . $recuser["id_personnel"] . "'") or die(mysqli_error($con));
                            $nbrestb = mysqli_num_rows($reqrestb);
                            if ($nbrestb != 0) {
                                $rowrestb = mysqli_fetch_assoc($reqrestb);
//                                
                                ?>&nbsp;&nbsp;
                                <a href="indexproprietaire.php?page=<?php echo base64_encode('hotelpages/personnelhotel/personnel_bar_edit') ?>&personnel=<?php echo $recuser["id_personnel"] ?>&bar=<?php echo $rowrestb["id_bar"] ?>">
                                    <?php
                                    print nl2br(htmlspecialchars($rowrestb["nom_bar"]));
//                                
                                    ?>
                                </a>
                                <?php
                            } else {
                                ?>&nbsp;&nbsp;
                                <a href="indexproprietaire.php?page=<?php echo base64_encode('hotelpages/personnelhotel/personnel_bar') ?>&personnel=<?php echo $recuser["id_personnel"] ?>">
                                    <span title="Choisir un bar" alt="bar"><i class="glyphicon glyphicon-home"></i></span>
                                </a>
                                <?php
                            }
                        }
                    }
                    ?>
                    &nbsp;&nbsp;
                    <a href='#' onclick=del_personnel(<?php echo $recuser["id_personnel"] ?>)>
                        <span title="Supprimer un Point d'Agence" alt="suppr"><i class="glyphicon glyphicon-remove"></i></span>
                    </a>
                    <?php
                } else {
                    ?>
                    <?php
                }
                ?>

            </td>
        </tr>

        <?php
    }
}

//fonction pour lister les Personnels
function lister_personnel_c($con) {
    $codes = "RECEP";
    $rsltuser = $con->query("select * from hotel_personnel as pe left join hotel_affectation as af on "
            . "pe.id_personnel=af.id_personnel left join service_point_hotel as spa on "
            . "af.id_service_point_hotel=spa.id_service_point_hotel left join hotel_point_hotel as pa on "
            . "spa.id_point_hotel=pa.id_point_hotel left join hotel_service as s on spa.id_service=s.id_service where "
            . "pa.id_proprietaire='" . $_SESSION["id_proprietaire"] . "' and s.code_service='" . $codes . "' and af.etat_affectation=true ") or die(mysqli_error($con));
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        $rsltcompte = $con->query('select * from hotel_compte_personnel where id_personnel=' . $recuser['id_personnel'] . '') or die(mysqli_error($con));
        $nbcompte = mysqli_num_rows($rsltcompte);
        ?>

        <tr >
            <td><?php print nl2br(htmlspecialchars($recuser["nom_pe"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["prenom_pe"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["tel_pe"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["email_pe"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["nom_service"])) ?></td>
            <td>
                <a href="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/personnelhotel/versementhotel/versement') ?>&personnel=<?php echo $recuser["id_personnel"] ?>">
                    <span title="Effectuer un versement" alt="vers"><i class="glyphicon glyphicon-download-alt"></i></span>
                </a>
            </td>
        </tr>

        <?php
    }
}

//fonction pour modifier un Personnel
function editer_personnel($id, $nomp, $prenomp, $emailp, $telp, $pointap, $servpa, $con) {
    $req = $con->query("select * from hotel_personnel where email_pe= '" . $emailp . "'") or die(mysqli_error($con));
    $nb = mysqli_num_rows($req);
    if (($nb == 0)) {
        $rslt = $con->query("update hotel_personnel set nom_pe='" . $nomp . "', prenom_pe='" . $prenomp . "', "
                . "tel_pe='" . $telp . "', email_pe='" . $emailp . "' where id_personnel='" . $id . "'") or die(mysqli_error($con));

        $rsltaf = $con->query("update hotel_affectation set id_point_hotel='" . $pointap . "', "
                . "id_service_point_hotel='" . $servpa . "' where id_personnel='" . $id . "' and "
                . "etat_affectation=true") or die(mysqli_error($con));
        echo "<script language='javascript'>$('div.alertmodifbon').show('slow').delay(8000).hide('slow');</script>";
    } else {
        $recuser = mysqli_fetch_array($req);
        if ($id == $recuser["id_personnel"]) {
            $rslt = $con->query("update hotel_personnel set nom_pe='" . $nomp . "', prenom_pe='" . $prenomp . "', "
                    . "tel_pe='" . $telp . "', email_pe='" . $emailp . "' where id_personnel='" . $id . "'") or die(mysqli_error($con));

            $rsltaf = $con->query("update hotel_affectation set id_point_hotel='" . $pointap . "', "
                    . "id_service_point_hotel='" . $servpa . "' where id_personnel='" . $id . "' and "
                    . "etat_affectation=true") or die(mysqli_error($con));
            echo "<script language='javascript'>$('div.alertmodifbon').show('slow').delay(8000).hide('slow');</script>";
        } else {
            echo "<script language='javascript'>$('div.alertaddmauv').show('slow').delay(8000).hide('slow');</script>";
        }
    }
}

//fonction pour affecter un Personnel
function affecter_personnel($id, $pointapa, $servpaa, $pointap, $servpa, $con) {
//    echo "<script language='javascript'>alert('ollll')</script>";
   if (($pointapa != $pointap)|| ($servpaa != $servpa)) {
//        echo "<script language='javascript'>alert($pointapa)</script>";
    $but = "Affectation";
//    $etaaf = 0;
    $eta = FALSE;
        $rsltaf = $con->query("insert into hotel_affectation(id_point_hotel, id_service_point_hotel, id_personnel, date_affectation, but) "
                . "values('" . $pointap . "', '" . $servpa . "', '" . $id . "',NOW(),'" . $but . "')") or die(mysqli_error($con));
        $rsltafa = $con->query("update hotel_affectation set etat_affectation='" . $eta . "' where "
                . "id_point_hotel='" . $pointapa . "' and id_service_point_hotel='" . $servpaa . "' and "
                . "id_personnel='" . $id . "' and etat_affectation=true") or die(mysqli_error($con));
        echo "<script language='javascript'>$('div.alertaffectbon').show('slow').delay(8000).hide('slow');</script>";
    } else {
            echo "<script language='javascript'>$('div.alertaffectmauv').show('slow').delay(8000).hide('slow');</script>";
    }
}

//fonction pour lister les Personnels
function lister_affectation_personnel($id, $con) {
    $rsltuser = $con->query("select * from hotel_affectation as af left join hotel_personnel as pe "
            . "on pe.id_personnel=af.id_personnel left join service_point_hotel as spa on "
            . "af.id_service_point_hotel=spa.id_service_point_hotel left join hotel_point_hotel as pa on "
            . "spa.id_point_hotel=pa.id_point_hotel left join hotel_service as s on spa.id_service=s.id_service "
            . "where pa.id_proprietaire='" . $_SESSION["id_proprietaire"] . "' and af.id_personnel='" . $id . "' ") or die(mysqli_error($con));
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        $rsltcompte = $con->query('select * from hotel_compte_personnel where id_personnel=' . $recuser['id_personnel'] . '') or die(mysqli_error($con));
        $nbcompte = mysqli_num_rows($rsltcompte);
        ?>

        <tr >
            <td><?php print nl2br(htmlspecialchars($recuser["date_affectation"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["nom_ph"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["nom_service"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["etat_affectation"])) ?></td>
        </tr>

        <?php
    }
}

function ajouter_restopers($idpers, $rest, $i, $con) {
    for ($j = 0; $j < $i; $j++) {
        $req = $con->query("select * from utilisateur_rest where id_personnel= '" . $idpers . "' and id_restaurant= '" . $rest[$j] . "'") or die(mysqli_error($con));
        $nb = mysqli_num_rows($req);
        if (($nb == 0)) {
            $rslt = $con->query("insert into utilisateur_rest(id_personnel, id_restaurant) values('" . $idpers . "', "
                    . "'" . $rest[$j] . "')") or die(mysqli_error($con));
        } else {
            echo "<script language='javascript'>$('div.alertaddmauv').show('slow').delay(8000).hide('slow');</script>";
        }
    }
    echo "<script language='javascript'>$('div.alertuseraddbon').show('slow').delay(8000).hide('slow');</script>";
}

function editer_restopers($idpers, $rest, $idrest, $con) {
    $rslt = $con->query("update utilisateur_rest set id_restaurant='" . $rest . "' where "
            . "id_restaurant='" . $idrest . "' and id_personnel='" . $idpers . "'") or die(mysqli_error($con));

    echo "<script language='javascript'>$('div.alertmodifbon').show('slow').delay(8000).hide('slow');</script>";
}

function ajouter_barpers($idpers, $rest, $i, $con) {
    for ($j = 0; $j < $i; $j++) {
        $req = $con->query("select * from utilisateur_bar where id_personnel= '" . $idpers . "' and id_bar= '" . $rest[$j] . "'") or die(mysqli_error($con));
        $nb = mysqli_num_rows($req);
        if (($nb == 0)) {
            $rslt = $con->query("insert into utilisateur_bar(id_personnel, id_bar) values('" . $idpers . "', "
                    . "'" . $rest[$j] . "')") or die(mysqli_error($con));
        } else {
            echo "<script language='javascript'>$('div.alertaddmauv').show('slow').delay(8000).hide('slow');</script>";
        }
    }
    echo "<script language='javascript'>$('div.alertuseraddbon').show('slow').delay(8000).hide('slow');</script>";
}

function editer_barpers($idpers, $rest, $idrest, $con) {
    $rslt = $con->query("update utilisateur_bar set id_bar='" . $rest . "' where "
            . "id_bar='" . $idrest . "' and id_personnel='" . $idpers . "'") or die(mysqli_error($con));

    echo "<script language='javascript'>$('div.alertmodifbon').show('slow').delay(8000).hide('slow');</script>";
}

function update_profil($nom, $prenom, $email, $tel, $login, $motdepasse1, $con) {
    $reqpe = $con->query("select * from hotel_compte_personnel where id_compte_personnel= '" . $_SESSION["id_compte_personnel"] . "' ") or die(mysqli_error($con));
    $rowpe = mysqli_fetch_assoc($reqpe);
    $reqp = $con->query("select * from hotel_compte_personnel where login_pe= '" . $login . "' or password_pe= '" . sha1($motdepasse1) . "'") or die(mysqli_error($con));
    $nbp = mysqli_num_rows($reqp);
    if (($nbp == 0)) {
        $req = $con->query("select * from hotel_proprietaire where login_p= '" . $login . "' or password_p= '" . sha1($motdepasse1) . "'") or die(mysqli_error($con));
        $nb = mysqli_num_rows($req);
        if (($nb == 0)) {
            $reqc = $con->query("select * from hotel_compte_client where login_cl= '" . $login . "' or password_cl= '" . sha1($motdepasse1) . "'") or die(mysqli_error($con));
            $nbc = mysqli_num_rows($reqc);
            if (($nbc == 0)) {
                $reqem = $con->query("select * from hotel_personnel where email_pe= '" . $email . "' ") or die(mysqli_error($con));
                $nbem = mysqli_num_rows($reqem);
                if (($nbem == 0)) {
                    if ($motdepasse1 == NULL) {
                        $rsltp = $con->query("update hotel_personnel set nom_pe='" . $nom . "',prenom_pe='" . $prenom . "',"
                                . "email_pe='" . $email . "',tel_pe='" . $tel . "' where id_personnel='" . $rowpe["id_personnel"] . "'") or die(mysqli_error($con));

                        $rsltc = $con->query("update hotel_compte_personnel set login_pe='" . $login . "' where id_compte_personnel= '" . $_SESSION["id_compte_personnel"] . "'") or die(mysqli_error($con));

                        $_SESSION["nom_personnel"] = $nom;
                        $_SESSION["prenom_personnel"] = $prenom;
                        $_SESSION["login_personnel"] = $login;
                        $_SESSION["telephone_personnel"] = $tel;
                        $_SESSION["email_personnel"] = $email;
                        echo "<script language='javascript'>$('div.alertmodifbon').show('slow').delay(8000).hide('slow');</script>";
                    } else {
                        $rsltp = $con->query("update hotel_personnel set nom_pe='" . $nom . "',prenom_pe='" . $prenom . "',"
                                . "email_pe='" . $email . "',tel_pe='" . $tel . "' where id_personnel='" . $rowpe["id_personnel"] . "'") or die(mysqli_error($con));

                        $rsltc = $con->query("update hotel_compte_personnel set login_pe='" . $login . "',password_pe='" . sha1($motdepasse1) . "' where id_compte_personnel= '" . $_SESSION["id_compte_personnel"] . "'") or die(mysqli_error($con));

                        $_SESSION["nom_personnel"] = $nom;
                        $_SESSION["prenom_personnel"] = $prenom;
                        $_SESSION["login_personnel"] = $login;
                        $_SESSION["mot_de_passe_personnel"] = sha1($motdepasse1);
                        $_SESSION["telephone_personnel"] = $tel;
                        $_SESSION["email_personnel"] = $email;

                        echo "<script language='javascript'>$('div.alertmodifbon').show('slow').delay(8000).hide('slow');</script>";
                    }
                } else {
                    $rowem = mysqli_fetch_assoc($reqem);
                    if (($rowem["id_personnel"] == $rowpe["id_personnel"])) {
                        if ($motdepasse1 == NULL) {
                            $rsltp = $con->query("update hotel_personnel set nom_pe='" . $nom . "',prenom_pe='" . $prenom . "',"
                                    . "email_pe='" . $email . "',tel_pe='" . $tel . "' where id_personnel='" . $rowpe["id_personnel"] . "'") or die(mysqli_error($con));

                            $rsltc = $con->query("update hotel_compte_personnel set login_pe='" . $login . "' where id_compte_personnel= '" . $_SESSION["id_compte_personnel"] . "'") or die(mysqli_error($con));

                            $_SESSION["nom_personnel"] = $nom;
                            $_SESSION["prenom_personnel"] = $prenom;
                            $_SESSION["login_personnel"] = $login;
                            $_SESSION["telephone_personnel"] = $tel;
                            $_SESSION["email_personnel"] = $email;
                            echo "<script language='javascript'>$('div.alertmodifbon').show('slow').delay(8000).hide('slow');</script>";
                        } else {
                            $rsltp = $con->query("update hotel_personnel set nom_pe='" . $nom . "',prenom_pe='" . $prenom . "',"
                                    . "email_pe='" . $email . "',tel_pe='" . $tel . "' where id_personnel='" . $rowpe["id_personnel"] . "'") or die(mysqli_error($con));

                            $rsltc = $con->query("update hotel_compte_personnel set login_pe='" . $login . "',password_pe='" . sha1($motdepasse1) . "' where id_compte_personnel= '" . $_SESSION["id_compte_personnel"] . "'") or die(mysqli_error($con));

                            $_SESSION["nom_personnel"] = $nom;
                            $_SESSION["prenom_personnel"] = $prenom;
                            $_SESSION["login_personnel"] = $login;
                            $_SESSION["mot_de_passe_personnel"] = sha1($motdepasse1);
                            $_SESSION["telephone_personnel"] = $tel;
                            $_SESSION["email_personnel"] = $email;

                            echo "<script language='javascript'>$('div.alertmodifbon').show('slow').delay(8000).hide('slow');</script>";
                        }
                    } else {
                        echo "<script language='javascript'>$('div.alertaddmauv').show('slow').delay(8000).hide('slow');</script>";
                    }
                }
            } else {
                echo "<script language='javascript'>$('div.alertaddmauv').show('slow').delay(8000).hide('slow');</script>";
            }
        } else {
            echo "<script language='javascript'>$('div.alertaddmauv').show('slow').delay(8000).hide('slow');</script>";
        }
    } else {
        $recuser = mysqli_fetch_array($reqp);
        if (($recuser["id_compte_personnel"] == $_SESSION["id_compte_personnel"])) {
            if ($motdepasse1 == NULL) {
                $rsltp = $con->query("update hotel_personnel set nom_pe='" . $nom . "',prenom_pe='" . $prenom . "',"
                        . "email_pe='" . $email . "',tel_pe='" . $tel . "' where id_personnel='" . $rowpe["id_personnel"] . "'") or die(mysqli_error($con));

                $rsltc = $con->query("update hotel_compte_personnel set login_pe='" . $login . "' where id_compte_personnel= '" . $_SESSION["id_compte_personnel"] . "'") or die(mysqli_error($con));

                $_SESSION["nom_personnel"] = $nom;
                $_SESSION["prenom_personnel"] = $prenom;
                $_SESSION["login_personnel"] = $login;
                $_SESSION["telephone_personnel"] = $tel;
                $_SESSION["email_personnel"] = $email;
                echo "<script language='javascript'>$('div.alertmodifbon').show('slow').delay(8000).hide('slow');</script>";
            } else {
                $rsltp = $con->query("update hotel_personnel set nom_pe='" . $nom . "',prenom_pe='" . $prenom . "',"
                        . "email_pe='" . $email . "',tel_pe='" . $tel . "' where id_personnel='" . $rowpe["id_personnel"] . "'") or die(mysqli_error($con));

                $rsltc = $con->query("update hotel_compte_personnel set login_pe='" . $login . "',password_pe='" . sha1($motdepasse1) . "' where id_compte_personnel= '" . $_SESSION["id_compte_personnel"] . "'") or die(mysqli_error($con));

                $_SESSION["nom_personnel"] = $nom;
                $_SESSION["prenom_personnel"] = $prenom;
                $_SESSION["login_personnel"] = $login;
                $_SESSION["mot_de_passe_personnel"] = sha1($motdepasse1);
                $_SESSION["telephone_personnel"] = $tel;
                $_SESSION["email_personnel"] = $email;

                echo "<script language='javascript'>$('div.alertmodifbon').show('slow').delay(8000).hide('slow');</script>";
            }
        } else {
            echo "<script language='javascript'>$('div.alertaddmauv').show('slow').delay(8000).hide('slow');</script>";
        }
    }
}

function update_profil_pro($nom, $prenom, $email, $tel, $login, $motdepasse1, $con) {
    $reqp = $con->query("select * from hotel_proprietaire where login_p= '" . $login . "' or password_p= '" . sha1($motdepasse1) . "'") or die(mysqli_error($con));
    $nbp = mysqli_num_rows($reqp);
    if (($nbp == 0)) {
        $req = $con->query("select * from hotel_compte_personnel where login_pe= '" . $login . "' or password_pe= '" . sha1($motdepasse1) . "'") or die(mysqli_error($con));
        $nb = mysqli_num_rows($req);
        if (($nb == 0)) {
            $reqc = $con->query("select * from hotel_compte_client where login_cl= '" . $login . "' or password_cl= '" . sha1($motdepasse1) . "'") or die(mysqli_error($con));
            $nbc = mysqli_num_rows($reqc);
            if (($nbc == 0)) {
                $reqem = $con->query("select * from hotel_proprietaire where email_p= '" . $email . "' ") or die(mysqli_error($con));
                $nbem = mysqli_num_rows($reqem);
                if (($nbem == 0)) {
                    if ($motdepasse1 == NULL) {
                        $rsltp = $con->query("update hotel_proprietaire set nom_p='" . $nom . "',prenom_p='" . $prenom . "',"
                                . "email_p='" . $email . "',tel_p='" . $tel . "', login_p='" . $login . "' where id_proprietaire='" . $_SESSION["id_proprietaire"] . "'") or die(mysqli_error($con));

                        $_SESSION["nom_proprietaire"] = $nom;
                        $_SESSION["prenom_proprietaire"] = $prenom;
                        $_SESSION["telephone_proprietaire"] = $tel;
                        $_SESSION["loginproprietaire"] = $login;
                        $_SESSION["email_proprietaire"] = $email;
                        echo "<script language='javascript'>$('div.alertmodifbon').show('slow').delay(8000).hide('slow');</script>";
                    } else {
                        $rsltp = $con->query("update hotel_proprietaire set nom_p='" . $nom . "',prenom_p='" . $prenom . "',"
                                . "email_p='" . $email . "',tel_p='" . $tel . "', login_p='" . $login . "' ,"
                                . "password_p='" . sha1($motdepasse1) . "' where id_proprietaire='" . $_SESSION["id_proprietaire"] . "'") or die(mysqli_error($con));

                        $_SESSION["nom_proprietaire"] = $nom;
                        $_SESSION["prenom_proprietaire"] = $prenom;
                        $_SESSION["telephone_proprietaire"] = $tel;
                        $_SESSION["loginproprietaire"] = $login;
                        $_SESSION["motdepasseproprietaire"] = sha1($motdepasse1);
                        $_SESSION["email_proprietaire"] = $email;

                        echo "<script language='javascript'>$('div.alertmodifbon').show('slow').delay(8000).hide('slow');</script>";
                    }
                } else {
                    $rowem = mysqli_fetch_assoc($reqem);
                    if (($rowem["id_proprietaire"] == $_SESSION["id_proprietaire"])) {
                        if ($motdepasse1 == NULL) {
                            $rsltp = $con->query("update hotel_proprietaire set nom_p='" . $nom . "',prenom_p='" . $prenom . "',"
                                    . "email_p='" . $email . "',tel_p='" . $tel . "', login_p='" . $login . "' where id_proprietaire='" . $_SESSION["id_proprietaire"] . "'") or die(mysqli_error($con));

                            $_SESSION["nom_proprietaire"] = $nom;
                            $_SESSION["prenom_proprietaire"] = $prenom;
                            $_SESSION["telephone_proprietaire"] = $tel;
                            $_SESSION["loginproprietaire"] = $login;
                            $_SESSION["email_proprietaire"] = $email;
                            echo "<script language='javascript'>$('div.alertmodifbon').show('slow').delay(8000).hide('slow');</script>";
                        } else {
                            $rsltp = $con->query("update hotel_proprietaire set nom_p='" . $nom . "',prenom_p='" . $prenom . "',"
                                    . "email_p='" . $email . "',tel_p='" . $tel . "', login_p='" . $login . "' ,"
                                    . "password_p='" . sha1($motdepasse1) . "' where id_proprietaire='" . $_SESSION["id_proprietaire"] . "'") or die(mysqli_error($con));

                            $_SESSION["nom_proprietaire"] = $nom;
                            $_SESSION["prenom_proprietaire"] = $prenom;
                            $_SESSION["telephone_proprietaire"] = $tel;
                            $_SESSION["loginproprietaire"] = $login;
                            $_SESSION["motdepasseproprietaire"] = sha1($motdepasse1);
                            $_SESSION["email_proprietaire"] = $email;

                            echo "<script language='javascript'>$('div.alertmodifbon').show('slow').delay(8000).hide('slow');</script>";
                        }
                    } else {
                        echo "<script language='javascript'>$('div.alertaddmauv').show('slow').delay(8000).hide('slow');</script>";
                    }
                }
            } else {
                echo "<script language='javascript'>$('div.alertaddmauv').show('slow').delay(8000).hide('slow');</script>";
            }
        } else {
            echo "<script language='javascript'>$('div.alertaddmauv').show('slow').delay(8000).hide('slow');</script>";
        }
    } else {
        $recuser = mysqli_fetch_array($reqp);
        if (($recuser["id_proprietaire"] == $_SESSION["id_proprietaire"])) {
            if ($motdepasse1 == NULL) {
                $rsltp = $con->query("update hotel_proprietaire set nom_p='" . $nom . "',prenom_p='" . $prenom . "',"
                        . "email_p='" . $email . "',tel_p='" . $tel . "', login_p='" . $login . "' where id_proprietaire='" . $_SESSION["id_proprietaire"] . "'") or die(mysqli_error($con));

                $_SESSION["nom_proprietaire"] = $nom;
                $_SESSION["prenom_proprietaire"] = $prenom;
                $_SESSION["telephone_proprietaire"] = $tel;
                $_SESSION["loginproprietaire"] = $login;
                $_SESSION["email_proprietaire"] = $email;
                echo "<script language='javascript'>$('div.alertmodifbon').show('slow').delay(8000).hide('slow');</script>";
            } else {
                $rsltp = $con->query("update hotel_proprietaire set nom_p='" . $nom . "',prenom_p='" . $prenom . "',"
                        . "email_p='" . $email . "',tel_p='" . $tel . "', login_p='" . $login . "' ,"
                        . "password_p='" . sha1($motdepasse1) . "' where id_proprietaire='" . $_SESSION["id_proprietaire"] . "'") or die(mysqli_error($con));

                $_SESSION["nom_proprietaire"] = $nom;
                $_SESSION["prenom_proprietaire"] = $prenom;
                $_SESSION["telephone_proprietaire"] = $tel;
                $_SESSION["loginproprietaire"] = $login;
                $_SESSION["motdepasseproprietaire"] = sha1($motdepasse1);
                $_SESSION["email_proprietaire"] = $email;

                echo "<script language='javascript'>$('div.alertmodifbon').show('slow').delay(8000).hide('slow');</script>";
            }
        } else {
            echo "<script language='javascript'>$('div.alertaddmauv').show('slow').delay(8000).hide('slow');</script>";
        }
    }
}

//
function ajouter_versement($res, $con) {
    if (($res != NULL) && isset($res["1"])) {
        $date = date('Y-m-d');
        $etatres = "En Cours";
        $rsltcr = $con->query("select * from hotel_compte_personnel as c left join hotel_personnel as p on "
                . "c.id_personnel=p.id_personnel where c.id_personnel='" . $res["1"]['personnel'] . "' ") or die(mysqli_error($con));
        $reccr = mysqli_fetch_assoc($rsltcr);

        $rsltc = $con->query("select * from hotel_caisse where receptionniste_c='" . $reccr["id_compte_personnel"] . "' and "
                . "DATE(date_caisse)='" . $date . "' ") or die(mysqli_error($con));
        $nbc = mysqli_num_rows($rsltc);
        if ($nbc == 0) {
            $op = "Versement";
            $bu = "Recette du jour";
            $rslt = $con->query("insert into hotel_caisse(caissier, receptionniste_c, montant_caisse, opperation, but, date_caisse) "
                    . "values('" . $_SESSION["id_compte_personnel"] . "','" . $reccr["id_compte_personnel"] . "','" . $res["1"]['montant'] . "', "
                    . "'" . $op . "', '" . $bu . "', NOW())") or die(mysqli_error($con));

            echo "<script language='javascript'>$('div.alertversbon').show('slow').delay(8000).hide('slow');</script>";
            $soe = $res["1"]['montant'];

            $rsltcr2 = $con->query("select * from hotel_compte_personnel as c left join hotel_personnel as p on "
                    . "c.id_personnel=p.id_personnel where c.id_compte_personnel='" . $_SESSION["id_compte_personnel"] . "' ") or die(mysqli_error($con));
            $reccr2 = mysqli_fetch_assoc($rsltcr2);

            $numero = $reccr["tel_pe"];
            if (strlen($numero) <= 9) {
                $numero = "237" . $numero;
            }
//            print_r($numero);
            $contenu = "M. /Mme. " . $reccr["nom_pe"] . " " . $reccr["prenom_pe"] . " Vous venez d'effectuer un versement de "
                    . "" . $soe . " FCFA dans la caisse de M. Mme " . $reccr2["nom_pe"] . " " . $reccr2["prenom_pe"];
            $smsObj = new Sender('martial_ngueto', 'nguetongueto@@1989', 'UB', $contenu, $numero, '1', '1');

//            print_r($contenu);
            try {
                //Envoyer le SMS
                $smsObj->Submit();
                $result = $smsObj->response;
                echo "<script language='javascript'>$('div.alertsmsbon').show('slow').delay(8000).hide('slow');</script>";
            } catch (Exception $e) {
                dd($e->getMessage());
            }
            $reqr = $con->query("select * from hotel_caisse where caissier= '" . $_SESSION["id_compte_personnel"] . "' order by date_caisse desc "
                    . "LIMIT 0,1") or die(mysqli_error($con));
            $rowr = mysqli_fetch_assoc($reqr);
            unset($_SESSION['formvoy']);
            ?>
                                                <!--            <a href="hotelpages/commandehotel/facture_commande_pdf.php?caisse=<?php echo $rowr["id_caisse"] ?>" class="btn btn-lg btn-success" target="_blank">
                                                                <span title="Imprimer cette facture" alt="editer"><i class="fa fa-file-pdf-o"></i> Impriner la facture</span>
                                                            </a>-->
            <?php
        } else {
            echo "<script language='javascript'>$('div.alertversdeja').show('slow').delay(8000).hide('slow');</script>";
//        include('pagestramsec/proprietairetramsec/voyagetramsec/lister_voyage.php');
        }
    } else {
        echo "<script language='javascript'>$('div.alertversvide').show('slow').delay(8000).hide('slow');</script>";
//        include('pagestramsec/proprietairetramsec/voyagetramsec/lister_voyage.php');
    }
}

function ajouter_decaissement($res, $con) {
    if (($res != NULL) && isset($res["1"])) {

        $op = "Décaissement";
        $rslt = $con->query("insert into hotel_caisse(caissier, montant_caisse, opperation, but, date_caisse) "
                . "values('" . $_SESSION["id_compte_personnel"] . "','" . $res["1"]['montant'] . "', "
                . "'" . $op . "', '" . $res["1"]['but'] . "', NOW())") or die(mysqli_error($con));

        echo "<script language='javascript'>$('div.alertdecaissebon').show('slow').delay(8000).hide('slow');</script>";

        unset($_SESSION['formdecaisse']);
    } else {
        echo "<script language='javascript'>$('div.alertversvide').show('slow').delay(8000).hide('slow');</script>";
//        include('pagestramsec/proprietairetramsec/voyagetramsec/lister_voyage.php');
    }
}

function caisse_proold($con) {
    $opev = "Versement";
    $opel = "Logement";
    $date = date('Y-m-d');
    $rsltuser = $con->query("select SUM(r.montant_reg) as prixc,pl.receptionniste, DATE(r.date_registre) as datereg "
            . "from hotel_registre_client as r left join hotel_paye_logement as pl on "
            . "r.id_paye_logement=pl.id_paye_logement where r.id_compte_personnel IS NOT NULL and "
            . "DATE(r.date_registre)<'" . $date . "' group by r.id_compte_personnel, DATE(r.date_registre) order by "
            . "r.date_registre desc") or die(mysqli_error($con));
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        $rsltc = $con->query("select * from hotel_caisse where receptionniste_c='" . $recuser["id_compte_personnel"] . "' "
                . "and DATE(date_caisse)='" . $recuser["datereg"] . "'") or die(mysqli_error($con));
        $recc = mysqli_fetch_assoc($rsltc);
        $rsltr = $con->query("select * from hotel_personnel as p left join hotel_compte_personnel as c on "
                . "p.id_personnel=c.id_personnel where c.id_compte_personnel='" . $recuser["id_compte_personnel"] . "'") or die(mysqli_error($con));
        $recr = mysqli_fetch_assoc($rsltr);
        $rsltfm = $con->query("select SUM(lm.qte_fmr*lm.prix_fmr) as prixm from hotel_ligne_m as lm left join hotel_facture_m "
                . "as f on lm.id_facture_m=f.id_facture_m where f.id_compte_personnel='" . $recuser["receptionniste"] . "' and "
                . "f.id_paye_logement IS NULL") or die(mysqli_error($con));
        $recfm = mysqli_fetch_assoc($rsltfm);
        $rsltfd = $con->query("select SUM(ld.qte_fd*ld.prix_fd) as prixd from hotel_ligne_d as ld left join hotel_facture_d as "
                . "f on ld.id_facture_d=f.id_facture_d where f.id_compte_personnel='" . $recuser["receptionniste"] . "' and "
                . "f.id_paye_logement IS NULL") or die(mysqli_error($con));
        $recfd = mysqli_fetch_assoc($rsltfd);
        $dep = $recuser["prixc"] + $recfm["prixm"] + $recfd["prixd"];
        $diff = $dep - $recc["montant_caisse"];
        if ($diff > 0) {
            ?>
            <tr >
                <td><?php print nl2br(htmlspecialchars($recuser["datereg"])) ?></td>
                <td>
                    <?php print nl2br(htmlspecialchars($recr["nom_pe"])) ?> 
                    <?php print nl2br(htmlspecialchars($recr["prenom_pe"])) ?> 
                    <?php print nl2br(htmlspecialchars($recr["tel_pe"])) ?>
                </td>
                <td><?php print number_format($dep, 0, ',', ' ') ?></td>
                <td><?php print number_format($recc["montant_caisse"], 0, ',', ' ') ?></td>
                <td><?php print number_format($diff, 0, ',', ' ') ?></td>
                <td>
                    <a href="#">
                        <span title="R&eacute;gler ce versement" alt="vers"><i class="glyphicon glyphicon-download-alt"></i></span>
                    </a>
                </td>
            </tr>
            <?php
        }
    }
}

function caisse_pro($con) {
    $opev = "Versement";
    $opel = "Logement";
    $oped = "Divers";
    $date = date('Y-m-d');
    $rsltuser = $con->query("select SUM(r.montant_reg) as prixc, r.*,pl.receptionniste, DATE(r.date_registre) as datereg "
            . "from hotel_registre_client as r left join hotel_paye_logement as pl on "
            . "r.id_paye_logement=pl.id_paye_logement where (r.id_compte_personnel IS NOT NULL and "
            . "DATE(r.date_registre)<'" . $date . "') and (r.operation_reg='" . $opev . "' or "
            . "r.operation_reg='" . $oped . "' or r.operation_reg='" . $opel . "') group by r.id_compte_personnel, "
            . "DATE(r.date_registre) order by r.date_registre desc") or die(mysqli_error($con));
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        $rsltc = $con->query("select SUM(c.montant_caisse) as prixc, c.* from hotel_caisse as c where "
                . "c.receptionniste_c='" . $recuser["id_compte_personnel"] . "' and "
                . "DATE(c.date_caisse)='" . $recuser["datereg"] . "'") or die(mysqli_error($con));
        $recc = mysqli_fetch_assoc($rsltc);
        $rsltr = $con->query("select * from hotel_personnel as p left join hotel_compte_personnel as c on "
                . "p.id_personnel=c.id_personnel where c.id_compte_personnel='" . $recuser["id_compte_personnel"] . "'") or die(mysqli_error($con));
        $recr = mysqli_fetch_assoc($rsltr);

        $dep = $recuser["prixc"];
        $diff = $dep - $recc["prixc"];
        if ($diff > 0) {
            ?>
            <tr >
                <td><?php print nl2br(htmlspecialchars($recuser["datereg"])) ?></td>
                <td>
                    <?php print nl2br(htmlspecialchars($recr["nom_pe"])) ?> 
                    <?php print nl2br(htmlspecialchars($recr["prenom_pe"])) ?> 
                    <?php print nl2br(htmlspecialchars($recr["tel_pe"])) ?>
                </td>
                <td><?php print number_format($dep, 0, ',', ' ') ?></td>
                <td><?php print number_format($recc["montant_caisse"], 0, ',', ' ') ?></td>
                <td><?php print number_format($diff, 0, ',', ' ') ?></td>
                <td>
                    <a href='#' onclick=regle_versement_receptionniste(<?php echo $recuser["id_compte_personnel"] ?>)>
                        <span title="R&eacute;gler ce versement" alt="vers"><i class="glyphicon glyphicon-download-alt"></i></span>
                    </a>
                </td>
            </tr>
            <?php
        }
    }
}

//gestion des Menus
//fonction pour ajouter un Menu
function ajouter_menu($nomm1, $descm1, $con) {
    $nomm = addslashes($nomm1);
    $descm = addslashes($descm1);
    $req = $con->query("select * from hotel_menu where nom_m= '" . $nomm . "'") or die(mysqli_error($con));
    $nb = mysqli_num_rows($req);
    if (($nb == 0)) {
        $rslt = $con->query("insert into hotel_menu(nom_m, description_m, date_m) "
                . "values('" . $nomm . "', '" . $descm . "', NOW())") or die(mysqli_error($con));
        echo "<script language='javascript'>$('div.alertuseraddbon').show('slow').delay(8000).hide('slow');</script>";
    } else {
        echo "<script language='javascript'>$('div.alertaddmauv').show('slow').delay(8000).hide('slow');</script>";
    }
}

//fonction pour lister les Menus
function lister_menuold($con) {
    $rsltuser = $con->query('select * from hotel_menu') or die(mysqli_error($con));
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        ?>

        <tr >
            <td><?php print nl2br(htmlspecialchars($recuser["nom_m"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["description_m"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["date_m"])) ?></td>
            <td>
                <?php
                if (isset($_SESSION["loginproprietaire"])) {
                    ?>
                    <a href="indexproprietaire.php?page=<?php echo base64_encode('hotelpages/restaurantbarhotel/menuhotel/editer_menu') ?>&menu=<?php echo $recuser["id_menu"] ?>">
                        <span title="Modifier ce Menu" alt="editer"><i class="glyphicon glyphicon-edit"></i></span>
                    </a>&nbsp;&nbsp;
                    <a href='#' onclick=del_menu(<?php echo $recuser["id_menu"] ?>)>
                        <span title="Supprimer ce Menu" alt="suppr"><i class="glyphicon glyphicon-remove"></i></span>
                    </a>
                    <?php
                } else {
                    ?>
                    <a href="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/restaurantbarhotel/menuhotel/editer_menu') ?>&menu=<?php echo $recuser["id_menu"] ?>">
                        <span title="Modifier ce Menu" alt="editer"><i class="glyphicon glyphicon-edit"></i></span>
                    </a>&nbsp;&nbsp;
                    <a href='#' onclick=del_menu(<?php echo $recuser["id_menu"] ?>)>
                        <span title="Supprimer ce Menu" alt="suppr"><i class="glyphicon glyphicon-remove"></i></span>
                    </a>
                    <?php
                }
                ?>
            </td>
        </tr>

        <?php
    }
}

//fonction pour modifier un Menu
function editer_menu($id, $nomm, $descm, $con) {
    $nomm = addslashes($nomm);
    $descm = addslashes($descm);
    $req = $con->query("select * from hotel_menu where nom_m = '" . $nomm . "'") or die(mysqli_error($con));
    $nb = mysqli_num_rows($req);
    if (($nb == 0)) {
        $rslt = $con->query("update hotel_menu set nom_m='" . $nomm . "', description_m='" . $descm . "' where id_menu='" . $id . "'") or die(mysqli_error($con));
        echo "<script language='javascript'>$('div.alertmodifbon').show('slow').delay(8000).hide('slow');</script>";
    } else {
        $recuser = mysqli_fetch_array($req);
        if ($id == $recuser["id_menu"]) {
            $rslt = $con->query("update hotel_menu set nom_m='" . $nomm . "', description_m='" . $descm . "' where id_menu='" . $id . "'") or die(mysqli_error($con));
            echo "<script language='javascript'>$('div.alertmodifbon').show('slow').delay(8000).hide('slow');</script>";
        } else {
            echo "<script language='javascript'>$('div.alertaddmauv').show('slow').delay(8000).hide('slow');</script>";
        }
    }
}

//fonction pour ajouter un Menu
function ajouter_menuresto($idresto, $men, $i, $prixm, $typem, $con) {
    for ($j = 0; $j < $i; $j++) {
        $req = $con->query("select * from hotel_menu_r where id_restaurant= '" . $idresto . "' and "
                . "id_menu= '" . $men[$j] . "'") or die(mysqli_error($con));
        $nb = mysqli_num_rows($req);
        if (($nb == 0)) {
            $rslt = $con->query("insert into hotel_menu_r(id_restaurant, id_menu, prix_mr, type_mr) "
                    . "values('" . $idresto . "', '" . $men[$j] . "', '" . $prixm . "', '" . $typem . "')") or die(mysqli_error($con));
        } else {
            echo "<script language='javascript'>$('div.alertaddmauv').show('slow').delay(8000).hide('slow');</script>";
        }
    }
    echo "<script language='javascript'>$('div.alertuseraddbon').show('slow').delay(8000).hide('slow');</script>";
}

//fonction pour lister les Menus
function lister_menuresto($idresto, $con) {
    $rsltuser = $con->query('select * from hotel_menu_r as spa left join hotel_menu as s on '
            . 'spa.id_menu=s.id_menu where spa.id_restaurant=' . $idresto . '') or die(mysqli_error($con));
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        ?>

        <tr >
            <td><?php print nl2br(htmlspecialchars($recuser["nom_m"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["prix_mr"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["type_mr"])) ?></td>
            <td>
                <?php
                if (isset($_SESSION["loginproprietaire"])) {
                    ?>
                    <a href='#' onclick=del_menu(<?php echo $recuser["id_menu"] ?>,<?php echo $idresto ?>)>
                        <span title="Supprimer un Menu" alt="suppr"><i class="glyphicon glyphicon-remove"></i></span>
                    </a>
                    <?php
                } else {
                    ?>
                    <!--                        
                                        <a href='#' onclick=del_menu(<?php echo $recuser["id_menu"] ?>,<?php echo $idresto ?>)>
                                            <span title="Supprimer un Menu" alt="suppr"><i class="glyphicon glyphicon-remove"></i></span>
                                        </a>-->
                    <?php
                }
                ?>
            </td>
        </tr>

        <?php
    }
}

//gestion des Pointhotels
//fonction pour ajouter un Pointhotel
function ajouter_restaurant($nomr, $typer, $contactr, $pointh, $con) {
    $nomr = addslashes($nomr);
//    $quartier_ph = addslashes($quartier_ph);
    $req = $con->query("select * from hotel_restaurant as r where r.nom_rest= '" . $nomr . "'") or die(mysqli_error($con));
    $nb = mysqli_num_rows($req);
    if (($nb == 0)) {
        $rslt = $con->query("insert into hotel_restaurant(id_point_hotel, nom_rest, type_rest, contact_rest, date_rest) "
                . "values('" . $pointh . "', '" . $nomr . "', '" . $typer . "', '" . $contactr . "', NOW())") or die(mysqli_error($con));
        echo "<script language='javascript'>$('div.alertuseraddbon').show('slow').delay(8000).hide('slow');</script>";
    } else {
        echo "<script language='javascript'>$('div.alertaddmauv').show('slow').delay(8000).hide('slow');</script>";
    }
}

//fonction pour lister les Pointhotels
function lister_restaurant($con) {
    $rsltuser = $con->query("select * from hotel_restaurant as r left join hotel_point_hotel as ph on "
            . "r.id_point_hotel=ph.id_point_hotel ") or die(mysqli_error($con));
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        $rsltreg = $con->query("select * from hotel_departement as d left join hotel_region as r on d.id_region=r.id_region "
                . "where d.id_departement='" . $recuser["id_departement"] . "'") or die(mysqli_error($con));
        $recreg = mysqli_fetch_assoc($rsltreg);
        ?>

        <tr >
            <td><?php print nl2br(htmlspecialchars($recuser["nom_rest"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["type_rest"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["contact_rest"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["nom_ph"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recreg["nom_reg"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["date_rest"])) ?></td>
            <td>
                <?php
                if (isset($_SESSION["loginproprietaire"])) {
                    ?>
                    <a href="indexproprietaire.php?page=<?php echo base64_encode('hotelpages/restaurantbarhotel/editer_restaurant') ?>&restaurant=<?php echo $recuser["id_restaurant"] ?>">
                        <span title="Modifier ce restaurant" alt="editer"><i class="glyphicon glyphicon-edit"></i></span>
                    </a>&nbsp;&nbsp;
                    <a href="indexproprietaire.php?page=<?php echo base64_encode('hotelpages/restaurantbarhotel/ajouter_menu') ?>&restaurant=<?php echo $recuser["id_restaurant"] ?>">
                        <span title="Associer un menu &agrave; ce restaurant" alt="associer"><i class="glyphicon glyphicon-plus"></i></span>
                    </a>&nbsp;&nbsp;
                    <a href="indexproprietaire.php?page=<?php echo base64_encode('hotelpages/restaurantbarhotel/lister_menu') ?>&restaurant=<?php echo $recuser["id_restaurant"] ?>">
                        <span title="Lister les menus de ce restaurant" alt="lister"><i class="glyphicon glyphicon-list"></i></span>
                    </a>&nbsp;&nbsp;
                    <a href='#' onclick=del_restaurant(<?php echo $recuser["id_restaurant"] ?>)>
                        <span title="Supprimer un restaurant" alt="suppr"><i class="glyphicon glyphicon-remove"></i></span>
                    </a>
                    <?php
                } else {
                    ?><a href="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/restaurantbarhotel/editer_restaurant') ?>&restaurant=<?php echo $recuser["id_restaurant"] ?>">
                        <span title="Modifier ce restaurant" alt="editer"><i class="glyphicon glyphicon-edit"></i></span>
                    </a>&nbsp;&nbsp;
                    <a href="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/restaurantbarhotel/ajouter_menu') ?>&restaurant=<?php echo $recuser["id_restaurant"] ?>">
                        <span title="Associer un menu &agrave; ce restaurant" alt="associer"><i class="glyphicon glyphicon-plus"></i></span>
                    </a>&nbsp;&nbsp;
                    <a href="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/restaurantbarhotel/lister_menu') ?>&restaurant=<?php echo $recuser["id_restaurant"] ?>">
                        <span title="Lister les menus de ce restaurant" alt="lister"><i class="glyphicon glyphicon-list"></i></span>
                    </a>&nbsp;&nbsp;
                    <a href='#' onclick=del_restaurant(<?php echo $recuser["id_restaurant"] ?>)>
                        <span title="Supprimer un restaurant" alt="suppr"><i class="glyphicon glyphicon-remove"></i></span>
                    </a>
                    <?php
                }
                ?>
            </td>
        </tr>

        <?php
    }
}

//fonction pour modifier un Pointhotel
function editer_restaurant($id, $nom_ph, $quartier_ph, $deppa, $con) {
    $nom_ph = addslashes($nom_ph);
    $quartier_ph = addslashes($quartier_ph);
    $req = $con->query("select * from hotel_restaurant where nom_ph = '" . $nom_ph . "'") or die(mysqli_error($con));
    $nb = mysqli_num_rows($req);
    if (($nb == 0)) {
        $rslt = $con->query("update hotel_restaurant set nom_ph='" . $nom_ph . "', quartier_ph='" . $quartier_ph . "', "
                . "id_departement='" . $deppa . "' where id_restaurant='" . $id . "'") or die(mysqli_error($con));
        echo "<script language='javascript'>$('div.alertmodifbon').show('slow').delay(8000).hide('slow');</script>";
    } else {
        $recuser = mysqli_fetch_array($req);
        if ($id == $recuser["id_restaurant"]) {
            $rslt = $con->query("update hotel_restaurant set nom_ph='" . $nom_ph . "', quartier_ph='" . $quartier_ph . "', "
                    . "id_departement='" . $deppa . "' where id_restaurant='" . $id . "'") or die(mysqli_error($con));
            echo "<script language='javascript'>$('div.alertmodifbon').show('slow').delay(8000).hide('slow');</script>";
        } else {
            echo "<script language='javascript'>$('div.alertaddmauv').show('slow').delay(8000).hide('slow');</script>";
        }
    }
}

//gestion des Pointhotels
//fonction pour ajouter un Pointhotel
function ajouter_bar($nomr, $typer, $contactr, $pointh, $con) {
    $nomr = addslashes($nomr);
//    $quartier_ph = addslashes($quartier_ph);
    $req = $con->query("select * from hotel_bar as r where r.nom_bar= '" . $nomr . "'") or die(mysqli_error($con));
    $nb = mysqli_num_rows($req);
    if (($nb == 0)) {
        $rslt = $con->query("insert into hotel_bar(id_point_hotel, nom_bar, type_bar, contact_bar, date_bar) "
                . "values('" . $pointh . "', '" . $nomr . "', '" . $typer . "', '" . $contactr . "', NOW())") or die(mysqli_error($con));
        echo "<script language='javascript'>$('div.alertuseraddbon').show('slow').delay(8000).hide('slow');</script>";
    } else {
        echo "<script language='javascript'>$('div.alertaddmauv').show('slow').delay(8000).hide('slow');</script>";
    }
}

//fonction pour lister les Pointhotels
function lister_bar($con) {
    $rsltuser = $con->query("select * from hotel_bar as r left join hotel_point_hotel as ph on "
            . "r.id_point_hotel=ph.id_point_hotel ") or die(mysqli_error($con));
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        $rsltreg = $con->query("select * from hotel_departement as d left join hotel_region as r on d.id_region=r.id_region "
                . "where d.id_departement='" . $recuser["id_departement"] . "'") or die(mysqli_error($con));
        $recreg = mysqli_fetch_assoc($rsltreg);
        ?>

        <tr >
            <td><?php print nl2br(htmlspecialchars($recuser["nom_bar"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["type_bar"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["contact_bar"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["nom_ph"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recreg["nom_reg"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["date_bar"])) ?></td>
            <td>
                <?php
                if (isset($_SESSION["loginproprietaire"])) {
                    ?>
                    <a href="indexproprietaire.php?page=<?php echo base64_encode('hotelpages/restaurantbarhotel/editer_bar') ?>&bar=<?php echo $recuser["id_bar"] ?>">
                        <span title="Modifier ce bar" alt="editer"><i class="glyphicon glyphicon-edit"></i></span>
                    </a>&nbsp;&nbsp;
                    <a href='#' onclick=del_bar(<?php echo $recuser["id_bar"] ?>)>
                        <span title="Supprimer un bar" alt="suppr"><i class="glyphicon glyphicon-remove"></i></span>
                    </a>
                    <?php
                } else {
                    ?><a href="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/restaurantbarhotel/editer_bar') ?>&bar=<?php echo $recuser["id_bar"] ?>">
                        <span title="Modifier ce bar" alt="editer"><i class="glyphicon glyphicon-edit"></i></span>
                    </a>&nbsp;&nbsp;
                    <a href='#' onclick=del_bar(<?php echo $recuser["id_bar"] ?>)>
                        <span title="Supprimer un bar" alt="suppr"><i class="glyphicon glyphicon-remove"></i></span>
                    </a>
                    <?php
                }
                ?>
            </td>
        </tr>

        <?php
    }
}

//fonction pour modifier un Pointhotel
function editer_bar($id, $nom_ph, $quartier_ph, $deppa, $con) {
    $nom_ph = addslashes($nom_ph);
    $quartier_ph = addslashes($quartier_ph);
    $req = $con->query("select * from hotel_bar where nom_ph = '" . $nom_ph . "'") or die(mysqli_error($con));
    $nb = mysqli_num_rows($req);
    if (($nb == 0)) {
        $rslt = $con->query("update hotel_bar set nom_ph='" . $nom_ph . "', quartier_ph='" . $quartier_ph . "', "
                . "id_departement='" . $deppa . "' where id_bar='" . $id . "'") or die(mysqli_error($con));
        echo "<script language='javascript'>$('div.alertmodifbon').show('slow').delay(8000).hide('slow');</script>";
    } else {
        $recuser = mysqli_fetch_array($req);
        if ($id == $recuser["id_bar"]) {
            $rslt = $con->query("update hotel_bar set nom_ph='" . $nom_ph . "', quartier_ph='" . $quartier_ph . "', "
                    . "id_departement='" . $deppa . "' where id_bar='" . $id . "'") or die(mysqli_error($con));
            echo "<script language='javascript'>$('div.alertmodifbon').show('slow').delay(8000).hide('slow');</script>";
        } else {
            echo "<script language='javascript'>$('div.alertaddmauv').show('slow').delay(8000).hide('slow');</script>";
        }
    }
}

//fonction pour lister les Pointhotels
function lister_caisse($con) {
    $moi = date('m');
    $an = date('Y');
    $rsltuser = $con->query("select * from hotel_caisse where YEAR(date_caisse)='" . $an . "' and "
            . "MONTH(date_caisse)='" . $moi . "' and caissier='" . $_SESSION["id_compte_personnel"] . "' ") or die(mysqli_error($con));
    $mtt = 0;
    ?>


    <?php
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        ?>
        <tr >
            <td><?php print nl2br(htmlspecialchars($recuser["date_caisse"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["opperation"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["but"])) ?></td>
            <td>
                <?php
                if ($recuser["opperation"] == "Versement") {
                    print number_format(nl2br(htmlspecialchars($recuser["montant_caisse"])), 0, ',', ' ');
                    $mtt = $mtt + $recuser["montant_caisse"];
                } else {
                    print "-" . number_format(nl2br(htmlspecialchars($recuser["montant_caisse"])), 0, ',', ' ');
                    $mtt = $mtt - $recuser["montant_caisse"];
                }
                ?>
            </td>
            <td>
                <?php
                if (isset($_SESSION["loginproprietaire"])) {
                    ?>

                    <?php
                } else {
                    ?>
                    <?php
                }
                ?>
            </td>
        </tr>

        <?php
    }
    ?>
    <tr >
        <td>TOTAL</td>
        <td></td>
        <td></td>
        <td><?php echo number_format($mtt, 0, ',', ' ') ?></td>
        <td>
        </td>
    </tr>

    <?php
}

function lister_caisse_c($con) {
    $moi = date('m');
    $an = date('Y');
    $rsltuser = $con->query("select * from hotel_caisse as c left join hotel_compte_personnel as cp on c.caissier=cp.id_compte_personnel "
            . "where YEAR(c.date_caisse)='" . $an . "' and MONTH(c.date_caisse)='" . $moi . "' ") or die(mysqli_error($con));
    $mtt = 0;
    ?>


    <?php
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        ?>
        <tr >
            <td><?php print nl2br(htmlspecialchars($recuser["login_pe"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["date_caisse"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["opperation"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["but"])) ?></td>
            <td>
                <?php
                if ($recuser["opperation"] == "Versement") {
                    print number_format(nl2br(htmlspecialchars($recuser["montant_caisse"])), 0, ',', ' ');
                    $mtt = $mtt + $recuser["montant_caisse"];
                } else {
                    print "-" . number_format(nl2br(htmlspecialchars($recuser["montant_caisse"])), 0, ',', ' ');
                    $mtt = $mtt - $recuser["montant_caisse"];
                }
                ?>
            </td>
            <td>
                <?php
                if (isset($_SESSION["loginproprietaire"])) {
                    ?>

                    <?php
                } else {
                    ?>
                    <?php
                }
                ?>
            </td>
        </tr>

        <?php
    }
    ?>
    <tr >
        <td>TOTAL</td>
        <td></td>
        <td></td>
        <td></td>
        <td><?php echo number_format($mtt, 0, ',', ' ') ?></td>
        <td>
        </td>
    </tr>

    <?php
}

//gestion des Divers
//fonction pour ajouter un Divers
function ajouter_divers($nomm1, $descm1, $prixm, $typem, $con) {
    $nomm = addslashes($nomm1);
    $descm = addslashes($descm1);
    $req = $con->query("select * from hotel_divers where intitule= '" . $nomm . "'") or die(mysqli_error($con));
    $nb = mysqli_num_rows($req);
    if (($nb == 0)) {
        $rslt = $con->query("insert into hotel_divers(intitule, description_d, prix_d, type_d) "
                . "values('" . $nomm . "', '" . $descm . "', '" . $prixm . "', '" . $typem . "')") or die(mysqli_error($con));
        echo "<script language='javascript'>$('div.alertuseraddbon').show('slow').delay(8000).hide('slow');</script>";
    } else {
        echo "<script language='javascript'>$('div.alertaddmauv').show('slow').delay(8000).hide('slow');</script>";
    }
}

//fonction pour lister les Diverss
function lister_divers($con) {
    $rsltuser = $con->query('select * from hotel_divers') or die(mysqli_error($con));
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        ?>

        <tr >
            <td><?php print nl2br(htmlspecialchars($recuser["intitule"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["description_d"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["prix_d"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["type_d"])) ?></td>
            <td>
                <?php
                if (isset($_SESSION["loginproprietaire"])) {
                    ?>
                    <a href="indexproprietaire.php?page=<?php echo base64_encode('hotelpages/divershotel/editer_divers') ?>&divers=<?php echo $recuser["id_divers"] ?>">
                        <span title="Modifier ce Divers" alt="editer"><i class="glyphicon glyphicon-edit"></i></span>
                    </a>&nbsp;&nbsp;
                    <a href='#' onclick=del_divers(<?php echo $recuser["id_divers"] ?>)>
                        <span title="Supprimer ce Divers" alt="suppr"><i class="glyphicon glyphicon-remove"></i></span>
                    </a>
                    <?php
                } else {
                    ?>
                    <a href="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/divershotel/editer_divers') ?>&divers=<?php echo $recuser["id_divers"] ?>">
                        <span title="Modifier ce Divers" alt="editer"><i class="glyphicon glyphicon-edit"></i></span>
                    </a>&nbsp;&nbsp;
                    <a href='#' onclick=del_divers(<?php echo $recuser["id_divers"] ?>)>
                        <span title="Supprimer ce Divers" alt="suppr"><i class="glyphicon glyphicon-remove"></i></span>
                    </a>
                    <?php
                }
                ?>
            </td>
        </tr>

        <?php
    }
}

//fonction pour modifier un Divers
function editer_divers($id, $nomm, $descm, $prixm, $typem, $con) {
    $nomm = addslashes($nomm);
    $descm = addslashes($descm);
    $req = $con->query("select * from hotel_divers where intitule = '" . $nomm . "'") or die(mysqli_error($con));
    $nb = mysqli_num_rows($req);
    if (($nb == 0)) {
        $rslt = $con->query("update hotel_divers set intitule='" . $nomm . "', description_d='" . $descm . "', "
                . "prix_d='" . $prixm . "', type_d='" . $typem . "' where id_divers='" . $id . "'") or die(mysqli_error($con));
        echo "<script language='javascript'>$('div.alertmodifbon').show('slow').delay(8000).hide('slow');</script>";
    } else {
        $recuser = mysqli_fetch_array($req);
        if ($id == $recuser["id_divers"]) {
            $rslt = $con->query("update hotel_divers set intitule='" . $nomm . "', description_d='" . $descm . "', "
                    . "prix_d='" . $prixm . "', type_d='" . $typem . "' where id_divers='" . $id . "'") or die(mysqli_error($con));
            echo "<script language='javascript'>$('div.alertmodifbon').show('slow').delay(8000).hide('slow');</script>";
        } else {
            echo "<script language='javascript'>$('div.alertaddmauv').show('slow').delay(8000).hide('slow');</script>";
        }
    }
}

function ajouter_achat_client($com, $con) {
    if (($com != NULL)) {
        $rsltpl2 = $con->query("select * from hotel_paye_logement as pl left join hotel_recu as r on pl.id_paye_logement=r.id_paye_logement "
                . "left join hotel_client as c on pl.id_client=c.id_client where pl.id_client='" . $com["1"]["client"] . "' order by pl.date_pl desc limit 0,1") or die(mysqli_error($con));
        $rowpl2 = mysqli_fetch_assoc($rsltpl2);
        $obh = "";
        $an = date('Y');
        $numid = date('Y', time()) . sprintf("%08d", 1);
        $req1 = $con->query("select * from hotel_facture_d where YEAR(date_facture_d)='" . $an . "'") or die(mysqli_error($con));
        $i = 0;
        while ($reqte = mysqli_fetch_assoc($req1)) {
            $i = $i + 1;
        }
        $numid = date('Y', time()) . sprintf("%08d", $i + 1);
        if (isset($_SESSION["id_compte_personnel"])) {
            $rsltf = $con->query("insert into hotel_facture_d(id_compte_personnel, id_paye_logement, num_facture_d, date_facture_d) "
                    . "values('" . $_SESSION["id_compte_personnel"] . "','" . $rowpl2["id_paye_logement"] . "', '" . $numid . "', NOW())") or die(mysqli_error($con));
        } else {
            $rsltf = $con->query("insert into hotel_facture_d(id_paye_logement, num_facture_d, date_facture_d) "
                    . "values('" . $rowpl2["id_paye_logement"] . "', '" . $numid . "', NOW())") or die(mysqli_error($con));
        }
        $rsltfa = $con->query("select * from hotel_facture_d where num_facture_d='" . $numid . "'") or die(mysqli_error($con));
        $rowfa = mysqli_fetch_assoc($rsltfa);
        $prixt = 0;
        if ($com[1]["ctel"]) {
            $rsltpde = $con->query("select * from hotel_divers where id_divers='" . $com[1]["tel"] . "'") or die(mysqli_error($con));
            $rowpde = mysqli_fetch_assoc($rsltpde);
            $rsltreg = $con->query("insert into hotel_ligne_d(id_divers, id_facture_d, qte_fd, prix_fd) "
                    . "values('" . $com[1]["tel"] . "', '" . $rowfa["id_facture_d"] . "', '" . $com[1]["qtetel"] . "', "
                    . "'" . $rowpde["prix_d"] . "')") or die(mysqli_error($con));
            $prixt = $prixt + ($rowpde["prix_d"] * $com[1]["qtetel"]);
            $obh = $obh . $com[1]["qtetel"] . "-" . $rowpde["intitule"];
//            $obh=$com[1]["qtetel"]."-".$rowpde["type_d"];
        }
        ?> 
        <?php
        if ($com[1]["cblan"]) {
            $rsltpde = $con->query("select * from hotel_divers where id_divers='" . $com[1]["blan"] . "'") or die(mysqli_error($con));
            $rowpde = mysqli_fetch_assoc($rsltpde);
            $rsltreg = $con->query("insert into hotel_ligne_d(id_divers, id_facture_d, qte_fd, prix_fd) "
                    . "values('" . $com[1]["blan"] . "', '" . $rowfa["id_facture_d"] . "', '" . $com[1]["qteblan"] . "', "
                    . "'" . $rowpde["prix_d"] . "')") or die(mysqli_error($con));
            $prixt = $prixt + ($rowpde["prix_d"] * $com[1]["qteblan"]);
            $obh = $obh . "-" . $com[1]["qteblan"] . "-" . $rowpde["intitule"];
//            $obh=$obh.$com[1]["qteblan"]."-".$rowpde["type_d"];
        }
        ?> 
        <?php
        if ($com[1]["cdive"]) {
            $rsltpde = $con->query("select * from hotel_divers where id_divers='" . $com[1]["dive"] . "'") or die(mysqli_error($con));
            $rowpde = mysqli_fetch_assoc($rsltpde);
            $rsltreg = $con->query("insert into hotel_ligne_d(id_divers, id_facture_d, qte_fd, prix_fd) "
                    . "values('" . $com[1]["dive"] . "', '" . $rowfa["id_facture_d"] . "', '" . $com[1]["qtedive"] . "', "
                    . "'" . $rowpde["prix_d"] . "')") or die(mysqli_error($con));
            $prixt = $prixt + ($rowpde["prix_d"] * $com[1]["qtedive"]);
            $obh = $obh . "-" . $com[1]["qtedive"] . "-" . $rowpde["intitule"];
//            $obh=$obh.$com[1]["qtedive"]."-".$rowpde["type_d"];
        }
        $contenu = NULL;
        $op = "Divers";
        if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
            $rsltreg = $con->query("insert into hotel_registre_client(id_paye_logement, montant_reg, operation_reg, date_registre) "
                    . "values('" . $rowpl2["id_paye_logement"] . "', '" . $prixt . "', '" . $op . "', NOW())") or die(mysqli_error($con));
        } else if (isset($_SESSION["login_personnel"]) && (isset($_SESSION["mot_de_passe_personnel"])) && ($_SESSION["etat_compte_personnel"])) {
            $rsltreg = $con->query("insert into hotel_registre_client(id_paye_logement, id_compte_personnel, montant_reg, "
                    . "operation_reg, date_registre) values('" . $rowpl2["id_paye_logement"] . "', "
                    . "'" . $_SESSION["id_compte_personnel"] . "', '" . $prixt . "', '" . $op . "', NOW())") or die(mysqli_error($con));
        }
        $contenu = "Bonjour M. /Mme. " . $rowpl2["nom_client"] . " " . $rowpl2["prenom_client"] . " Vous avez effectué un Achat de  " . $prixt . ".";

        $numero = $rowpl2["telephone_client"];
        if ($numero != NULL) {
            if (strlen($numero) <= 9) {
                $numero = "237" . $numero;
            }

            $smsObj = new Sender('martial_ngueto', 'nguetongueto@@1989', 'UB', $contenu, $numero, '1', '1');

//            print_r($numero);
//            print_r($contenu);
            try {
                //Envoyer le SMS
                $smsObj->Submit();
                $result = $smsObj->response;
                echo "<script language='javascript'>$('div.alertsmsbon').show('slow').delay(8000).hide('slow');</script>";
            } catch (Exception $e) {
                dd($e->getMessage());
            }
        }
        $oph = "Achat";
        if (isset($_SESSION["loginproprietaire"]) && isset($_SESSION["id_proprietaire"])) {
            $rslthisto = $con->query("insert into hotel_historique(id_proprietaire, id_client, operation_h, objet_h, date_histo) "
                    . "values('" . $_SESSION["id_proprietaire"] . "', '" . $com["1"]["client"] . "', '" . $oph . "', '" . $obh . "', NOW())") or die(mysqli_error($con));
        } else if (isset($_SESSION["login_personnel"]) && isset($_SESSION["id_compte_personnel"])) {
            $rslthisto = $con->query("insert into hotel_historique(id_compte_personnel, id_client, operation_h, objet_h, date_histo) "
                    . "values('" . $_SESSION["id_compte_personnel"] . "', '" . $com["1"]["client"] . "', '" . $oph . "', '" . $obh . "', NOW())") or die(mysqli_error($con));
        }
        unset($_SESSION['formachat']);
        echo "<script language='javascript'>$('div.alertuseraddbon').show('slow').delay(8000).hide('slow');</script>";
        ?>
        <a href="hotelpages/clienthotel/achatclienthotel/facture_achat_pdf.php?facture=<?php echo $rowfa["id_facture_d"] ?>" class="btn btn-lg btn-success" target="_blank">
            <span title="Imprimer la facture du client" alt="editer"><i class="fa fa-file-pdf-o"></i> Impriner la facture</span>
        </a>
        <?php
    } else {
        echo "<script language='javascript'>$('div.alertclformvide').show('slow').delay(8000).hide('slow');</script>";
    }
}

function ajouter_achat_divers($com, $con) {
    if (($com != NULL)) {

        $obh = "";
        $an = date('Y');
        $numid = date('Y', time()) . sprintf("%08d", 1);
        $req1 = $con->query("select * from hotel_facture_d where YEAR(date_facture_d)='" . $an . "'") or die(mysqli_error($con));
        $i = 0;
        while ($reqte = mysqli_fetch_assoc($req1)) {
            $i = $i + 1;
        }
        $numid = date('Y', time()) . sprintf("%08d", $i + 1);
        if (isset($_SESSION["id_compte_personnel"])) {
            $rsltf = $con->query("insert into hotel_facture_d(id_compte_personnel, num_facture_d, date_facture_d) "
                    . "values('" . $_SESSION["id_compte_personnel"] . "', '" . $numid . "', NOW())") or die(mysqli_error($con));
        } else {
            $rsltf = $con->query("insert into hotel_facture_d(num_facture_d, date_facture_d) values('" . $numid . "', NOW())") or die(mysqli_error($con));
        }
        $rsltfa = $con->query("select * from hotel_facture_d where num_facture_d='" . $numid . "'") or die(mysqli_error($con));
        $rowfa = mysqli_fetch_assoc($rsltfa);
        $prixt = 0;
        if ($com[1]["ctel"]) {
            $rsltpde = $con->query("select * from hotel_divers where id_divers='" . $com[1]["tel"] . "'") or die(mysqli_error($con));
            $rowpde = mysqli_fetch_assoc($rsltpde);
            $rsltreg = $con->query("insert into hotel_ligne_d(id_divers, id_facture_d, qte_fd, prix_fd) "
                    . "values('" . $com[1]["tel"] . "', '" . $rowfa["id_facture_d"] . "', '" . $com[1]["qtetel"] . "', "
                    . "'" . $rowpde["prix_d"] . "')") or die(mysqli_error($con));
            $prixt = $prixt + ($rowpde["prix_d"] * $com[1]["qtetel"]);
            $obh = $com[1]["qtetel"] . "-" . $rowpde["intitule"];
//            $obh=$com[1]["qtetel"]."-".$rowpde["type_d"];
        }
        ?> 
        <?php
        if ($com[1]["cblan"]) {
            $rsltpde = $con->query("select * from hotel_divers where id_divers='" . $com[1]["blan"] . "'") or die(mysqli_error($con));
            $rowpde = mysqli_fetch_assoc($rsltpde);
            $rsltreg = $con->query("insert into hotel_ligne_d(id_divers, id_facture_d, qte_fd, prix_fd) "
                    . "values('" . $com[1]["blan"] . "', '" . $rowfa["id_facture_d"] . "', '" . $com[1]["qteblan"] . "', "
                    . "'" . $rowpde["prix_d"] . "')") or die(mysqli_error($con));
            $prixt = $prixt + ($rowpde["prix_d"] * $com[1]["qteblan"]);
            $obh = $obh . "-" . $com[1]["qteblan"] . "-" . $rowpde["intitule"];
//            $obh=$obh."-".$com[1]["qteblan"]."-".$rowpde["type_d"];
        }
        ?> 
        <?php
        if ($com[1]["cdive"]) {
            $rsltpde = $con->query("select * from hotel_divers where id_divers='" . $com[1]["dive"] . "'") or die(mysqli_error($con));
            $rowpde = mysqli_fetch_assoc($rsltpde);
            $rsltreg = $con->query("insert into hotel_ligne_d(id_divers, id_facture_d, qte_fd, prix_fd) "
                    . "values('" . $com[1]["dive"] . "', '" . $rowfa["id_facture_d"] . "', '" . $com[1]["qtedive"] . "', "
                    . "'" . $rowpde["prix_d"] . "')") or die(mysqli_error($con));
            $prixt = $prixt + ($rowpde["prix_d"] * $com[1]["qtedive"]);
            $obh = $obh . "-" . $com[1]["qtedive"] . "-" . $rowpde["intitule"];
//            $obh=$obh."-".$com[1]["qtedive"]."-".$rowpde["type_d"];
        }
        $oph = "Achat";
        if (isset($_SESSION["loginproprietaire"]) && isset($_SESSION["id_proprietaire"])) {
            $rslthisto = $con->query("insert into hotel_historique(id_proprietaire, operation_h, objet_h, date_histo) "
                    . "values('" . $_SESSION["id_proprietaire"] . "', '" . $oph . "', '" . $obh . "', NOW())") or die(mysqli_error($con));
        } else if (isset($_SESSION["login_personnel"]) && isset($_SESSION["id_compte_personnel"])) {
            $rslthisto = $con->query("insert into hotel_historique(id_compte_personnel, operation_h, objet_h, date_histo) "
                    . "values('" . $_SESSION["id_compte_personnel"] . "', '" . $oph . "', '" . $obh . "', NOW())") or die(mysqli_error($con));
        }
        unset($_SESSION['formachat']);
        echo "<script language='javascript'>$('div.alertuseraddbon').show('slow').delay(8000).hide('slow');</script>";
        ?>
        <a href="hotelpages/achatdivershotel/facture_achat_pdf.php?facture=<?php echo $rowfa["id_facture_d"] ?>" class="btn btn-lg btn-success" target="_blank">
            <span title="Imprimer la facture du client" alt="editer"><i class="fa fa-file-pdf-o"></i> Impriner la facture</span>
        </a>
        <?php
    } else {
        echo "<script language='javascript'>$('div.alertclformvide').show('slow').delay(8000).hide('slow');</script>";
    }
}

//fonction pour lister les Payes logements
function lister_paye_logement($con) {
    $rsltuser = $con->query("select * from hotel_paye_logement as pl left join hotel_client as c on "
            . "c.id_client=pl.id_client order by pl.date_pl  ") or die(mysqli_error($con));
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        $rsltrecept = $con->query("select * from hotel_compte_personnel as cp left join hotel_personnel as p on "
                . "cp.id_personnel=p.id_personnel where id_compte_personnel='" . $recuser["receptionniste"] . "'") or die(mysqli_error($con));
        $recrecept = mysqli_fetch_assoc($rsltrecept);
        ?>
        <tr >
            <td>
                <?php echo $recuser["nom_client"] ?> 
                <?php echo $recuser["prenom_client"] ?>
            </td>
            <td>
                <?php echo $recrecept["nom_pe"] ?> 
                <?php echo $recrecept["prenom_pe"] ?> 
                <?php echo $recrecept["login_pe"] ?>
            </td>
            <?php
            if ($recuser["id_chambre"] != NULL) {
                $reqch = $con->query("select * from hotel_chambre as c left join hotel_point_hotel as ph on c.id_point_hotel=ph.id_point_hotel "
                        . "left join hotel_proprietaire as p on ph.id_proprietaire=p.id_proprietaire where c.id_chambre= '" . $recuser["id_chambre"] . "' ") or die(mysqli_error($con));
                $rowch = mysqli_fetch_assoc($reqch);
                ?>
                <td>
                    <?php print nl2br(htmlspecialchars($rowch["code_c"])) ?>
                </td>
                <?php
            } else if ($recuser["id_studio"] != NULL) {
                $reqst = $con->query("select * from hotel_studio as s left join hotel_point_hotel as ph on s.id_point_hotel=ph.id_point_hotel "
                        . "left join hotel_proprietaire as p on ph.id_proprietaire=p.id_proprietaire where s.id_studio= '" . $recuser["id_studio"] . "' ") or die(mysqli_error($con));
                $rowst = mysqli_fetch_assoc($reqst);
                ?>
                <td>
                    <?php print nl2br(htmlspecialchars($rowst["code_s"])) ?>
                </td>
                <?php
            } else if ($recuser["id_appartement"] != NULL) {
                $reqap = $con->query("select * from hotel_appartement as a left join hotel_point_hotel as ph on a.id_point_hotel=ph.id_point_hotel "
                        . "left join hotel_proprietaire as p on ph.id_proprietaire=p.id_proprietaire where a.id_appartement= '" . $recuser["id_appartement"] . "' ") or die(mysqli_error($con));
                $rowap = mysqli_fetch_assoc($reqap);
                ?>
                <td>
                    <?php print nl2br(htmlspecialchars($rowap["code_a"])) ?> 
                    <?php print $rowap["nbchambre_a"] ?>Ch  
                    <?php echo $rowap["nbsalon_a"] ?>S  
                    <?php echo $rowap["nbdouche_a"] ?>D  
                    <?php echo $rowap["nbcuisine_a"] ?>Cu 
                </td>
                <?php
            } else if ($recuser["id_salle"] != NULL) {
                $reqsa = $con->query("select * from hotel_salle as s left join hotel_point_hotel as ph on s.id_point_hotel=ph.id_point_hotel "
                        . "left join hotel_proprietaire as p on ph.id_proprietaire=p.id_proprietaire where s.id_salle= '" . $recuser["id_salle"] . "' ") or die(mysqli_error($con));
                $rowsa = mysqli_fetch_assoc($reqsa);
                ?>
                <td>
                    <?php print nl2br(htmlspecialchars($rowsa["code_salle"])) ?>
                </td>
                <?php
            }
            ?>
            <td>
                <?php print nl2br(htmlspecialchars($recuser["code_pl"])) ?>
            </td>    
            <td>
                <?php print nl2br(htmlspecialchars($recuser["nbpers"])) ?>
            </td>      
            <td>
                <?php print nl2br(htmlspecialchars($recuser["prix_u"])) ?>
            </td>     
            <td>
                <?php print nl2br(htmlspecialchars($recuser["prix_pl"])) ?>
            </td>    
            <td>
                <?php print nl2br(htmlspecialchars($recuser["date_debut_pl"])) ?>
            </td>    
            <td>
                <?php print nl2br(htmlspecialchars($recuser["date_fin_pl"])) ?>
            </td>    
            <td>
                <?php print nl2br(htmlspecialchars($recuser["regle_pl"])) ?>
            </td>    
        </tr>
        <?php
    }
}

//fonction pour lister les Factures menu
function lister_facture_m($con) {
    $rsltuser = $con->query("select * from hotel_facture_m order by date_facture_m desc ") or die(mysqli_error($con));
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        ?>

        <tr >
            <td><?php print nl2br(htmlspecialchars($recuser["num_fact_m"])) ?></td>
            <td>
                <?php
                if (($recuser["id_paye_logement"] != NULL) && ($recuser["id_paye_logement"] != 0)) {

                    $rsltcl = $con->query("select * from hotel_paye_logement as pl left join hotel_client as c on pl.id_client=c.id_client "
                            . "where pl.id_paye_logement='" . $recuser["id_paye_logement"] . "' ") or die(mysqli_error($con));
                    $rowcl = mysqli_fetch_assoc($rsltcl);
                    ?>
                    <?php print nl2br(htmlspecialchars($rowcl["nom_client"])) ?> 
                    <?php print nl2br(htmlspecialchars($rowcl["prenom_client"])) ?> - 
                    <?php print nl2br(htmlspecialchars($rowcl["cni_client"])) ?> --
                    <?php
                    if ($rowcl["id_chambre"] != NULL) {
                        $reqch = $con->query("select * from hotel_chambre as c left join hotel_point_hotel as ph on "
                                . "c.id_point_hotel=ph.id_point_hotel left join hotel_proprietaire as p on "
                                . "ph.id_proprietaire=p.id_proprietaire where c.id_chambre= '" . $rowcl["id_chambre"] . "' ")
                                or die(mysqli_error($con));
                        $rowch = mysqli_fetch_assoc($reqch);
                        ?>
                        &nbsp;
                        <?php print nl2br(htmlspecialchars($rowch["code_c"])) ?>
                        <?php
                    } else if ($rowcl["id_studio"] != NULL) {
                        $reqst = $con->query("select * from hotel_studio as s left join hotel_point_hotel as ph on "
                                . "s.id_point_hotel=ph.id_point_hotel left join hotel_proprietaire as p on "
                                . "ph.id_proprietaire=p.id_proprietaire where s.id_studio= '" . $rowcl["id_studio"] . "' ")
                                or die(mysqli_error($con));
                        $rowst = mysqli_fetch_assoc($reqst);
                        ?>
                        &nbsp;
                        <?php print nl2br(htmlspecialchars($rowst["code_s"])) ?>
                        <?php
                    } else if ($rowcl["id_appartement"] != NULL) {
                        $reqap = $con->query("select * from hotel_appartement as a left join hotel_point_hotel as ph on "
                                . "a.id_point_hotel=ph.id_point_hotel left join hotel_proprietaire as p on "
                                . "ph.id_proprietaire=p.id_proprietaire where a.id_appartement= '" . $rowcl["id_appartement"] . "' ")
                                or die(mysqli_error($con));
                        $rowap = mysqli_fetch_assoc($reqap);
                        ?>
                        &nbsp;
                        <?php print nl2br(htmlspecialchars($rowap["code_a"])) ?> 
                        <?php print nl2br(htmlspecialchars($rowap["nbchambre_a"])) ?> C 
                        <?php print nl2br(htmlspecialchars($rowap["nbsalon_a"])) ?> S 
                        <?php print nl2br(htmlspecialchars($rowap["nbcuisine_a"])) ?> CU
                        <?php print nl2br(htmlspecialchars($rowap["nbdouche_a"])) ?> D
                        <?php
                    } else if ($rowcl["id_salle"] != NULL) {
                        $reqst = $con->query("select * from hotel_salle as s left join hotel_point_hotel as ph on "
                                . "s.id_point_hotel=ph.id_point_hotel left join hotel_proprietaire as p on "
                                . "ph.id_proprietaire=p.id_proprietaire where s.id_salle= '" . $rowcl["id_salle"] . "' ")
                                or die(mysqli_error($con));
                        $rowst = mysqli_fetch_assoc($reqst);
                        ?>
                        &nbsp;
                        <?php print nl2br(htmlspecialchars($rowst["code_salle"])) ?>
                        <?php
                    }
                }
                ?>
            </td>
            <td>
                <?php
                if (($recuser["id_compte_personnel"] != NULL) && ($recuser["id_compte_personnel"] != 0)) {

                    $rsltpe = $con->query("select * from hotel_compte_personnel as cp left join hotel_personnel as p on "
                            . "cp.id_personnel=p.id_personnel where cp.id_compte_personnel='" . $recuser["id_compte_personnel"] . "' ")
                            or die(mysqli_error($con));
                    $rowpe = mysqli_fetch_assoc($rsltpe);
                    ?>
                    <?php print nl2br(htmlspecialchars($rowpe["nom_pe"])) ?> 
                    <?php print nl2br(htmlspecialchars($rowpe["prenom_pe"])) ?> - 
                    <?php print nl2br(htmlspecialchars($rowpe["login_pe"])) ?> --
                    <?php
                    $reqs = $con->query("select * from hotel_affectation as a left join service_point_hotel as sph on "
                            . "a.id_point_hotel=sph.id_point_hotel and a.id_service=sph.id_service left join hotel_service "
                            . "as s on sph.id_service=s.id_service where a.id_personnel= '" . $rowpe["id_personnel"] . "' "
                            . "order by a.date_affectation desc limit 0,1 ")
                            or die(mysqli_error($con));
                    $rows = mysqli_fetch_assoc($reqs);
                    ?>
                    &nbsp;
                    <?php print nl2br(htmlspecialchars($rows["code_service"])) ?>
                    <?php
                }
                ?>
            </td>
            <td><?php print nl2br(htmlspecialchars($recuser["date_facture_m"])) ?></td>
            <td>
                <?php
//                    $rsltpl = $con->query("select * from hotel_paye_logement as pl left join hotel_recu as r on pl.id_paye_logement=r.id_paye_logement "
//                            . "where pl.id_facture_m='" . $recuser["id_facture_m"] . "' and pl.date_fin_pl >= NOW() order by pl.date_pl desc ") or die(mysqli_error($con));
//                    $rowpl = mysqli_fetch_assoc($rsltpl);
//                    $rsltpl2 = $con->query("select * from hotel_paye_logement as pl left join hotel_recu as r on pl.id_paye_logement=r.id_paye_logement "
//                            . "where pl.id_facture_m='" . $recuser["id_facture_m"] . "' order by pl.date_pl desc limit 0,1") or die(mysqli_error($con));
//                    $rowpl2 = mysqli_fetch_assoc($rsltpl2);
//                    $today = date('Y-m-d H:i:s');
//                    $dif = dateDiff($today, $rowpl["date_fin_pl"]);
                if (isset($_SESSION["loginproprietaire"])) {
                    ?>
                    <a href="indexproprietaire.php?page=<?php echo base64_encode('hotelpages/commandehotel/editer_facture_m') ?>&facture_m=<?php echo $recuser["id_facture_m"] ?>">
                        <span title="Modifier cette Facture" alt="editer"><i class="glyphicon glyphicon-edit"></i></span>
                    </a>&nbsp;&nbsp;
                    <a href="indexproprietaire.php?page=<?php echo base64_encode('hotelpages/commandehotel/lister_ligne_facture_m') ?>&facture_m=<?php echo $recuser["id_facture_m"] ?>">
                        <span title="Lister les lignes de cette Facture" alt="dossier"><i class="glyphicon glyphicon-folder-open"></i></span>
                    </a>
                    <?php
                } else {
                    if (($_SESSION["code_service"] == "RESTO") || ($_SESSION["code_service"] == "BARESTO")) {
                        ?>
                        <a href="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/commandehotel/editer_facture_m') ?>&facture_m=<?php echo $recuser["id_facture_m"] ?>">
                            <span title="Modifier cette Facture" alt="editer"><i class="glyphicon glyphicon-edit"></i></span>
                        </a>
                        <?php
                    }
                    ?>&nbsp;&nbsp;
                    <a href="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/commandehotel/lister_ligne_facture_m') ?>&facture_m=<?php echo $recuser["id_facture_m"] ?>">
                        <span title="Lister les lignes de cette Facture" alt="dossier"><i class="glyphicon glyphicon-folder-open"></i></span>
                    </a>
                    <?php
                }

                if (($recuser["id_paye_logement"] != NULL) && ($recuser["id_paye_logement"] != 0)) {
                    ?>&nbsp;&nbsp;
                    <a href="hotelpages/clienthotel/commandeclienthotel/facture_commande_pdf.php?facture=<?php echo $recuser["id_facture_m"] ?>" target="_blank">
                        <span title="Imprimer la facture du client" alt="editer"><i class="glyphicon glyphicon-print"></i></span>
                    </a>
                    <?php
                } else {
                    ?>&nbsp;&nbsp;
                    <a href="hotelpages/commandehotel/facture_commande_pdf.php?facture=<?php echo $recuser["id_facture_m"] ?>" target="_blank">
                        <span title="Imprimer la facture du client" alt="editer"><i class="glyphicon glyphicon-print"></i></span>
                    </a>
                    <?php
                }
                ?>
            </td>
        </tr>

        <?php
    }
}

//fonction pour lister les Factures menu
function lister_facture_d($con) {
    $rsltuser = $con->query("select * from hotel_facture_d order by date_facture_d desc ") or die(mysqli_error($con));
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        ?>

        <tr >
            <td><?php print nl2br(htmlspecialchars($recuser["num_facture_d"])) ?></td>
            <td>
                <?php
                if (($recuser["id_paye_logement"] != NULL) && ($recuser["id_paye_logement"] != 0)) {

                    $rsltcl = $con->query("select * from hotel_paye_logement as pl left join hotel_client as c on pl.id_client=c.id_client "
                            . "where pl.id_paye_logement='" . $recuser["id_paye_logement"] . "' ") or die(mysqli_error($con));
                    $rowcl = mysqli_fetch_assoc($rsltcl);
                    ?>
                    <?php print nl2br(htmlspecialchars($rowcl["nom_client"])) ?> 
                    <?php print nl2br(htmlspecialchars($rowcl["prenom_client"])) ?> - 
                    <?php print nl2br(htmlspecialchars($rowcl["cni_client"])) ?> --
                    <?php
                    if ($rowcl["id_chambre"] != NULL) {
                        $reqch = $con->query("select * from hotel_chambre as c left join hotel_point_hotel as ph on "
                                . "c.id_point_hotel=ph.id_point_hotel left join hotel_proprietaire as p on "
                                . "ph.id_proprietaire=p.id_proprietaire where c.id_chambre= '" . $rowcl["id_chambre"] . "' ")
                                or die(mysqli_error($con));
                        $rowch = mysqli_fetch_assoc($reqch);
                        ?>
                        &nbsp;
                        <?php print nl2br(htmlspecialchars($rowch["code_c"])) ?>
                        <?php
                    } else if ($rowcl["id_studio"] != NULL) {
                        $reqst = $con->query("select * from hotel_studio as s left join hotel_point_hotel as ph on "
                                . "s.id_point_hotel=ph.id_point_hotel left join hotel_proprietaire as p on "
                                . "ph.id_proprietaire=p.id_proprietaire where s.id_studio= '" . $rowcl["id_studio"] . "' ")
                                or die(mysqli_error($con));
                        $rowst = mysqli_fetch_assoc($reqst);
                        ?>
                        &nbsp;
                        <?php print nl2br(htmlspecialchars($rowst["code_s"])) ?>
                        <?php
                    } else if ($rowcl["id_appartement"] != NULL) {
                        $reqap = $con->query("select * from hotel_appartement as a left join hotel_point_hotel as ph on "
                                . "a.id_point_hotel=ph.id_point_hotel left join hotel_proprietaire as p on "
                                . "ph.id_proprietaire=p.id_proprietaire where a.id_appartement= '" . $rowcl["id_appartement"] . "' ")
                                or die(mysqli_error($con));
                        $rowap = mysqli_fetch_assoc($reqap);
                        ?>
                        &nbsp;
                        <?php print nl2br(htmlspecialchars($rowap["code_a"])) ?> 
                        <?php print nl2br(htmlspecialchars($rowap["nbchambre_a"])) ?> C 
                        <?php print nl2br(htmlspecialchars($rowap["nbsalon_a"])) ?> S 
                        <?php print nl2br(htmlspecialchars($rowap["nbcuisine_a"])) ?> CU
                        <?php print nl2br(htmlspecialchars($rowap["nbdouche_a"])) ?> D
                        <?php
                    } else if ($rowcl["id_salle"] != NULL) {
                        $reqst = $con->query("select * from hotel_salle as s left join hotel_point_hotel as ph on "
                                . "s.id_point_hotel=ph.id_point_hotel left join hotel_proprietaire as p on "
                                . "ph.id_proprietaire=p.id_proprietaire where s.id_salle= '" . $rowcl["id_salle"] . "' ")
                                or die(mysqli_error($con));
                        $rowst = mysqli_fetch_assoc($reqst);
                        ?>
                        &nbsp;
                        <?php print nl2br(htmlspecialchars($rowst["code_salle"])) ?>
                        <?php
                    }
                }
                ?>
            </td>
            <td>
                <?php
                if (($recuser["id_compte_personnel"] != NULL) && ($recuser["id_compte_personnel"] != 0)) {

                    $rsltpe = $con->query("select * from hotel_compte_personnel as cp left join hotel_personnel as p on "
                            . "cp.id_personnel=p.id_personnel where cp.id_compte_personnel='" . $recuser["id_compte_personnel"] . "' ")
                            or die(mysqli_error($con));
                    $rowpe = mysqli_fetch_assoc($rsltpe);
                    ?>
                    <?php print nl2br(htmlspecialchars($rowpe["nom_pe"])) ?> 
                    <?php print nl2br(htmlspecialchars($rowpe["prenom_pe"])) ?> - 
                    <?php print nl2br(htmlspecialchars($rowpe["login_pe"])) ?> --
                    <?php
                    $reqs = $con->query("select * from hotel_affectation as a left join service_point_hotel as sph on "
                            . "a.id_point_hotel=sph.id_point_hotel and a.id_service=sph.id_service left join hotel_service "
                            . "as s on sph.id_service=s.id_service where a.id_personnel= '" . $rowpe["id_personnel"] . "' "
                            . "order by a.date_affectation desc limit 0,1 ")
                            or die(mysqli_error($con));
                    $rows = mysqli_fetch_assoc($reqs);
                    ?>
                    &nbsp;
                    <?php print nl2br(htmlspecialchars($rows["code_service"])) ?>
                    <?php
                }
                ?>
            </td>
            <td><?php print nl2br(htmlspecialchars($recuser["date_facture_d"])) ?></td>
            <td>
                <?php
//                    $today = date('Y-m-d H:i:s');
//                    $dif = dateDiff($today, $rowpl["date_fin_pl"]);
                if (isset($_SESSION["loginproprietaire"])) {
                    ?>
                    <a href="indexproprietaire.php?page=<?php echo base64_encode('hotelpages/achatdivershotel/editer_facture_d') ?>&facture_d=<?php echo $recuser["id_facture_d"] ?>">
                        <span title="Modifier cette Facture" alt="editer"><i class="glyphicon glyphicon-edit"></i></span>
                    </a>&nbsp;&nbsp;
                    <a href="indexproprietaire.php?page=<?php echo base64_encode('hotelpages/achatdivershotel/lister_ligne_facture_d') ?>&facture_d=<?php echo $recuser["id_facture_d"] ?>">
                        <span title="Lister les lignes de cette Facture" alt="dossier"><i class="glyphicon glyphicon-folder-open"></i></span>
                    </a>
                    <?php
                } else {
                    if (($_SESSION["code_service"] == "RECEP")) {
                        ?>
                        <a href="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/achatdivershotel/editer_facture_d') ?>&facture_d=<?php echo $recuser["id_facture_d"] ?>">
                            <span title="Modifier cette Facture" alt="editer"><i class="glyphicon glyphicon-edit"></i></span>
                        </a>
                        <?php
                    }
                    ?>&nbsp;&nbsp;
                    <a href="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/achatdivershotel/lister_ligne_facture_d') ?>&facture_d=<?php echo $recuser["id_facture_d"] ?>">
                        <span title="Lister les lignes de cette Facture" alt="dossier"><i class="glyphicon glyphicon-folder-open"></i></span>
                    </a>
                    <?php
                }
                if (($recuser["id_paye_logement"] != NULL) && ($recuser["id_paye_logement"] != 0)) {
                    ?>&nbsp;&nbsp;
                    <a href="hotelpages/clienthotel/achatclienthotel/facture_achat_pdf.php?facture=<?php echo $recuser["id_facture_d"] ?>" target="_blank">
                        <span title="Imprimer la facture du client" alt="editer"><i class="glyphicon glyphicon-print"></i></span>
                    </a>
                    <?php
                } else {
                    ?>&nbsp;&nbsp;
                    <a href="hotelpages/achatdivershotel/facture_achat_pdf.php?facture=<?php echo $recuser["id_facture_d"] ?>" target="_blank">
                        <span title="Imprimer la facture du client" alt="editer"><i class="glyphicon glyphicon-print"></i></span>
                    </a>
                    <?php
                }
                ?>
            </td>
        </tr>

        <?php
    }
}

function lister_ligne_d($fact, $con) {
    $rsltuser = $con->query("select * from hotel_ligne_d as l left join hotel_divers as d on l.id_divers=d.id_divers where "
            . "l.id_facture_d='" . $fact . "' ") or die(mysqli_error($con));
//    $row = mysqli_fetch_assoc($rslt);
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        ?>

        <tr >
            <td><?php print nl2br(htmlspecialchars($recuser["intitule"])) ?></td>
            <td>
                <?php print nl2br(htmlspecialchars($recuser["type_d"])) ?>
            </td>
            <td>
                <?php print nl2br(htmlspecialchars($recuser["qte_fd"])) ?> 
            </td>
            <td><?php print nl2br(htmlspecialchars($recuser["prix_fd"])) ?></td>
            <td><?php echo $recuser["qte_fd"] * $recuser["prix_fd"] ?></td>
        </tr>

        <?php
    }
}

function lister_ligne_m($fact, $con) {
    $rsltuser = $con->query("select * from hotel_ligne_m as l left join hotel_menu_r as mr on l.id_menu_r=mr.id_menu_r left "
            . "join hotel_menu as m on mr.id_menu=m.id_menu where l.id_facture_m='" . $fact . "'") or die(mysqli_error($con));
//    $row = mysqli_fetch_assoc($rslt);
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        ?>

        <tr >
            <td><?php print nl2br(htmlspecialchars($recuser["nom_m"])) ?></td>
            <td>
                <?php print nl2br(htmlspecialchars($recuser["type_mr"])) ?>
            </td>
            <td>
                <?php print nl2br(htmlspecialchars($recuser["qte_fmr"])) ?> 
            </td>
            <td><?php print nl2br(htmlspecialchars($recuser["prix_fmr"])) ?></td>
            <td><?php echo $recuser["qte_fmr"] * $recuser["prix_fmr"] ?></td>
        </tr>

        <?php
    }
}

//gestion des Salles
//fonction pour ajouter une Salle
function ajouter_salle($codec, $niveauc, $prixc, $typec, $pointh, $con) {
    $req = $con->query("select * from hotel_salle where code_salle= '" . $codec . "' and id_point_hotel= '" . $pointh . "' ") or die(mysqli_error($con));
    $nb = mysqli_num_rows($req);
    if (($nb == 0)) {
        $rslt = $con->query("insert into hotel_salle(id_point_hotel, code_salle, niveau_salle, prix_salle, type_salle, date_salle) "
                . "values('" . $pointh . "', '" . $codec . "', '" . $niveauc . "', '" . $prixc . "', '" . $typec . "', NOW())") or die(mysqli_error($con));
        echo "<script language='javascript'>$('div.alertuseraddbon').show('slow').delay(8000).hide('slow');</script>";
    } else {
        echo "<script language='javascript'>$('div.alertaddmauv').show('slow').delay(8000).hide('slow');</script>";
    }
}

//fonction pour lister les Salles
function lister_salle($con) {
    $rsltuser = $con->query("select * from hotel_salle as c left join hotel_point_hotel as ph on c.id_point_hotel=ph.id_point_hotel left join hotel_departement as d on ph.id_departement=d.id_departement "
            . "left join hotel_region as r on d.id_region=r.id_region ") or die(mysqli_error($con));
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        ?>

        <tr >
            <td><?php print nl2br(htmlspecialchars($recuser["code_salle"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["niveau_salle"])) ?></td>
            <td><?php print number_format($recuser["prix_salle"], 0, ',', ' ') ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["type_salle"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["nom_ph"])) ?></td>
            <td>
                <?php
                if ($recuser["etat_salle"]) {
                    ?>
                    <a href="#" onclick=liberer_sal(<?php echo $recuser["id_salle"] ?>)>
                        Occup&eacute;
                    </a>
                    <?php
                } else if ($recuser["reserve_salle"]) {
                    ?>
                    <a href="#" onclick=occuper_sal(<?php echo $recuser["id_salle"] ?>)>
                        R&eacute;serv&eacute;
                    </a>
                    <?php
                } else {
                    ?>
                    Libre
                    <?php
                }
                ?>
            </td>
            <td>
                <?php
                if (isset($_SESSION["loginproprietaire"])) {
                    ?>

                    <a href="indexproprietaire.php?page=<?php echo base64_encode('hotelpages/sallehotel/editer_salle') ?>&salle=<?php echo $recuser["id_salle"] ?>">
                        <span title="Modifier cette Salle" alt="editer"><i class="glyphicon glyphicon-edit"></i></span>
                    </a>&nbsp;&nbsp;
                    <a href='#' onclick=del_hotel_salle(<?php echo $recuser["id_salle"] ?>)>
                        <span title="Supprimer cette Salle" alt="suppr"><i class="glyphicon glyphicon-remove"></i></span>
                    </a>
                    <?php
                } else {
                    ?>
            <!--                        <a href="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/sallehotel/editer_salle') ?>&salle=<?php echo $recuser["id_salle"] ?>">
                            <span title="Modifier cette Salle" alt="editer"><i class="glyphicon glyphicon-edit"></i></span>
                        </a>-->
                    <?php
                }
                ?>
            </td>
        </tr>

        <?php
    }
}

//fonction pour modifier une Salle
function editer_salle($id, $codec, $niveauc, $prixc, $typec, $pointh, $con) {
    $req = $con->query("select * from hotel_salle where code_salle= '" . $codec . "' and id_point_hotel= '" . $pointh . "' ") or die(mysqli_error($con));
    $nb = mysqli_num_rows($req);
    if (($nb == 0)) {
        $rslt = $con->query("update hotel_salle set id_point_hotel='" . $pointh . "', code_salle='" . $codec . "', "
                . "niveau_salle='" . $niveauc . "', prix_salle='" . $prixc . "', type_salle='" . $typec . "' "
                . "where id_salle='" . $id . "'") or die(mysqli_error($con));
        echo "<script language='javascript'>$('div.alertmodifbon').show('slow').delay(8000).hide('slow');</script>";
    } else {
        $recuser = mysqli_fetch_array($req);
        if ($id == $recuser["id_salle"]) {
            $rslt = $con->query("update hotel_salle set id_point_hotel='" . $pointh . "', code_salle='" . $codec . "', "
                    . "niveau_salle='" . $niveauc . "', prix_salle='" . $prixc . "', type_salle='" . $typec . "' "
                    . "where id_salle='" . $id . "'") or die(mysqli_error($con));
            echo "<script language='javascript'>$('div.alertmodifbon').show('slow').delay(8000).hide('slow');</script>";
        } else {
            echo "<script language='javascript'>$('div.alertaddmauv').show('slow').delay(8000).hide('slow');</script>";
        }
    }
}

//gestion des fournitures
function ajouter_fourniture($codec, $nomc, $con) {
    $nomc = addslashes($nomc);
    $req = $con->query("select * from hotel_fourniture where (code_fourniture='" . $codec . "')") or die(mysqli_error($con));
    $nb = mysqli_num_rows($req);

    if (($nb == 0)) {
        $rslt = $con->query("insert into hotel_fourniture(code_fourniture, libelle_fourniture, date_fourniture) "
                . "values('" . $codec . "', '" . $nomc . "', NOW())") or die(mysqli_error($con));
        echo "<script language='javascript'>$('div.alertuseraddbon').show('slow').delay(8000).hide('slow');</script>";
    } else {
        echo "<script language='javascript'>$('div.alertaddcatmauv').show('slow').delay(8000).hide('slow');</script>";
    }
}

function lister_fourniture($con) {
    $rsltuser = $con->query("select * from hotel_fourniture") or die(mysqli_error($con));
    $num = 0;
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        $num = $num + 1;
        ?>
        <tr>
            <td><?php print $num ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["code_fourniture"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["libelle_fourniture"])) ?></td>
            <td>
                <?php
                if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                    ?>
                    <a href="indexproprietaire.php?page=<?php echo base64_encode('hotelpages/fourniturehotel/editer_fourniture') ?>&fourniture=<?php echo $recuser["id_fourniture"] ?>">
                        <span title="Modifier cette fourniture" alt="editer"><i class="glyphicon glyphicon-pencil"></i></span>
                    </a>&nbsp;&nbsp;
                    <a href='#' onclick=del_fourniture(<?php echo $recuser["id_fourniture"] ?>)>
                        <span title="Supprimer cette fourniture" alt="supprimer"><i class="glyphicon glyphicon-remove"></i></span>
                    </a>
                    <?php
                } else if (isset($_SESSION["login_personnel"]) && (isset($_SESSION["mot_de_passe_personnel"])) && ($_SESSION["etat_compte_personnel"])) {
                    if (($_SESSION["code_service"] == "ECONO")) {
                        ?>
                        <a href="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/fourniturehotel/editer_fourniture') ?>&fourniture=<?php echo $recuser["id_fourniture"] ?>">
                            <span title="Modifier cette fourniture" alt="editer"><i class="glyphicon glyphicon-pencil"></i></span>
                        </a>&nbsp;&nbsp;
                        <a href='#' onclick=del_fourniture(<?php echo $recuser["id_fourniture"] ?>)>
                            <span title="Supprimer cette fourniture" alt="supprimer"><i class="glyphicon glyphicon-remove"></i></span>
                        </a>
                        <?php
                    }
                }
                ?>
            </td>
        </tr>
        <?php
    }
}

function editer_fourniture($id, $codec, $nomc, $con) {
    $nomc = addslashes($nomc);
    $req = $con->query("select * from hotel_fourniture where (code_fourniture='" . $codec . "')") or die(mysqli_error($con));
    $nb = mysqli_num_rows($req);
    if (($nb == 0)) {
        $rslts = $con->query("update hotel_fourniture set code_fourniture='" . $codec . "', "
                . "libelle_fourniture='" . $nomc . "' where id_fourniture='" . $id . "'") or die(mysqli_error($con));
        echo "<script language='javascript'>$('div.alertmodifbon').show('slow').delay(8000).hide('slow');</script>";
    } else {
        $row = mysqli_fetch_assoc($req);
        if ($row["id_fourniture"] == $id) {
            $rslts = $con->query("update hotel_fourniture set code_fourniture='" . $codec . "', "
                    . "libelle_fourniture='" . $nomc . "' where id_fourniture='" . $id . "'") or die(mysqli_error($con));
            echo "<script language='javascript'>$('div.alertmodifbon').show('slow').delay(8000).hide('slow');</script>";
        } else {
            echo "<script language='javascript'>$('div.alertaddcatmauv').show('slow').delay(8000).hide('slow');</script>";
        }
    }
}

//gestion des categories
function ajouter_categorie($codec, $nomc, $con) {
    $nomc = addslashes($nomc);
    $req = $con->query("select * from hotel_categorie where (code_categorie='" . $codec . "' )") or die(mysqli_error($con));
    $nb = mysqli_num_rows($req);

    if (($nb == 0)) {
        $rslt = $con->query("insert into hotel_categorie(code_categorie,libelle_categorie) "
                . "values('" . $codec . "','" . $nomc . "')") or die(mysqli_error($con));
        echo "<script language='javascript'>$('div.alertuseraddbon').show('slow').delay(8000).hide('slow');</script>";
    } else {
        echo "<script language='javascript'>$('div.alertaddcatmauv').show('slow').delay(8000).hide('slow');</script>";
    }
}

function lister_categorie($con) {
    $rsltuser = $con->query("select * from hotel_categorie ") or die(mysqli_error($con));
    $num = 0;
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        $num = $num + 1;
        ?>
        <tr>
            <td><?php print $num ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["code_categorie"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["libelle_categorie"])) ?></td>
            <td>
                <?php
                if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                    ?>
                    <a href="indexproprietaire.php?page=<?php echo base64_encode('hotelpages/fourniturehotel/editer_categorie') ?>&categorie=<?php echo $recuser["id_categorie"] ?>">
                        <span title="Modifier cette categorie" alt="editer"><i class="glyphicon glyphicon-pencil"></i></span>
                    </a>&nbsp;&nbsp;
                    <a href='#' onclick=del_categorie(<?php echo $recuser["id_categorie"] ?>)>
                        <span title="Supprimer cette categorie" alt="supprimer"><i class="glyphicon glyphicon-remove"></i></span>
                    </a>
                    <?php
                } else if (isset($_SESSION["login_personnel"]) && (isset($_SESSION["mot_de_passe_personnel"])) && ($_SESSION["etat_compte_personnel"])) {
                    if (($_SESSION["code_service"] == "ECONO")) {
                        ?>
                        <a href="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/fourniturehotel/editer_categorie') ?>&categorie=<?php echo $recuser["id_categorie"] ?>">
                            <span title="Modifier cette categorie" alt="editer"><i class="glyphicon glyphicon-pencil"></i></span>
                        </a>&nbsp;&nbsp;
                        <a href='#' onclick=del_categorie(<?php echo $recuser["id_categorie"] ?>)>
                            <span title="Supprimer cette categorie" alt="supprimer"><i class="glyphicon glyphicon-remove"></i></span>
                        </a>
                        <?php
                    }
                }
                ?>
            </td>
        </tr>
        <?php
    }
}

function editer_categorie($id, $codec, $nomc, $con) {
    $nomc = addslashes($nomc);
    $req = $con->query("select * from hotel_categorie where (code_categorie='" . $codec . "') ") or die(mysqli_error($con));
    $nb = mysqli_num_rows($req);
    if (($nb == 0)) {
        $rslt = $con->query("update hotel_categorie set code_categorie='" . $codec . "', libelle_categorie='" . $nomc . "' "
                . "where id_categorie='" . $id . "'") or die(mysqli_error($con));
        echo "<script language='javascript'>$('div.alertmodifbon').show('slow').delay(8000).hide('slow');</script>";
    } else {
        $row = mysqli_fetch_assoc($req);
        if ($row["id_categorie"] == $id) {
            $rslt = $con->query("update hotel_categorie set code_categorie='" . $codec . "', libelle_categorie='" . $nomc . "' "
                    . "where id_categorie='" . $id . "'") or die(mysqli_error($con));
            echo "<script language='javascript'>$('div.alertmodifbon').show('slow').delay(8000).hide('slow');</script>";
        } else {
            echo "<script language='javascript'>$('div.alertaddcatmauv').show('slow').delay(8000).hide('slow');</script>";
        }
    }
}

//gestion des unites
function ajouter_unite($codec, $nomc, $con) {
    $nomc = addslashes($nomc);
    $req = $con->query("select * from hotel_unite where (code_unite='" . $codec . "' )") or die(mysqli_error($con));
    $nb = mysqli_num_rows($req);

    if (($nb == 0)) {
        $rslt = $con->query("insert into hotel_unite(code_unite,libelle_unite) "
                . "values('" . $codec . "','" . $nomc . "')") or die(mysqli_error($con));
        echo "<script language='javascript'>$('div.alertuseraddbon').show('slow').delay(8000).hide('slow');</script>";
    } else {
        echo "<script language='javascript'>$('div.alertaddcatmauv').show('slow').delay(8000).hide('slow');</script>";
    }
}

function lister_unite($con) {
    $rsltuser = $con->query("select * from hotel_unite ") or die(mysqli_error($con));
    $num = 0;
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        $num = $num + 1;
        ?>
        <tr>
            <td><?php print $num ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["code_unite"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["libelle_unite"])) ?></td>
            <td>
                <?php
                if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                    ?>
                    <a href="indexproprietaire.php?page=<?php echo base64_encode('hotelpages/fourniturehotel/editer_unite') ?>&unite=<?php echo $recuser["id_unite"] ?>">
                        <span title="Modifier cette unite" alt="editer"><i class="glyphicon glyphicon-pencil"></i></span>
                    </a>&nbsp;&nbsp;
                    <a href='#' onclick=del_unite(<?php echo $recuser["id_unite"] ?>)>
                        <span title="Supprimer cette unite" alt="supprimer"><i class="glyphicon glyphicon-remove"></i></span>
                    </a>
                    <?php
                } else if (isset($_SESSION["login_personnel"]) && (isset($_SESSION["mot_de_passe_personnel"])) && ($_SESSION["etat_compte_personnel"])) {
                    if (($_SESSION["code_service"] == "ECONO")) {
                        ?>
                        <a href="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/fourniturehotel/editer_unite') ?>&unite=<?php echo $recuser["id_unite"] ?>">
                            <span title="Modifier cette unite" alt="editer"><i class="glyphicon glyphicon-pencil"></i></span>
                        </a>&nbsp;&nbsp;
                        <a href='#' onclick=del_unite(<?php echo $recuser["id_unite"] ?>)>
                            <span title="Supprimer cette unite" alt="supprimer"><i class="glyphicon glyphicon-remove"></i></span>
                        </a>
                        <?php
                    }
                }
                ?>
            </td>
        </tr>
        <?php
    }
}

function editer_unite($id, $codec, $nomc, $con) {
    $nomc = addslashes($nomc);
    $req = $con->query("select * from hotel_unite where (code_unite='" . $codec . "') ") or die(mysqli_error($con));
    $nb = mysqli_num_rows($req);
    if (($nb == 0)) {
        $rslt = $con->query("update hotel_unite set code_unite='" . $codec . "', libelle_unite='" . $nomc . "' "
                . "where id_unite='" . $id . "'") or die(mysqli_error($con));
        echo "<script language='javascript'>$('div.alertmodifbon').show('slow').delay(8000).hide('slow');</script>";
    } else {
        $row = mysqli_fetch_assoc($req);
        if ($row["id_unite"] == $id) {
            $rslt = $con->query("update hotel_unite set code_unite='" . $codec . "', libelle_unite='" . $nomc . "' "
                    . "where id_unite='" . $id . "'") or die(mysqli_error($con));
            echo "<script language='javascript'>$('div.alertmodifbon').show('slow').delay(8000).hide('slow');</script>";
        } else {
            echo "<script language='javascript'>$('div.alertaddcatmauv').show('slow').delay(8000).hide('slow');</script>";
        }
    }
}

//gestion des produits
function inserer_produit($prod, $con) {
//    echo"<script language='javascript'>alert('ok')</script>";
    if (($prod != NULL) && isset($prod["1"])) {
        $desp = addslashes($prod["1"]["desp"]);
        $ca = $prod["1"]["cat"];
//        echo"<script language='javascript'>alert($ca)</script>";

        $req = $con->query("select * from hotel_article where code_article='" . $prod["1"]["codep"] . "'") or die(mysqli_error($con));
        $nb = mysqli_num_rows($req);
        $reqim = $con->query("select * from hotel_article where image_article='" . $prod["1"]["imagep"] . "'") or die(mysqli_error($con));
        $nbim = mysqli_num_rows($reqim);

        if (($nb == 0)) {
            $imageprod = NULL;
            if ($prod["1"]["imagep"] != "null") {
                if (($nbim == 0)) {
                    $imageprod = $prod["1"]["imagep"];
                }
            }
            $rslta = $con->query("insert into hotel_article(code_article, libelle_article, image_article, "
                    . "id_categorie, id_fourniture, date_article) values('" . $prod["1"]["codep"] . "', "
                    . "'" . $desp . "', '" . $imageprod . "', '" . $prod["1"]["cat"] . "', "
                    . "'" . $prod["1"]["four"] . "', NOW())") or die(mysqli_error($con));
            $reqar = $con->query("select * from hotel_article where code_article='" . $prod["1"]["codep"] . "'") or die(mysqli_error($con));
            $rowar = mysqli_fetch_assoc($reqar);
            $rsltaph = $con->query("insert into hotel_article_point_hotel(id_point_hotel, id_article, "
                    . "stock_article, stock_min_article, stock_max_article, prix_achat_article, "
                    . "unite_achat_article, unite_vente_article, unite_sortie_article, "
                    . "date_article_ph) values('" . $_SESSION["id_point_hotel"] . "', '" . $rowar["id_article"] . "', "
                    . "'" . $prod["1"]["qtes"] . "', '" . $prod["1"]["qtemin"] . "', '" . $prod["1"]["qtemax"] . "', "
                    . "'" . $prod["1"]["prixa"] . "', '" . $prod["1"]["unitea"] . "', "
                    . "'" . $prod["1"]["unitev"] . "', '" . $prod["1"]["unites"] . "', NOW())") or die(mysqli_error($con));
            $reqarph = $con->query("select * from hotel_article_point_hotel where id_article='" . $rowar["id_article"] . "' "
                    . "and id_point_hotel='" . $_SESSION["id_point_hotel"] . "'") or die(mysqli_error($con));
            $rowarph = mysqli_fetch_assoc($reqarph);
            if (($prod["1"]["linge"])) {
                $rsltal = $con->query("insert into hotel_linge(id_article_point_hotel, date_linge) "
                        . "values('" . $rowarph["id_article_point_hotel"] . "', NOW())") or die(mysqli_error($con));
            }

            $an = date('Y');
            $etat = "Valider";
            $nomfour = "Inconnu";
            $idfourn = null;

            $rsltfour = $con->query("select * from hotel_fournisseur where nom_fournisseur='" . $nomfour . "'") or die(mysqli_error($con));
            $nbf = mysqli_num_rows($rsltfour);
            if ($nbf != 0) {
                $rowfour = mysqli_fetch_assoc($rsltfour);
                $idfourn = $rowfour["id_fournisseur"];
            } else {
                $rsltfou = $con->query("insert into hotel_fournisseur(nom_fournisseur) values('" . $nomfour . "')") or die(mysqli_error($con));
                $rsltfour2 = $con->query("select * from hotel_fournisseur where nom_fournisseur='" . $nomfour . "'") or die(mysqli_error($con));
                $rowfour = mysqli_fetch_assoc($rsltfour2);
                $idfourn = $rowfour["id_fournisseur"];
            }
            $rsltpl2 = $con->query("select * from hotel_bon_livraison where YEAR(date_bl)='" . $an . "'") or die(mysqli_error($con));
            $obh = "";
            $numid = date('Y', time()) . sprintf("%08d", 1);
            $i = 0;
            while ($reqte = mysqli_fetch_assoc($rsltpl2)) {
                $i = $i + 1;
            }
            $numid = date('Y', time()) . sprintf("%08d", ($i + 1));
            if (isset($_SESSION["id_compte_personnel"])) {
                $rsltf = $con->query("insert into hotel_bon_livraison(id_compte_personnel_validel, id_point_hotel, "
                        . "id_fournisseur, code_bl, montant_bl, etat_bl, date_bl) values('" . $_SESSION["id_compte_personnel"] . "', "
                        . "'" . $_SESSION["id_point_hotel"] . "', '" . $idfourn . "', '" . $numid . "', '" . $prod["1"]["prixa"] . "', "
                        . "'" . $etat . "', NOW())") or die(mysqli_error($con));
            } else {
                $rsltf = $con->query("insert into hotel_bon_livraison(id_point_hotel, id_fournisseur, code_bl, "
                        . "montant_bl, etat_bl, date_bl) values('" . $_SESSION["id_point_hotel"] . "', '" . $idfourn . "', "
                        . "'" . $numid . "', '" . $prod["1"]["prixa"] . "', '" . $etat . "', NOW())")
                        or die(mysqli_error($con));
            }
            $rsltfa = $con->query("select * from hotel_bon_livraison where code_bl='" . $numid . "'") or die(mysqli_error($con));
            $rowfa = mysqli_fetch_assoc($rsltfa);
            $prixt = 0;
            $rsltreg = $con->query("insert into hotel_ligne_bon_livraison(id_bon_livraison, id_article_point_hotel, "
                        . "id_unite, stock_lbl, prix_achat_lbl, etat_lbl) "
                        . "values('" . $rowfa["id_bon_livraison"] . "', '" . $rowarph["id_article_point_hotel"] . "', "
                        . "'" . $prod["1"]["unitea"] . "', '" . $prod["1"]["qtes"] . "', '" . $prod["1"]["prixa"] . "', "
                        . "'" . $etat . "')") or die(mysqli_error($con));
            
            $obj = $prod["1"]["codep"] . "->" . $prod["1"]["qtes"] . "->" . $prod["1"]["prixa"];
            $op = "Ajout";
            if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                $rsltvente = $con->query("insert into hotel_historique(id_article_point_hotel, id_proprietaire, objet_h, operation_h, "
                        . "date_histo) values('" . $rowarph["id_article_point_hotel"] . "', '" . $_SESSION["id_proprietaire"] . "', "
                        . "'" . $obj . "', '" . $op . "', NOW())") or die(mysqli_error($con));
            } else if (isset($_SESSION["login_personnel"]) && (isset($_SESSION["mot_de_passe_personnel"])) && ($_SESSION["etat_compte_personnel"])) {
                if (($_SESSION["code_service"] == "ECONO")) {
                    $rsltvente = $con->query("insert into hotel_historique(id_article_point_hotel, id_compte_personnel, objet_h, operation_h, "
                            . "date_histo) values('" . $rowarph["id_article_point_hotel"] . "', '" . $_SESSION["id_compte_personnel"] . "', "
                            . "'" . $obj . "', '" . $op . "', NOW())") or die(mysqli_error($con));
                }
            }

            unset($_SESSION['formprod']);
            echo "<script language='javascript'>$('div.alertuseraddbon').show('slow').delay(8000).hide('slow');</script>";

            $pag = 'hotelpages/fourniturehotel/lister_produit';
            if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                die('<meta http-equiv="refresh" content="4; URL=indexproprietaire.php?page=' . base64_encode($pag) . '">');
            } else if (isset($_SESSION["login_personnel"]) && (isset($_SESSION["mot_de_passe_personnel"])) && ($_SESSION["etat_compte_personnel"])) {
                if (($_SESSION["code_service"] == "ECONO")) {
                    die('<meta http-equiv="refresh" content="4; URL=indexpersonnel.php?page=' . base64_encode($pag) . '">');
                }
            }
        } else {
            echo "<script language='javascript'>$('div.alertaddprdtmauv').show('slow').delay(8000).hide('slow');</script>";
        }
    } else {
        echo "<script language='javascript'>$('div.alertaddnull').show('slow').delay(8000).hide('slow');</script>";
    }
}

//gestion des produits
function inserer_produit_livraison($prod, $con) {

//    echo"<script language='javascript'>alert('ok')</script>";
    if (($prod != NULL) && isset($prod["1"])) {
        $desp = addslashes($prod["1"]["desp"]);
        $quantitea = 0;
        $ca = $prod["1"]["cat"];
//        echo"<script language='javascript'>alert($ca)</script>";

        $req = $con->query("select * from hotel_article where code_article='" . $prod["1"]["codep"] . "'") or die(mysqli_error($con));
        $nb = mysqli_num_rows($req);
        $reqim = $con->query("select * from hotel_article where image_article='" . $prod["1"]["imagep"] . "'") or die(mysqli_error($con));
        $nbim = mysqli_num_rows($reqim);

        if (($nb == 0)) {
            $imageprod = NULL;
            if ($prod["1"]["imagep"] != "null") {
                if (($nbim == 0)) {
                    $imageprod = $prod["1"]["imagep"];
                }
            }

            $rslta = $con->query("insert into hotel_article(code_article, libelle_article, image_article, "
                    . "id_categorie, id_fourniture, date_article) values('" . $prod["1"]["codep"] . "', "
                    . "'" . $desp . "', '" . $imageprod . "', '" . $prod["1"]["cat"] . "', "
                    . "'" . $prod["1"]["four"] . "', NOW())") or die(mysqli_error($con));
            $reqar = $con->query("select * from hotel_article where code_article='" . $prod["1"]["codep"] . "'") or die(mysqli_error($con));
            $rowar = mysqli_fetch_assoc($reqar);
            $rsltaph = $con->query("insert into hotel_article_point_hotel(id_point_hotel, id_article, "
                    . "stock_article, stock_min_article, stock_max_article, prix_achat_article, "
                    . "unite_achat_article, unite_vente_article, unite_sortie_article, "
                    . "date_article_ph) values('" . $_SESSION["id_point_hotel"] . "', '" . $rowar["id_article"] . "', "
                    . "'" . $quantitea . "', '" . $prod["1"]["qtemin"] . "', '" . $prod["1"]["qtemax"] . "', "
                    . "'" . $prod["1"]["prixa"] . "', '" . $prod["1"]["unitea"] . "', "
                    . "'" . $prod["1"]["unitev"] . "', '" . $prod["1"]["unites"] . "', NOW())") or die(mysqli_error($con));
            $reqarph = $con->query("select * from hotel_article_point_hotel where id_article='" . $rowar["id_article"] . "' "
                    . "and id_point_hotel='" . $rowar["id_point_hotel"] . "'") or die(mysqli_error($con));
            $rowarph = mysqli_fetch_assoc($reqarph);
            if (($prod["1"]["linge"])) {
                $rsltal = $con->query("insert into hotel_linge(id_article_point_hotel, date_linge) "
                        . "values('" . $rowarph["id_article_point_hotel"] . "', NOW())") or die(mysqli_error($con));
            }
            $obj = $prod["1"]["codep"] . "->" . $prod["1"]["prixa"];
            $op = "Ajout";
            if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                $rsltvente = $con->query("insert into hotel_historique(id_article_point_hotel, id_proprietaire, objet_h, operation_h, "
                        . "date_histo) values('" . $rowarph["id_article_point_hotel"] . "', '" . $_SESSION["id_proprietaire"] . "', "
                        . "'" . $obj . "', '" . $op . "', NOW())") or die(mysqli_error($con));
            } else if (isset($_SESSION["login_personnel"]) && (isset($_SESSION["mot_de_passe_personnel"])) && ($_SESSION["etat_compte_personnel"])) {
                if (($_SESSION["code_service"] == "ECONO")) {
                    $rsltvente = $con->query("insert into hotel_historique(id_article_point_hotel, id_compte_personnel, objet_h, operation_h, "
                            . "date_histo) values('" . $rowarph["id_article_point_hotel"] . "', '" . $_SESSION["id_compte_personnel"] . "', "
                            . "'" . $obj . "', '" . $op . "', NOW())") or die(mysqli_error($con));
                }
            }

            unset($_SESSION['formprod']);
            echo "<script language='javascript'>$('div.alertuseraddbon').show('slow').delay(8000).hide('slow');</script>";

            $a = 'hotelpages/economathotel/bonlivraisonhotel/livraison';
            $idlinge = NULL;
            $prixlinge = 0;
            $rsltlin = $con->query("select * from hotel_linge where id_article_point_hotel='" . $rowarph["id_article_point_hotel"] . "'") or die(mysqli_error($con));
            $nblin = mysqli_num_rows($rsltlin);
            if ($nblin != 0) {
                $rowlin = mysqli_fetch_assoc($rsltlin);
                $idlinge = $rowlin["id_linge"];
                $prixlinge = $rowlin["prix_lavage_linge"];
            }
            $prodArray = array($rowar["id_article"] => array(
                    'idart' => $rowar["id_article"],
                    'idlingeart' => $idlinge,
                    'prixlingeart' => $prixlinge,
                    'designationart' => $rowar["libelle_article"],
                    'qteart' => 1,
                    'prixarta' => $rowar["prix_achat_article"],
                    'prixartv' => $rowar["prix_vente_article"],
                    'unitearta' => $rowar["unite_achat_article"],
                    'uniteartv' => $rowar["unite_vente_article"],
                    'unitearts' => $rowar["unite_sortie_article"]
            ));

            if (!empty($_SESSION["cart_prodvlex"])) {
                $f = FALSE;
                foreach ($_SESSION["cart_prodvlex"] as $k => $v) {
                    if (($_SESSION["cart_prodvlex"][$k]["idart"] == $_GET["idp"])) {
                        $f = TRUE;
                        $_SESSION["cart_prodvlex"][$k]["qteart"] = $_SESSION["cart_prodvlex"][$k]["qteart"] + 1;
                    }
                }
                if (!$f) {
                    $_SESSION["cart_prodvlex"] = array_merge($_SESSION["cart_prodvlex"], $prodArray);
                }
            } else {
                $_SESSION["cart_prodvlex"] = $prodArray;
            }

            if (isset($_SESSION["loginproprietaire"])) {
                die('<meta http-equiv="refresh" content="0; URL=indexproprietaire.php?page=' . base64_encode($a) . '">');
            } else {
                die('<meta http-equiv="refresh" content="0; URL=indexpersonnel.php?page=' . base64_encode($a) . '">');
            }
        } else {
            echo "<script language='javascript'>$('div.alertaddprdtmauv').show('slow').delay(8000).hide('slow');</script>";
        }
    } else {
        echo "<script language='javascript'>$('div.alertaddnull').show('slow').delay(8000).hide('slow');</script>";
    }
}

function lister_produit($con) {
    $rsltuser = $con->query("select * from hotel_article_point_hotel as aph left join hotel_article as a on "
            . "aph.id_article=a.id_article left join hotel_categorie as c on a.id_categorie=c.id_categorie left "
            . "join hotel_fourniture as f on a.id_fourniture=f.id_fourniture "
            . "where aph.id_point_hotel='" . $_SESSION["id_point_hotel"] . "' order by a.libelle_article asc") or die(mysqli_error($con));
    $num = 0;
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        $num = $num + 1;
        ?>
        <tr>
            <td><?php print $num ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["code_article"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["libelle_article"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["libelle_fourniture"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["libelle_categorie"])) ?></td>
            <td>
                <?php
                if ($recuser["stock_min_article"] >= $recuser["stock_article"]) {
                    ?>
                    <b style="color: red">
                        <?php
                        print nl2br(htmlspecialchars($recuser["stock_article"]));
                        ?>
                    </b>
                    <?php
                } else {
                    ?>
                    <b>
                        <?php
                        print nl2br(htmlspecialchars($recuser["stock_article"]));
                        ?>
                    </b>
                    <?php
                }
                ?>
            </td>
            <td><?php print nl2br(htmlspecialchars($recuser["stock_min_article"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["stock_max_article"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["prix_achat_article"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["prix_vente_article"])) ?></td>
            <td>
                <?php
                $rsltua = $con->query("select * from hotel_unite where id_unite='" . $recuser["unite_achat_article"] . "'") or die(mysqli_error($con));
                $rowa = mysqli_fetch_assoc($rsltua);
                print nl2br(htmlspecialchars($rowa["libelle_unite"]));
                ?>
            </td>
            <td>
                <?php
                $rsltuv = $con->query("select * from hotel_unite where id_unite='" . $recuser["unite_vente_article"] . "'") or die(mysqli_error($con));
                $rowv = mysqli_fetch_assoc($rsltuv);
                print nl2br(htmlspecialchars($rowv["libelle_unite"]));
                ?>
            </td>
            <td>
                <?php
                $rsltus = $con->query("select * from hotel_unite where id_unite='" . $recuser["unite_sortie_article"] . "'") or die(mysqli_error($con));
                $rows = mysqli_fetch_assoc($rsltus);
                print nl2br(htmlspecialchars($rows["libelle_unite"]));
                ?>
            </td>
            <td>
                <?php
                if ($recuser["etat_article"]) {
                    ?>
                    <a href='#' onclick=desactive_article(<?php echo $recuser["id_article"] ?>)>
                        <span title="Desactiver cet article" alt="desactiver"><i class="glyphicon glyphicon-check"></i></span>
                    </a>
                    <?php
                } else {
                    ?>
                    <a href='#' onclick=active_article(<?php echo $recuser["id_article"] ?>)>
                        <span title="Activer cet article" alt="activer"><i class="glyphicon glyphicon-move"></i></span>
                    </a>
                    <?php
                }
                ?>
            </td>
            <td><?php print nl2br(htmlspecialchars($recuser["date_article"])) ?></td>
            <td>
                <?php
                if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                    ?>
                    <a href="indexproprietaire.php?page=<?php echo base64_encode('hotelpages/fourniturehotel/hotelediter/editer_produit') ?>&produit=<?php echo $recuser["id_article_point_hotel"] ?>">
                        <span title="Modifier cet article" alt="editer"><i class="glyphicon glyphicon-pencil"></i></span>
                    </a>&nbsp;&nbsp;
                    <a href="indexproprietaire.php?page=<?php echo base64_encode('hotelpages/fourniturehotel/hotelconvertion/lister_convertion') ?>&produit=<?php echo $recuser["id_article_point_hotel"] ?>">
                        <span title="G&eacute;rer les unit&eacute;s de convertion de cet article" alt="convertion"><i class="glyphicon glyphicon-resize-full"></i></span>
                    </a>&nbsp;&nbsp;
                    <a href='#' onclick=del_article(<?php echo $recuser["id_article_point_hotel"] ?>)>
                        <span title="Supprimer cet article" alt="supprimer"><i class="glyphicon glyphicon-remove"></i></span>
                    </a>
                    <?php
                } else if (isset($_SESSION["login_personnel"]) && (isset($_SESSION["mot_de_passe_personnel"])) && ($_SESSION["etat_compte_personnel"])) {
                    if (($_SESSION["code_service"] == "ECONO")) {
                        ?>
                        <a href="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/fourniturehotel/hotelediter/editer_produit') ?>&produit=<?php echo $recuser["id_article_point_hotel"] ?>">
                            <span title="Modifier cet article" alt="editer"><i class="glyphicon glyphicon-pencil"></i></span>
                        </a>&nbsp;&nbsp;
                        <a href="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/fourniturehotel/hotelconvertion/lister_convertion') ?>&produit=<?php echo $recuser["id_article_point_hotel"] ?>">
                            <span title="G&eacute;rer les unit&eacute;s de convertion de cet article" alt="convertion"><i class="glyphicon glyphicon-resize-full"></i></span>
                        </a>&nbsp;&nbsp;
                        <a href='#' onclick=del_article(<?php echo $recuser["id_article_point_hotel"] ?>)>
                            <span title="Supprimer cet article" alt="supprimer"><i class="glyphicon glyphicon-remove"></i></span>
                        </a>
                        <?php
                    }
                }
                ?>
            </td>
        </tr>
        <?php
    }
}

function lister_produit_pro($con) {
    $rsltuser = $con->query("select * from hotel_article as a left join hotel_categorie as c on "
            . "a.id_categorie=c.id_categorie left join hotel_fourniture as f on a.id_fourniture=f.id_fourniture "
            . "order by a.libelle_article asc") or die(mysqli_error($con));
    $num = 0;
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        $num = $num + 1;
        ?>
        <tr>
            <td><?php print $num ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["code_article"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["libelle_article"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["libelle_fourniture"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["libelle_categorie"])) ?></td>
            <td>
                <?php
                if ($recuser["etat_article"]) {
                    ?>
                    <a href='#' onclick=desactive_article(<?php echo $recuser["id_article"] ?>)>
                        <span title="Desactiver cet article" alt="desactiver"><i class="glyphicon glyphicon-check"></i></span>
                    </a>
                    <?php
                } else {
                    ?>
                    <a href='#' onclick=active_article(<?php echo $recuser["id_article"] ?>)>
                        <span title="Activer cet article" alt="activer"><i class="glyphicon glyphicon-move"></i></span>
                    </a>
                    <?php
                }
                ?>
            </td>
            <td><?php print nl2br(htmlspecialchars($recuser["date_article"])) ?></td>
            <td>
                <?php
                if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                    ?>
                    <a href="indexproprietaire.php?page=<?php echo base64_encode('hotelpages/fourniturehotel/hotelediter/editer_produit') ?>&produit=<?php echo $recuser["id_article"] ?>">
                        <span title="Modifier cet article" alt="editer"><i class="glyphicon glyphicon-pencil"></i></span>
                    </a>&nbsp;&nbsp;
<!--                    <a href="indexproprietaire.php?page=<?php echo base64_encode('hotelpages/fourniturehotel/hotelconvertion/lister_convertion') ?>&produit=<?php echo $recuser["id_article"] ?>">
                        <span title="G&eacute;rer les unit&eacute;s de convertion de cet article" alt="convertion"><i class="glyphicon glyphicon-resize-full"></i></span>
                    </a>&nbsp;&nbsp;-->
                    <a href='#' onclick=del_article(<?php echo $recuser["id_article"] ?>)>
                        <span title="Supprimer cet article" alt="supprimer"><i class="glyphicon glyphicon-remove"></i></span>
                    </a>
                    <?php
                } else if (isset($_SESSION["login_personnel"]) && (isset($_SESSION["mot_de_passe_personnel"])) && ($_SESSION["etat_compte_personnel"])) {
                    if (($_SESSION["code_service"] == "ECONO")) {
                        ?>
                        <a href="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/fourniturehotel/hotelediter/editer_produit') ?>&produit=<?php echo $recuser["id_article"] ?>">
                            <span title="Modifier cet article" alt="editer"><i class="glyphicon glyphicon-pencil"></i></span>
                        </a>&nbsp;&nbsp;
<!--                        <a href="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/fourniturehotel/hotelconvertion/lister_convertion') ?>&produit=<?php echo $recuser["id_article"] ?>">
                            <span title="G&eacute;rer les unit&eacute;s de convertion de cet article" alt="convertion"><i class="glyphicon glyphicon-resize-full"></i></span>
                        </a>&nbsp;&nbsp;-->
                        <a href='#' onclick=del_article(<?php echo $recuser["id_article"] ?>)>
                            <span title="Supprimer cet article" alt="supprimer"><i class="glyphicon glyphicon-remove"></i></span>
                        </a>
                        <?php
                    }
                }
                ?>
            </td>
        </tr>
        <?php
    }
}

function lister_produit_alert($con) {
    $rsltuser = $con->query("select * from hotel_article_point_hotel as aph left join hotel_article as a on "
            . "aph.id_article=a.id_article left join hotel_categorie as c on a.id_categorie=c.id_categorie left "
            . "join hotel_fourniture as f on a.id_fourniture=f.id_fourniture where "
            . "aph.id_point_hotel='" . $_SESSION["id_point_hotel"] . "' ans aph.stock_article<aph.stock_min_article "
            . "order by a.libelle_article asc") or die(mysqli_error($con));
    $num = 0;
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        $num = $num + 1;
        ?>
        <tr>
            <td><?php print $num ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["code_article"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["libelle_article"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["libelle_fourniture"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["libelle_categorie"])) ?></td>
            <td>
                <?php
                if ($recuser["stock_min_article"] >= $recuser["stock_article"]) {
                    ?>
                    <b style="color: red">
                        <?php
                        print nl2br(htmlspecialchars($recuser["stock_article"]));
                        ?>
                    </b>
                    <?php
                } else {
                    ?>
                    <b>
                        <?php
                        print nl2br(htmlspecialchars($recuser["stock_article"]));
                        ?>
                    </b>
                    <?php
                }
                ?>
            </td>
            <td><?php print nl2br(htmlspecialchars($recuser["stock_min_article"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["stock_max_article"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["prix_achat_article"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["prix_vente_article"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["unite_achat_article"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["unite_vente_article"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["unite_sortie_article"])) ?></td>
            <td>
                <?php
                if ($recuser["etat_article"]) {
                    ?>
                    <a href='#' onclick=desactive_article(<?php echo $recuser["id_article"] ?>)>
                        <span title="Desactiver cet article" alt="desactiver"><i class="glyphicon glyphicon-check"></i></span>
                    </a>
                    <?php
                } else {
                    ?>
                    <a href='#' onclick=active_article(<?php echo $recuser["id_article"] ?>)>
                        <span title="Activer cet article" alt="activer"><i class="glyphicon glyphicon-move"></i></span>
                    </a>
                    <?php
                }
                ?>
            </td>
            <td><?php print nl2br(htmlspecialchars($recuser["date_article"])) ?></td>
            <td>
                <?php
                if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                    ?>
                    <a href="indexproprietaire.php?page=<?php echo base64_encode('hotelpages/fourniturehotel/hotelediter/editer_produit') ?>&produit=<?php echo $recuser["id_article"] ?>">
                        <span title="Modifier cet article" alt="editer"><i class="glyphicon glyphicon-pencil"></i></span>
                    </a>&nbsp;&nbsp;
                    <a href='#' onclick=del_article(<?php echo $recuser["id_article"] ?>)>
                        <span title="Supprimer cet article" alt="supprimer"><i class="glyphicon glyphicon-remove"></i></span>
                    </a>
                    <?php
                } else if (isset($_SESSION["login_personnel"]) && (isset($_SESSION["mot_de_passe_personnel"])) && ($_SESSION["etat_compte_personnel"])) {
                    if (($_SESSION["code_service"] == "ECONO")) {
                        ?>
                        <a href="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/fourniturehotel/hotelediter/editer_produit') ?>&produit=<?php echo $recuser["id_article"] ?>">
                            <span title="Modifier cet article" alt="editer"><i class="glyphicon glyphicon-pencil"></i></span>
                        </a>&nbsp;&nbsp;
                        <a href='#' onclick=del_article(<?php echo $recuser["id_article"] ?>)>
                            <span title="Supprimer cet article" alt="supprimer"><i class="glyphicon glyphicon-remove"></i></span>
                        </a>
                        <?php
                    }
                }
                ?>
            </td>
        </tr>
        <?php
    }
}

function update_produit($prod, $con) {
//    echo"<script language='javascript'>alert('ok')</script>";
    if (($prod != NULL) && isset($prod["1"])) {
        $desp = addslashes($prod["1"]["desp"]);
        $req = $con->query("select * from hotel_article where code_article='" . $prod["1"]["codep"] . "'") or die(mysqli_error($con));
        $nb = mysqli_num_rows($req);
        $reqim = $con->query("select * from hotel_article where image_article='" . $prod["1"]["imagep"] . "'") or die(mysqli_error($con));
        $nbim = mysqli_num_rows($reqim);
        if (($nb == 0)) {

            $imageprod = $prod["1"]["imagepstring"];
            if ($prod["1"]["imagep"] != "null") {
                if (($nbim == 0)) {
                    $imageprod = $prod["1"]["imagep"];
                }
            }
            $rslt = $con->query("update hotel_article set code_article='" . $prod["1"]["codep"] . "', libelle_article='" . $desp . "', "
                    . "stock_article='" . $prod["1"]["qtes"] . "', stock_min_article='" . $prod["1"]["qtemin"] . "', "
                    . "stock_max_article='" . $prod["1"]["qtemax"] . "', prix_achat_article='" . $prod["1"]["prixa"] . "', "
                    . "prix_vente_article='" . $prod["1"]["prixv"] . "', unite_achat_article='" . $prod["1"]["unitea"] . "', "
                    . "unite_vente_article='" . $prod["1"]["unitev"] . "', unite_sortie_article='" . $prod["1"]["unites"] . "', "
                    . "type_article='" . $prod["1"]["typea"] . "', image_article='" . $imageprod . "', id_categorie='" . $prod["1"]["cat"] . "', "
                    . "id_fourniture='" . $prod["1"]["four"] . "' where id_article='" . $prod["1"]["idarticle"] . "'") or die(mysqli_error($con));

            $obj = $prod["1"]["codep"] . "->" . $prod["1"]["qtes"] . "->" . $prod["1"]["prixa"];
            $op = "Modification";
            if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                $rsltvente = $con->query("insert into hotel_historique(id_article, id_proprietaire, objet_h, operation_h, "
                        . "date_histo) values('" . $prod["1"]["idarticle"] . "', '" . $_SESSION["id_proprietaire"] . "', "
                        . "'" . $obj . "', '" . $op . "', NOW())") or die(mysqli_error($con));
            } else if (isset($_SESSION["login_personnel"]) && (isset($_SESSION["mot_de_passe_personnel"])) && ($_SESSION["etat_compte_personnel"])) {
                if (($_SESSION["code_service"] == "ECONO")) {
                    $rsltvente = $con->query("insert into hotel_historique(id_article, id_compte_personnel, objet_h, operation_h, "
                            . "date_histo) values('" . $prod["1"]["idarticle"] . "', '" . $_SESSION["id_compte_personnel"] . "', "
                            . "'" . $obj . "', '" . $op . "', NOW())") or die(mysqli_error($con));
                }
            }
            unset($_SESSION['formprode']);
            echo "<script language='javascript'>$('div.alertmodifbon').show('slow').delay(8000).hide('slow');</script>";

            $pag = 'hotelpages/fourniturehotel/lister_produit';
            if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                die('<meta http-equiv="refresh" content="4; URL=indexproprietaire.php?page=' . base64_encode($pag) . '">');
            } else if (isset($_SESSION["login_personnel"]) && (isset($_SESSION["mot_de_passe_personnel"])) && ($_SESSION["etat_compte_personnel"])) {
                if (($_SESSION["code_service"] == "ECONO")) {
                    die('<meta http-equiv="refresh" content="4; URL=indexpersonnel.php?page=' . base64_encode($pag) . '">');
                }
            }
        } else {
            $row = mysqli_fetch_assoc($req);
            if ($row["id_article"] == $prod["1"]["idarticle"]) {

                $imageprod = $prod["1"]["imagepstring"];
                if ($prod["1"]["imagep"] != "null") {
                    if (($nbim == 0)) {
                        $imageprod = $prod["1"]["imagep"];
                    }
                }
                $rslt = $con->query("update hotel_article set code_article='" . $prod["1"]["codep"] . "', libelle_article='" . $desp . "', "
                        . "stock_article='" . $prod["1"]["qtes"] . "', stock_min_article='" . $prod["1"]["qtemin"] . "', "
                        . "stock_max_article='" . $prod["1"]["qtemax"] . "', prix_achat_article='" . $prod["1"]["prixa"] . "', "
                        . "prix_vente_article='" . $prod["1"]["prixv"] . "', unite_achat_article='" . $prod["1"]["unitea"] . "', "
                        . "unite_vente_article='" . $prod["1"]["unitev"] . "', unite_sortie_article='" . $prod["1"]["unites"] . "', "
                        . "type_article='" . $prod["1"]["typea"] . "', image_article='" . $imageprod . "', id_categorie='" . $prod["1"]["cat"] . "', "
                        . "id_fourniture='" . $prod["1"]["four"] . "' where id_article='" . $prod["1"]["idarticle"] . "'") or die(mysqli_error($con));

                $obj = $prod["1"]["codep"] . "->" . $prod["1"]["qtes"] . "->" . $prod["1"]["prixa"];
                $op = "Modification";
                if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                    $rsltvente = $con->query("insert into hotel_historique(id_article, id_proprietaire, objet_h, operation_h, "
                            . "date_histo) values('" . $prod["1"]["idarticle"] . "', '" . $_SESSION["id_proprietaire"] . "', "
                            . "'" . $obj . "', '" . $op . "', NOW())") or die(mysqli_error($con));
                } else if (isset($_SESSION["login_personnel"]) && (isset($_SESSION["mot_de_passe_personnel"])) && ($_SESSION["etat_compte_personnel"])) {
                    if (($_SESSION["code_service"] == "ECONO")) {
                        $rsltvente = $con->query("insert into hotel_historique(id_article, id_compte_personnel, objet_h, operation_h, "
                                . "date_histo) values('" . $prod["1"]["idarticle"] . "', '" . $_SESSION["id_compte_personnel"] . "', "
                                . "'" . $obj . "', '" . $op . "', NOW())") or die(mysqli_error($con));
                    }
                }
                unset($_SESSION['formprode']);
                echo "<script language='javascript'>$('div.alertmodifbon').show('slow').delay(8000).hide('slow');</script>";

                $pag = 'hotelpages/fourniturehotel/lister_produit';
                if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                    die('<meta http-equiv="refresh" content="4; URL=indexproprietaire.php?page=' . base64_encode($pag) . '">');
                } else if (isset($_SESSION["login_personnel"]) && (isset($_SESSION["mot_de_passe_personnel"])) && ($_SESSION["etat_compte_personnel"])) {
                    if (($_SESSION["code_service"] == "ECONO")) {
                        die('<meta http-equiv="refresh" content="4; URL=indexpersonnel.php?page=' . base64_encode($pag) . '">');
                    }
                }
            } else {
                echo "<script language='javascript'>$('div.alertaddprdtmauv').show('slow').delay(8000).hide('slow');</script>";
            }
        }
    } else {
        echo "<script language='javascript'>$('div.alertaddnull').show('slow').delay(8000).hide('slow');</script>";
    }
}

function ajouter_livraison_bar($prixtotal, $com, $con) {
    if (($com != NULL)) {
        $an = date('Y');

        $codeb = "BAR";
        $rsltserv = $con->query("select * from hotel_service where code_service='" . $codeb . "'") or die(mysqli_error($con));
        $rowserv = mysqli_fetch_assoc($rsltserv);
        $rsltpl2 = $con->query("select * from hotel_bon_livraison_interne where YEAR(date_bli)='" . $an . "'") or die(mysqli_error($con));
        $obh = "";
        $numid = date('Y', time()) . sprintf("%08d", 1);
        $i = 0;
        while ($reqte = mysqli_fetch_assoc($rsltpl2)) {
            $i = $i + 1;
        }
        $numid = date('Y', time()) . sprintf("%08d", ($i + 1));
        if (isset($_SESSION["id_compte_personnel"])) {
            $rsltf = $con->query("insert into hotel_bon_livraison_interne(id_compte_personnel, id_service, code_bli, montant_bli, date_bli) "
                    . "values('" . $_SESSION["id_compte_personnel"] . "', '" . $rowserv["id_service"] . "', '" . $numid . "', '" . $prixtotal . "', "
                    . "NOW())") or die(mysqli_error($con));
        } else {
            $rsltf = $con->query("insert into hotel_bon_livraison_interne(id_service, code_bli, montant_bli, date_bli) "
                    . "values('" . $rowserv["id_service"] . "', '" . $numid . "', '" . $prixtotal . "', NOW())") or die(mysqli_error($con));
        }
        $rsltfa = $con->query("select * from hotel_bon_livraison_interne where code_bli='" . $numid . "'") or die(mysqli_error($con));
        $rowfa = mysqli_fetch_assoc($rsltfa);
        $prixt = 0;
        foreach ($_SESSION["cart_prodvlib"] as $prod) {
            $rsltreg = $con->query("insert into hotel_ligne_bon_livraison_interne(id_bon_livraison_interne, id_article, stock_lbli, "
                    . "unite_vente_lbli, unite_sortie_lbli) "
                    . "values('" . $rowfa["id_bon_livraison_interne"] . "', '" . $prod["idart"] . "', '" . $prod["qteart"] . "', "
                    . "'" . $prod["uniteartv"] . "', '" . $prod["unitearts"] . "')") or die(mysqli_error($con));
            $reqar = $con->query("select * from hotel_article where id_article='" . $prod["idart"] . "'") or die(mysqli_error($con));
            $rowar = mysqli_fetch_assoc($reqar);
            $stockar = $rowar["stock_article"] - $prod["qteart"];
            $rsltar = $con->query("update hotel_article set stock_article='" . $stockar . "' where "
                    . "id_article='" . $prod["idart"] . "'") or die(mysqli_error($con));
            $prixt = $prixt + ($prod["uniteartv"] * $prod["qteart"]);
            $obj = $prod["qteart"] . "-" . addslashes($prod["designationart"]);
            $op = "Livraison Interne";
            if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                $rsltvente = $con->query("insert into hotel_historique(id_article, id_proprietaire, objet_h, operation_h, "
                        . "date_histo) values('" . $prod["idart"] . "', '" . $_SESSION["id_proprietaire"] . "', "
                        . "'" . $obj . "', '" . $op . "', NOW())") or die(mysqli_error($con));
            } else if (isset($_SESSION["login_personnel"]) && (isset($_SESSION["mot_de_passe_personnel"])) && ($_SESSION["etat_compte_personnel"])) {
                if (($_SESSION["code_service"] == "ECONO")) {
                    $rsltvente = $con->query("insert into hotel_historique(id_article, id_compte_personnel, objet_h, operation_h, "
                            . "date_histo) values('" . $prod["idart"] . "', '" . $_SESSION["id_compte_personnel"] . "', "
                            . "'" . $obj . "', '" . $op . "', NOW())") or die(mysqli_error($con));
                }
            }
        }
        ?>
        <?php
        unset($_SESSION["cart_prodvlib"]);
        echo "<script language='javascript'>$('div.alertuseraddbon').show('slow').delay(8000).hide('slow');</script>";
        ?>
        <a href="hotelpages/barhotel/bonlivraisonhotel/facture_livraison_pdf.php?bonlivraison=<?php echo $rowfa["id_bon_livraison_interne"] ?>" class="btn btn-lg btn-success" target="_blank">
            <span title="Impriner le bon de livraison" alt="editer"><i class="fa fa-file-pdf-o"></i> Impriner le bon de livraison</span>
        </a>
        <?php
    } else {
        echo "<script language='javascript'>$('div.alertclformvide').show('slow').delay(8000).hide('slow');</script>";
    }
}

function ajouter_livraisonc_bar($id, $prixtotal, $com, $con) {
    if (($com != NULL)) {
        $an = date('Y');

        $codeb = "BAR";
        $rsltserv = $con->query("select * from hotel_service where code_service='" . $codeb . "'") or die(mysqli_error($con));
        $rowserv = mysqli_fetch_assoc($rsltserv);
        $rsltpl2 = $con->query("select * from hotel_bon_livraison_interne where YEAR(date_bli)='" . $an . "'") or die(mysqli_error($con));
        $obh = "";
        $numid = date('Y', time()) . sprintf("%08d", 1);
        $i = 0;
        while ($reqte = mysqli_fetch_assoc($rsltpl2)) {
            $i = $i + 1;
        }
        $numid = date('Y', time()) . sprintf("%08d", ($i + 1));
        if (isset($_SESSION["id_compte_personnel"])) {
            $rsltf = $con->query("insert into hotel_bon_livraison_interne(id_compte_personnel, id_service, id_bon_commande_interne, "
                    . "code_bli, montant_bli, date_bli) values('" . $_SESSION["id_compte_personnel"] . "', '" . $rowserv["id_service"] . "', "
                    . "'" . $id . "', '" . $numid . "', '" . $prixtotal . "', NOW())") or die(mysqli_error($con));
        } else {
            $rsltf = $con->query("insert into hotel_bon_livraison_interne(id_service,id_bon_commande_interne, code_bli, montant_bli, "
                    . "date_bli) values('" . $rowserv["id_service"] . "', '" . $id . "', '" . $numid . "', '" . $prixtotal . "', "
                    . "NOW())") or die(mysqli_error($con));
        }
        $rsltfa = $con->query("select * from hotel_bon_livraison_interne where code_bli='" . $numid . "'") or die(mysqli_error($con));
        $rowfa = mysqli_fetch_assoc($rsltfa);
        $prixt = 0;
        $etat = "Valider";
        $nbcomok = 0;
        foreach ($_SESSION["cart_prodvlibc" . $id] as $prod) {
            $reqar = $con->query("select * from hotel_ligne_bon_commande_interne as lbl left join hotel_article as a on "
                    . "lbl.id_article=a.id_article left join hotel_categorie as c on a.id_categorie=c.id_categorie left "
                    . "join hotel_fourniture as f on a.id_fourniture=f.id_fourniture where "
                    . "lbl.id_ligne_bon_commande_interne='" . $prod["idart"] . "'") or die(mysqli_error($con));
            $rowar = mysqli_fetch_assoc($reqar);
            $rsltreg = $con->query("insert into hotel_ligne_bon_livraison_interne(id_bon_livraison_interne, id_article, stock_lbli, "
                    . "unite_vente_lbli, unite_sortie_lbli) "
                    . "values('" . $rowfa["id_bon_livraison_interne"] . "', '" . $rowar["id_article"] . "', '" . $prod["qteart"] . "', "
                    . "'" . $prod["uniteartv"] . "', '" . $prod["unitearts"] . "')") or die(mysqli_error($con));

            $stockara = $rowar["stock_article"] - $prod["qteart"];
            $stockar = 0;
            if ($stockara >= 0) {
                $stockar = $stockara;
            } else {
                $stockar = 0;
            }
            $rsltar = $con->query("update hotel_article set stock_article='" . $stockar . "' where "
                    . "id_article='" . $rowar["id_article"] . "'") or die(mysqli_error($con));

            $slivre = $rowar["stock_livre_lbci"] + $prod["qteart"];
            if ($prod["stockok"]) {
                $rslt = $con->query("update hotel_ligne_bon_commande_interne set stock_livre_lbci='" . $slivre . "', "
                        . "etat_lbci='" . $etat . "' where id_ligne_bon_commande_interne='" . $prod["idart"] . "'") or die(mysqli_error($con));
            } else {
                $nbcomok = $nbcomok + 1;
                $rslt = $con->query("update hotel_ligne_bon_commande_interne set stock_livre_lbci='" . $slivre . "' "
                        . "where id_ligne_bon_commande_interne='" . $prod["idart"] . "'") or die(mysqli_error($con));
            }

            $prixt = $prixt + ($prod["uniteartv"] * $prod["qteart"]);
            $obj = $prod["qteart"] . "-" . addslashes($prod["designationart"]);
            $op = "Livraison Interne";
            if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                $rsltvente = $con->query("insert into hotel_historique(id_article, id_proprietaire, objet_h, operation_h, "
                        . "date_histo) values('" . $rowar["id_article"] . "', '" . $_SESSION["id_proprietaire"] . "', "
                        . "'" . $obj . "', '" . $op . "', NOW())") or die(mysqli_error($con));
            } else if (isset($_SESSION["login_personnel"]) && (isset($_SESSION["mot_de_passe_personnel"])) && ($_SESSION["etat_compte_personnel"])) {
                if (($_SESSION["code_service"] == "ECONO")) {
                    $rsltvente = $con->query("insert into hotel_historique(id_article, id_compte_personnel, objet_h, operation_h, "
                            . "date_histo) values('" . $rowar["id_article"] . "', '" . $_SESSION["id_compte_personnel"] . "', "
                            . "'" . $obj . "', '" . $op . "', NOW())") or die(mysqli_error($con));
                }
            }
        }
        if ($nbcomok == 0) {
            $rslt = $con->query("update hotel_bon_commande_interne set id_compte_personnel_validec='" . $_SESSION["id_compte_personnel"] . "', "
                    . "etat_bci='" . $etat . "' where id_bon_commande_interne='" . $id . "'") or die(mysqli_error($con));
        }
        ?>
        <?php
        unset($_SESSION["cart_prodvlibc" . $id]);
        echo "<script language='javascript'>$('div.alertuseraddbon').show('slow').delay(8000).hide('slow');</script>";
        ?>
        <a href="hotelpages/barhotel/bonlivraisonhotel/facture_livraison_pdf.php?bonlivraison=<?php echo $rowfa["id_bon_livraison_interne"] ?>" class="btn btn-lg btn-success" target="_blank">
            <span title="Impriner le bon de livraison" alt="editer"><i class="fa fa-file-pdf-o"></i> Impriner le bon de livraison</span>
        </a>

        <?php
        if (!empty($_SESSION["cart_prodvcex"])) {
            if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                ?>
                <a href="indexproprietaire.php?page=<?php echo base64_encode('hotelpages/economathotel/boncommandehotel/commande') ?>" class="btn btn-lg btn-success">
                    <span title="Commander" alt="editer">Voir la liste des articles &agrave; commander</span>
                </a>
                <?php
            } else if (isset($_SESSION["login_personnel"]) && (isset($_SESSION["mot_de_passe_personnel"])) && ($_SESSION["etat_compte_personnel"])) {
                if (($_SESSION["code_service"] == "ECONO")) {
                    ?>
                    <a href="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/economathotel/boncommandehotel/commande') ?>" class="btn btn-lg btn-success">
                        <span title="Commander" alt="editer">Voir la liste des articles &agrave; commander</span>
                    </a>
                    <?php
                }
            }
            ?>
            <?php
        }
    } else {
        echo "<script language='javascript'>$('div.alertclformvide').show('slow').delay(8000).hide('slow');</script>";
    }
}

function lister_livraison_bar($con) {
    $codeb = "BAR";
    $rsltserv = $con->query("select * from hotel_service where code_service='" . $codeb . "'") or die(mysqli_error($con));
    $rowserv = mysqli_fetch_assoc($rsltserv);
    $rsltuser = $con->query("select * from hotel_bon_livraison_interne as a left join hotel_service as c on "
            . "a.id_service=c.id_service where a.id_service='" . $rowserv["id_service"] . "' order by a.date_bli desc") or die(mysqli_error($con));
    $num = 0;
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        $num = $num + 1;
        ?>
        <tr>
            <td><?php print $num ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["code_bli"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["montant_bli"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["etat_bli"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["date_bli"])) ?></td>
            <td>
                <?php
                if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                    ?>
                    <a href="indexproprietaire.php?page=<?php echo base64_encode('hotelpages/barhotel/bonlivraisonhotel/lister_livraison_ligne') ?>&bonlivraison=<?php echo $recuser["id_bon_livraison_interne"] ?>">
                        <span title="Detail" alt="editer"><i class="glyphicon glyphicon-folder-close"></i></span>
                    </a>
                    <?php
                } else if (isset($_SESSION["login_personnel"]) && (isset($_SESSION["mot_de_passe_personnel"])) && ($_SESSION["etat_compte_personnel"])) {
                    if (($_SESSION["code_service"] == "ECONO")) {
                        ?>
                        <a href="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/barhotel/bonlivraisonhotel/lister_livraison_ligne') ?>&bonlivraison=<?php echo $recuser["id_bon_livraison_interne"] ?>">
                            <span title="Detail" alt="editer"><i class="glyphicon glyphicon-folder-close"></i></span>
                        </a>
                        <?php
                    }
                    if (($_SESSION["code_service"] == "BAR") || ($_SESSION["code_service"] == "BARESTO")) {
                        ?>
                        <a href="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/barhotel/bonlivraisonhotel/lister_livraison_ligne') ?>&bonlivraison=<?php echo $recuser["id_bon_livraison_interne"] ?>">
                            <span title="Detail" alt="editer"><i class="glyphicon glyphicon-folder-close"></i></span>
                        </a>
                        <?php
                        if ($recuser["etat_bli"] == "En Cours") {
                            ?>
                            &nbsp;&nbsp;
                            <a href='#' onclick=valider_bon_liv_bar(<?php echo $recuser["id_bon_livraison_interne"] ?>)>
                                <span title="Valider ce bon de livraison" alt="valider"><i class="glyphicon glyphicon-remove"></i></span>
                            </a>
                            <?php
                        }
                    }
                }
                ?>
            </td>
        </tr>
        <?php
    }
}

function lister_livraison_bar_alert($con) {
    $etatc = "En Cours";
    $codeb = "BAR";
    $rsltserv = $con->query("select * from hotel_service where code_service='" . $codeb . "'") or die(mysqli_error($con));
    $rowserv = mysqli_fetch_assoc($rsltserv);
    $rsltuser = $con->query("select * from hotel_bon_livraison_interne as a left join hotel_service as c on "
            . "a.id_service=c.id_service where a.etat_bli='" . $etatc . "' and a.id_service='" . $rowserv["id_service"] . "' order by a.date_bli desc") or die(mysqli_error($con));
    $num = 0;
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        $num = $num + 1;
        ?>
        <tr>
            <td><?php print $num ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["code_bli"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["montant_bli"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["etat_bli"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["date_bli"])) ?></td>
            <td>
                <?php
                if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                    ?>
                    <a href="indexproprietaire.php?page=<?php echo base64_encode('hotelpages/barhotel/bonlivraisonhotel/lister_livraison_ligne') ?>&bonlivraison=<?php echo $recuser["id_bon_livraison_interne"] ?>">
                        <span title="Detail" alt="editer"><i class="glyphicon glyphicon-folder-close"></i></span>
                    </a>
                    <?php
                } else if (isset($_SESSION["login_personnel"]) && (isset($_SESSION["mot_de_passe_personnel"])) && ($_SESSION["etat_compte_personnel"])) {
                    if (($_SESSION["code_service"] == "ECONO")) {
                        ?>
                        <a href="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/barhotel/bonlivraisonhotel/lister_livraison_ligne') ?>&bonlivraison=<?php echo $recuser["id_bon_livraison_interne"] ?>">
                            <span title="Detail" alt="editer"><i class="glyphicon glyphicon-folder-close"></i></span>
                        </a>
                        <?php
                    }
                    if (($_SESSION["code_service"] == "BAR") || ($_SESSION["code_service"] == "BARESTO")) {
                        ?>
                        <a href="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/barhotel/bonlivraisonhotel/lister_livraison_ligne') ?>&bonlivraison=<?php echo $recuser["id_bon_livraison_interne"] ?>">
                            <span title="Detail" alt="editer"><i class="glyphicon glyphicon-folder-close"></i></span>
                        </a>
                        <?php
                        if ($recuser["etat_bli"] == "En Cours") {
                            ?>
                            &nbsp;&nbsp;
                            <a href='#' onclick=valider_bon_liv_bar(<?php echo $recuser["id_bon_livraison_interne"] ?>)>
                                <span title="Valider ce bon de livraison" alt="valider"><i class="glyphicon glyphicon-remove"></i></span>
                            </a>
                            <?php
                        }
                    }
                }
                ?>
            </td>
        </tr>
        <?php
    }
}

function lister_livraison_bar_ligne($id, $con) {
    $rsltuser = $con->query("select * from hotel_ligne_bon_livraison_interne as lbl left join hotel_article as a on "
            . "lbl.id_article=a.id_article left join hotel_categorie as c on a.id_categorie=c.id_categorie where "
            . "lbl.id_bon_livraison_interne='" . $id . "'") or die(mysqli_error($con));
    $num = 0;
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        $num = $num + 1;
        ?>
        <tr>
            <td><?php print $num ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["code_article"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["libelle_article"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["libelle_categorie"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["stock_lbli"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["unite_vente_lbli"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["unite_sortie_lbli"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["etat_lbli"])) ?></td>
            <td>
                <?php
                if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                    ?>

                    <?php
                } else if (isset($_SESSION["login_personnel"]) && (isset($_SESSION["mot_de_passe_personnel"])) && ($_SESSION["etat_compte_personnel"])) {
                    if (($_SESSION["code_service"] == "ECONO")) {
                        ?>

                        <?php
                    }
                    if (($_SESSION["code_service"] == "BAR") || ($_SESSION["code_service"] == "BARESTO")) {
                        ?>
                        <?php
                        if ($recuser["etat_lbli"] == "En Cours") {
                            ?>
                            &nbsp;&nbsp;
                            <a href='#' onclick=valider_bon_liv_bar_ligne(<?php echo $recuser["id_ligne_bon_livraison_interne"] ?>)>
                                <span title="Valider cette ligne de bon de livraison" alt="valider"><i class="glyphicon glyphicon-remove"></i></span>
                            </a>
                            <?php
                        }
                    }
                }
                ?>
            </td>
        </tr>
        <?php
    }
}

function lister_magasin_bar($con) {
    $rsltuser = $con->query("select * from hotel_magasin_bar as mb left join hotel_bar as b on mb.id_bar=b.id_bar left "
            . "join hotel_article as a on mb.id_article=a.id_article left join hotel_categorie as c on "
            . "a.id_categorie=c.id_categorie ") or die(mysqli_error($con));
    $num = 0;
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        $num = $num + 1;
        ?>
        <tr>
            <td><?php print $num ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["nom_bar"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["code_article"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["libelle_article"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["libelle_categorie"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["stock_article_mb"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["stock_min_article_mb"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["stock_max_article_mb"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["unite_vente_article_mb"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["unite_sortie_article_mb"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["etat_article_mb"])) ?></td>
        </tr>
        <?php
    }
}

function lister_magasin_bar_alert($con) {
    $rsltuser = $con->query("select * from hotel_magasin_bar as mb left join hotel_bar as b on mb.id_bar=b.id_bar left "
            . "join hotel_article as a on mb.id_article=a.id_article left join hotel_categorie as c on "
            . "a.id_categorie=c.id_categorie where mb.stock_article_mb<mb.stock_min_article_mb") or die(mysqli_error($con));
    $num = 0;
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        $num = $num + 1;
        ?>
        <tr>
            <td><?php print $num ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["nom_bar"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["code_article"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["libelle_article"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["libelle_categorie"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["stock_article_mb"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["stock_min_article_mb"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["stock_max_article_mb"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["unite_vente_article_mb"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["unite_sortie_article_mb"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["etat_article_mb"])) ?></td>
        </tr>
        <?php
    }
}

function ajouter_livraison_restaurant($prixtotal, $com, $con) {
    if (($com != NULL)) {
        $an = date('Y');

        $codeb = "RESTO";
        $rsltserv = $con->query("select * from hotel_service where code_service='" . $codeb . "'") or die(mysqli_error($con));
        $rowserv = mysqli_fetch_assoc($rsltserv);
        $rsltpl2 = $con->query("select * from hotel_bon_livraison_interne where YEAR(date_bli)='" . $an . "'") or die(mysqli_error($con));
        $obh = "";
        $numid = date('Y', time()) . sprintf("%08d", 1);
        $i = 0;
        while ($reqte = mysqli_fetch_assoc($rsltpl2)) {
            $i = $i + 1;
        }
        $numid = date('Y', time()) . sprintf("%08d", ($i + 1));
        if (isset($_SESSION["id_compte_personnel"])) {
            $rsltf = $con->query("insert into hotel_bon_livraison_interne(id_compte_personnel, id_service, code_bli, montant_bli, date_bli) "
                    . "values('" . $_SESSION["id_compte_personnel"] . "', '" . $rowserv["id_service"] . "', '" . $numid . "', '" . $prixtotal . "', "
                    . "NOW())") or die(mysqli_error($con));
        } else {
            $rsltf = $con->query("insert into hotel_bon_livraison_interne(id_service, code_bli, montant_bli, date_bli) "
                    . "values('" . $rowserv["id_service"] . "', '" . $numid . "', '" . $prixtotal . "', NOW())") or die(mysqli_error($con));
        }
        $rsltfa = $con->query("select * from hotel_bon_livraison_interne where code_bli='" . $numid . "'") or die(mysqli_error($con));
        $rowfa = mysqli_fetch_assoc($rsltfa);
        $prixt = 0;
        foreach ($_SESSION["cart_prodvlir"] as $prod) {
            $rsltreg = $con->query("insert into hotel_ligne_bon_livraison_interne(id_bon_livraison_interne, id_article, stock_lbli, "
                    . "unite_vente_lbli, unite_sortie_lbli) values('" . $rowfa["id_bon_livraison_interne"] . "', '" . $prod["idart"] . "', "
                    . "'" . $prod["qteart"] . "', '" . $prod["uniteartv"] . "', '" . $prod["unitearts"] . "')") or die(mysqli_error($con));
            $reqar = $con->query("select * from hotel_article where id_article='" . $prod["idart"] . "'") or die(mysqli_error($con));
            $rowar = mysqli_fetch_assoc($reqar);
            $stockar = $rowar["stock_article"] - $prod["qteart"];
            $rsltar = $con->query("update hotel_article set stock_article='" . $stockar . "' where "
                    . "id_article='" . $prod["idart"] . "'") or die(mysqli_error($con));
            $prixt = $prixt + ($prod["uniteartv"] * $prod["qteart"]);
            $obj = $prod["qteart"] . "-" . addslashes($prod["designationart"]);
            $op = "Livraison Interne";
            if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                $rsltvente = $con->query("insert into hotel_historique(id_article, id_proprietaire, objet_h, operation_h, "
                        . "date_histo) values('" . $prod["idart"] . "', '" . $_SESSION["id_proprietaire"] . "', "
                        . "'" . $obj . "', '" . $op . "', NOW())") or die(mysqli_error($con));
            } else if (isset($_SESSION["login_personnel"]) && (isset($_SESSION["mot_de_passe_personnel"])) && ($_SESSION["etat_compte_personnel"])) {
                if (($_SESSION["code_service"] == "ECONO")) {
                    $rsltvente = $con->query("insert into hotel_historique(id_article, id_compte_personnel, objet_h, operation_h, "
                            . "date_histo) values('" . $prod["idart"] . "', '" . $_SESSION["id_compte_personnel"] . "', "
                            . "'" . $obj . "', '" . $op . "', NOW())") or die(mysqli_error($con));
                }
            }
        }
        ?>
        <?php
        unset($_SESSION["cart_prodvlir"]);
        echo "<script language='javascript'>$('div.alertuseraddbon').show('slow').delay(8000).hide('slow');</script>";
        ?>
        <a href="hotelpages/restauranthotel/bonlivraisonhotel/facture_livraison_pdf.php?bonlivraison=<?php echo $rowfa["id_bon_livraison_interne"] ?>" class="btn btn-lg btn-success" target="_blank">
            <span title="Impriner le bon de livraison" alt="editer"><i class="fa fa-file-pdf-o"></i> Impriner le bon de livraison</span>
        </a>
        <?php
    } else {
        echo "<script language='javascript'>$('div.alertclformvide').show('slow').delay(8000).hide('slow');</script>";
    }
}

function ajouter_livraisonc_restaurant($id, $prixtotal, $com, $con) {
    if (($com != NULL)) {
        $an = date('Y');

        $codeb = "RESTO";
        $rsltserv = $con->query("select * from hotel_service where code_service='" . $codeb . "'") or die(mysqli_error($con));
        $rowserv = mysqli_fetch_assoc($rsltserv);
        $rsltpl2 = $con->query("select * from hotel_bon_livraison_interne where YEAR(date_bli)='" . $an . "'") or die(mysqli_error($con));
        $obh = "";
        $numid = date('Y', time()) . sprintf("%08d", 1);
        $i = 0;
        while ($reqte = mysqli_fetch_assoc($rsltpl2)) {
            $i = $i + 1;
        }
        $numid = date('Y', time()) . sprintf("%08d", ($i + 1));
        if (isset($_SESSION["id_compte_personnel"])) {
            $rsltf = $con->query("insert into hotel_bon_livraison_interne(id_compte_personnel, id_service, id_bon_commande_interne, "
                    . "code_bli, montant_bli, date_bli) values('" . $_SESSION["id_compte_personnel"] . "', '" . $rowserv["id_service"] . "', "
                    . "'" . $id . "', '" . $numid . "', '" . $prixtotal . "', NOW())") or die(mysqli_error($con));
        } else {
            $rsltf = $con->query("insert into hotel_bon_livraison_interne(id_service,id_bon_commande_interne, code_bli, montant_bli, "
                    . "date_bli) values('" . $rowserv["id_service"] . "', '" . $id . "', '" . $numid . "', '" . $prixtotal . "', "
                    . "NOW())") or die(mysqli_error($con));
        }
        $rsltfa = $con->query("select * from hotel_bon_livraison_interne where code_bli='" . $numid . "'") or die(mysqli_error($con));
        $rowfa = mysqli_fetch_assoc($rsltfa);
        $prixt = 0;
        $etat = "Valider";
        $nbcomok = 0;
        foreach ($_SESSION["cart_prodvlirc" . $id] as $prod) {
            $reqar = $con->query("select * from hotel_ligne_bon_commande_interne as lbl left join hotel_article as a on "
                    . "lbl.id_article=a.id_article left join hotel_categorie as c on a.id_categorie=c.id_categorie left "
                    . "join hotel_fourniture as f on a.id_fourniture=f.id_fourniture where "
                    . "lbl.id_ligne_bon_commande_interne='" . $prod["idart"] . "'") or die(mysqli_error($con));
            $rowar = mysqli_fetch_assoc($reqar);
            $rsltreg = $con->query("insert into hotel_ligne_bon_livraison_interne(id_bon_livraison_interne, id_article, stock_lbli, "
                    . "unite_vente_lbli, unite_sortie_lbli) "
                    . "values('" . $rowfa["id_bon_livraison_interne"] . "', '" . $rowar["id_article"] . "', '" . $prod["qteart"] . "', "
                    . "'" . $prod["uniteartv"] . "', '" . $prod["unitearts"] . "')") or die(mysqli_error($con));

            $stockara = $rowar["stock_article"] - $prod["qteart"];
            $stockar = 0;
            if ($stockara >= 0) {
                $stockar = $stockara;
            } else {
                $stockar = 0;
            }
            $rsltar = $con->query("update hotel_article set stock_article='" . $stockar . "' where "
                    . "id_article='" . $rowar["id_article"] . "'") or die(mysqli_error($con));

            $slivre = $rowar["stock_livre_lbci"] + $prod["qteart"];
            if ($prod["stockok"]) {
                $rslt = $con->query("update hotel_ligne_bon_commande_interne set stock_livre_lbci='" . $slivre . "', "
                        . "etat_lbci='" . $etat . "' where id_ligne_bon_commande_interne='" . $prod["idart"] . "'") or die(mysqli_error($con));
            } else {
                $nbcomok = $nbcomok + 1;
                $rslt = $con->query("update hotel_ligne_bon_commande_interne set stock_livre_lbci='" . $slivre . "' "
                        . "where id_ligne_bon_commande_interne='" . $prod["idart"] . "'") or die(mysqli_error($con));
            }


            $prixt = $prixt + ($prod["uniteartv"] * $prod["qteart"]);
            $obj = $prod["qteart"] . "-" . addslashes($prod["designationart"]);
            $op = "Livraison Interne";
            if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                $rsltvente = $con->query("insert into hotel_historique(id_article, id_proprietaire, objet_h, operation_h, "
                        . "date_histo) values('" . $rowar["id_article"] . "', '" . $_SESSION["id_proprietaire"] . "', "
                        . "'" . $obj . "', '" . $op . "', NOW())") or die(mysqli_error($con));
            } else if (isset($_SESSION["login_personnel"]) && (isset($_SESSION["mot_de_passe_personnel"])) && ($_SESSION["etat_compte_personnel"])) {
                if (($_SESSION["code_service"] == "ECONO")) {
                    $rsltvente = $con->query("insert into hotel_historique(id_article, id_compte_personnel, objet_h, operation_h, "
                            . "date_histo) values('" . $rowar["id_article"] . "', '" . $_SESSION["id_compte_personnel"] . "', "
                            . "'" . $obj . "', '" . $op . "', NOW())") or die(mysqli_error($con));
                }
            }
        }
        if ($nbcomok == 0) {
            $rslt = $con->query("update hotel_bon_commande_interne set id_compte_personnel_validec='" . $_SESSION["id_compte_personnel"] . "', "
                    . "etat_bci='" . $etat . "' where id_bon_commande_interne='" . $id . "'") or die(mysqli_error($con));
        }
        ?>
        <?php
        unset($_SESSION["cart_prodvlirc" . $id]);
        echo "<script language='javascript'>$('div.alertuseraddbon').show('slow').delay(8000).hide('slow');</script>";
        ?>
        <a href="hotelpages/restauranthotel/bonlivraisonhotel/facture_livraison_pdf.php?bonlivraison=<?php echo $rowfa["id_bon_livraison_interne"] ?>" class="btn btn-lg btn-success" target="_blank">
            <span title="Impriner le bon de livraison" alt="editer"><i class="fa fa-file-pdf-o"></i> Impriner le bon de livraison</span>
        </a>

        <?php
        if (!empty($_SESSION["cart_prodvcex"])) {
            if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                ?>
                <a href="indexproprietaire.php?page=<?php echo base64_encode('hotelpages/economathotel/boncommandehotel/commande') ?>" class="btn btn-lg btn-success">
                    <span title="Commander" alt="editer">Voir la liste des articles &agrave; commander</span>
                </a>
                <?php
            } else if (isset($_SESSION["login_personnel"]) && (isset($_SESSION["mot_de_passe_personnel"])) && ($_SESSION["etat_compte_personnel"])) {
                if (($_SESSION["code_service"] == "ECONO")) {
                    ?>
                    <a href="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/economathotel/boncommandehotel/commande') ?>" class="btn btn-lg btn-success">
                        <span title="Commander" alt="editer">Voir la liste des articles &agrave; commander</span>
                    </a>
                    <?php
                }
            }
            ?>
            <?php
        }
    } else {
        echo "<script language='javascript'>$('div.alertclformvide').show('slow').delay(8000).hide('slow');</script>";
    }
}

function lister_livraison_restaurant($con) {
    $codeb = "RESTO";
    $rsltserv = $con->query("select * from hotel_service where code_service='" . $codeb . "'") or die(mysqli_error($con));
    $rowserv = mysqli_fetch_assoc($rsltserv);
    $rsltuser = $con->query("select * from hotel_bon_livraison_interne as a left join hotel_service as c on "
            . "a.id_service=c.id_service where a.id_service='" . $rowserv["id_service"] . "' order by a.date_bli desc") or die(mysqli_error($con));
    $num = 0;
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        $num = $num + 1;
        ?>
        <tr>
            <td><?php print $num ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["code_bli"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["montant_bli"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["etat_bli"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["date_bli"])) ?></td>
            <td>
                <?php
                if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                    ?>
                    <a href="indexproprietaire.php?page=<?php echo base64_encode('hotelpages/restauranthotel/bonlivraisonhotel/lister_livraison_ligne') ?>&bonlivraison=<?php echo $recuser["id_bon_livraison_interne"] ?>">
                        <span title="Detail" alt="editer"><i class="glyphicon glyphicon-folder-close"></i></span>
                    </a>
                    <?php
                } else if (isset($_SESSION["login_personnel"]) && (isset($_SESSION["mot_de_passe_personnel"])) && ($_SESSION["etat_compte_personnel"])) {
                    if (($_SESSION["code_service"] == "ECONO")) {
                        ?>
                        <a href="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/restauranthotel/bonlivraisonhotel/lister_livraison_ligne') ?>&bonlivraison=<?php echo $recuser["id_bon_livraison_interne"] ?>">
                            <span title="Detail" alt="editer"><i class="glyphicon glyphicon-folder-close"></i></span>
                        </a>
                        <?php
                    }
                    if (($_SESSION["code_service"] == "RESTO") || ($_SESSION["code_service"] == "BARESTO")) {
                        ?>
                        <a href="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/restauranthotel/bonlivraisonhotel/lister_livraison_ligne') ?>&bonlivraison=<?php echo $recuser["id_bon_livraison_interne"] ?>">
                            <span title="Detail" alt="editer"><i class="glyphicon glyphicon-folder-close"></i></span>
                        </a>
                        <?php
                        if ($recuser["etat_bli"] == "En Cours") {
                            ?>
                            &nbsp;&nbsp;
                            <a href='#' onclick=valider_bon_liv_restaurant(<?php echo $recuser["id_bon_livraison_interne"] ?>)>
                                <span title="Valider ce bon de livraison" alt="valider"><i class="glyphicon glyphicon-remove"></i></span>
                            </a>
                            <?php
                        }
                    }
                }
                ?>
            </td>
        </tr>
        <?php
    }
}

function lister_livraison_restaurant_alert($con) {
    $etatc = "En Cours";
    $codeb = "RESTO";
    $rsltserv = $con->query("select * from hotel_service where code_service='" . $codeb . "'") or die(mysqli_error($con));
    $rowserv = mysqli_fetch_assoc($rsltserv);
    $rsltuser = $con->query("select * from hotel_bon_livraison_interne as a left join hotel_service as c on "
            . "a.id_service=c.id_service where a.etat_bli='" . $etatc . "' and a.id_service='" . $rowserv["id_service"] . "' order by a.date_bli desc") or die(mysqli_error($con));
    $num = 0;
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        $num = $num + 1;
        ?>
        <tr>
            <td><?php print $num ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["code_bli"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["montant_bli"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["etat_bli"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["date_bli"])) ?></td>
            <td>
                <?php
                if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                    ?>
                    <a href="indexproprietaire.php?page=<?php echo base64_encode('hotelpages/restauranthotel/bonlivraisonhotel/lister_livraison_ligne') ?>&bonlivraison=<?php echo $recuser["id_bon_livraison_interne"] ?>">
                        <span title="Detail" alt="editer"><i class="glyphicon glyphicon-folder-close"></i></span>
                    </a>
                    <?php
                } else if (isset($_SESSION["login_personnel"]) && (isset($_SESSION["mot_de_passe_personnel"])) && ($_SESSION["etat_compte_personnel"])) {
                    if (($_SESSION["code_service"] == "ECONO")) {
                        ?>
                        <a href="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/restauranthotel/bonlivraisonhotel/lister_livraison_ligne') ?>&bonlivraison=<?php echo $recuser["id_bon_livraison_interne"] ?>">
                            <span title="Detail" alt="editer"><i class="glyphicon glyphicon-folder-close"></i></span>
                        </a>
                        <?php
                    }
                    if (($_SESSION["code_service"] == "RESTO") || ($_SESSION["code_service"] == "BARESTO")) {
                        ?>
                        <a href="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/restauranthotel/bonlivraisonhotel/lister_livraison_ligne') ?>&bonlivraison=<?php echo $recuser["id_bon_livraison_interne"] ?>">
                            <span title="Detail" alt="editer"><i class="glyphicon glyphicon-folder-close"></i></span>
                        </a>
                        <?php
                        if ($recuser["etat_bli"] == "En Cours") {
                            ?>
                            &nbsp;&nbsp;
                            <a href='#' onclick=valider_bon_liv_restaurant(<?php echo $recuser["id_bon_livraison_interne"] ?>)>
                                <span title="Valider ce bon de livraison" alt="valider"><i class="glyphicon glyphicon-remove"></i></span>
                            </a>
                            <?php
                        }
                    }
                }
                ?>
            </td>
        </tr>
        <?php
    }
}

function lister_livraison_restaurant_ligne($id, $con) {
    $rsltuser = $con->query("select * from hotel_ligne_bon_livraison_interne as lbl left join hotel_article as a on "
            . "lbl.id_article=a.id_article left join hotel_categorie as c on a.id_categorie=c.id_categorie where "
            . "lbl.id_bon_livraison_interne='" . $id . "'") or die(mysqli_error($con));
    $num = 0;
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        $num = $num + 1;
        ?>
        <tr>
            <td><?php print $num ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["code_article"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["libelle_article"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["libelle_categorie"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["stock_lbli"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["unite_vente_lbli"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["unite_sortie_lbli"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["etat_lbli"])) ?></td>
            <td>
                <?php
                if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                    ?>

                    <?php
                } else if (isset($_SESSION["login_personnel"]) && (isset($_SESSION["mot_de_passe_personnel"])) && ($_SESSION["etat_compte_personnel"])) {
                    if (($_SESSION["code_service"] == "ECONO")) {
                        ?>

                        <?php
                    }
                    if (($_SESSION["code_service"] == "RESTO") || ($_SESSION["code_service"] == "BARESTO")) {
                        ?>
                        <?php
                        if ($recuser["etat_lbli"] == "En Cours") {
                            ?>
                            &nbsp;&nbsp;
                            <a href='#' onclick=valider_bon_liv_restaurant_ligne(<?php echo $recuser["id_ligne_bon_livraison_interne"] ?>)>
                                <span title="Valider cette ligne de bon de livraison" alt="valider"><i class="glyphicon glyphicon-remove"></i></span>
                            </a>
                            <?php
                        }
                    }
                }
                ?>
            </td>
        </tr>
        <?php
    }
}

function lister_magasin_restaurant($con) {
    $rsltuser = $con->query("select * from hotel_magasin_restaurant as mb left join hotel_restaurant as b on mb.id_restaurant=b.id_restaurant left "
            . "join hotel_article as a on mb.id_article=a.id_article left join hotel_categorie as c on "
            . "a.id_categorie=c.id_categorie ") or die(mysqli_error($con));
    $num = 0;
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        $num = $num + 1;
        ?>
        <tr>
            <td><?php print $num ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["nom_rest"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["code_article"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["libelle_article"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["libelle_categorie"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["stock_article_mr"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["stock_min_article_mr"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["stock_max_article_mr"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["unite_vente_article_mr"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["unite_sortie_article_mr"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["etat_article_mr"])) ?></td>
        </tr>
        <?php
    }
}

function lister_magasin_restaurant_alert($con) {
    $rsltuser = $con->query("select * from hotel_magasin_restaurant as mb left join hotel_restaurant as b on mb.id_restaurant=b.id_restaurant left "
            . "join hotel_article as a on mb.id_article=a.id_article left join hotel_categorie as c on "
            . "a.id_categorie=c.id_categorie where mb.stock_article_mr<mb.stock_min_article_mr") or die(mysqli_error($con));
    $num = 0;
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        $num = $num + 1;
        ?>
        <tr>
            <td><?php print $num ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["nom_rest"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["code_article"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["libelle_article"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["libelle_categorie"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["stock_article_mr"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["stock_min_article_mr"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["stock_max_article_mr"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["unite_vente_article_mr"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["unite_sortie_article_mr"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["etat_article_mr"])) ?></td>
        </tr>
        <?php
    }
}

function ajouter_livraison_hebergement($logem, $cha, $std, $app, $sal, $com, $con) {
    if (($com != NULL)) {
        $an = date('Y');

        $codeb = "HEBER";
        $rsltserv = $con->query("select * from hotel_service where code_service='" . $codeb . "'") or die(mysqli_error($con));
        $rowserv = mysqli_fetch_assoc($rsltserv);
        $rsltpl2 = $con->query("select * from hotel_hebergement where YEAR(date_hebergement)='" . $an . "'") or die(mysqli_error($con));
        $obh = "";
        $numid = date('Y', time()) . sprintf("%08d", 1);
        $i = 0;
        while ($reqte = mysqli_fetch_assoc($rsltpl2)) {
            $i = $i + 1;
        }
        $numid = date('Y', time()) . sprintf("%08d", ($i + 1));
        if (isset($_SESSION["id_compte_personnel"])) {
            $rsltf = $con->query("insert into hotel_hebergement(id_compte_personnel, code_hebergement, date_hebergement) "
                    . "values('" . $_SESSION["id_compte_personnel"] . "', '" . $numid . "', NOW())") or die(mysqli_error($con));
        } else {
            $rsltf = $con->query("insert into hotel_hebergement(code_hebergement, date_hebergement) "
                    . "values('" . $numid . "', NOW())") or die(mysqli_error($con));
        }
        $rsltfa = $con->query("select * from hotel_hebergement where code_hebergement='" . $numid . "'") or die(mysqli_error($con));
        $rowfa = mysqli_fetch_assoc($rsltfa);
        $prixt = 0;
        foreach ($_SESSION["cart_prodvlih"] as $prod) {
            if ($logem == "chambre") {
                $rsltreg = $con->query("insert into hotel_ligne_hebergement(id_hebergement, id_linge, id_chambre, stock_lh, "
                        . "prix_lh) values('" . $rowfa["id_hebergement"] . "', '" . $prod["idart"] . "', '" . $cha . "', "
                        . "'" . $prod["qteart"] . "', '" . $prod["prixartl"] . "')") or die(mysqli_error($con));
            } else if ($logem == "studio") {
                $rsltreg = $con->query("insert into hotel_ligne_hebergement(id_hebergement, id_linge, id_studio, stock_lh, "
                        . "prix_lh) values('" . $rowfa["id_hebergement"] . "', '" . $prod["idart"] . "', '" . $std . "', "
                        . "'" . $prod["qteart"] . "', '" . $prod["prixartl"] . "')") or die(mysqli_error($con));
            } else if ($logem == "appartement") {
                $rsltreg = $con->query("insert into hotel_ligne_hebergement(id_hebergement, id_linge, id_appartement, stock_lh, "
                        . "prix_lh) values('" . $rowfa["id_hebergement"] . "', '" . $prod["idart"] . "', '" . $app . "', "
                        . "'" . $prod["qteart"] . "', '" . $prod["prixartl"] . "')") or die(mysqli_error($con));
            } else if ($logem == "salle") {
                $rsltreg = $con->query("insert into hotel_ligne_hebergement(id_hebergement, id_linge, id_salle, stock_lh, "
                        . "prix_lh) values('" . $rowfa["id_hebergement"] . "', '" . $prod["idart"] . "', '" . $sal . "', "
                        . "'" . $prod["qteart"] . "', '" . $prod["prixartl"] . "')") or die(mysqli_error($con));
            }
            $reqar = $con->query("select * from hotel_linge as l left join hotel_article as a on "
                    . "l.id_article=a.id_article where id_linge='" . $prod["idart"] . "'") or die(mysqli_error($con));
            $rowar = mysqli_fetch_assoc($reqar);
            $stockar = $rowar["stock_article"] - $prod["qteart"];
            $rsltar = $con->query("update hotel_article set stock_article='" . $stockar . "' where "
                    . "id_article='" . $rowar["id_article"] . "'") or die(mysqli_error($con));
            $prixt = $prixt + ($prod["prixartl"] * $prod["qteart"]);
            $obj = $prod["qteart"] . "-" . addslashes($prod["designationart"]);
            $op = "Livraison Interne";
            if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                $rsltvente = $con->query("insert into hotel_historique(id_article, id_proprietaire, objet_h, operation_h, "
                        . "date_histo) values('" . $rowar["id_article"] . "', '" . $_SESSION["id_proprietaire"] . "', "
                        . "'" . $obj . "', '" . $op . "', NOW())") or die(mysqli_error($con));
            } else if (isset($_SESSION["login_personnel"]) && (isset($_SESSION["mot_de_passe_personnel"])) && ($_SESSION["etat_compte_personnel"])) {
                if (($_SESSION["code_service"] == "ECONO")) {
                    $rsltvente = $con->query("insert into hotel_historique(id_article, id_compte_personnel, objet_h, operation_h, "
                            . "date_histo) values('" . $rowar["id_article"] . "', '" . $_SESSION["id_compte_personnel"] . "', "
                            . "'" . $obj . "', '" . $op . "', NOW())") or die(mysqli_error($con));
                }
            }
        }
        ?>
        <?php
        unset($_SESSION["cart_prodvlih"]);
        echo "<script language='javascript'>$('div.alertuseraddbon').show('slow').delay(8000).hide('slow');</script>";
        ?>
        <a href="hotelpages/hebergementhotel/bonlivraisonhotel/facture_livraison_pdf.php?bonlivraison=<?php echo $rowfa["id_hebergement"] ?>" class="btn btn-lg btn-success" target="_blank">
            <span title="Impriner le bon de livraison" alt="editer"><i class="fa fa-file-pdf-o"></i> Impriner le bon de livraison</span>
        </a>
        <?php
    } else {
        echo "<script language='javascript'>$('div.alertclformvide').show('slow').delay(8000).hide('slow');</script>";
    }
}

function ajouter_livraisonc_hebergement($id, $prixtotal, $com, $con) {
    if (($com != NULL)) {
        $an = date('Y');

        $codeb = "HEBER";
        $rsltserv = $con->query("select * from hotel_service where code_service='" . $codeb . "'") or die(mysqli_error($con));
        $rowserv = mysqli_fetch_assoc($rsltserv);
        $rsltpl2 = $con->query("select * from hotel_hebergement where YEAR(date_hebergement)='" . $an . "'") or die(mysqli_error($con));
        $obh = "";
        $numid = date('Y', time()) . sprintf("%08d", 1);
        $i = 0;
        while ($reqte = mysqli_fetch_assoc($rsltpl2)) {
            $i = $i + 1;
        }
        $numid = date('Y', time()) . sprintf("%08d", ($i + 1));

        if (isset($_SESSION["id_compte_personnel"])) {
            $rsltf = $con->query("insert into hotel_hebergement(id_compte_personnel, id_bon_commande_hebergement, "
                    . "code_hebergement, date_hebergement) values('" . $_SESSION["id_compte_personnel"] . "', '" . $id . "', "
                    . "'" . $numid . "', NOW())") or die(mysqli_error($con));
        } else {
            $rsltf = $con->query("insert into hotel_hebergement(id_bon_commande_hebergement, code_hebergement, "
                    . "date_hebergement) values('" . $id . "', '" . $numid . "', NOW())") or die(mysqli_error($con));
        }
        $rsltfa = $con->query("select * from hotel_hebergement where code_hebergement='" . $numid . "'") or die(mysqli_error($con));
        $rowfa = mysqli_fetch_assoc($rsltfa);
        $prixt = 0;
        $etat = "Valider";
        $nbcomok = 0;
        foreach ($_SESSION["cart_prodvlihc" . $id] as $prod) {
            $reqar = $con->query("select * from hotel_ligne_bon_commande_hebergement as lbl left join hotel_linge as l on "
                    . "lbl.id_linge=l.id_linge left join hotel_article as a on l.id_article=a.id_article left join hotel_categorie "
                    . "as c on a.id_categorie=c.id_categorie left join hotel_fourniture as f on a.id_fourniture=f.id_fourniture "
                    . "where lbl.id_ligne_bon_commande_hebergement='" . $prod["idart"] . "'") or die(mysqli_error($con));
            $rowar = mysqli_fetch_assoc($reqar);
            if ($rowar["id_chambre"] != NULL) {
                $rsltreg = $con->query("insert into hotel_ligne_hebergement(id_hebergement, id_linge, id_chambre, stock_lh, "
                        . "prix_lh) values('" . $rowfa["id_hebergement"] . "', '" . $rowar["id_linge"] . "', "
                        . "'" . $rowar["id_chambre"] . "', '" . $prod["qteart"] . "', '" . $prod["prixartl"] . "')") or die(mysqli_error($con));
            } else if ($rowar["id_studio"] != NULL) {
                $rsltreg = $con->query("insert into hotel_ligne_hebergement(id_hebergement, id_linge, id_studio, stock_lh, "
                        . "prix_lh) values('" . $rowfa["id_hebergement"] . "', '" . $rowar["id_linge"] . "', "
                        . "'" . $rowar["id_studio"] . "', '" . $prod["qteart"] . "', '" . $prod["prixartl"] . "')") or die(mysqli_error($con));
            } else if ($rowar["id_appartement"] != NULL) {
                $rsltreg = $con->query("insert into hotel_ligne_hebergement(id_hebergement, id_linge, id_appartement, stock_lh, "
                        . "prix_lh) values('" . $rowfa["id_hebergement"] . "', '" . $rowar["id_linge"] . "', "
                        . "'" . $rowar["id_appartement"] . "', '" . $prod["qteart"] . "', '" . $prod["prixartl"] . "')") or die(mysqli_error($con));
            } else if ($rowar["id_salle"] != NULL) {
                $rsltreg = $con->query("insert into hotel_ligne_hebergement(id_hebergement, id_linge, id_salle, stock_lh, "
                        . "prix_lh) values('" . $rowfa["id_hebergement"] . "', '" . $rowar["id_linge"] . "', "
                        . "'" . $rowar["id_salle"] . "', '" . $prod["qteart"] . "', '" . $prod["prixartl"] . "')") or die(mysqli_error($con));
            }

            if ($prod["stockok"]) {
                $rslt = $con->query("update hotel_ligne_bon_commande_hebergement set etat_lbch='" . $etat . "' where "
                        . "id_ligne_bon_commande_hebergement='" . $prod["idart"] . "'") or die(mysqli_error($con));
            } else {
                $nbcomok = $nbcomok + 1;
            }

            $stockara = $rowar["stock_article"] - $prod["qteart"];
            $stockar = 0;
            if ($stockara >= 0) {
                $stockar = $stockara;
            } else {
                $stockar = 0;
            }
            $rsltar = $con->query("update hotel_article set stock_article='" . $stockar . "' where "
                    . "id_article='" . $rowar["id_article"] . "'") or die(mysqli_error($con));
            $slivre = $rowar["stock_livre_lbch"] + $prod["qteart"];
            if ($prod["stockok"]) {
                $rslt = $con->query("update hotel_ligne_bon_commande_hebergement set stock_livre_lbch='" . $slivre . "', "
                        . "etat_lbch='" . $etat . "' where id_ligne_bon_commande_hebergement='" . $prod["idart"] . "'") or die(mysqli_error($con));
            } else {
                $nbcomok = $nbcomok + 1;
                $rslt = $con->query("update hotel_ligne_bon_commande_hebergement set stock_livre_lbch='" . $slivre . "' "
                        . "where id_ligne_bon_commande_hebergement='" . $prod["idart"] . "'") or die(mysqli_error($con));
            }
            if ($prod["stockok"]) {
                $rslt = $con->query("update hotel_ligne_bon_commande_hebergement set etat_lbch='" . $etat . "' where "
                        . "id_ligne_bon_commande_hebergement='" . $prod["idart"] . "'") or die(mysqli_error($con));
            } else {
                $nbcomok = $nbcomok + 1;
            }
            $prixt = $prixt + ($prod["prixartl"] * $prod["qteart"]);
            $obj = $prod["qteart"] . "-" . addslashes($prod["designationart"]);
            $op = "Livraison Interne";
            if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                $rsltvente = $con->query("insert into hotel_historique(id_article, id_proprietaire, objet_h, operation_h, "
                        . "date_histo) values('" . $rowar["id_article"] . "', '" . $_SESSION["id_proprietaire"] . "', "
                        . "'" . $obj . "', '" . $op . "', NOW())") or die(mysqli_error($con));
            } else if (isset($_SESSION["login_personnel"]) && (isset($_SESSION["mot_de_passe_personnel"])) && ($_SESSION["etat_compte_personnel"])) {
                if (($_SESSION["code_service"] == "ECONO")) {
                    $rsltvente = $con->query("insert into hotel_historique(id_article, id_compte_personnel, objet_h, operation_h, "
                            . "date_histo) values('" . $rowar["id_article"] . "', '" . $_SESSION["id_compte_personnel"] . "', "
                            . "'" . $obj . "', '" . $op . "', NOW())") or die(mysqli_error($con));
                }
            }
        }
        if ($nbcomok == 0) {
            $rslt = $con->query("update hotel_bon_commande_hebergement set id_compte_personnel_validec='" . $_SESSION["id_compte_personnel"] . "', "
                    . "etat_bch='" . $etat . "' where id_bon_commande_hebergement='" . $id . "'") or die(mysqli_error($con));
        }
        ?>
        <?php
        unset($_SESSION["cart_prodvlihc" . $id]);
        echo "<script language='javascript'>$('div.alertuseraddbon').show('slow').delay(8000).hide('slow');</script>";
        ?>
        <a href="hotelpages/hebergementhotel/bonlivraisonhotel/facture_livraison_pdf.php?bonlivraison=<?php echo $rowfa["id_hebergement"] ?>" class="btn btn-lg btn-success" target="_blank">
            <span title="Impriner le bon de livraison" alt="editer"><i class="fa fa-file-pdf-o"></i> Impriner le bon de livraison</span>
        </a>

        <?php
        if (!empty($_SESSION["cart_prodvcex"])) {
            if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                ?>
                <a href="indexproprietaire.php?page=<?php echo base64_encode('hotelpages/economathotel/boncommandehotel/commande') ?>" class="btn btn-lg btn-success">
                    <span title="Commander" alt="editer">Voir la liste des articles &agrave; commander</span>
                </a>
                <?php
            } else if (isset($_SESSION["login_personnel"]) && (isset($_SESSION["mot_de_passe_personnel"])) && ($_SESSION["etat_compte_personnel"])) {
                if (($_SESSION["code_service"] == "ECONO")) {
                    ?>
                    <a href="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/economathotel/boncommandehotel/commande') ?>" class="btn btn-lg btn-success">
                        <span title="Commander" alt="editer">Voir la liste des articles &agrave; commander</span>
                    </a>
                    <?php
                }
            }
            ?>
            <?php
        }
    } else {
        echo "<script language='javascript'>$('div.alertclformvide').show('slow').delay(8000).hide('slow');</script>";
    }
}

function lister_livraison_hebergement($con) {
    $codeb = "HEBER";
    $etath = "Sale";
    $rsltserv = $con->query("select * from hotel_service where code_service='" . $codeb . "'") or die(mysqli_error($con));
    $rowserv = mysqli_fetch_assoc($rsltserv);
    $rsltuser = $con->query("select * from hotel_hebergement as a order by a.date_hebergement desc") or die(mysqli_error($con));
    $num = 0;
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        $num = $num + 1;
        ?>
        <tr>
            <td><?php print $num ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["code_hebergement"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["etat_hebergement"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["date_hebergement"])) ?></td>
            <td>
                <?php
                if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                    ?>
                    <a href="indexproprietaire.php?page=<?php echo base64_encode('hotelpages/hebergementhotel/bonlivraisonhotel/lister_livraison_ligne') ?>&bonlivraison=<?php echo $recuser["id_hebergement"] ?>">
                        <span title="Detail" alt="editer"><i class="glyphicon glyphicon-folder-close"></i></span>
                    </a>
                    <?php
                } else if (isset($_SESSION["login_personnel"]) && (isset($_SESSION["mot_de_passe_personnel"])) && ($_SESSION["etat_compte_personnel"])) {
                    if (($_SESSION["code_service"] == "ECONO")) {
                        ?>
                        <a href="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/hebergementhotel/bonlivraisonhotel/lister_livraison_ligne') ?>&bonlivraison=<?php echo $recuser["id_hebergement"] ?>">
                            <span title="Detail" alt="editer"><i class="glyphicon glyphicon-folder-close"></i></span>
                        </a>
                        <?php
                    }
                    if (($_SESSION["code_service"] == "HEBER")) {
                        ?>
                        <a href="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/hebergementhotel/bonlivraisonhotel/lister_livraison_ligne') ?>&bonlivraison=<?php echo $recuser["id_hebergement"] ?>">
                            <span title="Detail" alt="editer"><i class="glyphicon glyphicon-folder-close"></i></span>
                        </a>
                        <?php
                        if ($recuser["etat_hebergement"] == "En Cours") {
                            ?>
                            &nbsp;&nbsp;
                            <a href='#' onclick=valider_bon_liv_hebergement(<?php echo $recuser["id_hebergement"] ?>)>
                                <span title="Valider ce bon de livraison" alt="valider"><i class="glyphicon glyphicon-remove"></i></span>
                            </a>
                            <?php
                        }
                    }
                }
                ?>
            </td>
        </tr>
        <?php
    }
}

function lister_livraison_hebergement_alert($con) {
    $etatc = "En Cours";
    $rsltuser = $con->query("select * from hotel_hebergement as a where a.etat_hebergement='" . $etatc . "' order by a.date_hebergement desc") or die(mysqli_error($con));
    $num = 0;
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        $num = $num + 1;
        ?>
        <tr>
            <td><?php print $num ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["code_hebergement"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["etat_hebergement"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["date_hebergement"])) ?></td>
            <td>
                <?php
                if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                    ?>
                    <a href="indexproprietaire.php?page=<?php echo base64_encode('hotelpages/hebergementhotel/bonlivraisonhotel/lister_livraison_ligne') ?>&bonlivraison=<?php echo $recuser["id_hebergement"] ?>">
                        <span title="Detail" alt="editer"><i class="glyphicon glyphicon-folder-close"></i></span>
                    </a>
                    <?php
                } else if (isset($_SESSION["login_personnel"]) && (isset($_SESSION["mot_de_passe_personnel"])) && ($_SESSION["etat_compte_personnel"])) {
                    if (($_SESSION["code_service"] == "ECONO")) {
                        ?>
                        <a href="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/hebergementhotel/bonlivraisonhotel/lister_livraison_ligne') ?>&bonlivraison=<?php echo $recuser["id_hebergement"] ?>">
                            <span title="Detail" alt="editer"><i class="glyphicon glyphicon-folder-close"></i></span>
                        </a>
                        <?php
                    }
                    if (($_SESSION["code_service"] == "HEBER")) {
                        ?>
                        <a href="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/hebergementhotel/bonlivraisonhotel/lister_livraison_ligne') ?>&bonlivraison=<?php echo $recuser["id_hebergement"] ?>">
                            <span title="Detail" alt="editer"><i class="glyphicon glyphicon-folder-close"></i></span>
                        </a>
                        <?php
                        if ($recuser["etat_hebergement"] == "En Cours") {
                            ?>
                            &nbsp;&nbsp;
                            <a href='#' onclick=valider_bon_liv_hebergement(<?php echo $recuser["id_hebergement"] ?>)>
                                <span title="Valider ce bon de livraison" alt="valider"><i class="glyphicon glyphicon-remove"></i></span>
                            </a>
                            <?php
                        }
                    }
                }
                ?>
            </td>
        </tr>
        <?php
    }
}

function lister_livraison_hebergement_ligne($id, $con) {
    $rsltuser = $con->query("select * from hotel_ligne_hebergement as lbl left join hotel_linge as l on "
            . "lbl.id_linge=l.id_linge left join hotel_article as a on l.id_article=a.id_article left join "
            . "hotel_categorie as c on a.id_categorie=c.id_categorie where "
            . "lbl.id_hebergement='" . $id . "'") or die(mysqli_error($con));
    $num = 0;
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        $num = $num + 1;
        ?>
        <tr>
            <td><?php print $num ?></td>
            <td>
                <?php
                if ($recuser["id_chambre"] != NULL) {
                    $reqch = $con->query("select * from hotel_chambre as c left join hotel_point_hotel as ph on c.id_point_hotel=ph.id_point_hotel "
                            . "left join hotel_proprietaire as p on ph.id_proprietaire=p.id_proprietaire where c.id_chambre= '" . $recuser["id_chambre"] . "' ") or die(mysqli_error($con));
                    $rowch = mysqli_fetch_assoc($reqch);
                    ?>
                    <?php print nl2br(htmlspecialchars($rowch["code_c"])) ?>
                    <?php
                } else if ($recuser["id_studio"] != NULL) {
                    $reqst = $con->query("select * from hotel_studio as s left join hotel_point_hotel as ph on s.id_point_hotel=ph.id_point_hotel "
                            . "left join hotel_proprietaire as p on ph.id_proprietaire=p.id_proprietaire where s.id_studio= '" . $recuser["id_studio"] . "' ") or die(mysqli_error($con));
                    $rowst = mysqli_fetch_assoc($reqst);
                    ?>
                    <?php print nl2br(htmlspecialchars($rowst["code_s"])) ?>
                    <?php
                } else if ($recuser["id_appartement"] != NULL) {
                    $reqap = $con->query("select * from hotel_appartement as a left join hotel_point_hotel as ph on a.id_point_hotel=ph.id_point_hotel "
                            . "left join hotel_proprietaire as p on ph.id_proprietaire=p.id_proprietaire where a.id_appartement= '" . $recuser["id_appartement"] . "' ") or die(mysqli_error($con));
                    $rowap = mysqli_fetch_assoc($reqap);
                    ?>
                    <?php print nl2br(htmlspecialchars($rowap["code_a"])) ?> 
                    <?php print $rowap["nbchambre_a"] ?>Ch  
                    <?php echo $rowap["nbsalon_a"] ?>S  
                    <?php echo $rowap["nbdouche_a"] ?>D  
                    <?php echo $rowap["nbcuisine_a"] ?>Cu 
                    <?php
                } else if ($recuser["id_salle"] != NULL) {
                    $reqsa = $con->query("select * from hotel_salle as s left join hotel_point_hotel as ph on s.id_point_hotel=ph.id_point_hotel "
                            . "left join hotel_proprietaire as p on ph.id_proprietaire=p.id_proprietaire where s.id_salle= '" . $recuser["id_salle"] . "' ") or die(mysqli_error($con));
                    $rowsa = mysqli_fetch_assoc($reqsa);
                    ?>
                    <?php print nl2br(htmlspecialchars($rowsa["code_salle"])) ?>
                    <?php
                }
                ?>
            </td>
            <td><?php print nl2br(htmlspecialchars($recuser["code_article"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["libelle_article"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["libelle_categorie"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["stock_lh"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["prix_lh"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["etat_lh"])) ?></td>
            <td>
                <?php
                if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                    ?>

                    <?php
                } else if (isset($_SESSION["login_personnel"]) && (isset($_SESSION["mot_de_passe_personnel"])) && ($_SESSION["etat_compte_personnel"])) {
                    if (($_SESSION["code_service"] == "ECONO")) {
                        ?>

                        <?php
                    }
                    if (($_SESSION["code_service"] == "HEBER")) {
                        ?>
                        <?php
                        if ($recuser["etat_lh"] == "En Cours") {
                            ?>
                            &nbsp;&nbsp;
                            <a href='#' onclick=valider_bon_liv_hebergement_ligne(<?php echo $recuser["id_ligne_hebergement"] ?>)>
                                <span title="Valider cette ligne de bon de livraison" alt="valider"><i class="glyphicon glyphicon-remove"></i></span>
                            </a>
                            <?php
                        }
                    }
                }
                ?>
            </td>
        </tr>
        <?php
    }
}

function lister_magasin_hebergement($con) {
    $eta = "Valider";
    $rsltuser = $con->query("select * from hotel_magasin_linge as ml left join hotel_linge as l on "
            . "ml.id_linge=l.id_linge left join hotel_article as a on l.id_article=a.id_article left join "
            . "hotel_categorie as c on a.id_categorie=c.id_categorie ") or die(mysqli_error($con));
    $num = 0;
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        $num = $num + 1;
        ?>
        <tr>
            <td><?php print $num ?></td>
            <td>
                <?php
                if ($recuser["id_chambre"] != NULL) {
                    $reqch = $con->query("select * from hotel_chambre as c left join hotel_point_hotel as ph on c.id_point_hotel=ph.id_point_hotel "
                            . "left join hotel_proprietaire as p on ph.id_proprietaire=p.id_proprietaire where c.id_chambre= '" . $recuser["id_chambre"] . "' ") or die(mysqli_error($con));
                    $rowch = mysqli_fetch_assoc($reqch);
                    ?>
                    <?php print nl2br(htmlspecialchars($rowch["code_c"])) ?>
                    <?php
                } else if ($recuser["id_studio"] != NULL) {
                    $reqst = $con->query("select * from hotel_studio as s left join hotel_point_hotel as ph on s.id_point_hotel=ph.id_point_hotel "
                            . "left join hotel_proprietaire as p on ph.id_proprietaire=p.id_proprietaire where s.id_studio= '" . $recuser["id_studio"] . "' ") or die(mysqli_error($con));
                    $rowst = mysqli_fetch_assoc($reqst);
                    ?>
                    <?php print nl2br(htmlspecialchars($rowst["code_s"])) ?>
                    <?php
                } else if ($recuser["id_appartement"] != NULL) {
                    $reqap = $con->query("select * from hotel_appartement as a left join hotel_point_hotel as ph on a.id_point_hotel=ph.id_point_hotel "
                            . "left join hotel_proprietaire as p on ph.id_proprietaire=p.id_proprietaire where a.id_appartement= '" . $recuser["id_appartement"] . "' ") or die(mysqli_error($con));
                    $rowap = mysqli_fetch_assoc($reqap);
                    ?>
                    <?php print nl2br(htmlspecialchars($rowap["code_a"])) ?> 
                    <?php print $rowap["nbchambre_a"] ?>Ch  
                    <?php echo $rowap["nbsalon_a"] ?>S  
                    <?php echo $rowap["nbdouche_a"] ?>D  
                    <?php echo $rowap["nbcuisine_a"] ?>Cu 
                    <?php
                } else if ($recuser["id_salle"] != NULL) {
                    $reqsa = $con->query("select * from hotel_salle as s left join hotel_point_hotel as ph on s.id_point_hotel=ph.id_point_hotel "
                            . "left join hotel_proprietaire as p on ph.id_proprietaire=p.id_proprietaire where s.id_salle= '" . $recuser["id_salle"] . "' ") or die(mysqli_error($con));
                    $rowsa = mysqli_fetch_assoc($reqsa);
                    ?>
                    <?php print nl2br(htmlspecialchars($rowsa["code_salle"])) ?>
                    <?php
                }
                ?>
            </td>
            <td><?php print nl2br(htmlspecialchars($recuser["code_article"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["libelle_article"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["libelle_categorie"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["stock_ml"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["prix_lavage_ml"])) ?></td>
            <td>
                <?php
                if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                    if ($recuser["stock_ml"] >= 1) {
                        ?>
                        <a href="indexproprietaire.php?page=<?php echo base64_encode('hotelpages/hebergementhotel/magasinhotel/ajouter_panier') ?>&actionp=add&idp=<?php echo $recuser["id_magasin_linge"]; ?>">
                            <span title="Ajouter &agrave; la pile de linges sales" alt="linge sale"><i class="glyphicon glyphicon-transfer"></i></span>
                        </a>
                        <?php
                    }
                } else if (isset($_SESSION["login_personnel"]) && (isset($_SESSION["mot_de_passe_personnel"])) && ($_SESSION["etat_compte_personnel"])) {
                    if (($_SESSION["code_service"] == "HEBER")) {
                        if ($recuser["stock_ml"] >= 1) {
                            ?>
                            <a href="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/hebergementhotel/magasinhotel/ajouter_panier') ?>&actionp=add&idp=<?php echo $recuser["id_magasin_linge"]; ?>">
                                <span title="Ajouter &agrave; la pile de linges sales" alt="linge sale"><i class="glyphicon glyphicon-transfer"></i></span>
                            </a>
                            <?php
                        }
                    }
                }
                ?>
            </td>
        </tr>
        <?php
    }
}

function lister_magasin_hebergement_alert($con) {
    $rsltuser = $con->query("select * from hotel_magasin_linge as ml left join hotel_linge as l on "
            . "ml.id_linge=l.id_linge left join hotel_article as a on l.id_article=a.id_article left join "
            . "hotel_categorie as c on a.id_categorie=c.id_categorie where ml.stock_ml=0") or die(mysqli_error($con));
    $num = 0;
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        $num = $num + 1;
        ?>
        <tr>
            <td><?php print $num ?></td>
            <td>
                <?php
                if ($recuser["id_chambre"] != NULL) {
                    $reqch = $con->query("select * from hotel_chambre as c left join hotel_point_hotel as ph on c.id_point_hotel=ph.id_point_hotel "
                            . "left join hotel_proprietaire as p on ph.id_proprietaire=p.id_proprietaire where c.id_chambre= '" . $recuser["id_chambre"] . "' ") or die(mysqli_error($con));
                    $rowch = mysqli_fetch_assoc($reqch);
                    ?>
                    <?php print nl2br(htmlspecialchars($rowch["code_c"])) ?>
                    <?php
                } else if ($recuser["id_studio"] != NULL) {
                    $reqst = $con->query("select * from hotel_studio as s left join hotel_point_hotel as ph on s.id_point_hotel=ph.id_point_hotel "
                            . "left join hotel_proprietaire as p on ph.id_proprietaire=p.id_proprietaire where s.id_studio= '" . $recuser["id_studio"] . "' ") or die(mysqli_error($con));
                    $rowst = mysqli_fetch_assoc($reqst);
                    ?>
                    <?php print nl2br(htmlspecialchars($rowst["code_s"])) ?>
                    <?php
                } else if ($recuser["id_appartement"] != NULL) {
                    $reqap = $con->query("select * from hotel_appartement as a left join hotel_point_hotel as ph on a.id_point_hotel=ph.id_point_hotel "
                            . "left join hotel_proprietaire as p on ph.id_proprietaire=p.id_proprietaire where a.id_appartement= '" . $recuser["id_appartement"] . "' ") or die(mysqli_error($con));
                    $rowap = mysqli_fetch_assoc($reqap);
                    ?>
                    <?php print nl2br(htmlspecialchars($rowap["code_a"])) ?> 
                    <?php print $rowap["nbchambre_a"] ?>Ch  
                    <?php echo $rowap["nbsalon_a"] ?>S  
                    <?php echo $rowap["nbdouche_a"] ?>D  
                    <?php echo $rowap["nbcuisine_a"] ?>Cu 
                    <?php
                } else if ($recuser["id_salle"] != NULL) {
                    $reqsa = $con->query("select * from hotel_salle as s left join hotel_point_hotel as ph on s.id_point_hotel=ph.id_point_hotel "
                            . "left join hotel_proprietaire as p on ph.id_proprietaire=p.id_proprietaire where s.id_salle= '" . $recuser["id_salle"] . "' ") or die(mysqli_error($con));
                    $rowsa = mysqli_fetch_assoc($reqsa);
                    ?>
                    <?php print nl2br(htmlspecialchars($rowsa["code_salle"])) ?>
                    <?php
                }
                ?>
            </td>
            <td><?php print nl2br(htmlspecialchars($recuser["code_article"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["libelle_article"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["libelle_categorie"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["stock_ml"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["prix_lavage_ml"])) ?></td>
            <td>
                <?php
                if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                    if ($recuser["stock_ml"] >= 1) {
                        ?>
                        <a href="indexproprietaire.php?page=<?php echo base64_encode('hotelpages/hebergementhotel/magasinhotel/ajouter_panier') ?>&actionp=add&idp=<?php echo $recuser["id_magasin_linge"]; ?>">
                            <span title="Ajouter &agrave; la pile de linges sales" alt="linge sale"><i class="glyphicon glyphicon-transfer"></i></span>
                        </a>
                        <?php
                    }
                } else if (isset($_SESSION["login_personnel"]) && (isset($_SESSION["mot_de_passe_personnel"])) && ($_SESSION["etat_compte_personnel"])) {
                    if (($_SESSION["code_service"] == "HEBER")) {
                        if ($recuser["stock_ml"] >= 1) {
                            ?>
                            <a href="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/hebergementhotel/magasinhotel/ajouter_panier') ?>&actionp=add&idp=<?php echo $recuser["id_magasin_linge"]; ?>">
                                <span title="Ajouter &agrave; la pile de linges sales" alt="linge sale"><i class="glyphicon glyphicon-transfer"></i></span>
                            </a>
                            <?php
                        }
                    }
                }
                ?>
            </td>
        </tr>
        <?php
    }
}

function ajouter_linge_sale_hebergement($com, $con) {
    if (($com != NULL)) {

        foreach ($_SESSION["cart_prodvmls"] as $prod) {

            $reqamb = $con->query("select * from hotel_magasin_linge_sale where id_magasin_linge='" . $prod["idart"] . "'") or die(mysqli_error($con));
            $nbamb = mysqli_num_rows($reqamb);
            if ($nbamb != 0) {
                $rowamb = mysqli_fetch_assoc($reqamb);
                $stock = $rowamb["stock_linge_sale"] + $prod["qteart"];
                $rsltl = $con->query("update hotel_magasin_linge_sale set stock_linge_sale='" . $stock . "' "
                        . "where id_linge_sale='" . $rowamb["id_linge_sale"] . "'") or die(mysqli_error($con));
            } else {
                $rsltl = $con->query("insert into hotel_magasin_linge_sale set id_magasin_linge='" . $prod["idart"] . "', "
                        . "stock_linge_sale='" . $prod["qteart"] . "', prix_lavage_linge_sale='" . $prod["prixartl"] . "', "
                        . "date_linge_sale=NOW() ")
                        or die(mysqli_error($con));
            }

            $rsltlts = $con->query("insert into hotel_transfert_linge_sale set id_magasin_linge='" . $prod["idart"] . "', "
                    . "stock_tls='" . $prod["qteart"] . "', prix_lavage_tls='" . $prod["prixartl"] . "', "
                    . "date_tls=NOW() ") or die(mysqli_error($con));
            $reqar = $con->query("select * from hotel_magasin_linge as ml left join hotel_linge as l on ml.id_linge=l.id_linge "
                    . "left join hotel_article as a on l.id_article=a.id_article where ml.id_magasin_linge='" . $prod["idart"] . "'") or die(mysqli_error($con));
            $rowar = mysqli_fetch_assoc($reqar);
            $stockar = $rowar["stock_ml"] - $prod["qteart"];
            $rsltar = $con->query("update hotel_magasin_linge set stock_ml='" . $stockar . "' where "
                    . "id_magasin_linge='" . $prod["idart"] . "'") or die(mysqli_error($con));
            $obj = $prod["qteart"] . "-" . addslashes($prod["designationart"]);
            $op = "Linge sale";
            if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                $rsltvente = $con->query("insert into hotel_historique(id_article, id_proprietaire, objet_h, operation_h, "
                        . "date_histo) values('" . $rowar["id_article"] . "', '" . $_SESSION["id_proprietaire"] . "', "
                        . "'" . $obj . "', '" . $op . "', NOW())") or die(mysqli_error($con));
            } else if (isset($_SESSION["login_personnel"]) && (isset($_SESSION["mot_de_passe_personnel"])) && ($_SESSION["etat_compte_personnel"])) {
                if (($_SESSION["code_service"] == "ECONO")) {
                    $rsltvente = $con->query("insert into hotel_historique(id_article, id_compte_personnel, objet_h, operation_h, "
                            . "date_histo) values('" . $rowar["id_article"] . "', '" . $_SESSION["id_compte_personnel"] . "', "
                            . "'" . $obj . "', '" . $op . "', NOW())") or die(mysqli_error($con));
                }
            }
        }
        ?>
        <?php
        unset($_SESSION["cart_prodvmls"]);
        echo "<script language='javascript'>$('div.alertuseraddbon').show('slow').delay(8000).hide('slow');</script>";
    } else {
        echo "<script language='javascript'>$('div.alertclformvide').show('slow').delay(8000).hide('slow');</script>";
    }
}

function lister_magasin_linge_sale($con) {
    $rsltuser = $con->query("select * from hotel_magasin_linge_sale as mls left join hotel_magasin_linge as ml on "
            . "mls.id_magasin_linge=ml.id_magasin_linge left join hotel_linge as l on ml.id_linge=l.id_linge left join "
            . "hotel_article as a on l.id_article=a.id_article left join hotel_categorie as c on "
            . "a.id_categorie=c.id_categorie ") or die(mysqli_error($con));
    $num = 0;
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        $num = $num + 1;
        ?>
        <tr>
            <td><?php print $num ?></td>
            <td>
                <?php
                if ($recuser["id_chambre"] != NULL) {
                    $reqch = $con->query("select * from hotel_chambre as c left join hotel_point_hotel as ph on c.id_point_hotel=ph.id_point_hotel "
                            . "left join hotel_proprietaire as p on ph.id_proprietaire=p.id_proprietaire where c.id_chambre= '" . $recuser["id_chambre"] . "' ") or die(mysqli_error($con));
                    $rowch = mysqli_fetch_assoc($reqch);
                    ?>
                    <?php print nl2br(htmlspecialchars($rowch["code_c"])) ?>
                    <?php
                } else if ($recuser["id_studio"] != NULL) {
                    $reqst = $con->query("select * from hotel_studio as s left join hotel_point_hotel as ph on s.id_point_hotel=ph.id_point_hotel "
                            . "left join hotel_proprietaire as p on ph.id_proprietaire=p.id_proprietaire where s.id_studio= '" . $recuser["id_studio"] . "' ") or die(mysqli_error($con));
                    $rowst = mysqli_fetch_assoc($reqst);
                    ?>
                    <?php print nl2br(htmlspecialchars($rowst["code_s"])) ?>
                    <?php
                } else if ($recuser["id_appartement"] != NULL) {
                    $reqap = $con->query("select * from hotel_appartement as a left join hotel_point_hotel as ph on a.id_point_hotel=ph.id_point_hotel "
                            . "left join hotel_proprietaire as p on ph.id_proprietaire=p.id_proprietaire where a.id_appartement= '" . $recuser["id_appartement"] . "' ") or die(mysqli_error($con));
                    $rowap = mysqli_fetch_assoc($reqap);
                    ?>
                    <?php print nl2br(htmlspecialchars($rowap["code_a"])) ?> 
                    <?php print $rowap["nbchambre_a"] ?>Ch  
                    <?php echo $rowap["nbsalon_a"] ?>S  
                    <?php echo $rowap["nbdouche_a"] ?>D  
                    <?php echo $rowap["nbcuisine_a"] ?>Cu 
                    <?php
                } else if ($recuser["id_salle"] != NULL) {
                    $reqsa = $con->query("select * from hotel_salle as s left join hotel_point_hotel as ph on s.id_point_hotel=ph.id_point_hotel "
                            . "left join hotel_proprietaire as p on ph.id_proprietaire=p.id_proprietaire where s.id_salle= '" . $recuser["id_salle"] . "' ") or die(mysqli_error($con));
                    $rowsa = mysqli_fetch_assoc($reqsa);
                    ?>
                    <?php print nl2br(htmlspecialchars($rowsa["code_salle"])) ?>
                    <?php
                }
                ?>
            </td>
            <td><?php print nl2br(htmlspecialchars($recuser["code_article"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["libelle_article"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["libelle_categorie"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["stock_linge_sale"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["prix_lavage_linge_sale"])) ?></td>
            <td>
                <?php
                if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                    if ($recuser["stock_linge_sale"] >= 1) {
                        ?>
                        <a href="indexproprietaire.php?page=<?php echo base64_encode('hotelpages/hebergementhotel/magasinsalehotel/ajouter_panier') ?>&actionp=add&idp=<?php echo $recuser["id_linge_sale"]; ?>">
                            <span title="Envoyer ce linge chez le blanchisseur" alt="blanchisseur"><i class="glyphicon glyphicon-transfer" alt="blanchisseur"></i></span>
                        </a>
                        <?php
                    }
                } else if (isset($_SESSION["login_personnel"]) && (isset($_SESSION["mot_de_passe_personnel"])) && ($_SESSION["etat_compte_personnel"])) {
                    if (($_SESSION["code_service"] == "ECONO")) {
                        if ($recuser["stock_linge_sale"] >= 1) {
                            ?>
                            <a href="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/hebergementhotel/magasinsalehotel/ajouter_panier') ?>&actionp=add&idp=<?php echo $recuser["id_linge_sale"]; ?>">
                                <span title="Envoyer ce linge chez le blanchisseur" alt="blanchisseur"><i class="glyphicon glyphicon-transfer" alt="blanchisseur"></i></span>
                            </a>
                            <?php
                        }
                    }
                }
                ?>
            </td>
        </tr>
        <?php
    }
}

function ajouter_menu_restaurant($nomme, $prixplatme, $typeme, $prixtm, $com, $con) {
    if (($com != NULL)) {
        $nomme = addslashes($nomme);
        $an = date('Y');
        $reqb = $con->query("select * from hotel_restaurant limit 0,1") or die(mysqli_error($con));
        $rowb = mysqli_fetch_assoc($reqb);
        $rsltpl2 = $con->query("select * from hotel_menu where YEAR(date_menu)='" . $an . "'") or die(mysqli_error($con));
        $obh = "";
        $numid = date('Y', time()) . sprintf("%08d", 1);
        $i = 0;
        while ($reqte = mysqli_fetch_assoc($rsltpl2)) {
            $i = $i + 1;
        }
        $numid = date('Y', time()) . sprintf("%08d", ($i + 1));
        $rsltf = $con->query("insert into hotel_menu(id_restaurant, code_menu, nom_menu, prix_mr, prix_plat_mr, "
                . "type_mr, date_menu) values('" . $rowb["id_restaurant"] . "', '" . $numid . "', '" . $nomme . "', "
                . "'" . $prixtm . "', '" . $prixplatme . "', '" . $typeme . "', NOW())") or die(mysqli_error($con));

        $rsltfa = $con->query("select * from hotel_menu where code_menu='" . $numid . "'") or die(mysqli_error($con));
        $rowfa = mysqli_fetch_assoc($rsltfa);

        foreach ($_SESSION["cart_prodvmenu"] as $prod) {

            $reqar = $con->query("select * from hotel_magasin_restaurant where id_magasin_restaurant='" . $prod["idart"] . "'") or die(mysqli_error($con));
            $rowar = mysqli_fetch_assoc($reqar);
            $rsltreg = $con->query("insert into hotel_menu_restaurant(id_menu, id_magasin_restaurant, stock_mr, "
                    . "prix_mr) values('" . $rowfa["id_menu"] . "', '" . $prod["idart"] . "', "
                    . "'" . $prod["qteart"] . "', '" . $prod["uniteartv"] . "')") or die(mysqli_error($con));

            $stockar = $rowar["stock_article_mr"] - $prod["qteart"];
            $rsltar = $con->query("update hotel_magasin_restaurant set stock_article_mr='" . $stockar . "' where "
                    . "id_magasin_restaurant='" . $prod["idart"] . "'") or die(mysqli_error($con));

            $obj = $prod["qteart"] . "-" . addslashes($prod["designationart"]);
            $op = "Creation menu";
            if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                $rsltvente = $con->query("insert into hotel_historique(id_article, id_proprietaire, objet_h, operation_h, "
                        . "date_histo) values('" . $rowar["id_article"] . "', '" . $_SESSION["id_proprietaire"] . "', "
                        . "'" . $obj . "', '" . $op . "', NOW())") or die(mysqli_error($con));
            } else if (isset($_SESSION["login_personnel"]) && (isset($_SESSION["mot_de_passe_personnel"])) && ($_SESSION["etat_compte_personnel"])) {
                if (($_SESSION["code_service"] == "ECONO")) {
                    $rsltvente = $con->query("insert into hotel_historique(id_article, id_compte_personnel, objet_h, operation_h, "
                            . "date_histo) values('" . $rowar["id_article"] . "', '" . $_SESSION["id_compte_personnel"] . "', "
                            . "'" . $obj . "', '" . $op . "', NOW())") or die(mysqli_error($con));
                }
            }
        }
        ?>
        <?php
        unset($_SESSION["cart_prodvmenu"]);
        echo "<script language='javascript'>$('div.alertuseraddbon').show('slow').delay(8000).hide('slow');</script>";
        ?>
        <?php
    } else {
        echo "<script language='javascript'>$('div.alertclformvide').show('slow').delay(8000).hide('slow');</script>";
    }
}

function lister_menu($con) {
    $rsltuser = $con->query("select * from hotel_menu as a order by a.nom_menu asc") or die(mysqli_error($con));
    $num = 0;
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        $num = $num + 1;
        ?>
        <tr>
            <td><?php print $num ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["code_menu"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["nom_menu"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["prix_mr"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["prix_plat_mr"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["type_mr"])) ?></td>
            <td>
                <?php
                if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                    ?>
                    <a href="indexproprietaire.php?page=<?php echo base64_encode('hotelpages/restauranthotel/menuhotel/lister_menu_ligne') ?>&menu=<?php echo $recuser["id_menu"] ?>">
                        <span title="Detail" alt="editer"><i class="glyphicon glyphicon-folder-close"></i></span>
                    </a>
                    <?php
                } else if (isset($_SESSION["login_personnel"]) && (isset($_SESSION["mot_de_passe_personnel"])) && ($_SESSION["etat_compte_personnel"])) {
                    if (($_SESSION["code_service"] == "ECONO")) {
                        ?>
                        <a href="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/restauranthotel/menuhotel/lister_menu_ligne') ?>&menu=<?php echo $recuser["id_menu"] ?>">
                            <span title="Detail" alt="editer"><i class="glyphicon glyphicon-folder-close"></i></span>
                        </a>
                        <?php
                    }
                    if (($_SESSION["code_service"] == "RESTO") || ($_SESSION["code_service"] == "BARESTO")) {
                        ?>
                        <a href="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/restauranthotel/menuhotel/lister_menu_ligne') ?>&menu=<?php echo $recuser["id_menu"] ?>">
                            <span title="Detail" alt="editer"><i class="glyphicon glyphicon-folder-close"></i></span>
                        </a>
                        <?php
                        if (!$recuser["etat_menu"]) {
                            ?>
                            &nbsp;&nbsp;
                            <a href='#' onclick=activer_menu(<?php echo $recuser["id_menu"] ?>)>
                                <span title="Activer ce menu" alt="activer"><i class="glyphicon glyphicon-remove"></i></span>
                            </a>
                            <?php
                        }
                    }
                }
                ?>
            </td>
        </tr>
        <?php
    }
}

function lister_menu_ligne($id, $con) {
    $rsltuser = $con->query("select * from hotel_menu_restaurant as lm left join hotel_magasin_restaurant as mr "
            . "on lm.id_magasin_restaurant=mr.id_magasin_restaurant left join hotel_article as a on mr.id_article=a.id_article "
            . "left join hotel_categorie as c on a.id_categorie=c.id_categorie where "
            . "lm.id_menu='" . $id . "'") or die(mysqli_error($con));
    $num = 0;
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        $num = $num + 1;
        ?>
        <tr>
            <td><?php print $num ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["code_article"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["libelle_article"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["libelle_categorie"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["stock_mr"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["prix_mr"])) ?></td>

        </tr>
        <?php
    }
}

function ajouter_commande_bar($prixtotal, $com, $con) {
    if (($com != NULL)) {
        $an = date('Y');

        $codeb = "BAR";
        $rsltserv = $con->query("select * from hotel_service where code_service='" . $codeb . "'") or die(mysqli_error($con));
        $rowserv = mysqli_fetch_assoc($rsltserv);
        $rsltpl2 = $con->query("select * from hotel_bon_commande_interne where YEAR(date_bci)='" . $an . "'") or die(mysqli_error($con));
        $obh = "";
        $numid = date('Y', time()) . sprintf("%08d", 1);
        $i = 0;
        while ($reqte = mysqli_fetch_assoc($rsltpl2)) {
            $i = $i + 1;
        }
        $numid = date('Y', time()) . sprintf("%08d", ($i + 1));
        if (isset($_SESSION["id_compte_personnel"])) {
            $rsltf = $con->query("insert into hotel_bon_commande_interne(id_compte_personnel, id_service, code_bci, date_bci) "
                    . "values('" . $_SESSION["id_compte_personnel"] . "', '" . $rowserv["id_service"] . "', '" . $numid . "', "
                    . "NOW())") or die(mysqli_error($con));
        } else {
            $rsltf = $con->query("insert into hotel_bon_commande_interne(id_service, code_bci, date_bci) "
                    . "values('" . $rowserv["id_service"] . "', '" . $numid . "', NOW())") or die(mysqli_error($con));
        }
        $rsltfa = $con->query("select * from hotel_bon_commande_interne where code_bci='" . $numid . "'") or die(mysqli_error($con));
        $rowfa = mysqli_fetch_assoc($rsltfa);
        $prixt = 0;
        foreach ($_SESSION["cart_prodvcib"] as $prod) {
            $rsltreg = $con->query("insert into hotel_ligne_bon_commande_interne(id_bon_commande_interne, id_article, stock_lbci, "
                    . "prix_lbci) values('" . $rowfa["id_bon_commande_interne"] . "', '" . $prod["idart"] . "', "
                    . "'" . $prod["qteart"] . "', '" . $prod["prixart"] . "')") or die(mysqli_error($con));

            $prixt = $prixt + ($prod["prixart"] * $prod["qteart"]);
            $obj = $prod["qteart"] . "-" . addslashes($prod["designationart"]);
            $op = "Commande Interne";
            if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                $rsltvente = $con->query("insert into hotel_historique(id_article, id_proprietaire, objet_h, operation_h, "
                        . "date_histo) values('" . $prod["idart"] . "', '" . $_SESSION["id_proprietaire"] . "', "
                        . "'" . $obj . "', '" . $op . "', NOW())") or die(mysqli_error($con));
            } else if (isset($_SESSION["login_personnel"]) && (isset($_SESSION["mot_de_passe_personnel"])) && ($_SESSION["etat_compte_personnel"])) {
                if (($_SESSION["code_service"] == "BAR") || ($_SESSION["code_service"] == "BARESTO")) {
                    $rsltvente = $con->query("insert into hotel_historique(id_article, id_compte_personnel, objet_h, operation_h, "
                            . "date_histo) values('" . $prod["idart"] . "', '" . $_SESSION["id_compte_personnel"] . "', "
                            . "'" . $obj . "', '" . $op . "', NOW())") or die(mysqli_error($con));
                }
            }
        }
        ?>
        <?php
        unset($_SESSION["cart_prodvcib"]);
        echo "<script language='javascript'>$('div.alertuseraddbon').show('slow').delay(8000).hide('slow');</script>";
        ?>
        <a href="hotelpages/barhotel/boncommandehotel/facture_commande_pdf.php?boncommande=<?php echo $rowfa["id_bon_commande_interne"] ?>" class="btn btn-lg btn-success" target="_blank">
            <span title="Impriner le bon de commande" alt="editer"><i class="fa fa-file-pdf-o"></i> Impriner le bon de commande</span>
        </a>
        <?php
    } else {
        echo "<script language='javascript'>$('div.alertclformvide').show('slow').delay(8000).hide('slow');</script>";
    }
}

function lister_commande_bar($con) {
    $codeb = "BAR";
    $rsltserv = $con->query("select * from hotel_service where code_service='" . $codeb . "'") or die(mysqli_error($con));
    $rowserv = mysqli_fetch_assoc($rsltserv);
    $rsltuser = $con->query("select * from hotel_bon_commande_interne as a left join hotel_service as c on "
            . "a.id_service=c.id_service where a.id_service='" . $rowserv["id_service"] . "' order by a.date_bci desc") or die(mysqli_error($con));
    $num = 0;
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        $num = $num + 1;
        ?>
        <tr>
            <td><?php print $num ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["code_bci"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["etat_bci"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["date_bci"])) ?></td>
            <td>
                <?php
                if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                    ?>
                    <a href="indexproprietaire.php?page=<?php echo base64_encode('hotelpages/barhotel/boncommandehotel/lister_commande_ligne') ?>&boncommande=<?php echo $recuser["id_bon_commande_interne"] ?>">
                        <span title="Detail" alt="editer"><i class="glyphicon glyphicon-folder-close"></i></span>
                    </a>
                    <?php
                    if ($recuser["etat_bci"] == "En Cours") {
                        ?>
                        &nbsp;&nbsp;
                        <a href="indexproprietaire.php?page=<?php echo base64_encode('hotelpages/barhotel/bonlivraisonchotel/livraison') ?>&boncommande=<?php echo $recuser["id_bon_commande_interne"] ?>">
                            <span title="Livrer ce bon de commande" alt="livrer"><i class="glyphicon glyphicon-remove"></i></span>
                        </a>
                        <?php
                    }
                } else if (isset($_SESSION["login_personnel"]) && (isset($_SESSION["mot_de_passe_personnel"])) && ($_SESSION["etat_compte_personnel"])) {
                    if (($_SESSION["code_service"] == "ECONO")) {
                        ?>
                        <a href="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/barhotel/boncommandehotel/lister_commande_ligne') ?>&boncommande=<?php echo $recuser["id_bon_commande_interne"] ?>">
                            <span title="Detail" alt="editer"><i class="glyphicon glyphicon-folder-close"></i></span>
                        </a>
                        <?php
                        if ($recuser["etat_bci"] == "En Cours") {
                            ?>
                            &nbsp;&nbsp;
                            <a href="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/barhotel/bonlivraisonchotel/livraison') ?>&boncommande=<?php echo $recuser["id_bon_commande_interne"] ?>">
                                <span title="Livrer ce bon de commande" alt="livrer"><i class="glyphicon glyphicon-remove"></i></span>
                            </a>
                            <?php
                        }
                    }
                    if (($_SESSION["code_service"] == "BAR") || ($_SESSION["code_service"] == "BARESTO")) {
                        ?>
                        <a href="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/barhotel/boncommandehotel/lister_commande_ligne') ?>&boncommande=<?php echo $recuser["id_bon_commande_interne"] ?>">
                            <span title="Detail" alt="editer"><i class="glyphicon glyphicon-folder-close"></i></span>
                        </a>
                        <?php
                    }
                }
                ?>
            </td>
        </tr>
        <?php
    }
}

function lister_commande_bar_alert($con) {
    $etatc = "En Cours";
    $codeb = "BAR";
    $rsltserv = $con->query("select * from hotel_service where code_service='" . $codeb . "'") or die(mysqli_error($con));
    $rowserv = mysqli_fetch_assoc($rsltserv);
    $rsltuser = $con->query("select * from hotel_bon_commande_interne as a left join hotel_service as c on "
            . "a.id_service=c.id_service where a.id_service='" . $rowserv["id_service"] . "' and "
            . "a.etat_bci='" . $etatc . "' order by a.date_bci desc") or die(mysqli_error($con));
    $num = 0;
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        $num = $num + 1;
        ?>
        <tr>
            <td><?php print $num ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["code_bci"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["etat_bci"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["date_bci"])) ?></td>
            <td>
                <?php
                if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                    ?>
                    <a href="indexproprietaire.php?page=<?php echo base64_encode('hotelpages/barhotel/boncommandehotel/lister_commande_ligne') ?>&boncommande=<?php echo $recuser["id_bon_commande_interne"] ?>">
                        <span title="Detail" alt="editer"><i class="glyphicon glyphicon-folder-close"></i></span>
                    </a>
                    <?php
                    if ($recuser["etat_bci"] == "En Cours") {
                        ?>
                        &nbsp;&nbsp;
                        <a href="indexproprietaire.php?page=<?php echo base64_encode('hotelpages/barhotel/bonlivraisonchotel/livraison') ?>&boncommande=<?php echo $recuser["id_bon_commande_interne"] ?>">
                            <span title="Livrer ce bon de commande" alt="livrer"><i class="glyphicon glyphicon-remove"></i></span>
                        </a>
                        <?php
                    }
                } else if (isset($_SESSION["login_personnel"]) && (isset($_SESSION["mot_de_passe_personnel"])) && ($_SESSION["etat_compte_personnel"])) {
                    if (($_SESSION["code_service"] == "ECONO")) {
                        ?>
                        <a href="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/barhotel/boncommandehotel/lister_commande_ligne') ?>&boncommande=<?php echo $recuser["id_bon_commande_interne"] ?>">
                            <span title="Detail" alt="editer"><i class="glyphicon glyphicon-folder-close"></i></span>
                        </a>
                        <?php
                        if ($recuser["etat_bci"] == "En Cours") {
                            ?>
                            &nbsp;&nbsp;
                            <a href="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/barhotel/bonlivraisonchotel/livraison') ?>&boncommande=<?php echo $recuser["id_bon_commande_interne"] ?>">
                                <span title="Livrer ce bon de commande" alt="livrer"><i class="glyphicon glyphicon-remove"></i></span>
                            </a>
                            <?php
                        }
                    }
                    if (($_SESSION["code_service"] == "BAR") || ($_SESSION["code_service"] == "BARESTO")) {
                        ?>
                        <a href="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/barhotel/boncommandehotel/lister_commande_ligne') ?>&boncommande=<?php echo $recuser["id_bon_commande_interne"] ?>">
                            <span title="Detail" alt="editer"><i class="glyphicon glyphicon-folder-close"></i></span>
                        </a>
                        <?php
                    }
                }
                ?>
            </td>
        </tr>
        <?php
    }
}

function lister_commande_bar_ligne($id, $con) {
    $rsltuser = $con->query("select * from hotel_ligne_bon_commande_interne as lbl left join hotel_article as a on "
            . "lbl.id_article=a.id_article left join hotel_categorie as c on a.id_categorie=c.id_categorie where "
            . "lbl.id_bon_commande_interne='" . $id . "'") or die(mysqli_error($con));
    $num = 0;
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        $num = $num + 1;
        ?>
        <tr>
            <td><?php print $num ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["code_article"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["libelle_article"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["libelle_categorie"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["stock_lbci"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["stock_livre_lbci"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["prix_lbci"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["etat_lbci"])) ?></td>
            <td>
                <?php
                if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                    ?>

                    <?php
                } else if (isset($_SESSION["login_personnel"]) && (isset($_SESSION["mot_de_passe_personnel"])) && ($_SESSION["etat_compte_personnel"])) {
                    if (($_SESSION["code_service"] == "ECONO")) {
                        ?>

                        <?php
                        if ($recuser["etat_lbci"] == "En Cours") {
                            ?>
                            &nbsp;&nbsp;
                            <a href='#' onclick=livrer_bon_liv_bar_ligne(<?php echo $recuser["id_ligne_bon_commande_interne"] ?>)>
                                <span title="Livrer cette ligne de bon de commande" alt="livrer"><i class="glyphicon glyphicon-remove"></i></span>
                            </a>
                            <?php
                        }
                    }
                    if (($_SESSION["code_service"] == "BAR") || ($_SESSION["code_service"] == "BARESTO")) {
                        ?>
                        <?php
                    }
                }
                ?>
            </td>
        </tr>
        <?php
    }
}

function ajouter_commande_restaurant($prixtotal, $com, $con) {
    if (($com != NULL)) {
        $an = date('Y');

        $codeb = "RESTO";
        $rsltserv = $con->query("select * from hotel_service where code_service='" . $codeb . "'") or die(mysqli_error($con));
        $rowserv = mysqli_fetch_assoc($rsltserv);
        $rsltpl2 = $con->query("select * from hotel_bon_commande_interne where YEAR(date_bci)='" . $an . "'") or die(mysqli_error($con));
        $obh = "";
        $numid = date('Y', time()) . sprintf("%08d", 1);
        $i = 0;
        while ($reqte = mysqli_fetch_assoc($rsltpl2)) {
            $i = $i + 1;
        }
        $numid = date('Y', time()) . sprintf("%08d", ($i + 1));
        if (isset($_SESSION["id_compte_personnel"])) {
            $rsltf = $con->query("insert into hotel_bon_commande_interne(id_compte_personnel, id_service, code_bci, date_bci) "
                    . "values('" . $_SESSION["id_compte_personnel"] . "', '" . $rowserv["id_service"] . "', '" . $numid . "', "
                    . "NOW())") or die(mysqli_error($con));
        } else {
            $rsltf = $con->query("insert into hotel_bon_commande_interne(id_service, code_bci, date_bci) "
                    . "values('" . $rowserv["id_service"] . "', '" . $numid . "', NOW())") or die(mysqli_error($con));
        }
        $rsltfa = $con->query("select * from hotel_bon_commande_interne where code_bci='" . $numid . "'") or die(mysqli_error($con));
        $rowfa = mysqli_fetch_assoc($rsltfa);
        $prixt = 0;
        foreach ($_SESSION["cart_prodvcir"] as $prod) {
            $rsltreg = $con->query("insert into hotel_ligne_bon_commande_interne(id_bon_commande_interne, id_article, stock_lbci, "
                    . "prix_lbci) values('" . $rowfa["id_bon_commande_interne"] . "', '" . $prod["idart"] . "', "
                    . "'" . $prod["qteart"] . "', '" . $prod["prixart"] . "')") or die(mysqli_error($con));

            $prixt = $prixt + ($prod["prixart"] * $prod["qteart"]);
            $obj = $prod["qteart"] . "-" . addslashes($prod["designationart"]);
            $op = "Commande Interne";
            if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                $rsltvente = $con->query("insert into hotel_historique(id_article, id_proprietaire, objet_h, operation_h, "
                        . "date_histo) values('" . $prod["idart"] . "', '" . $_SESSION["id_proprietaire"] . "', "
                        . "'" . $obj . "', '" . $op . "', NOW())") or die(mysqli_error($con));
            } else if (isset($_SESSION["login_personnel"]) && (isset($_SESSION["mot_de_passe_personnel"])) && ($_SESSION["etat_compte_personnel"])) {
                if (($_SESSION["code_service"] == "RESTO") || ($_SESSION["code_service"] == "BARESTO")) {
                    $rsltvente = $con->query("insert into hotel_historique(id_article, id_compte_personnel, objet_h, operation_h, "
                            . "date_histo) values('" . $prod["idart"] . "', '" . $_SESSION["id_compte_personnel"] . "', "
                            . "'" . $obj . "', '" . $op . "', NOW())") or die(mysqli_error($con));
                }
            }
        }
        ?>
        <?php
        unset($_SESSION["cart_prodvcir"]);
        echo "<script language='javascript'>$('div.alertuseraddbon').show('slow').delay(8000).hide('slow');</script>";
        ?>
        <a href="hotelpages/restauranthotel/boncommandehotel/facture_commande_pdf.php?boncommande=<?php echo $rowfa["id_bon_commande_interne"] ?>" class="btn btn-lg btn-success" target="_blank">
            <span title="Impriner le bon de commande" alt="editer"><i class="fa fa-file-pdf-o"></i> Impriner le bon de commande</span>
        </a>
        <?php
    } else {
        echo "<script language='javascript'>$('div.alertclformvide').show('slow').delay(8000).hide('slow');</script>";
    }
}

function lister_commande_restaurant($con) {
    $codeb = "RESTO";
    $rsltserv = $con->query("select * from hotel_service where code_service='" . $codeb . "'") or die(mysqli_error($con));
    $rowserv = mysqli_fetch_assoc($rsltserv);
    $rsltuser = $con->query("select * from hotel_bon_commande_interne as a left join hotel_service as c on "
            . "a.id_service=c.id_service where a.id_service='" . $rowserv["id_service"] . "' order by a.date_bci desc") or die(mysqli_error($con));
    $num = 0;
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        $num = $num + 1;
        ?>
        <tr>
            <td><?php print $num ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["code_bci"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["etat_bci"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["date_bci"])) ?></td>
            <td>
                <?php
                if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                    ?>
                    <a href="indexproprietaire.php?page=<?php echo base64_encode('hotelpages/restauranthotel/boncommandehotel/lister_commande_ligne') ?>&boncommande=<?php echo $recuser["id_bon_commande_interne"] ?>">
                        <span title="Detail" alt="editer"><i class="glyphicon glyphicon-folder-close"></i></span>
                    </a>
                    <?php
                    if ($recuser["etat_bci"] == "En Cours") {
                        ?>
                        &nbsp;&nbsp;
                        <a href="indexproprietaire.php?page=<?php echo base64_encode('hotelpages/restauranthotel/bonlivraisonchotel/livraison') ?>&boncommande=<?php echo $recuser["id_bon_commande_interne"] ?>">
                            <span title="Livrer ce bon de commande" alt="livrer"><i class="glyphicon glyphicon-remove"></i></span>
                        </a>
                        <?php
                    }
                } else if (isset($_SESSION["login_personnel"]) && (isset($_SESSION["mot_de_passe_personnel"])) && ($_SESSION["etat_compte_personnel"])) {
                    if (($_SESSION["code_service"] == "ECONO")) {
                        ?>
                        <a href="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/restauranthotel/boncommandehotel/lister_commande_ligne') ?>&boncommande=<?php echo $recuser["id_bon_commande_interne"] ?>">
                            <span title="Detail" alt="editer"><i class="glyphicon glyphicon-folder-close"></i></span>
                        </a>
                        <?php
                        if ($recuser["etat_bci"] == "En Cours") {
                            ?>
                            &nbsp;&nbsp;
                            <a href="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/restauranthotel/bonlivraisonchotel/livraison') ?>&boncommande=<?php echo $recuser["id_bon_commande_interne"] ?>">
                                <span title="Livrer ce bon de commande" alt="livrer"><i class="glyphicon glyphicon-remove"></i></span>
                            </a>
                            <?php
                        }
                    }
                    if (($_SESSION["code_service"] == "RESTO") || ($_SESSION["code_service"] == "BARESTO")) {
                        ?>
                        <a href="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/restauranthotel/boncommandehotel/lister_commande_ligne') ?>&boncommande=<?php echo $recuser["id_bon_commande_interne"] ?>">
                            <span title="Detail" alt="editer"><i class="glyphicon glyphicon-folder-close"></i></span>
                        </a>
                        <?php
                    }
                }
                ?>
            </td>
        </tr>
        <?php
    }
}

function lister_commande_restaurant_alert($con) {
    $etatc = "En Cours";
    $codeb = "RESTO";
    $rsltserv = $con->query("select * from hotel_service where code_service='" . $codeb . "'") or die(mysqli_error($con));
    $rowserv = mysqli_fetch_assoc($rsltserv);
    $rsltuser = $con->query("select * from hotel_bon_commande_interne as a left join hotel_service as c on "
            . "a.id_service=c.id_service where a.id_service='" . $rowserv["id_service"] . "' and "
            . "a.etat_bci='" . $etatc . "' order by a.date_bci desc") or die(mysqli_error($con));
    $num = 0;
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        $num = $num + 1;
        ?>
        <tr>
            <td><?php print $num ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["code_bci"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["etat_bci"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["date_bci"])) ?></td>
            <td>
                <?php
                if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                    ?>
                    <a href="indexproprietaire.php?page=<?php echo base64_encode('hotelpages/restauranthotel/boncommandehotel/lister_commande_ligne') ?>&boncommande=<?php echo $recuser["id_bon_commande_interne"] ?>">
                        <span title="Detail" alt="editer"><i class="glyphicon glyphicon-folder-close"></i></span>
                    </a>
                    <?php
                    if ($recuser["etat_bci"] == "En Cours") {
                        ?>
                        &nbsp;&nbsp;
                        <a href="indexproprietaire.php?page=<?php echo base64_encode('hotelpages/restauranthotel/bonlivraisonchotel/livraison') ?>&boncommande=<?php echo $recuser["id_bon_commande_interne"] ?>">
                            <span title="Livrer ce bon de commande" alt="livrer"><i class="glyphicon glyphicon-remove"></i></span>
                        </a>
                        <?php
                    }
                } else if (isset($_SESSION["login_personnel"]) && (isset($_SESSION["mot_de_passe_personnel"])) && ($_SESSION["etat_compte_personnel"])) {
                    if (($_SESSION["code_service"] == "ECONO")) {
                        ?>
                        <a href="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/restauranthotel/boncommandehotel/lister_commande_ligne') ?>&boncommande=<?php echo $recuser["id_bon_commande_interne"] ?>">
                            <span title="Detail" alt="editer"><i class="glyphicon glyphicon-folder-close"></i></span>
                        </a>
                        <?php
                        if ($recuser["etat_bci"] == "En Cours") {
                            ?>
                            &nbsp;&nbsp;
                            <a href="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/restauranthotel/bonlivraisonchotel/livraison') ?>&boncommande=<?php echo $recuser["id_bon_commande_interne"] ?>">
                                <span title="Livrer ce bon de commande" alt="livrer"><i class="glyphicon glyphicon-remove"></i></span>
                            </a>
                            <?php
                        }
                    }
                    if (($_SESSION["code_service"] == "RESTO") || ($_SESSION["code_service"] == "BARESTO")) {
                        ?>
                        <a href="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/restauranthotel/boncommandehotel/lister_commande_ligne') ?>&boncommande=<?php echo $recuser["id_bon_commande_interne"] ?>">
                            <span title="Detail" alt="editer"><i class="glyphicon glyphicon-folder-close"></i></span>
                        </a>
                        <?php
                    }
                }
                ?>
            </td>
        </tr>
        <?php
    }
}

function lister_commande_restaurant_ligne($id, $con) {
    $rsltuser = $con->query("select * from hotel_ligne_bon_commande_interne as lbl left join hotel_article as a on "
            . "lbl.id_article=a.id_article left join hotel_categorie as c on a.id_categorie=c.id_categorie where "
            . "lbl.id_bon_commande_interne='" . $id . "'") or die(mysqli_error($con));
    $num = 0;
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        $num = $num + 1;
        ?>
        <tr>
            <td><?php print $num ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["code_article"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["libelle_article"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["libelle_categorie"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["stock_lbci"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["stock_livre_lbci"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["prix_lbci"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["etat_lbci"])) ?></td>
            <td>
                <?php
                if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                    ?>

                    <?php
                } else if (isset($_SESSION["login_personnel"]) && (isset($_SESSION["mot_de_passe_personnel"])) && ($_SESSION["etat_compte_personnel"])) {
                    if (($_SESSION["code_service"] == "ECONO")) {
                        ?>

                        <?php
                        if ($recuser["etat_lbci"] == "En Cours") {
                            ?>
                            &nbsp;&nbsp;
                            <a href='#' onclick=livrer_bon_liv_restaurant_ligne(<?php echo $recuser["id_ligne_bon_commande_interne"] ?>)>
                                <span title="Livrer cette ligne de bon de commande" alt="livrer"><i class="glyphicon glyphicon-remove"></i></span>
                            </a>
                            <?php
                        }
                    }
                    if (($_SESSION["code_service"] == "RESTO") || ($_SESSION["code_service"] == "BARESTO")) {
                        ?>
                        <?php
                    }
                }
                ?>
            </td>
        </tr>
        <?php
    }
}

function ajouter_commande_hebergement($prixtotal, $com, $con) {
    if (($com != NULL)) {
        $an = date('Y');

        $rsltpl2 = $con->query("select * from hotel_bon_commande_hebergement where YEAR(date_bch)='" . $an . "'") or die(mysqli_error($con));
        $obh = "";
        $numid = date('Y', time()) . sprintf("%08d", 1);
        $i = 0;
        while ($reqte = mysqli_fetch_assoc($rsltpl2)) {
            $i = $i + 1;
        }
        $numid = date('Y', time()) . sprintf("%08d", ($i + 1));
        if (isset($_SESSION["id_compte_personnel"])) {
            $rsltf = $con->query("insert into hotel_bon_commande_hebergement(id_compte_personnel, code_bch, date_bch) "
                    . "values('" . $_SESSION["id_compte_personnel"] . "', '" . $numid . "', "
                    . "NOW())") or die(mysqli_error($con));
        } else {
            $rsltf = $con->query("insert into hotel_bon_commande_hebergement(code_bch, date_bch) "
                    . "values('" . $numid . "', NOW())") or die(mysqli_error($con));
        }
        $rsltfa = $con->query("select * from hotel_bon_commande_hebergement where code_bch='" . $numid . "'") or die(mysqli_error($con));
        $rowfa = mysqli_fetch_assoc($rsltfa);
        $prixt = 0;
        foreach ($_SESSION["cart_prodvcih"] as $prod) {
            $rsltar = $con->query("select * from hotel_magasin_linge as mb left join hotel_linge as l on mb.id_linge=l.id_linge "
                    . "left join hotel_article as a on l.id_article=a.id_article left join hotel_categorie as c on "
                    . "a.id_categorie=c.id_categorie where mb.id_magasin_linge='" . $prod["idart"] . "'");
            $rowar = mysqli_fetch_assoc($rsltar);
            if ($rowar["id_chambre"] != NULL) {
                $rsltreg = $con->query("insert into hotel_ligne_bon_commande_hebergement(id_bon_commande_hebergement, id_linge, "
                        . "id_chambre, stock_lbch, prix_lbch) values('" . $rowfa["id_bon_commande_hebergement"] . "', "
                        . "'" . $rowar["id_linge"] . "', '" . $rowar["id_chambre"] . "', '" . $prod["qteart"] . "', "
                        . "'" . $prod["prixart"] . "')") or die(mysqli_error($con));
            } else if ($rowar["id_studio"] != NULL) {
                $rsltreg = $con->query("insert into hotel_ligne_bon_commande_hebergement(id_bon_commande_hebergement, id_linge, "
                        . "id_studio, stock_lbch, prix_lbch) values('" . $rowfa["id_bon_commande_hebergement"] . "', "
                        . "'" . $rowar["id_linge"] . "', '" . $rowar["id_studio"] . "', '" . $prod["qteart"] . "', "
                        . "'" . $prod["prixart"] . "')") or die(mysqli_error($con));
            } else if ($rowar["id_appartement"] != NULL) {
                $rsltreg = $con->query("insert into hotel_ligne_bon_commande_hebergement(id_bon_commande_hebergement, id_linge, "
                        . "id_appartement, stock_lbch, prix_lbch) values('" . $rowfa["id_bon_commande_hebergement"] . "', "
                        . "'" . $rowar["id_linge"] . "', '" . $rowar["id_appartement"] . "', '" . $prod["qteart"] . "', "
                        . "'" . $prod["prixart"] . "')") or die(mysqli_error($con));
            } else if ($rowar["id_salle"] != NULL) {
                $rsltreg = $con->query("insert into hotel_ligne_bon_commande_hebergement(id_bon_commande_hebergement, id_linge, "
                        . "id_salle, stock_lbch, prix_lbch) values('" . $rowfa["id_bon_commande_hebergement"] . "', "
                        . "'" . $rowar["id_linge"] . "', '" . $rowar["id_salle"] . "', '" . $prod["qteart"] . "', "
                        . "'" . $prod["prixart"] . "')") or die(mysqli_error($con));
            }
            $prixt = $prixt + ($prod["prixart"] * $prod["qteart"]);
            $obj = $prod["qteart"] . "-" . addslashes($prod["designationart"]);
            $op = "Commande Interne";
            if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                $rsltvente = $con->query("insert into hotel_historique(id_article, id_proprietaire, objet_h, operation_h, "
                        . "date_histo) values('" . $rowar["id_article"] . "', '" . $_SESSION["id_proprietaire"] . "', "
                        . "'" . $obj . "', '" . $op . "', NOW())") or die(mysqli_error($con));
            } else if (isset($_SESSION["login_personnel"]) && (isset($_SESSION["mot_de_passe_personnel"])) && ($_SESSION["etat_compte_personnel"])) {
                if (($_SESSION["code_service"] == "BAR") || ($_SESSION["code_service"] == "BARESTO")) {
                    $rsltvente = $con->query("insert into hotel_historique(id_article, id_compte_personnel, objet_h, operation_h, "
                            . "date_histo) values('" . $rowar["id_article"] . "', '" . $_SESSION["id_compte_personnel"] . "', "
                            . "'" . $obj . "', '" . $op . "', NOW())") or die(mysqli_error($con));
                }
            }
        }
        ?>
        <?php
        unset($_SESSION["cart_prodvcih"]);
        echo "<script language='javascript'>$('div.alertuseraddbon').show('slow').delay(8000).hide('slow');</script>";
        ?>
        <a href="hotelpages/hebergementhotel/boncommandehotel/facture_commande_pdf.php?boncommande=<?php echo $rowfa["id_bon_commande_hebergement"] ?>" class="btn btn-lg btn-success" target="_blank">
            <span title="Impriner le bon de commande" alt="editer"><i class="fa fa-file-pdf-o"></i> Impriner le bon de commande</span>
        </a>
        <?php
    } else {
        echo "<script language='javascript'>$('div.alertclformvide').show('slow').delay(8000).hide('slow');</script>";
    }
}

function lister_commande_hebergement($con) {

    $rsltuser = $con->query("select * from hotel_bon_commande_hebergement as a order by a.date_bch desc") or die(mysqli_error($con));
    $num = 0;
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        $num = $num + 1;
        ?>
        <tr>
            <td><?php print $num ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["code_bch"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["etat_bch"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["date_bch"])) ?></td>
            <td>
                <?php
                if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                    ?>
                    <a href="indexproprietaire.php?page=<?php echo base64_encode('hotelpages/hebergementhotel/boncommandehotel/lister_commande_ligne') ?>&boncommande=<?php echo $recuser["id_bon_commande_hebergement"] ?>">
                        <span title="Detail" alt="editer"><i class="glyphicon glyphicon-folder-close"></i></span>
                    </a>
                    <?php
                    if ($recuser["etat_bch"] == "En Cours") {
                        ?>
                        &nbsp;&nbsp;
                        <a href="indexproprietaire.php?page=<?php echo base64_encode('hotelpages/hebergementhotel/bonlivraisonchotel/livraison') ?>&boncommande=<?php echo $recuser["id_bon_commande_hebergement"] ?>">
                            <span title="Livrer ce bon de commande" alt="livrer"><i class="glyphicon glyphicon-remove"></i></span>
                        </a>
                        <?php
                    }
                } else if (isset($_SESSION["login_personnel"]) && (isset($_SESSION["mot_de_passe_personnel"])) && ($_SESSION["etat_compte_personnel"])) {
                    if (($_SESSION["code_service"] == "ECONO")) {
                        ?>
                        <a href="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/hebergementhotel/boncommandehotel/lister_commande_ligne') ?>&boncommande=<?php echo $recuser["id_bon_commande_hebergement"] ?>">
                            <span title="Detail" alt="editer"><i class="glyphicon glyphicon-folder-close"></i></span>
                        </a>
                        <?php
                        if ($recuser["etat_bch"] == "En Cours") {
                            ?>
                            &nbsp;&nbsp;
                            <a href="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/hebergementhotel/bonlivraisonchotel/livraison') ?>&boncommande=<?php echo $recuser["id_bon_commande_hebergement"] ?>">
                                <span title="Livrer ce bon de commande" alt="livrer"><i class="glyphicon glyphicon-remove"></i></span>
                            </a>
                            <?php
                        }
                    }
                    if (($_SESSION["code_service"] == "HEBER")) {
                        ?>
                        <a href="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/hebergementhotel/boncommandehotel/lister_commande_ligne') ?>&boncommande=<?php echo $recuser["id_bon_commande_hebergement"] ?>">
                            <span title="Detail" alt="editer"><i class="glyphicon glyphicon-folder-close"></i></span>
                        </a>
                        <?php
                    }
                }
                ?>
            </td>
        </tr>
        <?php
    }
}

function lister_commande_hebergement_alert($con) {

    $etatc = "En Cours";
    $rsltuser = $con->query("select * from hotel_bon_commande_hebergement as a where a.etat_bch='" . $etatc . "' order by a.date_bch desc") or die(mysqli_error($con));
    $num = 0;
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        $num = $num + 1;
        ?>
        <tr>
            <td><?php print $num ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["code_bch"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["etat_bch"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["date_bch"])) ?></td>
            <td>
                <?php
                if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                    ?>
                    <a href="indexproprietaire.php?page=<?php echo base64_encode('hotelpages/hebergementhotel/boncommandehotel/lister_commande_ligne') ?>&boncommande=<?php echo $recuser["id_bon_commande_hebergement"] ?>">
                        <span title="Detail" alt="editer"><i class="glyphicon glyphicon-folder-close"></i></span>
                    </a>
                    <?php
                    if ($recuser["etat_bch"] == "En Cours") {
                        ?>
                        &nbsp;&nbsp;
                        <a href="indexproprietaire.php?page=<?php echo base64_encode('hotelpages/hebergementhotel/bonlivraisonchotel/livraison') ?>&boncommande=<?php echo $recuser["id_bon_commande_hebergement"] ?>">
                            <span title="Livrer ce bon de commande" alt="livrer"><i class="glyphicon glyphicon-remove"></i></span>
                        </a>
                        <?php
                    }
                } else if (isset($_SESSION["login_personnel"]) && (isset($_SESSION["mot_de_passe_personnel"])) && ($_SESSION["etat_compte_personnel"])) {
                    if (($_SESSION["code_service"] == "ECONO")) {
                        ?>
                        <a href="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/hebergementhotel/boncommandehotel/lister_commande_ligne') ?>&boncommande=<?php echo $recuser["id_bon_commande_hebergement"] ?>">
                            <span title="Detail" alt="editer"><i class="glyphicon glyphicon-folder-close"></i></span>
                        </a>
                        <?php
                        if ($recuser["etat_bch"] == "En Cours") {
                            ?>
                            &nbsp;&nbsp;
                            <a href="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/hebergementhotel/bonlivraisonchotel/livraison') ?>&boncommande=<?php echo $recuser["id_bon_commande_hebergement"] ?>">
                                <span title="Livrer ce bon de commande" alt="livrer"><i class="glyphicon glyphicon-remove"></i></span>
                            </a>
                            <?php
                        }
                    }
                    if (($_SESSION["code_service"] == "HEBER")) {
                        ?>
                        <a href="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/hebergementhotel/boncommandehotel/lister_commande_ligne') ?>&boncommande=<?php echo $recuser["id_bon_commande_hebergement"] ?>">
                            <span title="Detail" alt="editer"><i class="glyphicon glyphicon-folder-close"></i></span>
                        </a>
                        <?php
                    }
                }
                ?>
            </td>
        </tr>
        <?php
    }
}

function lister_commande_hebergement_ligne($id, $con) {
    $rsltuser = $con->query("select * from hotel_ligne_bon_commande_hebergement as lbl left join hotel_linge as l on "
            . "lbl.id_linge=l.id_linge left join hotel_article as a on l.id_article=a.id_article left join hotel_categorie "
            . "as c on a.id_categorie=c.id_categorie where lbl.id_bon_commande_hebergement='" . $id . "'") or die(mysqli_error($con));
    $num = 0;
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        $num = $num + 1;
        ?>
        <tr>
            <td><?php print $num ?></td>
            <td>
                <?php
                if ($recuser["id_chambre"] != NULL) {
                    $reqch = $con->query("select * from hotel_chambre as c left join hotel_point_hotel as ph on c.id_point_hotel=ph.id_point_hotel "
                            . "left join hotel_proprietaire as p on ph.id_proprietaire=p.id_proprietaire where c.id_chambre= '" . $recuser["id_chambre"] . "' ") or die(mysqli_error($con));
                    $rowch = mysqli_fetch_assoc($reqch);
                    ?>
                    <?php print nl2br(htmlspecialchars($rowch["code_c"])) ?>
                    <?php
                } else if ($recuser["id_studio"] != NULL) {
                    $reqst = $con->query("select * from hotel_studio as s left join hotel_point_hotel as ph on s.id_point_hotel=ph.id_point_hotel "
                            . "left join hotel_proprietaire as p on ph.id_proprietaire=p.id_proprietaire where s.id_studio= '" . $recuser["id_studio"] . "' ") or die(mysqli_error($con));
                    $rowst = mysqli_fetch_assoc($reqst);
                    ?>
                    <?php print nl2br(htmlspecialchars($rowst["code_s"])) ?>
                    <?php
                } else if ($recuser["id_appartement"] != NULL) {
                    $reqap = $con->query("select * from hotel_appartement as a left join hotel_point_hotel as ph on a.id_point_hotel=ph.id_point_hotel "
                            . "left join hotel_proprietaire as p on ph.id_proprietaire=p.id_proprietaire where a.id_appartement= '" . $recuser["id_appartement"] . "' ") or die(mysqli_error($con));
                    $rowap = mysqli_fetch_assoc($reqap);
                    ?>
                    <?php print nl2br(htmlspecialchars($rowap["code_a"])) ?> 
                    <?php print $rowap["nbchambre_a"] ?>Ch  
                    <?php echo $rowap["nbsalon_a"] ?>S  
                    <?php echo $rowap["nbdouche_a"] ?>D  
                    <?php echo $rowap["nbcuisine_a"] ?>Cu 
                    <?php
                } else if ($recuser["id_salle"] != NULL) {
                    $reqsa = $con->query("select * from hotel_salle as s left join hotel_point_hotel as ph on s.id_point_hotel=ph.id_point_hotel "
                            . "left join hotel_proprietaire as p on ph.id_proprietaire=p.id_proprietaire where s.id_salle= '" . $recuser["id_salle"] . "' ") or die(mysqli_error($con));
                    $rowsa = mysqli_fetch_assoc($reqsa);
                    ?>
                    <?php print nl2br(htmlspecialchars($rowsa["code_salle"])) ?>
                    <?php
                }
                ?>
            </td>
            <td><?php print nl2br(htmlspecialchars($recuser["code_article"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["libelle_article"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["libelle_categorie"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["stock_lbch"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["stock_livre_lbch"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["prix_lbch"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["etat_lbch"])) ?></td>
            <td>
                <?php
                if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                    ?>

                    <?php
                } else if (isset($_SESSION["login_personnel"]) && (isset($_SESSION["mot_de_passe_personnel"])) && ($_SESSION["etat_compte_personnel"])) {
                    if (($_SESSION["code_service"] == "ECONO")) {
                        ?>

                        <?php
                        if ($recuser["etat_lbch"] == "En Cours") {
                            ?>
                            &nbsp;&nbsp;
                            <a href='#' onclick=livrer_bon_liv_hebergement_ligne(<?php echo $recuser["id_ligne_bon_commande_hebergement"] ?>)>
                                <span title="Livrer cette ligne de bon de commande" alt="livrer"><i class="glyphicon glyphicon-remove"></i></span>
                            </a>
                            <?php
                        }
                    }
                    if (($_SESSION["code_service"] == "HEBER")) {
                        ?>
                        <?php
                    }
                }
                ?>
            </td>
        </tr>
        <?php
    }
}

function ajouter_commande_externe($prixtotal, $com, $con) {
    if (($com != NULL)) {
        $an = date('Y');
        $rsltpl2 = $con->query("select * from hotel_bon_commande where YEAR(date_bc)='" . $an . "'") or die(mysqli_error($con));
        $obh = "";
        $numid = date('Y', time()) . sprintf("%08d", 1);
        $i = 0;
        while ($reqte = mysqli_fetch_assoc($rsltpl2)) {
            $i = $i + 1;
        }
        $numid = date('Y', time()) . sprintf("%08d", ($i + 1));
        if (isset($_SESSION["id_compte_personnel"])) {
            $rsltf = $con->query("insert into hotel_bon_commande(id_compte_personnel, code_bc, date_bc) "
                    . "values('" . $_SESSION["id_compte_personnel"] . "', '" . $numid . "', "
                    . "NOW())") or die(mysqli_error($con));
        } else {
            $rsltf = $con->query("insert into hotel_bon_commande(code_bc, date_bc) "
                    . "values('" . $numid . "', NOW())") or die(mysqli_error($con));
        }
        $rsltfa = $con->query("select * from hotel_bon_commande where code_bc='" . $numid . "'") or die(mysqli_error($con));
        $rowfa = mysqli_fetch_assoc($rsltfa);
        $prixt = 0;
        foreach ($_SESSION["cart_prodvcex"] as $prod) {
            $rsltreg = $con->query("insert into hotel_ligne_bon_commande(id_bon_commande, id_article, stock_lbc, "
                    . "prix_lbc) values('" . $rowfa["id_bon_commande"] . "', '" . $prod["idart"] . "', "
                    . "'" . $prod["qteart"] . "', '" . $prod["unitearta"] . "')") or die(mysqli_error($con));

            $prixt = $prixt + ($prod["unitearta"] * $prod["qteart"]);
            $obj = $prod["qteart"] . "-" . addslashes($prod["designationart"]);
            $op = "Commande Externe";
            if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                $rsltvente = $con->query("insert into hotel_historique(id_article, id_proprietaire, objet_h, operation_h, "
                        . "date_histo) values('" . $prod["idart"] . "', '" . $_SESSION["id_proprietaire"] . "', "
                        . "'" . $obj . "', '" . $op . "', NOW())") or die(mysqli_error($con));
            } else if (isset($_SESSION["login_personnel"]) && (isset($_SESSION["mot_de_passe_personnel"])) && ($_SESSION["etat_compte_personnel"])) {
                if (($_SESSION["code_service"] == "BAR") || ($_SESSION["code_service"] == "BARESTO")) {
                    $rsltvente = $con->query("insert into hotel_historique(id_article, id_compte_personnel, objet_h, operation_h, "
                            . "date_histo) values('" . $prod["idart"] . "', '" . $_SESSION["id_compte_personnel"] . "', "
                            . "'" . $obj . "', '" . $op . "', NOW())") or die(mysqli_error($con));
                }
            }
        }
        ?>
        <?php
        unset($_SESSION["cart_prodvcex"]);
        echo "<script language='javascript'>$('div.alertuseraddbon').show('slow').delay(8000).hide('slow');</script>";
        ?>
        <a href="hotelpages/economathotel/boncommandehotel/facture_commande_pdf.php?boncommande=<?php echo $rowfa["id_bon_commande"] ?>" class="btn btn-lg btn-success" target="_blank">
            <span title="Impriner le bon de commande" alt="editer"><i class="fa fa-file-pdf-o"></i> Impriner le bon de commande</span>
        </a>
        <?php
    } else {
        echo "<script language='javascript'>$('div.alertclformvide').show('slow').delay(8000).hide('slow');</script>";
    }
}

function ajouter_linge_blanchisseur($prixtotal, $com, $con) {
    if (($com != NULL)) {
        $an = date('Y');
        $rsltpl2 = $con->query("select * from hotel_bon_nettoyage where YEAR(date_bn)='" . $an . "'") or die(mysqli_error($con));
        $obh = "";
        $numid = date('Y', time()) . sprintf("%08d", 1);
        $i = 0;
        while ($reqte = mysqli_fetch_assoc($rsltpl2)) {
            $i = $i + 1;
        }
        $numid = date('Y', time()) . sprintf("%08d", ($i + 1));
        if (isset($_SESSION["id_compte_personnel"])) {
            $rsltf = $con->query("insert into hotel_bon_nettoyage(id_compte_personnel, code_bn, date_bn) "
                    . "values('" . $_SESSION["id_compte_personnel"] . "', '" . $numid . "', "
                    . "NOW())") or die(mysqli_error($con));
        } else {
            $rsltf = $con->query("insert into hotel_bon_nettoyage(code_bn, date_bn) "
                    . "values('" . $numid . "', NOW())") or die(mysqli_error($con));
        }
        $rsltfa = $con->query("select * from hotel_bon_nettoyage where code_bn='" . $numid . "'") or die(mysqli_error($con));
        $rowfa = mysqli_fetch_assoc($rsltfa);
        $prixt = 0;
        foreach ($_SESSION["cart_prodvbnl"] as $prod) {
            $reqar = $con->query("select * from hotel_magasin_linge_sale as mls left join hotel_magasin_linge as ml on "
                    . "mls.id_magasin_linge=ml.id_magasin_linge left join hotel_linge as l on ml.id_linge=l.id_linge left join "
                    . "hotel_article as a on l.id_article=a.id_article left join hotel_categorie as c on "
                    . "a.id_categorie=c.id_categorie where mls.id_linge_sale='" . $prod["idart"] . "'") or die(mysqli_error($con));
            $rowar = mysqli_fetch_assoc($reqar);

            $rsltreg = $con->query("insert into hotel_ligne_bon_nettoyage(id_bon_nettoyage, id_linge_sale, stock_lbn, "
                    . "prix_lbn, date_lbn) values('" . $rowfa["id_bon_nettoyage"] . "', '" . $prod["idart"] . "', "
                    . "'" . $prod["qteart"] . "', '" . $prod["prixartl"] . "', NOW())") or die(mysqli_error($con));

            $stockar = $rowar["stock_linge_sale"] - $prod["qteart"];
            $rsltar = $con->query("update hotel_magasin_linge_sale set stock_linge_sale='" . $stockar . "' where "
                    . "id_linge_sale='" . $prod["idart"] . "'") or die(mysqli_error($con));

            $prixt = $prixt + ($prod["prixartl"] * $prod["qteart"]);
            $obj = $prod["qteart"] . "-" . addslashes($prod["designationart"]);
            $op = "Bon de nettoyage";
            if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                $rsltvente = $con->query("insert into hotel_historique(id_article, id_proprietaire, objet_h, operation_h, "
                        . "date_histo) values('" . $prod["idart"] . "', '" . $_SESSION["id_proprietaire"] . "', "
                        . "'" . $obj . "', '" . $op . "', NOW())") or die(mysqli_error($con));
            } else if (isset($_SESSION["login_personnel"]) && (isset($_SESSION["mot_de_passe_personnel"])) && ($_SESSION["etat_compte_personnel"])) {
                if (($_SESSION["code_service"] == "ECONO")) {
                    $rsltvente = $con->query("insert into hotel_historique(id_article, id_compte_personnel, objet_h, operation_h, "
                            . "date_histo) values('" . $prod["idart"] . "', '" . $_SESSION["id_compte_personnel"] . "', "
                            . "'" . $obj . "', '" . $op . "', NOW())") or die(mysqli_error($con));
                }
            }
        }
        ?>
        <?php
        unset($_SESSION["cart_prodvbnl"]);
        echo "<script language='javascript'>$('div.alertuseraddbon').show('slow').delay(8000).hide('slow');</script>";
        ?>
        <a href="hotelpages/hebergementhotel/magasinsalehotel/facture_nettoyage_pdf.php?bonnettoyage=<?php echo $rowfa["id_bon_nettoyage"] ?>" class="btn btn-lg btn-success" target="_blank">
            <span title="Impriner le bon de nettoyage" alt="editer"><i class="fa fa-file-pdf-o"></i> Impriner le bon de nettoyage</span>
        </a>
        <?php
    } else {
        echo "<script language='javascript'>$('div.alertclformvide').show('slow').delay(8000).hide('slow');</script>";
    }
}

function lister_bon_nettoyage($con) {

    $rsltuser = $con->query("select * from hotel_bon_nettoyage as a order by a.date_bn desc") or die(mysqli_error($con));
    $num = 0;
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        $num = $num + 1;
        ?>
        <tr>
            <td><?php print $num ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["code_bn"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["etat_bn"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["date_bn"])) ?></td>
            <td>
                <?php
                if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                    ?>
                    <a href="indexproprietaire.php?page=<?php echo base64_encode('hotelpages/blanchisseurhotel/bonnettoyagehotel/lister_bonnettoyage_ligne') ?>&bonnettoyage=<?php echo $recuser["id_bon_nettoyage"] ?>">
                        <span title="Detail" alt="editer"><i class="glyphicon glyphicon-folder-close"></i></span>
                    </a>
                    <?php
                    if ($recuser["etat_bn"] == "En Cours") {
                        ?>
                        &nbsp;&nbsp;
                        <a href='#' onclick=valider_bon_nettoyage(<?php echo $recuser["id_bon_nettoyage"] ?>)>
                            <span title="Valider ce bon de nettoyage" alt="valider"><i class="glyphicon glyphicon-remove"></i></span>
                        </a>
                        <?php
                    }
                } else if (isset($_SESSION["login_personnel"]) && (isset($_SESSION["mot_de_passe_personnel"])) && ($_SESSION["etat_compte_personnel"])) {
                    if (($_SESSION["code_service"] == "ECONO")) {
                        ?>
                        <a href="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/blanchisseurhotel/bonnettoyagehotel/lister_bonnettoyage_ligne') ?>&bonnettoyage=<?php echo $recuser["id_bon_nettoyage"] ?>">
                            <span title="Detail" alt="editer"><i class="glyphicon glyphicon-folder-close"></i></span>
                        </a>
                        <?php
                    }
                    if (($_SESSION["code_service"] == "BLANC")) {
                        ?>
                        <a href="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/blanchisseurhotel/bonnettoyagehotel/lister_bonnettoyage_ligne') ?>&bonnettoyage=<?php echo $recuser["id_bon_nettoyage"] ?>">
                            <span title="Detail" alt="editer"><i class="glyphicon glyphicon-folder-close"></i></span>
                        </a>
                        <?php
                        if ($recuser["etat_bn"] == "En Cours") {
                            ?>
                            &nbsp;&nbsp;
                            <a href='#' onclick=valider_bon_nettoyage(<?php echo $recuser["id_bon_nettoyage"] ?>)>
                                <span title="Valider ce bon de nettoyage" alt="valider"><i class="glyphicon glyphicon-remove"></i></span>
                            </a>
                            <?php
                        }
                    }
                }
                ?>
            </td>
        </tr>
        <?php
    }
}

function lister_bon_nettoyage_alert($con) {

    $etatc = "En Cours";
    $rsltuser = $con->query("select * from hotel_bon_nettoyage as a where a.etat_bn='" . $etatc . "' order by a.date_bn desc") or die(mysqli_error($con));
    $num = 0;
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        $num = $num + 1;
        ?>
        <tr>
            <td><?php print $num ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["code_bn"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["etat_bn"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["date_bn"])) ?></td>
            <td>
                <?php
                if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                    ?>
                    <a href="indexproprietaire.php?page=<?php echo base64_encode('hotelpages/blanchisseurhotel/bonnettoyagehotel/lister_bonnettoyage_ligne') ?>&bonnettoyage=<?php echo $recuser["id_bon_nettoyage"] ?>">
                        <span title="Detail" alt="editer"><i class="glyphicon glyphicon-folder-close"></i></span>
                    </a>
                    <?php
                    if ($recuser["etat_bn"] == "En Cours") {
                        ?>
                        &nbsp;&nbsp;
                        <a href='#' onclick=valider_bon_nettoyage(<?php echo $recuser["id_bon_nettoyage"] ?>)>
                            <span title="Valider ce bon de nettoyage" alt="valider"><i class="glyphicon glyphicon-remove"></i></span>
                        </a>
                        <?php
                    }
                } else if (isset($_SESSION["login_personnel"]) && (isset($_SESSION["mot_de_passe_personnel"])) && ($_SESSION["etat_compte_personnel"])) {
                    if (($_SESSION["code_service"] == "ECONO")) {
                        ?>
                        <a href="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/blanchisseurhotel/bonnettoyagehotel/lister_bonnettoyage_ligne') ?>&bonnettoyage=<?php echo $recuser["id_bon_nettoyage"] ?>">
                            <span title="Detail" alt="editer"><i class="glyphicon glyphicon-folder-close"></i></span>
                        </a>
                        <?php
                    }
                    if (($_SESSION["code_service"] == "BLANC")) {
                        ?>
                        <a href="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/blanchisseurhotel/bonnettoyagehotel/lister_bonnettoyage_ligne') ?>&bonnettoyage=<?php echo $recuser["id_bon_nettoyage"] ?>">
                            <span title="Detail" alt="editer"><i class="glyphicon glyphicon-folder-close"></i></span>
                        </a>
                        <?php
                        if ($recuser["etat_bn"] == "En Cours") {
                            ?>
                            &nbsp;&nbsp;
                            <a href='#' onclick=valider_bon_nettoyage(<?php echo $recuser["id_bon_nettoyage"] ?>)>
                                <span title="Valider ce bon de nettoyage" alt="valider"><i class="glyphicon glyphicon-remove"></i></span>
                            </a>
                            <?php
                        }
                    }
                }
                ?>
            </td>
        </tr>
        <?php
    }
}

function lister_bon_nettoyage_ligne($id, $con) {
    $rsltuser = $con->query("select * from hotel_ligne_bon_nettoyage as lbn left join hotel_magasin_linge_sale as mls on "
            . "lbn.id_linge_sale=mls.id_linge_sale left join hotel_magasin_linge as ml on "
            . "mls.id_magasin_linge=ml.id_magasin_linge left join hotel_linge as l on ml.id_linge=l.id_linge left join "
            . "hotel_article as a on l.id_article=a.id_article left join hotel_categorie as c on a.id_categorie=c.id_categorie "
            . "where lbn.id_bon_nettoyage='" . $id . "'") or die(mysqli_error($con));
    $num = 0;
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        $num = $num + 1;
        ?>
        <tr>
            <td><?php print $num ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["code_article"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["libelle_article"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["libelle_categorie"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["stock_lbn"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["prix_lbn"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["etat_lbn"])) ?></td>
            <td>
                <?php
                if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {

                    if ($recuser["etat_lbn"] == "En Cours") {
                        ?>
                        &nbsp;&nbsp;
                        <a href='#' onclick=valider_bon_nettoyage_ligne(<?php echo $recuser["id_ligne_bon_nettoyage"] ?>)>
                            <span title="Valider cette ligne de bon de nettoyage" alt="valider"><i class="glyphicon glyphicon-remove"></i></span>
                        </a>
                        <?php
                    }
                } else if (isset($_SESSION["login_personnel"]) && (isset($_SESSION["mot_de_passe_personnel"])) && ($_SESSION["etat_compte_personnel"])) {
                    if (($_SESSION["code_service"] == "ECONO")) {
                        ?>

                        <?php
                    }
                    if (($_SESSION["code_service"] == "BLANC")) {
                        if ($recuser["etat_lbn"] == "En Cours") {
                            ?>
                            &nbsp;&nbsp;
                            <a href='#' onclick=valider_bon_nettoyage_ligne(<?php echo $recuser["id_ligne_bon_nettoyage"] ?>)>
                                <span title="Valider cette ligne de bon de nettoyage" alt="valider"><i class="glyphicon glyphicon-remove"></i></span>
                            </a>
                            <?php
                        }
                    }
                }
                ?>
            </td>
        </tr>
        <?php
    }
}

function lister_magasin_blanchisseur($con) {
    $rsltuser = $con->query("select * from hotel_magasin_blanchisseur as ml left join hotel_linge as l on "
            . "ml.id_linge=l.id_linge left join hotel_article as a on l.id_article=a.id_article left join "
            . "hotel_categorie as c on a.id_categorie=c.id_categorie ") or die(mysqli_error($con));
    $num = 0;
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        $num = $num + 1;
        ?>
        <tr>
            <td><?php print $num ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["code_article"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["libelle_article"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["libelle_categorie"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["stock_mb"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["prix_lavage_mb"])) ?></td>
            <td>
                <?php
                if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                    if ($recuser["stock_mb"] >= 1) {
                        ?>
                        <a href="indexproprietaire.php?page=<?php echo base64_encode('hotelpages/blanchisseurhotel/magasinhotel/ajouter_panier') ?>&actionp=add&idp=<?php echo $recuser["id_magasin_blanchisseur"]; ?>">
                            <span title="Ajouter &agrave; la pile de linges &agrave; livrer" alt="livrer"><i class="glyphicon glyphicon-transfer"></i></span>
                        </a>
                        <?php
                    }
                } else if (isset($_SESSION["login_personnel"]) && (isset($_SESSION["mot_de_passe_personnel"])) && ($_SESSION["etat_compte_personnel"])) {
                    if (($_SESSION["code_service"] == "BLANC")) {
                        if ($recuser["stock_mb"] >= 1) {
                            ?>
                            <a href="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/blanchisseurhotel/magasinhotel/ajouter_panier') ?>&actionp=add&idp=<?php echo $recuser["id_magasin_blanchisseur"]; ?>">
                                <span title="Ajouter &agrave; la pile de linges &agrave; livrer" alt="livrer"><i class="glyphicon glyphicon-transfer"></i></span>
                            </a>
                            <?php
                        }
                    }
                }
                ?>
            </td>
        </tr>
        <?php
    }
}

function ajouter_livraison_blanchisseur($prixtotal, $com, $con) {
    if (($com != NULL)) {
        $an = date('Y');

        $rsltpl2 = $con->query("select * from hotel_bon_livraison where YEAR(date_bl)='" . $an . "'") or die(mysqli_error($con));
        $obh = "";
        $numid = date('Y', time()) . sprintf("%08d", 1);
        $i = 0;
        while ($reqte = mysqli_fetch_assoc($rsltpl2)) {
            $i = $i + 1;
        }
        $numid = date('Y', time()) . sprintf("%08d", ($i + 1));

        if (isset($_SESSION["id_compte_personnel"])) {
            $rsltf = $con->query("insert into hotel_bon_livraison(id_compte_personnel, "
                    . "code_bl, montant_bl, date_bl) values('" . $_SESSION["id_compte_personnel"] . "', "
                    . "'" . $numid . "', '" . $prixtotal . "', NOW())") or die(mysqli_error($con));
        } else {
            $rsltf = $con->query("insert into hotel_bon_livraison(code_bl, montant_bl, "
                    . "date_bl) values('" . $numid . "', '" . $prixtotal . "', NOW())") or die(mysqli_error($con));
        }
        $rsltfa = $con->query("select * from hotel_bon_livraison where code_bl='" . $numid . "'") or die(mysqli_error($con));
        $rowfa = mysqli_fetch_assoc($rsltfa);

        foreach ($_SESSION["cart_prodvmbl"] as $prod) {
            $reqar = $con->query("select * from hotel_magasin_blanchisseur as ml left join hotel_linge as l on "
                    . "ml.id_linge=l.id_linge left join hotel_article as a on l.id_article=a.id_article left join "
                    . "hotel_categorie as c on a.id_categorie=c.id_categorie where ml.id_magasin_blanchisseur='" . $prod["idart"] . "'") or die(mysqli_error($con));
            $rowar = mysqli_fetch_assoc($reqar);
            $rsltreg = $con->query("insert into hotel_ligne_bon_livraison(id_bon_livraison, id_article, id_magasin_blanchisseur, "
                    . "stock_lbl, prix_lavage_lbl) values('" . $rowfa["id_bon_livraison"] . "', '" . $rowar["id_article"] . "', "
                    . "'" . $prod["idart"] . "', '" . $prod["qteart"] . "', '" . $prod["prixartl"] . "')") or die(mysqli_error($con));
            $stockar = $rowar["stock_mb"] - $prod["qteart"];
            $rsltar = $con->query("update hotel_magasin_blanchisseur set stock_mb='" . $stockar . "' where "
                    . "id_magasin_blanchisseur='" . $prod["idart"] . "'") or die(mysqli_error($con));

            $obj = $prod["qteart"] . "-" . addslashes($prod["designationart"]);
            $op = "Livraison Blanchisseur";
            if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                $rsltvente = $con->query("insert into hotel_historique(id_article, id_proprietaire, objet_h, operation_h, "
                        . "date_histo) values('" . $rowar["id_article"] . "', '" . $_SESSION["id_proprietaire"] . "', "
                        . "'" . $obj . "', '" . $op . "', NOW())") or die(mysqli_error($con));
            } else if (isset($_SESSION["login_personnel"]) && (isset($_SESSION["mot_de_passe_personnel"])) && ($_SESSION["etat_compte_personnel"])) {
                if (($_SESSION["code_service"] == "ECONO")) {
                    $rsltvente = $con->query("insert into hotel_historique(id_article, id_compte_personnel, objet_h, operation_h, "
                            . "date_histo) values('" . $rowar["id_article"] . "', '" . $_SESSION["id_compte_personnel"] . "', "
                            . "'" . $obj . "', '" . $op . "', NOW())") or die(mysqli_error($con));
                }
            }
        }
        ?>
        <?php
        unset($_SESSION["cart_prodvmbl"]);
        echo "<script language='javascript'>$('div.alertuseraddbon').show('slow').delay(8000).hide('slow');</script>";
        ?>
        <a href="hotelpages/blanchisseurhotel/magasinhotel/facture_livraison_pdf.php?bonlivraison=<?php echo $rowfa["id_bon_livraison"] ?>" class="btn btn-lg btn-success" target="_blank">
            <span title="Impriner le bon de livraison" alt="editer"><i class="fa fa-file-pdf-o"></i> Impriner le bon de livraison</span>
        </a>
        <?php
    } else {
        echo "<script language='javascript'>$('div.alertclformvide').show('slow').delay(8000).hide('slow');</script>";
    }
}

function lister_livraison_blanchisseur($con) {
    $rsltuser = $con->query("select * from hotel_bon_livraison as a where id_fournisseur is null order by a.date_bl desc") or die(mysqli_error($con));
    $num = 0;
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        $num = $num + 1;
        ?>
        <tr>
            <td><?php print $num ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["code_bl"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["montant_bl"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["etat_bl"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["date_bl"])) ?></td>
            <td>
                <?php
                if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                    ?>
                    <a href="indexproprietaire.php?page=<?php echo base64_encode('hotelpages/blanchisseurhotel/magasinhotel/lister_livraison_ligne') ?>&bonlivraison=<?php echo $recuser["id_bon_livraison"] ?>">
                        <span title="Detail" alt="editer"><i class="glyphicon glyphicon-folder-close"></i></span>
                    </a>
                    <?php
                    if ($recuser["etat_bl"] == "En Cours") {
                        ?>
                        &nbsp;&nbsp;
                        <a href='#' onclick=valider_bon_liv_blanchisseur(<?php echo $recuser["id_hebergement"] ?>)>
                            <span title="Valider ce bon de livraison" alt="valider"><i class="glyphicon glyphicon-remove"></i></span>
                        </a>
                        <?php
                    }
                } else if (isset($_SESSION["login_personnel"]) && (isset($_SESSION["mot_de_passe_personnel"])) && ($_SESSION["etat_compte_personnel"])) {
                    if (($_SESSION["code_service"] == "ECONO")) {
                        ?>
                        <a href="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/blanchisseurhotel/magasinhotel/lister_livraison_ligne') ?>&bonlivraison=<?php echo $recuser["id_bon_livraison"] ?>">
                            <span title="Detail" alt="editer"><i class="glyphicon glyphicon-folder-close"></i></span>
                        </a>
                        <?php
                        if ($recuser["etat_bl"] == "En Cours") {
                            ?>
                            &nbsp;&nbsp;
                            <a href='#' onclick=valider_bon_liv_blanchisseur(<?php echo $recuser["id_bon_livraison"] ?>)>
                                <span title="Valider ce bon de livraison" alt="valider"><i class="glyphicon glyphicon-remove"></i></span>
                            </a>
                            <?php
                        }
                    }
                    if (($_SESSION["code_service"] == "BLANC")) {
                        ?>
                        <a href="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/blanchisseurhotel/magasinhotel/lister_livraison_ligne') ?>&bonlivraison=<?php echo $recuser["id_bon_livraison"] ?>">
                            <span title="Detail" alt="editer"><i class="glyphicon glyphicon-folder-close"></i></span>
                        </a>
                        <?php
                    }
                }
                ?>
            </td>
        </tr>
        <?php
    }
}

function lister_livraison_blanchisseur_ligne($id, $con) {
    $rsltuser = $con->query("select * from hotel_ligne_bon_livraison as lbl left join hotel_article as a on "
            . "lbl.id_article=a.id_article left join hotel_categorie as c on a.id_categorie=c.id_categorie where "
            . "lbl.id_bon_livraison='" . $id . "'") or die(mysqli_error($con));
    $num = 0;
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        $num = $num + 1;
        ?>
        <tr>
            <td><?php print $num ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["code_article"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["libelle_article"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["libelle_categorie"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["stock_lbl"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["prix_lavage_lbl"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["etat_lbl"])) ?></td>
            <td>
                <?php
                if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                    if ($recuser["etat_lbl"] == "En Cours") {
                        ?>
                        &nbsp;&nbsp;
                        <a href='#' onclick=valider_bon_liv_blanchisseur_ligne(<?php echo $recuser["id_ligne_bon_livraison"] ?>)>
                            <span title="Valider cette ligne de bon de livraison" alt="valider"><i class="glyphicon glyphicon-remove"></i></span>
                        </a>
                        <?php
                    }
                } else if (isset($_SESSION["login_personnel"]) && (isset($_SESSION["mot_de_passe_personnel"])) && ($_SESSION["etat_compte_personnel"])) {
                    if (($_SESSION["code_service"] == "ECONO")) {
                        if ($recuser["etat_lbl"] == "En Cours") {
                            ?>
                            &nbsp;&nbsp;
                            <a href='#' onclick=valider_bon_liv_blanchisseur_ligne(<?php echo $recuser["id_ligne_bon_livraison"] ?>)>
                                <span title="Valider cette ligne de bon de livraison" alt="valider"><i class="glyphicon glyphicon-remove"></i></span>
                            </a>
                            <?php
                        }
                    }
                    if (($_SESSION["code_service"] == "BLANC")) {
                        ?>
                        <?php
                    }
                }
                ?>
            </td>
        </tr>
        <?php
    }
}

function ajouter_livraison($prixtotal, $nomfour, $com, $con) {
    if (($com != NULL)) {
        $an = date('Y');
        $etat = "Valider";
        $nomfour = addslashes($nomfour);
        $idfourn = null;

        $rsltfour = $con->query("select * from hotel_fournisseur where nom_fournisseur='" . $nomfour . "'") or die(mysqli_error($con));
        $nbf = mysqli_num_rows($rsltfour);
        if ($nbf != 0) {
            $rowfour = mysqli_fetch_assoc($rsltfour);
            $idfourn = $rowfour["id_fournisseur"];
        } else {
            $rsltfou = $con->query("insert into hotel_fournisseur(nom_fournisseur) values('" . $nomfour . "')") or die(mysqli_error($con));
            $rsltfour2 = $con->query("select * from hotel_fournisseur where nom_fournisseur='" . $nomfour . "'") or die(mysqli_error($con));
            $rowfour = mysqli_fetch_assoc($rsltfour2);
            $idfourn = $rowfour["id_fournisseur"];
        }
        $rsltpl2 = $con->query("select * from hotel_bon_livraison where YEAR(date_bl)='" . $an . "'") or die(mysqli_error($con));
        $obh = "";
        $numid = date('Y', time()) . sprintf("%08d", 1);
        $i = 0;
        while ($reqte = mysqli_fetch_assoc($rsltpl2)) {
            $i = $i + 1;
        }
        $numid = date('Y', time()) . sprintf("%08d", ($i + 1));
        echo "<script language='javascript'>alert($nomfour)</script>";
        if (isset($_SESSION["id_compte_personnel"])) {
            $rsltf = $con->query("insert into hotel_bon_livraison(id_compte_personnel_validel, id_fournisseur, code_bl, "
                    . "montant_bl, etat_bl, date_bl) values('" . $_SESSION["id_compte_personnel"] . "', '" . $idfourn . "', "
                    . "'" . $numid . "', '" . $prixtotal . "', '" . $etat . "', NOW())") or die(mysqli_error($con));
        } else {
            $rsltf = $con->query("insert into hotel_bon_livraison(id_fournisseur, code_bl, montant_bl, etat_bl, date_bl) "
                    . "values('" . $idfourn . "', '" . $numid . "', '" . $prixtotal . "', '" . $etat . "', NOW())") or die(mysqli_error($con));
        }
        $rsltfa = $con->query("select * from hotel_bon_livraison where code_bl='" . $numid . "'") or die(mysqli_error($con));
        $rowfa = mysqli_fetch_assoc($rsltfa);
        $prixt = 0;
        foreach ($_SESSION["cart_prodvlex"] as $prod) {
            $rsltreg = $con->query("insert into hotel_ligne_bon_livraison(id_bon_livraison, id_article, stock_lbl, prix_achat_lbl, "
                    . "prix_vente_lbl, prix_lavage_lbl, unite_achat_lbl, unite_vente_lbl, unite_sortie_lbl, etat_lbl) "
                    . "values('" . $rowfa["id_bon_livraison"] . "', '" . $prod["idart"] . "', '" . $prod["qteart"] . "', "
                    . "'" . $prod["prixarta"] . "', '" . $prod["prixartv"] . "', '" . $prod["prixlingeart"] . "', "
                    . "'" . $prod["unitearta"] . "', '" . $prod["uniteartv"] . "', '" . $prod["unitearts"] . "', '" . $etat . "')") or die(mysqli_error($con));
            $reqar = $con->query("select * from hotel_article where id_article='" . $prod["idart"] . "'") or die(mysqli_error($con));
            $rowar = mysqli_fetch_assoc($reqar);
            $stockar = $rowar["stock_article"] + $prod["qteart"];
            $rsltar = $con->query("update hotel_article set stock_article='" . $stockar . "', unite_achat_article='" . $prod["unitearta"] . "', "
                    . "unite_vente_article='" . $prod["uniteartv"] . "', unite_sortie_article='" . $prod["unitearts"] . "' where "
                    . "id_article='" . $prod["idart"] . "'") or die(mysqli_error($con));
            if ($prod["idlingeart"] != NULL) {
                $rsltar = $con->query("update hotel_linge set prix_lavage_linge='" . $prod["prixlingeart"] . "' where "
                        . "id_linge='" . $prod["idlingeart"] . "'") or die(mysqli_error($con));
            }
            $obj = $prod["qteart"] . "-" . addslashes($prod["designationart"]);
            $op = "Livraison Externe";
            if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                $rsltvente = $con->query("insert into hotel_historique(id_article, id_proprietaire, objet_h, operation_h, "
                        . "date_histo) values('" . $prod["idart"] . "', '" . $_SESSION["id_proprietaire"] . "', "
                        . "'" . $obj . "', '" . $op . "', NOW())") or die(mysqli_error($con));
            } else if (isset($_SESSION["login_personnel"]) && (isset($_SESSION["mot_de_passe_personnel"])) && ($_SESSION["etat_compte_personnel"])) {
                if (($_SESSION["code_service"] == "ECONO")) {
                    $rsltvente = $con->query("insert into hotel_historique(id_article, id_compte_personnel, objet_h, operation_h, "
                            . "date_histo) values('" . $prod["idart"] . "', '" . $_SESSION["id_compte_personnel"] . "', "
                            . "'" . $obj . "', '" . $op . "', NOW())") or die(mysqli_error($con));
                }
            }
        }
        ?>
        <?php
        unset($_SESSION["cart_prodvlex"]);
        echo "<script language='javascript'>$('div.alertuseraddbon').show('slow').delay(8000).hide('slow');</script>";
        ?>
        <a href="hotelpages/economathotel/bonlivraisonhotel/facture_livraison_pdf.php?bonlivraison=<?php echo $rowfa["id_bon_livraison"] ?>" class="btn btn-lg btn-success" target="_blank">
            <span title="Impriner le bon de livraison" alt="editer"><i class="fa fa-file-pdf-o"></i> Impriner le bon de livraison</span>
        </a>
        <?php
    } else {
        echo "<script language='javascript'>$('div.alertclformvide').show('slow').delay(8000).hide('slow');</script>";
    }
}

function lister_livraison($con) {
    $rsltuser = $con->query("select * from hotel_bon_livraison as a where a.id_fournisseur is not null order by a.date_bl desc") or die(mysqli_error($con));
    $num = 0;
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        $rsltuserf = $con->query("select * from hotel_fournisseur as a where a.id_fournisseur='" . $recuser["id_fournisseur"] . "'") or die(mysqli_error($con));
        $recuserf = mysqli_fetch_assoc($rsltuserf);
        $num = $num + 1;
        ?>
        <tr>
            <td><?php print $num ?></td>
            <td><?php print nl2br(htmlspecialchars($recuserf["nom_fournisseur"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["code_bl"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["montant_bl"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["etat_bl"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["date_bl"])) ?></td>
            <td>
                <?php
                if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                    ?>
                    <a href="indexproprietaire.php?page=<?php echo base64_encode('hotelpages/economathotel/bonlivraisonhotel/lister_livraison_ligne') ?>&bonlivraison=<?php echo $recuser["id_bon_livraison"] ?>">
                        <span title="Detail" alt="editer"><i class="glyphicon glyphicon-folder-close"></i></span>
                    </a>
                    <?php
                    if ($recuser["etat_bl"] == "En Cours") {
                        ?>
                        &nbsp;&nbsp;
                        <a href='#' onclick=valider_bon_liv(<?php echo $recuser["id_bon_livraison"] ?>)>
                            <span title="Valider ce bon de livraison" alt="valider"><i class="glyphicon glyphicon-remove"></i></span>
                        </a>
                        <?php
                    }
                } else if (isset($_SESSION["login_personnel"]) && (isset($_SESSION["mot_de_passe_personnel"])) && ($_SESSION["etat_compte_personnel"])) {
                    if (($_SESSION["code_service"] == "ECONO")) {
                        ?>
                        <a href="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/economathotel/bonlivraisonhotel/lister_livraison_ligne') ?>&bonlivraison=<?php echo $recuser["id_bon_livraison"] ?>">
                            <span title="Detail" alt="editer"><i class="glyphicon glyphicon-folder-close"></i></span>
                        </a>
                        <?php
                        if ($recuser["etat_bl"] == "En Cours") {
                            ?>
                            &nbsp;&nbsp;
                            <a href='#' onclick=valider_bon_liv(<?php echo $recuser["id_bon_livraison"] ?>)>
                                <span title="Valider ce bon de livraison" alt="valider"><i class="glyphicon glyphicon-remove"></i></span>
                            </a>
                            <?php
                        }
                    }
                }
                ?>
            </td>
        </tr>
        <?php
    }
}

function lister_livraison_ligne($id, $con) {
    $rsltuser = $con->query("select * from hotel_ligne_bon_livraison as lbl left join hotel_article as a on "
            . "lbl.id_article=a.id_article left join hotel_categorie as c on a.id_categorie=c.id_categorie where "
            . "lbl.id_bon_livraison='" . $id . "'") or die(mysqli_error($con));
    $num = 0;
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        $num = $num + 1;
        ?>
        <tr>
            <td><?php print $num ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["code_article"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["libelle_article"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["libelle_categorie"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["stock_lbl"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["prix_achat_lbl"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["prix_vente_lbl"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["prix_lavage_lbl"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["unite_achat_lbl"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["unite_vente_lbl"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["unite_sortie_lbl"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["etat_lbl"])) ?></td>
            <td>
                <?php
                if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                    if ($recuser["etat_lbl"] == "En Cours") {
                        ?>
                        &nbsp;&nbsp;
                        <a href='#' onclick=valider_bon_liv_ligne(<?php echo $recuser["id_ligne_bon_livraison"] ?>)>
                            <span title="Valider cette ligne de bon de livraison" alt="valider"><i class="glyphicon glyphicon-remove"></i></span>
                        </a>
                        <?php
                    }
                } else if (isset($_SESSION["login_personnel"]) && (isset($_SESSION["mot_de_passe_personnel"])) && ($_SESSION["etat_compte_personnel"])) {
                    if (($_SESSION["code_service"] == "ECONO")) {
                        if ($recuser["etat_lbl"] == "En Cours") {
                            ?>
                            &nbsp;&nbsp;
                            <a href='#' onclick=valider_bon_liv_ligne(<?php echo $recuser["id_ligne_bon_livraison"] ?>)>
                                <span title="Valider cette ligne de bon de livraison" alt="valider"><i class="glyphicon glyphicon-remove"></i></span>
                            </a>
                            <?php
                        }
                    }
                }
                ?>
            </td>
        </tr>
        <?php
    }
}

function lister_commande($con) {
    $rsltuser = $con->query("select * from hotel_bon_commande as a order by a.date_bc desc") or die(mysqli_error($con));
    $num = 0;
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        $num = $num + 1;
        ?>
        <tr>
            <td><?php print $num ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["code_bc"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["etat_bc"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["date_bc"])) ?></td>
            <td>
                <?php
                if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                    ?>
                    <a href="indexproprietaire.php?page=<?php echo base64_encode('hotelpages/economathotel/boncommandehotel/lister_commande_ligne') ?>&boncommande=<?php echo $recuser["id_bon_commande"] ?>">
                        <span title="Detail" alt="editer"><i class="glyphicon glyphicon-folder-close"></i></span>
                    </a>
                    <?php
                    if ($recuser["etat_bc"] == "En Cours") {
                        ?>
                        &nbsp;&nbsp;
                        <a href="indexproprietaire.php?page=<?php echo base64_encode('hotelpages/economathotel/bonlivraisonchotel/livraison') ?>&boncommande=<?php echo $recuser["id_bon_commande"] ?>">
                            <span title="Receptionner la livraison de ce bon de commande" alt="livrer"><i class="glyphicon glyphicon-remove"></i></span>
                        </a>
                        <?php
                    }
                } else if (isset($_SESSION["login_personnel"]) && (isset($_SESSION["mot_de_passe_personnel"])) && ($_SESSION["etat_compte_personnel"])) {
                    if (($_SESSION["code_service"] == "ECONO")) {
                        ?>
                        <a href="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/economathotel/boncommandehotel/lister_commande_ligne') ?>&boncommande=<?php echo $recuser["id_bon_commande"] ?>">
                            <span title="Detail" alt="editer"><i class="glyphicon glyphicon-folder-close"></i></span>
                        </a>
                        <?php
                        if ($recuser["etat_bc"] == "En Cours") {
                            ?>
                            &nbsp;&nbsp;
                            <a href="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/economathotel/bonlivraisonchotel/livraison') ?>&boncommande=<?php echo $recuser["id_bon_commande"] ?>">
                                <span title="Receptionner la livraison de ce bon de commande" alt="livrer"><i class="glyphicon glyphicon-remove"></i></span>
                            </a>
                            <?php
                        }
                    }
                }
                ?>
            </td>
        </tr>
        <?php
    }
}

function lister_commande_ligne($id, $con) {
    $rsltuser = $con->query("select * from hotel_ligne_bon_commande as lbl left join hotel_article as a on "
            . "lbl.id_article=a.id_article left join hotel_categorie as c on a.id_categorie=c.id_categorie where "
            . "lbl.id_bon_commande='" . $id . "'") or die(mysqli_error($con));
    $num = 0;
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        $num = $num + 1;
        ?>
        <tr>
            <td><?php print $num ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["code_article"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["libelle_article"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["libelle_categorie"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["stock_lbc"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["prix_lbc"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["etat_lbc"])) ?></td>

        </tr>
        <?php
    }
}

function lister_unite_produit($idp, $con) {
    $rsltuser = $con->query("select * from hotel_convertion as c left join hotel_unite as u on "
            . "c.id_unite=u.id_unite where c.id_article_point_hotel='" . $idp . "'") or die(mysqli_error($con));
    $num = 0;
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        $num = $num + 1;
        ?>
        <tr>
            <td><?php print $num ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["stock_convertion"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["libelle_unite"])) ?></td>
            <td>
                <?php
                if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                    ?>
                    <a href="indexproprietaire.php?page=<?php echo base64_encode('hotelpages/fourniturehotel/hotelconvertion/hotelajouter/ajouter_convertion') ?>&convertion=<?php echo $recuser["id_convertion"] ?>">
                        <span title="Modifier cette convertion" alt="editer"><i class="glyphicon glyphicon-pencil"></i></span>
                    </a>
                    <?php
                } else if (isset($_SESSION["login_personnel"]) && (isset($_SESSION["mot_de_passe_personnel"])) && ($_SESSION["etat_compte_personnel"])) {
                    if (($_SESSION["code_service"] == "ECONO")) {
                        ?>
                        <a href="indexuser.php?page=<?php echo base64_encode('hotelpages/fourniturehotel/hotelconvertion/hotelajouter/ajouter_convertion') ?>&convertion=<?php echo $recuser["id_convertion"] ?>">
                            <span title="Modifier cette convertion" alt="editer"><i class="glyphicon glyphicon-pencil"></i></span>
                        </a>
                        <?php
                    }
                }
                ?>
            </td>
        </tr>
        <?php
    }
}

//gestion des produits
function inserer_unite_produit($prod, $con) {
//    echo"<script language='javascript'>alert('ok')</script>";
    if (($prod != NULL) && isset($prod["1"])) {
        $reqta = $con->query("select * from hotel_convertion where id_article_point_hotel='" . $prod["1"]["article"] . "' and id_unite='" . $prod["1"]["unite"] . "'") or die(mysqli_error($con));
        $nbta = mysqli_num_rows($reqta);
        if ($nbta == 0) {
            $rslt = $con->query("insert into hotel_convertion(id_unite, id_article_point_hotel, stock_convertion) "
                    . "values('" . $prod["1"]["unite"] . "', '" . $prod["1"]["article"] . "', '" . $prod["1"]["stock"] . "')") or die(mysqli_error($con));
            unset($_SESSION['formprodunite']);
            echo "<script language='javascript'>$('div.alertaddbon').show('slow').delay(8000).hide('slow');</script>";
        }
    } else {
        echo "<script language='javascript'>$('div.alertaddnull').show('slow').delay(8000).hide('slow');</script>";
    }
}
?>