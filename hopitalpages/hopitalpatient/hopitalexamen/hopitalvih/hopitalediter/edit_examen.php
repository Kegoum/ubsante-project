<?php

if ((isset($_REQUEST["idvih"]))) {
    $idmc = $_REQUEST["idvih"];

    $reqr = $con->query("select * from hp_vih as n left join hp_resultat_examen as r on n.idresultatexamen=r.idresultatexamen "
            . "where n.idvih='" . $idmc . "' ") or die(mysqli_error($con));
    $rownfe = mysqli_fetch_array($reqr);

    $req_fin = $con->query("select * from hp_examen_patient as ep left join hp_sous_dossier as sd on "
            . "ep.idsousdossier=sd.idsousdossier left join hp_dossier as d on sd.iddossier=d.iddossier "
            . "left join hp_patient as p on d.idpatient=p.idpatient left join hp_departement as dp on "
            . "p.residencepatient=dp.iddepartement where ep.idexamenpatient='" . $rownfe["idexamenpatient"] . "'") or die(mysqli_error($con));
    $row = mysqli_fetch_assoc($req_fin);
    $req_fine = $con->query("select * from hp_examen as e left join hp_laboratoire as l on e.idlaboratoire=l.idlaboratoire "
            . "left join hp_service as s on l.idservice=s.idservice left join hp_unite as u on e.idunite=u.idunite "
            . "where e.idexamen='" . $row["idexamen"] . "'") or die(mysqli_error($con));
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
    if (empty($_SESSION['formexamenvihe'])) {
        $_SESSION['formexamenvihe'] = array();
    }

    if (empty($_SESSION['formexamenvihe'])) {
        $_SESSION['formexamenvihe'] = array();
        $_SESSION['formexamenvihe'][1] = array(
            'idvih' => $_REQUEST["idvih"],
            'idexamenpatient' => $rownfe["idexamenpatient"],
            'laboratoire' => $rowe["idlaboratoire"],
            'orientation' => $row["orientationexamenpatient"],
            'prelevement' => $row["dateprelevementexamenpatient"],
            'prescription' => $row["prescriptionexamenpatient"],
            'interpretation' => $rownfe["interpretationvih"],
            'methode' => $rownfe["methodevih"],
            'resultat' => $rownfe["resultatvih"]
        );
    }


    switch (NUM_PAGE) {

        case 2:
            // Récupération des informations du formulaire précédent
            if (!empty($_POST)) {
                $erreur = FALSE;

                $_SESSION['formexamenvihe'][NUM_PAGE - 1] = array(
                    'idvih' => $_REQUEST["idvih"],
                    'idexamenpatient' => $rownfe["idexamenpatient"],
                    'laboratoire' => trim(htmlspecialchars($_POST["laboratoire"])),
                    'orientation' => trim(htmlspecialchars($_POST["orientation"])),
                    'prelevement' => trim(htmlspecialchars($_POST["prelevement"])),
                    'prescription' => trim(htmlspecialchars($_POST["prescription"])),
                    'interpretation' => trim(htmlspecialchars($_POST["interpretation"])),
                    'methode' => trim(htmlspecialchars($_POST["methode"])),
                    'resultat' => (trim(htmlspecialchars($_POST["resultat"])))
                );
            }
            if ((isset($erreur)) && ($erreur)) {
                $pag = 'hopitalpages/hopitalpatient/hopitalexamen/hopitalvih/hopitalediter/edit_examen';
                $stag = 1;
                die('<meta http-equiv="refresh" content="3; URL=' . $url . '?page=' . base64_encode($pag) . '&idexamenpatient=' . $idmc . '">');
            } else {
                require('hopitalpages/hopitalpatient/hopitalexamen/hopitalvih/hopitalediter/form_terminer.php');
                break;
            }

        case 1:
        default:
            // Valeurs par défaut
            if (empty($_SESSION['formexamenvihe'][NUM_PAGE])) {

                $_SESSION['formexamenvihe'][NUM_PAGE] = array(
                    'idvih' => $_REQUEST["idvih"],
                    'idexamenpatient' => $rownfe["idexamenpatient"],
                    'laboratoire' => $rowe["idlaboratoire"],
                    'orientation' => $row["orientationexamenpatient"],
                    'prelevement' => $row["dateprelevementexamenpatient"],
                    'prescription' => $row["prescriptionexamenpatient"],
                    'interpretation' => $rownfe["interpretationvih"],
                    'methode' => $rownfe["methodevih"],
                    'resultat' => $rownfe["resultatvih"]
                );
            } else if (($_SESSION['formexamenvihe'][NUM_PAGE]["idvih"]) != $_REQUEST["idvih"]) {

                $_SESSION['formexamenvihe'][NUM_PAGE] = array(
                    'idvih' => $_REQUEST["idvih"],
                    'idexamenpatient' => $rownfe["idexamenpatient"],
                    'laboratoire' => $rowe["idlaboratoire"],
                    'orientation' => $row["orientationexamenpatient"],
                    'prelevement' => $row["dateprelevementexamenpatient"],
                    'prescription' => $row["prescriptionexamenpatient"],
                    'interpretation' => $rownfe["interpretationvih"],
                    'methode' => $rownfe["methodevih"],
                    'resultat' => $rownfe["resultatvih"]
                );
            }
            require('hopitalpages/hopitalpatient/hopitalexamen/hopitalvih/hopitalediter/form_editer_examen.php');
            break;
    }
}