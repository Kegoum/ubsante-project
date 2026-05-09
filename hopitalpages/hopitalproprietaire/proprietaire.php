<?php
$rslt = $con->query("select * from hp_proprietaire") or die(mysqli_error($con));
$row = NULL;
while ($row1 = mysqli_fetch_assoc($rslt)) {
    $row = $row1;
}
?>

<center>
    <h2>Param&egrave;tres de l'Hopital (Proprietaire)</h2>
</center>
<form action="#" method="post" enctype="multipart/form-data" name="edit_enseignant">
    <div class="row">
        <div class="col-sm-6 col-xs-12">
            <input type="hidden" name="id" value="<?php echo $row["idproprietaire"]; ?>"/>
            <label>NOM DE L'ETABLISSEMENT :</label>
            <input type="text" name="nom" onkeyup="this.value = this.value.toUpperCase();" id="nom" maxlength="254" placeholder="Ex: INSTITUT SUPERIEUR DES SCIENCES, ARTS ET METIERS" class="form-control" value="<?php echo $row["nomproprietaire"]; ?>" required/>
        </div>
        <div class="col-sm-6 col-xs-12">
            <label>NOM DE L'ETABLISSEMENT EN ANGLAIS :</label>
            <input type="text" name="noma" onkeyup="this.value = this.value.toUpperCase();" id="nom" maxlength="254" placeholder="Ex: INSTITUT SUPERIEUR DES SCIENCES, ARTS ET METIERS" class="form-control" value="<?php echo $row["nomproprietaireanglais"]; ?>" required/>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6 col-xs-12">
            <label>NOM DE L'ETABLISSEMENT 2 :</label>
            <input type="text" name="nomb" onkeyup="this.value = this.value.toUpperCase();" id="nom" maxlength="254" placeholder="Ex: INSTITUT SUPERIEUR DES SCIENCES, ARTS ET METIERS" class="form-control" value="<?php echo $row["nomproprietaireb"]; ?>"/>
        </div>
        <div class="col-sm-6 col-xs-12">
            <label>NOM DE L'ETABLISSEMENT 2 EN ANGLAIS :</label>
            <input type="text" name="nomba" onkeyup="this.value = this.value.toUpperCase();" id="nom" maxlength="254" placeholder="Ex: INSTITUT SUPERIEUR DES SCIENCES, ARTS ET METIERS" class="form-control" value="<?php echo $row["nomproprietairebanglais"]; ?>"/>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6 col-xs-12">
            <label>ACTIVITE :</label>
            <input type="text" name="textea" onkeyup="this.value = this.value.toUpperCase();"  maxlength="254" placeholder="Ex: ETABLISSEMENT PRIVE LAÏC D’ENSEIGNEMENT SUPERIEUR..." class="form-control" value="<?php echo $row["textea"]; ?>"/>
        </div>
        <div class="col-sm-6 col-xs-12">
            <label>ACTIVITE EN ANGLAIS :</label>
            <input type="text" name="texteaa" onkeyup="this.value = this.value.toUpperCase();"  maxlength="254" placeholder="Ex: ETABLISSEMENT PRIVE LAÏC D’ENSEIGNEMENT SUPERIEUR..." class="form-control" value="<?php echo $row["texteaanglais"]; ?>"/>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6 col-xs-12">
            <label>MINISTERE DE TUTELLE :</label>
            <input type="text" name="ministere" onkeyup="this.value = this.value.toUpperCase();" maxlength="254" placeholder="Ex: MINISTERE DE L'ENSEIGNEMENT SUPERIEUR" class="form-control" value="<?php echo $row["ministere"]; ?>" required/>
        </div>
        <div class="col-sm-6 col-xs-12">
            <label>MINISTERE DE TUTELLE EN ANGLAIS :</label>
            <input type="text" name="ministerea" onkeyup="this.value = this.value.toUpperCase();" maxlength="254" placeholder="Ex: MINISTERE DE L'ENSEIGNEMENT SUPERIEUR" class="form-control" value="<?php echo $row["ministereanglais"]; ?>" required/>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6 col-xs-12">
            <label>TUTELLE ACADEMIQUE :</label>
            <input type="text" name="tutelle" onkeyup="this.value = this.value.toUpperCase();" maxlength="254" placeholder="Ex: UNIVERSITE DE DOUALA" class="form-control" value="<?php echo $row["tutelle"]; ?>" required/>
        </div>
        <div class="col-sm-6 col-xs-12">
            <label>TUTELLE ACADEMIQUE EN ANGLAIS :</label>
            <input type="text" name="tutellea" onkeyup="this.value = this.value.toUpperCase();" maxlength="254" placeholder="Ex: UNIVERSITE DE DOUALA" class="form-control" value="<?php echo $row["tutelleanglais"]; ?>" required/>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6 col-xs-12">
            <label>AUTORISATION D’OUVERTURE :</label>
            <input type="text" name="texteb" onkeyup="this.value = this.value.toUpperCase();"  maxlength="254" placeholder="Ex: N° 17- 09553/L/MINESUP/SG/.............DU 22 SEPTEMBRE 2017" class="form-control" value="<?php echo $row["texteb"]; ?>"/>
        </div>
        <div class="col-sm-3 col-xs-6">
            <label>DEVISE :</label>
            <input type="text" name="devise" onkeyup="this.value = this.value.toLowerCase();" style="text-transform: capitalize;"  maxlength="254" placeholder="Ex: Paix - Travail - Patrie" class="form-control" value="<?php echo $row["devise"]; ?>"/>
        </div>
        <div class="col-sm-3 col-xs-6">
            <label>QUALITE DU DIRIGEANT :</label>
            <input type="text" name="typed"  maxlength="254" placeholder="Ex: Directeur, Secr�taire G�n�ral ...." class="form-control" value="<?php echo $row["typedirigeant"]; ?>" required/>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6 col-xs-12">
            <label>NON DU DIRIGEANT :</label>
            <input type="text" name="nomd" onkeyup="this.value = this.value.toLowerCase();" style="text-transform: capitalize;"  maxlength="254" placeholder="Ex: Nom et prenom..." class="form-control" value="<?php echo $row["nomdirigeant"]; ?>" required/>
        </div>
        <div class="col-sm-3 col-xs-6">
            <label>NOTE MODULABLE :</label>
            <input type="text" name="notemodulable" placeholder="Ex: 8 ...." class="form-control" value="<?php echo $row["notemodulable"]; ?>" required/>
        </div>
        <div class="col-sm-3 col-xs-6">
            <label>NOTE MINIMALE POUR VALIDER :</label>
            <input type="text" name="noteminvalide" placeholder="Ex: 10 ...." class="form-control" value="<?php echo $row["noteminvalide"]; ?>" required/>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6 col-xs-12">
            <label>BOITE POSTALE :</label>
            <input type="text" name="bp" maxlength="10" placeholder="Ex: 1234" class="form-control" value="<?php echo $row["bp"]; ?>"/>
        </div>
        <div class="col-sm-6 col-xs-12">
            <label>VILLE :</label>
            <input type="text" name="quartier" onkeyup="this.value = this.value.toLowerCase();" style="text-transform: capitalize;"  maxlength="254" placeholder="Ex: Yaound� " class="form-control" value="<?php echo $row["quartier"]; ?>"/>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6 col-xs-12">
            <label>ADRESSE :</label>
            <input type="text" name="adresse" onkeyup="this.value = this.value.toLowerCase();" style="text-transform: capitalize;" maxlength="254" placeholder="Ex: Minkan" class="form-control" value="<?php echo $row["adresse"]; ?>"/>
        </div>
        <div class="col-sm-6 col-xs-12">
            <label>REGION :</label>
            <input type="text" name="region" onkeyup="this.value = this.value.toLowerCase();" style="text-transform: capitalize;"  maxlength="254" placeholder="Ex: Centre" class="form-control" value="<?php echo $row["region"]; ?>"/>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-3 col-xs-6">
            <label>TELEPHONE :</label>
            <input type="text" name="tel" maxlength="15" placeholder="Ex: 242 22 22 22" class="form-control" value="<?php echo $row["tel"]; ?>"/>
        </div>
        <div class="col-sm-3 col-xs-6">
            <label>FAX :</label>
            <input type="text" name="fax" maxlength="15" placeholder="Ex: 242 22 22 22" class="form-control" value="<?php echo $row["fax"]; ?>"/>
        </div>
        <div class="col-sm-3 col-xs-6">
            <label>EMAIL :</label>
            <input type="email" name="email"  maxlength="254" placeholder="Ex: admin@admin.com" class="form-control" value="<?php echo $row["email"]; ?>"/>
        </div>
        <div class="col-sm-3 col-xs-6">
            <label>SITE WEB :</label>
            <input type="text" name="siteweb"  maxlength="254" placeholder="Ex: www.admin.com" class="form-control" value="<?php echo $row["siteweb"]; ?>" required/>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-3 col-xs-6">
            <label>TELEPHONE 2 :</label>
            <input type="text" name="tel2" maxlength="15" placeholder="Ex: 242 22 22 22" class="form-control" value="<?php echo $row["tel2"]; ?>"/>
        </div>
        <div class="col-sm-3 col-xs-6">
            <label>REGISTRE DE COMMERCE :</label>
            <input type="text" name="registrecommerce" onkeyup="this.value = this.value.toUpperCase();"  maxlength="254" placeholder="" class="form-control" value="<?php echo $row["registrecommerce"]; ?>"/>
        </div>
        <div class="col-sm-3 col-xs-6">
            <label>NUMERO CONTRIBUABLE :</label>
            <input type="text" name="nocontribuable" onkeyup="this.value = this.value.toUpperCase();" pattern="^([a-zA-Z0-9]([ ]?[a-zA-Z0-9._-])+)$" maxlength="254" placeholder="Num&eacute;ro Contribuable" class="form-control" value="<?php echo $row["nocontribuable"]; ?>"/>
        </div>
        <div class="col-sm-3 col-xs-6">
            <label>NUMERO CNPS :</label>
            <input type="text" name="nocnps" pattern="^([a-zA-Z0-9]([ ]?[a-zA-Z0-9._-])+)$" maxlength="254" placeholder="Le num&eacute;ro CNPS" class="form-control" value="<?php echo $row["nocnps"]; ?>"/>
        </div>
    </div>
    <br>
 <fieldset class="space_data"><legend>LOGO ET FILIGRANNE (pour background des PDF selon les types de format)</legend>
    <div class="row">
        <div class="col-sm-2 col-xs-6">
            <label>Ancien Logo :</label>
            <input type="text" name="logoa" class="form-control" value="<?php echo $row["logo"]; ?>" readonly/>
        </div>
        <div class="col-sm-4 col-xs-6">
            <label>Nouveau Logo :</label>
            <input type="file" name="logon" class="form-control" />
            <div class="alert alert-block alert-danger alertextp" style="display:none">
                <h4>Erreur !</h4>
                Extension nom autoris&eacute;e !
            </div>
            <div class="alert alert-block alert-danger alerttailp" style="display:none">
                <h4>Erreur !</h4>
                Image trop grande !
            </div>
            <div class="alert alert-block alert-danger alertimgp" style="display:none">
                <h4>Erreur !</h4>
                Veuillez charger une image !
            </div>
        </div>
        
        <div class="col-sm-2 col-xs-6">
            <label>Ancien Logo 2 :</label>
            <input type="text" name="logoba" class="form-control" value="<?php echo $row["logob"]; ?>" readonly/>
        </div>
        <div class="col-sm-4 col-xs-6">
            <label>Nouveau Logo 2 :</label>
            <input type="file" name="logobn" class="form-control" />
            <div class="alert alert-block alert-danger alertextp" style="display:none">
                <h4>Erreur !</h4>
                Extension nom autoris&eacute;e !
            </div>
            <div class="alert alert-block alert-danger alerttailp" style="display:none">
                <h4>Erreur !</h4>
                Image trop grande !
            </div>
            <div class="alert alert-block alert-danger alertimgp" style="display:none">
                <h4>Erreur !</h4>
                Veuillez charger une image !
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-2 col-xs-6">
            <label>Ancien Filigrane A5 P :</label>
            <input type="text" name="filigranea5pa" class="form-control" value="<?php echo $row["filigranea5p"]; ?>" readonly/>
        </div>
        <div class="col-sm-4 col-xs-6">
            <label>Nouveau Filigrane A5 P :</label>
            <input type="file" name="filigranea5pn" class="form-control" />
            <div class="alert alert-block alert-danger alertextp" style="display:none">
                <h4>Erreur !</h4>
                Extension nom autoris&eacute;e !
            </div>
            <div class="alert alert-block alert-danger alerttailp" style="display:none">
                <h4>Erreur !</h4>
                Image trop grande !
            </div>
            <div class="alert alert-block alert-danger alertimgp" style="display:none">
                <h4>Erreur !</h4>
                Veuillez charger une image !
            </div>
        </div>
        <div class="col-sm-2 col-xs-6">
            <label>Ancien Filigrane A5 L :</label>
            <input type="text" name="filigranea5la" class="form-control" value="<?php echo $row["filigranea5l"]; ?>" readonly/>
        </div>
        <div class="col-sm-4 col-xs-6">
            <label>Nouveau Filigrane A5 L :</label>
            <input type="file" name="filigranea5ln" class="form-control" />
            <div class="alert alert-block alert-danger alertextp" style="display:none">
                <h4>Erreur !</h4>
                Extension nom autoris&eacute;e !
            </div>
            <div class="alert alert-block alert-danger alerttailp" style="display:none">
                <h4>Erreur !</h4>
                Image trop grande !
            </div>
            <div class="alert alert-block alert-danger alertimgp" style="display:none">
                <h4>Erreur !</h4>
                Veuillez charger une image !
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-2 col-xs-6">
            <label>Ancien Filigrane A4 P :</label>
            <input type="text" name="filigranea4pa" class="form-control" value="<?php echo $row["filigranea4p"]; ?>" readonly/>
        </div>
        <div class="col-sm-4 col-xs-6">
            <label>Nouveau Filigrane A4 P :</label>
            <input type="file" name="filigranea4pn" class="form-control" />
            <div class="alert alert-block alert-danger alertextp" style="display:none">
                <h4>Erreur !</h4>
                Extension nom autoris&eacute;e !
            </div>
            <div class="alert alert-block alert-danger alerttailp" style="display:none">
                <h4>Erreur !</h4>
                Image trop grande !
            </div>
            <div class="alert alert-block alert-danger alertimgp" style="display:none">
                <h4>Erreur !</h4>
                Veuillez charger une image !
            </div>
        </div>
        <div class="col-sm-2 col-xs-6">
            <label>Ancien Filigrane A4 L :</label>
            <input type="text" name="filigranea4la" class="form-control" value="<?php echo $row["filigranea4l"]; ?>" readonly/>
        </div>
        <div class="col-sm-4 col-xs-6">
            <label>Nouveau Filigrane A4 L :</label>
            <input type="file" name="filigranea4ln" class="form-control" />
            <div class="alert alert-block alert-danger alertextp" style="display:none">
                <h4>Erreur !</h4>
                Extension nom autoris&eacute;e !
            </div>
            <div class="alert alert-block alert-danger alerttailp" style="display:none">
                <h4>Erreur !</h4>
                Image trop grande !
            </div>
            <div class="alert alert-block alert-danger alertimgp" style="display:none">
                <h4>Erreur !</h4>
                Veuillez charger une image !
            </div>
        </div>
    </div>
