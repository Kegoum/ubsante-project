<?php

if (isset($_REQUEST["personnel"])) {
    $idpers = $_REQUEST["personnel"];
    $rslt = $con->query("select * from hp_personnel where idpersonnel='" . $idpers . "'") or die(mysqli_error($con));
    $row = mysqli_fetch_assoc($rslt);
// Récupération du numéro de l'étape en cours
    if (empty($_GET['pagecom']) or ! is_numeric($_GET['pagecom'])) {
        define('NUM_PAGE', 1);
    } else {
        // En situation réelle, il faudrait vérifier l'existence de cette page
        define('NUM_PAGE', intval($_GET['pagecom']));
    }

// Déclaration de la variable de session
    if (empty($_SESSION['formcomptepersonnel'])) {
        $_SESSION['formcomptepersonnel'] = array();
    }

    if (empty($_SESSION['formcomptepersonnel'])) {
        $_SESSION['formcomptepersonnel'] = array();

        $_SESSION['formcomptepersonnel'][1] = array(
            'idpersonnel' => $_REQUEST["personnel"],
            'loginp' => '',
            'pas1' => '',
            'pas2' => ''
        );
    }

    switch (NUM_PAGE) {

        case 2:
            // Récupération des informations du formulaire précédent
            if (!empty($_POST)) {
                $erreurprod = FALSE;
                $_SESSION['formcomptepersonnel'][NUM_PAGE - 1] = array(
                    'idpersonnel' => $_REQUEST["personnel"],
                    'loginp' => trim(htmlspecialchars($_POST["loginp"])),
                    'pas1' => trim(htmlspecialchars($_POST["pas1"])),
                    'pas2' => trim(htmlspecialchars($_POST["pas2"]))
                );
            }
            if ((isset($erreurprod)) && ($erreurprod)) {
                $pag = 'hopitalpages/hopitalpersonnel/hopitalcompte/hopitalajouter/ajout_compte';
                $stag = 1;
                die('<meta http-equiv="refresh" content="0; URL=' . $url . '?page=' . base64_encode($pag) . '&pagecom=' . $stag . '">');
            } else {
                require('hopitalpages/hopitalpersonnel/hopitalcompte/hopitalajouter/form_terminer.php');
                break;
            }

        case 1:
        default:
            // Valeurs par défaut
            if (empty($_SESSION['formcomptepersonnel'][NUM_PAGE])) {

                $_SESSION['formcomptepersonnel'][NUM_PAGE] = array(
                    'idpersonnel' => $_REQUEST["personnel"],
                    'loginp' => '',
                    'pas1' => '',
                    'pas2' => ''
                );
            }
            require('hopitalpages/hopitalpersonnel/hopitalcompte/hopitalajouter/form_ajouter_compte.php');
            break;
    }
}