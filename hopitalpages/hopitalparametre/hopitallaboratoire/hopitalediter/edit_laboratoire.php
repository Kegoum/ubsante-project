
<?php

if (isset($_REQUEST["idlaboratoire"])) {
    $id = $_REQUEST["idlaboratoire"];
    $rslt = $con->query("select * from hp_laboratoire as p where "
            . "p.idlaboratoire='" . $id . "'") or die(mysqli_error($con));
    $row = mysqli_fetch_assoc($rslt);
// R�cup�ration du num�ro de l'�tape en cours
    if (empty($_GET['pagecom']) or ! is_numeric($_GET['pagecom'])) {
        define('NUM_PAGE', 1);
    } else {
        // En situation r�elle, il faudrait v�rifier l'existence de cette page
        define('NUM_PAGE', intval($_GET['pagecom']));
    }

// D�claration de la variable de session
    if (empty($_SESSION['formlaboratoiree'])) {
        $_SESSION['formlaboratoiree'] = array();
    }

    if (empty($_SESSION['formlaboratoiree'])) {
        $_SESSION['formlaboratoiree'] = array();
        $_SESSION['formlaboratoiree'][1] = array(
            'idlaboratoire' => $_GET["idlaboratoire"],
            'service' => $row["idservice"],
            'codepe' => $row["codelaboratoire"],
            'laboratoiree' => $row["nomlaboratoire"],
            'but' => $row["butlaboratoire"]
        );
    }


    switch (NUM_PAGE) {

        case 2:

            // R�cup�ration des informations du formulaire pr�c�dent
            if (!empty($_POST)) {

                $_SESSION['formlaboratoiree'][NUM_PAGE - 1] = array(
                    'idlaboratoire' => $_GET["idlaboratoire"],
                    'service' => strtoupper(trim(htmlspecialchars($_POST["service"]))),
                    'codepe' => strtoupper(trim(htmlspecialchars($_POST["codepe"]))),
                    'laboratoiree' => ucwords(trim(htmlspecialchars($_POST["laboratoiree"]))),
                    'but' => (trim(htmlspecialchars($_POST["but"])))
                );
            }
            require('./hopitalpages/hopitalparametre/hopitallaboratoire/hopitalediter/form_terminer.php');
            break;

        case 1:
        default:
            // Valeurs par d�faut
            if (empty($_SESSION['formlaboratoiree'][NUM_PAGE])) {
                $_SESSION['formlaboratoiree'][NUM_PAGE] = array(
                    'idlaboratoire' => $_GET["idlaboratoire"],
                    'service' => $row["idservice"],
                    'codepe' => $row["codelaboratoire"],
                    'laboratoiree' => $row["nomlaboratoire"],
            'but' => $row["butlaboratoire"]
                );
            } else if (($_SESSION['formlaboratoiree'][1]['idlaboratoire'] != $_GET["idlaboratoire"])) {
                $_SESSION['formlaboratoiree'][NUM_PAGE] = array(
                    'idlaboratoire' => $_GET["idlaboratoire"],
                    'service' => $row["idservice"],
                    'codepe' => $row["codelaboratoire"],
                    'laboratoiree' => $row["nomlaboratoire"],
            'but' => $row["butlaboratoire"]
                );
            }
            require('hopitalpages/hopitalparametre/hopitallaboratoire/hopitalediter/form_edit_laboratoire.php');
            break;
    }
}