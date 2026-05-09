
<?php

if (isset($_REQUEST["idacte"])) {
    $id = $_REQUEST["idacte"];
    $rslt = $con->query("select * from hp_acte as p where "
            . "p.idacte='" . $id . "'") or die(mysqli_error($con));
    $row = mysqli_fetch_assoc($rslt);
// R�cup�ration du num�ro de l'�tape en cours
    if (empty($_GET['pagecom']) or ! is_numeric($_GET['pagecom'])) {
        define('NUM_PAGE', 1);
    } else {
        // En situation r�elle, il faudrait v�rifier l'existence de cette page
        define('NUM_PAGE', intval($_GET['pagecom']));
    }

// D�claration de la variable de session
    if (empty($_SESSION['formactee'])) {
        $_SESSION['formactee'] = array();
    }

    if (empty($_SESSION['formactee'])) {
        $_SESSION['formactee'] = array();
        $_SESSION['formactee'][1] = array(
            'idacte' => $_GET["idacte"],
            'service' => $row["idservice"],
            'codee' => $row["codeacte"],
            'categoriee' => $row["categorieacte"],
            'designationpe' => $row["libelleacte"],
            'typee' => $row["typeacte"],
            'descriptione' => $row["descriptionacte"],
            'montant' => $row["prixacte"]
        );
    }


    switch (NUM_PAGE) {

        case 2:

            // R�cup�ration des informations du formulaire pr�c�dent
            if (!empty($_POST)) {

                $_SESSION['formactee'][NUM_PAGE - 1] = array(
                    'idacte' => $_GET["idacte"],
                    'service' => (trim(htmlspecialchars($_POST["service"]))),
                    'codee' => (trim(htmlspecialchars($_POST["codee"]))),
                    'designationpe' => (trim(htmlspecialchars($_POST["designationpe"]))),
                    'categoriee' => (trim(htmlspecialchars($_POST["categoriee"]))),
                    'typee' => ucwords(trim(htmlspecialchars($_POST["typee"]))),
                    'descriptione' => ucwords(trim(htmlspecialchars($_POST["descriptione"]))),
                    'montant' => (trim(htmlspecialchars($_POST["montant"])))
                );
            }
            require('./hopitalpages/hopitalparametre/hopitalacte/hopitalediter/form_terminer.php');
            break;

        case 1:
        default:
            // Valeurs par d�faut
            if (empty($_SESSION['formactee'][NUM_PAGE])) {
                $_SESSION['formactee'][NUM_PAGE] = array(
                    'idacte' => $_GET["idacte"],
            'service' => $row["idservice"],
                    'codee' => $row["codeacte"],
                    'categoriee' => $row["categorieacte"],
                    'designationpe' => $row["libelleacte"],
                    'typee' => $row["typeacte"],
                    'descriptione' => $row["descriptionacte"],
                    'montant' => $row["prixacte"]
                );
            } else if (($_SESSION['formactee'][1]['idacte'] != $_GET["idacte"])) {
                $_SESSION['formactee'][NUM_PAGE] = array(
                    'idacte' => $_GET["idacte"],
            'service' => $row["idservice"],
                    'codee' => $row["codeacte"],
                    'categoriee' => $row["categorieacte"],
                    'designationpe' => $row["libelleacte"],
                    'typee' => $row["typeacte"],
                    'descriptione' => $row["descriptionacte"],
                    'montant' => $row["prixacte"]
                );
            }
            require('hopitalpages/hopitalparametre/hopitalacte/hopitalediter/form_edit_acte.php');
            break;
    }
}