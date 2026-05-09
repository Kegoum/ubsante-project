<?php $page_active="Personnel"; ?>
<script language="JavaScript">
    jQuery(document).ready(function() {
        // binds form submission and fields to the validation engine
        jQuery("#compte_form").validationEngine('attach');
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
<?php
if (isset($_POST["inscompte"])) {
    $loginp = trim(htmlspecialchars($_POST["loginp"]));
    $pas1 = sha1(trim(htmlspecialchars($_POST["pas1"])));
    $idpers = $_REQUEST["personnel"];
    ajouter_compte($idpers, $loginp, $pas1,$con);
}
if (isset($_REQUEST["personnel"])) {
    $idpers = $_REQUEST["personnel"];
    $rslt = $con->query("select * from hotel_personnel where id_personnel='" . $idpers . "'") or die(mysqli_error($con));
    $row = mysqli_fetch_assoc($rslt);
    ?>
    <!-- formulaire d'ajout d'une annee   -->
    <div class="row">
        <div class="col-lg-12">
            <!--<a href="javascript:history.go(-1)" class="btn btn-success btn-sm pull-left">Pr&eacute;c&eacute;dent</a>-->
            <h2 class="page-header">Association d'un Compte <small> &agrave; <?php echo $row["nom_pe"] ?>  <?php echo $row["prenom_pe"] ?> </small></h2>  
            <form id="compte_form" method="post" action="#">

                <div class="row ">
                    <div class="col-sm-6">
                        <div class="form-group" style="margin-left:15px;">
                            <label class="control-label">Login</label>  
                            <div class="inputGroupContainer">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-log-in"></i></span>
                                    <input name="loginp" placeholder="Login" class="validate[required,custom[onlyLetterSp]] text-input form-control" type="text">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row ">
                    <div class="col-sm-6">
                        <div class="form-group" style="margin-left:15px;">
                            <label class="control-label">Mot de passe</label>  
                            <div class="inputGroupContainer">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-globe"></i></span>
                                    <input name="pas1" placeholder="Mot de passe" class="validate[required] text-input form-control" type="password" id="pas1">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group" style="margin-left:15px;">
                            <label class="control-label">Confirmer le mot de passe</label>  
                            <div class="inputGroupContainer">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-file"></i></span>
                                    <input name="pas2" placeholder="Confirmer le mot de passe" class="validate[required,equals[pas1]] text-input form-control" type="password" id="pas2">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 col-sm-offset-6">
                        <button type="submit" name="inscompte" class="btn btn-success"><i class="icon-check"></i> Enregistrer</button>
                        <button type="reset" class="btn btn-danger"><i class="icon-remove"></i> Effacer</button>
                        <a href="javascript:history.go(-1)" class="btn btn-success"><i class="icon-backward"></i> Quitter</a>
                    </div>
                </div>
            </form>
        </div>
    </div> 
    <?php
}
?>