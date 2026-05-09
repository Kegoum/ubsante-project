<?php

if ($_REQUEST["idconsultation"]) {
    $rsltc = $con->query('select * from hp_facture where idconsultation=' . $_REQUEST["idconsultation"] . ' ') or die(mysqli_error($con));
    $row = mysqli_fetch_assoc($rsltc);
    $rowpcon = NULL;
    $rowpexa = NULL;
    $rowpord = NULL;
    if ($row["idconsultation"] != NULL) {
        $rsltniv = $con->query("select * from hp_consultation as c left join hp_sous_dossier as sd on c.idsousdossier=sd.idsousdossier "
                . "left join hp_dossier as d on sd.iddossier=d.iddossier left join hp_patient as p on d.idpatient=p.idpatient left join "
                . "hp_departement as dp on p.residencepatient=dp.iddepartement where "
                . "c.idconsultation='" . $row["idconsultation"] . "'") or die(mysqli_error($con));
        $rowpcon = mysqli_fetch_assoc($rsltniv);
    } else if ($row["idexamenpatient"] != NULL) {
        $rsltniv = $con->query("select * from hp_examen_patient as c left join hp_sous_dossier as sd on c.idsousdossier=sd.idsousdossier "
                . "left join hp_dossier as d on sd.iddossier=d.iddossier left join hp_patient as p on d.idpatient=p.idpatient left join "
                . "hp_departement as dp on p.residencepatient=dp.iddepartement where "
                . "c.idexamenpatient='" . $row["idexamenpatient"] . "'") or die(mysqli_error($con));
        $rowpexa = mysqli_fetch_assoc($rsltniv);
    } else if ($row["idordonnance"] != NULL) {
        $rsltniv = $con->query("select * from hp_ordonnance as c left join hp_sous_dossier as sd on c.idsousdossier=sd.idsousdossier "
                . "left join hp_dossier as d on sd.iddossier=d.iddossier left join hp_patient as p on d.idpatient=p.idpatient left join "
                . "hp_departement as dp on p.residencepatient=dp.iddepartement where "
                . "c.idordonnance='" . $row["idordonnance"] . "'") or die(mysqli_error($con));
        $rowpord = mysqli_fetch_assoc($rsltniv);
    }
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
    if (empty($_SESSION['formparametrepatient'])) {
        $_SESSION['formparametrepatient'] = array();
    }

    if (empty($_SESSION['formparametrepatient'])) {
        $_SESSION['formparametrepatient'] = array();
        $_SESSION['formparametrepatient'][1] = array(
            'idconsultation' => $_REQUEST["idconsultation"],
                    'datejour' => NULL,
                    'heurejour' => NULL,
            'tparam[]' => array()
        );

        $rsltens = $con->query("select * from hp_parametre as p left join hp_unite as u on p.idunite=u.idunite where "
                . "p.etatparametre=true order by p.libelleparametre asc") or die(mysqli_error($con));
        $i = 0;
        while ($rec = mysqli_fetch_assoc($rsltens)) {
            $_SESSION['formparametrepatient'][1]["parametre" . $i] = $rec["idparametre"];
            $_SESSION['formparametrepatient'][1]["libelle" . $i] = $rec["libelleparametre"];
            $_SESSION['formparametrepatient'][1]["valeurmin" . $i] = $rec["valeurminparametre"];
            $_SESSION['formparametrepatient'][1]["valeurmax" . $i] = $rec["valeurmaxparametre"];
                    $_SESSION['formparametrepatient'][1]["unite" . $i] = $rec["codeunite"];
            $_SESSION['formparametrepatient'][1]["param" . $i] = '';
            $i = $i + 1;
        }

        $_SESSION['formparametrepatient'][1]["nbparametre"] = $i;
    }


    switch (NUM_PAGE) {

        case 2:
            // Récupération des informations du formulaire précédent
            if (!empty($_POST)) {
                $erreur = FALSE;


                $tabens = array();
                $en = 0;
                if ((!isset($_POST['tparam'])) || (count($_POST['tparam']) == 0)) {
                    echo "<div class='alert alert-warning'>Vous n'avez pas coche les lignes</div>";
                    $erreur = TRUE;
                } else {
                    $mc = $_REQUEST["idconsultation"];
                    $date = date('Y-m-d');
                    foreach ($_POST['tparam'] as $idm) {
//                        if ((!is_numeric($_POST["param" . $idm]))) {
//                            $reqmam = $con->query("select * from hp_parametre where idparametre='" . $idm . "'") or die(mysqli_error($con));
//                            $matmam = mysqli_fetch_assoc($reqmam);
//                            $_SESSION["parametremauv"] = $matmam["libelleparametre"];
//                            echo"<script language='javascript'>$('div.parammatko').show('slow').delay(4000).hide('slow');</script>";
//                            $erreur = TRUE;
//                        }
                        $tabens[$en] = $idm;
                        $en = $en + 1;
                    }
                }
                $_SESSION['formparametrepatient'][NUM_PAGE - 1] = array(
                    'idconsultation' => $_REQUEST["idconsultation"],
                    'datejour' => trim(htmlspecialchars($_POST["datejour"])),
                    'heurejour' => trim(htmlspecialchars($_POST["heurejour"])),
                    'nbparametre' => trim(htmlspecialchars($_POST["nbparametre"])),
                    'tparam[]' => $tabens
                );

                $nbqmat = trim(htmlspecialchars($_POST["nbparametre"]));
                for ($i = 0; $i < $nbqmat; $i++) {
                    $_SESSION['formparametrepatient'][NUM_PAGE - 1]["parametre" . $i] = trim(htmlspecialchars($_POST["parametre" . $i]));
                    $_SESSION['formparametrepatient'][NUM_PAGE - 1]["libelle" . $i] = trim(htmlspecialchars($_POST["libelle" . $i]));
                    $_SESSION['formparametrepatient'][NUM_PAGE - 1]["valeurmin" . $i] = trim(htmlspecialchars($_POST["valeurmin" . $i]));
                    $_SESSION['formparametrepatient'][NUM_PAGE - 1]["valeurmax" . $i] = trim(htmlspecialchars($_POST["valeurmax" . $i]));
                    $_SESSION['formparametrepatient'][NUM_PAGE - 1]["unite" . $i] = trim(htmlspecialchars($_POST["unite" . $i]));
                    $_SESSION['formparametrepatient'][NUM_PAGE - 1]["param" . $i] = trim(htmlspecialchars($_POST["param" . $i]));
                }
            }
            if ((isset($erreur)) && ($erreur)) {
                $pag = 'hopitalpages/hopitalpatient/hopitalparametre/hopitalajouter/ajout_parametre_patient';
                $stag = 1;
                die('<meta http-equiv="refresh" content="3; URL=' . $url . '?page=' . base64_encode($pag) . '&idconsultation=' . $_REQUEST["idconsultation"] . '">');
            } else {
                require('hopitalpages/hopitalpatient/hopitalparametre/hopitalajouter/form_terminer.php');
                break;
            }

        case 1:
        default:
            // Valeurs par défaut
            if (empty($_SESSION['formparametrepatient'][NUM_PAGE])) {

                $_SESSION['formparametrepatient'][NUM_PAGE] = array(
                    'idconsultation' => $_REQUEST["idconsultation"],
                    'datejour' => NULL,
                    'heurejour' => NULL,
                    'tparam[]' => array()
                );

                $rsltens = $con->query("select * from hp_parametre as p left join hp_unite as u on p.idunite=u.idunite where "
                        . "p.etatparametre=true order by p.libelleparametre asc") or die(mysqli_error($con));
                $i = 0;
                while ($rec = mysqli_fetch_assoc($rsltens)) {

                    $_SESSION['formparametrepatient'][NUM_PAGE]["parametre" . $i] = $rec["idparametre"];
                    $_SESSION['formparametrepatient'][NUM_PAGE]["libelle" . $i] = $rec["libelleparametre"];
                    $_SESSION['formparametrepatient'][NUM_PAGE]["valeurmin" . $i] = $rec["valeurminparametre"];
                    $_SESSION['formparametrepatient'][NUM_PAGE]["valeurmax" . $i] = $rec["valeurmaxparametre"];
                    $_SESSION['formparametrepatient'][NUM_PAGE]["unite" . $i] = $rec["codeunite"];
                    $_SESSION['formparametrepatient'][NUM_PAGE]["param" . $i] = '';
                    $i = $i + 1;
                }

                $_SESSION['formparametrepatient'][NUM_PAGE]["nbparametre"] = $i;
            } else if (($_SESSION['formparametrepatient'][NUM_PAGE]["idconsultation"]) != $_REQUEST["idconsultation"]) {

                $_SESSION['formparametrepatient'][NUM_PAGE] = array(
                    'idconsultation' => $_REQUEST["idconsultation"],
                    'datejour' => NULL,
                    'heurejour' => NULL,
                    'tparam[]' => array()
                );

                $rsltens = $con->query("select * from hp_parametre as p left join hp_unite as u on p.idunite=u.idunite where "
                        . "p.etatparametre=true order by p.libelleparametre asc") or die(mysqli_error($con));
                $i = 0;
                while ($rec = mysqli_fetch_assoc($rsltens)) {

                    $_SESSION['formparametrepatient'][NUM_PAGE]["parametre" . $i] = $rec["idparametre"];
                    $_SESSION['formparametrepatient'][NUM_PAGE]["libelle" . $i] = $rec["libelleparametre"];
                    $_SESSION['formparametrepatient'][NUM_PAGE]["valeurmin" . $i] = $rec["valeurminparametre"];
                    $_SESSION['formparametrepatient'][NUM_PAGE]["valeurmax" . $i] = $rec["valeurmaxparametre"];
                    $_SESSION['formparametrepatient'][NUM_PAGE]["unite" . $i] = $rec["codeunite"];
                    $_SESSION['formparametrepatient'][NUM_PAGE]["param" . $i] = '';
                    $i = $i + 1;
                }

                $_SESSION['formparametrepatient'][NUM_PAGE]["nbparametre"] = $i;
            }
            require('hopitalpages/hopitalpatient/hopitalparametre/hopitalajouter/form_ajout_parametre_patient.php');
            break;
    }
}