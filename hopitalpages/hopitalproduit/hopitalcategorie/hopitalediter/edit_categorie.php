
<?php

if (isset($_REQUEST["idcategorie"])) {
    $id = $_REQUEST["idcategorie"];
    $rslt = $con->query("select * from hp_categorie as p where "
            . "p.idcategorie='" . $id . "'") or die(mysqli_error($con));
    $row = mysqli_fetch_assoc($rslt);
// R�cup�ration du num�ro de l'�tape en cours
    if (empty($_GET['pagecom']) or ! is_numeric($_GET['pagecom'])) {
        define('NUM_PAGE', 1);
    } else {
        // En situation r�elle, il faudrait v�rifier l'existence de cette page
        define('NUM_PAGE', intval($_GET['pagecom']));
    }

// D�claration de la variable de session
    if (empty($_SESSION['formcategoriee'])) {
        $_SESSION['formcategoriee'] = array();
    }

    if (empty($_SESSION['formcategoriee'])) {
        $_SESSION['formcategoriee'] = array();
        $_SESSION['formcategoriee'][1] = array(
            'idcategorie' => $_GET["idcategorie"],
            'codepe' => $row["codecategorie"],
            'categoriee' => $row["libellecategorie"]
        );
    }


    switch (NUM_PAGE) {

        case 2:

            // R�cup�ration des informations du formulaire pr�c�dent
            if (!empty($_POST)) {

                $_SESSION['formcategoriee'][NUM_PAGE - 1] = array(
                    'idcategorie' => $_GET["idcategorie"],
                    'codepe' => (trim(htmlspecialchars($_POST["codepe"]))),
                    'categoriee' => (trim(htmlspecialchars($_POST["categoriee"])))
                );
            }
            require('./hopitalpages/hopitalproduit/hopitalcategorie/hopitalediter/form_terminer.php');
            break;

        case 1:
        default:
            // Valeurs par d�faut
            if (empty($_SESSION['formcategoriee'][NUM_PAGE])) {
                $_SESSION['formcategoriee'][NUM_PAGE] = array(
                    'idcategorie' => $_GET["idcategorie"],
                    'codepe' => $row["codecategorie"],
                    'categoriee' => $row["libellecategorie"]
                );
            } else if (($_SESSION['formcategoriee'][1]['idcategorie'] != $_GET["idcategorie"])) {
                $_SESSION['formcategoriee'][NUM_PAGE] = array(
                    'idcategorie' => $_GET["idcategorie"],
                    'codepe' => $row["codecategorie"],
                    'categoriee' => $row["libellecategorie"]
                );
            }
            require('hopitalpages/hopitalproduit/hopitalcategorie/hopitalediter/form_edit_categorie.php');
            break;
    }
}