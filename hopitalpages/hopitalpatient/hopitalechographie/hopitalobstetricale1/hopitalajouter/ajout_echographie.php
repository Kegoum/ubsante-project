<?php

if ((isset($_REQUEST["idechographiepatient"]))) {
    $idmc = $_REQUEST["idechographiepatient"];

    $req_fin = $con->query("select * from hp_echographie_patient as ep left join hp_sous_dossier as sd on "
            . "ep.idsousdossier=sd.idsousdossier left join hp_dossier as d on sd.iddossier=d.iddossier "
            . "left join hp_patient as p on d.idpatient=p.idpatient left join hp_departement as dp on "
            . "p.residencepatient=dp.iddepartement where ep.idechographiepatient='" . $idmc . "'") or die(mysqli_error($con));
    $row = mysqli_fetch_assoc($req_fin);
    $req_fine = $con->query("select * from hp_echographie as e left join hp_acte as l on e.idacte=l.idacte "
            . "left join hp_service as s on e.idservice=s.idservice "
            . "where e.idechographie='" . $row["idechographie"] . "'") or die(mysqli_error($con));
    $rowe = mysqli_fetch_assoc($req_fine);
?>
    <?php

// Récupération du numéro de l'étape en cours
    if (empty($_GET['pagecom']) or ! is_numeric($_GET['pagecom'])) {
        define('NUM_PAGE', 1);
    } else {
        // En situation réelle, il faudrait vérifier l'existence de cette page
        define('NUM_PAGE', intval($_GET['pagecom']));
    }

// Déclaration de la variable de session
    if (empty($_SESSION['formechographieobstetricale1'])) {
        $_SESSION['formechographieobstetricale1'] = array();
    }

    if (empty($_SESSION['formechographieobstetricale1'])) {
        $_SESSION['formechographieobstetricale1'] = array();
        $_SESSION['formechographieobstetricale1'][1] = array(
            'idechographiepatient' => $_REQUEST["idechographiepatient"],
            'idacte' => $rowe["idacte"],
            'prescripteur' => '',
            'indication' => '',
            'datejour' => '',
            'heurejour' => '',
            'ddr' => '',
            'dpa' => '',
            'semaine' => '',
            'jour' => '',
            'gravide' => '',
            'localisation' => '',
            'nbfoetus' => '',
            'vitalite' => '',
            'mouvement' => '',
            'ac' => '',
            'frequencecardiaque' => '',
            'longueursac' => '',
            'longueurcranio' => '',
            'trophoblaste' => '',
            'poids' => '',
            'col1' => '',
            'col2' => '',
            'ovaired' => '',
            'ovaireg' => '',
            'epanchement' => '',
            'vessie' => '',
            'conclusion' => ''
        );
    }

    switch (NUM_PAGE) {
        case 2:
            // Récupération des informations du formulaire précédent
            if (!empty($_POST)) {
                $erreur = FALSE;
                $_SESSION['formechographieobstetricale1'][NUM_PAGE - 1] = array(
                    'idacte' => $rowe["idacte"],
                    'idechographiepatient' => $_REQUEST["idechographiepatient"],
                    'prescripteur' => trim(htmlspecialchars($_POST["prescripteur"])),
                    'indication' => trim(htmlspecialchars($_POST["indication"])),
                    'datejour' => trim(htmlspecialchars($_POST["datejour"])),
                    'heurejour' => trim(htmlspecialchars($_POST["heurejour"])),
                    'ddr' => trim(htmlspecialchars($_POST["ddr"])),
                    'dpa' => trim(htmlspecialchars($_POST["dpa"])),
                    'semaine' => floatval(trim(htmlspecialchars($_POST["semaine"]))),
                    'jour' => floatval(trim(htmlspecialchars($_POST["jour"]))),
                    'gravide' => (trim(htmlspecialchars($_POST["gravide"]))),
                    'localisation' => trim(htmlspecialchars($_POST["localisation"])),
                    'nbfoetus' => floatval(trim(htmlspecialchars($_POST["nbfoetus"]))),
                    'vitalite' => (trim(htmlspecialchars($_POST["vitalite"]))),
                    'mouvement' => (trim(htmlspecialchars($_POST["mouvement"]))),
                    'ac' => (trim(htmlspecialchars($_POST["ac"]))),
                    'frequencecardiaque' => floatval(trim(htmlspecialchars($_POST["frequencecardiaque"]))),
                    'longueursac' => floatval(trim(htmlspecialchars($_POST["longueursac"]))),
                    'longueurcranio' => floatval(trim(htmlspecialchars($_POST["longueurcranio"]))),
                    'trophoblaste' => (trim(htmlspecialchars($_POST["trophoblaste"]))),
                    'poids' => floatval(trim(htmlspecialchars($_POST["poids"]))),
                    'col1' => (trim(htmlspecialchars($_POST["col1"]))),
                    'col2' => (trim(htmlspecialchars($_POST["col2"]))),
                    'ovaired' => (trim(htmlspecialchars($_POST["ovaired"]))),
                    'ovaireg' => (trim(htmlspecialchars($_POST["ovaireg"]))),
                    'epanchement' => (trim(htmlspecialchars($_POST["epanchement"]))),
                    'vessie' => (trim(htmlspecialchars($_POST["vessie"]))),
                    'conclusion' => trim(stripcslashes($_POST["conclusion"]))
                );
            }
            if ((isset($erreur)) && ($erreur)) {
                $pag = 'hopitalpages/hopitalpatient/hopitalechographie/hopitalobstetricale1/hopitalajouter/ajout_echographie';
                $stag = 1;
                die('<meta http-equiv="refresh" content="3; URL=' . $url . '?page=' . base64_encode($pag) . '&idechographiepatient=' . $idmc . '">');
            } else {
                require('hopitalpages/hopitalpatient/hopitalechographie/hopitalobstetricale1/hopitalajouter/form_terminer.php');
                break;
            }

        case 1:
        default:
            // Valeurs par défaut
            if (empty($_SESSION['formechographieobstetricale1'][NUM_PAGE])) {

                $_SESSION['formechographieobstetricale1'][NUM_PAGE] = array(
                    'idechographiepatient' => $_REQUEST["idechographiepatient"],
                    'idacte' => $rowe["idacte"],
            'prescripteur' => '',
            'indication' => '',
            'datejour' => '',
            'heurejour' => '',
            'ddr' => '',
            'dpa' => '',
            'semaine' => '',
            'jour' => '',
            'gravide' => '',
            'localisation' => '',
            'nbfoetus' => '',
            'vitalite' => '',
            'mouvement' => '',
            'ac' => '',
            'frequencecardiaque' => '',
            'longueursac' => '',
            'longueurcranio' => '',
            'trophoblaste' => '',
            'poids' => '',
            'col1' => '',
            'col2' => '',
            'ovaired' => '',
            'ovaireg' => '',
            'epanchement' => '',
            'vessie' => '',
            'conclusion' => ''
                );
            } else if (($_SESSION['formechographieobstetricale1'][NUM_PAGE]["idechographiepatient"]) != $_REQUEST["idechographiepatient"]) {

                $_SESSION['formechographieobstetricale1'][NUM_PAGE] = array(
                    'idechographiepatient' => $_REQUEST["idechographiepatient"],
                    'idacte' => $rowe["idacte"],
            'prescripteur' => '',
            'indication' => '',
            'datejour' => '',
            'heurejour' => '',
            'ddr' => '',
            'dpa' => '',
            'semaine' => '',
            'jour' => '',
            'gravide' => '',
            'localisation' => '',
            'nbfoetus' => '',
            'vitalite' => '',
            'mouvement' => '',
            'ac' => '',
            'frequencecardiaque' => '',
            'longueursac' => '',
            'longueurcranio' => '',
            'trophoblaste' => '',
            'poids' => '',
            'col1' => '',
            'col2' => '',
            'ovaired' => '',
            'ovaireg' => '',
            'epanchement' => '',
            'vessie' => '',
            'conclusion' => ''
                );
            }
            require('hopitalpages/hopitalpatient/hopitalechographie/hopitalobstetricale1/hopitalajouter/form_ajouter_echographie.php');
            break;
    }
}