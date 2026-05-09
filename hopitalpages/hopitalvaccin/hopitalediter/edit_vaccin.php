
<?php

if (isset($_REQUEST["idvaccin"])) {
    $id = $_REQUEST["idvaccin"];
    $rslt = $con->query("select * from hp_vaccin as p where p.idvaccin='" . $id . "'") or die(mysqli_error($con));
    $row = mysqli_fetch_assoc($rslt);

    // R�cup�ration du num�ro de l'�tape en cours
    if (empty($_GET['pagecom']) or ! is_numeric($_GET['pagecom'])) {
        define('NUM_PAGE', 1);
    } else {
        // En situation r�elle, il faudrait v�rifier l'existence de cette page
        define('NUM_PAGE', intval($_GET['pagecom']));
    }

// D�claration de la variable de session
    if (empty($_SESSION['formvaccine'])) {
        $_SESSION['formvaccine'] = array();
    }

    if (empty($_SESSION['formvaccine'])) {
        $_SESSION['formvaccine'] = array();
        $_SESSION['formvaccine'][1] = array(
            'idvaccin' => $_GET["idvaccin"],
                'sexe' => $row["sexevaccin"],
                'nom' => $row["nomvaccin"],
                'datenais' => $row["datenaissancevaccin"],
                'quartier' => $row["quartiervaccin"],
                'nomparent' => $row["nomparentvaccin"],
                'telc' => $row["contactvaccin"]
        );
    }


    switch (NUM_PAGE) {

        case 2:
            // Récupération des informations du formulaire précédent
            if (!empty($_POST)) {
                $erreurprod = FALSE;

                $_SESSION['formvaccine'][NUM_PAGE - 1] = array(
                    'idvaccin' => $_GET["idvaccin"],
                'sexe' => (trim(htmlspecialchars($_POST["sexe"]))),
                'nom' => trim(htmlspecialchars($_POST["nom"])),
                'datenais' => (trim(htmlspecialchars($_POST["datenais"]))),
                'quartier' => trim(htmlspecialchars($_POST["quartier"])),
                'nomparent' => trim(htmlspecialchars($_POST["nomparent"])),
                'telc' => trim(htmlspecialchars($_POST["telc"]))
                );

            }
            if ((isset($erreurprod)) && ($erreurprod)) {
                $pag = 'hopitalpages/hopitalvaccin/hopitalediter/ajout_vaccin';
                $stag = 1;
                die('<meta http-equiv="refresh" content="0; URL=' . $url . '?page=' . base64_encode($pag) . '&idvaccin=' . $_GET["idvaccin"] . '">');
            } else {
                require('hopitalpages/hopitalvaccin/hopitalediter/form_terminer.php');
                break;
            }

        case 1:
        default:
            // Valeurs par défaut
            if (empty($_SESSION['formvaccine'][NUM_PAGE])) {

                $_SESSION['formvaccine'][NUM_PAGE] = array(
                    'idvaccin' => $_GET["idvaccin"],
                'sexe' => $row["sexevaccin"],
                'nom' => $row["nomvaccin"],
                'datenais' => $row["datenaissancevaccin"],
                'quartier' => $row["quartiervaccin"],
                'nomparent' => $row["nomparentvaccin"],
                'telc' => $row["contactvaccin"]
                );
            } else if (($_SESSION['formvaccine'][NUM_PAGE]["idvaccin"])!=$_GET["idvaccin"]) {

                $_SESSION['formvaccine'][NUM_PAGE] = array(
                    'idvaccin' => $_GET["idvaccin"],
                'sexe' => $row["sexevaccin"],
                'nom' => $row["nomvaccin"],
                'datenais' => $row["datenaissancevaccin"],
                'quartier' => $row["quartiervaccin"],
                'nomparent' => $row["nomparentvaccin"],
                'telc' => $row["contactvaccin"]
                );
            }
            require('hopitalpages/hopitalvaccin/hopitalediter/form_edit_vaccin.php');
            break;
    }
}