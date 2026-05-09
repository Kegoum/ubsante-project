<?php

// Récupération du numéro de l'étape en cours
if (empty($_GET['pagecom']) or ! is_numeric($_GET['pagecom'])) {
    define('NUM_PAGE', 1);
} else {
    // En situation réelle, il faudrait vérifier l'existence de cette page
    define('NUM_PAGE', intval($_GET['pagecom']));
}

// Déclaration de la variable de session
if (empty($_SESSION['formvaccin'])) {
    $_SESSION['formvaccin'] = array();
}

switch (NUM_PAGE) {

    case 2:
        // Récupération des informations du formulaire précédent
        if (!empty($_POST)) {
            $erreurprod = FALSE;

            $_SESSION['formvaccin'][NUM_PAGE - 1] = array(
                'sexe' => (trim(htmlspecialchars($_POST["sexe"]))),
                'nom' => trim(htmlspecialchars($_POST["nom"])),
                'datenais' => (trim(htmlspecialchars($_POST["datenais"]))),
                'quartier' => trim(htmlspecialchars($_POST["quartier"])),
                'nomparent' => trim(htmlspecialchars($_POST["nomparent"])),
                'telc' => trim(htmlspecialchars($_POST["telc"]))
            );
            
        }
        if ((isset($erreurprod)) && ($erreurprod)) {
            $pag = 'hopitalpages/hopitalvaccin/hopitalajouter/ajout_vaccin';
            $stag = 1;
            die('<meta http-equiv="refresh" content="0; URL=' . $url . '?page=' . base64_encode($pag) . '&pagecom=' . $stag . '">');
        } else {
            require('hopitalpages/hopitalvaccin/hopitalajouter/form_terminer.php');
            break;
        }

    case 1:
    default:
        // Valeurs par défaut
        if (empty($_SESSION['formvaccin'][NUM_PAGE])) {

            $_SESSION['formvaccin'][NUM_PAGE] = array(
                'sexe' => '',
                'nom' => '',
                'datenais' => NULL,
                'quartier' => '',
                'nomparent' => '',
                'telc' => ''
            );
        }
        require('hopitalpages/hopitalvaccin/hopitalajouter/form_ajouter_vaccin.php');
        break;
}