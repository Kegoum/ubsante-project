<?php

if ((isset($_REQUEST["idabdominopelvienne"]))) {
    $idmc = $_REQUEST["idabdominopelvienne"];

    $reqr = $con->query("select * from hp_abdomino_pelvienne as n left join hp_resultat_echographie as r on n.idresultatechographie=r.idresultatechographie "
            . "where n.idabdominopelvienne='" . $idmc . "' ") or die(mysqli_error($con));
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
    if (empty($_SESSION['formechographieabdominopelviennee'])) {
        $_SESSION['formechographieabdominopelviennee'] = array();
    }

    if (empty($_SESSION['formechographieabdominopelviennee'])) {
        $_SESSION['formechographieabdominopelviennee'] = array();
        $_SESSION['formechographieabdominopelviennee'][1] = array(
            'idabdominopelvienne' => $_REQUEST["idabdominopelvienne"],
            'idechographiepatient' => $rownfe["idechographiepatient"],
            'idacte' => $rowe["idacte"],
            'prescripteur' => $row["prescripteurechographiepatient"],
            'indication' => $row["indicationechographiepatient"],
            'datejour' => $rownfe["datejourabdominopelvienne"],
            'abdominale' => trim(stripcslashes($rownfe["abdominaleabdominopelvienne"])),
            'pelvienne' => trim(stripcslashes($rownfe["pelvienneabdominopelvienne"])),
            'conclusion' => trim(stripcslashes($rownfe["conclusionabdominopelvienne"]))
        );
    }

    switch (NUM_PAGE) {
        case 2:
            // Récupération des informations du formulaire précédent
            if (!empty($_POST)) {
                $erreur = FALSE;
                $_SESSION['formechographieabdominopelviennee'][NUM_PAGE - 1] = array(
                    'idabdominopelvienne' => $_REQUEST["idabdominopelvienne"],
                    'idechographiepatient' => $rownfe["idechographiepatient"],
                    'idacte' => $rowe["idacte"],
                    'prescripteur' => trim(htmlspecialchars($_POST["prescripteur"])),
                    'indication' => trim(htmlspecialchars($_POST["indication"])),
                    'datejour' => trim(htmlspecialchars($_POST["datejour"])),
                    'abdominale' => trim(stripcslashes($_POST["abdominale"])),
                    'pelvienne' => (trim(stripcslashes($_POST["pelvienne"]))),
                    'conclusion' => (trim(stripcslashes($_POST["conclusion"])))
                );
            }
            if ((isset($erreur)) && ($erreur)) {
                $pag = 'hopitalpages/hopitalpatient/hopitalechographie/hopitalabdominopelvienne/hopitalediter/edit_echographie';
                $stag = 1;
                die('<meta http-equiv="refresh" content="3; URL=' . $url . '?page=' . base64_encode($pag) . '&idechographiepatient=' . $idmc . '">');
            } else {
                require('hopitalpages/hopitalpatient/hopitalechographie/hopitalabdominopelvienne/hopitalediter/form_terminer.php');
                break;
            }

        case 1:
        default:
            // Valeurs par défaut
            if (empty($_SESSION['formechographieabdominopelviennee'][NUM_PAGE])) {

                $_SESSION['formechographieabdominopelviennee'][NUM_PAGE] = array(
                    'idabdominopelvienne' => $_REQUEST["idabdominopelvienne"],
                    'idechographiepatient' => $rownfe["idechographiepatient"],
                    'idacte' => $rowe["idacte"],
                    'prescripteur' => $row["prescripteurechographiepatient"],
                    'indication' => $row["indicationechographiepatient"],
                    'datejour' => $rownfe["datejourabdominopelvienne"],
                    'abdominale' => trim(stripcslashes($rownfe["abdominaleabdominopelvienne"])),
                    'pelvienne' => trim(stripcslashes($rownfe["pelvienneabdominopelvienne"])),
                    'conclusion' => trim(stripcslashes($rownfe["conclusionabdominopelvienne"]))
                );
            } else if (($_SESSION['formechographieabdominopelviennee'][NUM_PAGE]["idabdominopelvienne"]) != $_REQUEST["idabdominopelvienne"]) {

                $_SESSION['formechographieabdominopelviennee'][NUM_PAGE] = array(
                    'idabdominopelvienne' => $_REQUEST["idabdominopelvienne"],
                    'idechographiepatient' => $rownfe["idechographiepatient"],
                    'idacte' => $rowe["idacte"],
                    'prescripteur' => $row["prescripteurechographiepatient"],
                    'indication' => $row["indicationechographiepatient"],
                    'datejour' => $rownfe["datejourabdominopelvienne"],
                    'abdominale' => trim(stripcslashes($rownfe["abdominaleabdominopelvienne"])),
                    'pelvienne' => trim(stripcslashes($rownfe["pelvienneabdominopelvienne"])),
                    'conclusion' => trim(stripcslashes($rownfe["conclusionabdominopelvienne"]))
                );
            }
            require('hopitalpages/hopitalpatient/hopitalechographie/hopitalabdominopelvienne/hopitalediter/form_editer_echographie.php');
            break;
    }
}