<?php

// Récupération du numéro de l'étape en cours
if (empty($_GET['pagecom']) or ! is_numeric($_GET['pagecom'])) {
    define('NUM_PAGE', 1);
} else {
    // En situation réelle, il faudrait vérifier l'existence de cette page
    define('NUM_PAGE', intval($_GET['pagecom']));
}

// Déclaration de la variable de session
if (empty($_SESSION['formdepartement'])) {
    $_SESSION['formdepartement'] = array();
}

if (empty($_SESSION['formdepartement'])) {
    $_SESSION['formdepartement'] = array();
}

switch (NUM_PAGE) {

    case 2:
        // Récupération des informations du formulaire précédent
        if (!empty($_POST)) {
            $_SESSION['formdepartement'][NUM_PAGE - 1] = array(
                'region' => trim(htmlspecialchars($_POST["region"])),
                'departement' => ucwords(trim(htmlspecialchars($_POST["departement"]))),
                'cheflieu' => ucwords(trim(htmlspecialchars($_POST["cheflieu"])))
            );
        }
        require('hopitalpages/hopitalparametre/hopitaldepartement/hopitalajouter/form_terminer.php');
        break;

    case 1:
    default:
        // Valeurs par défaut
        if (empty($_SESSION['formdepartement'][NUM_PAGE])) {

            $_SESSION['formdepartement'][NUM_PAGE] = array(
                'region' => '',
                'departement' => '',
                'cheflieu' => ''
            );
        }
        require('hopitalpages/hopitalparametre/hopitaldepartement/hopitalajouter/form_ajouter_departement.php');
        break;
}