<?php

if ((isset($_REQUEST["idobstetricale"]))) {
    $idmc = $_REQUEST["idobstetricale"];
    $reqr = $con->query("select * from hp_obstetricale as n left join hp_resultat_echographie as r on n.idresultatechographie=r.idresultatechographie "
            . "where n.idobstetricale='" . $idmc . "' "
            . "") or die(mysqli_error($con));
    $rownfe = mysqli_fetch_array($reqr);
    $req_fin = $con->query("select * from hp_echographie_patient as ep left join hp_sous_dossier as sd on "
            . "ep.idsousdossier=sd.idsousdossier left join hp_dossier as d on sd.iddossier=d.iddossier "
            . "left join hp_patient as p on d.idpatient=p.idpatient left join hp_departement as dp on "
            . "p.residencepatient=dp.iddepartement where ep.idechographiepatient='" . $rownfe["idechographiepatient"] . "'") or die(mysqli_error($con));
    $row = mysqli_fetch_assoc($req_fin);
    $req_fine = $con->query("select * from hp_echographie as e left join hp_acte as l on e.idacte=l.idacte "
            . "left join hp_service as s on e.idservice=s.idservice "
            . "where e.idechographie='" . $row["idechographie"] . "'") or die(mysqli_error($con));
    $rowe = mysqli_fetch_assoc($req_fine);

// Récupération du numéro de l'étape en cours
    if (empty($_GET['pagecom']) or ! is_numeric($_GET['pagecom'])) {
        define('NUM_PAGE', 1);
    } else {
        // En situation réelle, il faudrait vérifier l'existence de cette page
        define('NUM_PAGE', intval($_GET['pagecom']));
    }

// Déclaration de la variable de session
    if (empty($_SESSION['formechographieobstetricalee'])) {
        $_SESSION['formechographieobstetricalee'] = array();
    }

    if (empty($_SESSION['formechographieobstetricalee'])) {
        $_SESSION['formechographieobstetricalee'] = array();
        $_SESSION['formechographieobstetricalee'][1] = array(
            'idobstetricale' => $_REQUEST["idobstetricale"],
            'idechographiepatient' => $rownfe["idechographiepatient"],
            'idacte' => $rowe["idacte"],
            'prescripteur' => $row["prescripteurechographiepatient"],
            'indication' => $row["indicationechographiepatient"],
            'datejour' => $rownfe["datejourobstetricale"],
            'heurejour' => $rownfe["heureobstetricale"],
            'ddr' => $rownfe["datedernierregleobstetricale"],
            'dpa' => $rownfe["dpaobstetricale"],
            'localisation' => $rownfe["localisationobstetricale"],
            'nbfoetus' => $rownfe["nombrefoetusobstetricale"],
            'mouvement' => $rownfe["mouvementactifobstetricale"],
            'ac' => $rownfe["activitecardiaqueobstetricale"],
            'frequencecardiaque' => $rownfe["frequencecardiaqueobstetricale"],
            'bip' => $rownfe["bipobstetricale"],
            'pc' => $rownfe["pcobstetricale"],
            'pa' => $rownfe["paobstetricale"],
            'longueurfemorale' => $rownfe["longueurfemoraleobstetricale"],
            'semaine' => $rownfe["semaineobstetricale"],
            'jour' => $rownfe["jourobstetricale"],
            'poids' => $rownfe["poidsfoetalobstetricale"],
            'rcf' => $rownfe["rcfobstetricale"],
            'morphologie' => $rownfe["morphologieobstetricale"],
            'liqam' => $rownfe["liquideamniostiqueobstetricale"],
            'qte' => $rownfe["quantiteliquideobstetricale"],
            'placentai' => $rownfe["placentainsertionobstetricale"],
            'placentae' => $rownfe["placentaechostructureobstetricale"],
            'presentation' => $rownfe["presentationobstetricale"],
            'col1' => $rownfe["colobstetricale"],
            'col2' => $rownfe["collongueurobstetricale"],
            'sexe' => $rownfe["sexeobstetricale"],
            'conclusion' => trim(stripcslashes($rownfe["conclusionobstetricale"]))
        );
    }

    switch (NUM_PAGE) {
        case 2:
            // Récupération des informations du formulaire précédent
            if (!empty($_POST)) {
                $erreur = FALSE;
                $_SESSION['formechographieobstetricalee'][NUM_PAGE - 1] = array(
                    'idobstetricale' => $_REQUEST["idobstetricale"],
                    'idechographiepatient' => $rownfe["idechographiepatient"],
                    'idacte' => $rowe["idacte"],
                    'prescripteur' => trim(htmlspecialchars($_POST["prescripteur"])),
                    'indication' => trim(htmlspecialchars($_POST["indication"])),
                    'datejour' => trim(htmlspecialchars($_POST["datejour"])),
                    'heurejour' => trim(htmlspecialchars($_POST["heurejour"])),
                    'ddr' => trim(htmlspecialchars($_POST["ddr"])),
                    'dpa' => trim(htmlspecialchars($_POST["dpa"])),
                    'localisation' => trim(htmlspecialchars($_POST["localisation"])),
                    'nbfoetus' => floatval(trim(htmlspecialchars($_POST["nbfoetus"]))),
                    'bip' => floatval(trim(htmlspecialchars($_POST["bip"]))),
                    'pc' => floatval(trim(htmlspecialchars($_POST["pc"]))),
                    'pa' => floatval(trim(htmlspecialchars($_POST["pa"]))),
                    'ac' => (trim(htmlspecialchars($_POST["ac"]))),
                    'mouvement' => (trim(htmlspecialchars($_POST["mouvement"]))),
                    'semaine' => floatval(trim(htmlspecialchars($_POST["semaine"]))),
                    'jour' => floatval(trim(htmlspecialchars($_POST["jour"]))),
                    'poids' => floatval(trim(htmlspecialchars($_POST["poids"]))),
                    'frequencecardiaque' => (trim(htmlspecialchars($_POST["frequencecardiaque"]))),
                    'longueurfemorale' => floatval(trim(htmlspecialchars($_POST["longueurfemorale"]))),
                    'rcf' => floatval(trim(htmlspecialchars($_POST["rcf"]))),
                    'morphologie' => (trim(htmlspecialchars($_POST["morphologie"]))),
                    'liqam' => (trim(htmlspecialchars($_POST["liqam"]))),
                    'qte' => (trim(htmlspecialchars($_POST["qte"]))),
                    'placentai' => (trim(htmlspecialchars($_POST["placentai"]))),
                    'placentae' => (trim(htmlspecialchars($_POST["placentae"]))),
                    'presentation' => (trim(htmlspecialchars($_POST["presentation"]))),
                    'col1' => (trim(htmlspecialchars($_POST["col1"]))),
                    'col2' => floatval(trim(htmlspecialchars($_POST["col2"]))),
                    'sexe' => (trim(htmlspecialchars($_POST["sexe"]))),
                    'conclusion' => (trim(stripcslashes($_POST["conclusion"])))
                );
            }
            if ((isset($erreur)) && ($erreur)) {
                $pag = 'hopitalpages/hopitalpatient/hopitalechographie/hopitalobstetricale/hopitalediter/edit_echographie';
                $stag = 1;
                die('<meta http-equiv="refresh" content="3; URL=' . $url . '?page=' . base64_encode($pag) . '&idechographiepatient=' . $idmc . '">');
            } else {
                require('hopitalpages/hopitalpatient/hopitalechographie/hopitalobstetricale/hopitalediter/form_terminer.php');
                break;
            }

        case 1:
        default:
            // Valeurs par défaut
            if (empty($_SESSION['formechographieobstetricalee'][NUM_PAGE])) {

                $_SESSION['formechographieobstetricalee'][NUM_PAGE] = array(
                    'idobstetricale' => $_REQUEST["idobstetricale"],
                    'idechographiepatient' => $rownfe["idechographiepatient"],
                    'idacte' => $rowe["idacte"],
                    'prescripteur' => $row["prescripteurechographiepatient"],
                    'indication' => $row["indicationechographiepatient"],
                    'datejour' => $rownfe["datejourobstetricale"],
                    'heurejour' => $rownfe["heureobstetricale"],
                    'ddr' => $rownfe["datedernierregleobstetricale"],
                    'dpa' => $rownfe["dpaobstetricale"],
                    'localisation' => $rownfe["localisationobstetricale"],
                    'nbfoetus' => $rownfe["nombrefoetusobstetricale"],
                    'bip' => $rownfe["bipobstetricale"],
                    'pc' => $rownfe["pcobstetricale"],
                    'pa' => $rownfe["paobstetricale"],
                    'ac' => $rownfe["activitecardiaqueobstetricale"],
                    'mouvement' => $rownfe["mouvementactifobstetricale"],
                    'semaine' => $rownfe["semaineobstetricale"],
                    'jour' => $rownfe["jourobstetricale"],
                    'poids' => $rownfe["poidsfoetalobstetricale"],
                    'frequencecardiaque' => $rownfe["frequencecardiaqueobstetricale"],
                    'longueurfemorale' => $rownfe["longueurfemoraleobstetricale"],
                    'rcf' => $rownfe["rcfobstetricale"],
                    'morphologie' => $rownfe["morphologieobstetricale"],
                    'liqam' => $rownfe["liquideamniostiqueobstetricale"],
                    'qte' => $rownfe["quantiteliquideobstetricale"],
                    'placentai' => $rownfe["placentainsertionobstetricale"],
                    'placentae' => $rownfe["placentaechostructureobstetricale"],
                    'presentation' => $rownfe["presentationobstetricale"],
                    'col1' => $rownfe["colobstetricale"],
                    'col2' => $rownfe["collongueurobstetricale"],
                    'sexe' => $rownfe["sexeobstetricale"],
                    'conclusion' => trim(stripcslashes($rownfe["conclusionobstetricale"]))
                );
            } else if (($_SESSION['formechographieobstetricalee'][NUM_PAGE]["idobstetricale"]) != $_REQUEST["idobstetricale"]) {

                $_SESSION['formechographieobstetricalee'][NUM_PAGE] = array(
                    'idobstetricale' => $_REQUEST["idobstetricale"],
                    'idechographiepatient' => $rownfe["idechographiepatient"],
                    'idacte' => $rowe["idacte"],
                    'prescripteur' => $row["prescripteurechographiepatient"],
                    'indication' => $row["indicationechographiepatient"],
                    'datejour' => $rownfe["datejourobstetricale"],
                    'heurejour' => $rownfe["heureobstetricale"],
                    'ddr' => $rownfe["datedernierregleobstetricale"],
                    'dpa' => $rownfe["dpaobstetricale"],
                    'localisation' => $rownfe["localisationobstetricale"],
                    'nbfoetus' => $rownfe["nombrefoetusobstetricale"],
                    'bip' => $rownfe["bipobstetricale"],
                    'pc' => $rownfe["pcobstetricale"],
                    'pa' => $rownfe["paobstetricale"],
                    'ac' => $rownfe["activitecardiaqueobstetricale"],
                    'mouvement' => $rownfe["mouvementactifobstetricale"],
                    'semaine' => $rownfe["semaineobstetricale"],
                    'jour' => $rownfe["jourobstetricale"],
                    'poids' => $rownfe["poidsfoetalobstetricale"],
                    'frequencecardiaque' => $rownfe["frequencecardiaqueobstetricale"],
                    'longueurfemorale' => $rownfe["longueurfemoraleobstetricale"],
                    'rcf' => $rownfe["rcfobstetricale"],
                    'morphologie' => $rownfe["morphologieobstetricale"],
                    'liqam' => $rownfe["liquideamniostiqueobstetricale"],
                    'qte' => $rownfe["quantiteliquideobstetricale"],
                    'placentai' => $rownfe["placentainsertionobstetricale"],
                    'placentae' => $rownfe["placentaechostructureobstetricale"],
                    'presentation' => $rownfe["presentationobstetricale"],
                    'col1' => $rownfe["colobstetricale"],
                    'col2' => $rownfe["collongueurobstetricale"],
                    'sexe' => $rownfe["sexeobstetricale"],
                    'conclusion' => trim(stripcslashes($rownfe["conclusionobstetricale"]))
                );
            }
            require('hopitalpages/hopitalpatient/hopitalechographie/hopitalobstetricale/hopitalediter/form_editer_echographie.php');
            break;
    }
}