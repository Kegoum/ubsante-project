<?php

// Récupération du numéro de l'étape en cours
if (empty($_GET['pagecom']) or ! is_numeric($_GET['pagecom'])) {
    define('NUM_PAGE', 1);
} else {
    // En situation réelle, il faudrait vérifier l'existence de cette page
    define('NUM_PAGE', intval($_GET['pagecom']));
}

// Déclaration de la variable de session
if (empty($_SESSION['formchambre'])) {
    $_SESSION['formchambre'] = array();
}

switch (NUM_PAGE) {

    case 2:
        // Récupération des informations du formulaire précédent
        if (!empty($_POST)) {
            $_SESSION['formchambre'][NUM_PAGE - 1] = array(
                'categorie' => trim(htmlspecialchars($_POST["categorie"])),
                'code' => strtoupper(trim(htmlspecialchars($_POST["code"]))),
                'chambre' => ucwords(trim(htmlspecialchars($_POST["chambre"]))),
                'place' => ucwords(trim(htmlspecialchars($_POST["place"])))
            );
        }
        require('hopitalpages/hopitalparametre/hopitalchambre/hopitalajouter/form_terminer.php');
        break;

    case 1:
    default:
        // Valeurs par défaut
        if (empty($_SESSION['formchambre'][NUM_PAGE])) {

            $_SESSION['formchambre'][NUM_PAGE] = array(
                'categorie' => '',
                'code' => '',
                'chambre' => '',
                'place' => ''
            );
        }
        require('hopitalpages/hopitalparametre/hopitalchambre/hopitalajouter/form_ajouter_chambre.php');
        break;
}