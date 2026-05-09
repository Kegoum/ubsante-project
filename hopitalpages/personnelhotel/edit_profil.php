<script language="JavaScript">
    jQuery(document).ready(function() {
        // binds form submission and fields to the validation engine
        jQuery("#personnel_eform").validationEngine('attach');
    });
    /**
     *
     * @param {jqObject} the field where the validation applies
     * @param {Array[String]} validation rules for this field
     * @param {int} rule index
     * @param {Map} form options
     * @return an error string if validation failed
     */
    function checkHELLO(field, rules, i, options) {
        if (field.val() != "HELLO") {
            // this allows to use i18 for the error msgs
            return options.allrules.validate2fields.alertText;
        }
    }

</script>
<div id="modaleditppe" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modaleditpLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h2 id="modaleditpLabel">Modifier <small>Mon profil</small></h2>
            </div>
            <div class="modal-body">
                <?php
                if (isset($_SESSION["id_compte_personnel"])) {
                    $iduser = $_SESSION["id_compte_personnel"];
                    $rslt = $con->query("select * from hotel_compte_personnel as c left join hotel_personnel as p on c.id_personnel=p.id_personnel "
                            . "where c.id_compte_personnel='" . $iduser . "'") or die("erreur");
                    $row = mysqli_fetch_assoc($rslt);
                    ?>
                    <form name="" id="personnel_eform" method="POST" action="#">
                        <div class="form-group">
                            <label>Nom</label>
                            <input name="nomep" value="<?php echo $row["nom_pe"]; ?>" type="text" class="validate[required,custom[textSansApostroph]] text-input form-control" id="nome" required autofocus>
                        </div>
                        <div class="form-group">
                            <label>Pr&eacute;nom</label>
                            <input name="prenomep" value="<?php echo $row["prenom_pe"]; ?>" type="text" class="validate[custom[textSansApostroph]] text-input form-control" id="prenome">
                        </div>
                        <div class="form-group">
                            <label>T&eacute;l&eacute;phone</label>
                            <input name="telep" type="text" class="validate[custom[phone]] text-input form-control" value="<?php echo $row["tel_pe"]; ?>" id="tele" required>
                        </div>
                        <div class="form-group">
                            <label>E-Mail</label>
                            <input name="emailep" value="<?php echo $row["email_pe"]; ?>" type="text" class="validate[required,custom[email]] text-input form-control" id="emaile" required>
                        </div>
                        <div class="form-group">
                            <label>Login</label>
                            <input name="loginep" value="<?php echo $row["login_pe"]; ?>" type="text" class="validate[required,custom[onlyLetterSp]] text-input form-control" id="logine" required>
                        </div>
                        <div class="form-group">
                            <label>Mot de passe</label>
                            <input name="motdepasse1ep" placeholder="Votre mot de passe" type="password" class="form-control" id="passworde">
                        </div>
                        <br/><br/>
                        <input type="submit" class="btn btn-success"  id="Submite" onclick="verif_vale();"  name="edituser_btn"/>
                        <input type="reset" class="btn btn-success " name="effacere" value="Effacer">
                        <input type="button" class="close btn-success" data-dismiss="modal" aria-hidden="true"  value="Annuler">
                    </form>
                    <?php
                }
                $id = $_SESSION["id_compte_personnel"];
                if (isset($_POST["edituser_btn"])) {
                    $nom = trim($_POST["nomep"]);
                    $prenom = trim($_POST["prenomep"]);
                    $login = trim($_POST["loginep"]);
                    $tel = trim($_POST["telep"]);
                    $email = trim($_POST["emailep"]);
                    $motdepasse1 = trim($_POST["motdepasse1ep"]);
                    update_profil($nom, $prenom, $email, $tel, $login, $motdepasse1, $con);
                }
                ?>
            </div>

        </div>
    </div>
</div>