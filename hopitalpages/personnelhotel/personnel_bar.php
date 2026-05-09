<?php $page_active="Point Hotel"; ?>
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
if (isset($_POST["insserv"])) {
//    $serv = trim(htmlspecialchars($_POST["serv"]));
    $rest = array();
    $i = 0;
    foreach ($_POST['resto'] as $restor) {
        $rest[$i] = $restor;
        $i=$i + 1;
    }
    $idpers = $_REQUEST["personnel"];
    ajouter_barpers($idpers, $rest, $i,$con);
}
if (isset($_REQUEST["personnel"])) {
    $idpers = $_REQUEST["personnel"];
    $rslt = $con->query("select * from hotel_personnel where id_personnel='" . $idpers . "'") or die(mysqli_error($con));
    $row = mysqli_fetch_assoc($rslt);
    $rslts = $con->query("select * from hotel_bar") or die(mysqli_error($con));
    ?>
    <!-- formulaire d'ajout d'une annee   -->
    <div class="row">
        <div class="col-lg-12">
            <!--<a href="javascript:history.go(-1)" class="btn btn-success btn-sm pull-left">Pr&eacute;c&eacute;dent</a>-->
            <h2 class="page-header">Association des Services <small> &agrave; <?php echo $row["nom_pe"] ?> <?php echo $row["prenom_pe"] ?> <?php echo $row["tel_pe"] ?> </small></h2>  
            <form id="service_form" method="post" action="#">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group" style="margin-left:15px;">
                            <label class="control-label">Nom du bar</label>  
                            <div class="inputGroupContainer">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                    <select class="validate[required] text-input form-control" type="text" name="resto[]" id="resto">
                                        <option value="" selected="selected">- Choisissez un bar -</option>
                                        <?php
                                        while ($rows = mysqli_fetch_assoc($rslts)) {
                                            $rsltfe = $con->query("select * from utilisateur_bar where id_bar='" . $rows["id_bar"] . "' "
                                                    . "and id_personnel='" . $idpers . "'") or die(mysqli_error($con));
                                            $nbfe = mysqli_num_rows($rsltfe);
                                            if ($nbfe == 0) {
                                                ?>
                                                <option value="<?php echo $rows["id_bar"] ?>" ><?php echo $rows["nom_bar"] ?></option>
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