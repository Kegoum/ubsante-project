<?php

if ((isset($_REQUEST["idpelvienne"]))) {
    $idmc = $_REQUEST["idpelvienne"];

    $reqr = $con->query("select * from hp_pelvienne as n left join hp_resultat_echographie as r on n.idresultatechographie=r.idresultatechographie "
            . "where n.idpelvienne='" . $idmc . "' ") or die(mysqli_error($con));
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
    if (empty($_SESSION['formechographiepelviennee'])) {
        $_SESSION['formechographiepelviennee'] = array();
    }

    if (empty($_SESSION['formechographiepelviennee'])) {
        $_SESSION['formechographiepelviennee'] = array();
        $_SESSION['formechographiepelviennee'][1] = array(
            'idpelvienne' => $_REQUEST["idpelvienne"],
            'idechographiepatient' => $rownfe["idechographiepatient"],
            'idacte' => $rowe["idacte"],
            'prescripteur' => $row["prescripteurechographiepatient"],
            'indication' => $row["indicationechographiepatient"],
            'datejour' => $rownfe["datejourpelvienne"],
            'ugravide' => $rownfe["uterusgravidepelvienne"],
            'utaille' => $rownfe["uterustaillepelvienne"],
            'ucontour' => $rownfe["uteruscontourpelvienne"],
            'umyometre' => $rownfe["uterusmyometrepelvienne"],
            'uendometre' => $rownfe["uterusendometrepelvienne"],
            'ulumiere' => $rownfe["uteruslumierecervicopelvienne"],
            'ucol' => $rownfe["uteruscolpelvienne"],
            'ovaired' => $rownfe["ovairedroitpelvienne"],
            'ovaireg' => $rownfe["ovairegauchepelvienne"],
            'anomalie' => $rownfe["anomaliepelvienne"],
            'epanchement' => $rownfe["epanchementpelvienne"],
            'vessie' => $rownfe["vessiepelvienne"],
            'conclusion' => trim(stripcslashes($rownfe["conclusionpelvienne"]))
        );
    }

    switch (NUM_PAGE) {
        case 2:
            // Récupération des informations du formulaire précédent
            if (!empty($_POST)) {
                $erreur = FALSE;
                $_SESSION['formechographiepelviennee'][NUM_PAGE - 1] = array(
                    'idpelvienne' => $_REQUEST["idpelvienne"],
                    'idechographiepatient' => $rownfe["idechographiepatient"],
                    'idacte' => $rowe["idacte"],
                    'prescripteur' => trim(htmlspecialchars($_POST["prescripteur"])),
                    'indication' => trim(htmlspecialchars($_POST["indication"])),
                    'datejour' => trim(htmlspecialchars($_POST["datejour"])),
                    'ugravide' => trim(htmlspecialchars($_POST["ugravide"])),
                    'utaille' => (trim(htmlspecialchars($_POST["utaille"]))),
                    'ucontour' => (trim(htmlspecialchars($_POST["ucontour"]))),
                    'umyometre' => (trim(htmlspecialchars($_POST["umyometre"]))),
                    'uendometre' => (trim(htmlspecialchars($_POST["uendometre"]))),
                    'ulumiere' => (trim(htmlspecialchars($_POST["ulumiere"]))),
                    'ucol' => (trim(htmlspecialchars($_POST["ucol"]))),
                    'ovaired' => (trim(htmlspecialchars($_POST["ovaired"]))),
                    'ovaireg' => (trim(htmlspecialchars($_POST["ovaireg"]))),
                    'anomalie' => (trim(htmlspecialchars($_POST["anomalie"]))),
                    'epanchement' => (trim(htmlspecialchars($_POST["epanchement"]))),
                    'vessie' => (trim(htmlspecialchars($_POST["vessie"]))),
                    'conclusion' => (trim(stripcslashes($_POST["conclusion"])))
                );
            }
            if ((isset($erreur)) && ($erreur)) {
                $pag = 'hopitalpages/hopitalpatient/hopitalechographie/hopitalpelvienne/hopitalediter/edit_echographie';
                $stag = 1;
                die('<meta http-equiv="refresh" content="3; URL=' . $url . '?page=' . base64_encode($pag) . '&idechographiepatient=' . $idmc . '">');
            } else {
                require('hopitalpages/hopitalpatient/hopitalechographie/hopitalpelvienne/hopitalediter/form_terminer.php');
                break;
            }

        case 1:
        default:
            // Valeurs par défaut
            if (empty($_SESSION['formechographiepelviennee'][NUM_PAGE])) {

                $_SESSION['formechographiepelviennee'][NUM_PAGE] = array(
                    'idpelvienne' => $_REQUEST["idpelvienne"],
                    'idechographiepatient' => $rownfe["idechographiepatient"],
                    'idacte' => $rowe["idacte"],
                    'prescripteur' => $row["prescripteurechographiepatient"],
                    'indication' => $row["indicationechographiepatient"],
                    'datejour' => $rownfe["datejourpelvienne"],
                    'ugravide' => $rownfe["uterusgravidepelvienne"],
                    'utaille' => $rownfe["uterustaillepelvienne"],
                    'ucontour' => $rownfe["uteruscontourpelvienne"],
                    'umyometre' => $rownfe["uterusmyometrepelvienne"],
                    'uendometre' => $rownfe["uterusendometrepelvienne"],
                    'ulumiere' => $rownfe["uteruslumierecervicopelvienne"],
                    'ucol' => $rownfe["uteruscolpelvienne"],
                    'ovaired' => $rownfe["ovairedroitpelvienne"],
                    'ovaireg' => $rownfe["ovairegauchepelvienne"],
                    'anomalie' => $rownfe["anomaliepelvienne"],
                    'epanchement' => $rownfe["epanchementpelvienne"],
                    'vessie' => $rownfe["vessiepelvienne"],
                    'conclusion' => trim(stripcslashes($rownfe["conclusionpelvienne"]))
                );
            } else if (($_SESSION['formechographiepelviennee'][NUM_PAGE]["idpelvienne"]) != $_REQUEST["idpelvienne"]) {

                $_SESSION['formechographiepelviennee'][NUM_PAGE] = array(
                    'idpelvienne' => $_REQUEST["idpelvienne"],
                    'idechographiepatient' => $rownfe["idechographiepatient"],
                    'idacte' => $rowe["idacte"],
                    'prescripteur' => $row["prescripteurechographiepatient"],
                    'indication' => $row["indicationechographiepatient"],
                    'datejour' => $rownfe["datejourpelvienne"],
                    'ugravide' => $rownfe["uterusgravidepelvienne"],
                    'utaille' => $rownfe["uterustaillepelvienne"],
                    'ucontour' => $rownfe["uteruscontourpelvienne"],
                    'umyometre' => $rownfe["uterusmyometrepelvienne"],
                    'uendometre' => $rownfe["uterusendometrepelvienne"],
                    'ulumiere' => $rownfe["uteruslumierecervicopelvienne"],
                    'ucol' => $rownfe["uteruscolpelvienne"],
                    'ovaired' => $rownfe["ovairedroitpelvienne"],
                    'ovaireg' => $rownfe["ovairegauchepelvienne"],
                    'anomalie' => $rownfe["anomaliepelvienne"],
                    'epanchement' => $rownfe["epanchementpelvienne"],
                    'vessie' => $rownfe["vessiepelvienne"],
                    'conclusion' => trim(stripcslashes($rownfe["conclusionpelvienne"]))
                );
            }
            require('hopitalpages/hopitalpatient/hopitalechographie/hopitalpelvienne/hopitalediter/form_editer_echographie.php');
            break;
    }
}