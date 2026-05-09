<?php

// Récupération du numéro de l'étape en cours
if (empty($_GET['pagecom']) or ! is_numeric($_GET['pagecom'])) {
    define('NUM_PAGE', 1);
} else {
    // En situation réelle, il faudrait vérifier l'existence de cette page
    define('NUM_PAGE', intval($_GET['pagecom']));
}

// Déclaration de la variable de session
if (empty($_SESSION['formechographie'])) {
    $_SESSION['formechographie'] = array();
}

if (empty($_SESSION['formechographie'])) {
    $_SESSION['formechographie'] = array();
}

switch (NUM_PAGE) {

    case 2:
        // Récupération des informations du formulaire précédent
        if (!empty($_POST)) {

            $_SESSION['formechographie'][NUM_PAGE - 1] = array(
                'service' => strtoupper(trim(htmlspecialchars($_POST["service"]))),
                'codep' => strtoupper(trim(htmlspecialchars($_POST["codep"]))),
                'echographie' => ucwords(trim(htmlspecialchars($_POST["echographie"]))),
                'type' => (trim(htmlspecialchars($_POST["type"]))),
                'montant' => floatval(trim(htmlspecialchars($_POST["montant"]))),
                'resultat' => (trim(htmlspecialchars($_POST["resultat"]))),
                'valmin' => floatval(trim(htmlspecialchars($_POST["valmin"]))),
                'valmax' => floatval(trim(htmlspecialchars($_POST["valmax"]))),
                'acte' => floatval(trim(htmlspecialchars($_POST["acte"])))
            );
        }
        require('hopitalpages/hopitalparametre/hopitalechographie/hopitalajouter/form_terminer.php');
        break;

    case 1:
    default:
        // Valeurs par défaut
        if (empty($_SESSION['formechographie'][NUM_PAGE])) {

            $_SESSION['formechographie'][NUM_PAGE] = array(
                'service' => '',
                'codep' => '',
                'echographie' => '',
                'type' => '',
                'montant' => '',
                'resultat' => '',
                'valmin' => '',
                'valmax' => '',
                'acte' => ''
            );
        }
        require('hopitalpages/hopitalparametre/hopitalechographie/hopitalajouter/form_ajouter_echographie.php');
        break;
}
        