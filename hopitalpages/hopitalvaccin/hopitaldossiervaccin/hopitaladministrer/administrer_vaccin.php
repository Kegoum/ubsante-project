<?php

if ($_REQUEST["idvaccin"]) {
    $rsltc = $con->query('select * from hp_vaccin where idvaccin=' . $_REQUEST["idvaccin"] . ' ') or die(mysqli_error($con));
    $row = mysqli_fetch_assoc($rsltc);
?>
    <?php

// Récupération du numéro de l'étape en cours
    if (empty($_GET['pagecom']) or ! is_numeric($_GET['pagecom'])) {
        define('NUM_PAGE', 1);
    } else {
        // En situation réelle, il faudrait vérifier l'existence de cette page
        define('NUM_PAGE', intval($_GET['pagecom']));
    }

// Déclaration de la variable de session
    if (empty($_SESSION['formadministrevaccin'])) {
        $_SESSION['formadministrevaccin'] = array();
    }

    if (empty($_SESSION['formadministrevaccin'])) {
        $_SESSION['formadministrevaccin'] = array();
        $_SESSION['formadministrevaccin'][1] = array(
            'idvaccin' => $_REQUEST["idvaccin"],
            'datejour' => NULL,
            'daterdv' => NULL,
            'vaccin' => array(),
            'nbvaccin' => 0,
            'masse' => '',
            'taille' => '',
            'ctete' => '',
            'cbras' => ''
        );
    }


    switch (NUM_PAGE) {

        case 2:
            // Récupération des informations du formulaire précédent
            if (!empty($_POST)) {
                $erreur = FALSE;
                $vacc = array();
                $nbv = 0;

                foreach ($_POST['vaccin'] as $service) {
                    if (($service != "") && ($service != NULL)) {
                        $vacc[$nbv] = $service;
                        $nbv = $nbv + 1;
                    }
                }
                $_SESSION['formadministrevaccin'][NUM_PAGE - 1] = array(
                    'idvaccin' => $_REQUEST["idvaccin"],
                    'datejour' => trim(htmlspecialchars($_POST["datejour"])),
                    'daterdv' => trim(htmlspecialchars($_POST["daterdv"])),
                    'vaccin' => $vacc,
                    'nbvaccin' => $nbv,
                    'masse' => floatval(trim(htmlspecialchars($_POST["masse"]))),
                    'taille' => floatval(trim(htmlspecialchars($_POST["taille"]))),
                    'ctete' => floatval(trim(htmlspecialchars($_POST["ctete"]))),
                    'cbras' => floatval(trim(htmlspecialchars($_POST["cbras"])))
                );
            }
            if ((isset($erreur)) && ($erreur)) {
                $pag = 'hopitalpages/hopitalvaccin/hopitaldossiervaccin/hopitaladministrer/administrer_vaccin';
                $stag = 1;
                die('<meta http-equiv="refresh" content="3; URL=' . $url . '?page=' . base64_encode($pag) . '&idvaccin=' . $_REQUEST["idvaccin"] . '">');
            } else {
                require('hopitalpages/hopitalvaccin/hopitaldossiervaccin/hopitaladministrer/form_terminer.php');
                break;
            }

        case 1:
        default:
            // Valeurs par défaut
            if (empty($_SESSION['formadministrevaccin'][NUM_PAGE])) {

                $_SESSION['formadministrevaccin'][NUM_PAGE] = array(
                    'idvaccin' => $_REQUEST["idvaccin"],
                    'datejour' => NULL,
            'daterdv' => NULL,
                    'vaccin' => array(),
                    'nbvaccin' => 0,
                    'masse' => '',
                    'taille' => '',
                    'ctete' => '',
                    'cbras' => ''
                );
            } else if (($_SESSION['formadministrevaccin'][NUM_PAGE]["idvaccin"]) != $_REQUEST["idvaccin"]) {

                $_SESSION['formadministrevaccin'][NUM_PAGE] = array(
                    'idvaccin' => $_REQUEST["idvaccin"],
                    'datejour' => NULL,
            'daterdv' => NULL,
                    'vaccin' => array(),
                    'nbvaccin' => 0,
                    'masse' => '',
                    'taille' => '',
                    'ctete' => '',
                    'cbras' => ''
                );
            }
            require('hopitalpages/hopitalvaccin/hopitaldossiervaccin/hopitaladministrer/form_administrer_vaccin.php');
            break;
    }
}