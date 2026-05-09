
<?php

if (isset($_REQUEST["personnel"])) {
    $id = $_REQUEST["personnel"];
    $rslt = $con->query("select * from hotel_personnel as pe left join hotel_affectation as af on "
            . "pe.id_personnel=af.id_personnel left join service_point_hotel as spa on "
            . "af.id_service_point_hotel=spa.id_service_point_hotel left join hotel_point_hotel as pa on "
            . "spa.id_point_hotel=pa.id_point_hotel left join hotel_service as s on spa.id_service=s.id_service "
            . "where pe.id_personnel='" . $id . "'") or die(mysqli_error($con));
    $row = mysqli_fetch_assoc($rslt);
// Récupération du numéro de l'étape en cours
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
            'idpersonnel' => $_REQUEST["personnel"],
            'datedebutp' => '',
            'datefinp' => '',
            'nome' => $row["nom_pe"] . " " . $row["prenom_pe"],
            'nopointage' => $row["code_pe"],
            'emploi' => $row["nom_service"],
            'nocontribuablee' => $row["no_contribuable_pe"],
            'nocnpse' => $row["no_cnps_pe"],
            'salairebase' => $row["salaire_personnel"],
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

        case 2:

            // Récupération des informations du formulaire précédent
            if (!empty($_POST)) {
                $erreurprod = FALSE;
                $_SESSION['formpaye'][NUM_PAGE - 1] = array(
            'idpersonnel' => $_REQUEST["personnel"],
            'datedebutp' => trim(htmlspecialchars($_POST["datedebutp"])),
            'datefinp' => trim(htmlspecialchars($_POST["datefinp"])),
            'nome' => trim(htmlspecialchars($_POST["nome"])),
            'nopointage' => trim(htmlspecialchars($_POST["nopointage"])),
            'emploi' => trim(htmlspecialchars($_POST["emploi"])),
            'nocontribuablee' => trim(htmlspecialchars($_POST["nocontribuablee"])),
            'nocnpse' => trim(htmlspecialchars($_POST["nocnpse"])),
            'salairebase' => trim(htmlspecialchars($_POST["salairebase"])),
            'heuresup' => trim(htmlspecialchars($_POST["heuresup"])),
            'heure15' => trim(htmlspecialchars($_POST["heure15"])),
            'heure20' => trim(htmlspecialchars($_POST["heure20"])),
            'heure30' => trim(htmlspecialchars($_POST["heure30"])),
            'heure40' => trim(htmlspecialchars($_POST["heure40"])),
            'heure50' => trim(htmlspecialchars($_POST["heure50"])),
            'prime' => trim(htmlspecialchars($_POST["prime"])),
            'anciennep' => trim(htmlspecialchars($_POST["anciennep"])),
            'rendementp' => trim(htmlspecialchars($_POST["rendementp"])),
            'logementp' => trim(htmlspecialchars($_POST["logementp"])),
            'indemnite' => trim(htmlspecialchars($_POST["indemnite"])),
            'caissei' => trim(htmlspecialchars($_POST["caissei"])),
            'deplacementi' => trim(htmlspecialchars($_POST["deplacementi"])),
            'representationi' => trim(htmlspecialchars($_POST["representationi"])),
            'remunerationbrute' => trim(htmlspecialchars($_POST["remunerationbrute"])),
            'retenuefiscales' => trim(htmlspecialchars($_POST["retenuefiscales"])),
            'irpp' => trim(htmlspecialchars($_POST["irpp"])),
            'cac' => trim(htmlspecialchars($_POST["cac"])),
            'taxec' => trim(htmlspecialchars($_POST["taxec"])),
            'redevanceaudio' => trim(htmlspecialchars($_POST["redevanceaudio"])),
            'creditf' => trim(htmlspecialchars($_POST["creditf"])),
            'fne' => trim(htmlspecialchars($_POST["fne"])),
            'retenuesociales' => trim(htmlspecialchars($_POST["retenuesociales"])),
            'cnps' => trim(htmlspecialchars($_POST["cnps"])),
            'autresretenue' => trim(htmlspecialchars($_POST["autresretenue"])),
            'acomptes' => trim(htmlspecialchars($_POST["acomptes"])),
            'avancee' => trim(htmlspecialchars($_POST["avancee"])),
            'saisiearret' => trim(htmlspecialchars($_POST["saisiearret"])),
            'cotisations' => trim(htmlspecialchars($_POST["cotisations"])),
            'autre' => trim(htmlspecialchars($_POST["autre"])),
            'totalretenue' => trim(htmlspecialchars($_POST["totalretenue"])),
            'netapayer' => trim(htmlspecialchars($_POST["netapayer"]))
                );
            }

            if ((isset($erreurprod)) && ($erreurprod)) {
                $pag = 'hotelpages/personnelhotel/payepersonnelhotel/hotelajouter/insert_paye';
                $stag = 1;
                if (isset($_SESSION["login_proprietaire"]) && (isset($_SESSION["mot_de_passe_proprietaire"]))) {
                    die('<meta http-equiv="refresh" content="4; URL=indexadmin.php?page=' . base64_encode($pag) . '&pagecom=' . $stag . '">');
                } else if (isset($_SESSION["login_personnel"]) && (isset($_SESSION["mot_de_passe_personnel"])) && ($_SESSION["etat_compte_personnel"])) {
                    if (($_SESSION["code_service"] == "ECONO")) {
                        die('<meta http-equiv="refresh" content="4; URL=indexpersonnel.php?page=' . base64_encode($pag) . '&pagecom=' . $stag . '">');
                    }
                }
            } else {
                require('hotelpages/personnelhotel/payepersonnelhotel/hotelajouter/form_terminer.php');
                break;
            }

        case 1:
        default:
            // Valeurs par défaut
            if (empty($_SESSION['formpaye'][NUM_PAGE])) {

                $_SESSION['formpaye'][NUM_PAGE] = array(
                    'idpersonnel' => $_REQUEST["personnel"],
                    'datedebutp' => '',
                    'datefinp' => '',
                    'nome' => $row["nom_pe"] . " " . $row["prenom_pe"],
                    'nopointage' => $row["code_pe"],
                    'emploi' => $row["nom_service"],
                    'nocontribuablee' => $row["no_contribuable_pe"],
                    'nocnpse' => $row["no_cnps_pe"],
                    'salairebase' => $row["salaire_personnel"],
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
            } else if (($_SESSION['formpaye'][NUM_PAGE]["idpersonnel"] != $_REQUEST["personnel"])) {
                $_SESSION['formpaye'][NUM_PAGE] = array(
                    'idpersonnel' => $_REQUEST["personnel"],
                    'datedebutp' => '',
                    'datefinp' => '',
                    'nome' => $row["nom_pe"] . " " . $row["prenom_pe"],
                    'nopointage' => $row["code_pe"],
                    'emploi' => $row["nom_service"],
                    'nocontribuablee' => $row["no_contribuable_pe"],
                    'nocnpse' => $row["no_cnps_pe"],
                    'salairebase' => $row["salaire_personnel"],
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
            require('hotelpages/personnelhotel/payepersonnelhotel/hotelajouter/form_paye.php');
            break;
    }
}