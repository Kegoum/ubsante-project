
<?php

if (isset($_REQUEST["idproprietaire"])) {
    $id = $_REQUEST["idproprietaire"];
    $rslt = $con->query("select * from hp_proprietaire as p where p.idproprietaire='" . $id . "'") or die(mysqli_error($con));
    $row = mysqli_fetch_assoc($rslt);
// R�cup�ration du num�ro de l'�tape en cours
    if (empty($_GET['pagecom']) or ! is_numeric($_GET['pagecom'])) {
        define('NUM_PAGE', 1);
    } else {
        // En situation r�elle, il faudrait v�rifier l'existence de cette page
        define('NUM_PAGE', intval($_GET['pagecom']));
    }

// D�claration de la variable de session
    if (empty($_SESSION['formproprietaireep'])) {
        $_SESSION['formproprietaireep'] = array();
    }

    if (empty($_SESSION['formproprietaireep'])) {
        $_SESSION['formproprietaireep'] = array();
        $_SESSION['formproprietaireep'][1] = array(
            'idproprietaire' => $_GET["idproprietaire"],
            'iddepartement' => $row["iddepartement"],
            'hopital' => $row["hopitalproprietaire"],
            'arrondissement' => $row["arrondissementproprietaire"],
            'district' => $row["districtproprietaire"],
            'airesante' => $row["airesanteproprietaire"],
            'nome' => $row["nomproprietaire"],
            'typee' => $row["typeproprietaire"],
            'photostring' => $row["logoproprietaire"],
            'photoe' => NULL,
            'emaile' => $row["emailproprietaire"],
            'tele' => $row["telephoneproprietaire"],
            'bp' => $row["bpproprietaire"],
            'site' => $row["siteproprietaire"],
            'logine' => $row["loginproprietaire"],
            'motdepasse' => '',
            'motdepasse2' => '',
            'datecreation' => $row["datecreationproprietaire"],
            'slogan' => $row["sloganproprietaire"],
            'nocontribuable' => $row["nocontribuableproprietaire"],
            'texte' => $row["textehopital"],
            'adresse' => $row["adressehopital"],
            'filigranea5pa' => $row["filigranea5p"],
            'filigranea5pn' => NULL,
            'filigranea5la' => $row["filigranea5l"],
            'filigranea5ln' => NULL,
            'filigranea4pa' => $row["filigranea4p"],
            'filigranea4pn' => NULL,
            'filigranea4la' => $row["filigranea4l"],
            'filigranea4ln' => NULL
        );
    }


    switch (NUM_PAGE) {

        case 2:
            // Récupération des informations du formulaire précédent
            if (!empty($_POST)) {
                $erreurprod = FALSE;
                $log = $_SESSION['formproprietaireep'][NUM_PAGE - 1]["photoe"];
                $fila5p = $_SESSION['formproprietaireep'][NUM_PAGE - 1]["filigranea5pn"];
                $fila5l = $_SESSION['formproprietaireep'][NUM_PAGE - 1]["filigranea5ln"];
                $fila4p = $_SESSION['formproprietaireep'][NUM_PAGE - 1]["filigranea4pn"];
                $fila4l = $_SESSION['formproprietaireep'][NUM_PAGE - 1]["filigranea4ln"];
                // Testons si le fichier a bien été envoyé et s'il n'y a pas d'erreur
                if (isset($_FILES['photoe']) AND $_FILES['photoe']['error'] == 0) {
                    // Testons si le fichier n'est pas trop gros
                    if ($_FILES['photoe']['size'] <= 2000000) {
                        // Testons si l'extension est autorisée
                        $infosfichier = pathinfo($_FILES['photoe']['name']);
                        $extension_upload = $infosfichier['extension'];
                        $extensions_autorisees = array('jpg', 'JPEG', 'png', 'PNG', 'jpeg', 'JPG');
                        if (in_array($extension_upload, $extensions_autorisees)) {
                            $log = $_FILES['photoe'];
                            $erreurprod = FALSE;
                        } else {

                            $erreurprod = TRUE;
                            echo"<script language='javascript'>alert('extension photo nom autorisée')</script>";
                        }
                    } else {

                        $erreurprod = TRUE;
                        echo"<script language='javascript'>alert('photo trop grande')</script>";
                    }
                } else {
                    $log = NULL;
                    $erreurprod = FALSE;
                }
                if (isset($_FILES['filigranea5pn']) AND $_FILES['filigranea5pn']['error'] == 0) {
                    // Testons si le fichier n'est pas trop gros
                    if ($_FILES['filigranea5pn']['size'] <= 2000000) {
                        // Testons si l'extension est autorisée
                        $infosfichier = pathinfo($_FILES['filigranea5pn']['name']);
                        $extension_upload = $infosfichier['extension'];
                        $extensions_autorisees = array('jpg', 'JPEG', 'png', 'PNG', 'jpeg', 'JPG');
                        if (in_array($extension_upload, $extensions_autorisees)) {
                            $fila5p = $_FILES['filigranea5pn'];
                            $erreurprod = FALSE;
                        } else {

                            $erreurprod = TRUE;
                            echo"<script language='javascript'>alert('extension photo nom autorisée')</script>";
                        }
                    } else {

                        $erreurprod = TRUE;
                        echo"<script language='javascript'>alert('photo trop grande')</script>";
                    }
                } else {
                    $fila5p = NULL;
                    $erreurprod = FALSE;
                }
                if (isset($_FILES['filigranea5ln']) AND $_FILES['filigranea5ln']['error'] == 0) {
                    // Testons si le fichier n'est pas trop gros
                    if ($_FILES['filigranea5ln']['size'] <= 2000000) {
                        // Testons si l'extension est autorisée
                        $infosfichier = pathinfo($_FILES['filigranea5ln']['name']);
                        $extension_upload = $infosfichier['extension'];
                        $extensions_autorisees = array('jpg', 'JPEG', 'png', 'PNG', 'jpeg', 'JPG');
                        if (in_array($extension_upload, $extensions_autorisees)) {
                            $fila5l = $_FILES['filigranea5ln'];
                            $erreurprod = FALSE;
                        } else {

                            $erreurprod = TRUE;
                            echo"<script language='javascript'>alert('extension photo nom autorisée')</script>";
                        }
                    } else {

                        $erreurprod = TRUE;
                        echo"<script language='javascript'>alert('photo trop grande')</script>";
                    }
                } else {
                    $fila5l = NULL;
                    $erreurprod = FALSE;
                }
                if (isset($_FILES['filigranea4pn']) AND $_FILES['filigranea4pn']['error'] == 0) {
                    // Testons si le fichier n'est pas trop gros
                    if ($_FILES['filigranea4pn']['size'] <= 2000000) {
                        // Testons si l'extension est autorisée
                        $infosfichier = pathinfo($_FILES['filigranea4pn']['name']);
                        $extension_upload = $infosfichier['extension'];
                        $extensions_autorisees = array('jpg', 'JPEG', 'png', 'PNG', 'jpeg', 'JPG');
                        if (in_array($extension_upload, $extensions_autorisees)) {
                            $fila4p = $_FILES['filigranea4pn'];
                            $erreurprod = FALSE;
                        } else {

                            $erreurprod = TRUE;
                            echo"<script language='javascript'>alert('extension photo nom autorisée')</script>";
                        }
                    } else {

                        $erreurprod = TRUE;
                        echo"<script language='javascript'>alert('photo trop grande')</script>";
                    }
                } else {
                    $fila4p = NULL;
                    $erreurprod = FALSE;
                }
                if (isset($_FILES['filigranea4ln']) AND $_FILES['filigranea4ln']['error'] == 0) {
                    // Testons si le fichier n'est pas trop gros
                    if ($_FILES['filigranea4ln']['size'] <= 2000000) {
                        // Testons si l'extension est autorisée
                        $infosfichier = pathinfo($_FILES['filigranea4ln']['name']);
                        $extension_upload = $infosfichier['extension'];
                        $extensions_autorisees = array('jpg', 'JPEG', 'png', 'PNG', 'jpeg', 'JPG');
                        if (in_array($extension_upload, $extensions_autorisees)) {
                            $fila4l = $_FILES['filigranea4ln'];
                            $erreurprod = FALSE;
                        } else {

                            $erreurprod = TRUE;
                            echo"<script language='javascript'>alert('extension photo nom autorisée')</script>";
                        }
                    } else {

                        $erreurprod = TRUE;
                        echo"<script language='javascript'>alert('photo trop grande')</script>";
                    }
                } else {
                    $fila4l = NULL;
                    $erreurprod = FALSE;
                }
                $_SESSION['formproprietaireep'][NUM_PAGE - 1] = array(
                    'idproprietaire' => $_GET["idproprietaire"],
                    'iddepartement' => trim(htmlspecialchars($_POST["iddepartement"])),
                    'hopital' => trim(htmlspecialchars($_POST["hopital"])),
                    'arrondissement' => trim(htmlspecialchars($_POST["arrondissement"])),
                    'district' => trim(htmlspecialchars($_POST["district"])),
                    'airesante' => trim(htmlspecialchars($_POST["airesante"])),
                    'nome' => trim(htmlspecialchars($_POST["nome"])),
                    'typee' => trim(htmlspecialchars($_POST["typee"])),
                    'photostring' => trim(htmlspecialchars($_POST["photostring"])),
                    'photoe' => $log,
                    'tele' => trim(htmlspecialchars($_POST["tele"])),
                    'bp' => trim(htmlspecialchars($_POST["bp"])),
                    'emaile' => trim(htmlspecialchars($_POST["emaile"])),
                    'site' => trim(htmlspecialchars($_POST["site"])),
                    'logine' => trim(htmlspecialchars($_POST["logine"])),
                    'motdepasse' => trim(htmlspecialchars($_POST["motdepasse"])),
                    'motdepasse2' => trim(htmlspecialchars($_POST["motdepasse2"])),
                    'datecreation' => trim(htmlspecialchars($_POST["datecreation"])),
                    'slogan' => trim(htmlspecialchars($_POST["slogan"])),
                    'nocontribuable' => trim(htmlspecialchars($_POST["nocontribuable"])),
                    'texte' => trim(htmlspecialchars($_POST["texte"])),
                    'adresse' => trim(htmlspecialchars($_POST["adresse"])),
                    'filigranea5pa' => trim(htmlspecialchars($_POST["filigranea5pa"])),
                    'filigranea5pn' => $fila5p,
                    'filigranea5la' => trim(htmlspecialchars($_POST["filigranea5la"])),
                    'filigranea5ln' => $fila5l,
                    'filigranea4pa' => trim(htmlspecialchars($_POST["filigranea4pa"])),
                    'filigranea4pn' => $fila4p,
                    'filigranea4la' => trim(htmlspecialchars($_POST["filigranea4la"])),
                    'filigranea4ln' => $fila4l
                );
            }
            if ((isset($erreurprod)) && ($erreurprod)) {
                $pag = 'hopitalpages/hopitalproprietaire/hopitalediterprofil/edit_proprietaire';
                $stag = 1;
                die('<meta http-equiv="refresh" content="0; URL=' . $url . '?page=' . base64_encode($pag) . '&idproprietaire=' . $id . '">');
            } else {
                require('hopitalpages/hopitalproprietaire/hopitalediterprofil/form_terminer.php');
                break;
            }

        case 1:
        default:
            // Valeurs par défaut
            if (empty($_SESSION['formproprietaireep'][NUM_PAGE])) {

                $_SESSION['formproprietaireep'][NUM_PAGE] = array(
            'idproprietaire' => $_GET["idproprietaire"],
            'iddepartement' => $row["iddepartement"],
            'hopital' => $row["hopitalproprietaire"],
            'arrondissement' => $row["arrondissementproprietaire"],
            'district' => $row["districtproprietaire"],
            'airesante' => $row["airesanteproprietaire"],
            'nome' => $row["nomproprietaire"],
            'typee' => $row["typeproprietaire"],
            'photostring' => $row["logoproprietaire"],
            'photoe' => NULL,
            'emaile' => $row["emailproprietaire"],
            'tele' => $row["telephoneproprietaire"],
            'bp' => $row["bpproprietaire"],
            'site' => $row["siteproprietaire"],
            'logine' => $row["loginproprietaire"],
            'motdepasse' => '',
            'motdepasse2' => '',
            'datecreation' => $row["datecreationproprietaire"],
            'slogan' => $row["sloganproprietaire"],
            'nocontribuable' => $row["nocontribuableproprietaire"],
            'texte' => $row["textehopital"],
            'adresse' => $row["adressehopital"],
            'filigranea5pa' => $row["filigranea5p"],
            'filigranea5pn' => NULL,
            'filigranea5la' => $row["filigranea5l"],
            'filigranea5ln' => NULL,
            'filigranea4pa' => $row["filigranea4p"],
            'filigranea4pn' => NULL,
            'filigranea4la' => $row["filigranea4l"],
            'filigranea4ln' => NULL
                );
            } else if (($_SESSION['formproprietaireep'][NUM_PAGE]["idproprietaire"] != $_REQUEST["idproprietaire"])) {

                $_SESSION['formproprietaireep'][NUM_PAGE] = array(
            'idproprietaire' => $_GET["idproprietaire"],
            'iddepartement' => $row["iddepartement"],
            'hopital' => $row["hopitalproprietaire"],
            'arrondissement' => $row["arrondissementproprietaire"],
            'district' => $row["districtproprietaire"],
            'airesante' => $row["airesanteproprietaire"],
            'nome' => $row["nomproprietaire"],
            'typee' => $row["typeproprietaire"],
            'photostring' => $row["logoproprietaire"],
            'photoe' => NULL,
            'emaile' => $row["emailproprietaire"],
            'tele' => $row["telephoneproprietaire"],
            'bp' => $row["bpproprietaire"],
            'site' => $row["siteproprietaire"],
            'logine' => $row["loginproprietaire"],
            'motdepasse' => '',
            'motdepasse2' => '',
            'datecreation' => $row["datecreationproprietaire"],
            'slogan' => $row["sloganproprietaire"],
            'nocontribuable' => $row["nocontribuableproprietaire"],
            'texte' => $row["textehopital"],
            'adresse' => $row["adressehopital"],
            'filigranea5pa' => $row["filigranea5p"],
            'filigranea5pn' => NULL,
            'filigranea5la' => $row["filigranea5l"],
            'filigranea5ln' => NULL,
            'filigranea4pa' => $row["filigranea4p"],
            'filigranea4pn' => NULL,
            'filigranea4la' => $row["filigranea4l"],
            'filigranea4ln' => NULL
                );
            }
            require('hopitalpages/hopitalproprietaire/hopitalediterprofil/form_edit_proprietaire.php');
            break;
    }
}