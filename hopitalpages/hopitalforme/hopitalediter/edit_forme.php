
<?php

if (isset($_REQUEST["idforme"])) {
    $id = $_REQUEST["idforme"];
    $rslt = $con->query("select * from hp_forme as p where "
            . "p.idforme='" . $id . "'") or die(mysqli_error($con));
    $row = mysqli_fetch_assoc($rslt);
// R�cup�ration du num�ro de l'�tape en cours
    if (empty($_GET['pagecom']) or ! is_numeric($_GET['pagecom'])) {
        define('NUM_PAGE', 1);
    } else {
        // En situation r�elle, il faudrait v�rifier l'existence de cette page
        define('NUM_PAGE', intval($_GET['pagecom']));
    }

// D�claration de la variable de session
    if (empty($_SESSION['formformee'])) {
        $_SESSION['formformee'] = array();
    }

    if (empty($_SESSION['formformee'])) {
        $_SESSION['formformee'] = array();
        $_SESSION['formformee'][1] = array(
            'idforme' => $_GET["idforme"],
            'formee' => $row["libelleforme"]
        );
    }


    switch (NUM_PAGE) {

        case 2:

            // R�cup�ration des informations du formulaire pr�c�dent
            if (!empty($_POST)) {

                $_SESSION['formformee'][NUM_PAGE - 1] = array(
                    'idforme' => $_GET["idforme"],
                    'formee' => (trim(htmlspecialchars($_POST["formee"])))
                );
            }
            require('./hopitalpages/hopitalforme/hopitalediter/form_terminer.php');
            break;

        case 1:
        default:
            // Valeurs par d�faut
            if (empty($_SESSION['formformee'][NUM_PAGE])) {
                $_SESSION['formformee'][NUM_PAGE] = array(
                    'idforme' => $_GET["idforme"],
                    'formee' => $row["libelleforme"]
                );
            } else if (($_SESSION['formformee'][1]['idforme'] != $_GET["idforme"])) {
                $_SESSION['formformee'][NUM_PAGE] = array(
                    'idforme' => $_GET["idforme"],
                    'formee' => $row["libelleforme"]
                );
            }
            require('hopitalpages/hopitalforme/hopitalediter/form_edit_forme.php');
            break;
    }
}