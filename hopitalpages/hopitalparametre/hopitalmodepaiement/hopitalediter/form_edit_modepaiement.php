<div class="row">
    <div class="col-md-3 col-sm-2 col-xs-1" ></div>
    <div class="col-md-6 col-sm-8 col-xs-10" >


        <!--***** BASIC FORM *****-->
        <div class="card form" id="form1">
            <div class="card-header">
                <h3>Formulaire de modification d'un Mode de paiement</h3>  

            </div>
            <br>
            <form id="edit_modepaiement" name="formmodepaiemente" enctype="multipart/form-data" method="post" action="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalparametre/hopitalmodepaiement/hopitalediter/edit_modepaiement'); ?>&pagecom=<?php echo NUM_PAGE + 1; ?>&idmodepaiement=<?php echo $_REQUEST["idmodepaiement"]; ?>" style="padding: 2%;">

                <input value="<?php echo $_SESSION['formmodepaiemente'][NUM_PAGE]["idmodepaiement"]; ?>" type="hidden" name="idmodepaiement" id="idmodepaiement" />

                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group" style="margin-left:15px;">
                            <label class="control-label" >Code mode paiement &nbsp;<g>*</g></label>
                            <div class="inputGroupContainer">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                    <input value="<?php echo $_SESSION['formmodepaiemente'][NUM_PAGE]["codee"]; ?>" onkeyup="this.value = this.value.toUpperCase();" class="form-control" placeholder="" type="text" name="codee" id="codee" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group" style="margin-left:15px;">
                            <label class="control-label" >Nom mode paiement&nbsp;<g>*</g></label>
                            <div class="inputGroupContainer">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                    <input value="<?php echo $_SESSION['formmodepaiemente'][NUM_PAGE]["modepaiemente"]; ?>" onkeyup="this.value = this.value.toLowerCase();" style="text-transform: capitalize;" class="form-control" placeholder="" type="text" name="modepaiemente" id="modepaiemente" />
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

    <div class="col-md-3 col-sm-2 col-xs-1" ></div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        // Generate a simple captcha
        function randomNumber(min, max) {
            return Math.floor(Math.random() * (max - min + 1) + min);
        }
        ;
        $('#captchaOperation').html([randomNumber(1, 100), '+', randomNumber(1, 200), '='].join(' '));

        var idmodepaiement = document.getElementById('idmodepaiement').value;
//        alert(idmodepaiement);
        $('#edit_modepaiement').bootstrapValidator({
//        live: 'disabled',
            message: 'Cette valeur est invalide',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                codee: {
                    message: 'Nom du modepaiement invalide',
                    validators: {
                        notEmpty: {
                            message: 'Le nom de la modepaiement est obligatoire'
                        },
                        stringLength: {
                            min: 2,
                            message: 'Le nom de la modepaiement doit avoir au moins 2 characteres de long'
                        },
                        remote: {
                            type: 'POST',
                            data: {idmodepaiement: idmodepaiement},
                            dataType: 'json',
                            url: './hopitalpages/hopitalparametre/hopitalmodepaiement/remoteformvalidationmodepaiement.php',
                            message: 'Le nom doit etre unique'
                        }
                    }
                },
                modepaiemente: {
                    message: 'Nom du modepaiement invalide',
                    validators: {
                        notEmpty: {
                            message: 'Le nom de la modepaiement est obligatoire'
                        },
                        stringLength: {
                            min: 2,
                            message: 'Le nom de la modepaiement doit avoir au moins 2 characteres de long'
                        }
                    }
                },
                campuse: {
                    validators: {
                        notEmpty: {
                            message: 'Le campus de la modepaiement est obligatoire'
                        }
                    }
                }
            }
        });

        // Validate the form manually
//        $('#validateBtnpe').click(function () {
//            $('#edit_modepaiement').bootstrapValidator('validate');
//        });

//        $('#resetBtnpe').click(function () {
//            $('#edit_modepaiement').data('bootstrapValidator').resetForm(true);
//        });
    });
</script>
