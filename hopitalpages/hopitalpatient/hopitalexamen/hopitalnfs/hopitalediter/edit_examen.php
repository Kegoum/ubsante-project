<?php

if ((isset($_REQUEST["idnfs"]))) {
    $idmc = $_REQUEST["idnfs"];

    $reqr = $con->query("select * from hp_nfs as n left join hp_resultat_examen as r on n.idresultatexamen=r.idresultatexamen "
            . "where n.idnfs='" . $idmc . "' "
            . "") or die(mysqli_error($con));
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
    if (empty($_SESSION['formexamennfse'])) {
        $_SESSION['formexamennfse'] = array();
    }

    if (empty($_SESSION['formexamennfse'])) {
        $_SESSION['formexamennfse'] = array();
        
                $_SESSION['formexamennfse'][1] = array(
                    'idnfs' => $_REQUEST["idnfs"],
                    'idexamenpatient' => $rownfe["idexamenpatient"],
                    'laboratoire' => $rowe["idlaboratoire"],
                    'orientation' => $row["orientationexamenpatient"],
                    'prelevement' => $row["dateprelevementexamenpatient"],
                    'prescription' => $row["prescriptionexamenpatient"],
                    'interpretation' => $rownfe["interpretationnfs"],
                    'tligne[]' => array()
                );
                $tabens = array();

                $i = 0;
                $en = 0;
                $rsltens = $con->query("select * from hp_ligne_nfs where etatlignenfs=true") or die(mysqli_error($con));
                while ($rec = mysqli_fetch_assoc($rsltens)) {
                    $reqmc = $con->query("select * from hp_detail_nfs as n where n.idnfs='" . $idmc . "' "
                            . "and n.idlignenfs='" . $rec["idlignenfs"] . "' ") or die(mysqli_error($con));
                    $nbmc = mysqli_num_rows($reqmc);
                    $vale = '';
                    if ($nbmc != 0) {
                        $rowmc1 = mysqli_fetch_assoc($reqmc);
                        $vale = $rowmc1["valeurdetailnfs"];
                        $tabens[$en] = $i;
                        $en = $en + 1;
                    }
                    $_SESSION['formexamennfse'][1]["idlignenfs" . $i] = $rec["idlignenfs"];
                    $_SESSION['formexamennfse'][1]["lib" . $i] = $rec["libellelignenfs"];
                    $_SESSION['formexamennfse'][1]["code" . $i] = $rec["codelignenfs"];
                    $_SESSION['formexamennfse'][1]["min29" . $i] = $rec["29jourminlignenfs"];
                    $_SESSION['formexamennfse'][1]["max29" . $i] = $rec["29jourmaxlignenfs"];
                    $_SESSION['formexamennfse'][1]["min6" . $i] = $rec["6anminlignenfs"];
                    $_SESSION['formexamennfse'][1]["max6" . $i] = $rec["6anmaxlignenfs"];
                    $_SESSION['formexamennfse'][1]["minf" . $i] = $rec["adultefemmeminlignenfs"];
                    $_SESSION['formexamennfse'][1]["maxf" . $i] = $rec["adultefemmemaxlignenfs"];
                    $_SESSION['formexamennfse'][1]["minh" . $i] = $rec["adultehommeminlignenfs"];
                    $_SESSION['formexamennfse'][1]["maxh" . $i] = $rec["adultehommemaxlignenfs"];
                    $_SESSION['formexamennfse'][1]["valeur" . $i] = $vale;

                    $i = $i + 1;
                }

                $_SESSION['formexamennfse'][1]["nbexamen"] = $i;
                $_SESSION['formexamennfse'][1]["tligne[]"] = $tabens;
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
                $_SESSION['formexamennfse'][NUM_PAGE - 1] = array(
                    'idnfs' => $_REQUEST["idnfs"],
                    'idexamenpatient' => $rownfe["idexamenpatient"],
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
                    $_SESSION['formexamennfse'][NUM_PAGE - 1]["idlignenfs" . $i] = trim(htmlspecialchars($_POST["idlignenfs" . $i]));
                    $_SESSION['formexamennfse'][NUM_PAGE - 1]["lib" . $i] = trim(htmlspecialchars($_POST["lib" . $i]));
                    $_SESSION['formexamennfse'][NUM_PAGE - 1]["code" . $i] = trim(htmlspecialchars($_POST["code" . $i]));
                    $_SESSION['formexamennfse'][NUM_PAGE - 1]["min29" . $i] = trim(htmlspecialchars($_POST["min29" . $i]));
                    $_SESSION['formexamennfse'][NUM_PAGE - 1]["max29" . $i] = trim(htmlspecialchars($_POST["max29" . $i]));
                    $_SESSION['formexamennfse'][NUM_PAGE - 1]["min6" . $i] = trim(htmlspecialchars($_POST["min6" . $i]));
                    $_SESSION['formexamennfse'][NUM_PAGE - 1]["max6" . $i] = trim(htmlspecialchars($_POST["max6" . $i]));
                    $_SESSION['formexamennfse'][NUM_PAGE - 1]["minf" . $i] = trim(htmlspecialchars($_POST["minf" . $i]));
                    $_SESSION['formexamennfse'][NUM_PAGE - 1]["maxf" . $i] = trim(htmlspecialchars($_POST["maxf" . $i]));
                    $_SESSION['formexamennfse'][NUM_PAGE - 1]["minh" . $i] = trim(htmlspecialchars($_POST["minh" . $i]));
                    $_SESSION['formexamennfse'][NUM_PAGE - 1]["maxh" . $i] = trim(htmlspecialchars($_POST["maxh" . $i]));
                    $_SESSION['formexamennfse'][NUM_PAGE - 1]["valeur" . $i] = trim(htmlspecialchars($_POST["valeur" . $i]));
                }
            }
            if ((isset($erreur)) && ($erreur)) {
                $pag = 'hopitalpages/hopitalpatient/hopitalexamen/hopitalnfs/hopitalediter/edit_examen';
                $stag = 1;
                die('<meta http-equiv="refresh" content="3; URL=' . $url . '?page=' . base64_encode($pag) . '&idexamenpatient=' . $idmc . '">');
            } else {
                require('hopitalpages/hopitalpatient/hopitalexamen/hopitalnfs/hopitalediter/form_terminer.php');
                break;
            }

        case 1:
        default:
            // Valeurs par défaut
            if (empty($_SESSION['formexamennfse'][NUM_PAGE])) {

                $_SESSION['formexamennfse'][NUM_PAGE] = array(
                    'idnfs' => $_REQUEST["idnfs"],
                    'idexamenpatient' => $rownfe["idexamenpatient"],
                    'laboratoire' => $rowe["idlaboratoire"],
                    'orientation' => $row["orientationexamenpatient"],
                    'prelevement' => $row["dateprelevementexamenpatient"],
                    'prescription' => $row["prescriptionexamenpatient"],
                    'interpretation' => $rownfe["interpretationnfs"],
                    'tligne[]' => array()
                );
                $tabens = array();

                $i = 0;
                $en = 0;
                $rsltens = $con->query("select * from hp_ligne_nfs where etatlignenfs=true") or die(mysqli_error($con));
                while ($rec = mysqli_fetch_assoc($rsltens)) {
                    $reqmc = $con->query("select * from hp_detail_nfs as n where n.idnfs='" . $idmc . "' "
                            . "and n.idlignenfs='" . $rec["idlignenfs"] . "' ") or die(mysqli_error($con));
                    $nbmc = mysqli_num_rows($reqmc);
                    $vale = '';
                    if ($nbmc != 0) {
                        $rowmc1 = mysqli_fetch_assoc($reqmc);
                        $vale = $rowmc1["valeurdetailnfs"];
                        $tabens[$en] = $i;
                        $en = $en + 1;
                    }
                    $_SESSION['formexamennfse'][NUM_PAGE]["idlignenfs" . $i] = $rec["idlignenfs"];
                    $_SESSION['formexamennfse'][NUM_PAGE]["lib" . $i] = $rec["libellelignenfs"];
                    $_SESSION['formexamennfse'][NUM_PAGE]["code" . $i] = $rec["codelignenfs"];
                    $_SESSION['formexamennfse'][NUM_PAGE]["min29" . $i] = $rec["29jourminlignenfs"];
                    $_SESSION['formexamennfse'][NUM_PAGE]["max29" . $i] = $rec["29jourmaxlignenfs"];
                    $_SESSION['formexamennfse'][NUM_PAGE]["min6" . $i] = $rec["6anminlignenfs"];
                    $_SESSION['formexamennfse'][NUM_PAGE]["max6" . $i] = $rec["6anmaxlignenfs"];
                    $_SESSION['formexamennfse'][NUM_PAGE]["minf" . $i] = $rec["adultefemmeminlignenfs"];
                    $_SESSION['formexamennfse'][NUM_PAGE]["maxf" . $i] = $rec["adultefemmemaxlignenfs"];
                    $_SESSION['formexamennfse'][NUM_PAGE]["minh" . $i] = $rec["adultehommeminlignenfs"];
                    $_SESSION['formexamennfse'][NUM_PAGE]["maxh" . $i] = $rec["adultehommemaxlignenfs"];
                    $_SESSION['formexamennfse'][NUM_PAGE]["valeur" . $i] = $vale;

                    $i = $i + 1;
                }

                $_SESSION['formexamennfse'][NUM_PAGE]["nbexamen"] = $i;
                $_SESSION['formexamennfse'][NUM_PAGE]["tligne[]"] = $tabens;
            } else if (($_SESSION['formexamennfse'][NUM_PAGE]["idnfs"]) != $_REQUEST["idnfs"]) {

                $_SESSION['formexamennfse'][NUM_PAGE] = array(
                    'idnfs' => $_REQUEST["idnfs"],
                    'idexamenpatient' => $rownfe["idexamenpatient"],
                    'laboratoire' => $rowe["idlaboratoire"],
                    'orientation' => $row["orientationexamenpatient"],
                    'prelevement' => $row["dateprelevementexamenpatient"],
                    'prescription' => $row["prescriptionexamenpatient"],
                    'interpretation' => $rownfe["interpretationnfs"],
                    'tligne[]' => array()
                );
                $tabens = array();

                $i = 0;
                $en = 0;
                $rsltens = $con->query("select * from hp_ligne_nfs where etatlignenfs=true") or die(mysqli_error($con));
                while ($rec = mysqli_fetch_assoc($rsltens)) {
                    $reqmc = $con->query("select * from hp_detail_nfs as n where n.idnfs='" . $idmc . "' "
                            . "and n.idlignenfs='" . $rec["idlignenfs"] . "' ") or die(mysqli_error($con));
                    $nbmc = mysqli_num_rows($reqmc);
                    $vale = '';
                    if ($nbmc != 0) {
                        $rowmc1 = mysqli_fetch_assoc($reqmc);
                        $vale = $rowmc1["valeurdetailnfs"];
                        $tabens[$en] = $i;
                        $en = $en + 1;
                    }
                    $_SESSION['formexamennfse'][NUM_PAGE]["idlignenfs" . $i] = $rec["idlignenfs"];
                    $_SESSION['formexamennfse'][NUM_PAGE]["lib" . $i] = $rec["libellelignenfs"];
                    $_SESSION['formexamennfse'][NUM_PAGE]["code" . $i] = $rec["codelignenfs"];
                    $_SESSION['formexamennfse'][NUM_PAGE]["min29" . $i] = $rec["29jourminlignenfs"];
                    $_SESSION['formexamennfse'][NUM_PAGE]["max29" . $i] = $rec["29jourmaxlignenfs"];
                    $_SESSION['formexamennfse'][NUM_PAGE]["min6" . $i] = $rec["6anminlignenfs"];
                    $_SESSION['formexamennfse'][NUM_PAGE]["max6" . $i] = $rec["6anmaxlignenfs"];
                    $_SESSION['formexamennfse'][NUM_PAGE]["minf" . $i] = $rec["adultefemmeminlignenfs"];
                    $_SESSION['formexamennfse'][NUM_PAGE]["maxf" . $i] = $rec["adultefemmemaxlignenfs"];
                    $_SESSION['formexamennfse'][NUM_PAGE]["minh" . $i] = $rec["adultehommeminlignenfs"];
                    $_SESSION['formexamennfse'][NUM_PAGE]["maxh" . $i] = $rec["adultehommemaxlignenfs"];
                    $_SESSION['formexamennfse'][NUM_PAGE]["valeur" . $i] = $vale;

                    $i = $i + 1;
                }

                $_SESSION['formexamennfse'][NUM_PAGE]["nbexamen"] = $i;
                $_SESSION['formexamennfse'][NUM_PAGE]["tligne[]"] = $tabens;
            }
            require('hopitalpages/hopitalpatient/hopitalexamen/hopitalnfs/hopitalediter/form_editer_examen.php');
            break;
    }
}