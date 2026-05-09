<script language="JavaScript">
    jQuery(document).ready(function() {
        // binds form submission and fields to the validation engine
        jQuery("#versement_form").validationEngine('attach');
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
$rslt = $con->query("select * from hotel_personnel as pe left join hotel_affectation as af on "
        . "pe.id_personnel=af.id_personnel left join service_point_hotel as spa on "
        . "af.id_service_point_hotel=spa.id_service_point_hotel left join hotel_point_hotel as pa on "
        . "spa.id_point_hotel=pa.id_point_hotel left join hotel_service as s on spa.id_service=s.id_service "
        . "where pe.id_personnel='" . $_REQUEST["personnel"] . "'") or die(mysqli_error($con));
$row = mysqli_fetch_assoc($rslt);
?>
<div class="row">
    <div class="col-sm-3"></div>
    <div class="col-sm-6">
        <!--<a href="javascript:history.go(-1)" class="btn btn-success btn-sm pull-left">Pr&eacute;c&eacute;dent</a>-->
        <h3 class=" text-center">Formulaire de Versement de <small> <?php echo $row["nom_pe"]; ?> <?php echo $row["prenom_pe"]; ?> - <?php echo $row["tel_pe"]; ?></small></h3>  
        <form id="versement_form" name="formversement" enctype="multipart/form-data" method="post" action="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/personnelhotel/versementhotel/versement'); ?>&pagevoy=<?php echo NUM_PAGE + 1; ?>&personnel=<?php echo $_REQUEST["personnel"] ?>">
            <div class="row ">
                <div class="col-sm-6">
                    <div class="form-group" style="margin-left:15px;">
                        <label class="control-label">Montant</label>  
                        <div class="inputGroupContainer">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></span>
                                <input value="<?php echo $_SESSION['formvoy'][NUM_PAGE]["montant"]; ?>" class="validate[required,custom[number]] text-input form-control" placeholder="50000" type="text" name="montant" id="montant" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 col-sm-offset-6">
                    <a href="javascript:history.go(-1)" class="btn btn-success"><i class="icon-backward"></i> Quitter</a>
                    <button type="reset" class="btn btn-danger"><i class="icon-remove"></i> Effacer</button>
                    <button type="submit" name="editpers" class="btn btn-success">Verser <i class="icon-forward"></i></button>
                </div>
            </div>
        </form>
    </div>
    <div class="col-sm-3"></div>
</div>