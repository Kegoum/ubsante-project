<?php

if ((isset($_REQUEST["idpcv"]))) {
    $idmc = $_REQUEST["idpcv"];
    $reqre = $con->query("select * from hp_pcv as n left join hp_resultat_examen as r on n.idresultatexamen=r.idresultatexamen "
            . "where n.idpcv='" . $idmc . "' "
            . "") or die(mysqli_error($con));
    $rownfe = mysqli_fetch_array($reqre);
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
    if (empty($_SESSION['formexamenpcve'])) {
        $_SESSION['formexamenpcve'] = array();
    }

    if (empty($_SESSION['formexamenpcve'])) {
        $_SESSION['formexamenpcve'] = array();
        $_SESSION['formexamenpcve'][1] = array(
            'idpcv' => $_REQUEST["idpcv"],
            'idexamenpatient' => $rownfe["idexamenpatient"],
            'laboratoire' => $rowe["idlaboratoire"],
            'orientation' => $row["orientationexamenpatient"],
            'prelevement' => $row["dateprelevementexamenpatient"],
            'prescription' => $row["prescriptionexamenpatient"],
            'interpretation' => $rownfe["interpretationpcv"],
            'col' => $rownfe["aspectcolpcv"],
            'leucqte' => $rownfe["quantitepcv"],
            'leuccons' => $rownfe["consistancepcv"],
            'leucodeur' => $rownfe["odeurpcv"],
            'leuccouleur' => $rownfe["couleurpcv"],
            'etattv' => $rownfe["trichomonaspcv"],
            'etatlev' => $rownfe["levurespcv"],
            'etatleuc' => $rownfe["leucocytepcv"],
            'etathema' => $rownfe["hematiepcv"],
            'etatcc' => $rownfe["cluepcv"],
            'etatce' => $rownfe["cellulepcv"],
            'colorcgn' => $rownfe["coccinegatifpcv"],
            'colorcgp' => $rownfe["coccipositifpcv"],
            'colorbgn' => $rownfe["bacillesnegatifpcv"],
            'colorbgp' => $rownfe["bacillespositifpcv"],
            'flore' => $rownfe["typeflorepcv"]
        );
    }


    switch (NUM_PAGE) {

        case 2:
            // Récupération des informations du formulaire précédent
            if (!empty($_POST)) {
                $erreur = FALSE;

                $_SESSION['formexamenpcve'][NUM_PAGE - 1] = array(
                    'idpcv' => $_REQUEST["idpcv"],
                    'idexamenpatient' => $rownfe["idexamenpatient"],
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
                $pag = 'hopitalpages/hopitalpatient/hopitalexamen/hopitalpcv/hopitalediter/edit_examen';
                $stag = 1;
                die('<meta http-equiv="refresh" content="3; URL=' . $url . '?page=' . base64_encode($pag) . '&idexamenpatient=' . $idmc . '">');
            } else {
                require('hopitalpages/hopitalpatient/hopitalexamen/hopitalpcv/hopitalediter/form_terminer.php');
                break;
            }

        case 1:
        default:
            // Valeurs par défaut
            if (empty($_SESSION['formexamenpcve'][NUM_PAGE])) {

                $_SESSION['formexamenpcve'][NUM_PAGE] = array(
                    'idpcv' => $_REQUEST["idpcv"],
                    'idexamenpatient' => $rownfe["idexamenpatient"],
                    'laboratoire' => $rowe["idlaboratoire"],
                    'orientation' => $row["orientationexamenpatient"],
                    'prelevement' => $row["dateprelevementexamenpatient"],
                    'prescription' => $row["prescriptionexamenpatient"],
                    'interpretation' => $rownfe["interpretationpcv"],
                    'col' => $rownfe["aspectcolpcv"],
                    'leucqte' => $rownfe["quantitepcv"],
                    'leuccons' => $rownfe["consistancepcv"],
                    'leucodeur' => $rownfe["odeurpcv"],
                    'leuccouleur' => $rownfe["couleurpcv"],
                    'etattv' => $rownfe["trichomonaspcv"],
                    'etatlev' => $rownfe["levurespcv"],
                    'etatleuc' => $rownfe["leucocytepcv"],
                    'etathema' => $rownfe["hematiepcv"],
                    'etatcc' => $rownfe["cluepcv"],
                    'etatce' => $rownfe["cellulepcv"],
                    'colorcgn' => $rownfe["coccinegatifpcv"],
                    'colorcgp' => $rownfe["coccipositifpcv"],
                    'colorbgn' => $rownfe["bacillesnegatifpcv"],
                    'colorbgp' => $rownfe["bacillespositifpcv"],
                    'flore' => $rownfe["typeflorepcv"]
                );
            } else if (($_SESSION['formexamenpcve'][NUM_PAGE]["idpcv"]) != $_REQUEST["idpcv"]) {

                $_SESSION['formexamenpcve'][NUM_PAGE] = array(
                    'idpcv' => $_REQUEST["idpcv"],
                    'idexamenpatient' => $rownfe["idexamenpatient"],
                    'laboratoire' => $rowe["idlaboratoire"],
                    'orientation' => $row["orientationexamenpatient"],
                    'prelevement' => $row["dateprelevementexamenpatient"],
                    'prescription' => $row["prescriptionexamenpatient"],
                    'interpretation' => $rownfe["interpretationpcv"],
                    'col' => $rownfe["aspectcolpcv"],
                    'leucqte' => $rownfe["quantitepcv"],
                    'leuccons' => $rownfe["consistancepcv"],
                    'leucodeur' => $rownfe["odeurpcv"],
                    'leuccouleur' => $rownfe["couleurpcv"],
                    'etattv' => $rownfe["trichomonaspcv"],
                    'etatlev' => $rownfe["levurespcv"],
                    'etatleuc' => $rownfe["leucocytepcv"],
                    'etathema' => $rownfe["hematiepcv"],
                    'etatcc' => $rownfe["cluepcv"],
                    'etatce' => $rownfe["cellulepcv"],
                    'colorcgn' => $rownfe["coccinegatifpcv"],
                    'colorcgp' => $rownfe["coccipositifpcv"],
                    'colorbgn' => $rownfe["bacillesnegatifpcv"],
                    'colorbgp' => $rownfe["bacillespositifpcv"],
                    'flore' => $rownfe["typeflorepcv"]
                );
            }
            require('hopitalpages/hopitalpatient/hopitalexamen/hopitalpcv/hopitalediter/form_editer_examen.php');
            break;
    }
}