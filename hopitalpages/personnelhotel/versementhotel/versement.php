<?php

if (isset($_REQUEST["personnel"])) {
    
// Récupération du numéro de l'étape en cours
    if (empty($_GET['pagevoy']) or ! is_numeric($_GET['pagevoy'])) {
        define('NUM_PAGE', 1);
    } else {
        // En situation réelle, il faudrait vérifier l'existence de cette page
        define('NUM_PAGE', intval($_GET['pagevoy']));
    }

// Déclaration de la variable de session
    if (empty($_SESSION['formvoy'])) {
        $_SESSION['formvoy'] = array();
    }

    switch (NUM_PAGE) {

        case 3:

            require('hotelpages/personnelhotel/versementhotel/traite_ajouter_versement.php');
            break;
        case 2:

            // Récupération des informations du formulaire précédent
            if (!empty($_POST)) {
                $_SESSION['formvoy'][NUM_PAGE - 1] = array(
                    'personnel' => $_REQUEST["personnel"],
                    'montant' => $_POST['montant']
                );
            }

            require('hotelpages/personnelhotel/versementhotel/form_confirme_versement.php');
            break;

        case 1:
        default:
            // Valeurs par défaut
            if (empty($_SESSION['formvoy'][NUM_PAGE])) {
                $_SESSION['formvoy'][NUM_PAGE] = array(
                    'personnel' => $_REQUEST["personnel"],
                    'montant' => ''
                );
            } else if (($_SESSION['formvoy'][1]['personnel'] != $_REQUEST["personnel"])) {
                $_SESSION['formvoy'][NUM_PAGE] = array(
                    'personnel' => $_REQUEST["personnel"],
                    'montant' => ''
                );
            }

            require('hotelpages/personnelhotel/versementhotel/form_ajouter_versement.php');
            break;
    }
}