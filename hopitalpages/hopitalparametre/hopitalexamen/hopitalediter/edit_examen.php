
<?php

if (isset($_REQUEST["idexamen"])) {
    $id = $_REQUEST["idexamen"];
    $rslt = $con->query("select * from hp_examen as p where "
            . "p.idexamen='" . $id . "'") or die(mysqli_error($con));
    $row = mysqli_fetch_assoc($rslt);
// R�cup�ration du num�ro de l'�tape en cours
    if (empty($_GET['pagecom']) or ! is_numeric($_GET['pagecom'])) {
        define('NUM_PAGE', 1);
    } else {
        // En situation r�elle, il faudrait v�rifier l'existence de cette page
        define('NUM_PAGE', intval($_GET['pagecom']));
    }

// D�claration de la variable de session
    if (empty($_SESSION['formexamene'])) {
        $_SESSION['formexamene'] = array();
    }

    if (empty($_SESSION['formexamene'])) {
        $_SESSION['formexamene'] = array();
        $_SESSION['formexamene'][1] = array(
            'idexamen' => $_GET["idexamen"],
            'laboratoire' => $row["idlaboratoire"],
            'codepe' => $row["codeexamen"],
            'examene' => $row["nomexamen"],
            'type' => $row["typeexamen"],
            'montant' => $row["prixexamen"],
            'resultat' => $row["resultatexamen"],
            'valmin' => $row["valeurminexamen"],
            'valmax' => $row["valeurmaxexamen"],
            'unite' => $row["idunite"]
        );
    }


    switch (NUM_PAGE) {

        case 2:

            // R�cup�ration des informations du formulaire pr�c�dent
            if (!empty($_POST)) {

                $_SESSION['formexamene'][NUM_PAGE - 1] = array(
                    'idexamen' => $_GET["idexamen"],
                    'laboratoire' => strtoupper(trim(htmlspecialchars($_POST["laboratoire"]))),
                    'codepe' => strtoupper(trim(htmlspecialchars($_POST["codepe"]))),
                    'examene' => ucwords(trim(htmlspecialchars($_POST["examene"]))),
                    'type' => (trim(htmlspecialchars($_POST["type"]))),
                    'montant' => floatval(trim(htmlspecialchars($_POST["montant"]))),
                    'resultat' => (trim(htmlspecialchars($_POST["resultat"]))),
                    'valmin' => floatval(trim(htmlspecialchars($_POST["valmin"]))),
                    'valmax' => floatval(trim(htmlspecialchars($_POST["valmax"]))),
                    'unite' => floatval(trim(htmlspecialchars($_POST["unite"])))
                );
            }
            require('./hopitalpages/hopitalparametre/hopitalexamen/hopitalediter/form_terminer.php');
            break;

        case 1:
        default:
            // Valeurs par d�faut
            if (empty($_SESSION['formexamene'][NUM_PAGE])) {
                $_SESSION['formexamene'][NUM_PAGE] = array(
                    'idexamen' => $_GET["idexamen"],
                    'laboratoire' => $row["idlaboratoire"],
                    'codepe' => $row["codeexamen"],
                    'examene' => $row["nomexamen"],
                    'type' => $row["typeexamen"],
                    'montant' => $row["prixexamen"],
                    'resultat' => $row["resultatexamen"],
                    'valmin' => $row["valeurminexamen"],
                    'valmax' => $row["valeurmaxexamen"],
                    'unite' => $row["idunite"]
                );
            } else if (($_SESSION['formexamene'][1]['idexamen'] != $_GET["idexamen"])) {
                $_SESSION['formexamene'][NUM_PAGE] = array(
                    'idexamen' => $_GET["idexamen"],
                    'laboratoire' => $row["idlaboratoire"],
                    'codepe' => $row["codeexamen"],
                    'examene' => $row["nomexamen"],
                    'type' => $row["typeexamen"],
                    'montant' => $row["prixexamen"],
                    'resultat' => $row["resultatexamen"],
                    'valmin' => $row["valeurminexamen"],
                    'valmax' => $row["valeurmaxexamen"],
                    'unite' => $row["idunite"]
                );
            }
            require('hopitalpages/hopitalparametre/hopitalexamen/hopitalediter/form_edit_examen.php');
            break;
    }
}