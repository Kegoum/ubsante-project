<?php

// Récupération du numéro de l'étape en cours
if (empty($_GET['pagecom']) or ! is_numeric($_GET['pagecom'])) {
    define('NUM_PAGE', 1);
} else {
    // En situation réelle, il faudrait vérifier l'existence de cette page
    define('NUM_PAGE', intval($_GET['pagecom']));
}

// Déclaration de la variable de session
if (empty($_SESSION['formservice'])) {
    $_SESSION['formservice'] = array();
}

if (empty($_SESSION['formservice'])) {
    $_SESSION['formservice'] = array();
}

switch (NUM_PAGE) {

    case 2:
        // Récupération des informations du formulaire précédent
        if (!empty($_POST)) {
            $loc=0;
            if(isset($_POST["local"])){
                $loc=1;
            }
            $_SESSION['formservice'][NUM_PAGE - 1] = array(
                'codep' => strtoupper(trim(htmlspecialchars($_POST["codep"]))),
                'service' => ucwords(trim(htmlspecialchars($_POST["service"]))),
                'domaine' => ucwords(trim(htmlspecialchars($_POST["domaine"]))),
                'tel' => ucwords(trim(htmlspecialchars($_POST["tel"]))),
                'local' => $loc
            );
        }
        require('hopitalpages/hopitalparametre/hopitalservice/hopitalajouter/form_terminer.php');
        break;

    case 1:
    default:
        // Valeurs par défaut
        if (empty($_SESSION['formservice'][NUM_PAGE])) {

            $_SESSION['formservice'][NUM_PAGE] = array(
                'codep' => '',
                'service' => '',
                'domaine' => '',
                'tel' => '',
                'local' => 1
            );
        }
        require('hopitalpages/hopitalparametre/hopitalservice/hopitalajouter/form_ajouter_service.php');
        break;

}
        