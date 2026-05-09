
<?php

if (isset($_REQUEST["iddosage"])) {
    $id = $_REQUEST["iddosage"];
    $rslt = $con->query("select * from hp_dosage as p where "
            . "p.iddosage='" . $id . "'") or die(mysqli_error($con));
    $row = mysqli_fetch_assoc($rslt);
// R�cup�ration du num�ro de l'�tape en cours
    if (empty($_GET['pagecom']) or ! is_numeric($_GET['pagecom'])) {
        define('NUM_PAGE', 1);
    } else {
        // En situation r�elle, il faudrait v�rifier l'existence de cette page
        define('NUM_PAGE', intval($_GET['pagecom']));
    }

// D�claration de la variable de session
    if (empty($_SESSION['formdosagee'])) {
        $_SESSION['formdosagee'] = array();
    }

    if (empty($_SESSION['formdosagee'])) {
        $_SESSION['formdosagee'] = array();
        $_SESSION['formdosagee'][1] = array(
            'iddosage' => $_GET["iddosage"],
            'dosagee' => $row["libelledosage"]
        );
    }


    switch (NUM_PAGE) {

        case 2:

            // R�cup�ration des informations du formulaire pr�c�dent
            if (!empty($_POST)) {

                $_SESSION['formdosagee'][NUM_PAGE - 1] = array(
                    'iddosage' => $_GET["iddosage"],
                    'dosagee' => (trim(htmlspecialchars($_POST["dosagee"])))
                );
            }
            require('./hopitalpages/hopitaldosage/hopitalediter/form_terminer.php');
            break;

        case 1:
        default:
            // Valeurs par d�faut
            if (empty($_SESSION['formdosagee'][NUM_PAGE])) {
                $_SESSION['formdosagee'][NUM_PAGE] = array(
                    'iddosage' => $_GET["iddosage"],
                    'dosagee' => $row["libelledosage"]
                );
            } else if (($_SESSION['formdosagee'][1]['iddosage'] != $_GET["iddosage"])) {
                $_SESSION['formdosagee'][NUM_PAGE] = array(
                    'iddosage' => $_GET["iddosage"],
                    'dosagee' => $row["libelledosage"]
                );
            }
            require('hopitalpages/hopitaldosage/hopitalediter/form_edit_dosage.php');
            break;
    }
}