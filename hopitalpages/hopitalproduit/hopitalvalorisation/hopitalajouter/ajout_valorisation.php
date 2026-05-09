<?php

// Récupération du numéro de l'étape en cours
if (empty($_GET['pagecom']) or ! is_numeric($_GET['pagecom'])) {
    define('NUM_PAGE', 1);
} else {
    // En situation réelle, il faudrait vérifier l'existence de cette page
    define('NUM_PAGE', intval($_GET['pagecom']));
}

// Déclaration de la variable de session
if (empty($_SESSION['formvalorisationstock'])) {
    $_SESSION['formvalorisationstock'] = array();
}

switch (NUM_PAGE) {

    case 2:
        // Récupération des informations du formulaire précédent
        if (!empty($_POST)) {
            $_SESSION['formvalorisationstock'][NUM_PAGE - 1] = array(
                'codevalorisationstock' => strtoupper(trim(htmlspecialchars($_POST["codevalorisationstock"]))),
                'libvalorisationstock' => ucwords(trim(htmlspecialchars($_POST["libvalorisationstock"])))
            );
        }
        require('hopitalpages/hopitalproduit/hopitalvalorisation/hopitalajouter/form_terminer.php');
        break;
        
    case 1:
    default:
        // Valeurs par défaut
        if (empty($_SESSION['formvalorisationstock'][NUM_PAGE])) {

            $_SESSION['formvalorisationstock'][NUM_PAGE] = array(
                'codevalorisationstock' => '',
                'libvalorisationstock' => ''
            );
        }
        require('hopitalpages/hopitalproduit/hopitalvalorisation/hopitalajouter/form_ajouter_valorisation.php');
        break;
}