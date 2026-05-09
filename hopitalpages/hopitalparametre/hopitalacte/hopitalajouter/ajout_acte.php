<?php

// Récupération du numéro de l'étape en cours
if (empty($_GET['pagecom']) or ! is_numeric($_GET['pagecom'])) {
    define('NUM_PAGE', 1);
} else {
    // En situation réelle, il faudrait vérifier l'existence de cette page
    define('NUM_PAGE', intval($_GET['pagecom']));
}

// Déclaration de la variable de session
if (empty($_SESSION['formacte'])) {
    $_SESSION['formacte'] = array();
}

if (empty($_SESSION['formacte'])) {
    $_SESSION['formacte'] = array();
}

switch (NUM_PAGE) {

    case 2:
        // Récupération des informations du formulaire précédent
        if (!empty($_POST)) {
            
            $_SESSION['formacte'][NUM_PAGE - 1] = array(
                'service' => (trim(htmlspecialchars($_POST["service"]))),
                'code' => (trim(htmlspecialchars($_POST["code"]))),
                'designationp' => (trim(htmlspecialchars($_POST["designationp"]))),
                'categorie' => (trim(htmlspecialchars($_POST["categorie"]))),
                'type' => ucwords(trim(htmlspecialchars($_POST["type"]))),
                'description' => ucwords(trim(htmlspecialchars($_POST["description"]))),
                'montant' => (trim(htmlspecialchars($_POST["montant"])))
            );
        }
        require('hopitalpages/hopitalparametre/hopitalacte/hopitalajouter/form_terminer.php');
        break;

    case 1:
    default:
        // Valeurs par défaut
        if (empty($_SESSION['formacte'][NUM_PAGE])) {

            $_SESSION['formacte'][NUM_PAGE] = array(
                'service' => '',
                'code' => '',
                'designationp' => '',
                'categorie' => '',
                'type' => '',
                'description' => '',
                'montant' => ''
            );
        }
        require('hopitalpages/hopitalparametre/hopitalacte/hopitalajouter/form_ajouter_acte.php');
        break;

}
        