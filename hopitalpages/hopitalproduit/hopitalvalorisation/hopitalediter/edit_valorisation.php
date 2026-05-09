
<?php

if (isset($_REQUEST["idvalorisationstock"])) {
    $id = $_REQUEST["idvalorisationstock"];
    $rslt = $con->query("select * from hp_valorisation_stock where idvalorisationstock='" . $id . "'") or die(mysqli_error($con));
    $row = mysqli_fetch_assoc($rslt);
// Récupération du numéro de l'étape en cours
if (empty($_GET['pagecom']) or ! is_numeric($_GET['pagecom'])) {
    define('NUM_PAGE', 1);
} else {
    // En situation réelle, il faudrait vérifier l'existence de cette page
    define('NUM_PAGE', intval($_GET['pagecom']));
}

// Déclaration de la variable de session
if (empty($_SESSION['formvalorisationstocke'])) {
    $_SESSION['formvalorisationstocke'] = array();
}
if (empty($_SESSION['formvalorisationstocke'])) {
    $_SESSION['formvalorisationstocke'] = array();
    $_SESSION['formvalorisationstocke'][1] = array(
                'idvalorisationstock' => $_REQUEST["idvalorisationstock"],
                'codevalorisationstocke' => $row["codevalorisationstock"],
                'libvalorisationstocke' => $row["libellevalorisationstock"]
            );
}

switch (NUM_PAGE) {

    case 2:
        // Récupération des informations du formulaire précédent
        if (!empty($_POST)) {
            $_SESSION['formvalorisationstocke'][NUM_PAGE - 1] = array(
                'idvalorisationstock' => $_REQUEST["idvalorisationstock"],
                'codevalorisationstocke' => strtoupper(trim(htmlspecialchars($_POST["codevalorisationstocke"]))),
                'libvalorisationstocke' => ucwords(trim(htmlspecialchars($_POST["libvalorisationstocke"])))
            );
        }
        require('hopitalpages/hopitalproduit/hopitalvalorisation/hopitalediter/form_terminer.php');
        break;
        
    case 1:
    default:
        // Valeurs par défaut
        if (empty($_SESSION['formvalorisationstocke'][NUM_PAGE])) {

            $_SESSION['formvalorisationstocke'][NUM_PAGE] = array(
                'idvalorisationstock' => $_REQUEST["idvalorisationstock"],
                'codevalorisationstocke' => $row["codevalorisationstock"],
                'libvalorisationstocke' => $row["libellevalorisationstock"]
            );
        }  else if (($_SESSION['formvalorisationstocke'][NUM_PAGE]["idvalorisationstock"]==$_REQUEST["idvalorisationstock"])) {

            $_SESSION['formvalorisationstocke'][NUM_PAGE] = array(
                'idvalorisationstock' => $_REQUEST["idvalorisationstock"],
                'codevalorisationstocke' => $row["codevalorisationstock"],
                'libvalorisationstocke' => $row["libellevalorisationstock"]
            );
        }
        require('hopitalpages/hopitalproduit/hopitalvalorisation/hopitalediter/form_edit_valorisation.php');
        break;
}
}