
<div class="single-product-tab-area mg-tb-15">
    <!-- Single pro tab review Start-->
    <div class="single-pro-review-area">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="sparkline12-list mt-b-30">
                        <div class="sparkline12-hd">
                            <div class="main-sparkline12-hd">
                                <h1>Formulaire de modification d'une r&eacute;gion</h1>
                            </div>
                        </div>
                        <form id="edit_region" name="formregione" enctype="multipart/form-data" method="post" action="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalparametre/hopitalregion/hopitalediter/edit_region'); ?>&pagecom=<?php echo NUM_PAGE + 1; ?>&idregion=<?php echo $_REQUEST["idregion"]; ?>" style="padding: 2%;">

                            <input value="<?php echo $_SESSION['formregione'][NUM_PAGE]["idregion"]; ?>" type="hidden" name="idregion" id="idregion" />
                            
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group" style="margin-left:15px;">
                                        <label class="control-label">Code&nbsp;<g style="color: red">*</g></label>
                                        <div class="inputGroupContainer">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                                <input value="<?php echo $_SESSION['formregione'][NUM_PAGE]["codepe"]; ?>" onkeyup="this.value = this.value.toUpperCase();" class="form-control" placeholder="" type="text" name="codepe" id="codepe" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group" style="margin-left:15px;">
                                        <label class="control-label" >Nom&nbsp;<g style="color: red">*</g></label>
                                        <div class="inputGroupContainer">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                                <input value="<?php echo $_SESSION['formregione'][NUM_PAGE]["regione"]; ?>" onkeyup="this.value = this.value.toLowerCase();" style="text-transform: capitalize;" class="form-control" placeholder="" type="text" name="regione" id="regione" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group" style="margin-left:15px;">
                                        <label class="control-label" >Chef lieu<g style="color: red">*</g></label>
                                        <div class="inputGroupContainer">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                                <input value="<?php echo $_SESSION['formregione'][NUM_PAGE]["cheflieue"]; ?>" class="form-control" placeholder="" type="text" name="cheflieue" id="cheflieue" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-footer">
                                <div class="row">
                                    <br>
                                    <div class="col-sm-12">
                                        <b style="color: red">Champs Obligatoires *</b>
                                    </div>
                                    <br>
                                    <div class="col-sm-12 text-center">
                                        <button type="submit" id="validateBtnpe" name="" class="btn btn-success"><i class="glyphicon glyphicon-check"></i> Modifier</button>
                                        <button type="reset" id="resetBtnpe" class="btn btn-primary"><i class="glyphicon glyphicon-remove"></i> Effacer</button>
                                        <a href="javascript:history.go(-1)" class="btn btn-primary"><i class="glyphicon glyphicon-backward"></i> Quitter</a>
                                        <br>
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

<script type="text/javascript">
    $(document).ready(function() {
        // Generate a simple captcha
        function randomNumber(min, max) {
            return Math.floor(Math.random() * (max - min + 1) + min);
        }
        ;
        $('#captchaOperation').html([randomNumber(1, 100), '+', randomNumber(1, 200), '='].join(' '));

        var idregion = document.getElementById('idregion').value;
//        alert(idregion);
        $('#edit_region').bootstrapValidator({
//        live: 'disabled',
            message: 'Cette valeur est invalide',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                codepe: {
                    message: 'Code du region invalide',
                    validators: {
                        notEmpty: {
                            message: 'Le code du region est obligatoire'
                        },
                        stringLength: {
                            min: 1,
                            max: 5,
                            message: 'Le code du region doit etre entre 1 et 5 characteres de long'
                        },
                        regexp: {
                            regexp: /^[a-zA-Z0-9]+$/,
                            message: 'Le code du region peut contenir seulement les lettres de l\'alphabet et les chiffres'
                        },
                        remote: {
                            type: 'POST',
                            data: {idregion: idregion},
                            dataType: 'json',
                            url: './hopitalpages/hopitalparametre/hopitalregion/remoteformvalidationregion.php',
                            message: 'Le code doit etre unique'
                        }
                    }
                },
                regione: {
                    validators: {
                        notEmpty: {
                            message: 'Le nom du region est obligatoire'
                        }
                    }
                }
            }
        });

        // Validate the form manually
//        $('#validateBtnpe').click(function () {
//            $('#edit_region').bootstrapValidator('validate');
//        });
//
//        $('#resetBtnpe').click(function () {
//            $('#edit_region').data('bootstrapValidator').resetForm(true);
//        });
    });
</script>
