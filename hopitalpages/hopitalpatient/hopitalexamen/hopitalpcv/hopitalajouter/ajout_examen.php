<?php

if ((isset($_REQUEST["idexamenpatient"]))) {
    $idmc = $_REQUEST["idexamenpatient"];

    $req_fin = $con->query("select * from hp_examen_patient as ep left join hp_sous_dossier as sd on "
            . "ep.idsousdossier=sd.idsousdossier left join hp_dossier as d on sd.iddossier=d.iddossier "
            . "left join hp_patient as p on d.idpatient=p.idpatient left join hp_departement as dp on "
            . "p.residencepatient=dp.iddepartement where ep.idexamenpatient='" . $idmc . "'") or die(mysqli_error($con));
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
    if (empty($_SESSION['formexamenpcv'])) {
        $_SESSION['formexamenpcv'] = array();
    }

    if (empty($_SESSION['formexamenpcv'])) {
        $_SESSION['formexamenpcv'] = array();
        $_SESSION['formexamenpcv'][1] = array(
            'idexamenpatient' => $_REQUEST["idexamenpatient"],
            'laboratoire' => $rowe["idlaboratoire"],
            'orientation' => $row["orientationexamenpatient"],
            'prelevement' => $row["dateprelevementexamenpatient"],
            'prescription' => $row["prescriptionexamenpatient"],
            'interpretation' => '',
                    'col' => '',
                    'leucqte' => '',
                    'leuccons' => '',
                    'leucodeur' => '',
                    'leuccouleur' => '',
                    'etattv' => '',
                    'etatlev' => '',
                    'etatleuc' => '',
                    'etathema' => '',
                    'etatcc' => '',
                    'etatce' => '',
                    'colorcgn' => '',
                    'colorcgp' => '',
                    'colorbgn' => '',
                    'colorbgp' => '',
                    'flore' => ''
        );

    }


    switch (NUM_PAGE) {

        case 2:
            // Récupération des informations du formulaire précédent
            if (!empty($_POST)) {
                $erreur = FALSE;

                $_SESSION['formexamenpcv'][NUM_PAGE - 1] = array(
                    'idexamenpatient' => $_REQUEST["idexamenpatient"],
                    'laboratoire' => trim(htmlspecialchars($_POST["laboratoire"])),
                    'orientation' => trim(htmlspecialchars($_POST["orientation"])),
                    'prelevement' => trim(htmlspecialchars($_POST["prelevement"])),
                    'prescription' => trim(htmlspecialchars($_POST["prescription"])),
                    'interpretation' => trim(htmlspecialchars($_POST["interpretation"])),
                    'col' => trim(htmlspecialchars($_POST["col"])),
                    'leucqte' => floatval(trim(htmlspecialchars($_POST["leucqte"]))),
                    'leuccons' => trim(htmlspecialchars($_POST["leuccons"])),
                    'leucodeur' => trim(htmlspecialchars($_POST["leucodeur"])),
                    'leuccouleur' => trim(htmlspecialchars($_POST["leuccouleur"])),
                    'etattv' => trim(htmlspecialchars($_POST["etattv"])),
                    'etatlev' => trim(htmlspecialchars($_POST["etatlev"])),
                    'etatleuc' => trim(htmlspecialchars($_POST["etatleuc"])),
                    'etathema' => trim(htmlspecialchars($_POST["etathema"])),
                    'etatcc' => trim(htmlspecialchars($_POST["etatcc"])),
                    'etatce' => trim(htmlspecialchars($_POST["etatce"])),
                    'colorcgn' => trim(htmlspecialchars($_POST["colorcgn"])),
                    'colorcgp' => trim(htmlspecialchars($_POST["colorcgp"])),
                    'colorbgn' => trim(htmlspecialchars($_POST["colorbgn"])),
                    'colorbgp' => trim(htmlspecialchars($_POST["colorbgp"])),
                    'flore' => trim(htmlspecialchars($_POST["flore"]))
                );

                
            }
            if ((isset($erreur)) && ($erreur)) {
                $pag = 'hopitalpages/hopitalpatient/hopitalexamen/hopitalpcv/hopitalajouter/ajout_examen';
                $stag = 1;
                die('<meta http-equiv="refresh" content="3; URL=' . $url . '?page=' . base64_encode($pag) . '&idexamenpatient=' . $idmc . '">');
            } else {
                require('hopitalpages/hopitalpatient/hopitalexamen/hopitalpcv/hopitalajouter/form_terminer.php');
                break;
            }

        case 1:
        default:
            // Valeurs par défaut
            if (empty($_SESSION['formexamenpcv'][NUM_PAGE])) {

                $_SESSION['formexamenpcv'][NUM_PAGE] = array(
                    'idexamenpatient' => $_REQUEST["idexamenpatient"],
                    'laboratoire' => $rowe["idlaboratoire"],
                    'orientation' => $row["orientationexamenpatient"],
                    'prelevement' => $row["dateprelevementexamenpatient"],
                    'prescription' => $row["prescriptionexamenpatient"],
                    'interpretation' => '',
                    'col' => '',
                    'leucqte' => '',
                    'leuccons' => '',
                    'leucodeur' => '',
                    'leuccouleur' => '',
                    'etattv' => '',
                    'etatlev' => '',
                    'etatleuc' => '',
                    'etathema' => '',
                    'etatcc' => '',
                    'etatce' => '',
                    'colorcgn' => '',
                    'colorcgp' => '',
                    'colorbgn' => '',
                    'colorbgp' => '',
                    'flore' => ''
                );

                
            } else if (($_SESSION['formexamenpcv'][NUM_PAGE]["idexamenpatient"]) != $_REQUEST["idexamenpatient"]) {

                $_SESSION['formexamenpcv'][NUM_PAGE] = array(
                    'idexamenpatient' => $_REQUEST["idexamenpatient"],
                    'laboratoire' => $rowe["idlaboratoire"],
                    'orientation' => $row["orientationexamenpatient"],
                    'prelevement' => $row["dateprelevementexamenpatient"],
                    'prescription' => $row["prescriptionexamenpatient"],
                    'interpretation' => '',
                    'col' => '',
                    'leucqte' => '',
                    'leuccons' => '',
                    'leucodeur' => '',
                    'leuccouleur' => '',
                    'etattv' => '',
                    'etatlev' => '',
                    'etatleuc' => '',
                    'etathema' => '',
                    'etatcc' => '',
                    'etatce' => '',
                    'colorcgn' => '',
                    'colorcgp' => '',
                    'colorbgn' => '',
                    'colorbgp' => '',
                    'flore' => ''
                );

            }
            require('hopitalpages/hopitalpatient/hopitalexamen/hopitalpcv/hopitalajouter/form_ajouter_examen.php');
            break;
    }
}