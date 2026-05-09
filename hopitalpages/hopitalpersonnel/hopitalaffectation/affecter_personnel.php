
<?php

if (isset($_REQUEST["personnel"])) {
    $id = $_REQUEST["personnel"];
    $rslt = $con->query("select * from hp_personnel as u where u.idpersonnel='" . $id . "'") or die(mysqli_error($con));
    $row = mysqli_fetch_assoc($rslt);
    $rsltuser = $con->query("select * from hp_affectation as af left join hp_personnel as pe on af.idpersonnel=pe.idpersonnel "
            . "left join hp_service as s on af.idservice=s.idservice "
            . "where af.idpersonnel='" . $id . "' and etataffectation=true ") or die(mysqli_error($con));
    $recuser = mysqli_fetch_assoc($rsltuser);

// Récupération du numéro de l'étape en cours
if (empty($_GET['pagecom']) or ! is_numeric($_GET['pagecom'])) {
    define('NUM_PAGE', 1);
} else {
    // En situation réelle, il faudrait vérifier l'existence de cette page
    define('NUM_PAGE', intval($_GET['pagecom']));
}

// Déclaration de la variable de session
if (empty($_SESSION['formaffectation'])) {
    $_SESSION['formaffectation'] = array();
}
if (empty($_SESSION['formaffectation'])) {
    $_SESSION['formaffectation'] = array();
     $_SESSION['formaffectation'][1] = array(
                'idpersonnel' => $_REQUEST["personnel"],
                'servicea' => $recuser["idservice"],
                'service' => '',
                'rolea' => $row["rolepersonnel"],
                'role' => '',
                'salaire' => $recuser["salaireaffectation"],
                'typepaiement' => $recuser["typepaiement"]
            );
}

switch (NUM_PAGE) {

    case 2:
        // Récupération des informations du formulaire précédent
        if (!empty($_POST)) {
            $erreurprod = FALSE;
            $_SESSION['formaffectation'][NUM_PAGE - 1] = array(
                'idpersonnel' => $_REQUEST["personnel"],
                'servicea' => trim(htmlspecialchars($_POST["servicea"])),
                'service' => trim(htmlspecialchars($_POST["service"])),
                'rolea' => trim(htmlspecialchars($_POST["rolea"])),
                'role' => trim(htmlspecialchars($_POST["role"])),
                'salaire' => trim(htmlspecialchars($_POST["salaire"])),
                'typepaiement' => trim(htmlspecialchars($_POST["typepaiement"]))
            );
        }
        if ((isset($erreurprod)) && ($erreurprod)) {
            $pag = 'hopitalpages/hopitalpersonnel/hopitalaffectation/affecter_personnel';
            $stag = 1;
            die('<meta http-equiv="refresh" content="0; URL=' . $url . '?page=' . base64_encode($pag) . '&personnel=' . $id . '&pagecom=' . $stag . '">');
        } else {
            require('hopitalpages/hopitalpersonnel/hopitalaffectation/form_terminer.php');
            break;
        }

    case 1:
    default:
        // Valeurs par défaut
        if (empty($_SESSION['formaffectation'][NUM_PAGE])) {

            $_SESSION['formaffectation'][NUM_PAGE] = array(
                'idpersonnel' => $_REQUEST["personnel"],
                'servicea' => $recuser["idservice"],
                'service' => '',
                'rolea' => $row["rolepersonnel"],
                'role' => '',
                'salaire' => $recuser["salaireaffectation"],
                'typepaiement' => $recuser["typepaiement"]
            );
        } else if (($_SESSION['formaffectation'][NUM_PAGE]["idpersonnel"]!=$_REQUEST["personnel"])) {

            $_SESSION['formaffectation'][NUM_PAGE] = array(
                'idpersonnel' => $_REQUEST["personnel"],
                'servicea' => $recuser["idservice"],
                'service' => '',
                'rolea' => $row["rolepersonnel"],
                'role' => '',
                'salaire' => $recuser["salaireaffectation"],
                'typepaiement' => $recuser["typepaiement"]
            );
        }
        require('hopitalpages/hopitalpersonnel/hopitalaffectation/form_affecter_personnel.php');
        break;
}
}