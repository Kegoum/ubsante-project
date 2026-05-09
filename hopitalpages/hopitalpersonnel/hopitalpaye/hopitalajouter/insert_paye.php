
<?php

    if (isset($_REQUEST["idpersonnel"])) {
        $id = $_REQUEST["idpersonnel"];
        $rslt = $con->query("select * from hp_personnel as pe left join hp_affectation as af on "
            . "pe.idpersonnel=af.idpersonnel left join hp_service as s on af.idservice=s.idservice "
            . "where af.etataffectation=true and pe.idpersonnel='" . $id . "'") or die(mysqli_error($con));
        $row = mysqli_fetch_assoc($rslt);
        $rsltec = $con->query("select * from hp_proprietaire as pe where pe.etatproprietaire=true limit 0,1") or die(mysqli_error($con));
        $rowecol = mysqli_fetch_assoc($rsltec);
// Récupération du numéro de l'étape en 
        if (empty($_GET['pagecom']) or ! is_numeric($_GET['pagecom'])) {
            define('NUM_PAGE', 1);
        } else {
            // En situation réelle, il faudrait vérifier l'existence de cette page
            define('NUM_PAGE', intval($_GET['pagecom']));
        }

// Déclaration de la variable de session
        if (empty($_SESSION['formpaye'])) {
            $_SESSION['formpaye'] = array();
        }
        if (empty($_SESSION['formpaye'])) {
            $_SESSION['formpaye'] = array();
            $_SESSION['formpaye'][1] = array(
                'idpersonnel' => $_REQUEST["idpersonnel"],
                'nome' => $row["nompersonnel"] . " " . $row["prenompersonnel"],
                'nopointage' => $row["codepersonnel"],
                'emploi' => $row["rolepersonnel"],
//                'nocontribuablee' => $row["nocontribuablee"],
//                'nocnpse' => $row["nocnpse"],
                
                'typepaiement' => $row["typepaiement"],
                'nbeffectue' => '',
                'libeffectue' => '',
                'qteeffectue' => '',
                'prixueffectue' => '',
                'prixteffectue' => '',
                
                'nbjeffectue' => '',
                'libjeffectue' => '',
                'prixjeffectue' => '',
                
                'nbmeffectue' => '',
                'libmeffectue' => '',
                'prixumeffectue' => $row["salaireaffectation"],
                'prixtmeffectue' => '',
                
                'datejoureffectue' => '',
//                'paiementeffectue' => '',
                'salairebase' => '',
                'heuresup' => '',
                'heure15' => '',
                'heure20' => '',
                'heure30' => '',
                'heure40' => '',
                'heure50' => '',
                'prime' => '',
                'anciennep' => '',
                'rendementp' => '',
                'logementp' => '',
                'indemnite' => '',
                'caissei' => '',
                'deplacementi' => '',
                'representationi' => '',
                'remunerationbrute' => '',
                'retenuefiscales' => '',
                'irpp' => '',
                'cac' => '',
                'taxec' => '',
                'redevanceaudio' => '',
                'creditf' => '',
                'fne' => '',
                'retenuesociales' => '',
                'cnps' => '',
                'autresretenue' => '',
                'acomptes' => '',
                'avancee' => '',
                'saisiearret' => '',
                'cotisations' => '',
                'autre' => '',
                'totalretenue' => '',
                'netapayer' => ''
            );
        }
        switch (NUM_PAGE) {

            case 3:

                // Récupération des informations du formulaire précédent
                
                    require('hopitalpages/hopitalpersonnel/hopitalpaye/hopitalajouter/form_terminer.php');
                    break;
case 2:

                // Récupération des informations du formulaire précédent
                if (!empty($_POST)) {
                    $erreurprod = FALSE;
                    $tabnbh = array();
                    $tabnbhj = array();
                    $tabnbhm = array();
                    
                    $nbe = $_SESSION['formpaye'][NUM_PAGE - 1]["nbeffectue"];
            $libe = $_SESSION['formpaye'][NUM_PAGE - 1]["libeffectue"];
            $qtee = $_SESSION['formpaye'][NUM_PAGE - 1]["qteeffectue"];
            $prixue = $_SESSION['formpaye'][NUM_PAGE - 1]["prixueffectue"];
            $prixte = $_SESSION['formpaye'][NUM_PAGE - 1]["prixteffectue"];
                    $nbej = $_SESSION['formpaye'][NUM_PAGE - 1]["nbjeffectue"];
            $libej = $_SESSION['formpaye'][NUM_PAGE - 1]["libjeffectue"];
            $prixtej = $_SESSION['formpaye'][NUM_PAGE - 1]["prixjeffectue"];
                    $nbem = $_SESSION['formpaye'][NUM_PAGE - 1]["nbmeffectue"];
            $libem = $_SESSION['formpaye'][NUM_PAGE - 1]["libmeffectue"];
            $prixuem = $_SESSION['formpaye'][NUM_PAGE - 1]["prixumeffectue"];
            $prixtem = $_SESSION['formpaye'][NUM_PAGE - 1]["prixtmeffectue"];
             if ($_SESSION['formpaye'][1]['typepaiement']=="Mois") {
                 $nbem = trim(htmlspecialchars($_POST["nbmeffectue"]));
                if (isset($_POST["libmeffectue"])) {
                    $libem = trim(htmlspecialchars($_POST["libmeffectue"]));
                    $prixuem = trim(htmlspecialchars($_POST["prixumeffectue"]));
                    $prixtem = trim(htmlspecialchars($_POST["prixtmeffectue"]));
                }
             } else if ($_SESSION['formpaye'][1]['typepaiement']=="Jour") {
                 $nbej = trim(htmlspecialchars($_POST["nbjeffectue"]));
                if (isset($_POST["libjeffectue"])) {
                    $libej = trim(htmlspecialchars($_POST["libjeffectue"]));
                    $prixtej = trim(htmlspecialchars($_POST["prixjeffectue"]));
                }
             } else if ($_SESSION['formpaye'][1]['typepaiement']=="Heure") {
                 $nbe = trim(htmlspecialchars($_POST["nbeffectue"]));
                if (isset($_POST["libeffectue"])) {
                    $libe = trim(htmlspecialchars($_POST["libeffectue"]));
                    $qtee = trim(htmlspecialchars($_POST["qteeffectue"]));
                    $prixue = trim(htmlspecialchars($_POST["prixueffectue"]));
                    $prixte = trim(htmlspecialchars($_POST["prixteffectue"]));
                }
             }
                    $_SESSION['formpaye'][NUM_PAGE - 1] = array(
                        'idpersonnel' => $_REQUEST["idpersonnel"],
                        'nome' => trim(htmlspecialchars($_POST["nome"])),
                        'nopointage' => trim(htmlspecialchars($_POST["nopointage"])),
                        'emploi' => trim(htmlspecialchars($_POST["emploi"])),
//                        'nocontribuablee' => trim(htmlspecialchars($_POST["nocontribuablee"])),
//                        'nocnpse' => trim(htmlspecialchars($_POST["nocnpse"])),
                        
                        'typepaiement' => trim(htmlspecialchars($_POST["typepaiement"])),
                        'libeffectue' => $libe,
                        'qteeffectue' => $qtee,
                        'prixueffectue' => $prixue,
                        'prixteffectue' => $prixte,
                        'nbeffectue' => $nbe,
                        
                        'libjeffectue' => $libej,
                        'prixjeffectue' => $prixtej,
                        'nbjeffectue' => $nbej,
                        
                        'libmeffectue' => $libem,
                        'prixumeffectue' => $prixuem,
                        'prixtmeffectue' => $prixtem,
                        'nbmeffectue' => $nbem,
                        
                        'datejoureffectue' => trim(htmlspecialchars($_POST["datejoureffectue"])),
//                        'paiementeffectue' => trim(htmlspecialchars($_POST["paiementeffectue"])),
                        'salairebase' => floatval(trim(htmlspecialchars($_POST["salairebase"]))),
                        'heuresup' => floatval(trim(htmlspecialchars($_POST["heuresup"]))),
                        'heure15' => floatval(trim(htmlspecialchars($_POST["heure15"]))),
                        'heure20' => floatval(trim(htmlspecialchars($_POST["heure20"]))),
                        'heure30' => floatval(trim(htmlspecialchars($_POST["heure30"]))),
                        'heure40' => floatval(trim(htmlspecialchars($_POST["heure40"]))),
                        'heure50' => floatval(trim(htmlspecialchars($_POST["heure50"]))),
                        'prime' => floatval(trim(htmlspecialchars($_POST["prime"]))),
                        'anciennep' => floatval(trim(htmlspecialchars($_POST["anciennep"]))),
                        'rendementp' => floatval(trim(htmlspecialchars($_POST["rendementp"]))),
                        'logementp' => floatval(trim(htmlspecialchars($_POST["logementp"]))),
                        'indemnite' => floatval(trim(htmlspecialchars($_POST["indemnite"]))),
                        'caissei' => floatval(trim(htmlspecialchars($_POST["caissei"]))),
                        'deplacementi' => floatval(trim(htmlspecialchars($_POST["deplacementi"]))),
                        'representationi' => floatval(trim(htmlspecialchars($_POST["representationi"]))),
                        'remunerationbrute' => floatval(trim(htmlspecialchars($_POST["remunerationbrute"]))),
                        'retenuefiscales' => floatval(trim(htmlspecialchars($_POST["retenuefiscales"]))),
                        'irpp' => floatval(trim(htmlspecialchars($_POST["irpp"]))),
                        'cac' => floatval(trim(htmlspecialchars($_POST["cac"]))),
                        'taxec' => floatval(trim(htmlspecialchars($_POST["taxec"]))),
                        'redevanceaudio' => floatval(trim(htmlspecialchars($_POST["redevanceaudio"]))),
                        'creditf' => floatval(trim(htmlspecialchars($_POST["creditf"]))),
                        'fne' => floatval(trim(htmlspecialchars($_POST["fne"]))),
                        'retenuesociales' => floatval(trim(htmlspecialchars($_POST["retenuesociales"]))),
                        'cnps' => floatval(trim(htmlspecialchars($_POST["cnps"]))),
                        'autresretenue' => floatval(trim(htmlspecialchars($_POST["autresretenue"]))),
                        'acomptes' => floatval(trim(htmlspecialchars($_POST["acomptes"]))),
                        'avancee' => floatval(trim(htmlspecialchars($_POST["avancee"]))),
                        'saisiearret' => floatval(trim(htmlspecialchars($_POST["saisiearret"]))),
                        'cotisations' => floatval(trim(htmlspecialchars($_POST["cotisations"]))),
                        'autre' => floatval(trim(htmlspecialchars($_POST["autre"]))),
                        'totalretenue' => floatval(trim(htmlspecialchars($_POST["totalretenue"]))),
                        'netapayer' => floatval(trim(htmlspecialchars($_POST["netapayer"])))
                    );
                    $nbqmo = trim(htmlspecialchars($_POST["nbeffectue"]));
                    $tabnbh[0] = $_POST["libeffectue"];
                    $a = 1;
                    for ($i = 0; $i < $nbqmo; $i++) {
                        $_SESSION['formpaye'][NUM_PAGE - 1]['libeffectue' . $i] = trim(htmlspecialchars($_POST["libeffectue" . $i]));
                        $_SESSION['formpaye'][NUM_PAGE - 1]['qteeffectue' . $i] = trim(htmlspecialchars($_POST["qteeffectue" . $i]));
                        $_SESSION['formpaye'][NUM_PAGE - 1]['prixueffectue' . $i] = trim(htmlspecialchars($_POST["prixueffectue" . $i]));
                        $_SESSION['formpaye'][NUM_PAGE - 1]['prixteffectue' . $i] = trim(htmlspecialchars($_POST["prixteffectue" . $i]));
                        foreach ($tabnbh as $key => $value) {
                            if ($tabnbh[$key] == $_POST["libeffectue" . $i]) {
                                $erreurprod = TRUE;
                            }
                        }

                        $tabnbh[$a] = $_POST["libeffectue" . $i];
                        $a = $a + 1;
                    }
                    
                    $nbqmoj = trim(htmlspecialchars($_POST["nbjeffectue"]));
                    $tabnbhj[0] = $_POST["libjeffectue"];
                    $aj = 1;
                    for ($i = 0; $i < $nbqmoj; $i++) {
                        $_SESSION['formpaye'][NUM_PAGE - 1]['libjeffectue' . $i] = trim(htmlspecialchars($_POST["libjeffectue" . $i]));
                        $_SESSION['formpaye'][NUM_PAGE - 1]['prixjeffectue' . $i] = trim(htmlspecialchars($_POST["prixjeffectue" . $i]));
                        foreach ($tabnbhj as $key => $value) {
                            if ($tabnbhj[$key] == $_POST["libjeffectue" . $i]) {
                                $erreurprod = TRUE;
                            }
                        }

                        $tabnbhj[$a] = $_POST["libjeffectue" . $i];
                        $aj = $aj + 1;
                    }
                    
                }
                if ((isset($erreurprod)) && ($erreurprod)) {
                    echo "<script language='javascript'>$('div.addceko').show('slow').delay(8000).hide('slow');</script>";
                    $pag = 'hopitalpages/hopitalpersonnel/hopitalpaye/hopitalajouter/insert_paye';
                    $stag = 1;
                    die('<meta http-equiv="refresh" content="5; URL=' . $url . '?page=' . base64_encode($pag) . '&pagecom=' . $stag . '&idpersonnel=' . $_REQUEST["idpersonnel"] . '">');
                } else {
                    require('hopitalpages/hopitalpersonnel/hopitalpaye/hopitalajouter/form_paye_confirmation.php');
                    break;
                }

            case 1:
            default:
                // Valeurs par défaut
                if (empty($_SESSION['formpaye'][NUM_PAGE])) {

                    $_SESSION['formpaye'][NUM_PAGE] = array(
                'idpersonnel' => $_REQUEST["idpersonnel"],
                'nome' => $row["nompersonnel"] . " " . $row["prenompersonnel"],
                'nopointage' => $row["codepersonnel"],
                'emploi' => $row["rolepersonnel"],
//                'nocontribuablee' => $row["nocontribuablee"],
//                'nocnpse' => $row["nocnpse"],
                        
                'typepaiement' => $row["typepaiement"],
                'nbeffectue' => '',
                'libeffectue' => '',
                'qteeffectue' => '',
                'prixueffectue' => '',
                'prixteffectue' => '',
                
                'nbjeffectue' => '',
                'libjeffectue' => '',
                'prixjeffectue' => '',
                
                'nbmeffectue' => '',
                'libmeffectue' => '',
                'prixumeffectue' => $row["salaireaffectation"],
                'prixtmeffectue' => '',
                
                'datejoureffectue' => '',
//                'paiementeffectue' => '',
                'salairebase' => '',
                'heuresup' => '',
                'heure15' => '',
                'heure20' => '',
                'heure30' => '',
                'heure40' => '',
                'heure50' => '',
                'prime' => '',
                'anciennep' => '',
                'rendementp' => '',
                'logementp' => '',
                'indemnite' => '',
                'caissei' => '',
                'deplacementi' => '',
                'representationi' => '',
                'remunerationbrute' => '',
                'retenuefiscales' => '',
                'irpp' => '',
                'cac' => '',
                'taxec' => '',
                'redevanceaudio' => '',
                'creditf' => '',
                'fne' => '',
                'retenuesociales' => '',
                'cnps' => '',
                'autresretenue' => '',
                'acomptes' => '',
                'avancee' => '',
                'saisiearret' => '',
                'cotisations' => '',
                'autre' => '',
                'totalretenue' => '',
                'netapayer' => ''
                    );
                } else if (($_SESSION['formpaye'][NUM_PAGE]["idpersonnel"] != $_REQUEST["idpersonnel"])) {
                    $_SESSION['formpaye'][NUM_PAGE] = array(
                'idpersonnel' => $_REQUEST["idpersonnel"],
                'nome' => $row["nompersonnel"] . " " . $row["prenompersonnel"],
                'nopointage' => $row["codepersonnel"],
                'emploi' => $row["rolepersonnel"],
//                'nocontribuablee' => $row["nocontribuablee"],
//                'nocnpse' => $row["nocnpse"],
                        
                'typepaiement' => $row["typepaiement"],
                'nbeffectue' => '',
                'libeffectue' => '',
                'qteeffectue' => '',
                'prixueffectue' => '',
                'prixteffectue' => '',
                
                'nbjeffectue' => '',
                'libjeffectue' => '',
                'prixjeffectue' => '',
                
                'nbmeffectue' => '',
                'libmeffectue' => '',
                'prixumeffectue' => $row["salaireaffectation"],
                'prixtmeffectue' => '',
                
                'datejoureffectue' => '',
//                'paiementeffectue' => '',
                'salairebase' => '',
                'heuresup' => '',
                'heure15' => '',
                'heure20' => '',
                'heure30' => '',
                'heure40' => '',
                'heure50' => '',
                'prime' => '',
                'anciennep' => '',
                'rendementp' => '',
                'logementp' => '',
                'indemnite' => '',
                'caissei' => '',
                'deplacementi' => '',
                'representationi' => '',
                'remunerationbrute' => '',
                'retenuefiscales' => '',
                'irpp' => '',
                'cac' => '',
                'taxec' => '',
                'redevanceaudio' => '',
                'creditf' => '',
                'fne' => '',
                'retenuesociales' => '',
                'cnps' => '',
                'autresretenue' => '',
                'acomptes' => '',
                'avancee' => '',
                'saisiearret' => '',
                'cotisations' => '',
                'autre' => '',
                'totalretenue' => '',
                'netapayer' => ''
                    );
                }
                require('hopitalpages/hopitalpersonnel/hopitalpaye/hopitalajouter/form_paye.php');
                break;
        }
    }
