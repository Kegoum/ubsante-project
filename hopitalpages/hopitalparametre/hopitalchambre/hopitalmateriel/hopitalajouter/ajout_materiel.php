<?php

// Récupération du numéro de l'étape en cours
if (empty($_GET['pagecom']) or ! is_numeric($_GET['pagecom'])) {
    define('NUM_PAGE', 1);
} else {
    // En situation réelle, il faudrait vérifier l'existence de cette page
    define('NUM_PAGE', intval($_GET['pagecom']));
}

// Déclaration de la variable de session
if (empty($_SESSION['formmateriel'])) {
    $_SESSION['formmateriel'] = array();
}

switch (NUM_PAGE) {

    case 2:
        // Récupération des informations du formulaire précédent
        if (!empty($_POST)) {
            $_SESSION['formmateriel'][NUM_PAGE - 1] = array(
                'libelle' => ucwords(trim(htmlspecialchars($_POST["libelle"]))),
                'type' => trim(htmlspecialchars($_POST["type"]))
            );
        }
        require('hopitalpages/hopitalparametre/hopitalchambre/hopitalmateriel/hopitalajouter/form_terminer.php');
        break;

    case 1:
    default:
        // Valeurs par défaut
        if (empty($_SESSION['formmateriel'][NUM_PAGE])) {

            $_SESSION['formmateriel'][NUM_PAGE] = array(
                'libelle' => '',
                'type' => ''
            );
        }
        require('hopitalpages/hopitalparametre/hopitalchambre/hopitalmateriel/hopitalajouter/form_ajouter_materiel.php');
        break;
}