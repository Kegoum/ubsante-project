<?php

// Récupération du numéro de l'étape en cours
if (empty($_GET['pagecom']) or ! is_numeric($_GET['pagecom'])) {
    define('NUM_PAGE', 1);
} else {
    // En situation réelle, il faudrait vérifier l'existence de cette page
    define('NUM_PAGE', intval($_GET['pagecom']));
}

// Déclaration de la variable de session
if (empty($_SESSION['formcategoriechambre'])) {
    $_SESSION['formcategoriechambre'] = array();
}

switch (NUM_PAGE) {

    case 2:
        // Récupération des informations du formulaire précédent
        if (!empty($_POST)) {
            $_SESSION['formcategoriechambre'][NUM_PAGE - 1] = array(
                'libelle' => ucwords(trim(htmlspecialchars($_POST["libelle"]))),
                'prix' => trim(htmlspecialchars($_POST["prix"]))
            );
        }
        require('hopitalpages/hopitalparametre/hopitalchambre/hopitalcategoriechambre/hopitalajouter/form_terminer.php');
        break;

    case 1:
    default:
        // Valeurs par défaut
        if (empty($_SESSION['formcategoriechambre'][NUM_PAGE])) {

            $_SESSION['formcategoriechambre'][NUM_PAGE] = array(
                'libelle' => '',
                'prix' => ''
            );
        }
        require('hopitalpages/hopitalparametre/hopitalchambre/hopitalcategoriechambre/hopitalajouter/form_ajouter_categoriechambre.php');
        break;
}