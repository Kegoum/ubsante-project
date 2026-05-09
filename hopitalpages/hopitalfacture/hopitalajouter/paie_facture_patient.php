<?php

if (isset($_REQUEST["idfacture"])) {
    $id = $_REQUEST["idfacture"];
    $req_fin = $con->query("select * from hp_facture as f where f.idfacture='" . $id . "'") or die(mysqli_error($con));
    $row = mysqli_fetch_assoc($req_fin);
    $versement = $row["avancefacture"];
    $mrest = $row["montantfacture"] - $versement;
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
    if (empty($_SESSION['formfacture'])) {
        $_SESSION['formfacture'] = array();
    }

    if (empty($_SESSION['formfacture'])) {
        $_SESSION['formfacture'] = array();
        $_SESSION['formfacture'][1] = array(
            'idfacture' => $_REQUEST["idfacture"],
            'versa' => $versement,
            'montvers' => '',
            'montt' => $row["montantfacture"],
            'reste' => $mrest,
            'datejour' => '',
            'paiement' => ''
        );
    }


    switch (NUM_PAGE) {

        case 2:
            // Récupération des informations du formulaire précédent
            if (!empty($_POST)) {
                $erreurprod = FALSE;

                $_SESSION['formfacture'][NUM_PAGE - 1] = array(
                    'idfacture' => $_REQUEST["idfacture"],
                    'montvers' => trim(htmlspecialchars($_POST["montvers"])),
                    'versa' => trim(htmlspecialchars($_POST["versa"])),
                    'montt' => trim(htmlspecialchars($_POST["montt"])),
                    'reste' => trim(htmlspecialchars($_POST["reste"])),
                    'paiement' => trim(htmlspecialchars($_POST["paiement"])),
                    'datejour' => trim(htmlspecialchars($_POST["datejour"]))
                );
            }
            if ((isset($erreurprod)) && ($erreurprod)) {
                $pag = 'hopitalpages/hopitalfacture/hopitalajouter/paie_facture_patient';
                $stag = 1;
                die('<meta http-equiv="refresh" content="0; URL=' . $url . '?page=' . base64_encode($pag) . '&pagecom=' . $stag . '">');
            } else {
                require('hopitalpages/hopitalfacture/hopitalajouter/form_terminer.php');
                break;
            }

        case 1:
        default:
            // Valeurs par défaut
            if (empty($_SESSION['formfacture'][NUM_PAGE])) {

                $_SESSION['formfacture'][NUM_PAGE] = array(
                    'idfacture' => $_REQUEST["idfacture"],
                    'versa' => $versement,
                    'montvers' => '',
                    'montt' => $row["montantfacture"],
                    'reste' => $mrest,
                    'datejour' => '',
                    'paiement' => ''
                );
            } else if (($_SESSION['formfacture'][NUM_PAGE]["idfacture"]) != $_REQUEST["idfacture"]) {

                $_SESSION['formfacture'][NUM_PAGE] = array(
                    'idfacture' => $_REQUEST["idfacture"],
                    'versa' => $versement,
                    'montvers' => '',
                    'montt' => $row["montantfacture"],
                    'reste' => $mrest,
                    'datejour' => '',
                    'paiement' => ''
                );
            }
            require('hopitalpages/hopitalfacture/hopitalajouter/form_paie_facture_patient.php');
            break;
    }
}