<?php

// Récupération du numéro de l'étape en cours
if (empty($_GET['pagecom']) or ! is_numeric($_GET['pagecom'])) {
    define('NUM_PAGE', 1);
} else {
    // En situation réelle, il faudrait vérifier l'existence de cette page
    define('NUM_PAGE', intval($_GET['pagecom']));
}

// Déclaration de la variable de session
if (empty($_SESSION['formpatient'])) {
    $_SESSION['formpatient'] = array();
}

switch (NUM_PAGE) {

    case 2:
        // Récupération des informations du formulaire précédent
        if (!empty($_POST)) {
            $erreurprod = FALSE;

            $consul = $_SESSION['formpatient'][NUM_PAGE - 1]["consultation"];
            $vacc = $_SESSION['formpatient'][NUM_PAGE - 1]["vaccin"];
            $consulpren = $_SESSION['formpatient'][NUM_PAGE - 1]["prenatale"];
            $examnb = 0;
            $libexamena=$_SESSION['formpatient'][NUM_PAGE - 1]["libexamen"];
            $prixexamena=$_SESSION['formpatient'][NUM_PAGE - 1]["prixexamen"];
            $echonb = 0;
            $libechographiea=$_SESSION['formpatient'][NUM_PAGE - 1]["libechographie"];
            $prixechographiea=$_SESSION['formpatient'][NUM_PAGE - 1]["prixechographie"];
            $actnb = 0;
            $libactea=$_SESSION['formpatient'][NUM_PAGE - 1]["libacte"];
            $prixactea=$_SESSION['formpatient'][NUM_PAGE - 1]["prixacte"];
            $ordonb = 0;
            $libordonnancea=$_SESSION['formpatient'][NUM_PAGE - 1]["libordonnance"];
            $qteordonnancea=$_SESSION['formpatient'][NUM_PAGE - 1]["qteordonnance"];
            $uniteordonnancea=$_SESSION['formpatient'][NUM_PAGE - 1]["uniteordonnance"];
            $prixuordonnancea=$_SESSION['formpatient'][NUM_PAGE - 1]["prixuordonnance"];
            $prixtordonnancea=$_SESSION['formpatient'][NUM_PAGE - 1]["prixtordonnance"];
            if ($_POST["but"] == "Consultation") {
                $consul = (trim(htmlspecialchars($_POST["consultation"])));
            } else if ($_POST["but"] == "Consultation Prenatale") {
                $consulpren = (trim(htmlspecialchars($_POST["prenatale"])));
            } else if ($_POST["but"] == "Vaccination") {
                $vacc = (trim(htmlspecialchars($_POST["vaccin"])));
            } else if ($_POST["but"] == "Examen") {
                $examnb = (trim(htmlspecialchars($_POST["examennb"])));
                if (isset($_POST["libexamen"])) {
                    $libexamena = trim(htmlspecialchars($_POST["libexamen"]));
                    $prixexamena = trim(htmlspecialchars($_POST["prixexamen"]));
                }
            } else if ($_POST["but"] == "Echographie") {
                $echonb = (trim(htmlspecialchars($_POST["echographienb"])));
                if (isset($_POST["libechographie"])) {
                    $libechographiea = trim(htmlspecialchars($_POST["libechographie"]));
                    $prixechographiea = trim(htmlspecialchars($_POST["prixechographie"]));
                }
            } else if ($_POST["but"] == "Autre") {
                $actnb = (trim(htmlspecialchars($_POST["actenb"])));
                if (isset($_POST["libacte"])) {
                    $libactea = trim(htmlspecialchars($_POST["libacte"]));
                    $prixactea = trim(htmlspecialchars($_POST["prixacte"]));
                }
            } else {
                $ordonb = (trim(htmlspecialchars($_POST["ordonnancenb"])));
                if (isset($_POST["libordonnance"])) {
                    $libordonnancea = trim(htmlspecialchars($_POST["libordonnance"]));
                    $uniteordonnancea = trim(htmlspecialchars($_POST["uniteordonnance"]));
                    $qteordonnancea = trim(htmlspecialchars($_POST["qteordonnance"]));
                    $prixuordonnancea = trim(htmlspecialchars($_POST["prixuordonnance"]));
                    $prixtordonnancea = trim(htmlspecialchars($_POST["prixtordonnance"]));
                }
            }

            $_SESSION['formpatient'][NUM_PAGE - 1] = array(
                'idpatient' => strtoupper(trim(htmlspecialchars($_POST["idpatient"]))),
                'recherche' => ucwords(trim(htmlspecialchars($_POST["recherche"]))),
                'nom' => trim(htmlspecialchars($_POST["nom"])),
                'prenom' => trim(htmlspecialchars($_POST["prenom"])),
                'tel' => trim(htmlspecialchars($_POST["tel"])),
                'telc' => trim(htmlspecialchars($_POST["telc"])),
                'sexe' => (trim(htmlspecialchars($_POST["sexe"]))),
                'datenais' => (trim(htmlspecialchars($_POST["datenais"]))),
                'lieunais' => (trim(htmlspecialchars($_POST["lieunais"]))),
                'sitmat' => (trim(htmlspecialchars($_POST["sitmat"]))),
                'profession' => (trim(htmlspecialchars($_POST["profession"]))),
                'residence' => (trim(htmlspecialchars($_POST["residence"]))),
                'datejourp' => (trim(htmlspecialchars($_POST["datejourp"]))),
                'heurejourp' => (trim(htmlspecialchars($_POST["heurejourp"]))),
//                'residencelib' => trim(htmlspecialchars($_POST["residencelib"])),
                'but' => (trim(htmlspecialchars($_POST["but"]))),
                'montantc' => (trim(htmlspecialchars($_POST["montantc"]))),
                'montante' => (trim(htmlspecialchars($_POST["montante"]))),
                'montanto' => (trim(htmlspecialchars($_POST["montanto"]))),
                'montantcp' => (trim(htmlspecialchars($_POST["montantcp"]))),
                'montantec' => (trim(htmlspecialchars($_POST["montantec"]))),
                'montantv' => (trim(htmlspecialchars($_POST["montantv"]))),
                'montanta' => (trim(htmlspecialchars($_POST["montanta"]))),
                'consultation' => $consul,
                'prenatale' => $consulpren,
                'vaccin' => $vacc,
                'examennb' => $examnb,
                'libexamen' => $libexamena,
                'prixexamen' => $prixexamena,
                'echographienb' => $echonb,
                'libechographie' => $libechographiea,
                'prixechographie' => $prixechographiea,
                'actenb' => $actnb,
                'libacte' => $libactea,
                'prixacte' => $prixactea,
                'ordonnancenb' => $ordonb,
                'libordonnance' => $libordonnancea,
                'uniteordonnance' => $uniteordonnancea,
                'qteordonnance' => $qteordonnancea,
                'prixuordonnance' => $prixuordonnancea,
                'prixtordonnance' => $prixtordonnancea,
            );
            
            $nbqex = trim(htmlspecialchars($_POST["examennb"]));

            for ($i = 0; $i < $nbqex; $i++) {
                $_SESSION['formpatient'][NUM_PAGE - 1]['libexamen' . $i] = trim(htmlspecialchars($_POST["libexamen" . $i]));
                $_SESSION['formpatient'][NUM_PAGE - 1]['prixexamen' . $i] = trim(htmlspecialchars($_POST["prixexamen" . $i]));
            }
            
            $nbqec = trim(htmlspecialchars($_POST["echographienb"]));

            for ($i = 0; $i < $nbqec; $i++) {
                $_SESSION['formpatient'][NUM_PAGE - 1]['libechographie' . $i] = trim(htmlspecialchars($_POST["libechographie" . $i]));
                $_SESSION['formpatient'][NUM_PAGE - 1]['prixechographie' . $i] = trim(htmlspecialchars($_POST["prixechographie" . $i]));
            }
            
            $nbqa = trim(htmlspecialchars($_POST["actenb"]));

            for ($i = 0; $i < $nbqa; $i++) {
                $_SESSION['formpatient'][NUM_PAGE - 1]['libacte' . $i] = trim(htmlspecialchars($_POST["libacte" . $i]));
                $_SESSION['formpatient'][NUM_PAGE - 1]['prixacte' . $i] = trim(htmlspecialchars($_POST["prixacte" . $i]));
            }
            
            $nbqor = trim(htmlspecialchars($_POST["ordonnancenb"]));

            for ($i = 0; $i < $nbqor; $i++) {
                $_SESSION['formpatient'][NUM_PAGE - 1]['libordonnance' . $i] = trim(htmlspecialchars($_POST["libordonnance" . $i]));
                $_SESSION['formpatient'][NUM_PAGE - 1]['uniteordonnance' . $i] = trim(htmlspecialchars($_POST["uniteordonnance" . $i]));
                $_SESSION['formpatient'][NUM_PAGE - 1]['qteordonnance' . $i] = trim(htmlspecialchars($_POST["qteordonnance" . $i]));
                $_SESSION['formpatient'][NUM_PAGE - 1]['prixuordonnance' . $i] = trim(htmlspecialchars($_POST["prixuordonnance" . $i]));
                $_SESSION['formpatient'][NUM_PAGE - 1]['prixtordonnance' . $i] = trim(htmlspecialchars($_POST["prixtordonnance" . $i]));
            }
        }
        if ((isset($erreurprod)) && ($erreurprod)) {
            $pag = 'hopitalpages/hopitalpatient/hopitalajouter/ajout_patient';
            $stag = 1;
            die('<meta http-equiv="refresh" content="0; URL=' . $url . '?page=' . base64_encode($pag) . '&pagecom=' . $stag . '">');
        } else {
            require('hopitalpages/hopitalpatient/hopitalajouter/form_terminer.php');
            break;
        }

    case 1:
    default:
        // Valeurs par défaut
        if (empty($_SESSION['formpatient'][NUM_PAGE])) {

            $_SESSION['formpatient'][NUM_PAGE] = array(
                'recherche' => '',
                'idpatient' => '',
                'nom' => '',
                'prenom' => '',
                'tel' => '',
                'telc' => '',
                'sexe' => '',
                'datenais' => NULL,
                'lieunais' => '',
                'sitmat' => '',
                'profession' => '',
                'residence' => '',
                'datejourp' => '',
                'heurejourp' => '',
//                'residencelib' => '',
                'but' => 'Consultation',
                'montantc' => '',
                'consultation' => '',
                
                'montante' => '',
                'examennb' => 0,
                'libexamen' => '',
                'prixexamen' => '',
                
                'montanto' => '',
                'ordonnancenb' => 0,
                'libordonnance' => '',
                'qteordonnance' => '',
                'uniteordonnance' => '',
                'prixuordonnance' => '',
                'prixtordonnance' => '',
                
                'montantv' => '',
                'vaccin' => '',
                
                'montantcp' => '',
                'prenatale' => '',
                
                'montantec' => '',
                'echographienb' => 0,
                'libechographie' => '',
                'prixechographie' => '',
                
                'montanta' => '',
                'actenb' => 0,
                'libacte' => '',
                'prixacte' => ''
               
            );
        }
        require('hopitalpages/hopitalpatient/hopitalajouter/form_ajouter_patient.php');
        break;
}