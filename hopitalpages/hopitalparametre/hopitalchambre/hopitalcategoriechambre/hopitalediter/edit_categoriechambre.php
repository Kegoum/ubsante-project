
<?php

if (isset($_REQUEST["idcategoriechambre"])) {
    $id = $_REQUEST["idcategoriechambre"];
    $rslt = $con->query("select * from hp_categorie_chambre where idcategoriechambre='" . $id . "'") or die(mysqli_error($con));
    $row = mysqli_fetch_assoc($rslt);
// R�cup�ration du num�ro de l'�tape en cours
    if (empty($_GET['pagecom']) or ! is_numeric($_GET['pagecom'])) {
        define('NUM_PAGE', 1);
    } else {
        // En situation r�elle, il faudrait v�rifier l'existence de cette page
        define('NUM_PAGE', intval($_GET['pagecom']));
    }

// D�claration de la variable de session
    if (empty($_SESSION['formcategoriechambree'])) {
        $_SESSION['formcategoriechambree'] = array();
    }

    if (empty($_SESSION['formcategoriechambree'])) {
        $_SESSION['formcategoriechambree'] = array();
        $_SESSION['formcategoriechambree'][1] = array(
            'idcategoriechambre' => $_GET["idcategoriechambre"],
            'libellee' => $row["libellecategoriechambre"],
            'prixe' => $row["prixcategoriechambre"]
        );
    }


    switch (NUM_PAGE) {

        case 2:

            // R�cup�ration des informations du formulaire pr�c�dent
            if (!empty($_POST)) {

                $_SESSION['formcategoriechambree'][NUM_PAGE - 1] = array(
                    'idcategoriechambre' => $_GET["idcategoriechambre"],
                    'libellee' => ucwords(trim(htmlspecialchars($_POST["libellee"]))),
                    'prixe' => trim(htmlspecialchars($_POST["prixe"]))
                );
            }
            require('./hopitalpages/hopitalparametre/hopitalchambre/hopitalcategoriechambre/hopitalediter/form_terminer.php');
            break;

        case 1:
        default:
            // Valeurs par d�faut
            if (empty($_SESSION['formcategoriechambree'][NUM_PAGE])) {
                $_SESSION['formcategoriechambree'][NUM_PAGE] = array(
                    'idcategoriechambre' => $_GET["idcategoriechambre"],
            'libellee' => $row["libellecategoriechambre"],
            'prixe' => $row["prixcategoriechambre"]
                );
            } else if (($_SESSION['formcategoriechambree'][1]['idcategoriechambre'] != $_GET["idcategoriechambre"])) {
                $_SESSION['formcategoriechambree'][NUM_PAGE] = array(
                    'idcategoriechambre' => $_GET["idcategoriechambre"],
            'libellee' => $row["libellecategoriechambre"],
            'prixe' => $row["prixcategoriechambre"]
                );
            }
            require('hopitalpages/hopitalparametre/hopitalchambre/hopitalcategoriechambre/hopitalediter/form_edit_categoriechambre.php');
            break;
    }
}