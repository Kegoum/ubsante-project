<?php

// Récupération du numéro de l'étape en cours
if (empty($_GET['pagecom']) or ! is_numeric($_GET['pagecom'])) {
    define('NUM_PAGE', 1);
} else {
    // En situation réelle, il faudrait vérifier l'existence de cette page
    define('NUM_PAGE', intval($_GET['pagecom']));
}

// Déclaration de la variable de session
if (empty($_SESSION['formpersonnel'])) {
    $_SESSION['formpersonnel'] = array();
}

switch (NUM_PAGE) {

    case 2:
        // Récupération des informations du formulaire précédent
        if (!empty($_POST)) {
            $erreurprod = FALSE;
            $_SESSION['formpersonnel'][NUM_PAGE - 1] = array(
                'nom' => trim(htmlspecialchars($_POST["nom"])),
                'prenom' => trim(htmlspecialchars($_POST["prenom"])),
                'tel' => trim(htmlspecialchars($_POST["tel"])),
                'service' => trim(htmlspecialchars($_POST["service"])),
                'role' => trim(htmlspecialchars($_POST["role"])),
                'salaire' => trim(htmlspecialchars($_POST["salaire"])),
                'typepaiement' => trim(htmlspecialchars($_POST["typepaiement"]))
            );
        }
        if ((isset($erreurprod)) && ($erreurprod)) {
            $pag = 'hopitalpages/hopitalpersonnel/hopitalajouter/ajout_personnel';
            $stag = 1;
            die('<meta http-equiv="refresh" content="0; URL=' . $url . '?page=' . base64_encode($pag) . '&pagecom=' . $stag . '">');
        } else {
            require('hopitalpages/hopitalpersonnel/hopitalajouter/form_terminer.php');
            break;
        }

    case 1:
    default:
        // Valeurs par défaut
        if (empty($_SESSION['formpersonnel'][NUM_PAGE])) {

            $_SESSION['formpersonnel'][NUM_PAGE] = array(
                'nom' => '',
                'prenom' => '',
                'tel' => '',
                'service' => '',
                'role' => '',
                'salaire' => '',
                'typepaiement' => ''
            );
        }
        require('hopitalpages/hopitalpersonnel/hopitalajouter/form_ajouter_personnel.php');
        break;
}