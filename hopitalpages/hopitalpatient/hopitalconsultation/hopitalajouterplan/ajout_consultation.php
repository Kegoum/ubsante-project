<?php

if ($_REQUEST["idconsultation"]) {
    $idc = $_REQUEST["idconsultation"];
    $rsltc = $con->query("select * from hp_consultation as c left join hp_sous_dossier as sd on c.idsousdossier=sd.idsousdossier "
            . "left join hp_dossier as d on sd.iddossier=d.iddossier left join hp_patient as p on d.idpatient=p.idpatient left join "
            . "hp_departement as dp on p.residencepatient=dp.iddepartement where "
            . "c.idconsultation='" . $_REQUEST["idconsultation"] . "'") or die(mysqli_error($con));
    $row = mysqli_fetch_assoc($rsltc);

    $rsltcp = $con->query("select * from hp_parametre_patient as c left join hp_parametre as sd on "
            . "c.idparametre=sd.idparametre left join hp_unite as d on sd.idunite=d.idunite where "
            . "c.idconsultation='" . $_REQUEST["idconsultation"] . "'") or die(mysqli_error($con));
//    $rowp = mysqli_fetch_assoc($rsltcp);
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
    if (empty($_SESSION['formconsultationplan'])) {
        $_SESSION['formconsultationplan'] = array();
    }

    if (empty($_SESSION['formconsultationplan'])) {
        $_SESSION['formconsultationplan'] = array();

        $_SESSION['formconsultationplan'][1] = array(
            'idconsultation' => $_REQUEST["idconsultation"],
            'decisionexamen' => 0,
            'decisionordonnance' => 0,
            'decisionacte' => 0,
                    'decisionechographie' => 0,
            'decisionhospitalisation' => 0
        );
        $_SESSION['formconsultationplan'][2] = array(
            'idconsultation3' => $_REQUEST["idconsultation"],
            'salle' => '',
            'lit' => ''
        );
    }


    switch (NUM_PAGE) {

        case 4:
            // Valeurs par défaut

            require('hopitalpages/hopitalpatient/hopitalconsultation/hopitalajouterplan/form_terminer.php');
            break;

        case 3:
            // Récupération des informations du formulaire précédent
            if (!empty($_POST)) {
                $erreur = FALSE;

                $sall = "";
                $li = "";
                if ($_SESSION['formconsultationplan'][1]["decisionhospitalisation"]) {
                    $sall = $_POST["salle"];
                    $li = $_POST["lit"];
                }
                $_SESSION['formconsultationplan'][NUM_PAGE - 1] = array(
                    'idconsultation3' => $_REQUEST["idconsultation"],
                    'salle' => $sall,
                    'lit' => $li
                );
            }
            if ((isset($erreur)) && ($erreur)) {
                $pag = 'hopitalpages/hopitalpatient/hopitalconsultation/hopitalajouterplan/ajout_consultation';
                $stag = 2;
                die('<meta http-equiv="refresh" content="0; URL=' . $url . '?page=' . base64_encode($pag) . '&idconsultation=' . $idmc . '">');
            } else {
                require('hopitalpages/hopitalpatient/hopitalconsultation/hopitalajouterplan/form_confirmation.php');
                break;
            }

        case 2:
            // Valeurs par défaut

            if (empty($_SESSION['formconsultationplan'][NUM_PAGE])) {

                $_SESSION['formconsultationplan'][NUM_PAGE] = array(
                    'idconsultation3' => $_REQUEST["idconsultation"],
                    'salle' => '',
                    'lit' => ''
                );
            } else if (($_SESSION['formconsultationplan'][NUM_PAGE]["idconsultation3"]) != $_REQUEST["idconsultation"]) {

                $_SESSION['formconsultationplan'][NUM_PAGE] = array(
                    'idconsultation3' => $_REQUEST["idconsultation"],
                    'salle' => '',
                    'lit' => ''
                );
            } else {
//                echo "<script language='javascript'>alert('olol')</script>";
            }
            // Récupération des informations du formulaire précédent
            if (!empty($_POST)) {
                $erreur = FALSE;

                $dece = 0;
                $deco = 0;
                $dech = 0;
                $decec = 0;
                $deca = 0;
                if (isset($_POST["decisionexamen"])) {
                    $dece = 1;
                }
                if (isset($_POST["decisionordonnance"])) {
                    $deco = 1;
                }
                if (isset($_POST["decisionhospitalisation"])) {
                    $dech = 1;
                }
                if (isset($_POST["decisionechographie"])) {
                    $decec = 1;
                }
                if (isset($_POST["decisionacte"])) {
                    $deca = 1;
                }

                $_SESSION['formconsultationplan'][NUM_PAGE - 1] = array(
                    'idconsultation' => $_REQUEST["idconsultation"],
                    'decisionexamen' => $dece,
                    'decisionordonnance' => $deco,
                    'decisionhospitalisation' => $dech,
                    'decisionechographie' => $decec,
                    'decisionacte' => $deca
                );
            }
            if ((isset($erreur)) && ($erreur)) {
                $pag = 'hopitalpages/hopitalpatient/hopitalconsultation/hopitalajouterplan/ajout_consultation';
                $stag = 1;
                die('<meta http-equiv="refresh" content="0; URL=' . $url . '?page=' . base64_encode($pag) . '&idconsultation=' . $idmc . '">');
            } else {
                require('hopitalpages/hopitalpatient/hopitalconsultation/hopitalajouterplan/form_decision.php');
                break;
            }

        case 1:
        default:
            // Valeurs par défaut

            if (empty($_SESSION['formconsultationplan'][NUM_PAGE])) {

                $_SESSION['formconsultationplan'][NUM_PAGE] = array(
                    'idconsultation' => $_REQUEST["idconsultation"],
                    'decisionexamen' => 0,
                    'decisionordonnance' => 0,
                    'decisionacte' => 0,
                    'decisionechographie' => 0,
                    'decisionhospitalisation' => 0
                );
            } else if (($_SESSION['formconsultationplan'][NUM_PAGE]["idconsultation"]) != $_REQUEST["idconsultation"]) {

                $_SESSION['formconsultationplan'][NUM_PAGE] = array(
                    'idconsultation' => $_REQUEST["idconsultation"],
                    'decisionexamen' => 0,
                    'decisionordonnance' => 0,
                    'decisionechographie' => 0,
                    'decisionacte' => 0,
                    'decisionhospitalisation' => 0
                );
            }

            require('hopitalpages/hopitalpatient/hopitalconsultation/hopitalajouterplan/form_ajout_decision.php');
            break;
    }
}