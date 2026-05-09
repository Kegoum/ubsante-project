
<?php

if (isset($_REQUEST["idservice"])) {
    $id = $_REQUEST["idservice"];
    $rslt = $con->query("select * from hp_service as p where "
            . "p.idservice='" . $id . "'") or die(mysqli_error($con));
    $row = mysqli_fetch_assoc($rslt);
// R�cup�ration du num�ro de l'�tape en cours
    if (empty($_GET['pagecom']) or ! is_numeric($_GET['pagecom'])) {
        define('NUM_PAGE', 1);
    } else {
        // En situation r�elle, il faudrait v�rifier l'existence de cette page
        define('NUM_PAGE', intval($_GET['pagecom']));
    }

// D�claration de la variable de session
    if (empty($_SESSION['formservicee'])) {
        $_SESSION['formservicee'] = array();
    }

    if (empty($_SESSION['formservicee'])) {
        $_SESSION['formservicee'] = array();
        $_SESSION['formservicee'][1] = array(
            'idservice' => $_GET["idservice"],
            'codepe' => $row["codeservice"],
            'servicee' => $row["nomservice"],
            'domainee' => $row["domaineservice"],
            'tel' => $row["telephoneservice"],
            'local' => $row["localservice"]
        );
    }


    switch (NUM_PAGE) {

        case 2:

            // R�cup�ration des informations du formulaire pr�c�dent
            if (!empty($_POST)) {

            $loc=0;
            if(isset($_POST["local"])){
                $loc=1;
            }
                $_SESSION['formservicee'][NUM_PAGE - 1] = array(
                    'idservice' => $_GET["idservice"],
                    'codepe' => strtoupper(trim(htmlspecialchars($_POST["codepe"]))),
                    'servicee' => ucwords(trim(htmlspecialchars($_POST["servicee"]))),
                    'domainee' => ucwords(trim(htmlspecialchars($_POST["domainee"]))),
                'tel' => ucwords(trim(htmlspecialchars($_POST["tel"]))),
                'local' => $loc
                );
            }
            require('./hopitalpages/hopitalparametre/hopitalservice/hopitalediter/form_terminer.php');
            break;

        case 1:
        default:
            // Valeurs par d�faut
            if (empty($_SESSION['formservicee'][NUM_PAGE])) {
                $_SESSION['formservicee'][NUM_PAGE] = array(
                    'idservice' => $_GET["idservice"],
                    'codepe' => $row["codeservice"],
                    'servicee' => $row["nomservice"],
                    'domainee' => $row["domaineservice"],
            'tel' => $row["telephoneservice"],
            'local' => $row["localservice"]
                );
            } else if (($_SESSION['formservicee'][1]['idservice'] != $_GET["idservice"])) {
                $_SESSION['formservicee'][NUM_PAGE] = array(
                    'idservice' => $_GET["idservice"],
                    'codepe' => $row["codeservice"],
                    'servicee' => $row["nomservice"],
                    'domainee' => $row["domaineservice"],
            'tel' => $row["telephoneservice"],
            'local' => $row["localservice"]
                );
            }
            require('hopitalpages/hopitalparametre/hopitalservice/hopitalediter/form_edit_service.php');
            break;
    }
}