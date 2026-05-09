<?php

// Récupération du numéro de l'étape en cours
if (empty($_GET['pagecom']) or ! is_numeric($_GET['pagecom'])) {
    define('NUM_PAGE', 1);
} else {
    // En situation réelle, il faudrait vérifier l'existence de cette page
    define('NUM_PAGE', intval($_GET['pagecom']));
}

// Déclaration de la variable de session
if (empty($_SESSION['formgrilleprix'])) {
    $_SESSION['formgrilleprix'] = array();
}

if (empty($_SESSION['formgrilleprix'])) {
    $_SESSION['formgrilleprix'] = array();
}

switch (NUM_PAGE) {

    case 2:
        // Récupération des informations du formulaire précédent
        if (!empty($_POST)) {
            
            $_SESSION['formgrilleprix'][NUM_PAGE - 1] = array(
                'acte' => (trim(htmlspecialchars($_POST["acte"]))),
                'designationp' => (trim(htmlspecialchars($_POST["designationp"]))),
                'type' => ucwords(trim(htmlspecialchars($_POST["type"]))),
                'montant' => (trim(htmlspecialchars($_POST["montant"])))
            );
        }
        require('hopitalpages/hopitalparametre/hopitalgrilleprix/hopitalajouter/form_terminer.php');
        break;

    case 1:
    default:
        // Valeurs par défaut
        if (empty($_SESSION['formgrilleprix'][NUM_PAGE])) {

            $_SESSION['formgrilleprix'][NUM_PAGE] = array(
                'acte' => '',
                'designationp' => '',
                'type' => '',
                'montant' => ''
            );
        }
        require('hopitalpages/hopitalparametre/hopitalgrilleprix/hopitalajouter/form_ajouter_grilleprix.php');
        break;

}
        