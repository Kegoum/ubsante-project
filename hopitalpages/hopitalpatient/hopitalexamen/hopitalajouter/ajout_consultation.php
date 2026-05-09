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
    if (empty($_SESSION['formconsultation'])) {
        $_SESSION['formconsultation'] = array();
    }

    if (empty($_SESSION['formconsultation'])) {
        $_SESSION['formconsultation'] = array();

        $_SESSION['formconsultation'][1] = array(
            'idconsultation' => $_REQUEST["idconsultation"],
            'but' => NULL,
            'signe' => NULL,
            'symptome' => NULL,
            'diagnostique' => NULL
        );

        $_SESSION['formconsultation'][2] = array(
            'idconsultation2' => $_REQUEST["idconsultation"],
            'decisionexamen' => 0,
            'decisionordonnance' => 0,
            'decisionhospitalisation' => 0
        );
        $_SESSION['formconsultation'][3] = array(
            'idconsultation3' => $_REQUEST["idconsultation"],
            'salle' => '',
            'lit' => ''
        );
    }


    switch (NUM_PAGE) {

        case 5:
            // Valeurs par défaut

            require('hopitalpages/hopitalpatient/hopitalconsultation/hopitalajouter/form_terminer.php');
            break;

        case 4:
            // Récupération des informations du formulaire précédent
            if (!empty($_POST)) {
                $erreur = FALSE;

                $sall = "";
                $li = "";
                if ($_SESSION['formconsultation'][2]["decisionhospitalisation"]) {
                    $sall=$_POST["salle"];
                    $li=$_POST["lit"];
                }
                $_SESSION['formconsultation'][NUM_PAGE - 1] = array(
                    'idconsultation3' => $_REQUEST["idconsultation"],
                    'salle' => $sall,
                    'lit' => $li
                );
            }
            if ((isset($erreur)) && ($erreur)) {
                $pag = 'hopitalpages/hopitalpatient/hopitalconsultation/hopitalajouter/ajout_consultation';
                $stag = 1;
                die('<meta http-equiv="refresh" content="0; URL=' . $url . '?page=' . base64_encode($pag) . '&idconsultation=' . $idmc . '">');
            } else {
                require('hopitalpages/hopitalpatient/hopitalconsultation/hopitalajouter/form_confirmation.php');
                break;
            }

        case 3:
            // Valeurs par défaut

            if (empty($_SESSION['formconsultation'][NUM_PAGE])) {

                $_SESSION['formconsultation'][NUM_PAGE] = array(
                    'idconsultation3' => $_REQUEST["idconsultation"],
                    'salle' => '',
                    'lit' => ''
                );
            } else if (($_SESSION['formconsultation'][NUM_PAGE]["idconsultation3"]) != $_REQUEST["idconsultation"]) {

                $_SESSION['formconsultation'][NUM_PAGE] = array(
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
                if (isset($_POST["decisionexamen"])) {
                    $dece = 1;
                }
                if (isset($_POST["decisionordonnance"])) {
                    $deco = 1;
                }
                if (isset($_POST["decisionhospitalisation"])) {
                    $dech = 1;
                }

                $_SESSION['formconsultation'][NUM_PAGE - 1] = array(
                    'idconsultation2' => $_REQUEST["idconsultation"],
                    'decisionexamen' => $dece,
                    'decisionordonnance' => $deco,
                    'decisionhospitalisation' => $dech
                );
            }
            if ((isset($erreur)) && ($erreur)) {
                $pag = 'hopitalpages/hopitalpatient/hopitalconsultation/hopitalajouter/ajout_consultation';
                $stag = 1;
                die('<meta http-equiv="refresh" content="0; URL=' . $url . '?page=' . base64_encode($pag) . '&idconsultation=' . $idmc . '">');
            } else {
                require('hopitalpages/hopitalpatient/hopitalconsultation/hopitalajouter/form_decision.php');
                break;
            }

        case 2:
            // Valeurs par défaut

            if (empty($_SESSION['formconsultation'][NUM_PAGE])) {

                $_SESSION['formconsultation'][NUM_PAGE] = array(
                    'idconsultation2' => $_REQUEST["idconsultation"],
                    'decisionexamen' => 0,
                    'decisionordonnance' => 0,
                    'decisionhospitalisation' => 0
                );
            } else if (($_SESSION['formconsultation'][NUM_PAGE]["idconsultation2"]) != $_REQUEST["idconsultation"]) {

                $_SESSION['formconsultation'][NUM_PAGE] = array(
                    'idconsultation2' => $_REQUEST["idconsultation"],
                    'decisionexamen' => 0,
                    'decisionordonnance' => 0,
                    'decisionhospitalisation' => 0
                );
            } else {
//                echo "<script language='javascript'>alert('olol')</script>";
            }

            // Récupération des informations du formulaire précédent
            if (!empty($_POST)) {
                $erreur = FALSE;
                $_SESSION['formconsultation'][NUM_PAGE - 1] = array(
                    'idconsultation' => $_REQUEST["idconsultation"],
                    'but' => trim(htmlspecialchars($_POST["but"])),
                    'signe' => trim(htmlspecialchars($_POST["signe"])),
                    'symptome' => trim(htmlspecialchars($_POST["symptome"])),
                    'diagnostique' => trim(htmlspecialchars($_POST["diagnostique"]))
                );
            }

            require('hopitalpages/hopitalpatient/hopitalconsultation/hopitalajouter/form_ajout_decision.php');
            break;

        case 1:
        default:
            // Valeurs par défaut
            if (empty($_SESSION['formconsultation'][NUM_PAGE])) {

                $_SESSION['formconsultation'][NUM_PAGE] = array(
                    'idconsultation' => $_REQUEST["idconsultation"],
                    'but' => NULL,
                    'signe' => NULL,
                    'symptome' => NULL,
                    'diagnostique' => NULL
                );
            } else if (($_SESSION['formconsultation'][NUM_PAGE]["idconsultation"]) != $_REQUEST["idconsultation"]) {

                $_SESSION['formconsultation'][NUM_PAGE] = array(
                    'idconsultation' => $_REQUEST["idconsultation"],
                    'but' => NULL,
                    'signe' => NULL,
                    'symptome' => NULL,
                    'diagnostique' => NULL
                );
            }
            require('hopitalpages/hopitalpatient/hopitalconsultation/hopitalajouter/form_ajout_consultation.php');
            break;
    }
}