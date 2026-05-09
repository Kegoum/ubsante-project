
<?php

if (isset($_REQUEST["idlignenfs"])) {
    $id = $_REQUEST["idlignenfs"];
    $rslt = $con->query("select * from hp_ligne_nfs as p where "
            . "p.idlignenfs='" . $id . "'") or die(mysqli_error($con));
    $row = mysqli_fetch_assoc($rslt);
// R�cup�ration du num�ro de l'�tape en cours
    if (empty($_GET['pagecom']) or ! is_numeric($_GET['pagecom'])) {
        define('NUM_PAGE', 1);
    } else {
        // En situation r�elle, il faudrait v�rifier l'existence de cette page
        define('NUM_PAGE', intval($_GET['pagecom']));
    }

// D�claration de la variable de session
    if (empty($_SESSION['formnfse'])) {
        $_SESSION['formnfse'] = array();
    }

    if (empty($_SESSION['formnfse'])) {
        $_SESSION['formnfse'] = array();
        $_SESSION['formnfse'][1] = array(
            'idlignenfs' => $_GET["idlignenfs"],
            'codee' => $row["codelignenfs"],
            'nfse' => $row["libellelignenfs"],
            'valmin29' => $row["29jourminlignenfs"],
            'valmax29' => $row["29jourmaxlignenfs"],
            'valmin6' => $row["6anminlignenfs"],
            'valmax6' => $row["6anmaxlignenfs"],
            'valminf' => $row["adultefemmeminlignenfs"],
            'valmaxf' => $row["adultefemmemaxlignenfs"],
            'valminh' => $row["adultehommeminlignenfs"],
            'valmaxh' => $row["adultehommemaxlignenfs"],
            'unite' => $row["idunite"]
        );
    }


    switch (NUM_PAGE) {

        case 2:

            // R�cup�ration des informations du formulaire pr�c�dent
            if (!empty($_POST)) {

                $_SESSION['formnfse'][NUM_PAGE - 1] = array(
                    'idlignenfs' => $_GET["idlignenfs"],
                    'codee' => ucwords(trim(htmlspecialchars($_POST["codee"]))),
                    'nfse' => ucwords(trim(htmlspecialchars($_POST["nfse"]))),
                    'valmin29' => floatval(trim(htmlspecialchars($_POST["valmin29"]))),
                    'valmax29' => floatval(trim(htmlspecialchars($_POST["valmax29"]))),
                    'valmin6' => floatval(trim(htmlspecialchars($_POST["valmin6"]))),
                    'valmax6' => floatval(trim(htmlspecialchars($_POST["valmax6"]))),
                    'valminf' => floatval(trim(htmlspecialchars($_POST["valminf"]))),
                    'valmaxf' => floatval(trim(htmlspecialchars($_POST["valmaxf"]))),
                    'valminh' => floatval(trim(htmlspecialchars($_POST["valminh"]))),
                    'valmaxh' => floatval(trim(htmlspecialchars($_POST["valmaxh"]))),
                    'unite' => floatval(trim(htmlspecialchars($_POST["unite"])))
                );
            }
            require('./hopitalpages/hopitalparametre/hopitallaboratoire/hopitalnfs/hopitalediter/form_terminer.php');
            break;

        case 1:
        default:
            // Valeurs par d�faut
            if (empty($_SESSION['formnfse'][NUM_PAGE])) {
                $_SESSION['formnfse'][NUM_PAGE] = array(
                    'idlignenfs' => $_GET["idlignenfs"],
                    'codee' => $row["codelignenfs"],
                    'nfse' => $row["libellelignenfs"],
                    'valmin29' => $row["29jourminlignenfs"],
                    'valmax29' => $row["29jourmaxlignenfs"],
                    'valmin6' => $row["6anminlignenfs"],
                    'valmax6' => $row["6anmaxlignenfs"],
                    'valminf' => $row["adultefemmeminlignenfs"],
                    'valmaxf' => $row["adultefemmemaxlignenfs"],
                    'valminh' => $row["adultehommeminlignenfs"],
                    'valmaxh' => $row["adultehommemaxlignenfs"],
                    'unite' => $row["idunite"]
                );
            } else if (($_SESSION['formnfse'][1]['idlignenfs'] != $_GET["idlignenfs"])) {
                $_SESSION['formnfse'][NUM_PAGE] = array(
                    'idlignenfs' => $_GET["idlignenfs"],
                    'codee' => $row["codelignenfs"],
                    'nfse' => $row["libellelignenfs"],
                    'valmin29' => $row["29jourminlignenfs"],
                    'valmax29' => $row["29jourmaxlignenfs"],
                    'valmin6' => $row["6anminlignenfs"],
                    'valmax6' => $row["6anmaxlignenfs"],
                    'valminf' => $row["adultefemmeminlignenfs"],
                    'valmaxf' => $row["adultefemmemaxlignenfs"],
                    'valminh' => $row["adultehommeminlignenfs"],
                    'valmaxh' => $row["adultehommemaxlignenfs"],
                    'unite' => $row["idunite"]
                );
            }
            require('hopitalpages/hopitalparametre/hopitallaboratoire/hopitalnfs/hopitalediter/form_edit_nfs.php');
            break;
    }
}