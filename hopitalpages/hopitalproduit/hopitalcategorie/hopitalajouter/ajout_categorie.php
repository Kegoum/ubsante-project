<?php

// Récupération du numéro de l'étape en cours
if (empty($_GET['pagecom']) or ! is_numeric($_GET['pagecom'])) {
    define('NUM_PAGE', 1);
} else {
    // En situation réelle, il faudrait vérifier l'existence de cette page
    define('NUM_PAGE', intval($_GET['pagecom']));
}

// Déclaration de la variable de session
if (empty($_SESSION['formcategorie'])) {
    $_SESSION['formcategorie'] = array();
}

if (empty($_SESSION['formcategorie'])) {
    $_SESSION['formcategorie'] = array();
}

switch (NUM_PAGE) {

    case 2:
        // Récupération des informations du formulaire précédent
        if (!empty($_POST)) {
            $_SESSION['formcategorie'][NUM_PAGE - 1] = array(
                'codep' => (trim(htmlspecialchars($_POST["codep"]))),
                'categorie' => (trim(htmlspecialchars($_POST["categorie"])))
            );
        }
        require('hopitalpages/hopitalproduit/hopitalcategorie/hopitalajouter/form_terminer.php');
        break;

    case 1:
    default:
        // Valeurs par défaut
        if (empty($_SESSION['formcategorie'][NUM_PAGE])) {

            $_SESSION['formcategorie'][NUM_PAGE] = array(
                'codep' => '',
                'categorie' => ''
            );
        }
        require('hopitalpages/hopitalproduit/hopitalcategorie/hopitalajouter/form_ajouter_categorie.php');
        break;

}
        