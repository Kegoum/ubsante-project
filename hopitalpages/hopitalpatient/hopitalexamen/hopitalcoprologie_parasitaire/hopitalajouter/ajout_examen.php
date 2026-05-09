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
    if (empty($_SESSION['formexamencoprologie_parasitaire'])) {
        $_SESSION['formexamencoprologie_parasitaire'] = array();
    }

    if (empty($_SESSION['formexamencoprologie_parasitaire'])) {
        $_SESSION['formexamencoprologie_parasitaire'] = array();
        $_SESSION['formexamencoprologie_parasitaire'][1] = array(
            'idexamenpatient' => $_REQUEST["idexamenpatient"],
            'laboratoire' => $rowe["idlaboratoire"],
            'orientation' => $row["orientationexamenpatient"],
            'prelevement' => $row["dateprelevementexamenpatient"],
            'prescription' => $row["prescriptionexamenpatient"],
            'interpretation' => '',
                    'glaire' => '',
                    'cons' => '',
                    'odeur' => '',
                    'couleur' => '',
                    'sang' => '',
                    'parasiteadulte' => '',
                    'debris' => '',
                    'digestion' => '',
                    'etattv' => '',
                    'etatlev' => '',
                    'parasite' => '',
                    'leucocyte' => '',
                    'hematie' => '',
                    'clue' => '',
                    'cellule' => '',
                    'cristaux' => ''
        );

    }


    switch (NUM_PAGE) {

        case 2:
            // Récupération des informations du formulaire précédent
            if (!empty($_POST)) {
                $erreur = FALSE;

                $_SESSION['formexamencoprologie_parasitaire'][NUM_PAGE - 1] = array(
                    'idexamenpatient' => $_REQUEST["idexamenpatient"],
                    'laboratoire' => trim(htmlspecialchars($_POST["laboratoire"])),
                    'orientation' => trim(htmlspecialchars($_POST["orientation"])),
                    'prelevement' => trim(htmlspecialchars($_POST["prelevement"])),
                    'prescription' => trim(htmlspecialchars($_POST["prescription"])),
                    'interpretation' => trim(htmlspecialchars($_POST["interpretation"])),
                    'glaire' => trim(htmlspecialchars($_POST["glaire"])),
                    'cons' => trim(htmlspecialchars($_POST["cons"])),
                    'odeur' => trim(htmlspecialchars($_POST["odeur"])),
                    'couleur' => trim(htmlspecialchars($_POST["couleur"])),
                    'sang' => trim(htmlspecialchars($_POST["sang"])),
                    'parasiteadulte' => trim(htmlspecialchars($_POST["parasiteadulte"])),
                    'debris' => trim(htmlspecialchars($_POST["debris"])),
                    'digestion' => trim(htmlspecialchars($_POST["digestion"])),
                    'etattv' => trim(htmlspecialchars($_POST["etattv"])),
                    'etatlev' => trim(htmlspecialchars($_POST["etatlev"])),
                    'parasite' => trim(htmlspecialchars($_POST["parasite"])),
                    'leucocyte' => trim(htmlspecialchars($_POST["leucocyte"])),
                    'hematie' => trim(htmlspecialchars($_POST["hematie"])),
                    'clue' => trim(htmlspecialchars($_POST["clue"])),
                    'cellule' => trim(htmlspecialchars($_POST["cellule"])),
                    'cristaux' => trim(htmlspecialchars($_POST["cristaux"]))
                );

                
            }
            if ((isset($erreur)) && ($erreur)) {
                $pag = 'hopitalpages/hopitalpatient/hopitalexamen/hopitalcoprologie_parasitaire/hopitalajouter/ajout_examen';
                $stag = 1;
                die('<meta http-equiv="refresh" content="3; URL=' . $url . '?page=' . base64_encode($pag) . '&idexamenpatient=' . $idmc . '">');
            } else {
                require('hopitalpages/hopitalpatient/hopitalexamen/hopitalcoprologie_parasitaire/hopitalajouter/form_terminer.php');
                break;
            }

        case 1:
        default:
            // Valeurs par défaut
            if (empty($_SESSION['formexamencoprologie_parasitaire'][NUM_PAGE])) {

                $_SESSION['formexamencoprologie_parasitaire'][NUM_PAGE] = array(
                    'idexamenpatient' => $_REQUEST["idexamenpatient"],
                    'laboratoire' => $rowe["idlaboratoire"],
                    'orientation' => $row["orientationexamenpatient"],
                    'prelevement' => $row["dateprelevementexamenpatient"],
                    'prescription' => $row["prescriptionexamenpatient"],
                    'interpretation' => '',
                    'glaire' => '',
                    'cons' => '',
                    'odeur' => '',
                    'couleur' => '',
                    'sang' => '',
                    'parasiteadulte' => '',
                    'debris' => '',
                    'digestion' => '',
                    'etattv' => '',
                    'etatlev' => '',
                    'parasite' => '',
                    'leucocyte' => '',
                    'hematie' => '',
                    'clue' => '',
                    'cellule' => '',
                    'cristaux' => ''
                );

                
            } else if (($_SESSION['formexamencoprologie_parasitaire'][NUM_PAGE]["idexamenpatient"]) != $_REQUEST["idexamenpatient"]) {

                $_SESSION['formexamencoprologie_parasitaire'][NUM_PAGE] = array(
                    'idexamenpatient' => $_REQUEST["idexamenpatient"],
                    'laboratoire' => $rowe["idlaboratoire"],
                    'orientation' => $row["orientationexamenpatient"],
                    'prelevement' => $row["dateprelevementexamenpatient"],
                    'prescription' => $row["prescriptionexamenpatient"],
                    'interpretation' => '',
                    'glaire' => '',
                    'cons' => '',
                    'odeur' => '',
                    'couleur' => '',
                    'sang' => '',
                    'parasiteadulte' => '',
                    'debris' => '',
                    'digestion' => '',
                    'etattv' => '',
                    'etatlev' => '',
                    'parasite' => '',
                    'leucocyte' => '',
                    'hematie' => '',
                    'clue' => '',
                    'cellule' => '',
                    'cristaux' => ''
                );

            }
            require('hopitalpages/hopitalpatient/hopitalexamen/hopitalcoprologie_parasitaire/hopitalajouter/form_ajouter_examen.php');
            break;
    }
}