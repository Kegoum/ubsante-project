<?php
include('../../../hopitalconnexion/connexion.php');

$reqhote = $con->query("select * from hp_proprietaire as p left join hp_departement as d on "
        . "p.iddepartement=d.iddepartement left join hp_region as r on d.idregion=r.idregion ") or die(mysqli_error($con));
$rowhote = NULL;
while ($rowhote1 = mysqli_fetch_assoc($reqhote)) {
    $rowhote = $rowhote1;
}

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

if ((isset($_REQUEST["dated"])) && (isset($_REQUEST["datef"]))) {
    $dated = $_REQUEST["dated"];
    $datef = $_REQUEST["datef"];

    $datedd = explode('-', $dated);
    $datede = $datedd[2] . "-" . $datedd[1] . "-" . $datedd[0];

    $datedf = explode('-', $datef);
    $datefe = $datedf[2] . "-" . $datedf[1] . "-" . $datedf[0];

    $encais1 = 0;
    $decais1 = 0;

    $soldei = 0;
    $encais = 0;
    $decais = 0;

    $tabc = array();
    $ic = 0;

    $tabordo = array();
    $iordo = 0;

    $eta = "Actif";
    $ope = "Encaissement";
    $opd = "Décaissement";
    $rsltconsi = $con->query("select *, cast(lc.datejourlignecaisse as DATE) as datec from hp_ligne_caisse as lc left join hp_caisse "
            . "as c on lc.idcaisse=c.idcaisse where (cast(lc.datejourlignecaisse as DATE) < '" . $dated . "') "
            . "and lc.paiementlignecaisse='" . $eta . "'") or die(mysqli_error($con));
    while ($row = mysqli_fetch_assoc($rsltconsi)) {
        if ($row["operationlignecaisse"] == "Encaissement") {
            $soldei = $soldei + $row["montantlignecaisse"];
        } else {
            $soldei = $soldei - $row["montantlignecaisse"];
        }
    }
    $rsltcons = $con->query("select *, cast(lc.datejourlignecaisse as DATE) as datec from hp_ligne_caisse as lc left join hp_caisse "
            . "as c on lc.idcaisse=c.idcaisse where (cast(lc.datejourlignecaisse as DATE) BETWEEN '" . $dated . "' and '" . $datef . "') "
            . "and lc.paiementlignecaisse='" . $eta . "' and lc.operationlignecaisse='" . $ope . "' order by datec desc") or die(mysqli_error($con));

    $rsltord = $con->query("select *, cast(lc.datejourlignecaisse as DATE) as datec from hp_ligne_caisse as lc left join hp_caisse "
            . "as c on lc.idcaisse=c.idcaisse where (cast(lc.datejourlignecaisse as DATE) BETWEEN '" . $dated . "' and '" . $datef . "') "
            . "and lc.paiementlignecaisse='" . $eta . "' and lc.operationlignecaisse='" . $opd . "' order by datec desc") or die(mysqli_error($con));

    while ($rowlbl = mysqli_fetch_assoc($rsltcons)) {

        $rsltuarpa = $con->query("select * from hp_facture as lc where "
                . "lc.idfacture='" . $rowlbl["idfacture"] . "'") or die(mysqli_error($con));
        $rowarpa = mysqli_fetch_assoc($rsltuarpa);
        $but = "";
        if ($rowarpa["idconsultation"] != NULL) {
            $but = "Consultation";
        } else if ($rowarpa["idexamenpatient"] != NULL) {
            $but = "Examen";
        } else if ($rowarpa["idechographiepatient"] != NULL) {
            $but = "Echographie";
        } else if ($rowarpa["idactepatient"] != NULL) {
            $but = "Autre";
        } else if ($rowarpa["idordonnance"] != NULL) {
            $but = "Ordonance";
        }

        $prodArray = array($rowlbl["datec"] => array(
                'datem' => $rowlbl["datec"],
                'lignefinance' => array()
        ));

        $prodArray[$rowlbl["datec"]]["lignefinance"][$ic]["referencem"] = "";
        $prodArray[$rowlbl["datec"]]["lignefinance"][$ic]["libellem"] = $but;
        $prodArray[$rowlbl["datec"]]["lignefinance"][$ic]["montant"] = $rowlbl["montantlignecaisse"];
        $encais1 = $encais1 + $rowlbl["montantlignecaisse"];

        if (!empty($tabc)) {
            $f = FALSE;
            $fm = FALSE;
            foreach ($tabc as $k => $v) {
                if (($tabc[$k]["datem"] == $rowlbl["datec"])) {
                    $f = TRUE;
                    foreach ($tabc[$k]["lignefinance"] as $km => $vm) {
                        if (($tabc[$k]["lignefinance"][$km]["libellem"] == $but)) {
                            $fm = TRUE;
                            $tabc[$k]["lignefinance"][$km]["montant"] = $tabc[$k]["lignefinance"][$km]["montant"] + $rowlbl["montantlignecaisse"];
                        }
                    }

                    if (!$fm) {
                        $tabc[$k]["lignefinance"][$ic]["referencem"] = "";
                        $tabc[$k]["lignefinance"][$ic]["libellem"] = $but;
                        $tabc[$k]["lignefinance"][$ic]["montant"] = $rowlbl["montantlignecaisse"];
                        $ic = $ic + 1;
                    }
                }
            }
            if (!$f) {
                $tabc = array_merge($tabc, $prodArray);
                $ic = $ic + 1;
            }
        } else {
            $tabc = $prodArray;
            $ic = $ic + 1;
        }
    }
    while ($rowlbl = mysqli_fetch_assoc($rsltord)) {

        $prodArray = array($rowlbl["datec"] => array(
                'datem' => $rowlbl["datec"],
                'lignefinance' => array()
        ));

        $prodArray[$rowlbl["datec"]]["lignefinance"][$iordo]["referencem"] = $rowlbl["codelignecaisse"];
        $prodArray[$rowlbl["datec"]]["lignefinance"][$iordo]["libellem"] = $rowlbl["butlignecaisse"];
        $prodArray[$rowlbl["datec"]]["lignefinance"][$iordo]["montant"] = $rowlbl["montantlignecaisse"];
        $decais1 = $decais1 + $rowlbl["montantlignecaisse"];

        if (!empty($tabordo)) {
            $f = FALSE;
            $fm = FALSE;
            foreach ($tabordo as $k => $v) {
                if (($tabordo[$k]["datem"] == $rowlbl["datec"])) {
                    $f = TRUE;
                    foreach ($tabordo[$k]["lignefinance"] as $km => $vm) {
                        if (($tabordo[$k]["lignefinance"][$km]["referencem"] == $rowlbl["codelignecaisse"])) {
                            $fm = TRUE;
                            $tabordo[$k]["lignefinance"][$km]["montant"] = $tabordo[$k]["lignefinance"][$km]["montant"] + $rowlbl["montantlignecaisse"];
                        }
                    }

                    if (!$fm) {
                        $tabordo[$k]["lignefinance"][$iordo]["referencem"] = $rowlbl["codelignecaisse"];
                        $tabordo[$k]["lignefinance"][$iordo]["libellem"] = $rowlbl["butlignecaisse"];
                        $tabordo[$k]["lignefinance"][$iordo]["montant"] = $rowlbl["montantlignecaisse"];
                        $iordo = $iordo + 1;
//                print_r($iordo);
                    }
                }
            }
            if (!$f) {
                $tabordo = array_merge($tabordo, $prodArray);
                $iordo = $iordo + 1;
            }
        } else {
            $tabordo = $prodArray;
            $iordo = $iordo + 1;
        }
    }
    $soldef1 = $soldei + $encais1 - $decais1;
    $date2 = date('d-m-Y');
    ?>
    <page backtop="5mm" backbottom="5mm" backleft="5mm" backright="10mm">
        <table style="width: 100%;border: none;">
            <tr>
                <td style="width: 40%; text-align: center; font-size: 9pt; font-weight: bold;">
                    <!--REPUBLIC OF CAMEROON <br> Peace - Work - Fatherland<br>-->
                    <?php echo strtoupper($rowhote["hopitalproprietaire"]); ?><br>
                    <?php echo strtoupper($rowhote["sloganproprietaire"]); ?><br>
                    B. P. <?php echo $rowhote["bpproprietaire"]; ?> 
                    T&eacute;l: <?php echo $rowhote["telephoneproprietaire"]; ?>
                    E-mail<?php echo $rowhote["emailproprietaire"]; ?>
                </td>
                <td style="width: 20%; text-align: center; font-size: 7pt;">
                    <img src="../../../hopitalupload/logo/<?php echo $rowhote["logoproprietaire"] ?>" alt="logo" style="height: 22mm; border-radius: 6mm;"><br>
                </td>
                <td style="width: 40%; text-align: center; font-size: 9pt; font-weight: bold;">
                    REPUBLIQUE DU CAMEROUN<br>Paix - Travail - Patrie<br>
                </td>
            </tr>
        </table><br>
        <table align="center" >
            <tr>
                <td style="text-align: center; font-size: 22pt; font-weight: bold;">
            <u>
                <h2>Le journal de caisse du <?php echo $dated ?> au <?php echo $datef ?></h2>
            </u>
            </td>
            </tr>
        </table><br><br>
        <table cellspacing="0" style="width: 100%; border: solid 1px; font-size: 10pt;">
            <thead>    
                <tr> 
                    <th style="width: 15%;text-align: left; border: solid 1px;">Solde initial :</th>
                    <th style="width: 25%;text-align: right; border: solid 1px;"><b><?php echo number_format($soldei, 0, ',', ' '); ?></b></th>
                    <th style="width: 40%;text-align: center; border: solid 1px;"></th>
                    <th style="width: 20%;text-align: center; border: solid 1px;"></th>
                </tr>    
                <tr> 
                    <th style="width: 15%;text-align: left; border: solid 1px;">Encaissement :</th>
                    <th style="width: 25%;text-align: right; border: solid 1px;"><b><?php echo number_format($encais1, 0, ',', ' '); ?></b></th>
                    <th style="width: 40%;text-align: center; border: solid 1px;"></th>
                    <th style="width: 20%;text-align: center; border: solid 1px;"></th>
                </tr>    
                <tr> 
                    <th style="width: 15%;text-align: left; border: solid 1px;">Decaissement :</th>
                    <th style="width: 25%;text-align: right; border: solid 1px;"><b><?php echo number_format($decais1, 0, ',', ' '); ?></b></th>
                    <th style="width: 40%;text-align: center; border: solid 1px;"></th>
                    <th style="width: 20%;text-align: center; border: solid 1px;"></th>
                </tr>    
                <tr> 
                    <th style="width: 15%;text-align: left; border: solid 1px;">Solde final :</th>
                    <th style="width: 25%;text-align: right; border: solid 1px;"><b><?php echo number_format($soldef1, 0, ',', ' '); ?></b></th>
                    <th style="width: 40%;text-align: center; border: solid 1px;"></th>
                    <th style="width: 20%;text-align: center; border: solid 1px;"></th>
                </tr>      
                <tr> 
                    <th colspan="4" style="width: 100%;text-align: center; border: solid 1px;">&nbsp;</th>
                </tr>
                <tr style=" background: #cbcaca;"> 
                    <th style="width: 15%;text-align: center; border: solid 1px;">Date</th>
                    <th style="width: 25%;text-align: center; border: solid 1px;">Reference</th>
                    <th style="width: 40%;text-align: center; border: solid 1px;">Libelle</th>
                    <th style="width: 20%;text-align: center; border: solid 1px;">Montant</th>
                </tr>
            </thead>
            <tbody>
                <tr style="background-color: #eee">
                    <td colspan="2" style="width: 40%;text-align: center; border: solid 1px;"><b>Solde initial</b></td>
                    <td style="width: 40%;text-align: right; border: solid 1px;"></td>
                    <td style="width: 20%;text-align: right; border: solid 1px;"><b><?php echo number_format($soldei, 0, ',', ' '); ?></b></td>
                </tr>
                <?php
                if ($ic != 0) {
                    ?>
                    <tr>
                        <td style="width: 15%;text-align: center; border: solid 1px;"><b>Encaissement</b></td>
                        <td style="width: 25%;text-align: center; border: solid 1px;"></td>
                        <td style="width: 40%;text-align: center; border: solid 1px;"></td>
                        <td style="width: 20%;text-align: center; border: solid 1px;"></td>
                    </tr>
                    <?php
                    foreach ($tabc as $prod) {
//                            print_r($prod);
                        foreach ($prod["lignefinance"] as $prodm) {
                            ?>
                            <tr >
                                <td style="width: 15%;text-align: center; border: solid 1px;"><?php print nl2br(htmlspecialchars($prod["datem"])) ?></td>
                                <td style="width: 25%;text-align: left; border: solid 1px;"><?php print nl2br(htmlspecialchars($prodm["referencem"])) ?></td>
                                <td style="width: 40%;text-align: left; border: solid 1px;"><?php print nl2br(htmlspecialchars($prodm["libellem"])) ?></td>
                                <td style="width: 20%;text-align: right; border: solid 1px;"><?php print number_format($prodm["montant"], 0, ',', ' '); ?></td>
                            </tr>
                            <?php
                            $encais = $encais + $prodm["montant"];
                        }
                    }
                    ?>
                    <tr style="background-color: #eee">
                        <td colspan="2" style="width: 40%;text-align: center; border: solid 1px;"><b>Total Encaissement</b></td>
                        <td style="width: 40%;text-align: right; border: solid 1px;"></td>
                        <td style="width: 20%;text-align: right; border: solid 1px;"><b><?php echo number_format($encais, 0, ',', ' '); ?></b></td>
                    </tr>
                    <tr>
                        <td style="width: 15%;text-align: right; border: solid 1px;">&nbsp;</td>
                        <td style="width: 25%;text-align: right; border: solid 1px;"></td>
                        <td style="width: 40%;text-align: right; border: solid 1px;"></td>
                        <td style="width: 20%;text-align: right; border: solid 1px;"></td>
                    </tr>
                    <?php
                }
                ?>
                <?php
                if ($iordo != 0) {
                    ?>
                    <tr>
                        <td style="width: 15%;text-align: center; border: solid 1px;"><b>D&eacute;caissement</b></td>
                        <td style="width: 25%;text-align: left; border: solid 1px;"></td>
                        <td style="width: 40%;text-align: right; border: solid 1px;"></td>
                        <td style="width: 20%;text-align: right; border: solid 1px;"></td>
                    </tr>
                    <?php
                    foreach ($tabordo as $prod) {
//                            print_r($prod);
                        foreach ($prod["lignefinance"] as $prodm) {
                            ?>
                            <tr >
                                <td style="width: 15%;text-align: center; border: solid 1px;"><?php print nl2br(htmlspecialchars($prod["datem"])) ?></td>
                                <td style="width: 25%;text-align: left; border: solid 1px;"><?php print nl2br(htmlspecialchars($prodm["referencem"])) ?></td>
                                <td style="width: 40%;text-align: left; border: solid 1px;"><?php print nl2br(htmlspecialchars($prodm["libellem"])) ?></td>
                                <td style="width: 20%;text-align: right; border: solid 1px;"><?php print number_format($prodm["montant"], 0, ',', ' '); ?></td>

                            </tr>
                            <?php
                            $decais = $decais + $prodm["montant"];
                        }
                    }
                    ?>
                    <tr style="background-color: #eee">
                        <td colspan="2" style="width: 40%;text-align: center; border: solid 1px;"><b>Total D&eacute;caissement</b></td>
                        <td style="width: 40%;text-align: right; border: solid 1px;"></td>
                        <td style="width: 20%;text-align: right; border: solid 1px;"><b><?php echo number_format($decais, 0, ',', ' '); ?></b></td>
                    </tr>
                    <tr>
                        <td style="width: 15%;text-align: center; border: solid 1px;">&nbsp;</td>
                        <td style="width: 25%;text-align: left; border: solid 1px;"></td>
                        <td style="width: 40%;text-align: right; border: solid 1px;"></td>
                        <td style="width: 20%;text-align: right; border: solid 1px;"></td>
                    </tr>
                    <?php
                }
                ?>
                <tr>
                    <td style="width: 15%;text-align: right; border: solid 1px;">&nbsp;</td>
                    <td style="width: 25%;text-align: right; border: solid 1px;"></td>
                    <td style="width: 40%;text-align: right; border: solid 1px;"></td>
                    <td style="width: 20%;text-align: right; border: solid 1px;"></td>
                </tr>
                <?php
                $soldef = $soldei + $encais - $decais;
                ?>
                <tr style="background-color: #eee">
                    <td colspan="2" style="width: 40%;text-align: center; border: solid 1px;"><b>Solde final</b></td>
                    <td style="width: 40%;text-align: right; border: solid 1px;"></td>
                    <td style="width: 20%;text-align: right; border: solid 1px;"><b><?php echo number_format($soldef, 0, ',', ' '); ?></b></td>
                </tr>
            </tbody>
        </table><br><br>
        <table cellspacing="0" style="width: 100%; font-size: 16pt">
            <tr>
                <td style="width: 100%; text-align: right">
                    <b>Fait à Yaound&eacute;, le</b> <?php echo $date2 ?><br> &nbsp;
                </td>
            </tr>
            <tr>
                <td style="width: 50%; text-align: right">
                    Signature de la Direction
                </td>
            </tr>
        </table>
    </page>  
    <?php
}
?>

