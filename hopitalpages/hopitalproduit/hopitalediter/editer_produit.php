
<?php

if (isset($_REQUEST["produit"])) {
    $id = $_REQUEST["produit"];
    $rslt = $con->query("select * from hp_produit where idproduit='" . $id . "'") or die(mysqli_error($con));
    $row = mysqli_fetch_assoc($rslt);

// Récupération du numéro de l'étape en cours
    if (empty($_GET['pagecom']) or ! is_numeric($_GET['pagecom'])) {
        define('NUM_PAGE', 1);
    } else {
        // En situation réelle, il faudrait vérifier l'existence de cette page
        define('NUM_PAGE', intval($_GET['pagecom']));
    }

// Déclaration de la variable de session
    if (empty($_SESSION['formproduite'])) {
        $_SESSION['formproduite'] = array();
    }

    if (empty($_SESSION['formproduite'])) {
        $_SESSION['formproduite'] = array();
        $_SESSION['formproduite'][1] = array(
            'idproduit' => $_REQUEST["produit"],
            'codepe' => $row["codeproduit"],
            'cat' => $row["idcategorie"],
            'classe' => $row["idclassemedicamenteuse"],
            'dosage' => $row["iddosage"],
            'forme' => $row["idforme"],
            'conditionnement' => $row["idconditionnement"],
            'laboratoire' => $row["idlaboratoireproduit"],
            'valorisation' => $row["idvalorisationstock"],
            'desp' => $row["libelleproduit"],
            'qtes' => $row["stockproduit"],
            'qtemin' => $row["stockminproduit"],
            'qtemax' => $row["stockmaxproduit"],
            'prixa' => $row["prixachatproduit"],
            'unitea' => $row["uniteachatproduit"],
            'unitev' => $row["uniteventeproduit"],
            'unites' => $row["unitesortieproduit"],
            'imagepstring' => $row["imageproduit"],
            'imagep' => NULL,
            'datefab' => $row["datefabricationproduit"],
            'dateper' => $row["dateperemptionproduit"]
        );
    }


    switch (NUM_PAGE) {

        case 2:

            // Récupération des informations du formulaire précédent
            if (!empty($_POST)) {
                $erreurprod = FALSE;

                $imagep = $_SESSION['formproduite'][NUM_PAGE - 1]["imagep"];
                // Testons si le fichier a bien été envoyé et s'il n'y a pas d'erreur
                if (isset($_FILES['imagep']) AND $_FILES['imagep']['error'] == 0) {
                    // Testons si le fichier n'est pas trop gros
                    if ($_FILES['imagep']['size'] <= 2000000) {
                        // Testons si l'extension est autorisée
                        $infosfichier = pathinfo($_FILES['imagep']['name']);
                        $extension_upload = $infosfichier['extension'];
                        $extensions_autorisees = array('jpg', 'JPEG', 'png', 'PNG', 'jpeg', 'JPG');
                        if (in_array($extension_upload, $extensions_autorisees)) {
                            $imagep = $_FILES['imagep'];
                        } else {

                            $erreurprod = TRUE;
                            echo"<script language='javascript'>alert('extension image produit nom autorisée')</script>";
                        }
                    } else {

                        $erreurprod = TRUE;
                        echo"<script language='javascript'>alert('image produit trop grande')</script>";
                    }
                } else {
                    $imagep = "null";
                }
                $_SESSION['formproduite'][NUM_PAGE - 1] = array(
                    'idproduit' => $_REQUEST["produit"],
                    'codepe' => trim(htmlspecialchars($_POST["codepe"])),
                    'cat' => trim(htmlspecialchars($_POST["cat"])),
                    'classe' => trim(htmlspecialchars($_POST["classe"])),
                    'dosage' => trim(htmlspecialchars($_POST["dosage"])),
                    'forme' => trim(htmlspecialchars($_POST["forme"])),
                    'conditionnement' => trim(htmlspecialchars($_POST["conditionnement"])),
                    'laboratoire' => trim(htmlspecialchars($_POST["laboratoire"])),
                    'valorisation' => trim(htmlspecialchars($_POST["valorisation"])),
                    'desp' => trim(htmlspecialchars($_POST["desp"])),
                    'qtes' => trim(htmlspecialchars($_POST["qtes"])),
                    'qtemin' => trim(htmlspecialchars($_POST["qtemin"])),
                    'qtemax' => trim(htmlspecialchars($_POST["qtemax"])),
                    'prixa' => trim(htmlspecialchars($_POST["prixa"])),
                    'unitea' => trim(htmlspecialchars($_POST["unitea"])),
                    'unitev' => trim(htmlspecialchars($_POST["unitev"])),
                    'unites' => trim(htmlspecialchars($_POST["unites"])),
                    'datefab' => trim(htmlspecialchars($_POST["datefab"])),
                    'dateper' => trim(htmlspecialchars($_POST["dateper"])),
                    'imagepstring' => trim(htmlspecialchars($_POST["imagepstring"])),
                    'imagep' => $imagep
                );
            }

            if ((isset($erreurprod)) && ($erreurprod)) {
                $pag = 'hopitalpages/hopitalproduit/hopitalediter/editer_produit';
                $stag = 1;
                die('<meta http-equiv="refresh" content="4; URL=' . $url . '?page=' . base64_encode($pag) . '&produit=' . $id . '&pagecom=' . $stag . '">');
            } else {
                require('hopitalpages/hopitalproduit/hopitalediter/form_terminer.php');
                break;
            }

        case 1:
        default:
            // Valeurs par défaut
            if (empty($_SESSION['formproduite'][NUM_PAGE])) {

                $_SESSION['formproduite'][NUM_PAGE] = array(
                    'idproduit' => $_REQUEST["produit"],
                    'codepe' => $row["codeproduit"],
                    'cat' => $row["idcategorie"],
                    'classe' => $row["idclassemedicamenteuse"],
                    'dosage' => $row["iddosage"],
                    'forme' => $row["idforme"],
                    'conditionnement' => $row["idconditionnement"],
                    'laboratoire' => $row["idlaboratoireproduit"],
                    'valorisation' => $row["idvalorisationstock"],
                    'desp' => $row["libelleproduit"],
                    'qtes' => $row["stockproduit"],
                    'qtemin' => $row["stockminproduit"],
                    'qtemax' => $row["stockmaxproduit"],
                    'prixa' => $row["prixachatproduit"],
                    'unitea' => $row["uniteachatproduit"],
                    'unitev' => $row["uniteventeproduit"],
                    'unites' => $row["unitesortieproduit"],
                    'imagepstring' => $row["imageproduit"],
                    'imagep' => NULL,
                    'datefab' => $row["datefabricationproduit"],
                    'dateper' => $row["dateperemptionproduit"]
                );
            } else if (($_SESSION['formproduite'][NUM_PAGE]["idproduit"] != $_REQUEST["produit"])) {

                $_SESSION['formproduite'][NUM_PAGE] = array(
                    'idproduit' => $_REQUEST["produit"],
                    'codepe' => $row["codeproduit"],
                    'cat' => $row["idcategorie"],
                    'classe' => $row["idclassemedicamenteuse"],
                    'dosage' => $row["iddosage"],
                    'forme' => $row["idforme"],
                    'conditionnement' => $row["idconditionnement"],
                    'laboratoire' => $row["idlaboratoireproduit"],
                    'valorisation' => $row["idvalorisationstock"],
                    'desp' => $row["libelleproduit"],
                    'qtes' => $row["stockproduit"],
                    'qtemin' => $row["stockminproduit"],
                    'qtemax' => $row["stockmaxproduit"],
                    'prixa' => $row["prixachatproduit"],
                    'unitea' => $row["uniteachatproduit"],
                    'unitev' => $row["uniteventeproduit"],
                    'unites' => $row["unitesortieproduit"],
                    'imagepstring' => $row["imageproduit"],
                    'imagep' => NULL,
                    'datefab' => $row["datefabricationproduit"],
                    'dateper' => $row["dateperemptionproduit"]
                );
            }
            require('hopitalpages/hopitalproduit/hopitalediter/form_editer_produit.php');
            break;
    }
}