<?php

if ((isset($_REQUEST["idcoprologieparasitaire"]))) {
    $idmc = $_REQUEST["idcoprologieparasitaire"];
    $reqr = $con->query("select * from hp_coprologie_parasitaire as n left join hp_resultat_examen as r on n.idresultatexamen=r.idresultatexamen "
            . "where n.idcoprologieparasitaire='" . $idmc . "' "
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
    if (empty($_SESSION['formexamencoprologie_parasitairee'])) {
        $_SESSION['formexamencoprologie_parasitairee'] = array();
    }

    if (empty($_SESSION['formexamencoprologie_parasitairee'])) {
        $_SESSION['formexamencoprologie_parasitairee'] = array();
        $_SESSION['formexamencoprologie_parasitairee'][1] = array(
            'idcoprologieparasitaire' => $_REQUEST["idcoprologieparasitaire"],
            'idexamenpatient' => $rownfe["idexamenpatient"],
            'laboratoire' => $rowe["idlaboratoire"],
            'orientation' => $row["orientationexamenpatient"],
            'prelevement' => $row["dateprelevementexamenpatient"],
            'prescription' => $row["prescriptionexamenpatient"],
            'interpretation' => $rownfe["interpretationcoprologieparasitaire"],
            'glaire' => $rownfe["glairecoprologieparasitaire"],
            'cons' => $rownfe["consistancecoprologieparasitaire"],
            'odeur' => $rownfe["odeurcoprologieparasitaire"],
            'couleur' => $rownfe["couleurcoprologieparasitaire"],
            'sang' => $rownfe["sangcoprologieparasitaire"],
            'parasiteadulte' => $rownfe["parasiteadultecoprologieparasitaire"],
            'debris' => $rownfe["debrisalimentairecoprologieparasitaire"],
            'digestion' => $rownfe["digestioncoprologieparasitaire"],
            'etattv' => $rownfe["trichomonascoprologieparasitaire"],
            'etatlev' => $rownfe["levurescoprologieparasitaire"],
            'parasite' => $rownfe["parasitecoprologieparasitaire"],
            'leucocyte' => $rownfe["leucocytecoprologieparasitaire"],
            'hematie' => $rownfe["hematiecoprologieparasitaire"],
            'clue' => $rownfe["cluecoprologieparasitaire"],
            'cellule' => $rownfe["cellulecoprologieparasitaire"],
            'cristaux' => $rownfe["cristauxcoprologieparasitaire"]
        );
    }


    switch (NUM_PAGE) {

        case 2:
            // Récupération des informations du formulaire précédent
            if (!empty($_POST)) {
                $erreur = FALSE;

                $_SESSION['formexamencoprologie_parasitairee'][NUM_PAGE - 1] = array(
                    'idcoprologieparasitaire' => $_REQUEST["idcoprologieparasitaire"],
                    'idexamenpatient' => $rownfe["idexamenpatient"],
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
                $pag = 'hopitalpages/hopitalpatient/hopitalexamen/hopitalcoprologie_parasitaire/hopitalediter/edit_examen';
                $stag = 1;
                die('<meta http-equiv="refresh" content="3; URL=' . $url . '?page=' . base64_encode($pag) . '&idexamenpatient=' . $idmc . '">');
            } else {
                require('hopitalpages/hopitalpatient/hopitalexamen/hopitalcoprologie_parasitaire/hopitalediter/form_terminer.php');
                break;
            }

        case 1:
        default:
            // Valeurs par défaut
            if (empty($_SESSION['formexamencoprologie_parasitairee'][NUM_PAGE])) {

                $_SESSION['formexamencoprologie_parasitairee'][NUM_PAGE] = array(
                    'idcoprologieparasitaire' => $_REQUEST["idcoprologieparasitaire"],
                    'idexamenpatient' => $rownfe["idexamenpatient"],
                    'laboratoire' => $rowe["idlaboratoire"],
                    'orientation' => $row["orientationexamenpatient"],
                    'prelevement' => $row["dateprelevementexamenpatient"],
                    'prescription' => $row["prescriptionexamenpatient"],
            'interpretation' => $rownfe["interpretationcoprologieparasitaire"],
                    'glaire' => $rownfe["glairecoprologieparasitaire"],
                    'cons' => $rownfe["consistancecoprologieparasitaire"],
                    'odeur' => $rownfe["odeurcoprologieparasitaire"],
                    'couleur' => $rownfe["couleurcoprologieparasitaire"],
                    'sang' => $rownfe["sangcoprologieparasitaire"],
                    'parasiteadulte' => $rownfe["parasiteadultecoprologieparasitaire"],
                    'debris' => $rownfe["debrisalimentairecoprologieparasitaire"],
                    'digestion' => $rownfe["digestioncoprologieparasitaire"],
                    'etattv' => $rownfe["trichomonascoprologieparasitaire"],
                    'etatlev' => $rownfe["levurescoprologieparasitaire"],
                    'parasite' => $rownfe["parasitecoprologieparasitaire"],
                    'leucocyte' => $rownfe["leucocytecoprologieparasitaire"],
                    'hematie' => $rownfe["hematiecoprologieparasitaire"],
                    'clue' => $rownfe["cluecoprologieparasitaire"],
                    'cellule' => $rownfe["cellulecoprologieparasitaire"],
                    'cristaux' => $rownfe["cristauxcoprologieparasitaire"]
                );
            } else if (($_SESSION['formexamencoprologie_parasitairee'][NUM_PAGE]["idcoprologieparasitaire"]) != $_REQUEST["idcoprologieparasitaire"]) {

                $_SESSION['formexamencoprologie_parasitairee'][NUM_PAGE] = array(
                    'idcoprologieparasitaire' => $_REQUEST["idcoprologieparasitaire"],
                    'idexamenpatient' => $rownfe["idexamenpatient"],
                    'laboratoire' => $rowe["idlaboratoire"],
                    'orientation' => $row["orientationexamenpatient"],
                    'prelevement' => $row["dateprelevementexamenpatient"],
                    'prescription' => $row["prescriptionexamenpatient"],
            'interpretation' => $rownfe["interpretationcoprologieparasitaire"],
                    'glaire' => $rownfe["glairecoprologieparasitaire"],
                    'cons' => $rownfe["consistancecoprologieparasitaire"],
                    'odeur' => $rownfe["odeurcoprologieparasitaire"],
                    'couleur' => $rownfe["couleurcoprologieparasitaire"],
                    'sang' => $rownfe["sangcoprologieparasitaire"],
                    'parasiteadulte' => $rownfe["parasiteadultecoprologieparasitaire"],
                    'debris' => $rownfe["debrisalimentairecoprologieparasitaire"],
                    'digestion' => $rownfe["digestioncoprologieparasitaire"],
                    'etattv' => $rownfe["trichomonascoprologieparasitaire"],
                    'etatlev' => $rownfe["levurescoprologieparasitaire"],
                    'parasite' => $rownfe["parasitecoprologieparasitaire"],
                    'leucocyte' => $rownfe["leucocytecoprologieparasitaire"],
                    'hematie' => $rownfe["hematiecoprologieparasitaire"],
                    'clue' => $rownfe["cluecoprologieparasitaire"],
                    'cellule' => $rownfe["cellulecoprologieparasitaire"],
                    'cristaux' => $rownfe["cristauxcoprologieparasitaire"]
                );
            }
            require('hopitalpages/hopitalpatient/hopitalexamen/hopitalcoprologie_parasitaire/hopitalediter/form_editer_examen.php');
            break;
    }
}