
<?php

if (isset($_REQUEST["iddepartement"])) {
    $id = $_REQUEST["iddepartement"];
    $rslt = $con->query("select * from hp_departement as v left join hp_region as p on v.idregion=p.idregion where "
            . "v.iddepartement='" . $id . "'") or die(mysqli_error($con));
    $row = mysqli_fetch_assoc($rslt);
// R�cup�ration du num�ro de l'�tape en cours
    if (empty($_GET['pagecom']) or ! is_numeric($_GET['pagecom'])) {
        define('NUM_PAGE', 1);
    } else {
        // En situation r�elle, il faudrait v�rifier l'existence de cette page
        define('NUM_PAGE', intval($_GET['pagecom']));
    }

// D�claration de la variable de session
    if (empty($_SESSION['formdepartemente'])) {
        $_SESSION['formdepartemente'] = array();
    }

    if (empty($_SESSION['formdepartemente'])) {
        $_SESSION['formdepartemente'] = array();
        $_SESSION['formdepartemente'][1] = array(
            'iddepartement' => $_GET["iddepartement"],
            'regione' => $row["idregion"],
            'departemente' => $row["libelledepartement"],
            'cheflieue' => $row["cheflieudepartement"]
        );
    }


    switch (NUM_PAGE) {

        case 2:

            // R�cup�ration des informations du formulaire pr�c�dent
            if (!empty($_POST)) {

                $_SESSION['formdepartemente'][NUM_PAGE - 1] = array(
                    'iddepartement' => $_GET["iddepartement"],
                    'regione' => trim(htmlspecialchars($_POST["regione"])),
                    'departemente' => ucwords(trim(htmlspecialchars($_POST["departemente"]))),
                'cheflieue' => ucwords(trim(htmlspecialchars($_POST["cheflieue"])))
                );
            }
            require('./hopitalpages/hopitalparametre/hopitaldepartement/hopitalediter/form_terminer.php');
            break;

        case 1:
        default:
            // Valeurs par d�faut
            if (empty($_SESSION['formdepartemente'][NUM_PAGE])) {
                $_SESSION['formdepartemente'][NUM_PAGE] = array(
                    'iddepartement' => $_GET["iddepartement"],
                    'regione' => $row["idregion"],
                    'departemente' => $row["libelledepartement"],
            'cheflieue' => $row["cheflieudepartement"]
                );
            } else if (($_SESSION['formdepartemente'][1]['iddepartement'] != $_GET["iddepartement"])) {
                $_SESSION['formdepartemente'][NUM_PAGE] = array(
                    'iddepartement' => $_GET["iddepartement"],
                    'regione' => $row["idregion"],
                    'departemente' => $row["libelledepartement"],
            'cheflieue' => $row["cheflieudepartement"]
                );
            }
            require('hopitalpages/hopitalparametre/hopitaldepartement/hopitalediter/form_edit_departement.php');
            break;
    }
}