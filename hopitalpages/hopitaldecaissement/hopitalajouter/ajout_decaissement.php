
<?php

$id = NULL;
if (isset($_REQUEST["idcaisse"])) {
    $id = $_REQUEST["idcaisse"];
}

$eta = "Actif";
$mont = 0;
$rslt = $con->query("select * from hp_ligne_caisse as lc where lc.idcaisse='" . $id . "' and "
        . "lc.paiementlignecaisse='" . $eta . "' ") or die(mysqli_error($con));
while ($row = mysqli_fetch_assoc($rslt)) {
    if ($row["operationlignecaisse"] == "Encaissement") {
        $mont = $mont + $row["montantlignecaisse"];
    } else {
        $mont = $mont - $row["montantlignecaisse"];
    }
}
// R�cup�ration du num�ro de l'�tape en cours
if (empty($_GET['pagecom']) or ! is_numeric($_GET['pagecom'])) {
    define('NUM_PAGE', 1);
} else {
    // En situation r�elle, il faudrait v�rifier l'existence de cette page
    define('NUM_PAGE', intval($_GET['pagecom']));
}

// D�claration de la variable de session
if (empty($_SESSION['formdecaissement'])) {
    $_SESSION['formdecaissement'] = array();
}

if (empty($_SESSION['formdecaissement'])) {
    $_SESSION['formdecaissement'] = array();
    $_SESSION['formdecaissement'][1] = array(
        'idcaisse' => $id,
        'datejour' => '',
        'but' => '',
        'montant' => $mont,
        'montvers' => 0,
        'reste' => $mont
    );
}


switch (NUM_PAGE) {

    case 2:
        // Récupération des informations du formulaire précédent
        if (!empty($_POST)) {

            $_SESSION['formdecaissement'][NUM_PAGE - 1] = array(
                'idcaisse' => $id,
                'but' => trim(htmlspecialchars($_POST["but"])),
                'datejour' => trim(htmlspecialchars($_POST["datejour"])),
                'montant' => floatval(trim(htmlspecialchars($_POST["montant"]))),
                'montvers' => floatval(trim(htmlspecialchars($_POST["montvers"]))),
                'reste' => floatval(trim(htmlspecialchars($_POST["reste"])))
            );
        }

        require('hopitalpages/hopitaldecaissement/hopitalajouter/form_terminer.php');
        break;

    case 1:
    default:
        // Valeurs par défaut
        if (empty($_SESSION['formdecaissement'][NUM_PAGE])) {

            $_SESSION['formdecaissement'][NUM_PAGE] = array(
                'idcaisse' => $id,
                'datejour' => '',
                'but' => '',
                'montant' => $mont,
                'montvers' => 0,
                'reste' => $mont
            );
        } else if (($_SESSION['formdecaissement'][NUM_PAGE]["idcaisse"] != $id)) {

            $_SESSION['formdecaissement'][NUM_PAGE] = array(
                'idcaisse' => $id,
                'datejour' => '',
                'but' => '',
                'montant' => $mont,
                'montvers' => 0,
                'reste' => $mont
            );
        }
        require('hopitalpages/hopitaldecaissement/hopitalajouter/form_ajouter_decaissement.php');
        break;
}