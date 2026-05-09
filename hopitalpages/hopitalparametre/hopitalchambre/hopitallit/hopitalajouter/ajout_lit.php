<?php

if (isset($_REQUEST["idchambre"])) {
    $id = $_REQUEST["idchambre"];
    $rslt = $con->query("select * from hp_chambre where idchambre='" . $id . "'") or die(mysqli_error($con));
    $row = mysqli_fetch_assoc($rslt);
// Récupération du numéro de l'étape en cours
    if (empty($_GET['pagecom']) or ! is_numeric($_GET['pagecom'])) {
        define('NUM_PAGE', 1);
    } else {
        // En situation réelle, il faudrait vérifier l'existence de cette page
        define('NUM_PAGE', intval($_GET['pagecom']));
    }

// Déclaration de la variable de session
    if (empty($_SESSION['formlit'])) {
        $_SESSION['formlit'] = array();
    }
    if (empty($_SESSION['formlit'])) {
        $_SESSION['formlit'] = array();
        $_SESSION['formlit'][1] = array(
            'idchambre' => $_REQUEST["idchambre"],
            'libelle' => '',
            'code' => ''
        );
    }

    switch (NUM_PAGE) {

        case 2:
            // Récupération des informations du formulaire précédent
            if (!empty($_POST)) {
                $_SESSION['formlit'][NUM_PAGE - 1] = array(
                    'idchambre' => $_REQUEST["idchambre"],
                    'libelle' => ucwords(trim(htmlspecialchars($_POST["libelle"]))),
                    'code' => trim(htmlspecialchars($_POST["code"]))
                );
            }
            require('hopitalpages/hopitalparametre/hopitalchambre/hopitallit/hopitalajouter/form_terminer.php');
            break;

        case 1:
        default:
            // Valeurs par défaut
            if (empty($_SESSION['formlit'][NUM_PAGE])) {

                $_SESSION['formlit'][NUM_PAGE] = array(
                    'idchambre' => $_REQUEST["idchambre"],
                    'libelle' => '',
                    'code' => ''
                );
            } else if (($_SESSION['formlit'][NUM_PAGE]["idchambre"]!=$_REQUEST["idchambre"])) {

                $_SESSION['formlit'][NUM_PAGE] = array(
                    'idchambre' => $_REQUEST["idchambre"],
                    'libelle' => '',
                    'code' => ''
                );
            }
            require('hopitalpages/hopitalparametre/hopitalchambre/hopitallit/hopitalajouter/form_ajouter_lit.php');
            break;
    }
}