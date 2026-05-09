<?php

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
if (empty($_SESSION['formsoin'])) {
    $_SESSION['formsoin'] = array();
}

    

switch (NUM_PAGE) {

    case 2:
        // Récupération des informations du formulaire précédent
        if (!empty($_POST)) {
            $erreurprod = FALSE;
            
            $_SESSION['formsoin'][NUM_PAGE - 1] = array(
                'libelle' => trim(htmlspecialchars($_POST["libelle"])),
                'montant' => floatval(trim(htmlspecialchars($_POST["montant"]))),
                'nblignesoin' => trim(htmlspecialchars($_POST["nblignesoin"])),
                'liblignesoin' => trim(htmlspecialchars($_POST["liblignesoin"])),
                'qtelignesoin' => trim(htmlspecialchars($_POST["qtelignesoin"])),
                'unitelignesoin' => trim(htmlspecialchars($_POST["unitelignesoin"]))
            );
            
            $nbqmo = trim(htmlspecialchars($_POST["nblignesoin"]));

            for ($i = 0; $i < $nbqmo; $i++) {
                $_SESSION['formsoin'][NUM_PAGE - 1]['liblignesoin' . $i] = trim(htmlspecialchars($_POST["liblignesoin" . $i]));
                $_SESSION['formsoin'][NUM_PAGE - 1]['qtelignesoin' . $i] = trim(htmlspecialchars($_POST["qtelignesoin" . $i]));
                $_SESSION['formsoin'][NUM_PAGE - 1]['unitelignesoin' . $i] = trim(htmlspecialchars($_POST["unitelignesoin" . $i]));
            }
        }
        if ((isset($erreurprod)) && ($erreurprod)) {
            $pag = 'hopitalpages/hopitalparametre/hopitalsoin/hopitalajouter/ajout_soin';
            $stag = 1;
            die('<meta http-equiv="refresh" content="0; URL=' . $url . '?page=' . base64_encode($pag) . '&pagecom=' . $stag . '">');
        } else {
            require('hopitalpages/hopitalparametre/hopitalsoin/hopitalajouter/form_terminer.php');
            break;
        }

    case 1:
    default:
        // Valeurs par défaut
        if (empty($_SESSION['formsoin'][NUM_PAGE])) {

            $_SESSION['formsoin'][NUM_PAGE] = array(
                'libelle' => '',
                'montant' => '',
                'nblignesoin' => '',
                'liblignesoin' => '',
                'qtelignesoin' => '',
                'unitelignesoin' => ''
            );
        }
        require('hopitalpages/hopitalparametre/hopitalsoin/hopitalajouter/form_ajouter_soin.php');
        break;
}