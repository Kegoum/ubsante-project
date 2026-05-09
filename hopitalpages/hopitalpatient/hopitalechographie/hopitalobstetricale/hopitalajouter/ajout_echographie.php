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
    if (empty($_SESSION['formechographieobstetricale'])) {
        $_SESSION['formechographieobstetricale'] = array();
    }

    if (empty($_SESSION['formechographieobstetricale'])) {
        $_SESSION['formechographieobstetricale'] = array();
        $_SESSION['formechographieobstetricale'][1] = array(
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
            'localisation' => '',
            'nbfoetus' => '',
            'mouvement' => '',
            'ac' => '',
            'frequencecardiaque' => '',
            'bip' => '',
            'pc' => '',
            'pa' => '',
            'longueurfemorale' => '',
            'poids' => '',
            'rcf' => '',
            'morphologie' => '',
                    'presentation' => '',
                    'placentai' => '',
                    'placentae' => '',
            'liqam' => '',
            'qte' => '',
            'col1' => '',
            'col2' => '',
            'sexe' => '',
                    'conclusion' => ''
        );
    }

    switch (NUM_PAGE) {
        case 2:
            // Récupération des informations du formulaire précédent
            if (!empty($_POST)) {
                $erreur = FALSE;
                $_SESSION['formechographieobstetricale'][NUM_PAGE - 1] = array(
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
                    'localisation' => trim(htmlspecialchars($_POST["localisation"])),
                    'nbfoetus' => floatval(trim(htmlspecialchars($_POST["nbfoetus"]))),
                    'mouvement' => (trim(htmlspecialchars($_POST["mouvement"]))),
                    'ac' => (trim(htmlspecialchars($_POST["ac"]))),
                    'frequencecardiaque' => floatval(trim(htmlspecialchars($_POST["frequencecardiaque"]))),
                    'bip' => floatval(trim(htmlspecialchars($_POST["bip"]))),
                    'pc' => floatval(trim(htmlspecialchars($_POST["pc"]))),
                    'pa' => floatval(trim(htmlspecialchars($_POST["pa"]))),
                    'longueurfemorale' => floatval(trim(htmlspecialchars($_POST["longueurfemorale"]))),
                    'poids' => floatval(trim(htmlspecialchars($_POST["poids"]))),
                    'rcf' => floatval(trim(htmlspecialchars($_POST["rcf"]))),
                    'morphologie' => (trim(htmlspecialchars($_POST["morphologie"]))),
                    'presentation' => (trim(htmlspecialchars($_POST["presentation"]))),
                    'placentai' => (trim(htmlspecialchars($_POST["placentai"]))),
                    'placentae' => (trim(htmlspecialchars($_POST["placentae"]))),
                    'liqam' => (trim(htmlspecialchars($_POST["liqam"]))),
                    'qte' => (trim(htmlspecialchars($_POST["qte"]))),
                    'col1' => (trim(htmlspecialchars($_POST["col1"]))),
                    'col2' => floatval(trim(htmlspecialchars($_POST["col2"]))),
                    'sexe' => (trim(htmlspecialchars($_POST["sexe"]))),
                    'conclusion' => trim(stripcslashes($_POST["conclusion"]))
                );
            }
            if ((isset($erreur)) && ($erreur)) {
                $pag = 'hopitalpages/hopitalpatient/hopitalechographie/hopitalobstetricale/hopitalajouter/ajout_echographie';
                $stag = 1;
                die('<meta http-equiv="refresh" content="3; URL=' . $url . '?page=' . base64_encode($pag) . '&idechographiepatient=' . $idmc . '">');
            } else {
                require('hopitalpages/hopitalpatient/hopitalechographie/hopitalobstetricale/hopitalajouter/form_terminer.php');
                break;
            }

        case 1:
        default:
            // Valeurs par défaut
            if (empty($_SESSION['formechographieobstetricale'][NUM_PAGE])) {

                $_SESSION['formechographieobstetricale'][NUM_PAGE] = array(
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
                    'localisation' => '',
                    'nbfoetus' => '',
                    'mouvement' => '',
                    'ac' => '',
                    'frequencecardiaque' => '',
                    'bip' => '',
                    'pc' => '',
                    'pa' => '',
                    'longueurfemorale' => '',
                    'poids' => '',
                    'rcf' => '',
                    'morphologie' => '',
                    'presentation' => '',
                    'placentai' => '',
                    'placentae' => '',
                    'liqam' => '',
                    'qte' => '',
            'col1' => '',
                    'col2' => '',
                    'sexe' => '',
                    'conclusion' => ''
                );
            } else if (($_SESSION['formechographieobstetricale'][NUM_PAGE]["idechographiepatient"]) != $_REQUEST["idechographiepatient"]) {

                $_SESSION['formechographieobstetricale'][NUM_PAGE] = array(
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
                    'localisation' => '',
                    'nbfoetus' => '',
                    'mouvement' => '',
                    'ac' => '',
                    'frequencecardiaque' => '',
                    'bip' => '',
                    'pc' => '',
                    'pa' => '',
                    'longueurfemorale' => '',
                    'poids' => '',
                    'rcf' => '',
                    'morphologie' => '',
                    'presentation' => '',
                    'placentai' => '',
                    'placentae' => '',
                    'liqam' => '',
                    'qte' => '',
            'col1' => '',
                    'col2' => '',
                    'sexe' => '',
                    'conclusion' => ''
                );
            }
            require('hopitalpages/hopitalpatient/hopitalechographie/hopitalobstetricale/hopitalajouter/form_ajouter_echographie.php');
            break;
    }
}