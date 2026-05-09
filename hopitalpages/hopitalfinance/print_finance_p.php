<?php
include('../../hopitalconnexion/connexion.php');

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
    $montanttotalc = 0;
    $montanttotalp = 0;
    $montanttotaln = 0;

    $tabc = array();
    $ic = 0;
    $montantcc = 0;
    $montantpc = 0;
    $montantnc = 0;

    $tabcp = array();
    $icp = 0;
    $montantccp = 0;
    $montantpcp = 0;
    $montantncp = 0;

    $tabvac = array();
    $ivac = 0;
    $montantcvac = 0;
    $montantpvac = 0;
    $montantnvac = 0;

    $tabexa = array();
    $iexa = 0;
    $montantcexa = 0;
    $montantpexa = 0;
    $montantnexa = 0;

    $tabecho = array();
    $iecho = 0;
    $montantcecho = 0;
    $montantpecho = 0;
    $montantnecho = 0;

    $tabordo = array();
    $iordo = 0;
    $montantcordo = 0;
    $montantpordo = 0;
    $montantnordo = 0;

    $taba = array();
    $ia = 0;
    $montantca = 0;
    $montantpa = 0;
    $montantna = 0;

    $tabhos = array();
    $ihos = 0;
    $montantchos = 0;
    $montantphos = 0;
    $montantnhos = 0;

    $rsltcons = $con->query("select *, cast(c.dateconsultation as DATE) as datec from hp_consultation as c "
            . "left join hp_sous_dossier as sd on c.idsousdossier=sd.idsousdossier where "
            . "(cast(c.dateconsultation as DATE) "
            . "BETWEEN '" . $dated . "' and '" . $datef . "') order by datec desc") or die(mysqli_error($con));

    $rsltexa = $con->query("select *, cast(c.dateexamenpatient as DATE) as datec from hp_examen_patient as c "
            . "left join hp_sous_dossier as sd on c.idsousdossier=sd.idsousdossier where "
            . "(cast(c.dateexamenpatient as DATE) "
            . "BETWEEN '" . $dated . "' and '" . $datef . "') order by datec desc") or die(mysqli_error($con));

    $rsltecho = $con->query("select *, cast(c.dateechographiepatient as DATE) as datec from hp_echographie_patient as c "
            . "left join hp_sous_dossier as sd on c.idsousdossier=sd.idsousdossier where "
            . "(cast(c.dateechographiepatient as DATE) "
            . "BETWEEN '" . $dated . "' and '" . $datef . "') order by datec desc") or die(mysqli_error($con));

    $rsltord = $con->query("select *, cast(c.dateordonnance as DATE) as datec from hp_ordonnance as c "
            . "left join hp_sous_dossier as sd on c.idsousdossier=sd.idsousdossier where "
            . "(cast(c.dateordonnance as DATE) "
            . "BETWEEN '" . $dated . "' and '" . $datef . "') order by datec desc") or die(mysqli_error($con));

    $rslthos = $con->query("select *, cast(c.datehospitalisation as DATE) as datec from hp_hospitalisation as c "
            . "left join hp_sous_dossier as sd on c.idsousdossier=sd.idsousdossier where "
            . "(cast(c.datehospitalisation as DATE) "
            . "BETWEEN '" . $dated . "' and '" . $datef . "') order by datec desc") or die(mysqli_error($con));

    while ($rowlbl = mysqli_fetch_assoc($rsltcons)) {

        $rsltuarpa = $con->query("select * from hp_consultation as lc left join hp_acte as f on "
                . "lc.idacte=f.idacte left join hp_service as u on f.idservice=u.idservice where "
                . "lc.idconsultation='" . $rowlbl["idconsultation"] . "'") or die(mysqli_error($con));
        $rowarpa = mysqli_fetch_assoc($rsltuarpa);

        $rsltuarpf = $con->query("select * from hp_facture as lc where "
                . "lc.idconsultation='" . $rowlbl["idconsultation"] . "'") or die(mysqli_error($con));
        $rowarpf = mysqli_fetch_assoc($rsltuarpf);

        $prodArray = array($rowlbl["datec"] => array(
                'datem' => $rowlbl["datec"],
                'lignefinance' => array()
        ));

        $prodArray[$rowlbl["datec"]]["lignefinance"][$ic]["idm"] = $rowarpa["idconsultation"];
        $prodArray[$rowlbl["datec"]]["lignefinance"][$ic]["servicem"] = $rowarpa["nomservice"];
        $prodArray[$rowlbl["datec"]]["lignefinance"][$ic]["libellem"] = $rowarpa["libelleacte"];
        $prodArray[$rowlbl["datec"]]["lignefinance"][$ic]["montantc"] = $rowarpf["montantfacture"];
        $prodArray[$rowlbl["datec"]]["lignefinance"][$ic]["montantp"] = $rowarpf["avancefacture"];
        $prodArray[$rowlbl["datec"]]["lignefinance"][$ic]["montantn"] = $rowarpf["montantfacture"] - $rowarpf["avancefacture"];

        if (!empty($tabc)) {
            $f = FALSE;
            foreach ($tabc as $k => $v) {
                if (($tabc[$k]["datem"] == $rowlbl["datec"])) {
                    $f = TRUE;
                    $fm = FALSE;
                    foreach ($tabc[$k]["lignefinance"] as $km => $vm) {
                        if (($tabc[$k]["lignefinance"][$km]["libellem"] == $rowarpa["libelleacte"])) {
                            $fm = TRUE;
                            $tabc[$k]["lignefinance"][$km]["montantc"] = $tabc[$k]["lignefinance"][$km]["montantc"] + $rowarpf["montantfacture"];
                            $tabc[$k]["lignefinance"][$km]["montantp"] = $tabc[$k]["lignefinance"][$km]["montantp"] + $rowarpf["avancefacture"];
                            $tabc[$k]["lignefinance"][$km]["montantn"] = $tabc[$k]["lignefinance"][$km]["montantn"] + ($rowarpf["montantfacture"] - $rowarpf["avancefacture"]);
                        }
                    }
                       
                    if (!$fm) {
                        $tabc[$k]["lignefinance"][$ic]["idm"] = $rowarpa["idconsultation"];
                        $tabc[$k]["lignefinance"][$ic]["servicem"] = $rowarpa["nomservice"];
                        $tabc[$k]["lignefinance"][$ic]["libellem"] = $rowarpa["libelleacte"];
                        $tabc[$k]["lignefinance"][$ic]["montantc"] = $rowarpf["montantfacture"];
                        $tabc[$k]["lignefinance"][$ic]["montantp"] = $rowarpf["avancefacture"];
                        $tabc[$k]["lignefinance"][$ic]["montantn"] = $rowarpf["montantfacture"] - $rowarpf["avancefacture"];
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
    while ($rowlbl = mysqli_fetch_assoc($rsltexa)) {

        $rsltuarpa = $con->query("select * from hp_examen_patient as lc left join hp_examen as f on lc.idexamen=f.idexamen "
                . "left join hp_laboratoire as l on f.idlaboratoire=l.idlaboratoire left join hp_service as u on "
                . "l.idservice=u.idservice where "
                . "lc.idexamenpatient='" . $rowlbl["idexamenpatient"] . "'") or die(mysqli_error($con));

        $rowarpa = mysqli_fetch_assoc($rsltuarpa);

        $rsltuarpf = $con->query("select * from hp_facture as lc where "
                . "lc.idexamenpatient='" . $rowlbl["idexamenpatient"] . "'") or die(mysqli_error($con));
        $rowarpf = mysqli_fetch_assoc($rsltuarpf);

        $rsltfnp2 = $con->query("select * from hp_facture where idexamenpatient='" . $rowarpa["idexamenpatient"] . "' and "
                . "etatfacture=true ") or die(mysqli_error($con));
        $nbfnp = mysqli_num_rows($rsltfnp2);
        $prodArray = array($rowlbl["datec"] => array(
                'datem' => $rowlbl["datec"],
                'lignefinance' => array()
        ));

        $prodArray[$rowlbl["datec"]]["lignefinance"][$iexa]["idm"] = $rowarpa["idexamenpatient"];
        $prodArray[$rowlbl["datec"]]["lignefinance"][$iexa]["servicem"] = $rowarpa["nomservice"];
        $prodArray[$rowlbl["datec"]]["lignefinance"][$iexa]["libellem"] = $rowarpa["typeexamen"];
        $prodArray[$rowlbl["datec"]]["lignefinance"][$iexa]["montantc"] = $rowarpf["montantfacture"];
        $prodArray[$rowlbl["datec"]]["lignefinance"][$iexa]["montantp"] = $rowarpf["avancefacture"];
        $prodArray[$rowlbl["datec"]]["lignefinance"][$iexa]["montantn"] = $rowarpf["montantfacture"] - $rowarpf["avancefacture"];

        if (!empty($tabexa)) {
            $f = FALSE;
            $fm = FALSE;
            foreach ($tabexa as $k => $v) {
                if (($tabexa[$k]["datem"] == $rowlbl["datec"])) {
                    $f = TRUE;
                    foreach ($tabexa[$k]["lignefinance"] as $km => $vm) {
                        if (($tabexa[$k]["lignefinance"][$km]["libellem"] == $rowarpa["typeexamen"])) {
                            $fm = TRUE;
                            $tabexa[$k]["lignefinance"][$km]["montantc"] = $tabexa[$k]["lignefinance"][$km]["montantc"] + $rowarpf["montantfacture"];
                            $tabexa[$k]["lignefinance"][$km]["montantp"] = $tabexa[$k]["lignefinance"][$km]["montantp"] + $rowarpf["avancefacture"];
                            $tabexa[$k]["lignefinance"][$km]["montantn"] = $tabexa[$k]["lignefinance"][$km]["montantn"] + ($rowarpf["montantfacture"] - $rowarpf["avancefacture"]);
                        }
                    }

                    if (!$fm) {
                        $tabexa[$k]["lignefinance"][$iexa]["idm"] = $rowarpa["idexamenpatient"];
                        $tabexa[$k]["lignefinance"][$iexa]["servicem"] = $rowarpa["nomservice"];
                        $tabexa[$k]["lignefinance"][$iexa]["libellem"] = $rowarpa["typeexamen"];
                        $tabexa[$k]["lignefinance"][$iexa]["montantc"] = $rowarpf["montantfacture"];
                        $tabexa[$k]["lignefinance"][$iexa]["montantp"] = $rowarpf["avancefacture"];
                        $tabexa[$k]["lignefinance"][$iexa]["montantn"] = $rowarpf["montantfacture"] - $rowarpf["avancefacture"];
                        $iexa = $iexa + 1;
//                print_r($iexa);
                    }
                }
            }
            if (!$f) {
                $tabexa = array_merge($tabexa, $prodArray);
                $iexa = $iexa + 1;
            }
        } else {
            $tabexa = $prodArray;
            $iexa = $iexa + 1;
        }
    }
    while ($rowlbl = mysqli_fetch_assoc($rsltecho)) {

        $rsltuarpa = $con->query("select * from hp_echographie_patient as ep left join hp_echographie as e on ep.idechographie=e.idechographie "
                . "left join hp_acte as a on e.idacte=a.idacte left join hp_service as s on "
                . "e.idservice=s.idservice where "
                . "ep.idechographiepatient='" . $rowlbl["idechographiepatient"] . "'") or die(mysqli_error($con));

        $rowarpa = mysqli_fetch_assoc($rsltuarpa);

        $rsltuarpf = $con->query("select * from hp_facture as lc where "
                . "lc.idechographiepatient='" . $rowlbl["idechographiepatient"] . "'") or die(mysqli_error($con));
        $rowarpf = mysqli_fetch_assoc($rsltuarpf);

        $rsltfnp2 = $con->query("select * from hp_facture where idechographiepatient='" . $rowarpa["idechographiepatient"] . "' and "
                . "etatfacture=true ") or die(mysqli_error($con));
        $nbfnp = mysqli_num_rows($rsltfnp2);
        $prodArray = array($rowlbl["datec"] => array(
                'datem' => $rowlbl["datec"],
                'lignefinance' => array()
        ));

        $prodArray[$rowlbl["datec"]]["lignefinance"][$iecho]["idm"] = $rowarpa["idechographiepatient"];
        $prodArray[$rowlbl["datec"]]["lignefinance"][$iecho]["servicem"] = "Echographie";
        $prodArray[$rowlbl["datec"]]["lignefinance"][$iecho]["libellem"] = $rowarpa["typeechographie"];
        $prodArray[$rowlbl["datec"]]["lignefinance"][$iecho]["montantc"] = $rowarpf["montantfacture"];
        $prodArray[$rowlbl["datec"]]["lignefinance"][$iecho]["montantp"] = $rowarpf["avancefacture"];
        $prodArray[$rowlbl["datec"]]["lignefinance"][$iecho]["montantn"] = $rowarpf["montantfacture"] - $rowarpf["avancefacture"];

        if (!empty($tabecho)) {
            $f = FALSE;
            $fm = FALSE;
            foreach ($tabecho as $k => $v) {
                if (($tabecho[$k]["datem"] == $rowlbl["datec"])) {
                    $f = TRUE;
                    foreach ($tabecho[$k]["lignefinance"] as $km => $vm) {
                        if (($tabecho[$k]["lignefinance"][$km]["libellem"] == $rowarpa["typeechographie"])) {
                            $fm = TRUE;
                            $tabecho[$k]["lignefinance"][$km]["montantc"] = $tabecho[$k]["lignefinance"][$km]["montantc"] + $rowarpf["montantfacture"];
                            $tabecho[$k]["lignefinance"][$km]["montantp"] = $tabecho[$k]["lignefinance"][$km]["montantp"] + $rowarpf["avancefacture"];
                            $tabecho[$k]["lignefinance"][$km]["montantn"] = $tabecho[$k]["lignefinance"][$km]["montantn"] + ($rowarpf["montantfacture"] - $rowarpf["avancefacture"]);
                        }
                    }

                    if (!$fm) {
                        $tabecho[$k]["lignefinance"][$iecho]["idm"] = $rowarpa["idechographiepatient"];
                        $tabecho[$k]["lignefinance"][$iecho]["servicem"] = "Echographie";
                        $tabecho[$k]["lignefinance"][$iecho]["libellem"] = $rowarpa["typeechographie"];
                        $tabecho[$k]["lignefinance"][$iecho]["montantc"] = $rowarpf["montantfacture"];
                        $tabecho[$k]["lignefinance"][$iecho]["montantp"] = $rowarpf["avancefacture"];
                        $tabecho[$k]["lignefinance"][$iecho]["montantn"] = $rowarpf["montantfacture"] - $rowarpf["avancefacture"];
                        $iecho = $iecho + 1;
//                print_r($iecho);
                    }
                }
            }
            if (!$f) {
                $tabecho = array_merge($tabecho, $prodArray);
                $iecho = $iecho + 1;
            }
        } else {
            $tabecho = $prodArray;
            $iecho = $iecho + 1;
        }
    }
    while ($rowlbl = mysqli_fetch_assoc($rsltord)) {

        $rsltuarpa = $con->query("select * from hp_ligne_ordonnance as lo left join hp_produit as a on "
                . "lo.idproduit=a.idproduit left join hp_categorie as c on "
                . "a.idcategorie=c.idcategorie where "
                . "lo.idordonnance='" . $rowlbl["idordonnance"] . "'") or die(mysqli_error($con));

        $rsltuarpf = $con->query("select * from hp_facture as lc where "
                . "lc.idordonnance='" . $rowlbl["idordonnance"] . "'") or die(mysqli_error($con));
        $rowarpf = mysqli_fetch_assoc($rsltuarpf);

        $prodArray = array($rowlbl["datec"] => array(
                'datem' => $rowlbl["datec"],
                'lignefinance' => array()
        ));

        while ($rowarpa = mysqli_fetch_assoc($rsltuarpa)) {
            $rsltua = $con->query("select * from hp_unite where idunite='" . $rowarpa["idunite"] . "'") or die(mysqli_error($con));
            $rowa = mysqli_fetch_assoc($rsltua);

            $prodArray[$rowlbl["datec"]]["lignefinance"][$iordo]["idm"] = $rowarpa["idproduit"];
            $prodArray[$rowlbl["datec"]]["lignefinance"][$iordo]["servicem"] = "Pharmacie";
            $prodArray[$rowlbl["datec"]]["lignefinance"][$iordo]["libellem"] = $rowarpa["libelleproduit"];
            $prodArray[$rowlbl["datec"]]["lignefinance"][$iordo]["montantc"] = $rowarpf["montantfacture"];
            $prodArray[$rowlbl["datec"]]["lignefinance"][$iordo]["montantp"] = $rowarpf["avancefacture"];
            $prodArray[$rowlbl["datec"]]["lignefinance"][$iordo]["montantn"] = $rowarpf["montantfacture"] - $rowarpf["avancefacture"];

            if (!empty($tabordo)) {
                $f = FALSE;
                $fm = FALSE;
                foreach ($tabordo as $k => $v) {
                    if (($tabordo[$k]["datem"] == $rowlbl["datec"])) {
                        $f = TRUE;
                        foreach ($tabordo[$k]["lignefinance"] as $km => $vm) {
                            if (($tabordo[$k]["lignefinance"][$km]["libellem"] == $rowarpa["libelleproduit"])) {
                                $fm = TRUE;
                                $tabordo[$k]["lignefinance"][$km]["montantc"] = $tabordo[$k]["lignefinance"][$km]["montantc"] + $rowarpf["montantfacture"];
                                $tabordo[$k]["lignefinance"][$km]["montantp"] = $tabordo[$k]["lignefinance"][$km]["montantp"] + $rowarpf["avancefacture"];
                                $tabordo[$k]["lignefinance"][$km]["montantn"] = $tabordo[$k]["lignefinance"][$km]["montantn"] + ($rowarpf["montantfacture"] - $rowarpf["avancefacture"]);
                            }
                        }

                        if (!$fm) {
                            $tabordo[$k]["lignefinance"][$iordo]["idm"] = $rowarpa["idproduit"];
                            $tabordo[$k]["lignefinance"][$iordo]["servicem"] = "Pharmacie";
                            $tabordo[$k]["lignefinance"][$iordo]["libellem"] = $rowarpa["libelleproduit"];
                            $tabordo[$k]["lignefinance"][$iordo]["montantc"] = $rowarpf["montantfacture"];
                            $tabordo[$k]["lignefinance"][$iordo]["montantp"] = $rowarpf["avancefacture"];
                            $tabordo[$k]["lignefinance"][$iordo]["montantn"] = $rowarpf["montantfacture"] - $rowarpf["avancefacture"];
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
    }
    while ($rowlbl = mysqli_fetch_assoc($rslthos)) {

        $rsltpl = $con->query("select * from hp_deplacement_patient as dp left join hp_facture as f on "
                . "dp.iddeplacementpatient=f.iddeplacementpatient where dp.idhospitalisation='" . $rowlbl["idhospitalisation"] . "' "
                . "and dp.regledeplacementpatient=false order by dp.datedeplacementpatient desc limit 0,1 ") or die(mysqli_error($con));
        $rowpl = mysqli_fetch_assoc($rsltpl);

        $rsltpl2 = $con->query("select * from hp_deplacement_patient as dp left join hp_facture as f on "
                . "dp.iddeplacementpatient=f.iddeplacementpatient where dp.idhospitalisation='" . $rowlbl["idhospitalisation"] . "' "
                . "and dp.regledeplacementpatient=false order by dp.datedeplacementpatient desc  limit 0,1") or die(mysqli_error($con));
        $today = date('Y-m-d H:i:s');

        $prodArray = array($rowlbl["datec"] => array(
                'datem' => $rowlbl["datec"],
                'lignefinance' => array()
        ));
        $rowpl2 = mysqli_fetch_assoc($rsltpl2);

        $rsltuarpf = $con->query("select * from hp_facture as lc where "
                . "lc.iddeplacementpatient='" . $rowpl2["iddeplacementpatient"] . "'") or die(mysqli_error($con));
        $rowarpf = mysqli_fetch_assoc($rsltuarpf);

        $dif = dateDiff($rowpl2["datedebutdeplacementpatient"], $today);
        $reqch = $con->query("select * from hp_lit as l left join hp_chambre as c on l.idchambre=c.idchambre "
                . "where l.idlit= '" . $rowpl2["idlit"] . "' ") or die(mysqli_error($con));
        $rowch = mysqli_fetch_assoc($reqch);

        $lib = $rowlbl["datedebuthospitalisation"] . " - " . $rowlbl["datefinhospitalisation"] . "  " . $rowch["codechambre"] . " - " .
                $rowch["codelit"];
        $etar = "Non réglée";
        $etas = "En Cours";
        if ($rowlbl["reglehospitalisation"]) {
            $etar = "Réglée";
        }
        if ($rowlbl["sortiehospitalisation"]) {
            $etas = "Sortie";
        }
        $prodArray[$rowlbl["datec"]]["lignefinance"][$ihos]["idm"] = $rowlbl["idhospitalisation"];
        $prodArray[$rowlbl["datec"]]["lignefinance"][$ihos]["servicem"] = "Hospitalisation";
        $prodArray[$rowlbl["datec"]]["lignefinance"][$ihos]["libellem"] = $lib;
        $prodArray[$rowlbl["datec"]]["lignefinance"][$ihos]["montantc"] = $rowarpf["montantfacture"];
        $prodArray[$rowlbl["datec"]]["lignefinance"][$ihos]["montantp"] = $rowarpf["avancefacture"];
        $prodArray[$rowlbl["datec"]]["lignefinance"][$ihos]["montantn"] = $rowarpf["montantfacture"] - $rowarpf["avancefacture"];

        if (!empty($tabhos)) {
            $f = FALSE;
            $fm = FALSE;
            foreach ($tabhos as $k => $v) {
                if (($tabhos[$k]["datem"] == $rowlbl["datec"])) {
                    $f = TRUE;
                    foreach ($tabhos[$k]["lignefinance"] as $km => $vm) {
                        if (($tabhos[$k]["lignefinance"][$km]["libellem"] == $rowarpa["libelleacte"])) {
                            $fm = TRUE;
                            $tabhos[$k]["lignefinance"][$km]["montantc"] = $tabhos[$k]["lignefinance"][$km]["montantc"] + $rowarpf["montantfacture"];
                            $tabhos[$k]["lignefinance"][$km]["montantp"] = $tabhos[$k]["lignefinance"][$km]["montantp"] + $rowarpf["avancefacture"];
                            $tabhos[$k]["lignefinance"][$km]["montantn"] = $tabhos[$k]["lignefinance"][$km]["montantn"] + ($rowarpf["montantfacture"] - $rowarpf["avancefacture"]);
                        }
                    }

                    if (!$fm) {
                        $tabhos[$k]["lignefinance"][$ihos]["idm"] = $rowlbl["idhospitalisation"];
                        $tabhos[$k]["lignefinance"][$ihos]["servicem"] = "Hospitalisation";
                        $tabhos[$k]["lignefinance"][$ihos]["libellem"] = $lib;
                        $tabhos[$k]["lignefinance"][$ihos]["montantc"] = $rowarpf["montantfacture"];
                        $tabhos[$k]["lignefinance"][$ihos]["montantp"] = $rowarpf["avancefacture"];
                        $tabhos[$k]["lignefinance"][$ihos]["montantn"] = $rowarpf["montantfacture"] - $rowarpf["avancefacture"];
                        $ihos = $ihos + 1;
//                print_r($ihos);
                    }
                }
            }
            if (!$f) {
                $tabhos = array_merge($tabhos, $prodArray);
                $ihos = $ihos + 1;
            }
        } else {
            $tabhos = $prodArray;
            $ihos = $ihos + 1;
        }
    }
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
                    <img src="../../<?php echo $rowhote["logoproprietaire"] ?>" alt="logo" style="height: 22mm; border-radius: 6mm;"><br>
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
                <h2>Finance du <?php echo $dated ?> au <?php echo $datef ?></h2>
            </u>
            </td>
            </tr>
        </table><br><br>
        <table cellspacing="0" style="width: 100%; border: solid 1px; font-size: 10pt;">
            <thead>    
                <tr style=" background: #cbcaca;"> 
                    <th style="width: 15%;text-align: center; border: solid 1px;">Date</th>
                    <th style="width: 25%;text-align: center; border: solid 1px;">Objet</th>
                    <th style="width: 20%;text-align: center; border: solid 1px;">Finance total</th>
                    <th style="width: 20%;text-align: center; border: solid 1px;">Finance r&eacute;gl&eacute;e</th>
                    <th style="width: 20%;text-align: center; border: solid 1px;">Finance non r&eacute;gl&eacute;e</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($ic != 0) {
                    ?>
                    <tr>
                        <td style="width: 15%;text-align: center; border: solid 1px;">Concultation</td>
                        <td style="width: 25%;text-align: center; border: solid 1px;"></td>
                        <td style="width: 20%;text-align: center; border: solid 1px;"></td>
                        <td style="width: 20%;text-align: center; border: solid 1px;"></td>
                        <td style="width: 20%;text-align: center; border: solid 1px;"></td>
                    </tr>
                    <?php
                    foreach ($tabc as $prod) {
//                            print_r($prod);
                        foreach ($prod["lignefinance"] as $prodm) {
                            ?>
                            <tr >
                                <td style="width: 15%;text-align: center; border: solid 1px;"><?php print nl2br(htmlspecialchars($prod["datem"])) ?></td>
                                <td style="width: 25%;text-align: left; border: solid 1px;"><?php print nl2br(htmlspecialchars($prodm["libellem"])) ?></td>
                                <td style="width: 20%;text-align: right; border: solid 1px;"><?php print number_format($prodm["montantc"], 0, ',', ' '); ?></td>
                                <td style="width: 20%;text-align: right; border: solid 1px;"><?php print number_format($prodm["montantp"], 0, ',', ' '); ?></td>
                                <td style="width: 20%;text-align: right; border: solid 1px;"><?php print number_format($prodm["montantn"], 0, ',', ' '); ?></td>
                            </tr>
                            <?php
                            $montantcc = $montantcc + $prodm["montantc"];
                            $montantpc = $montantpc + $prodm["montantp"];

                            $montanttotalc = $montanttotalc + $prodm["montantc"];
                            $montanttotalp = $montanttotalp + $prodm["montantp"];
                        }
                    }
                    $montantnc = $montantcc - $montantpc;
                    ?>
                    <tr style="background-color: #eee">
                        <td colspan="2" style="width: 40%;text-align: center; border: solid 1px;">Total Concultation</td>
                        <td style="width: 20%;text-align: right; border: solid 1px;"><?php echo number_format($montantcc, 0, ',', ' '); ?></td>
                        <td style="width: 20%;text-align: right; border: solid 1px;"><?php echo number_format($montantpc, 0, ',', ' '); ?></td>
                        <td style="width: 20%;text-align: right; border: solid 1px;"><?php echo number_format($montantnc, 0, ',', ' '); ?></td>
                    </tr>
                    <tr>
                        <td style="width: 15%;text-align: right; border: solid 1px;">&nbsp;</td>
                        <td style="width: 25%;text-align: right; border: solid 1px;"></td>
                        <td style="width: 20%;text-align: right; border: solid 1px;"></td>
                        <td style="width: 20%;text-align: right; border: solid 1px;"></td>
                        <td style="width: 20%;text-align: right; border: solid 1px;"></td>
                    </tr>
                    <?php
                }
                ?>

                <?php
                if ($iexa != 0) {
                    ?>
                    <tr>
                        <td style="width: 15%;text-align: center; border: solid 1px;">Examen</td>
                        <td style="width: 25%;text-align: left; border: solid 1px;"></td>
                        <td style="width: 20%;text-align: right; border: solid 1px;"></td>
                        <td style="width: 20%;text-align: right; border: solid 1px;"></td>
                        <td style="width: 20%;text-align: right; border: solid 1px;"></td>
                    </tr>
                    <?php
                    foreach ($tabexa as $prod) {
//                            print_r($prod);
                        foreach ($prod["lignefinance"] as $prodm) {
                            ?>
                            <tr >
                                <td style="width: 15%;text-align: center; border: solid 1px;"><?php print nl2br(htmlspecialchars($prod["datem"])) ?></td>
                                <td style="width: 25%;text-align: left; border: solid 1px;"><?php print nl2br(htmlspecialchars($prodm["libellem"])) ?></td>
                                <td style="width: 20%;text-align: right; border: solid 1px;"><?php print number_format($prodm["montantc"], 0, ',', ' '); ?></td>
                                <td style="width: 20%;text-align: right; border: solid 1px;"><?php print number_format($prodm["montantp"], 0, ',', ' '); ?></td>
                                <td style="width: 20%;text-align: right; border: solid 1px;"><?php print number_format($prodm["montantn"], 0, ',', ' '); ?></td>
                            </tr>
                            <?php
                            $montantcexa = $montantcexa + $prodm["montantc"];
                            $montantpexa = $montantpexa + $prodm["montantp"];

                            $montanttotalc = $montanttotalc + $prodm["montantc"];
                            $montanttotalp = $montanttotalp + $prodm["montantp"];
                        }
                    }
                    $montantnexa = $montantcexa - $montantpexa;
                    ?>
                    <tr style="background-color: #eee">
                        <td colspan="2" style="width: 40%;text-align: center; border: solid 1px;">Total Examen</td>
                        <td style="width: 20%;text-align: right; border: solid 1px;"><?php echo number_format($montantcexa, 0, ',', ' '); ?></td>
                        <td style="width: 20%;text-align: right; border: solid 1px;"><?php echo number_format($montantpexa, 0, ',', ' '); ?></td>
                        <td style="width: 20%;text-align: right; border: solid 1px;"><?php echo number_format($montantnexa, 0, ',', ' '); ?></td>
                    </tr>
                    <tr>
                        <td style="width: 15%;text-align: center; border: solid 1px;">&nbsp;</td>
                        <td style="width: 25%;text-align: left; border: solid 1px;"></td>
                        <td style="width: 20%;text-align: right; border: solid 1px;"></td>
                        <td style="width: 20%;text-align: right; border: solid 1px;"></td>
                        <td style="width: 20%;text-align: right; border: solid 1px;"></td>
                    </tr>
                    <?php
                }
                ?>
                <?php
                if ($iecho != 0) {
                    ?>
                    <tr>
                        <td style="width: 15%;text-align: center; border: solid 1px;">Echographie</td>
                        <td style="width: 25%;text-align: left; border: solid 1px;"></td>
                        <td style="width: 20%;text-align: right; border: solid 1px;"></td>
                        <td style="width: 20%;text-align: right; border: solid 1px;"></td>
                        <td style="width: 20%;text-align: right; border: solid 1px;"></td>
                    </tr>
                    <?php
                    foreach ($tabecho as $prod) {
//                            print_r($prod);
                        foreach ($prod["lignefinance"] as $prodm) {
                            ?>
                            <tr >
                                <td style="width: 15%;text-align: center; border: solid 1px;"><?php print nl2br(htmlspecialchars($prod["datem"])) ?></td>
                                <td style="width: 25%;text-align: left; border: solid 1px;"><?php print nl2br(htmlspecialchars($prodm["libellem"])) ?></td>
                                <td style="width: 20%;text-align: right; border: solid 1px;"><?php print number_format($prodm["montantc"], 0, ',', ' '); ?></td>
                                <td style="width: 20%;text-align: right; border: solid 1px;"><?php print number_format($prodm["montantp"], 0, ',', ' '); ?></td>
                                <td style="width: 20%;text-align: right; border: solid 1px;"><?php print number_format($prodm["montantn"], 0, ',', ' '); ?></td>
                            </tr>
                            <?php
                            $montantcecho = $montantcecho + $prodm["montantc"];
                            $montantpecho = $montantpecho + $prodm["montantp"];

                            $montanttotalc = $montanttotalc + $prodm["montantc"];
                            $montanttotalp = $montanttotalp + $prodm["montantp"];
                        }
                    }
                    $montantnecho = $montantcecho - $montantpecho;
                    ?>
                    <tr style="background-color: #eee">
                        <td colspan="2" style="width: 40%;text-align: center; border: solid 1px;">Total Echographie</td>
                        <td style="width: 20%;text-align: right; border: solid 1px;"><?php echo number_format($montantcecho, 0, ',', ' '); ?></td>
                        <td style="width: 20%;text-align: right; border: solid 1px;"><?php echo number_format($montantpecho, 0, ',', ' '); ?></td>
                        <td style="width: 20%;text-align: right; border: solid 1px;"><?php echo number_format($montantnecho, 0, ',', ' '); ?></td>
                    </tr>
                    <tr>
                        <td style="width: 15%;text-align: center; border: solid 1px;">&nbsp;</td>
                        <td style="width: 25%;text-align: left; border: solid 1px;"></td>
                        <td style="width: 20%;text-align: right; border: solid 1px;"></td>
                        <td style="width: 20%;text-align: right; border: solid 1px;"></td>
                        <td style="width: 20%;text-align: right; border: solid 1px;"></td>
                    </tr>
                    <?php
                }
                ?>
                <?php
                if ($iordo != 0) {
                    ?>
                    <tr>
                        <td style="width: 15%;text-align: center; border: solid 1px;">Ordonance</td>
                        <td style="width: 25%;text-align: left; border: solid 1px;"></td>
                        <td style="width: 20%;text-align: right; border: solid 1px;"></td>
                        <td style="width: 20%;text-align: right; border: solid 1px;"></td>
                        <td style="width: 20%;text-align: right; border: solid 1px;"></td>
                    </tr>
                    <?php
                    foreach ($tabordo as $prod) {
//                            print_r($prod);
                        foreach ($prod["lignefinance"] as $prodm) {
                            ?>
                            <tr >
                                <td style="width: 15%;text-align: center; border: solid 1px;"><?php print nl2br(htmlspecialchars($prod["datem"])) ?></td>
                                <td style="width: 25%;text-align: left; border: solid 1px;"><?php print nl2br(htmlspecialchars($prodm["libellem"])) ?></td>
                                <td style="width: 20%;text-align: right; border: solid 1px;"><?php print number_format($prodm["montantc"], 0, ',', ' '); ?></td>
                                <td style="width: 20%;text-align: right; border: solid 1px;"><?php print number_format($prodm["montantp"], 0, ',', ' '); ?></td>
                                <td style="width: 20%;text-align: right; border: solid 1px;"><?php print number_format($prodm["montantn"], 0, ',', ' '); ?></td>
                            </tr>
                            <?php
                            $montantcordo = $montantcordo + $prodm["montantc"];
                            $montantpordo = $montantpordo + $prodm["montantp"];

                            $montanttotalc = $montanttotalc + $prodm["montantc"];
                            $montanttotalp = $montanttotalp + $prodm["montantp"];
                        }
                    }
                    $montantnordo = $montantcordo - $montantpordo;
                    ?>
                    <tr style="background-color: #eee">
                        <td colspan="2" style="width: 40%;text-align: center; border: solid 1px;">Total Ordonance</td>
                        <td style="width: 20%;text-align: right; border: solid 1px;"><?php echo number_format($montantcordo, 0, ',', ' '); ?></td>
                        <td style="width: 20%;text-align: right; border: solid 1px;"><?php echo number_format($montantpordo, 0, ',', ' '); ?></td>
                        <td style="width: 20%;text-align: right; border: solid 1px;"><?php echo number_format($montantnordo, 0, ',', ' '); ?></td>
                    </tr>
                    <tr>
                        <td style="width: 15%;text-align: center; border: solid 1px;">&nbsp;</td>
                        <td style="width: 25%;text-align: left; border: solid 1px;"></td>
                        <td style="width: 20%;text-align: right; border: solid 1px;"></td>
                        <td style="width: 20%;text-align: right; border: solid 1px;"></td>
                        <td style="width: 20%;text-align: right; border: solid 1px;"></td>
                    </tr>
                    <?php
                }
                ?>
                <?php
                if ($ihos != 0) {
                    ?>
                    <tr>
                        <td style="width: 15%;text-align: center; border: solid 1px;">Hospitalisation</td>
                        <td style="width: 22%;text-align: left; border: solid 1px;"></td>
                        <td style="width: 20%;text-align: right; border: solid 1px;"></td>
                        <td style="width: 20%;text-align: right; border: solid 1px;"></td>
                        <td style="width: 20%;text-align: right; border: solid 1px;"></td>
                    </tr>
                    <?php
                    foreach ($tabhos as $prod) {
//                            print_r($prod);
                        foreach ($prod["lignefinance"] as $prodm) {
                            ?>
                            <tr >
                                <td style="width: 15%;text-align: center; border: solid 1px;"><?php print nl2br(htmlspecialchars($prod["datem"])) ?></td>
                                <td style="width: 25%;text-align: left; border: solid 1px;"><?php print nl2br(htmlspecialchars($prodm["libellem"])) ?></td>
                                <td style="width: 20%;text-align: right; border: solid 1px;"><?php print number_format($prodm["montantc"], 0, ',', ' '); ?></td>
                                <td style="width: 20%;text-align: right; border: solid 1px;"><?php print number_format($prodm["montantp"], 0, ',', ' '); ?></td>
                                <td style="width: 20%;text-align: right; border: solid 1px;"><?php print number_format($prodm["montantn"], 0, ',', ' '); ?></td>
                            </tr>
                            <?php
                            $montantchos = $montantchos + $prodm["montantc"];
                            $montantphos = $montantphos + $prodm["montantp"];

                            $montanttotalc = $montanttotalc + $prodm["montantc"];
                            $montanttotalp = $montanttotalp + $prodm["montantp"];
                        }
                    }
                    $montantnhos = $montantchos - $montantphos;
                    ?>
                    <tr style="background-color: #eee">
                        <td colspan="2" style="width: 40%;text-align: center; border: solid 1px;">Total Hospitalisation</td>
                        <td style="width: 20%;text-align: right; border: solid 1px;"><?php echo number_format($montantchos, 0, ',', ' '); ?></td>
                        <td style="width: 20%;text-align: right; border: solid 1px;"><?php echo number_format($montantphos, 0, ',', ' '); ?></td>
                        <td style="width: 20%;text-align: right; border: solid 1px;"><?php echo number_format($montantnhos, 0, ',', ' '); ?></td>
                    </tr>
                    <tr>
                        <td style="width: 15%;text-align: center; border: solid 1px;">&nbsp;</td>
                        <td style="width: 25%;text-align: left; border: solid 1px;"></td>
                        <td style="width: 20%;text-align: right; border: solid 1px;"></td>
                        <td style="width: 20%;text-align: right; border: solid 1px;"></td>
                        <td style="width: 20%;text-align: right; border: solid 1px;"></td>
                    </tr>
                    <?php
                }
                ?>

                <tr>
                    <td style="width: 15%;text-align: right; border: solid 1px;">&nbsp;</td>
                    <td style="width: 25%;text-align: right; border: solid 1px;"></td>
                    <td style="width: 20%;text-align: right; border: solid 1px;"></td>
                    <td style="width: 20%;text-align: right; border: solid 1px;"></td>
                    <td style="width: 20%;text-align: right; border: solid 1px;"></td>
                </tr>
                <?php
                $montanttotaln = $montanttotalc - $montanttotalp;
                ?>
                <tr style="background-color: #eee">
                    <td colspan="2" style="width: 40%;text-align: center; border: solid 1px;">Total Finance</td>
                    <td style="width: 20%;text-align: right; border: solid 1px;"><?php echo number_format($montanttotalc, 0, ',', ' '); ?></td>
                    <td style="width: 20%;text-align: right; border: solid 1px;"><?php echo number_format($montanttotalp, 0, ',', ' '); ?></td>
                    <td style="width: 20%;text-align: right; border: solid 1px;"><?php echo number_format($montanttotaln, 0, ',', ' '); ?></td>
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

