<?php $page_active = "Point Hotel"; ?>
<script language="JavaScript">
    jQuery(document).ready(function() {
        // binds form submission and fields to the validation engine
        jQuery("#service_form").validationEngine('attach');
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
if ((isset($_REQUEST["personnel"])) && (isset($_REQUEST["magasin"]))) {
    $idpers = $_REQUEST["personnel"];
    $idrest= $_REQUEST["magasin"];
    if (isset($_POST["insserv"])) {
    $rest = trim(htmlspecialchars($_POST['resto']));
        editer_magasinpers($idpers, $rest, $idrest,$con);
    }
    $rslt = $con->query("select * from hp_personnel_magasin as ur left join hp_personnel as p on "
            . "ur.idpersonnel=p.idpersonnel left join hp_magasin as r on ur.idmagasin=r.idmagasin where "
            . "ur.idpersonnel='" . $idpers . "' and ur.idmagasin='" . $idrest . "'") or die(mysqli_error($con));
    $row = mysqli_fetch_assoc($rslt);
    $rslts = $con->query("select * from hp_magasin") or die(mysqli_error($con));
    ?>
    <!-- formulaire d'ajout d'une annee   -->
    <div class="row">
        <div class="col-lg-12">
            <!--<a href="javascript:history.go(-1)" class="btn btn-success btn-sm pull-left">Pr&eacute;c&eacute;dent</a>-->
            <h2 class="page-header">Modification du magasin <small> de <?php echo $row["nompersonnel"] ?> <?php echo $row["prenompersonnel"] ?> <?php echo $row["telephonepersonnel"] ?> </small></h2>  
            <h2 class="page-header">Ancien magasin <small> <?php echo $row["nommagasin"] ?></small></h2>  
            <form id="service_form" method="post" action="#">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group" style="margin-left:15px;">
                            <label class="control-label">Nom du magasin</label>  
                            <div class="inputGroupContainer">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                    <select class="text-input form-control" type="text" name="resto" id="resto">
                                        <option value="" selected="selected">- Choisissez un magasin -</option>
                                        <?php
                                        while ($rows = mysqli_fetch_assoc($rslts)) {
                                            if (($rows["idmagasin"] != $idrest)) {
                                                ?>
                                        <option value="<?php echo $rows["idmagasin"] ?>" ><?php echo $rows["nommagasin"] ?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 col-sm-offset-6">
                        <button type="submit" name="insserv" class="btn btn-success"><i class="icon-check"></i> Enregistrer</button>
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