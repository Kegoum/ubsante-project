<?php

// Récupération du numéro de l'étape en cours
    if (empty($_GET['pagevoy']) or ! is_numeric($_GET['pagevoy'])) {
        define('NUM_PAGE', 1);
    } else {
        // En situation réelle, il faudrait vérifier l'existence de cette page
        define('NUM_PAGE', intval($_GET['pagevoy']));
    }

// Déclaration de la variable de session
    if (empty($_SESSION['formdecaisse'])) {
        $_SESSION['formdecaisse'] = array();
    }

    switch (NUM_PAGE) {

        case 3:

            require('hotelpages/personnelhotel/caissehotel/traite_decaissement.php');
            break;
        case 2:

            // Récupération des informations du formulaire précédent
            if (!empty($_POST)) {
                $_SESSION['formdecaisse'][NUM_PAGE - 1] = array(
                    'montant' => trim(stripcslashes($_POST['montant'])),
                    'but' => trim(stripcslashes($_POST['but'])),
                    'personneld' => trim(stripcslashes($_POST['personneld'])),
                    'serviced' => trim(stripcslashes($_POST['serviced']))
                );
            }

            require('hotelpages/personnelhotel/caissehotel/form_confirme_decaissement.php');
            break;

        case 1:
        default:
            // Valeurs par défaut
            if (empty($_SESSION['formdecaisse'][NUM_PAGE])) {
                $_SESSION['formdecaisse'][NUM_PAGE] = array(
                    'montant' => '',
                    'but' => '',
                    'personneld' => '',
                    'serviced' => ''
                );
            }

            require('hotelpages/personnelhotel/caissehotel/form_decaissement.php');
            break;
    }