
<?php

if (isset($_REQUEST["idmodepaiement"])) {
    $id = $_REQUEST["idmodepaiement"];
    $rslt = $con->query("select * from hp_mode_paiement where idmodepaiement='" . $id . "'") or die(mysqli_error($con));
    $row = mysqli_fetch_assoc($rslt);
// R�cup�ration du num�ro de l'�tape en cours
    if (empty($_GET['pagecom']) or ! is_numeric($_GET['pagecom'])) {
        define('NUM_PAGE', 1);
    } else {
        // En situation r�elle, il faudrait v�rifier l'existence de cette page
        define('NUM_PAGE', intval($_GET['pagecom']));
    }

// D�claration de la variable de session
    if (empty($_SESSION['formmodepaiemente'])) {
        $_SESSION['formmodepaiemente'] = array();
    }

    if (empty($_SESSION['formmodepaiemente'])) {
        $_SESSION['formmodepaiemente'] = array();
        $_SESSION['formmodepaiemente'][1] = array(
            'idmodepaiement' => $_GET["idmodepaiement"],
            'codee' => $row["codemodepaiement"],
            'modepaiemente' => $row["libellemodepaiement"]
        );
    }


    switch (NUM_PAGE) {

        case 2:

            // R�cup�ration des informations du formulaire pr�c�dent
            if (!empty($_POST)) {

                $_SESSION['formmodepaiemente'][NUM_PAGE - 1] = array(
                    'idmodepaiement' => $_GET["idmodepaiement"],
                    'codee' => strtoupper(trim(htmlspecialchars($_POST["codee"]))),
                    'modepaiemente' => ucwords(trim(htmlspecialchars($_POST["modepaiemente"])))
                );
            }
            require('./hopitalpages/hopitalparametre/hopitalmodepaiement/hopitalediter/form_terminer.php');
            break;

        case 1:
        default:
            // Valeurs par d�faut
            if (empty($_SESSION['formmodepaiemente'][NUM_PAGE])) {
                $_SESSION['formmodepaiemente'][NUM_PAGE] = array(
                    'idmodepaiement' => $_GET["idmodepaiement"],
                    'codee' => $row["codemodepaiement"],
                    'modepaiemente' => $row["libellemodepaiement"]
                );
            } else if (($_SESSION['formmodepaiemente'][1]['idmodepaiement'] != $_GET["idmodepaiement"])) {
                $_SESSION['formmodepaiemente'][NUM_PAGE] = array(
                    'idmodepaiement' => $_GET["idmodepaiement"],
                    'codee' => $row["codemodepaiement"],
                    'modepaiemente' => $row["libellemodepaiement"]
                );
            }
            require('hopitalpages/hopitalparametre/hopitalmodepaiement/hopitalediter/form_edit_modepaiement.php');
            break;
    }
}