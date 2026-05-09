<?php

// Récupération du numéro de l'étape en cours
if (empty($_GET['pagecom']) or ! is_numeric($_GET['pagecom'])) {
    define('NUM_PAGE', 1);
} else {
    // En situation réelle, il faudrait vérifier l'existence de cette page
    define('NUM_PAGE', intval($_GET['pagecom']));
}

// Déclaration de la variable de session
if (empty($_SESSION['formunite'])) {
    $_SESSION['formunite'] = array();
}

if (empty($_SESSION['formunite'])) {
    $_SESSION['formunite'] = array();
}

switch (NUM_PAGE) {

    case 2:
        // Récupération des informations du formulaire précédent
        if (!empty($_POST)) {
            $_SESSION['formunite'][NUM_PAGE - 1] = array(
                'codep' => (trim(htmlspecialchars($_POST["codep"]))),
                'unite' => (trim(htmlspecialchars($_POST["unite"])))
            );
        }
        require('hopitalpages/hopitalparametre/hopitalunite/hopitalajouter/form_terminer.php');
        break;

    case 1:
    default:
        // Valeurs par défaut
        if (empty($_SESSION['formunite'][NUM_PAGE])) {

            $_SESSION['formunite'][NUM_PAGE] = array(
                'codep' => '',
                'unite' => ''
            );
        }
        require('hopitalpages/hopitalparametre/hopitalunite/hopitalajouter/form_ajouter_unite.php');
        break;

}
        