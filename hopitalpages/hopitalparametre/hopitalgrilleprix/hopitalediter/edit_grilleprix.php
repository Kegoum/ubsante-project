
<?php

if (isset($_REQUEST["idgrilleprix"])) {
    $id = $_REQUEST["idgrilleprix"];
    $rslt = $con->query("select * from hp_grille_prix as p where "
            . "p.idgrilleprix='" . $id . "'") or die(mysqli_error($con));
    $row = mysqli_fetch_assoc($rslt);
// R�cup�ration du num�ro de l'�tape en cours
    if (empty($_GET['pagecom']) or ! is_numeric($_GET['pagecom'])) {
        define('NUM_PAGE', 1);
    } else {
        // En situation r�elle, il faudrait v�rifier l'existence de cette page
        define('NUM_PAGE', intval($_GET['pagecom']));
    }

// D�claration de la variable de session
    if (empty($_SESSION['formgrilleprixe'])) {
        $_SESSION['formgrilleprixe'] = array();
    }

    if (empty($_SESSION['formgrilleprixe'])) {
        $_SESSION['formgrilleprixe'] = array();
        $_SESSION['formgrilleprixe'][1] = array(
            'idgrilleprix' => $_GET["idgrilleprix"],
            'acte' => $row["idacte"],
            'designationpe' => $row["designationgrilleprix"],
            'typee' => $row["typegrilleprix"],
            'montant' => $row["montantgrilleprix"]
        );
    }


    switch (NUM_PAGE) {

        case 2:

            // R�cup�ration des informations du formulaire pr�c�dent
            if (!empty($_POST)) {

                $_SESSION['formgrilleprixe'][NUM_PAGE - 1] = array(
                    'idgrilleprix' => $_GET["idgrilleprix"],
                'acte' => (trim(htmlspecialchars($_POST["acte"]))),
                    'designationpe' => ucwords(trim(htmlspecialchars($_POST["designationpe"]))),
                    'typee' => ucwords(trim(htmlspecialchars($_POST["typee"]))),
                'montant' => (trim(htmlspecialchars($_POST["montant"])))
                );
            }
            require('./hopitalpages/hopitalparametre/hopitalgrilleprix/hopitalediter/form_terminer.php');
            break;

        case 1:
        default:
            // Valeurs par d�faut
            if (empty($_SESSION['formgrilleprixe'][NUM_PAGE])) {
                $_SESSION['formgrilleprixe'][NUM_PAGE] = array(
                    'idgrilleprix' => $_GET["idgrilleprix"],
            'acte' => $row["idacte"],
                    'designationpe' => $row["designationgrilleprix"],
                    'typee' => $row["typegrilleprix"],
            'montant' => $row["montantgrilleprix"]
                );
            } else if (($_SESSION['formgrilleprixe'][1]['idgrilleprix'] != $_GET["idgrilleprix"])) {
                $_SESSION['formgrilleprixe'][NUM_PAGE] = array(
                    'idgrilleprix' => $_GET["idgrilleprix"],
            'acte' => $row["idacte"],
                    'designationpe' => $row["designationgrilleprix"],
                    'typee' => $row["typegrilleprix"],
            'montant' => $row["montantgrilleprix"]
                );
            }
            require('hopitalpages/hopitalparametre/hopitalgrilleprix/hopitalediter/form_edit_grilleprix.php');
            break;
    }
}