
<?php

if (isset($_REQUEST["idlit"])) {
    $id = $_REQUEST["idlit"];
    $rslt = $con->query("select * from hp_lit as l left join hp_chambre as c on l.idchambre=c.idchambre where l.idlit='" . $id . "'") or die(mysqli_error($con));
    $row = mysqli_fetch_assoc($rslt);
// R�cup�ration du num�ro de l'�tape en cours
    if (empty($_GET['pagecom']) or ! is_numeric($_GET['pagecom'])) {
        define('NUM_PAGE', 1);
    } else {
        // En situation r�elle, il faudrait v�rifier l'existence de cette page
        define('NUM_PAGE', intval($_GET['pagecom']));
    }

// D�claration de la variable de session
    if (empty($_SESSION['formlite'])) {
        $_SESSION['formlite'] = array();
    }

    if (empty($_SESSION['formlite'])) {
        $_SESSION['formlite'] = array();
        $_SESSION['formlite'][1] = array(
            'idlit' => $_GET["idlit"],
            'libellee' => $row["libellelit"],
            'codee' => $row["codelit"]
        );
    }


    switch (NUM_PAGE) {

        case 2:

            // R�cup�ration des informations du formulaire pr�c�dent
            if (!empty($_POST)) {

                $_SESSION['formlite'][NUM_PAGE - 1] = array(
                    'idlit' => $_GET["idlit"],
                    'libellee' => ucwords(trim(htmlspecialchars($_POST["libellee"]))),
                    'codee' => trim(htmlspecialchars($_POST["codee"]))
                );
            }
            require('./hopitalpages/hopitalparametre/hopitalchambre/hopitallit/hopitalediter/form_terminer.php');
            break;

        case 1:
        default:
            // Valeurs par d�faut
            if (empty($_SESSION['formlite'][NUM_PAGE])) {
                $_SESSION['formlite'][NUM_PAGE] = array(
                    'idlit' => $_GET["idlit"],
            'libellee' => $row["libellelit"],
            'codee' => $row["codelit"]
                );
            } else if (($_SESSION['formlite'][1]['idlit'] != $_GET["idlit"])) {
                $_SESSION['formlite'][NUM_PAGE] = array(
                    'idlit' => $_GET["idlit"],
            'libellee' => $row["libellelit"],
            'codee' => $row["codelit"]
                );
            }
            require('hopitalpages/hopitalparametre/hopitalchambre/hopitallit/hopitalediter/form_edit_lit.php');
            break;
    }
}