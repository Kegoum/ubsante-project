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

<div class="row">
    <div class="col-sm-3"></div>
    <div class="col-sm-6">
        <!--<a href="javascript:history.go(-1)" class="btn btn-success btn-sm pull-left">Pr&eacute;c&eacute;dent</a>-->
        <h3 class=" text-center">Formulaire de Versement </h3>  
        <form id="versement_form" name="formversement" enctype="multipart/form-data" method="post" action="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/personnelhotel/caissehotel/versementhotel/versement'); ?>&pageversautre=<?php echo NUM_PAGE + 1; ?>">
            <div class="row ">
                <div class="col-sm-12">
                    <div class="form-group" style="margin-left:15px;">
                        <label class="control-label">Montant</label>  
                        <div class="inputGroupContainer">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></span>
                                <input value="<?php echo $_SESSION['formversautre'][NUM_PAGE]["montant"]; ?>" class="validate[required,custom[onlyNumber]] text-input form-control" placeholder="50000" type="text" name="montant" id="montant" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row ">
                <div class="col-sm-12">
                    <div class="form-group" style="margin-left:15px;">
                        <label class="control-label">But</label>  
                        <div class="inputGroupContainer">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-adjust"></i></span>
                                <textarea value="" class="validate[required] text-input form-control" placeholder="Le but du versement" name="but" id="but"><?php echo $_SESSION['formversautre'][NUM_PAGE]["but"]; ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row pull-right">
                <div class="col-sm-12">
                    <a href="javascript:history.go(-1)" class="btn btn-success"><i class="icon-backward"></i> Quitter</a>
                    <button type="reset" class="btn btn-danger"><i class="icon-remove"></i> Effacer</button>
                    <button type="submit" name="editpers" class="btn btn-success">Verser <i class="icon-forward"></i></button>
                </div>
            </div>
        </form>
    </div>
    <div class="col-sm-3"></div>
</div>