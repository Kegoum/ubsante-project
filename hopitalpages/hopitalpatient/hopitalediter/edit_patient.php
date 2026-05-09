
<?php

if (isset($_REQUEST["idpatient"])) {
    $id = $_REQUEST["idpatient"];
    $rslt = $con->query("select * from hp_patient as p left join hp_departement as d on p.residencepatient=d.iddepartement "
            . "left join hp_region as r on d.idregion=r.idregion where p.idpatient='" . $id . "'") or die(mysqli_error($con));
    $row = mysqli_fetch_assoc($rslt);

    // R�cup�ration du num�ro de l'�tape en cours
    if (empty($_GET['pagecom']) or ! is_numeric($_GET['pagecom'])) {
        define('NUM_PAGE', 1);
    } else {
        // En situation r�elle, il faudrait v�rifier l'existence de cette page
        define('NUM_PAGE', intval($_GET['pagecom']));
    }

// D�claration de la variable de session
    if (empty($_SESSION['formpatiente'])) {
        $_SESSION['formpatiente'] = array();
    }

    if (empty($_SESSION['formpatiente'])) {
        $_SESSION['formpatiente'] = array();
        $_SESSION['formpatiente'][1] = array(
            'idpatient' => $_GET["idpatient"],
            'nom' => $row["nompatient"],
            'prenom' => $row["prenompatient"],
            'tel' => $row["telephonepatient"],
            'telc' => $row["telephonepacpatient"],
            'sexe' => $row["sexepatient"],
            'datenais' => $row["datenaissancepatient"],
            'lieunais' => $row["lieunaissancepatient"],
            'sitmat' => $row["situationmatrimonialepatient"],
            'profession' => $row["professionpatient"],
            'residence' => $row["residencepatient"]
        );
    }


    switch (NUM_PAGE) {

        case 2:
            // Récupération des informations du formulaire précédent
            if (!empty($_POST)) {
                $erreurprod = FALSE;

                $_SESSION['formpatiente'][NUM_PAGE - 1] = array(
                    'idpatient' => $_GET["idpatient"],
                    'nom' => trim(htmlspecialchars($_POST["nom"])),
                    'prenom' => trim(htmlspecialchars($_POST["prenom"])),
                    'tel' => trim(htmlspecialchars($_POST["tel"])),
                    'telc' => trim(htmlspecialchars($_POST["telc"])),
                    'sexe' => (trim(htmlspecialchars($_POST["sexe"]))),
                    'datenais' => (trim(htmlspecialchars($_POST["datenais"]))),
                    'lieunais' => (trim(htmlspecialchars($_POST["lieunais"]))),
                    'sitmat' => (trim(htmlspecialchars($_POST["sitmat"]))),
                    'profession' => (trim(htmlspecialchars($_POST["profession"]))),
                    'residence' => (trim(htmlspecialchars($_POST["residence"])))
                );

            }
            if ((isset($erreurprod)) && ($erreurprod)) {
                $pag = 'hopitalpages/hopitalpatient/hopitalediter/ajout_patient';
                $stag = 1;
                die('<meta http-equiv="refresh" content="0; URL=' . $url . '?page=' . base64_encode($pag) . '&idpatient=' . $_GET["idpatient"] . '">');
            } else {
                require('hopitalpages/hopitalpatient/hopitalediter/form_terminer.php');
                break;
            }

        case 1:
        default:
            // Valeurs par défaut
            if (empty($_SESSION['formpatiente'][NUM_PAGE])) {

                $_SESSION['formpatiente'][NUM_PAGE] = array(
                    'idpatient' => $_GET["idpatient"],
                    'nom' => $row["nompatient"],
                    'prenom' => $row["prenompatient"],
                    'tel' => $row["telephonepatient"],
            'telc' => $row["telephonepacpatient"],
                    'sexe' => $row["sexepatient"],
                    'datenais' => $row["datenaissancepatient"],
                    'lieunais' => $row["lieunaissancepatient"],
                    'sitmat' => $row["situationmatrimonialepatient"],
                    'profession' => $row["professionpatient"],
                    'residence' => $row["residencepatient"]
                );
            } else if (($_SESSION['formpatiente'][NUM_PAGE]["idpatient"])!=$_GET["idpatient"]) {

                $_SESSION['formpatiente'][NUM_PAGE] = array(
                    'idpatient' => $_GET["idpatient"],
                    'nom' => $row["nompatient"],
                    'prenom' => $row["prenompatient"],
                    'tel' => $row["telephonepatient"],
            'telc' => $row["telephonepacpatient"],
                    'sexe' => $row["sexepatient"],
                    'datenais' => $row["datenaissancepatient"],
                    'lieunais' => $row["lieunaissancepatient"],
                    'sitmat' => $row["situationmatrimonialepatient"],
                    'profession' => $row["professionpatient"],
                    'residence' => $row["residencepatient"]
                );
            }
            require('hopitalpages/hopitalpatient/hopitalediter/form_edit_patient.php');
            break;
    }
}