
<?php

if (isset($_REQUEST["idmateriel"])) {
    $id = $_REQUEST["idmateriel"];
    $rslt = $con->query("select * from hp_materiel where idmateriel='" . $id . "'") or die(mysqli_error($con));
    $row = mysqli_fetch_assoc($rslt);
// R�cup�ration du num�ro de l'�tape en cours
    if (empty($_GET['pagecom']) or ! is_numeric($_GET['pagecom'])) {
        define('NUM_PAGE', 1);
    } else {
        // En situation r�elle, il faudrait v�rifier l'existence de cette page
        define('NUM_PAGE', intval($_GET['pagecom']));
    }

// D�claration de la variable de session
    if (empty($_SESSION['formmateriele'])) {
        $_SESSION['formmateriele'] = array();
    }

    if (empty($_SESSION['formmateriele'])) {
        $_SESSION['formmateriele'] = array();
        $_SESSION['formmateriele'][1] = array(
            'idmateriel' => $_GET["idmateriel"],
            'libellee' => $row["libellemateriel"],
            'typee' => $row["typemateriel"]
        );
    }


    switch (NUM_PAGE) {

        case 2:

            // R�cup�ration des informations du formulaire pr�c�dent
            if (!empty($_POST)) {

                $_SESSION['formmateriele'][NUM_PAGE - 1] = array(
                    'idmateriel' => $_GET["idmateriel"],
                    'libellee' => ucwords(trim(htmlspecialchars($_POST["libellee"]))),
                    'typee' => trim(htmlspecialchars($_POST["typee"]))
                );
            }
            require('./hopitalpages/hopitalparametre/hopitalchambre/hopitalmateriel/hopitalediter/form_terminer.php');
            break;

        case 1:
        default:
            // Valeurs par d�faut
            if (empty($_SESSION['formmateriele'][NUM_PAGE])) {
                $_SESSION['formmateriele'][NUM_PAGE] = array(
                    'idmateriel' => $_GET["idmateriel"],
            'libellee' => $row["libellemateriel"],
            'typee' => $row["typemateriel"]
                );
            } else if (($_SESSION['formmateriele'][1]['idmateriel'] != $_GET["idmateriel"])) {
                $_SESSION['formmateriele'][NUM_PAGE] = array(
                    'idmateriel' => $_GET["idmateriel"],
            'libellee' => $row["libellemateriel"],
            'typee' => $row["typemateriel"]
                );
            }
            require('hopitalpages/hopitalparametre/hopitalchambre/hopitalmateriel/hopitalediter/form_edit_materiel.php');
            break;
    }
}