<?php

if (isset($_REQUEST["client"])) {
    
// Récupération du numéro de l'étape en cours
    if (empty($_GET['pageverp']) or ! is_numeric($_GET['pageverp'])) {
        define('NUM_PAGE', 1);
    } else {
        // En situation réelle, il faudrait vérifier l'existence de cette page
        define('NUM_PAGE', intval($_GET['pageverp']));
    }

// Déclaration de la variable de session
    if (empty($_SESSION['formvoyp'])) {
        $_SESSION['formvoyp'] = array();
    }

    switch (NUM_PAGE) {

        case 3:

            require('hotelpages/clienthotel/dossierclienthotel/traite_ajouter_versement_p.php');
            break;
        case 2:

            // Récupération des informations du formulaire précédent
            if (!empty($_POST)) {
                $_SESSION['formvoyp'][NUM_PAGE - 1] = array(
                    'client' => $_REQUEST["client"],
                    'montant' => $_POST['montant']
                );
            }

            require('hotelpages/clienthotel/dossierclienthotel/form_confirme_versement_p.php');
            break;

        case 1:
        default:
            // Valeurs par défaut
            if (empty($_SESSION['formvoyp'][NUM_PAGE])) {
                $_SESSION['formvoyp'][NUM_PAGE] = array(
                    'client' => $_REQUEST["client"],
                    'montant' => ''
                );
            } else if (($_SESSION['formvoyp'][1]['client'] != $_REQUEST["client"])) {
                $_SESSION['formvoyp'][NUM_PAGE] = array(
                    'client' => $_REQUEST["client"],
                    'montant' => ''
                );
            }

            require('hotelpages/clienthotel/dossierclienthotel/form_ajouter_versement_p.php');
            break;
    }
}