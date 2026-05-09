<?php

if ((isset($_REQUEST["idserologiewidalfelix"]))) {
    $idmc = $_REQUEST["idserologiewidalfelix"];

    $reqr = $con->query("select * from hp_serologie_widal_felix as n left join hp_resultat_examen as r on n.idresultatexamen=r.idresultatexamen "
            . "where n.idserologiewidalfelix='" . $idmc . "' ") or die(mysqli_error($con));
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
    if (empty($_SESSION['formexamenserologie_widal_felixe'])) {
        $_SESSION['formexamenserologie_widal_felixe'] = array();
    }

    if (empty($_SESSION['formexamenserologie_widal_felixe'])) {
        $_SESSION['formexamenserologie_widal_felixe'] = array();
        $_SESSION['formexamenserologie_widal_felixe'][1] = array(
            'idserologiewidalfelix' => $_REQUEST["idserologiewidalfelix"],
            'idexamenpatient' => $rownfe["idexamenpatient"],
            'laboratoire' => $rowe["idlaboratoire"],
            'orientation' => $row["orientationexamenpatient"],
            'prelevement' => $row["dateprelevementexamenpatient"],
            'prescription' => $row["prescriptionexamenpatient"],
            'interpretation' => $rownfe["interpretationserologiewidalfelix"],
            'swfto' => $rownfe["toserologiewidalfelix"],
            'swfth' => $rownfe["thserologiewidalfelix"],
            'swfao' => $rownfe["aoserologiewidalfelix"],
            'swfah' => $rownfe["ahserologiewidalfelix"],
            'swfbo' => $rownfe["boserologiewidalfelix"],
            'swfbh' => $rownfe["bhserologiewidalfelix"],
            'swfco' => $rownfe["coserologiewidalfelix"],
            'swfch' => $rownfe["chserologiewidalfelix"]
        );
    }


    switch (NUM_PAGE) {

        case 2:
            // Récupération des informations du formulaire précédent
            if (!empty($_POST)) {
                $erreur = FALSE;

                $_SESSION['formexamenserologie_widal_felixe'][NUM_PAGE - 1] = array(
                    'idserologiewidalfelix' => $_REQUEST["idserologiewidalfelix"],
                    'idexamenpatient' => $rownfe["idexamenpatient"],
                    'laboratoire' => trim(htmlspecialchars($_POST["laboratoire"])),
                    'orientation' => trim(htmlspecialchars($_POST["orientation"])),
                    'prelevement' => trim(htmlspecialchars($_POST["prelevement"])),
                    'prescription' => trim(htmlspecialchars($_POST["prescription"])),
                    'interpretation' => trim(htmlspecialchars($_POST["interpretation"])),
                    'swfto' => trim(htmlspecialchars($_POST["swfto"])),
                    'swfth' => trim(htmlspecialchars($_POST["swfth"])),
                    'swfao' => trim(htmlspecialchars($_POST["swfao"])),
                    'swfah' => trim(htmlspecialchars($_POST["swfah"])),
                    'swfbo' => trim(htmlspecialchars($_POST["swfbo"])),
                    'swfbh' => trim(htmlspecialchars($_POST["swfbh"])),
                    'swfco' => trim(htmlspecialchars($_POST["swfco"])),
                    'swfch' => trim(htmlspecialchars($_POST["swfch"]))
                );
            }
            if ((isset($erreur)) && ($erreur)) {
                $pag = 'hopitalpages/hopitalpatient/hopitalexamen/hopitalserologie_widal_felix/hopitalediter/edit_examen';
                $stag = 1;
                die('<meta http-equiv="refresh" content="3; URL=' . $url . '?page=' . base64_encode($pag) . '&idexamenpatient=' . $idmc . '">');
            } else {
                require('hopitalpages/hopitalpatient/hopitalexamen/hopitalserologie_widal_felix/hopitalediter/form_terminer.php');
                break;
            }

        case 1:
        default:
            // Valeurs par défaut
            if (empty($_SESSION['formexamenserologie_widal_felixe'][NUM_PAGE])) {

                $_SESSION['formexamenserologie_widal_felixe'][NUM_PAGE] = array(
                    'idserologiewidalfelix' => $_REQUEST["idserologiewidalfelix"],
                    'idexamenpatient' => $rownfe["idexamenpatient"],
                    'laboratoire' => $rowe["idlaboratoire"],
                    'orientation' => $row["orientationexamenpatient"],
                    'prelevement' => $row["dateprelevementexamenpatient"],
                    'prescription' => $row["prescriptionexamenpatient"],
                    'interpretation' => $rownfe["interpretationserologiewidalfelix"],
                    'swfto' => $rownfe["toserologiewidalfelix"],
                    'swfth' => $rownfe["thserologiewidalfelix"],
                    'swfao' => $rownfe["aoserologiewidalfelix"],
                    'swfah' => $rownfe["ahserologiewidalfelix"],
                    'swfbo' => $rownfe["boserologiewidalfelix"],
                    'swfbh' => $rownfe["bhserologiewidalfelix"],
                    'swfco' => $rownfe["coserologiewidalfelix"],
                    'swfch' => $rownfe["chserologiewidalfelix"]
                );
            } else if (($_SESSION['formexamenserologie_widal_felixe'][NUM_PAGE]["idserologiewidalfelix"]) != $_REQUEST["idserologiewidalfelix"]) {

                $_SESSION['formexamenserologie_widal_felixe'][NUM_PAGE] = array(
                    'idserologiewidalfelix' => $_REQUEST["idserologiewidalfelix"],
                    'idexamenpatient' => $rownfe["idexamenpatient"],
                    'laboratoire' => $rowe["idlaboratoire"],
                    'orientation' => $row["orientationexamenpatient"],
                    'prelevement' => $row["dateprelevementexamenpatient"],
                    'prescription' => $row["prescriptionexamenpatient"],
                    'interpretation' => $rownfe["interpretationserologiewidalfelix"],
                    'swfto' => $rownfe["toserologiewidalfelix"],
                    'swfth' => $rownfe["thserologiewidalfelix"],
                    'swfao' => $rownfe["aoserologiewidalfelix"],
                    'swfah' => $rownfe["ahserologiewidalfelix"],
                    'swfbo' => $rownfe["boserologiewidalfelix"],
                    'swfbh' => $rownfe["bhserologiewidalfelix"],
                    'swfco' => $rownfe["coserologiewidalfelix"],
                    'swfch' => $rownfe["chserologiewidalfelix"]
                );
            }
            require('hopitalpages/hopitalpatient/hopitalexamen/hopitalserologie_widal_felix/hopitalediter/form_editer_examen.php');
            break;
    }
}