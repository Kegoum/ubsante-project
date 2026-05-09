
<div id="ModalAddProduct" class="modal modal-edu-general default-popup-PrimaryModal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header header-color-modal bg-color-1">
                <h4 class="modal-title">Formulaire d'Ajout d'un Produit</h4>
                <div class="modal-close-area modal-close-df">
                    <a class="close" data-dismiss="modal" href="#"><i class="fa fa-close"></i></a>
                </div>
            </div>
            <div class="modal-body">
                <?php
// Récupération du numéro de l'étape en cours
                if (empty($_GET['pagecom']) or ! is_numeric($_GET['pagecom'])) {
                    define('NUM_PAGE', 1);
                } else {
                    // En situation réelle, il faudrait vérifier l'existence de cette page
                    define('NUM_PAGE', intval($_GET['pagecom']));
                }

// Déclaration de la variable de session
                if (empty($_SESSION['formprod'])) {
                    $_SESSION['formprod'] = array();
                }

                switch (NUM_PAGE) {

                    case 2:

                        // Récupération des informations du formulaire précédent
                        if (!empty($_POST)) {
                            $erreurprod = FALSE;

                            $imagep = $_SESSION['formprod'][NUM_PAGE - 1]["imagep"];
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
                                        if (!is_dir("hopitalupload/images/")) {

// puis on créer les 2 dossiers, qui contiendront les originaux et les miniatures
// avec tous les droits ( écriture, lecture , suppression )
                                            @mkdir("hopitalupload/images/", 0777);
// on fait une vérification sur la création pour le retour à l'utilisateur
                                            if (is_dir("hopitalupload/images/")) {
// On peut valider le fichier et le stocker définitivement
                                                move_uploaded_file($_FILES['imagep']['tmp_name'], "hopitalupload/images/" . basename($_FILES['imagep']['name']));
                                            } else {
                                                echo "<p>Une erreur est survenu durant la cr&eacute;ation de votre cat&eacute;gorie </br> Veuillez contacter votre administrateur</p>";
                                            }
                                        } else {
// On peut valider le fichier et le stocker définitivement
                                            move_uploaded_file($_FILES['imagep']['tmp_name'], "hopitalupload/images/" . basename($_FILES['imagep']['name']));
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
                            $_SESSION['formprod'][NUM_PAGE - 1] = array(
                                'codep' => trim(htmlspecialchars($_POST["codep"])),
                                'cat' => trim(htmlspecialchars($_POST["cat"])),
                                'desp' => trim(htmlspecialchars($_POST["desp"])),
                                'qtemin' => trim(htmlspecialchars($_POST["qtemin"])),
                                'qtemax' => trim(htmlspecialchars($_POST["qtemax"])),
                                'prixa' => trim(htmlspecialchars($_POST["prixa"])),
                                'unitea' => trim(htmlspecialchars($_POST["unitea"])),
                                'unitev' => trim(htmlspecialchars($_POST["unitev"])),
                                'unites' => trim(htmlspecialchars($_POST["unites"])),
                                'imagep' => $imagep
                            );
                        }

                        if ((isset($erreurprod)) && ($erreurprod)) {
                            $pag = 'hopitalpages/hopitalmagasin/hopitalboncommande/hopitalajouter/ajouter_produit';
                            $stag = 1;
                            die('<meta http-equiv="refresh" content="4; URL=' . $url . '?page=' . base64_encode($pag) . '&pagecom=' . $stag . '">');
                        } else {
                            require('hopitalpages/hopitalmagasin/hopitalboncommande/hopitalajouter/form_terminer.php');
                            break;
                        }

                    case 1:
                    default:
                        // Valeurs par défaut
                        if (empty($_SESSION['formprod'][NUM_PAGE])) {

                            $_SESSION['formprod'][NUM_PAGE] = array(
                                'codep' => '',
                                'cat' => '',
                                'desp' => '',
                                'qtemin' => '',
                                'qtemax' => '',
                                'prixa' => '',
                                'unitea' => '',
                                'unitev' => '',
                                'unites' => '',
                                'imagep' => NULL
                            );
                        }
                        require('hopitalpages/hopitalmagasin/hopitalboncommande/hopitalajouter/form_ajouter_produit.php');
                        break;
                }
                ?>
            </div>
            <div class="modal-footer">
                <a data-dismiss="modal" href="#">Cancel</a>
            </div>
        </div>
    </div>
</div>