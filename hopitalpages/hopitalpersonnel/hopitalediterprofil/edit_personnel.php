
<?php

if (isset($_REQUEST["idcomptepersonnel"])) {
    $id = $_REQUEST["idcomptepersonnel"];
    $rslt = $con->query("select * from hp_compte_personnel as cp left join hp_personnel as p on "
        . "cp.idpersonnel=p.idpersonnel where cp.idcomptepersonnel='" . $id . "'") or die(mysqli_error($con));
    $row = mysqli_fetch_assoc($rslt);
// R�cup�ration du num�ro de l'�tape en cours
    if (empty($_GET['pagecom']) or ! is_numeric($_GET['pagecom'])) {
        define('NUM_PAGE', 1);
    } else {
        // En situation r�elle, il faudrait v�rifier l'existence de cette page
        define('NUM_PAGE', intval($_GET['pagecom']));
    }

// D�claration de la variable de session
    if (empty($_SESSION['formpersonnelep'])) {
        $_SESSION['formpersonnelep'] = array();
    }

    if (empty($_SESSION['formpersonnelep'])) {
        $_SESSION['formpersonnelep'] = array();
        $_SESSION['formpersonnelep'][1] = array(
            'idcomptepersonnel' => $_GET["idcomptepersonnel"],
                'nome' => $row["nompersonnel"],
                'prenome' => $row["prenompersonnel"],
                'tele' => $row["telephonepersonnel"],
                'logine' => $row["logincomptepersonnel"],
                'pass1e' => NULL,
                'pass2e' => NULL
        );
    }


switch (NUM_PAGE) {

    case 2:
        // Récupération des informations du formulaire précédent
        if (!empty($_POST)) {
            $erreurprod = FALSE;
            
            $_SESSION['formpersonnelep'][NUM_PAGE - 1] = array(
            'idcomptepersonnel' => $_GET["idcomptepersonnel"],
                'nome' => trim(htmlspecialchars($_POST["nome"])),
                'prenome' => trim(htmlspecialchars($_POST["prenome"])),
                'tele' => trim(htmlspecialchars($_POST["tele"])),
                'logine' => trim(htmlspecialchars($_POST["logine"])),
                'pass1e' => trim(htmlspecialchars($_POST["pass1e"])),
                'pass2e' => trim(htmlspecialchars($_POST["pass2e"]))
            );
        }
        if ((isset($erreurprod)) && ($erreurprod)) {
            $pag = 'hopitalpages/hopitalpersonnel/hopitalediterprofil/edit_personnel';
            $stag = 1;
            die('<meta http-equiv="refresh" content="0; URL='.$url.'?page=' . base64_encode($pag) . '&idcomptepersonnel=' . $id . '">');
            
        } else {
        require('hopitalpages/hopitalpersonnel/hopitalediterprofil/form_terminer.php');
        break;
        }

    case 1:
    default:
        // Valeurs par défaut
        if (empty($_SESSION['formpersonnelep'][NUM_PAGE])) {

            $_SESSION['formpersonnelep'][NUM_PAGE] = array(
            'idcomptepersonnel' => $_GET["idcomptepersonnel"],
                'nome' => $row["nompersonnel"],
                'prenome' => $row["prenompersonnel"],
                'tele' => $row["telephonepersonnel"],
                'logine' => $row["logincomptepersonnel"],
                'pass1e' => NULL,
                'pass2e' => NULL
            );
        } else if (($_SESSION['formpersonnelep'][NUM_PAGE]["idcomptepersonnel"]!=$_REQUEST["idcomptepersonnel"])) {

            $_SESSION['formpersonnelep'][NUM_PAGE] = array(
            'idcomptepersonnel' => $_GET["idcomptepersonnel"],
                'nome' => $row["nompersonnel"],
                'prenome' => $row["prenompersonnel"],
                'tele' => $row["telephonepersonnel"],
                'logine' => $row["logincomptepersonnel"],
                'pass1e' => NULL,
                'pass2e' => NULL
            );
        }
        require('hopitalpages/hopitalpersonnel/hopitalediterprofil/form_edit_personnel.php');
        break;
}
}