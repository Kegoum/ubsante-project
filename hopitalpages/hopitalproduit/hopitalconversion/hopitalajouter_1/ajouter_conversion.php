
<?php

if (isset($_REQUEST["produit"])) {
    $idp = $_REQUEST["produit"];
$rslt = $con->query("select * from hp_produit as a where a.idproduit='" . $idp . "'") or die(mysqli_error($con));
    $row = mysqli_fetch_assoc($rslt);
// Récupération du numéro de l'étape en cours
    if (empty($_GET['pagecom']) or ! is_numeric($_GET['pagecom'])) {
        define('NUM_PAGE', 1);
    } else {
        // En situation réelle, il faudrait vérifier l'existence de cette page
        define('NUM_PAGE', intval($_GET['pagecom']));
    }

// Déclaration de la variable de session
    if (empty($_SESSION['formprodunite'])) {
        $_SESSION['formprodunite'] = array();
    }

    switch (NUM_PAGE) {

        case 2:

            // Récupération des informations du formulaire précédent
            if (!empty($_POST)) {

                $_SESSION['formprodunite'][NUM_PAGE - 1] = array(
                    'produit' => $_REQUEST["produit"],
                    'unite' => trim(htmlspecialchars($_POST["unite"])),
                    'conver' => trim(htmlspecialchars($_POST["conver"])),
                    'stock' => trim(htmlspecialchars($_POST["stock"]))
                );
            }

            require('hopitalpages/hopitalproduit/hopitalconversion/hopitalajouter/form_terminer.php');
            break;

        case 1:
        default:
            // Valeurs par défaut
            if (empty($_SESSION['formprodunite'][NUM_PAGE])) {

                $_SESSION['formprodunite'][NUM_PAGE] = array(
                    'produit' => $_REQUEST["produit"],
                    'unite' => '',
                    'conver' => '',
                    'stock' => ''
                );
            }
            require('hopitalpages/hopitalproduit/hopitalconversion/hopitalajouter/form_ajouter_conversion.php');
            break;
    }
}