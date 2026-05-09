
<?php

$rslt = $con->query("select * from hp_proprietaire limit 0,1") or die(mysqli_error($con));
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
        'iddepartement' => $row["iddepartement"],
        'hopital' => $row["hopitalproprietaire"],
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
        'adresse' => $row["adressehopital"]
    );
}

switch (NUM_PAGE) {

    case 2:
        // Récupération des informations du formulaire précédent
        if (!empty($_POST)) {
            $erreurprod = FALSE;
            $log = $_SESSION['formproprietaireep'][NUM_PAGE - 1]["photoe"];
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

            $_SESSION['formproprietaireep'][NUM_PAGE - 1] = array(
                'iddepartement' => trim(htmlspecialchars($_POST["iddepartement"])),
                'hopital' => trim(htmlspecialchars($_POST["hopital"])),
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
                'adresse' => trim(htmlspecialchars($_POST["adresse"]))
            );
        }
        if ((isset($erreurprod)) && ($erreurprod)) {
            $pag = 'hopitalpages/hopitalparametre/hopitalproprietaire/edit_proprietaire';
            $stag = 1;
            die('<meta http-equiv="refresh" content="0; URL=' . $url . '?page=' . base64_encode($pag) . '&pagecom=' . $stag . '">');
        } else {
            require('hopitalpages/hopitalparametre/hopitalproprietaire/form_terminer.php');
            break;
        }

    case 1:
    default:
        // Valeurs par défaut
        if (empty($_SESSION['formproprietaireep'][NUM_PAGE])) {

            $_SESSION['formproprietaireep'][NUM_PAGE] = array(
                'iddepartement' => $row["iddepartement"],
                'hopital' => $row["hopitalproprietaire"],
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
                'adresse' => $row["adressehopital"]
            );
        }
        require('hopitalpages/hopitalparametre/hopitalproprietaire/form_edit_proprietaire.php');
        break;
}