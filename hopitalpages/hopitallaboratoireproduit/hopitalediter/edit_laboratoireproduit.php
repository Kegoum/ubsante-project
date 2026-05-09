
<?php

if (isset($_REQUEST["idlaboratoireproduit"])) {
    $id = $_REQUEST["idlaboratoireproduit"];
    $rslt = $con->query("select * from hp_laboratoire_produit as p where "
            . "p.idlaboratoireproduit='" . $id . "'") or die(mysqli_error($con));
    $row = mysqli_fetch_assoc($rslt);
// R�cup�ration du num�ro de l'�tape en cours
    if (empty($_GET['pagecom']) or ! is_numeric($_GET['pagecom'])) {
        define('NUM_PAGE', 1);
    } else {
        // En situation r�elle, il faudrait v�rifier l'existence de cette page
        define('NUM_PAGE', intval($_GET['pagecom']));
    }

// D�claration de la variable de session
    if (empty($_SESSION['formlaboratoireproduite'])) {
        $_SESSION['formlaboratoireproduite'] = array();
    }

    if (empty($_SESSION['formlaboratoireproduite'])) {
        $_SESSION['formlaboratoireproduite'] = array();
        $_SESSION['formlaboratoireproduite'][1] = array(
            'idlaboratoireproduit' => $_GET["idlaboratoireproduit"],
            'laboratoireproduite' => $row["libellelaboratoireproduit"]
        );
    }


    switch (NUM_PAGE) {

        case 2:

            // R�cup�ration des informations du formulaire pr�c�dent
            if (!empty($_POST)) {

                $_SESSION['formlaboratoireproduite'][NUM_PAGE - 1] = array(
                    'idlaboratoireproduit' => $_GET["idlaboratoireproduit"],
                    'laboratoireproduite' => (trim(htmlspecialchars($_POST["laboratoireproduite"])))
                );
            }
            require('./hopitalpages/hopitallaboratoireproduit/hopitalediter/form_terminer.php');
            break;

        case 1:
        default:
            // Valeurs par d�faut
            if (empty($_SESSION['formlaboratoireproduite'][NUM_PAGE])) {
                $_SESSION['formlaboratoireproduite'][NUM_PAGE] = array(
                    'idlaboratoireproduit' => $_GET["idlaboratoireproduit"],
                    'laboratoireproduite' => $row["libellelaboratoireproduit"]
                );
            } else if (($_SESSION['formlaboratoireproduite'][1]['idlaboratoireproduit'] != $_GET["idlaboratoireproduit"])) {
                $_SESSION['formlaboratoireproduite'][NUM_PAGE] = array(
                    'idlaboratoireproduit' => $_GET["idlaboratoireproduit"],
                    'laboratoireproduite' => $row["libellelaboratoireproduit"]
                );
            }
            require('hopitalpages/hopitallaboratoireproduit/hopitalediter/form_edit_laboratoireproduit.php');
            break;
    }
}