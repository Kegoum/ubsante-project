<?php

// Récupération du numéro de l'étape en cours
if (empty($_GET['pagecom']) or ! is_numeric($_GET['pagecom'])) {
    define('NUM_PAGE', 1);
} else {
    // En situation réelle, il faudrait vérifier l'existence de cette page
    define('NUM_PAGE', intval($_GET['pagecom']));
}

// Déclaration de la variable de session
if (empty($_SESSION['formparametre'])) {
    $_SESSION['formparametre'] = array();
}

if (empty($_SESSION['formparametre'])) {
    $_SESSION['formparametre'] = array();
}

switch (NUM_PAGE) {

    case 2:
        // Récupération des informations du formulaire précédent
        if (!empty($_POST)) {

            $_SESSION['formparametre'][NUM_PAGE - 1] = array(
                'parametre' => ucwords(trim(htmlspecialchars($_POST["parametre"]))),
                'valmin' => floatval(trim(htmlspecialchars($_POST["valmin"]))),
                'valmax' => floatval(trim(htmlspecialchars($_POST["valmax"]))),
                'unite' => floatval(trim(htmlspecialchars($_POST["unite"])))
            );
        }
        require('hopitalpages/hopitalparametre/hopitalparametre/hopitalajouter/form_terminer.php');
        break;

    case 1:
    default:
        // Valeurs par défaut
        if (empty($_SESSION['formparametre'][NUM_PAGE])) {

            $_SESSION['formparametre'][NUM_PAGE] = array(
                'parametre' => '',
                'valmin' => '',
                'valmax' => '',
                'unite' => ''
            );
        }
        require('hopitalpages/hopitalparametre/hopitalparametre/hopitalajouter/form_ajouter_parametre.php');
        break;
}
        