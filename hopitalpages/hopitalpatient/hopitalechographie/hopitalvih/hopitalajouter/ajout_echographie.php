<?php

if ((isset($_REQUEST["idechographiepatient"]))) {
    $idmc = $_REQUEST["idechographiepatient"];

    $req_fin = $con->query("select * from hp_echographie_patient as ep left join hp_sous_dossier as sd on "
            . "ep.idsousdossier=sd.idsousdossier left join hp_dossier as d on sd.iddossier=d.iddossier "
            . "left join hp_patient as p on d.idpatient=p.idpatient left join hp_departement as dp on "
            . "p.residencepatient=dp.iddepartement where ep.idechographiepatient='" . $idmc . "'") or die(mysqli_error($con));
    $row = mysqli_fetch_assoc($req_fin);
    $req_fine = $con->query("select * from hp_echographie as e left join hp_laboratoire as l on e.idlaboratoire=l.idlaboratoire "
            . "left join hp_service as s on l.idservice=s.idservice left join hp_unite as u on e.idunite=u.idunite "
            . "where e.idechographie='" . $row["idechographie"] . "'") or die(mysqli_error($con));
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
    if (empty($_SESSION['formechographievih'])) {
        $_SESSION['formechographievih'] = array();
    }

    if (empty($_SESSION['formechographievih'])) {
        $_SESSION['formechographievih'] = array();
        $_SESSION['formechographievih'][1] = array(
            'idechographiepatient' => $_REQUEST["idechographiepatient"],
            'laboratoire' => $rowe["idlaboratoire"],
            'orientation' => $row["orientationechographiepatient"],
            'prelevement' => $row["dateprelevementechographiepatient"],
            'prescription' => $row["prescriptionechographiepatient"],
            'interpretation' => "Un résultat négatif signifie que vous n'êtes pas entrés en contact avec le virus du SIDA "
            . "ou au contraire que votre contamination est très récente pour être détectable car votre organisme met environ "
            . "03 mois pour synthétiser les anticorps dirigés contre le virus. Veuillez faire un autre echographie de contrôle dans "
            . "03 mois si vous avez eu un contactnrécent",
                    'methode' => '',
                    'resultat' => ''
        );

    }


    switch (NUM_PAGE) {

        case 2:
            // Récupération des informations du formulaire précédent
            if (!empty($_POST)) {
                $erreur = FALSE;

                $_SESSION['formechographievih'][NUM_PAGE - 1] = array(
                    'idechographiepatient' => $_REQUEST["idechographiepatient"],
                    'laboratoire' => trim(htmlspecialchars($_POST["laboratoire"])),
                    'orientation' => trim(htmlspecialchars($_POST["orientation"])),
                    'prelevement' => trim(htmlspecialchars($_POST["prelevement"])),
                    'prescription' => trim(htmlspecialchars($_POST["prescription"])),
                    'interpretation' => trim(htmlspecialchars($_POST["interpretation"])),
                    'methode' => trim(htmlspecialchars($_POST["methode"])),
                    'resultat' => floatval(trim(htmlspecialchars($_POST["resultat"])))
                );

                
            }
            if ((isset($erreur)) && ($erreur)) {
                $pag = 'hopitalpages/hopitalpatient/hopitalechographie/hopitalvih/hopitalajouter/ajout_echographie';
                $stag = 1;
                die('<meta http-equiv="refresh" content="3; URL=' . $url . '?page=' . base64_encode($pag) . '&idechographiepatient=' . $idmc . '">');
            } else {
                require('hopitalpages/hopitalpatient/hopitalechographie/hopitalvih/hopitalajouter/form_terminer.php');
                break;
            }

        case 1:
        default:
            // Valeurs par défaut
            if (empty($_SESSION['formechographievih'][NUM_PAGE])) {

                $_SESSION['formechographievih'][NUM_PAGE] = array(
                    'idechographiepatient' => $_REQUEST["idechographiepatient"],
                    'laboratoire' => $rowe["idlaboratoire"],
                    'orientation' => $row["orientationechographiepatient"],
                    'prelevement' => $row["dateprelevementechographiepatient"],
                    'prescription' => $row["prescriptionechographiepatient"],
                    'interpretation' => '',
                    'methode' => '',
                    'resultat' => ''
                );

                
            } else if (($_SESSION['formechographievih'][NUM_PAGE]["idechographiepatient"]) != $_REQUEST["idechographiepatient"]) {

                $_SESSION['formechographievih'][NUM_PAGE] = array(
                    'idechographiepatient' => $_REQUEST["idechographiepatient"],
                    'laboratoire' => $rowe["idlaboratoire"],
                    'orientation' => $row["orientationechographiepatient"],
                    'prelevement' => $row["dateprelevementechographiepatient"],
                    'prescription' => $row["prescriptionechographiepatient"],
                    'interpretation' => '',
                    'methode' => '',
                    'resultat' => ''
                );

            }
            require('hopitalpages/hopitalpatient/hopitalechographie/hopitalvih/hopitalajouter/form_ajouter_echographie.php');
            break;
    }
}