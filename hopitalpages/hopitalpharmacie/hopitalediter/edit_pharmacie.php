
<?php

if (isset($_REQUEST["idpharmacie"])) {
    $id = $_REQUEST["idpharmacie"];
    $rslt = $con->query("select * from hp_pharmacie as p where "
            . "p.idpharmacie='" . $id . "'") or die(mysqli_error($con));
    $row = mysqli_fetch_assoc($rslt);
// R�cup�ration du num�ro de l'�tape en cours
    if (empty($_GET['pagecom']) or ! is_numeric($_GET['pagecom'])) {
        define('NUM_PAGE', 1);
    } else {
        // En situation r�elle, il faudrait v�rifier l'existence de cette page
        define('NUM_PAGE', intval($_GET['pagecom']));
    }

// D�claration de la variable de session
    if (empty($_SESSION['formpharmaciee'])) {
        $_SESSION['formpharmaciee'] = array();
    }

    if (empty($_SESSION['formpharmaciee'])) {
        $_SESSION['formpharmaciee'] = array();
        $_SESSION['formpharmaciee'][1] = array(
            'idpharmacie' => $_GET["idpharmacie"],
            'codepe' => $row["codepharmacie"],
            'pharmaciee' => $row["nompharmacie"]
        );
    }


    switch (NUM_PAGE) {

        case 2:

            // R�cup�ration des informations du formulaire pr�c�dent
            if (!empty($_POST)) {

                $_SESSION['formpharmaciee'][NUM_PAGE - 1] = array(
                    'idpharmacie' => $_GET["idpharmacie"],
                    'codepe' => strtoupper(trim(htmlspecialchars($_POST["codepe"]))),
                    'pharmaciee' => ucwords(trim(htmlspecialchars($_POST["pharmaciee"])))
                );
            }
            require('./hopitalpages/hopitalpharmacie/hopitalediter/form_terminer.php');
            break;

        case 1:
        default:
            // Valeurs par d�faut
            if (empty($_SESSION['formpharmaciee'][NUM_PAGE])) {
                $_SESSION['formpharmaciee'][NUM_PAGE] = array(
                    'idpharmacie' => $_GET["idpharmacie"],
                    'codepe' => $row["codepharmacie"],
                    'pharmaciee' => $row["nompharmacie"]
                );
            } else if (($_SESSION['formpharmaciee'][1]['idpharmacie'] != $_GET["idpharmacie"])) {
                $_SESSION['formpharmaciee'][NUM_PAGE] = array(
                    'idpharmacie' => $_GET["idpharmacie"],
                    'codepe' => $row["codepharmacie"],
                    'pharmaciee' => $row["nompharmacie"]
                );
            }
            require('hopitalpages/hopitalpharmacie/hopitalediter/form_edit_pharmacie.php');
            break;
    }
}