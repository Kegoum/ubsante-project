<?php

// Récupération du numéro de l'étape en cours
if (empty($_GET['pagecom']) or ! is_numeric($_GET['pagecom'])) {
    define('NUM_PAGE', 1);
} else {
    // En situation réelle, il faudrait vérifier l'existence de cette page
    define('NUM_PAGE', intval($_GET['pagecom']));
}

// Déclaration de la variable de session
if (empty($_SESSION['formlaboratoire'])) {
    $_SESSION['formlaboratoire'] = array();
}

if (empty($_SESSION['formlaboratoire'])) {
    $_SESSION['formlaboratoire'] = array();
}

switch (NUM_PAGE) {

    case 2:
        // Récupération des informations du formulaire précédent
        if (!empty($_POST)) {

            $_SESSION['formlaboratoire'][NUM_PAGE - 1] = array(
                'service' => strtoupper(trim(htmlspecialchars($_POST["service"]))),
                'codep' => strtoupper(trim(htmlspecialchars($_POST["codep"]))),
                'laboratoire' => ucwords(trim(htmlspecialchars($_POST["laboratoire"]))),
                'but' => (trim(htmlspecialchars($_POST["but"])))
            );
        }
        require('hopitalpages/hopitalparametre/hopitallaboratoire/hopitalajouter/form_terminer.php');
        break;

    case 1:
    default:
        // Valeurs par défaut
        if (empty($_SESSION['formlaboratoire'][NUM_PAGE])) {

            $_SESSION['formlaboratoire'][NUM_PAGE] = array(
                'service' => '',
                'codep' => '',
                'laboratoire' => '',
                'but' => ''
            );
        }
        require('hopitalpages/hopitalparametre/hopitallaboratoire/hopitalajouter/form_ajouter_laboratoire.php');
        break;
}
        