
<?php

if (isset($_REQUEST["idparametre"])) {
    $id = $_REQUEST["idparametre"];
    $rslt = $con->query("select * from hp_parametre as p where "
            . "p.idparametre='" . $id . "'") or die(mysqli_error($con));
    $row = mysqli_fetch_assoc($rslt);
// R�cup�ration du num�ro de l'�tape en cours
    if (empty($_GET['pagecom']) or ! is_numeric($_GET['pagecom'])) {
        define('NUM_PAGE', 1);
    } else {
        // En situation r�elle, il faudrait v�rifier l'existence de cette page
        define('NUM_PAGE', intval($_GET['pagecom']));
    }

// D�claration de la variable de session
    if (empty($_SESSION['formparametree'])) {
        $_SESSION['formparametree'] = array();
    }

    if (empty($_SESSION['formparametree'])) {
        $_SESSION['formparametree'] = array();
        $_SESSION['formparametree'][1] = array(
            'idparametre' => $_GET["idparametre"],
            'parametree' => $row["libelleparametre"],
            'valmin' => $row["valeurminparametre"],
            'valmax' => $row["valeurmaxparametre"],
            'unite' => $row["idunite"]
        );
    }


    switch (NUM_PAGE) {

        case 2:

            // R�cup�ration des informations du formulaire pr�c�dent
            if (!empty($_POST)) {

                $_SESSION['formparametree'][NUM_PAGE - 1] = array(
                    'idparametre' => $_GET["idparametre"],
                    'parametree' => ucwords(trim(htmlspecialchars($_POST["parametree"]))),
                    'valmin' => floatval(trim(htmlspecialchars($_POST["valmin"]))),
                    'valmax' => floatval(trim(htmlspecialchars($_POST["valmax"]))),
                    'unite' => floatval(trim(htmlspecialchars($_POST["unite"])))
                );
            }
            require('./hopitalpages/hopitalparametre/hopitalparametre/hopitalediter/form_terminer.php');
            break;

        case 1:
        default:
            // Valeurs par d�faut
            if (empty($_SESSION['formparametree'][NUM_PAGE])) {
                $_SESSION['formparametree'][NUM_PAGE] = array(
                    'idparametre' => $_GET["idparametre"],
                    'parametree' => $row["libelleparametre"],
                    'valmin' => $row["valeurminparametre"],
                    'valmax' => $row["valeurmaxparametre"],
                    'unite' => $row["idunite"]
                );
            } else if (($_SESSION['formparametree'][1]['idparametre'] != $_GET["idparametre"])) {
                $_SESSION['formparametree'][NUM_PAGE] = array(
                    'idparametre' => $_GET["idparametre"],
                    'parametree' => $row["libelleparametre"],
                    'valmin' => $row["valeurminparametre"],
                    'valmax' => $row["valeurmaxparametre"],
                    'unite' => $row["idunite"]
                );
            }
            require('hopitalpages/hopitalparametre/hopitalparametre/hopitalediter/form_edit_parametre.php');
            break;
    }
}