
<?php

if (isset($_REQUEST["idfinance"])) {
    $id = $_REQUEST["idfinance"];
   $req_fin = $con->query("select * from smsfinance as f left join smsetudiant as e on f.idetudiant=e.idetudiant where "
            . "f.idfinance='" . $id . "'") or die(mysqli_error($con));
    $row = mysqli_fetch_assoc($req_fin);
    $versement = $row["versement1"] + $row["versement2"] + $row["versement3"] + $row["versement4"];
    
// R�cup�ration du num�ro de l'�tape en cours
    if (empty($_GET['pagecom']) or ! is_numeric($_GET['pagecom'])) {
        define('NUM_PAGE', 1);
    } else {
        // En situation r�elle, il faudrait v�rifier l'existence de cette page
        define('NUM_PAGE', intval($_GET['pagecom']));
    }

// D�claration de la variable de session
    if (empty($_SESSION['formfinancee'])) {
        $_SESSION['formfinancee'] = array();
    }

    if (empty($_SESSION['formfinancee'])) {
        $_SESSION['formfinancee'] = array();
        $_SESSION['formfinancee'][1] = array(
            'idfinance' => $_GET["idfinance"],
                'nom' => $row["nom"],
                'prenom' => $row["prenom"],
                'photostring' => $row["photo"],
                'datenais' => $row["datenais"],
                'lieunais' => $row["lieunais"],
                'regor' => $row["regionor"],
                'depor' => $row["departementor"],
                'sexe' => $row["sexe"],
                'quarthab' => $row["quartierhab"],
                'tel' => $row["telfinance"],
                'photo' => NULL
        );
    }


switch (NUM_PAGE) {

    case 2:
        // Récupération des informations du formulaire précédent
        if (!empty($_POST)) {
            $erreurprod = FALSE;
            $log = $_SESSION['formfinance'][NUM_PAGE - 1]["photo"];
            // Testons si le fichier a bien été envoyé et s'il n'y a pas d'erreur
            if (isset($_FILES['photo']) AND $_FILES['photo']['error'] == 0) {
                // Testons si le fichier n'est pas trop gros
                if ($_FILES['photo']['size'] <= 2000000) {
                    // Testons si l'extension est autorisée
                    $infosfichier = pathinfo($_FILES['photo']['name']);
                    $extension_upload = $infosfichier['extension'];
                    $extensions_autorisees = array('jpg', 'JPEG', 'png', 'PNG', 'jpeg', 'JPG');
                    if (in_array($extension_upload, $extensions_autorisees)) {
                        $log = $_FILES['photo'];
                        $erreurprod = FALSE;
                    } else {

                        $erreurprod = TRUE;
                        echo"<script language='javascript'>alert('extension photo non autorisée')</script>";
                    }
                } else {

                    $erreurprod = TRUE;
                    echo"<script language='javascript'>alert('photo trop grande')</script>";
                }
            } else {
                $log = NULL;
                $erreurprod = FALSE;
            }
            $_SESSION['formfinancee'][NUM_PAGE - 1] = array(
            'idfinance' => $_GET["idfinance"],
                'nom' => trim(htmlspecialchars($_POST["nom"])),
                'prenom' => trim(htmlspecialchars($_POST["prenom"])),
                'datenais' => trim(htmlspecialchars($_POST["datenais"])),
                'lieunais' => trim(htmlspecialchars($_POST["lieunais"])),
                'regor' => trim(htmlspecialchars($_POST["regor"])),
                'depor' => trim(htmlspecialchars($_POST["depor"])),
                'sexe' => trim(htmlspecialchars($_POST["sexe"])),
                'quarthab' => trim(htmlspecialchars($_POST["quarthab"])),
                'tel' => trim(htmlspecialchars($_POST["tel"])),
                'photostring' => trim(htmlspecialchars($_POST["photostring"])),
                'photo' => $log
            );
        }
        if ((isset($erreurprod)) && ($erreurprod)) {
            $pag = 'issampages/issamfinance/issamediter/edit_finance';
            $stag = 1;
            die('<meta http-equiv="refresh" content="0; URL='.$url.'?page=' . base64_encode($pag) . '&pagecom=' . $stag . '">');
            
        } else {
        require('issampages/issamfinance/issamediter/form_terminer.php');
        break;
        }

    case 1:
    default:
        // Valeurs par défaut
        if (empty($_SESSION['formfinancee'][NUM_PAGE])) {

            $_SESSION['formfinancee'][NUM_PAGE] = array(
            'idfinance' => $_GET["idfinance"],
                'nom' => $row["nom"],
                'prenom' => $row["prenom"],
                'photostring' => $row["photo"],
                'datenais' => $row["datenais"],
                'lieunais' => $row["lieunais"],
                'regor' => $row["regionor"],
                'depor' => $row["departementor"],
                'sexe' => $row["sexe"],
                'quarthab' => $row["quartierhab"],
                'tel' => $row["telfinance"],
                'photo' => NULL
            );
        } else if (($_SESSION['formfinancee'][NUM_PAGE]["idfinance"]!=$_REQUEST["idfinance"])) {

            $_SESSION['formfinancee'][NUM_PAGE] = array(
            'idfinance' => $_GET["idfinance"],
                'nom' => $row["nom"],
                'prenom' => $row["prenom"],
                'photostring' => $row["photo"],
                'datenais' => $row["datenais"],
                'lieunais' => $row["lieunais"],
                'regor' => $row["regionor"],
                'depor' => $row["departementor"],
                'sexe' => $row["sexe"],
                'quarthab' => $row["quartierhab"],
                'tel' => $row["telfinance"],
                'photo' => NULL
            );
        }
        require('issampages/issamfinance/issamediter/form_edit_finance.php');
        break;
}
}