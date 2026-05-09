
<?php

if (isset($_REQUEST["idclassemedicamenteuse"])) {
    $id = $_REQUEST["idclassemedicamenteuse"];
    $rslt = $con->query("select * from hp_classe_medicamenteuse as p where "
            . "p.idclassemedicamenteuse='" . $id . "'") or die(mysqli_error($con));
    $row = mysqli_fetch_assoc($rslt);
// R�cup�ration du num�ro de l'�tape en cours
    if (empty($_GET['pagecom']) or ! is_numeric($_GET['pagecom'])) {
        define('NUM_PAGE', 1);
    } else {
        // En situation r�elle, il faudrait v�rifier l'existence de cette page
        define('NUM_PAGE', intval($_GET['pagecom']));
    }

// D�claration de la variable de session
    if (empty($_SESSION['formfamillee'])) {
        $_SESSION['formfamillee'] = array();
    }

    if (empty($_SESSION['formfamillee'])) {
        $_SESSION['formfamillee'] = array();
        $_SESSION['formfamillee'][1] = array(
            'idclassemedicamenteuse' => $_GET["idclassemedicamenteuse"],
            'famillee' => $row["libelleclassemedicamenteuse"]
        );
    }


    switch (NUM_PAGE) {

        case 2:

            // R�cup�ration des informations du formulaire pr�c�dent
            if (!empty($_POST)) {

                $_SESSION['formfamillee'][NUM_PAGE - 1] = array(
                    'idclassemedicamenteuse' => $_GET["idclassemedicamenteuse"],
                    'famillee' => (trim(htmlspecialchars($_POST["famillee"])))
                );
            }
            require('./hopitalpages/hopitalfamille/hopitalediter/form_terminer.php');
            break;

        case 1:
        default:
            // Valeurs par d�faut
            if (empty($_SESSION['formfamillee'][NUM_PAGE])) {
                $_SESSION['formfamillee'][NUM_PAGE] = array(
                    'idclassemedicamenteuse' => $_GET["idclassemedicamenteuse"],
                    'famillee' => $row["libelleclassemedicamenteuse"]
                );
            } else if (($_SESSION['formfamillee'][1]['idclassemedicamenteuse'] != $_GET["idclassemedicamenteuse"])) {
                $_SESSION['formfamillee'][NUM_PAGE] = array(
                    'idclassemedicamenteuse' => $_GET["idclassemedicamenteuse"],
                    'famillee' => $row["libelleclassemedicamenteuse"]
                );
            }
            require('hopitalpages/hopitalfamille/hopitalediter/form_edit_famille.php');
            break;
    }
}