
<?php

if (isset($_REQUEST["idmagasin"])) {
    $id = $_REQUEST["idmagasin"];
    $rslt = $con->query("select * from hp_magasin as p where "
            . "p.idmagasin='" . $id . "'") or die(mysqli_error($con));
    $row = mysqli_fetch_assoc($rslt);
// R�cup�ration du num�ro de l'�tape en cours
    if (empty($_GET['pagecom']) or ! is_numeric($_GET['pagecom'])) {
        define('NUM_PAGE', 1);
    } else {
        // En situation r�elle, il faudrait v�rifier l'existence de cette page
        define('NUM_PAGE', intval($_GET['pagecom']));
    }

// D�claration de la variable de session
    if (empty($_SESSION['formmagasine'])) {
        $_SESSION['formmagasine'] = array();
    }

    if (empty($_SESSION['formmagasine'])) {
        $_SESSION['formmagasine'] = array();
        $_SESSION['formmagasine'][1] = array(
            'idmagasin' => $_GET["idmagasin"],
            'codepe' => $row["codemagasin"],
            'magasine' => $row["nommagasin"]
        );
    }


    switch (NUM_PAGE) {

        case 2:

            // R�cup�ration des informations du formulaire pr�c�dent
            if (!empty($_POST)) {

                $_SESSION['formmagasine'][NUM_PAGE - 1] = array(
                    'idmagasin' => $_GET["idmagasin"],
                    'codepe' => strtoupper(trim(htmlspecialchars($_POST["codepe"]))),
                    'magasine' => ucwords(trim(htmlspecialchars($_POST["magasine"])))
                );
            }
            require('./hopitalpages/hopitalmagasin/hopitalediter/form_terminer.php');
            break;

        case 1:
        default:
            // Valeurs par d�faut
            if (empty($_SESSION['formmagasine'][NUM_PAGE])) {
                $_SESSION['formmagasine'][NUM_PAGE] = array(
                    'idmagasin' => $_GET["idmagasin"],
                    'codepe' => $row["codemagasin"],
                    'magasine' => $row["nommagasin"]
                );
            } else if (($_SESSION['formmagasine'][1]['idmagasin'] != $_GET["idmagasin"])) {
                $_SESSION['formmagasine'][NUM_PAGE] = array(
                    'idmagasin' => $_GET["idmagasin"],
                    'codepe' => $row["codemagasin"],
                    'magasine' => $row["nommagasin"]
                );
            }
            require('hopitalpages/hopitalmagasin/hopitalediter/form_edit_magasin.php');
            break;
    }
}