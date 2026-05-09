<?php

// Récupération du numéro de l'étape en cours
if (empty($_GET['pagecom']) or ! is_numeric($_GET['pagecom'])) {
    define('NUM_PAGE', 1);
} else {
    // En situation réelle, il faudrait vérifier l'existence de cette page
    define('NUM_PAGE', intval($_GET['pagecom']));
}

// Déclaration de la variable de session
if (empty($_SESSION['formexamen'])) {
    $_SESSION['formexamen'] = array();
}

if (empty($_SESSION['formexamen'])) {
    $_SESSION['formexamen'] = array();
}

switch (NUM_PAGE) {

    case 2:
        // Récupération des informations du formulaire précédent
        if (!empty($_POST)) {

            $_SESSION['formexamen'][NUM_PAGE - 1] = array(
                'laboratoire' => strtoupper(trim(htmlspecialchars($_POST["laboratoire"]))),
                'codep' => strtoupper(trim(htmlspecialchars($_POST["codep"]))),
                'examen' => ucwords(trim(htmlspecialchars($_POST["examen"]))),
                'type' => (trim(htmlspecialchars($_POST["type"]))),
                'montant' => floatval(trim(htmlspecialchars($_POST["montant"]))),
                'resultat' => (trim(htmlspecialchars($_POST["resultat"]))),
                'valmin' => floatval(trim(htmlspecialchars($_POST["valmin"]))),
                'valmax' => floatval(trim(htmlspecialchars($_POST["valmax"]))),
                'unite' => floatval(trim(htmlspecialchars($_POST["unite"])))
            );
        }
        require('hopitalpages/hopitalparametre/hopitalexamen/hopitalajouter/form_terminer.php');
        break;

    case 1:
    default:
        // Valeurs par défaut
        if (empty($_SESSION['formexamen'][NUM_PAGE])) {

            $_SESSION['formexamen'][NUM_PAGE] = array(
                'laboratoire' => '',
                'codep' => '',
                'examen' => '',
                'type' => '',
                'montant' => '',
                'resultat' => '',
                'valmin' => '',
                'valmax' => '',
                'unite' => ''
            );
        }
        require('hopitalpages/hopitalparametre/hopitalexamen/hopitalajouter/form_ajouter_examen.php');
        break;
}
        