</fieldset>
    <fieldset class="space_data"><legend>Options</legend>
        <input type="submit" name="proprietaire_btn" value="Enregistrer" class="btn btn-success" id="store_btn"/>
        <input type="reset" name="reload" value="Effacer" class="btn btn-success"/>
        <a href="javascript:history.go(-1)" class="btn btn-success btn-sm">Quitter</a>
    </fieldset>
</form><br>
<?php
if (isset($_POST["proprietaire_btn"])) {

    $nom = strtoupper(trim(htmlspecialchars($_POST["nom"])));
    $nomb = strtoupper(trim(htmlspecialchars($_POST["nomb"])));
    $ministere = strtoupper(trim(htmlspecialchars($_POST["ministere"])));
    $textea = strtoupper(trim(htmlspecialchars($_POST["textea"])));
    $tutelle = strtoupper(trim(htmlspecialchars($_POST["tutelle"])));
    $noma = strtoupper(trim(htmlspecialchars($_POST["noma"])));
    $nomba = strtoupper(trim(htmlspecialchars($_POST["nomba"])));
    $ministerea = strtoupper(trim(htmlspecialchars($_POST["ministerea"])));
    $texteaa = strtoupper(trim(htmlspecialchars($_POST["texteaa"])));
    $tutellea = strtoupper(trim(htmlspecialchars($_POST["tutellea"])));
    $notemodulable = floatval(trim(htmlspecialchars($_POST["notemodulable"])));
    $noteminvalide = floatval(trim(htmlspecialchars($_POST["noteminvalide"])));
    $devise = ucwords(trim(htmlspecialchars($_POST["devise"])));
    $bp = trim(htmlspecialchars($_POST["bp"]));
    $quartier = ucwords(trim(htmlspecialchars($_POST["quartier"])));
    $region = ucwords(trim(htmlspecialchars($_POST["region"])));
    $email = (trim(htmlspecialchars($_POST["email"])));
    $siteweb = (trim(htmlspecialchars($_POST["siteweb"])));
    $tel = trim(htmlspecialchars($_POST["tel"]));
    $tel2 = trim(htmlspecialchars($_POST["tel2"]));
    $fax = trim(htmlspecialchars($_POST["fax"]));
    $logoa = trim(htmlspecialchars($_POST["logoa"]));
    $logoba = trim(htmlspecialchars($_POST["logoba"]));
    $filigranea4pa = trim(htmlspecialchars($_POST["filigranea4pa"]));
    $filigranea4la = trim(htmlspecialchars($_POST["filigranea4la"]));
    $filigranea5pa = trim(htmlspecialchars($_POST["filigranea5pa"]));
    $filigranea5la = trim(htmlspecialchars($_POST["filigranea5la"]));
    $typed = ucwords(trim(htmlspecialchars($_POST["typed"])));
    $nomd = ucwords(trim(htmlspecialchars($_POST["nomd"])));
    $texteb = strtoupper(trim(htmlspecialchars($_POST["texteb"])));
    $adresse = ucwords(trim(htmlspecialchars($_POST["adresse"])));
    $nocnps = trim(htmlspecialchars($_POST["nocnps"]));
    $nocontribuable = strtoupper(trim(htmlspecialchars($_POST["nocontribuable"])));
    $registrecommerce = strtoupper(trim(htmlspecialchars($_POST["registrecommerce"])));
    $id = $row["idproprietaire"];
    $islog = FALSE;
    $logon = NULL;
    $islogb = FALSE;
    $logobn = NULL;
    $isfila4 = FALSE;
    $filigranea4pn = NULL;
    $isfila4l = FALSE;
    $filigranea4ln = NULL;
    $isfila5p = FALSE;
    $filigranea5pn = NULL;
    $isfila5 = FALSE;
    $filigranea5ln = NULL;
    //tester si on a envoyer une image
    if (isset($_FILES['logon']) AND $_FILES['logon']['error'] == 0) {
        //tester la taille de l'image
        if ($_FILES['logon']['size'] <= 2000000) {
            //tester l'extension
            $infosfichier = pathinfo($_FILES['logon']['name']);
            $extension_upload = $infosfichier['extension'];
            $extensions_autorisees = array('jpg', 'JPEG', 'gif', 'GIF', 'png', 'PNG', 'jpeg', 'JPG');
            if (in_array($extension_upload, $extensions_autorisees)) {
                $logon = $_FILES['logon']['name'];
                $islog = TRUE;
            } else {
                echo "<script language='javascript'>$('div.alertextp').show('slow').delay(4000).hide('slow');</script>";
                $islog = FALSE;
            }
        } else {
            echo "<script language='javascript'>$('div.alerttailp').show('slow').delay(4000).hide('slow');</script>";
            $islog = FALSE;
        }
    } else {
        $logon = NULL;
        $islog = TRUE;
    }
    //tester si on a envoyer une image
    if (isset($_FILES['logobn']) AND $_FILES['logobn']['error'] == 0) {
        //tester la taille de l'image
        if ($_FILES['logobn']['size'] <= 2000000) {
            //tester l'extension
            $infosfichier = pathinfo($_FILES['logobn']['name']);
            $extension_upload = $infosfichier['extension'];
            $extensions_autorisees = array('jpg', 'JPEG', 'gif', 'GIF', 'png', 'PNG', 'jpeg', 'JPG');
            if (in_array($extension_upload, $extensions_autorisees)) {
                $logobn = $_FILES['logobn']['name'];
                $islogb = TRUE;
            } else {
                echo "<script language='javascript'>$('div.alertextp').show('slow').delay(4000).hide('slow');</script>";
                $islogb = FALSE;
            }
        } else {
            echo "<script language='javascript'>$('div.alerttailp').show('slow').delay(4000).hide('slow');</script>";
            $islogb = FALSE;
        }
    } else {
        $logobn = NULL;
        $islogb = TRUE;
    }
    //tester si on a envoyer une image
    if (isset($_FILES['filigranea4pn']) AND $_FILES['filigranea4pn']['error'] == 0) {
        //tester la taille de l'image
        if ($_FILES['filigranea4pn']['size'] <= 2000000) {
            //tester l'extension
            $infosfichier = pathinfo($_FILES['filigranea4pn']['name']);
            $extension_upload = $infosfichier['extension'];
            $extensions_autorisees = array('jpg', 'JPEG', 'gif', 'GIF', 'png', 'PNG', 'jpeg', 'JPG');
            if (in_array($extension_upload, $extensions_autorisees)) {
                $filigranea4pn = $_FILES['filigranea4pn']['name'];
                $isfila4 = TRUE;
            } else {
                echo "<script language='javascript'>$('div.alertextp').show('slow').delay(4000).hide('slow');</script>";
                $isfila4 = FALSE;
            }
        } else {
            echo "<script language='javascript'>$('div.alerttailp').show('slow').delay(4000).hide('slow');</script>";
            $isfila4 = FALSE;
        }
    } else {
        $filigranea4pn = NULL;
        $isfila4 = TRUE;
    }
    //tester si on a envoyer une image
    if (isset($_FILES['filigranea4ln']) AND $_FILES['filigranea4ln']['error'] == 0) {
        //tester la taille de l'image
        if ($_FILES['filigranea4ln']['size'] <= 2000000) {
            //tester l'extension
            $infosfichier = pathinfo($_FILES['filigranea4ln']['name']);
            $extension_upload = $infosfichier['extension'];
            $extensions_autorisees = array('jpg', 'JPEG', 'gif', 'GIF', 'png', 'PNG', 'jpeg', 'JPG');
            if (in_array($extension_upload, $extensions_autorisees)) {
                $filigranea4ln = $_FILES['filigranea4ln']['name'];
                $isfila4l = TRUE;
            } else {
                echo "<script language='javascript'>$('div.alertextp').show('slow').delay(4000).hide('slow');</script>";
                $isfila4l = FALSE;
            }
        } else {
            echo "<script language='javascript'>$('div.alerttailp').show('slow').delay(4000).hide('slow');</script>";
            $isfila4l = FALSE;
        }
    } else {
        $filigranea4ln = NULL;
        $isfila4l = TRUE;
    }
    //tester si on a envoyer une image
    if (isset($_FILES['filigranea5pn']) AND $_FILES['filigranea5pn']['error'] == 0) {
        //tester la taille de l'image
        if ($_FILES['filigranea5pn']['size'] <= 2000000) {
            //tester l'extension
            $infosfichier = pathinfo($_FILES['filigranea5pn']['name']);
            $extension_upload = $infosfichier['extension'];
            $extensions_autorisees = array('jpg', 'JPEG', 'gif', 'GIF', 'png', 'PNG', 'jpeg', 'JPG');
            if (in_array($extension_upload, $extensions_autorisees)) {
                $filigranea5pn = $_FILES['filigranea5pn']['name'];
                $isfila5p = TRUE;
            } else {
                echo "<script language='javascript'>$('div.alertextp').show('slow').delay(4000).hide('slow');</script>";
                $isfila5p = FALSE;
            }
        } else {
            echo "<script language='javascript'>$('div.alerttailp').show('slow').delay(4000).hide('slow');</script>";
            $isfila5p = FALSE;
        }
    } else {
        $filigranea5pn = NULL;
        $isfila5p = TRUE;
    }
    //tester si on a envoyer une image
    if (isset($_FILES['filigranea5ln']) AND $_FILES['filigranea5ln']['error'] == 0) {
        //tester la taille de l'image
        if ($_FILES['filigranea5ln']['size'] <= 2000000) {
            //tester l'extension
            $infosfichier = pathinfo($_FILES['filigranea5ln']['name']);
            $extension_upload = $infosfichier['extension'];
            $extensions_autorisees = array('jpg', 'JPEG', 'gif', 'GIF', 'png', 'PNG', 'jpeg', 'JPG');
            if (in_array($extension_upload, $extensions_autorisees)) {
                $filigranea5ln = $_FILES['filigranea5ln']['name'];
                $isfila5 = TRUE;
            } else {
                echo "<script language='javascript'>$('div.alertextp').show('slow').delay(4000).hide('slow');</script>";
                $isfila5 = FALSE;
            }
        } else {
            echo "<script language='javascript'>$('div.alerttailp').show('slow').delay(4000).hide('slow');</script>";
            $isfila5 = FALSE;
        }
    } else {
        $filigranea5ln = NULL;
        $isfila5 = TRUE;
    }
    if ($islog && $islogb && $isfila4 && $isfila4l && $isfila5p && $isfila5) {
        update_proprietaire($id, $nom1, $tell, $emaill, $site1, $bp1, $login, $pass1, $hopital1, $creation, $type, $slogan1, $nocontribuable, $texte1, $adresse1, $logoa, $logon, $filigranea4pa, $filigranea4pn, $filigranea4la, $filigranea4ln, $filigranea5pa, $filigranea5pn, $filigranea5la, $filigranea5ln, $con);
    }
}
?>