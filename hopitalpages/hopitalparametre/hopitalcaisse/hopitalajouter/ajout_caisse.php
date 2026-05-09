<?php

// Récupération du numéro de l'étape en cours
if (empty($_GET['pagecom']) or ! is_numeric($_GET['pagecom'])) {
    define('NUM_PAGE', 1);
} else {
    // En situation réelle, il faudrait vérifier l'existence de cette page
    define('NUM_PAGE', intval($_GET['pagecom']));
}

// Déclaration de la variable de session
if (empty($_SESSION['formcaisse'])) {
    $_SESSION['formcaisse'] = array();
}

if (empty($_SESSION['formcaisse'])) {
    $_SESSION['formcaisse'] = array();
}

switch (NUM_PAGE) {

    case 2:
        // Récupération des informations du formulaire précédent
        if (!empty($_POST)) {
            $_SESSION['formcaisse'][NUM_PAGE - 1] = array(
                'codep' => strtoupper(trim(htmlspecialchars($_POST["codep"]))),
                'caisse' => ucwords(trim(htmlspecialchars($_POST["caisse"])))
            );
        }
        require('hopitalpages/hopitalparametre/hopitalcaisse/hopitalajouter/form_terminer.php');
        break;

    case 1:
    default:
        // Valeurs par défaut
        if (empty($_SESSION['formcaisse'][NUM_PAGE])) {

            $_SESSION['formcaisse'][NUM_PAGE] = array(
                'codep' => '',
                'caisse' => ''
            );
        }
        require('hopitalpages/hopitalparametre/hopitalcaisse/hopitalajouter/form_ajouter_caisse.php');
        break;

}
        