
<?php

if (isset($_REQUEST["personnel"])) {
    $id = $_REQUEST["personnel"];
    $rslt = $con->query("select * from hp_personnel as u where u.idpersonnel='" . $id . "'") or die(mysqli_error($con));
    $row = mysqli_fetch_assoc($rslt);
    $rsltuser = $con->query("select * from hp_affectation as af left join hp_personnel as pe on pe.idpersonnel=af.idpersonnel "
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
if (empty($_SESSION['formpersonnele'])) {
    $_SESSION['formpersonnele'] = array();
}
if (empty($_SESSION['formpersonnele'])) {
    $_SESSION['formpersonnele'] = array();
     $_SESSION['formpersonnele'][1] = array(
                'idpersonnel' => $_REQUEST["personnel"],
                'nom' => $row["nompersonnel"],
                'prenom' => $row["prenompersonnel"],
                'tel' => $row["telephonepersonnel"],
                'service' => $recuser["idservice"],
                'role' => $row["rolepersonnel"],
                'salaire' => $recuser["salaireaffectation"],
                'typepaiement' => $recuser["typepaiement"]
            );
}

switch (NUM_PAGE) {

    case 2:
        // Récupération des informations du formulaire précédent
        if (!empty($_POST)) {
            $erreurprod = FALSE;
            $_SESSION['formpersonnele'][NUM_PAGE - 1] = array(
                'idpersonnel' => $_REQUEST["personnel"],
                'nom' => trim(htmlspecialchars($_POST["nom"])),
                'prenom' => trim(htmlspecialchars($_POST["prenom"])),
                'tel' => trim(htmlspecialchars($_POST["tel"])),
                'service' => trim(htmlspecialchars($_POST["service"])),
                'role' => trim(htmlspecialchars($_POST["role"])),
                'salaire' => trim(htmlspecialchars($_POST["salaire"])),
                'typepaiement' => trim(htmlspecialchars($_POST["typepaiement"]))
            );
        }
        if ((isset($erreurprod)) && ($erreurprod)) {
            $pag = 'hopitalpages/hopitalpersonnel/hopitalediter/edit_personnel';
            $stag = 1;
            die('<meta http-equiv="refresh" content="0; URL=' . $url . '?page=' . base64_encode($pag) . '&personnel=' . $id . '&pagecom=' . $stag . '">');
        } else {
            require('hopitalpages/hopitalpersonnel/hopitalediter/form_terminer.php');
            break;
        }

    case 1:
    default:
        // Valeurs par défaut
        if (empty($_SESSION['formpersonnele'][NUM_PAGE])) {

            $_SESSION['formpersonnele'][NUM_PAGE] = array(
                'idpersonnel' => $_REQUEST["personnel"],
                'nom' => $row["nompersonnel"],
                'prenom' => $row["prenompersonnel"],
                'tel' => $row["telephonepersonnel"],
                'service' => $recuser["idservice"],
                'role' => $row["rolepersonnel"],
                'salaire' => $recuser["salaireaffectation"],
                'typepaiement' => $recuser["typepaiement"]
            );
        } else if (($_SESSION['formpersonnele'][NUM_PAGE]["idpersonnel"]!=$_REQUEST["personnel"])) {

            $_SESSION['formpersonnele'][NUM_PAGE] = array(
                'idpersonnel' => $_REQUEST["personnel"],
                'nom' => $row["nompersonnel"],
                'prenom' => $row["prenompersonnel"],
                'tel' => $row["telephonepersonnel"],
                'service' => $recuser["idservice"],
                'role' => $row["rolepersonnel"],
                'salaire' => $recuser["salaireaffectation"],
                'typepaiement' => $recuser["typepaiement"]
            );
        }
        require('hopitalpages/hopitalpersonnel/hopitalediter/form_edit_personnel.php');
        break;
}
}