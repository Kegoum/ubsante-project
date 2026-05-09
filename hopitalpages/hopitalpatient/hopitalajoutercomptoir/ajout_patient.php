<?php

// Récupération du numéro de l'étape en cours
if (empty($_GET['pagecom']) or ! is_numeric($_GET['pagecom'])) {
    define('NUM_PAGE', 1);
} else {
    // En situation réelle, il faudrait vérifier l'existence de cette page
    define('NUM_PAGE', intval($_GET['pagecom']));
}

// Déclaration de la variable de session
if (empty($_SESSION['formpatientcomptoir'])) {
    $_SESSION['formpatientcomptoir'] = array();
}

switch (NUM_PAGE) {

    case 2:
        // Récupération des informations du formulaire précédent
        if (!empty($_POST)) {
            $erreurprod = FALSE;

            $libordonnancea=$_SESSION['formpatientcomptoir'][NUM_PAGE - 1]["libordonnance"];
            $qteordonnancea=$_SESSION['formpatientcomptoir'][NUM_PAGE - 1]["qteordonnance"];
            $uniteordonnancea=$_SESSION['formpatientcomptoir'][NUM_PAGE - 1]["uniteordonnance"];
            $prixuordonnancea=$_SESSION['formpatientcomptoir'][NUM_PAGE - 1]["prixuordonnance"];
            $prixtordonnancea=$_SESSION['formpatientcomptoir'][NUM_PAGE - 1]["prixtordonnance"];
            
                $ordonb = (trim(htmlspecialchars($_POST["ordonnancenb"])));
                if (isset($_POST["libordonnance"])) {
                    $libordonnancea = trim(htmlspecialchars($_POST["libordonnance"]));
                    $uniteordonnancea = trim(htmlspecialchars($_POST["uniteordonnance"]));
                    $qteordonnancea = trim(htmlspecialchars($_POST["qteordonnance"]));
                    $prixuordonnancea = trim(htmlspecialchars($_POST["prixuordonnance"]));
                    $prixtordonnancea = trim(htmlspecialchars($_POST["prixtordonnance"]));
                }

            $_SESSION['formpatientcomptoir'][NUM_PAGE - 1] = array(
                'datejourp' => (trim(htmlspecialchars($_POST["datejourp"]))),
                'heurejourp' => (trim(htmlspecialchars($_POST["heurejourp"]))),
                'montanto' => (trim(htmlspecialchars($_POST["montanto"]))),
                'ordonnancenb' => $ordonb,
                'libordonnance' => $libordonnancea,
                'uniteordonnance' => $uniteordonnancea,
                'qteordonnance' => $qteordonnancea,
                'prixuordonnance' => $prixuordonnancea,
                'prixtordonnance' => $prixtordonnancea,
            );
            
            $nbqor = trim(htmlspecialchars($_POST["ordonnancenb"]));

            for ($i = 0; $i < $nbqor; $i++) {
                $_SESSION['formpatientcomptoir'][NUM_PAGE - 1]['libordonnance' . $i] = trim(htmlspecialchars($_POST["libordonnance" . $i]));
                $_SESSION['formpatientcomptoir'][NUM_PAGE - 1]['uniteordonnance' . $i] = trim(htmlspecialchars($_POST["uniteordonnance" . $i]));
                $_SESSION['formpatientcomptoir'][NUM_PAGE - 1]['qteordonnance' . $i] = trim(htmlspecialchars($_POST["qteordonnance" . $i]));
                $_SESSION['formpatientcomptoir'][NUM_PAGE - 1]['prixuordonnance' . $i] = trim(htmlspecialchars($_POST["prixuordonnance" . $i]));
                $_SESSION['formpatientcomptoir'][NUM_PAGE - 1]['prixtordonnance' . $i] = trim(htmlspecialchars($_POST["prixtordonnance" . $i]));
            }
        }
        if ((isset($erreurprod)) && ($erreurprod)) {
            $pag = 'hopitalpages/hopitalpatient/hopitalajoutercomptoir/ajout_patient';
            $stag = 1;
            die('<meta http-equiv="refresh" content="0; URL=' . $url . '?page=' . base64_encode($pag) . '&pagecom=' . $stag . '">');
        } else {
            require('hopitalpages/hopitalpatient/hopitalajoutercomptoir/form_terminer.php');
            break;
        }

    case 1:
    default:
        // Valeurs par défaut
        if (empty($_SESSION['formpatientcomptoir'][NUM_PAGE])) {

            $_SESSION['formpatientcomptoir'][NUM_PAGE] = array(
                'datejourp' => '',
                'heurejourp' => '',
                'montanto' => '',
                'ordonnancenb' => 0,
                'libordonnance' => '',
                'qteordonnance' => '',
                'uniteordonnance' => '',
                'prixuordonnance' => '',
                'prixtordonnance' => '',
            );
        }
        require('hopitalpages/hopitalpatient/hopitalajoutercomptoir/form_ajouter_patient.php');
        break;
}