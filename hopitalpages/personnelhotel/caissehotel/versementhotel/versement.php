<?php
  
// Récupération du numéro de l'étape en cours
    if (empty($_GET['pageversautre']) or ! is_numeric($_GET['pageversautre'])) {
        define('NUM_PAGE', 1);
    } else {
        // En situation réelle, il faudrait vérifier l'existence de cette page
        define('NUM_PAGE', intval($_GET['pageversautre']));
    }

// Déclaration de la variable de session
    if (empty($_SESSION['formversautre'])) {
        $_SESSION['formversautre'] = array();
    }

    switch (NUM_PAGE) {

        case 3:

            require('hotelpages/personnelhotel/caissehotel/versementhotel/traite_ajouter_versement.php');
            break;
        case 2:

            // Récupération des informations du formulaire précédent
            if (!empty($_POST)) {
                $_SESSION['formversautre'][NUM_PAGE - 1] = array(
                    'but' => trim(htmlspecialchars($_POST['but'])),
                    'montant' => trim(htmlspecialchars($_POST['montant']))
                );
            }

            require('hotelpages/personnelhotel/caissehotel/versementhotel/form_confirme_versement.php');
            break;

        case 1:
        default:
            // Valeurs par défaut
            if (empty($_SESSION['formversautre'][NUM_PAGE])) {
                $_SESSION['formversautre'][NUM_PAGE] = array(
                    'but' => '',
                    'montant' => ''
                );
            }

            require('hotelpages/personnelhotel/caissehotel/versementhotel/form_ajouter_versement.php');
            break;
    }