<?php

// Récupération du numéro de l'étape en cours
if (empty($_GET['pagecom']) or ! is_numeric($_GET['pagecom'])) {
    define('NUM_PAGE', 1);
} else {
    // En situation réelle, il faudrait vérifier l'existence de cette page
    define('NUM_PAGE', intval($_GET['pagecom']));
}

// Déclaration de la variable de session
if (empty($_SESSION['formmodepaiement'])) {
    $_SESSION['formmodepaiement'] = array();
}

switch (NUM_PAGE) {

    case 2:
        // Récupération des informations du formulaire précédent
        if (!empty($_POST)) {
            $_SESSION['formmodepaiement'][NUM_PAGE - 1] = array(
                'code' => strtoupper(trim(htmlspecialchars($_POST["code"]))),
                'modepaiement' => ucwords(trim(htmlspecialchars($_POST["modepaiement"])))
            );
        }
        require('hopitalpages/hopitalparametre/hopitalmodepaiement/hopitalajouter/form_terminer.php');
        break;

    case 1:
    default:
        // Valeurs par défaut
        if (empty($_SESSION['formmodepaiement'][NUM_PAGE])) {

            $_SESSION['formmodepaiement'][NUM_PAGE] = array(
                'code' => '',
                'modepaiement' => ''
            );
        }
        require('hopitalpages/hopitalparametre/hopitalmodepaiement/hopitalajouter/form_ajouter_modepaiement.php');
        break;
}