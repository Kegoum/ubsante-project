<div id="modalnewuniteve" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modalnewuniteveLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h5 id="modalnewuniteveLabel">Formulaire d'ajout d'une Unit&eacute;</h5>
            </div>
            <div class="modal-body">
                <div class="single-product-tab-area mg-tb-15">
                    <!-- Single pro tab review Start-->
                    <div class="single-pro-review-area">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="sparkline12-list mt-b-30">
                                        <form id="ajout_unitevma" name="formunitevma" enctype="multipart/form-data" method="post" action="#">

                                            <div class="row">
                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                    <div class="review-content-section">
                                                        <label class="control-label" >Code  <g style="color: red">*</g></label>
                                                        <div class="input-group mg-b-pro-edt">
                                                            <span class="input-group-addon"><i class="fa fa-home" aria-hidden="true"></i></span>
                                                            <input value="" class="form-control" placeholder="" type="text" name="codeunitevma" id="codeunitevma" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                    <div class="review-content-section">
                                                        <label class="control-label" >D&eacute;signation  <g style="color: red">*</g></label>
                                                        <div class="input-group mg-b-pro-edt">
                                                            <span class="input-group-addon"><i class="fa fa-home" aria-hidden="true"></i></span>
                                                            <input value="" class="form-control" placeholder="" type="text" name="libunitevma" id="libunitevma" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                    <b style="color: red">Champs Obligatoires *</b>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                    <div class="text-center mg-b-pro-edt custom-pro-edt-ds">
                                                        <button type="submit" id="addnewunitevma" name="addnewunitevma" class="btn btn-primary ">Enregistrer</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        // Generate a simple captcha
        function randomNumber(min, max) {
            return Math.floor(Math.random() * (max - min + 1) + min);
        }
        ;
        $('#captchaOperation').html([randomNumber(1, 100), '+', randomNumber(1, 200), '='].join(' '));

        $('#ajout_unitevma').bootstrapValidator({
//        live: 'disabled',
            message: 'Cette valeur est invalide',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                libuniteman: {
                    validators: {
                        notEmpty: {
                            message: 'La Désignation est obligatoire'
                        },
                        remote: {
                            type: 'POST',
                            url: './hopitalpages/hopitalunite/remoteformvalidationunite.php',
                            message: 'La Désignation doit être unique'
                        }
                    }
                }
            }
        });

        // Validate the form manually
//    $('#validateBtn').click(function() {
//        $('#ajout_unitema').bootstrapValidator('validate');
//    });
//
//    $('#resetBtn').click(function() {
//        $('#ajout_unitema').data('bootstrapValidator').resetForm(true);
//    });
    });
</script>
