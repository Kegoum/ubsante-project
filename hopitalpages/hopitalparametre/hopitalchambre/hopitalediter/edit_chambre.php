
<?php

if (isset($_REQUEST["idchambre"])) {
    $id = $_REQUEST["idchambre"];
    $rslt = $con->query("select * from hp_chambre where idchambre='" . $id . "'") or die(mysqli_error($con));
    $row = mysqli_fetch_assoc($rslt);
// R�cup�ration du num�ro de l'�tape en cours
    if (empty($_GET['pagecom']) or ! is_numeric($_GET['pagecom'])) {
        define('NUM_PAGE', 1);
    } else {
        // En situation r�elle, il faudrait v�rifier l'existence de cette page
        define('NUM_PAGE', intval($_GET['pagecom']));
    }

// D�claration de la variable de session
    if (empty($_SESSION['formchambree'])) {
        $_SESSION['formchambree'] = array();
    }

    if (empty($_SESSION['formchambree'])) {
        $_SESSION['formchambree'] = array();
        $_SESSION['formchambree'][1] = array(
            'idchambre' => $_GET["idchambre"],
            'categoriee' => $row["idcategoriechambre"],
            'codee' => $row["codechambre"],
            'chambree' => $row["libellechambre"],
            'place' => $row["placechambre"]
        );
    }


    switch (NUM_PAGE) {

        case 2:

            // R�cup�ration des informations du formulaire pr�c�dent
            if (!empty($_POST)) {

                $_SESSION['formchambree'][NUM_PAGE - 1] = array(
                    'idchambre' => $_GET["idchambre"],
                    'codee' => strtoupper(trim(htmlspecialchars($_POST["codee"]))),
                    'categoriee' => trim(htmlspecialchars($_POST["categoriee"])),
                    'chambree' => ucwords(trim(htmlspecialchars($_POST["chambree"]))),
                    'place' => intval(trim(htmlspecialchars($_POST["place"])))
                );
            }
            require('./hopitalpages/hopitalparametre/hopitalchambre/hopitalediter/form_terminer.php');
            break;

        case 1:
        default:
            // Valeurs par d�faut
            if (empty($_SESSION['formchambree'][NUM_PAGE])) {
                $_SESSION['formchambree'][NUM_PAGE] = array(
                    'idchambre' => $_GET["idchambre"],
                    'categoriee' => $row["idcategoriechambre"],
                    'codee' => $row["codechambre"],
                    'chambree' => $row["libellechambre"],
                    'place' => $row["placechambre"]
                );
            } else if (($_SESSION['formchambree'][1]['idchambre'] != $_GET["idchambre"])) {
                $_SESSION['formchambree'][NUM_PAGE] = array(
                    'idchambre' => $_GET["idchambre"],
                    'categoriee' => $row["idcategoriechambre"],
                    'codee' => $row["codechambre"],
                    'chambree' => $row["libellechambre"],
                    'place' => $row["placechambre"]
                );
            }
            require('hopitalpages/hopitalparametre/hopitalchambre/hopitalediter/form_edit_chambre.php');
            break;
    }
}