
<?php

if (isset($_REQUEST["idechographie"])) {
    $id = $_REQUEST["idechographie"];
    $rslt = $con->query("select * from hp_echographie as p where "
            . "p.idechographie='" . $id . "'") or die(mysqli_error($con));
    $row = mysqli_fetch_assoc($rslt);
// R�cup�ration du num�ro de l'�tape en cours
    if (empty($_GET['pagecom']) or ! is_numeric($_GET['pagecom'])) {
        define('NUM_PAGE', 1);
    } else {
        // En situation r�elle, il faudrait v�rifier l'existence de cette page
        define('NUM_PAGE', intval($_GET['pagecom']));
    }

// D�claration de la variable de session
    if (empty($_SESSION['formechographiee'])) {
        $_SESSION['formechographiee'] = array();
    }

    if (empty($_SESSION['formechographiee'])) {
        $_SESSION['formechographiee'] = array();
        $_SESSION['formechographiee'][1] = array(
            'idechographie' => $_GET["idechographie"],
            'service' => $row["idservice"],
            'codepe' => $row["codeechographie"],
            'echographiee' => $row["nomechographie"],
            'type' => $row["typeechographie"],
            'montant' => $row["prixechographie"],
            'resultat' => $row["resultatechographie"],
            'valmin' => $row["valeurminechographie"],
            'valmax' => $row["valeurmaxechographie"],
            'acte' => $row["idacte"]
        );
    }


    switch (NUM_PAGE) {

        case 2:

            // R�cup�ration des informations du formulaire pr�c�dent
            if (!empty($_POST)) {

                $_SESSION['formechographiee'][NUM_PAGE - 1] = array(
                    'idechographie' => $_GET["idechographie"],
                    'service' => strtoupper(trim(htmlspecialchars($_POST["service"]))),
                    'codepe' => strtoupper(trim(htmlspecialchars($_POST["codepe"]))),
                    'echographiee' => ucwords(trim(htmlspecialchars($_POST["echographiee"]))),
                    'type' => (trim(htmlspecialchars($_POST["type"]))),
                    'montant' => floatval(trim(htmlspecialchars($_POST["montant"]))),
                    'resultat' => (trim(htmlspecialchars($_POST["resultat"]))),
                    'valmin' => floatval(trim(htmlspecialchars($_POST["valmin"]))),
                    'valmax' => floatval(trim(htmlspecialchars($_POST["valmax"]))),
                    'acte' => floatval(trim(htmlspecialchars($_POST["acte"])))
                );
            }
            require('./hopitalpages/hopitalparametre/hopitalechographie/hopitalediter/form_terminer.php');
            break;

        case 1:
        default:
            // Valeurs par d�faut
            if (empty($_SESSION['formechographiee'][NUM_PAGE])) {
                $_SESSION['formechographiee'][NUM_PAGE] = array(
                    'idechographie' => $_GET["idechographie"],
                    'service' => $row["idservice"],
                    'codepe' => $row["codeechographie"],
                    'echographiee' => $row["nomechographie"],
                    'type' => $row["typeechographie"],
                    'montant' => $row["prixechographie"],
                    'resultat' => $row["resultatechographie"],
                    'valmin' => $row["valeurminechographie"],
                    'valmax' => $row["valeurmaxechographie"],
                    'acte' => $row["idacte"]
                );
            } else if (($_SESSION['formechographiee'][1]['idechographie'] != $_GET["idechographie"])) {
                $_SESSION['formechographiee'][NUM_PAGE] = array(
                    'idechographie' => $_GET["idechographie"],
                    'service' => $row["idservice"],
                    'codepe' => $row["codeechographie"],
                    'echographiee' => $row["nomechographie"],
                    'type' => $row["typeechographie"],
                    'montant' => $row["prixechographie"],
                    'resultat' => $row["resultatechographie"],
                    'valmin' => $row["valeurminechographie"],
                    'valmax' => $row["valeurmaxechographie"],
                    'acte' => $row["idacte"]
                );
            }
            require('hopitalpages/hopitalparametre/hopitalechographie/hopitalediter/form_edit_echographie.php');
            break;
    }
}