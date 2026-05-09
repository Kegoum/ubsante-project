
<div class="single-product-tab-area mg-tb-15">
    <!-- Single pro tab review Start-->
    <div class="single-pro-review-area">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="sparkline12-list mt-b-30">
                        <div class="sparkline12-hd">
                            <div class="main-sparkline12-hd">
                                <h1>Formulaire d'ajout d'une Valorisation</h1>
                            </div>
                        </div>
                        <form id="ajout_valorisationstock" name="formvalorisationstock" enctype="multipart/form-data" method="post" action="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalproduit/hopitalvalorisation/hopitalajouter/ajout_valorisation'); ?>&pagecom=<?php echo NUM_PAGE + 1; ?>" style="padding: 2%;">

                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="review-content-section">
                                        <label class="control-label" >Code &nbsp;<g style="color: red">*</g></label>
                                        <div class="input-group mg-b-pro-edt">
                                            <span class="input-group-addon"><i class="fa fa-home" aria-hidden="true"></i></span>
                                            <select name="codevalorisationstock" class="form-control pro-edt-select form-control-primary">
                                                <option value="" selected="selected">- Choisissez un Code-</option>
                                                <option value="CUMPFP" <?php if ($_SESSION['formvalorisationstock'][NUM_PAGE]["codevalorisationstock"] == "CUMPFP") { ?> selected <?php } ?>>CUMPFP</option>
                                                <option value="CUMPFE" <?php if ($_SESSION['formvalorisationstock'][NUM_PAGE]["codevalorisationstock"] == "CUMPFE") { ?> selected <?php } ?>>CUMPFE</option>
                                                <option value="PEPS" <?php if ($_SESSION['formvalorisationstock'][NUM_PAGE]["codevalorisationstock"] == "PEPS") { ?> selected <?php } ?>>PEPS</option>
                                                <option value="DEPS" <?php if ($_SESSION['formvalorisationstock'][NUM_PAGE]["codevalorisationstock"] == "DEPS") { ?> selected <?php } ?>>DEPS</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="review-content-section">
                                        <label class="control-label" >Libell&eacute;  <g style="color: red">*</g></label>
                                        <div class="input-group mg-b-pro-edt">
                                            <span class="input-group-addon"><i class="fa fa-home" aria-hidden="true"></i></span>
                                            <input value="<?php echo $_SESSION['formvalorisationstock'][NUM_PAGE]["libvalorisationstock"]; ?>" class="form-control" onkeyup="this.value = this.value.toLowerCase();" style="text-transform: capitalize;" placeholder="" type="text" name="libvalorisationstock" id="libvalorisationstock" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <b style="color: red">Champs Obligatoires *</b>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <button type="submit" class="btn btn-primary ">Enregistrer</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        // Generate a simple captcha
        function randomNumber(min, max) {
            return Math.floor(Math.random() * (max - min + 1) + min);
        }
        ;
        $('#captchaOperation').html([randomNumber(1, 100), '+', randomNumber(1, 200), '='].join(' '));

        $('#ajout_valorisationstock').bootstrapValidator({
//        live: 'disabled',
            message: 'Cette valeur est invalide',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                codevalorisationstock: {
                    validators: {
                        notEmpty: {
                            message: 'Le Code est obligatoire'
                        },
                        remote: {
                            type: 'POST',
                            url: './hopitalpages/hopitalproduit/hopitalvalorisation/remoteformvalidationvalorisation.php',
                            message: 'Le Code doit être unique'
                        }
                    }
                }
            }
        });

        // Validate the form manually
//    $('#validateBtn').click(function() {
//        $('#ajout_valorisationstock').bootstrapValidator('validate');
//    });
//
//    $('#resetBtn').click(function() {
//        $('#ajout_valorisationstock').data('bootstrapValidator').resetForm(true);
//    });
    });
</script>
