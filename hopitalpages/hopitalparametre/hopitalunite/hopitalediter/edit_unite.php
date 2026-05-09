
<?php

if (isset($_REQUEST["idunite"])) {
    $id = $_REQUEST["idunite"];
    $rslt = $con->query("select * from hp_unite as p where "
            . "p.idunite='" . $id . "'") or die(mysqli_error($con));
    $row = mysqli_fetch_assoc($rslt);
// R�cup�ration du num�ro de l'�tape en cours
    if (empty($_GET['pagecom']) or ! is_numeric($_GET['pagecom'])) {
        define('NUM_PAGE', 1);
    } else {
        // En situation r�elle, il faudrait v�rifier l'existence de cette page
        define('NUM_PAGE', intval($_GET['pagecom']));
    }

// D�claration de la variable de session
    if (empty($_SESSION['formunitee'])) {
        $_SESSION['formunitee'] = array();
    }

    if (empty($_SESSION['formunitee'])) {
        $_SESSION['formunitee'] = array();
        $_SESSION['formunitee'][1] = array(
            'idunite' => $_GET["idunite"],
            'codepe' => $row["codeunite"],
            'unitee' => $row["libelleunite"]
        );
    }


    switch (NUM_PAGE) {

        case 2:

            // R�cup�ration des informations du formulaire pr�c�dent
            if (!empty($_POST)) {

                $_SESSION['formunitee'][NUM_PAGE - 1] = array(
                    'idunite' => $_GET["idunite"],
                    'codepe' => (trim(htmlspecialchars($_POST["codepe"]))),
                    'unitee' => (trim(htmlspecialchars($_POST["unitee"])))
                );
            }
            require('./hopitalpages/hopitalparametre/hopitalunite/hopitalediter/form_terminer.php');
            break;

        case 1:
        default:
            // Valeurs par d�faut
            if (empty($_SESSION['formunitee'][NUM_PAGE])) {
                $_SESSION['formunitee'][NUM_PAGE] = array(
                    'idunite' => $_GET["idunite"],
                    'codepe' => $row["codeunite"],
                    'unitee' => $row["libelleunite"]
                );
            } else if (($_SESSION['formunitee'][1]['idunite'] != $_GET["idunite"])) {
                $_SESSION['formunitee'][NUM_PAGE] = array(
                    'idunite' => $_GET["idunite"],
                    'codepe' => $row["codeunite"],
                    'unitee' => $row["libelleunite"]
                );
            }
            require('hopitalpages/hopitalparametre/hopitalunite/hopitalediter/form_edit_unite.php');
            break;
    }
}