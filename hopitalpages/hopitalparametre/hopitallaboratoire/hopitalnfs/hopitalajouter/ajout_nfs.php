<?php

// Récupération du numéro de l'étape en cours
if (empty($_GET['pagecom']) or ! is_numeric($_GET['pagecom'])) {
    define('NUM_PAGE', 1);
} else {
    // En situation réelle, il faudrait vérifier l'existence de cette page
    define('NUM_PAGE', intval($_GET['pagecom']));
}

// Déclaration de la variable de session
if (empty($_SESSION['formnfs'])) {
    $_SESSION['formnfs'] = array();
}

if (empty($_SESSION['formnfs'])) {
    $_SESSION['formnfs'] = array();
}

switch (NUM_PAGE) {

    case 2:
        // Récupération des informations du formulaire précédent
        if (!empty($_POST)) {

            $_SESSION['formnfs'][NUM_PAGE - 1] = array(
                'code' => ucwords(trim(htmlspecialchars($_POST["code"]))),
                'nfs' => ucwords(trim(htmlspecialchars($_POST["nfs"]))),
                'valmin29' => floatval(trim(htmlspecialchars($_POST["valmin29"]))),
                'valmax29' => floatval(trim(htmlspecialchars($_POST["valmax29"]))),
                'valmin6' => floatval(trim(htmlspecialchars($_POST["valmin6"]))),
                'valmax6' => floatval(trim(htmlspecialchars($_POST["valmax6"]))),
                'valminf' => floatval(trim(htmlspecialchars($_POST["valminf"]))),
                'valmaxf' => floatval(trim(htmlspecialchars($_POST["valmaxf"]))),
                'valminh' => floatval(trim(htmlspecialchars($_POST["valminh"]))),
                'valmaxh' => floatval(trim(htmlspecialchars($_POST["valmaxh"]))),
                'unite' => floatval(trim(htmlspecialchars($_POST["unite"])))
            );
        }
        require('hopitalpages/hopitalparametre/hopitallaboratoire/hopitalnfs/hopitalajouter/form_terminer.php');
        break;

    case 1:
    default:
        // Valeurs par défaut
        if (empty($_SESSION['formnfs'][NUM_PAGE])) {

            $_SESSION['formnfs'][NUM_PAGE] = array(
                'code' => '',
                'nfs' => '',
                'valmin29' => '',
                'valmax29' => '',
                'valmin6' => '',
                'valmax6' => '',
                'valminf' => '',
                'valmaxf' => '',
                'valminh' => '',
                'valmaxh' => '',
                'unite' => ''
            );
        }
        require('hopitalpages/hopitalparametre/hopitallaboratoire/hopitalnfs/hopitalajouter/form_ajouter_nfs.php');
        break;
}
        