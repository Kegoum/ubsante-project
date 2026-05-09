
<?php

if (isset($_REQUEST["produit"])) {
    $id = $_REQUEST["produit"];
    $rslt = $con->query("select * from hotel_article as a left join hotel_categorie as c "
            . "on a.id_categorie=c.id_categorie left join hotel_fourniture as f on "
            . "a.id_fourniture=f.id_fourniture where a.id_article='" . $id . "'") or die(mysqli_error($con));
    $row = mysqli_fetch_assoc($rslt);
    
// Récupération du numéro de l'étape en cours
    if (empty($_GET['pagecom']) or ! is_numeric($_GET['pagecom'])) {
        define('NUM_PAGE', 1);
    } else {
        // En situation réelle, il faudrait vérifier l'existence de cette page
        define('NUM_PAGE', intval($_GET['pagecom']));
    }

// Déclaration de la variable de session
    if (empty($_SESSION['formprode'])) {
        $_SESSION['formprode'] = array();
    }

    if (empty($_SESSION['formprode'])) {
        $_SESSION['formprode'] = array();
        $_SESSION['formprode'][1] = array(
            'idarticle' => $_REQUEST["produit"],
            'codep' => $row["code_article"],
            'four' => $row["id_fourniture"],
            'cat' => $row["id_categorie"],
            'desp' => $row["libelle_article"],
            'imagepstring' => $row["image_article"],
                'imagep' => NULL
        );
    }


switch (NUM_PAGE) {

    case 2:

        // Récupération des informations du formulaire précédent
        if (!empty($_POST)) {
            $erreurprod = FALSE;
            
            $imagep = $_SESSION['formprode'][NUM_PAGE - 1]["imagep"];
            // Testons si le fichier a bien été envoyé et s'il n'y a pas d'erreur
            if (isset($_FILES['imagep']) AND $_FILES['imagep']['error'] == 0) {
                // Testons si le fichier n'est pas trop gros
                if ($_FILES['imagep']['size'] <= 2000000) {
                    // Testons si l'extension est autorisée
                    $infosfichier = pathinfo($_FILES['imagep']['name']);
                    $extension_upload = $infosfichier['extension'];
                    $extensions_autorisees = array('jpg', 'JPEG', 'png', 'PNG', 'jpeg', 'JPG');
                    if (in_array($extension_upload, $extensions_autorisees)) {
                        $imagep = $_FILES['imagep']['name'];

// on va vérifier que la nouvelle catégorie n'existe pas déja
                        if (!is_dir("hotelupload/images/")) {

// puis on créer les 2 dossiers, qui contiendront les originaux et les miniatures
// avec tous les droits ( écriture, lecture , suppression )
                            @mkdir("hotelupload/images/", 0777);
// on fait une vérification sur la création pour le retour à l'utilisateur
                            if (is_dir("hotelupload/images/")) {
// On peut valider le fichier et le stocker définitivement
                                move_uploaded_file($_FILES['imagep']['tmp_name'], "hotelupload/images/" . basename($_FILES['imagep']['name']));
                            } else {
                                echo "<p>Une erreur est survenu durant la cr&eacute;ation de votre cat&eacute;gorie </br> Veuillez contacter votre administrateur</p>";
                            }
                        } else {
// On peut valider le fichier et le stocker définitivement
                            move_uploaded_file($_FILES['imagep']['tmp_name'], "hotelupload/images/" . basename($_FILES['imagep']['name']));
                        }
                    } else {

                        $erreurprod = TRUE;
                        echo"<script language='javascript'>alert('extension image article nom autorisée')</script>";
                    }
                } else {

                    $erreurprod = TRUE;
                    echo"<script language='javascript'>alert('image article trop grande')</script>";
                }
            } else {
                $imagep = "null";
            }
            $_SESSION['formprode'][NUM_PAGE - 1] = array(
            'idarticle' => $_REQUEST["produit"],
                'codep' => trim(htmlspecialchars($_POST["codep"])),
                'four' => trim(htmlspecialchars($_POST["four"])),
                'cat' => trim(htmlspecialchars($_POST["cat"])),
                'desp' => trim(htmlspecialchars($_POST["desp"])),
                'imagepstring' => trim(htmlspecialchars($_POST["imagepstring"])),
                'imagep' => $imagep
            );
        }

        if ((isset($erreurprod)) && ($erreurprod)) {
            $pag = 'hotelpages/fourniturehotel/hotelediter/editer_produit';
            $stag = 1;
            if (isset($_SESSION["login_proprietaire"]) && (isset($_SESSION["mot_de_passe_proprietaire"]))) {
                die('<meta http-equiv="refresh" content="4; URL=indexadmin.php?page=' . base64_encode($pag) . '&pagecom=' . $stag . '&produit=' . $id . '">');
            } else if (isset($_SESSION["login_personnel"]) && (isset($_SESSION["mot_de_passe_personnel"])) && ($_SESSION["etat_compte_personnel"])) {
                if (($_SESSION["code_service"] == "ECONO")) {
                    die('<meta http-equiv="refresh" content="4; URL=indexpersonnel.php?page=' . base64_encode($pag) . '&pagecom=' . $stag . '&produit=' . $id . '">');
                }
            }
        } else {
            require('hotelpages/fourniturehotel/hotelediter/form_terminer.php');
            break;
        }

    case 1:
    default:
        // Valeurs par défaut
        if (empty($_SESSION['formprode'][NUM_PAGE])) {

            $_SESSION['formprode'][NUM_PAGE] = array(
            'idarticle' => $_REQUEST["produit"],
            'codep' => $row["code_article"],
            'four' => $row["id_fourniture"],
            'cat' => $row["id_categorie"],
            'desp' => $row["libelle_article"],
            'imagepstring' => $row["image_article"],
                'imagep' => NULL
            );
        }  else if (($_SESSION['formprode'][NUM_PAGE]["idarticle"] != $_REQUEST["produit"])) {
            $_SESSION['formprode'][NUM_PAGE] = array(
            'idarticle' => $_REQUEST["produit"],
            'codep' => $row["code_article"],
            'four' => $row["id_fourniture"],
            'cat' => $row["id_categorie"],
            'desp' => $row["libelle_article"],
            'imagepstring' => $row["image_article"],
                'imagep' => NULL
            );
        }
        require('hotelpages/fourniturehotel/hotelediter/form_editer_produit.php');
        break;
}
}