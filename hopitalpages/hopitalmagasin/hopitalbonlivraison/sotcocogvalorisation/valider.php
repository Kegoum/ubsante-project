
<?php

if (isset($_REQUEST["idlignebonlivraison"])) {
    $idm = $_REQUEST["idlignebonlivraison"];
    $rslt = $con->query("select * from sot_ligne_bon_livraison as lbl left join sot_ligne_bon_commande as lbc on "
            . "lbl.idligneboncommande=lbc.idligneboncommande left join sot_ligne_demande_approvisionnement as lda on "
            . "lbc.idlignedemandeapprovisionnement=lda.idlignedemandeapprovisionnement left join sot_materiaux as m "
            . "on lda.idmateriaux=m.idmateriaux left join sot_unite as u on m.idunite=u.idunite left "
            . "join sot_type_materiaux as s on m.idtypemateriaux=s.idtypemateriaux left join sot_valorisation_stock "
            . "as v on m.idvalorisationstock=v.idvalorisationstock where "
            . "lbl.idlignebonlivraison='" . $_REQUEST["idlignebonlivraison"] . "'") or die(mysqli_error($con));
    $row = mysqli_fetch_assoc($rslt);
    $rsltda = $con->query("select * from sot_demande_approvisionnement as da where da.iddemandeapprovisionnement='" . $row["iddemandeapprovisionnement"] . "'") or die(mysqli_error($con));
    $rowda = mysqli_fetch_assoc($rsltda);
	if($rowda["idmagasin"]!=NULL){
	$rsltdam = $con->query("select * from sot_magasin as m where m.idmagasin='" . $rowda["idmagasin"] . "'") or die(mysqli_error($con));
    $rowdam = mysqli_fetch_assoc($rsltdam);
    $rslti = $con->query("select * from sot_ligne_magasin as lm where "
            . "lm.idmateriaux='" . $row["idmateriaux"] . "' and lm.idmagasin='" . $rowda["idmagasin"] . "'") or die(mysqli_error($con));
    $nbi = mysqli_num_rows($rslti);
    $qi = 0;
    $pi = 0;
    $ti = 0;
    if ($nbi != 0) {
        $rowi = mysqli_fetch_assoc($rslti);

        $qi = $rowi["quantitelignemagasin"];
        $pi = $rowi["prixunitairelignemagasin"];
        $ti = ($qi * $pi);
    }
    $qe = $row["quantitelignebonlivraison"];
    $pe = $row["prixunitairelignebonlivraison"];
    $te = ($qe * $pe);
    $qr = ($qi + $qe);
    $pr = 0;
    $tr = 0;
    if ($row["codevalorisationstock"] == "CUMPFE") {
        $tr = $ti + $te;
        $pr = $tr / $qr;
    }

    // Configuration du script
    // Affichage du menu en haut de la page
    $items = array();

// Récupération du numéro de l'étape en cours
    if (empty($_GET['pagecom']) or ! is_numeric($_GET['pagecom'])) {
        define('NUM_PAGE', 1);
    } else {
        // En situation réelle, il faudrait vérifier l'existence de cette page
        define('NUM_PAGE', intval($_GET['pagecom']));
    }

// Déclaration de la variable de session
    if (empty($_SESSION['formvalorisation'])) {
        $_SESSION['formvalorisation'] = array();
    }
    if (empty($_SESSION['formvalorisation'])) {
        $_SESSION['formvalorisation'][1] = array(
            'idlignebonlivraison' => $_REQUEST["idlignebonlivraison"],
            'datejour' => '',
            'transport' => 0,
            'fraisgestion' => 0,
            'qtei' => $qi,
            'prixui' => $pi,
            'prixti' => ($ti),
            'qtee' => $qe,
            'prixue' => $pe,
            'prixte' => ($te),
            'qter' => ($qr),
            'prixur' => $pr,
            'prixtr' => $tr,
            'valorisation' => $row["idvalorisationstock"],
            'codevalorisation' => $row["codevalorisationstock"]
        );
    }

    switch (NUM_PAGE) {

        case 2:
            // Valeurs par défaut
            // Récupération des informations du formulaire précédent
            if (!empty($_POST)) {
                $_SESSION['formvalorisation'][NUM_PAGE - 1] = array(
                    'idlignebonlivraison' => $_REQUEST["idlignebonlivraison"],
            'datejour' => trim(htmlspecialchars($_POST["datejour"])),
                    'transport' => trim(htmlspecialchars($_POST["transport"])),
                    'fraisgestion' => trim(htmlspecialchars($_POST["fraisgestion"])),
                    'qtei' => trim(htmlspecialchars($_POST["qtei"])),
                    'prixui' => trim(htmlspecialchars($_POST["prixui"])),
                    'prixti' => (trim(htmlspecialchars($_POST["prixti"]))),
                    'qtee' => trim(htmlspecialchars($_POST["qtee"])),
                    'prixue' => trim(htmlspecialchars($_POST["prixue"])),
                    'prixte' => (trim(htmlspecialchars($_POST["prixte"]))),
                    'qter' => (trim(htmlspecialchars($_POST["qter"]))),
                    'prixur' => trim(htmlspecialchars($_POST["prixur"])),
                    'prixtr' => trim(htmlspecialchars($_POST["prixtr"])),
                    'valorisation' => trim(htmlspecialchars($_POST["valorisation"])),
                    'codevalorisation' => trim(htmlspecialchars($_POST["codevalorisation"]))
                );
            }

            require('sotcocogpages/sotcocogbonlivraison/sotcocogvalorisation/form_terminer.php');
            break;

        case 1:
        default:
            // Valeurs par défaut
            if (empty($_SESSION['formvalorisation'][NUM_PAGE])) {
                $_SESSION['formvalorisation'][NUM_PAGE] = array(
                    'idlignebonlivraison' => $_REQUEST["idlignebonlivraison"],
            'datejour' => '',
                    'transport' => 0,
                    'fraisgestion' => 0,
                    'qtei' => $qi,
                    'prixui' => $pi,
                    'prixti' => ($ti),
                    'qtee' => $qe,
                    'prixue' => $pe,
                    'prixte' => ($te),
                    'qter' => ($qr),
                    'prixur' => $pr,
                    'prixtr' => $tr,
                    'valorisation' => $row["idvalorisationstock"],
                    'codevalorisation' => $row["codevalorisationstock"]
                );
            } else if (($_SESSION['formvalorisation'][NUM_PAGE]["idlignebonlivraison"] != $_REQUEST["idlignebonlivraison"])) {

                $_SESSION['formvalorisation'][NUM_PAGE] = array(
                    'idlignebonlivraison' => $_REQUEST["idlignebonlivraison"],
            'datejour' => '',
                    'transport' => 0,
                    'fraisgestion' => 0,
                    'qtei' => $qi,
                    'prixui' => $pi,
                    'prixti' => ($ti),
                    'qtee' => $qe,
                    'prixue' => $pe,
                    'prixte' => ($te),
                    'qter' => ($qr),
                    'prixur' => $pr,
                    'prixtr' => $tr,
                    'valorisation' => $row["idvalorisationstock"],
                    'codevalorisation' => $row["codevalorisationstock"]
                );
            }

            require('sotcocogpages/sotcocogbonlivraison/sotcocogvalorisation/form_info.php');
            break;
    }
	}else if($rowda["idpointconcassage"]!=NULL){
	$rslti = $con->query("select * from sot_materiaux_concassage_use as mcu where "
            . "mcu.idmateriaux='" . $row["idmateriaux"] . "' and mcu.idpointconcassage='" . $rowda["idpointconcassage"] . "'") or die(mysqli_error($con));
    $nbi = mysqli_num_rows($rslti);
    $qi = 0;
    $pi = 0;
    $ti = 0;
    if ($nbi != 0) {
        $rowi = mysqli_fetch_assoc($rslti);

        $qi = $rowi["quantitemateriauxconcassageuse"];
        $pi = $rowi["prixmateriauxconcassageuse"];
        $ti = ($qi * $pi);
    }
    $qe = $row["quantitelignebonlivraison"];
    $pe = $row["prixunitairelignebonlivraison"];
    $te = ($qe * $pe);
    $qr = ($qi + $qe);
    $pr = 0;
    $tr = 0;
    if ($row["codevalorisationstock"] == "CUMPFE") {
        $tr = $ti + $te;
        $pr = $tr / $qr;
    }

    // Configuration du script
    // Affichage du menu en haut de la page
    $items = array();

// Récupération du numéro de l'étape en cours
    if (empty($_GET['pagecom']) or ! is_numeric($_GET['pagecom'])) {
        define('NUM_PAGE', 1);
    } else {
        // En situation réelle, il faudrait vérifier l'existence de cette page
        define('NUM_PAGE', intval($_GET['pagecom']));
    }

// Déclaration de la variable de session
    if (empty($_SESSION['formvalorisation'])) {
        $_SESSION['formvalorisation'] = array();
    }
    if (empty($_SESSION['formvalorisation'])) {
        $_SESSION['formvalorisation'][1] = array(
            'idlignebonlivraison' => $_REQUEST["idlignebonlivraison"],
            'datejour' => '',
            'transport' => 0,
            'fraisgestion' => 0,
            'qtei' => $qi,
            'prixui' => $pi,
            'prixti' => ($ti),
            'qtee' => $qe,
            'prixue' => $pe,
            'prixte' => ($te),
            'qter' => ($qr),
            'prixur' => $pr,
            'prixtr' => $tr,
            'valorisation' => $row["idvalorisationstock"],
            'codevalorisation' => $row["codevalorisationstock"]
        );
    }

    switch (NUM_PAGE) {

        case 2:
            // Valeurs par défaut
            // Récupération des informations du formulaire précédent
            if (!empty($_POST)) {
                $_SESSION['formvalorisation'][NUM_PAGE - 1] = array(
                    'idlignebonlivraison' => $_REQUEST["idlignebonlivraison"],
            'datejour' => trim(htmlspecialchars($_POST["datejour"])),
                    'transport' => trim(htmlspecialchars($_POST["transport"])),
                    'fraisgestion' => trim(htmlspecialchars($_POST["fraisgestion"])),
                    'qtei' => trim(htmlspecialchars($_POST["qtei"])),
                    'prixui' => trim(htmlspecialchars($_POST["prixui"])),
                    'prixti' => (trim(htmlspecialchars($_POST["prixti"]))),
                    'qtee' => trim(htmlspecialchars($_POST["qtee"])),
                    'prixue' => trim(htmlspecialchars($_POST["prixue"])),
                    'prixte' => (trim(htmlspecialchars($_POST["prixte"]))),
                    'qter' => (trim(htmlspecialchars($_POST["qter"]))),
                    'prixur' => trim(htmlspecialchars($_POST["prixur"])),
                    'prixtr' => trim(htmlspecialchars($_POST["prixtr"])),
                    'valorisation' => trim(htmlspecialchars($_POST["valorisation"])),
                    'codevalorisation' => trim(htmlspecialchars($_POST["codevalorisation"]))
                );
            }

            require('sotcocogpages/sotcocogbonlivraison/sotcocogvalorisation/form_terminer.php');
            break;

        case 1:
        default:
            // Valeurs par défaut
            if (empty($_SESSION['formvalorisation'][NUM_PAGE])) {
                $_SESSION['formvalorisation'][NUM_PAGE] = array(
                    'idlignebonlivraison' => $_REQUEST["idlignebonlivraison"],
            'datejour' => '',
                    'transport' => 0,
                    'fraisgestion' => 0,
                    'qtei' => $qi,
                    'prixui' => $pi,
                    'prixti' => ($ti),
                    'qtee' => $qe,
                    'prixue' => $pe,
                    'prixte' => ($te),
                    'qter' => ($qr),
                    'prixur' => $pr,
                    'prixtr' => $tr,
                    'valorisation' => $row["idvalorisationstock"],
                    'codevalorisation' => $row["codevalorisationstock"]
                );
            } else if (($_SESSION['formvalorisation'][NUM_PAGE]["idlignebonlivraison"] != $_REQUEST["idlignebonlivraison"])) {

                $_SESSION['formvalorisation'][NUM_PAGE] = array(
                    'idlignebonlivraison' => $_REQUEST["idlignebonlivraison"],
            'datejour' => '',
                    'transport' => 0,
                    'fraisgestion' => 0,
                    'qtei' => $qi,
                    'prixui' => $pi,
                    'prixti' => ($ti),
                    'qtee' => $qe,
                    'prixue' => $pe,
                    'prixte' => ($te),
                    'qter' => ($qr),
                    'prixur' => $pr,
                    'prixtr' => $tr,
                    'valorisation' => $row["idvalorisationstock"],
                    'codevalorisation' => $row["codevalorisationstock"]
                );
            }

            require('sotcocogpages/sotcocogbonlivraison/sotcocogvalorisation/form_info.php');
            break;
    }
	}else if($rowda["idpointenrobe"]!=NULL){
	$rslti = $con->query("select * from sot_materiaux_enrobe_use as mcu where "
            . "mcu.idmateriaux='" . $row["idmateriaux"] . "' and mcu.idpointenrobe='" . $rowda["idpointenrobe"] . "'") or die(mysqli_error($con));
    $nbi = mysqli_num_rows($rslti);
    $qi = 0;
    $pi = 0;
    $ti = 0;
    if ($nbi != 0) {
        $rowi = mysqli_fetch_assoc($rslti);

        $qi = $rowi["quantitemateriauxenrobeuse"];
        $pi = $rowi["prixmateriauxenrobeuse"];
        $ti = ($qi * $pi);
    }
    $qe = $row["quantitelignebonlivraison"];
    $pe = $row["prixunitairelignebonlivraison"];
    $te = ($qe * $pe);
    $qr = ($qi + $qe);
    $pr = 0;
    $tr = 0;
    if ($row["codevalorisationstock"] == "CUMPFE") {
        $tr = $ti + $te;
        $pr = $tr / $qr;
    }

    // Configuration du script
    // Affichage du menu en haut de la page
    $items = array();

// Récupération du numéro de l'étape en cours
    if (empty($_GET['pagecom']) or ! is_numeric($_GET['pagecom'])) {
        define('NUM_PAGE', 1);
    } else {
        // En situation réelle, il faudrait vérifier l'existence de cette page
        define('NUM_PAGE', intval($_GET['pagecom']));
    }

// Déclaration de la variable de session
    if (empty($_SESSION['formvalorisation'])) {
        $_SESSION['formvalorisation'] = array();
    }
    if (empty($_SESSION['formvalorisation'])) {
        $_SESSION['formvalorisation'][1] = array(
            'idlignebonlivraison' => $_REQUEST["idlignebonlivraison"],
            'datejour' => '',
            'transport' => 0,
            'fraisgestion' => 0,
            'qtei' => $qi,
            'prixui' => $pi,
            'prixti' => ($ti),
            'qtee' => $qe,
            'prixue' => $pe,
            'prixte' => ($te),
            'qter' => ($qr),
            'prixur' => $pr,
            'prixtr' => $tr,
            'valorisation' => $row["idvalorisationstock"],
            'codevalorisation' => $row["codevalorisationstock"]
        );
    }

    switch (NUM_PAGE) {

        case 2:
            // Valeurs par défaut
            // Récupération des informations du formulaire précédent
            if (!empty($_POST)) {
                $_SESSION['formvalorisation'][NUM_PAGE - 1] = array(
                    'idlignebonlivraison' => $_REQUEST["idlignebonlivraison"],
            'datejour' => trim(htmlspecialchars($_POST["datejour"])),
                    'transport' => trim(htmlspecialchars($_POST["transport"])),
                    'fraisgestion' => trim(htmlspecialchars($_POST["fraisgestion"])),
                    'qtei' => trim(htmlspecialchars($_POST["qtei"])),
                    'prixui' => trim(htmlspecialchars($_POST["prixui"])),
                    'prixti' => (trim(htmlspecialchars($_POST["prixti"]))),
                    'qtee' => trim(htmlspecialchars($_POST["qtee"])),
                    'prixue' => trim(htmlspecialchars($_POST["prixue"])),
                    'prixte' => (trim(htmlspecialchars($_POST["prixte"]))),
                    'qter' => (trim(htmlspecialchars($_POST["qter"]))),
                    'prixur' => trim(htmlspecialchars($_POST["prixur"])),
                    'prixtr' => trim(htmlspecialchars($_POST["prixtr"])),
                    'valorisation' => trim(htmlspecialchars($_POST["valorisation"])),
                    'codevalorisation' => trim(htmlspecialchars($_POST["codevalorisation"]))
                );
            }

            require('sotcocogpages/sotcocogbonlivraison/sotcocogvalorisation/form_terminer.php');
            break;

        case 1:
        default:
            // Valeurs par défaut
            if (empty($_SESSION['formvalorisation'][NUM_PAGE])) {
                $_SESSION['formvalorisation'][NUM_PAGE] = array(
                    'idlignebonlivraison' => $_REQUEST["idlignebonlivraison"],
            'datejour' => '',
                    'transport' => 0,
                    'fraisgestion' => 0,
                    'qtei' => $qi,
                    'prixui' => $pi,
                    'prixti' => ($ti),
                    'qtee' => $qe,
                    'prixue' => $pe,
                    'prixte' => ($te),
                    'qter' => ($qr),
                    'prixur' => $pr,
                    'prixtr' => $tr,
                    'valorisation' => $row["idvalorisationstock"],
                    'codevalorisation' => $row["codevalorisationstock"]
                );
            } else if (($_SESSION['formvalorisation'][NUM_PAGE]["idlignebonlivraison"] != $_REQUEST["idlignebonlivraison"])) {

                $_SESSION['formvalorisation'][NUM_PAGE] = array(
                    'idlignebonlivraison' => $_REQUEST["idlignebonlivraison"],
            'datejour' => '',
                    'transport' => 0,
                    'fraisgestion' => 0,
                    'qtei' => $qi,
                    'prixui' => $pi,
                    'prixti' => ($ti),
                    'qtee' => $qe,
                    'prixue' => $pe,
                    'prixte' => ($te),
                    'qter' => ($qr),
                    'prixur' => $pr,
                    'prixtr' => $tr,
                    'valorisation' => $row["idvalorisationstock"],
                    'codevalorisation' => $row["codevalorisationstock"]
                );
            }

            require('sotcocogpages/sotcocogbonlivraison/sotcocogvalorisation/form_info.php');
            break;
    }
	}else if($rowda["idpointbeton"]!=NULL){
	$rslti = $con->query("select * from sot_materiaux_beton_use as mcu where "
            . "mcu.idmateriaux='" . $row["idmateriaux"] . "' and mcu.idpointbeton='" . $rowda["idpointbeton"] . "'") or die(mysqli_error($con));
    $nbi = mysqli_num_rows($rslti);
    $qi = 0;
    $pi = 0;
    $ti = 0;
    if ($nbi != 0) {
        $rowi = mysqli_fetch_assoc($rslti);

        $qi = $rowi["quantitemateriauxbetonuse"];
        $pi = $rowi["prixmateriauxbetonuse"];
        $ti = ($qi * $pi);
    }
    $qe = $row["quantitelignebonlivraison"];
    $pe = $row["prixunitairelignebonlivraison"];
    $te = ($qe * $pe);
    $qr = ($qi + $qe);
    $pr = 0;
    $tr = 0;
    if ($row["codevalorisationstock"] == "CUMPFE") {
        $tr = $ti + $te;
        $pr = $tr / $qr;
    }

    // Configuration du script
    // Affichage du menu en haut de la page
    $items = array();

// Récupération du numéro de l'étape en cours
    if (empty($_GET['pagecom']) or ! is_numeric($_GET['pagecom'])) {
        define('NUM_PAGE', 1);
    } else {
        // En situation réelle, il faudrait vérifier l'existence de cette page
        define('NUM_PAGE', intval($_GET['pagecom']));
    }

// Déclaration de la variable de session
    if (empty($_SESSION['formvalorisation'])) {
        $_SESSION['formvalorisation'] = array();
    }
    if (empty($_SESSION['formvalorisation'])) {
        $_SESSION['formvalorisation'][1] = array(
            'idlignebonlivraison' => $_REQUEST["idlignebonlivraison"],
            'datejour' => '',
            'transport' => 0,
            'fraisgestion' => 0,
            'qtei' => $qi,
            'prixui' => $pi,
            'prixti' => ($ti),
            'qtee' => $qe,
            'prixue' => $pe,
            'prixte' => ($te),
            'qter' => ($qr),
            'prixur' => $pr,
            'prixtr' => $tr,
            'valorisation' => $row["idvalorisationstock"],
            'codevalorisation' => $row["codevalorisationstock"]
        );
    }

    switch (NUM_PAGE) {

        case 2:
            // Valeurs par défaut
            // Récupération des informations du formulaire précédent
            if (!empty($_POST)) {
                $_SESSION['formvalorisation'][NUM_PAGE - 1] = array(
                    'idlignebonlivraison' => $_REQUEST["idlignebonlivraison"],
            'datejour' => trim(htmlspecialchars($_POST["datejour"])),
                    'transport' => trim(htmlspecialchars($_POST["transport"])),
                    'fraisgestion' => trim(htmlspecialchars($_POST["fraisgestion"])),
                    'qtei' => trim(htmlspecialchars($_POST["qtei"])),
                    'prixui' => trim(htmlspecialchars($_POST["prixui"])),
                    'prixti' => (trim(htmlspecialchars($_POST["prixti"]))),
                    'qtee' => trim(htmlspecialchars($_POST["qtee"])),
                    'prixue' => trim(htmlspecialchars($_POST["prixue"])),
                    'prixte' => (trim(htmlspecialchars($_POST["prixte"]))),
                    'qter' => (trim(htmlspecialchars($_POST["qter"]))),
                    'prixur' => trim(htmlspecialchars($_POST["prixur"])),
                    'prixtr' => trim(htmlspecialchars($_POST["prixtr"])),
                    'valorisation' => trim(htmlspecialchars($_POST["valorisation"])),
                    'codevalorisation' => trim(htmlspecialchars($_POST["codevalorisation"]))
                );
            }

            require('sotcocogpages/sotcocogbonlivraison/sotcocogvalorisation/form_terminer.php');
            break;

        case 1:
        default:
            // Valeurs par défaut
            if (empty($_SESSION['formvalorisation'][NUM_PAGE])) {
                $_SESSION['formvalorisation'][NUM_PAGE] = array(
                    'idlignebonlivraison' => $_REQUEST["idlignebonlivraison"],
            'datejour' => '',
                    'transport' => 0,
                    'fraisgestion' => 0,
                    'qtei' => $qi,
                    'prixui' => $pi,
                    'prixti' => ($ti),
                    'qtee' => $qe,
                    'prixue' => $pe,
                    'prixte' => ($te),
                    'qter' => ($qr),
                    'prixur' => $pr,
                    'prixtr' => $tr,
                    'valorisation' => $row["idvalorisationstock"],
                    'codevalorisation' => $row["codevalorisationstock"]
                );
            } else if (($_SESSION['formvalorisation'][NUM_PAGE]["idlignebonlivraison"] != $_REQUEST["idlignebonlivraison"])) {

                $_SESSION['formvalorisation'][NUM_PAGE] = array(
                    'idlignebonlivraison' => $_REQUEST["idlignebonlivraison"],
            'datejour' => '',
                    'transport' => 0,
                    'fraisgestion' => 0,
                    'qtei' => $qi,
                    'prixui' => $pi,
                    'prixti' => ($ti),
                    'qtee' => $qe,
                    'prixue' => $pe,
                    'prixte' => ($te),
                    'qter' => ($qr),
                    'prixur' => $pr,
                    'prixtr' => $tr,
                    'valorisation' => $row["idvalorisationstock"],
                    'codevalorisation' => $row["codevalorisationstock"]
                );
            }

            require('sotcocogpages/sotcocogbonlivraison/sotcocogvalorisation/form_info.php');
            break;
    }
	}else if($rowda["idpointprefabrication"]!=NULL){
	$rslti = $con->query("select * from sot_materiaux_prefabrication_use as mcu where "
            . "mcu.idmateriaux='" . $row["idmateriaux"] . "' and mcu.idpointprefabrication='" . $rowda["idpointprefabrication"] . "'") or die(mysqli_error($con));
    $nbi = mysqli_num_rows($rslti);
    $qi = 0;
    $pi = 0;
    $ti = 0;
    if ($nbi != 0) {
        $rowi = mysqli_fetch_assoc($rslti);

        $qi = $rowi["quantitemateriauxprefabricationuse"];
        $pi = $rowi["prixmateriauxprefabricationuse"];
        $ti = ($qi * $pi);
    }
    $qe = $row["quantitelignebonlivraison"];
    $pe = $row["prixunitairelignebonlivraison"];
    $te = ($qe * $pe);
    $qr = ($qi + $qe);
    $pr = 0;
    $tr = 0;
    if ($row["codevalorisationstock"] == "CUMPFE") {
        $tr = $ti + $te;
        $pr = $tr / $qr;
    }

    // Configuration du script
    // Affichage du menu en haut de la page
    $items = array();

// Récupération du numéro de l'étape en cours
    if (empty($_GET['pagecom']) or ! is_numeric($_GET['pagecom'])) {
        define('NUM_PAGE', 1);
    } else {
        // En situation réelle, il faudrait vérifier l'existence de cette page
        define('NUM_PAGE', intval($_GET['pagecom']));
    }

// Déclaration de la variable de session
    if (empty($_SESSION['formvalorisation'])) {
        $_SESSION['formvalorisation'] = array();
    }
    if (empty($_SESSION['formvalorisation'])) {
        $_SESSION['formvalorisation'][1] = array(
            'idlignebonlivraison' => $_REQUEST["idlignebonlivraison"],
            'datejour' => '',
            'transport' => 0,
            'fraisgestion' => 0,
            'qtei' => $qi,
            'prixui' => $pi,
            'prixti' => ($ti),
            'qtee' => $qe,
            'prixue' => $pe,
            'prixte' => ($te),
            'qter' => ($qr),
            'prixur' => $pr,
            'prixtr' => $tr,
            'valorisation' => $row["idvalorisationstock"],
            'codevalorisation' => $row["codevalorisationstock"]
        );
    }

    switch (NUM_PAGE) {

        case 2:
            // Valeurs par défaut
            // Récupération des informations du formulaire précédent
            if (!empty($_POST)) {
                $_SESSION['formvalorisation'][NUM_PAGE - 1] = array(
                    'idlignebonlivraison' => $_REQUEST["idlignebonlivraison"],
            'datejour' => trim(htmlspecialchars($_POST["datejour"])),
                    'transport' => trim(htmlspecialchars($_POST["transport"])),
                    'fraisgestion' => trim(htmlspecialchars($_POST["fraisgestion"])),
                    'qtei' => trim(htmlspecialchars($_POST["qtei"])),
                    'prixui' => trim(htmlspecialchars($_POST["prixui"])),
                    'prixti' => (trim(htmlspecialchars($_POST["prixti"]))),
                    'qtee' => trim(htmlspecialchars($_POST["qtee"])),
                    'prixue' => trim(htmlspecialchars($_POST["prixue"])),
                    'prixte' => (trim(htmlspecialchars($_POST["prixte"]))),
                    'qter' => (trim(htmlspecialchars($_POST["qter"]))),
                    'prixur' => trim(htmlspecialchars($_POST["prixur"])),
                    'prixtr' => trim(htmlspecialchars($_POST["prixtr"])),
                    'valorisation' => trim(htmlspecialchars($_POST["valorisation"])),
                    'codevalorisation' => trim(htmlspecialchars($_POST["codevalorisation"]))
                );
            }

            require('sotcocogpages/sotcocogbonlivraison/sotcocogvalorisation/form_terminer.php');
            break;

        case 1:
        default:
            // Valeurs par défaut
            if (empty($_SESSION['formvalorisation'][NUM_PAGE])) {
                $_SESSION['formvalorisation'][NUM_PAGE] = array(
                    'idlignebonlivraison' => $_REQUEST["idlignebonlivraison"],
            'datejour' => '',
                    'transport' => 0,
                    'fraisgestion' => 0,
                    'qtei' => $qi,
                    'prixui' => $pi,
                    'prixti' => ($ti),
                    'qtee' => $qe,
                    'prixue' => $pe,
                    'prixte' => ($te),
                    'qter' => ($qr),
                    'prixur' => $pr,
                    'prixtr' => $tr,
                    'valorisation' => $row["idvalorisationstock"],
                    'codevalorisation' => $row["codevalorisationstock"]
                );
            } else if (($_SESSION['formvalorisation'][NUM_PAGE]["idlignebonlivraison"] != $_REQUEST["idlignebonlivraison"])) {

                $_SESSION['formvalorisation'][NUM_PAGE] = array(
                    'idlignebonlivraison' => $_REQUEST["idlignebonlivraison"],
            'datejour' => '',
                    'transport' => 0,
                    'fraisgestion' => 0,
                    'qtei' => $qi,
                    'prixui' => $pi,
                    'prixti' => ($ti),
                    'qtee' => $qe,
                    'prixue' => $pe,
                    'prixte' => ($te),
                    'qter' => ($qr),
                    'prixur' => $pr,
                    'prixtr' => $tr,
                    'valorisation' => $row["idvalorisationstock"],
                    'codevalorisation' => $row["codevalorisationstock"]
                );
            }

            require('sotcocogpages/sotcocogbonlivraison/sotcocogvalorisation/form_info.php');
            break;
    }
	}
} else {
    echo "oooooo";
}
