
<?php

if (isset($_REQUEST["idconditionnement"])) {
    $id = $_REQUEST["idconditionnement"];
    $rslt = $con->query("select * from hp_conditionnement as p where "
            . "p.idconditionnement='" . $id . "'") or die(mysqli_error($con));
    $row = mysqli_fetch_assoc($rslt);
// R�cup�ration du num�ro de l'�tape en cours
    if (empty($_GET['pagecom']) or ! is_numeric($_GET['pagecom'])) {
        define('NUM_PAGE', 1);
    } else {
        // En situation r�elle, il faudrait v�rifier l'existence de cette page
        define('NUM_PAGE', intval($_GET['pagecom']));
    }

// D�claration de la variable de session
    if (empty($_SESSION['formconditionnemente'])) {
        $_SESSION['formconditionnemente'] = array();
    }

    if (empty($_SESSION['formconditionnemente'])) {
        $_SESSION['formconditionnemente'] = array();
        $_SESSION['formconditionnemente'][1] = array(
            'idconditionnement' => $_GET["idconditionnement"],
            'conditionnemente' => $row["libelleconditionnement"]
        );
    }


    switch (NUM_PAGE) {

        case 2:

            // R�cup�ration des informations du formulaire pr�c�dent
            if (!empty($_POST)) {

                $_SESSION['formconditionnemente'][NUM_PAGE - 1] = array(
                    'idconditionnement' => $_GET["idconditionnement"],
                    'conditionnemente' => (trim(htmlspecialchars($_POST["conditionnemente"])))
                );
            }
            require('./hopitalpages/hopitalconditionnement/hopitalediter/form_terminer.php');
            break;

        case 1:
        default:
            // Valeurs par d�faut
            if (empty($_SESSION['formconditionnemente'][NUM_PAGE])) {
                $_SESSION['formconditionnemente'][NUM_PAGE] = array(
                    'idconditionnement' => $_GET["idconditionnement"],
                    'conditionnemente' => $row["libelleconditionnement"]
                );
            } else if (($_SESSION['formconditionnemente'][1]['idconditionnement'] != $_GET["idconditionnement"])) {
                $_SESSION['formconditionnemente'][NUM_PAGE] = array(
                    'idconditionnement' => $_GET["idconditionnement"],
                    'conditionnemente' => $row["libelleconditionnement"]
                );
            }
            require('hopitalpages/hopitalconditionnement/hopitalediter/form_edit_conditionnement.php');
            break;
    }
}