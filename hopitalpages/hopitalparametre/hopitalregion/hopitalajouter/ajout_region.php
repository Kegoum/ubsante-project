<?php

// Récupération du numéro de l'étape en cours
if (empty($_GET['pagecom']) or ! is_numeric($_GET['pagecom'])) {
    define('NUM_PAGE', 1);
} else {
    // En situation réelle, il faudrait vérifier l'existence de cette page
    define('NUM_PAGE', intval($_GET['pagecom']));
}

// Déclaration de la variable de session
if (empty($_SESSION['formregion'])) {
    $_SESSION['formregion'] = array();
}

if (empty($_SESSION['formregion'])) {
    $_SESSION['formregion'] = array();
}

switch (NUM_PAGE) {

    case 2:
        // Récupération des informations du formulaire précédent
        if (!empty($_POST)) {
            $_SESSION['formregion'][NUM_PAGE - 1] = array(
                'codep' => strtoupper(trim(htmlspecialchars($_POST["codep"]))),
                'region' => ucwords(trim(htmlspecialchars($_POST["region"]))),
                'cheflieu' => ucwords(trim(htmlspecialchars($_POST["cheflieu"])))
            );
        }
        require('hopitalpages/hopitalparametre/hopitalregion/hopitalajouter/form_terminer.php');
        break;

    case 1:
    default:
        // Valeurs par défaut
        if (empty($_SESSION['formregion'][NUM_PAGE])) {

            $_SESSION['formregion'][NUM_PAGE] = array(
                'codep' => '',
                'region' => '',
                'cheflieu' => ''
            );
        }
        require('hopitalpages/hopitalparametre/hopitalregion/hopitalajouter/form_ajouter_region.php');
        break;

}
        