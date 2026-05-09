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
    if (empty($_SESSION['formexamennfs'])) {
        $_SESSION['formexamennfs'] = array();
    }

    if (empty($_SESSION['formexamennfs'])) {
        $_SESSION['formexamennfs'] = array();
        $_SESSION['formexamennfs'][1] = array(
            'idexamenpatient' => $_REQUEST["idexamenpatient"],
            'laboratoire' => $rowe["idlaboratoire"],
            'orientation' => $row["orientationexamenpatient"],
            'prelevement' => $row["dateprelevementexamenpatient"],
            'prescription' => $row["prescriptionexamenpatient"],
            'interpretation' => '',
            'tligne[]' => array()
        );

        $i = 0;
        $rsltens = $con->query("select * from hp_ligne_nfs where etatlignenfs=true") or die(mysqli_error($con));
        while ($rec = mysqli_fetch_assoc($rsltens)) {

            $_SESSION['formexamennfs'][1]["idlignenfs" . $i] = $rec["idlignenfs"];
            $_SESSION['formexamennfs'][1]["lib" . $i] = $rec["libellelignenfs"];
            $_SESSION['formexamennfs'][1]["code" . $i] = $rec["codelignenfs"];
            $_SESSION['formexamennfs'][1]["min29" . $i] = $rec["29jourminlignenfs"];
            $_SESSION['formexamennfs'][1]["max29" . $i] = $rec["29jourmaxlignenfs"];
            $_SESSION['formexamennfs'][1]["min6" . $i] = $rec["6anminlignenfs"];
            $_SESSION['formexamennfs'][1]["max6" . $i] = $rec["6anmaxlignenfs"];
            $_SESSION['formexamennfs'][1]["minf" . $i] = $rec["adultefemmeminlignenfs"];
            $_SESSION['formexamennfs'][1]["maxf" . $i] = $rec["adultefemmemaxlignenfs"];
            $_SESSION['formexamennfs'][1]["minh" . $i] = $rec["adultehommeminlignenfs"];
            $_SESSION['formexamennfs'][1]["maxh" . $i] = $rec["adultehommemaxlignenfs"];
            $_SESSION['formexamennfs'][1]["valeur" . $i] = '';
            $i = $i + 1;
        }

        $_SESSION['formexamennfs'][1]["nbexamen"] = $i;
    }


    switch (NUM_PAGE) {

        case 2:
            // Récupération des informations du formulaire précédent
            if (!empty($_POST)) {
                $erreur = FALSE;


                $tabens = array();
                $en = 0;
                if ((!isset($_POST['tligne'])) || (count($_POST['tligne']) == 0)) {
                    echo "<div class='alert alert-warning'>Vous n'avez pas coche les ligne</div>";
                    $erreur = TRUE;
                } else {
                    $mc = $_REQUEST["idexamenpatient"];
                    
                    foreach ($_POST['tligne'] as $idm) {
                        if ((!is_numeric($_POST["valeur" . $idm]))) {
                            
                            echo"<script language='javascript'>alert('erreur')</script>";
                            $erreur = TRUE;
                        }
                        $tabens[$en] = $idm;
                        $en = $en + 1;
                    }
                }
                $_SESSION['formexamennfs'][NUM_PAGE - 1] = array(
                    'idexamenpatient' => $_REQUEST["idexamenpatient"],
                    'laboratoire' => trim(htmlspecialchars($_POST["laboratoire"])),
                    'orientation' => trim(htmlspecialchars($_POST["orientation"])),
                    'prelevement' => trim(htmlspecialchars($_POST["prelevement"])),
                    'prescription' => trim(htmlspecialchars($_POST["prescription"])),
                    'interpretation' => trim(htmlspecialchars($_POST["interpretation"])),
                    'nbexamen' => trim(htmlspecialchars($_POST["nbexamen"])),
                    'tligne[]' => $tabens
                );

                $nbqmat = trim(htmlspecialchars($_POST["nbexamen"]));
                for ($i = 0; $i < $nbqmat; $i++) {
                    $_SESSION['formexamennfs'][NUM_PAGE - 1]["idlignenfs" . $i] = trim(htmlspecialchars($_POST["idlignenfs" . $i]));
                    $_SESSION['formexamennfs'][NUM_PAGE - 1]["lib" . $i] = trim(htmlspecialchars($_POST["lib" . $i]));
                    $_SESSION['formexamennfs'][NUM_PAGE - 1]["code" . $i] = trim(htmlspecialchars($_POST["code" . $i]));
                    $_SESSION['formexamennfs'][NUM_PAGE - 1]["min29" . $i] = trim(htmlspecialchars($_POST["min29" . $i]));
                    $_SESSION['formexamennfs'][NUM_PAGE - 1]["max29" . $i] = trim(htmlspecialchars($_POST["max29" . $i]));
                    $_SESSION['formexamennfs'][NUM_PAGE - 1]["min6" . $i] = trim(htmlspecialchars($_POST["min6" . $i]));
                    $_SESSION['formexamennfs'][NUM_PAGE - 1]["max6" . $i] = trim(htmlspecialchars($_POST["max6" . $i]));
                    $_SESSION['formexamennfs'][NUM_PAGE - 1]["minf" . $i] = trim(htmlspecialchars($_POST["minf" . $i]));
                    $_SESSION['formexamennfs'][NUM_PAGE - 1]["maxf" . $i] = trim(htmlspecialchars($_POST["maxf" . $i]));
                    $_SESSION['formexamennfs'][NUM_PAGE - 1]["minh" . $i] = trim(htmlspecialchars($_POST["minh" . $i]));
                    $_SESSION['formexamennfs'][NUM_PAGE - 1]["maxh" . $i] = trim(htmlspecialchars($_POST["maxh" . $i]));
                    $_SESSION['formexamennfs'][NUM_PAGE - 1]["valeur" . $i] = trim(htmlspecialchars($_POST["valeur" . $i]));
                }
                
            }
            if ((isset($erreur)) && ($erreur)) {
                $pag = 'hopitalpages/hopitalpatient/hopitalexamen/hopitalnfs/hopitalajouter/ajout_examen';
                $stag = 1;
                die('<meta http-equiv="refresh" content="3; URL=' . $url . '?page=' . base64_encode($pag) . '&idexamenpatient=' . $idmc . '">');
            } else {
                require('hopitalpages/hopitalpatient/hopitalexamen/hopitalnfs/hopitalajouter/form_terminer.php');
                break;
            }

        case 1:
        default:
            // Valeurs par défaut
            if (empty($_SESSION['formexamennfs'][NUM_PAGE])) {

                $_SESSION['formexamennfs'][NUM_PAGE] = array(
                    'idexamenpatient' => $_REQUEST["idexamenpatient"],
                    'laboratoire' => $rowe["idlaboratoire"],
                    'orientation' => $row["orientationexamenpatient"],
                    'prelevement' => $row["dateprelevementexamenpatient"],
                    'prescription' => $row["prescriptionexamenpatient"],
                    'interpretation' => '',
                    'tligne[]' => array()
                );

                $i = 0;
                $rsltens = $con->query("select * from hp_ligne_nfs where etatlignenfs=true") or die(mysqli_error($con));
                while ($rec = mysqli_fetch_assoc($rsltens)) {

                    $_SESSION['formexamennfs'][NUM_PAGE]["idlignenfs" . $i] = $rec["idlignenfs"];
                    $_SESSION['formexamennfs'][NUM_PAGE]["lib" . $i] = $rec["libellelignenfs"];
                    $_SESSION['formexamennfs'][NUM_PAGE]["code" . $i] = $rec["codelignenfs"];
                    $_SESSION['formexamennfs'][NUM_PAGE]["min29" . $i] = $rec["29jourminlignenfs"];
                    $_SESSION['formexamennfs'][NUM_PAGE]["max29" . $i] = $rec["29jourmaxlignenfs"];
                    $_SESSION['formexamennfs'][NUM_PAGE]["min6" . $i] = $rec["6anminlignenfs"];
                    $_SESSION['formexamennfs'][NUM_PAGE]["max6" . $i] = $rec["6anmaxlignenfs"];
                    $_SESSION['formexamennfs'][NUM_PAGE]["minf" . $i] = $rec["adultefemmeminlignenfs"];
                    $_SESSION['formexamennfs'][NUM_PAGE]["maxf" . $i] = $rec["adultefemmemaxlignenfs"];
                    $_SESSION['formexamennfs'][NUM_PAGE]["minh" . $i] = $rec["adultehommeminlignenfs"];
                    $_SESSION['formexamennfs'][NUM_PAGE]["maxh" . $i] = $rec["adultehommemaxlignenfs"];
                    $_SESSION['formexamennfs'][NUM_PAGE]["valeur" . $i] = '';
                    $i = $i + 1;
                }

                $_SESSION['formexamennfs'][NUM_PAGE]["nbexamen"] = $i;
            } else if (($_SESSION['formexamennfs'][NUM_PAGE]["idexamenpatient"]) != $_REQUEST["idexamenpatient"]) {

                $_SESSION['formexamennfs'][NUM_PAGE] = array(
                    'idexamenpatient' => $_REQUEST["idexamenpatient"],
                    'laboratoire' => $rowe["idlaboratoire"],
                    'orientation' => $row["orientationexamenpatient"],
                    'prelevement' => $row["dateprelevementexamenpatient"],
                    'prescription' => $row["prescriptionexamenpatient"],
                    'interpretation' => '',
                    'tligne[]' => array()
                );

                $i = 0;
                $rsltens = $con->query("select * from hp_ligne_nfs where etatlignenfs=true") or die(mysqli_error($con));
                while ($rec = mysqli_fetch_assoc($rsltens)) {

                    $_SESSION['formexamennfs'][NUM_PAGE]["idlignenfs" . $i] = $rec["idlignenfs"];
                    $_SESSION['formexamennfs'][NUM_PAGE]["lib" . $i] = $rec["libellelignenfs"];
                    $_SESSION['formexamennfs'][NUM_PAGE]["code" . $i] = $rec["codelignenfs"];
                    $_SESSION['formexamennfs'][NUM_PAGE]["min29" . $i] = $rec["29jourminlignenfs"];
                    $_SESSION['formexamennfs'][NUM_PAGE]["max29" . $i] = $rec["29jourmaxlignenfs"];
                    $_SESSION['formexamennfs'][NUM_PAGE]["min6" . $i] = $rec["6anminlignenfs"];
                    $_SESSION['formexamennfs'][NUM_PAGE]["max6" . $i] = $rec["6anmaxlignenfs"];
                    $_SESSION['formexamennfs'][NUM_PAGE]["minf" . $i] = $rec["adultefemmeminlignenfs"];
                    $_SESSION['formexamennfs'][NUM_PAGE]["maxf" . $i] = $rec["adultefemmemaxlignenfs"];
                    $_SESSION['formexamennfs'][NUM_PAGE]["minh" . $i] = $rec["adultehommeminlignenfs"];
                    $_SESSION['formexamennfs'][NUM_PAGE]["maxh" . $i] = $rec["adultehommemaxlignenfs"];
                    $_SESSION['formexamennfs'][NUM_PAGE]["valeur" . $i] = '';
                    $i = $i + 1;
                }

                $_SESSION['formexamennfs'][NUM_PAGE]["nbexamen"] = $i;
            }
            require('hopitalpages/hopitalpatient/hopitalexamen/hopitalnfs/hopitalajouter/form_ajouter_examen.php');
            break;
    }
}