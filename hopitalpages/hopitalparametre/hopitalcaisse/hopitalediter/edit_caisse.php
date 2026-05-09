
<?php

if (isset($_REQUEST["idcaisse"])) {
    $id = $_REQUEST["idcaisse"];
    $rslt = $con->query("select * from hp_caisse as p where "
            . "p.idcaisse='" . $id . "'") or die(mysqli_error($con));
    $row = mysqli_fetch_assoc($rslt);
// R�cup�ration du num�ro de l'�tape en cours
    if (empty($_GET['pagecom']) or ! is_numeric($_GET['pagecom'])) {
        define('NUM_PAGE', 1);
    } else {
        // En situation r�elle, il faudrait v�rifier l'existence de cette page
        define('NUM_PAGE', intval($_GET['pagecom']));
    }

// D�claration de la variable de session
    if (empty($_SESSION['formcaissee'])) {
        $_SESSION['formcaissee'] = array();
    }

    if (empty($_SESSION['formcaissee'])) {
        $_SESSION['formcaissee'] = array();
        $_SESSION['formcaissee'][1] = array(
            'idcaisse' => $_GET["idcaisse"],
            'codepe' => $row["codecaisse"],
            'caissee' => $row["nomcaisse"]
        );
    }


    switch (NUM_PAGE) {

        case 2:

            // R�cup�ration des informations du formulaire pr�c�dent
            if (!empty($_POST)) {

                $_SESSION['formcaissee'][NUM_PAGE - 1] = array(
                    'idcaisse' => $_GET["idcaisse"],
                    'codepe' => strtoupper(trim(htmlspecialchars($_POST["codepe"]))),
                    'caissee' => ucwords(trim(htmlspecialchars($_POST["caissee"])))
                );
            }
            require('./hopitalpages/hopitalparametre/hopitalcaisse/hopitalediter/form_terminer.php');
            break;

        case 1:
        default:
            // Valeurs par d�faut
            if (empty($_SESSION['formcaissee'][NUM_PAGE])) {
                $_SESSION['formcaissee'][NUM_PAGE] = array(
                    'idcaisse' => $_GET["idcaisse"],
                    'codepe' => $row["codecaisse"],
                    'caissee' => $row["nomcaisse"]
                );
            } else if (($_SESSION['formcaissee'][1]['idcaisse'] != $_GET["idcaisse"])) {
                $_SESSION['formcaissee'][NUM_PAGE] = array(
                    'idcaisse' => $_GET["idcaisse"],
                    'codepe' => $row["codecaisse"],
                    'caissee' => $row["nomcaisse"]
                );
            }
            require('hopitalpages/hopitalparametre/hopitalcaisse/hopitalediter/form_edit_caisse.php');
            break;
    }
}