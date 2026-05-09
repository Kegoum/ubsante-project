<div class="row">
    <div class="col-md-3 col-sm-2 col-xs-1" ></div>
    <div class="col-md-6 col-sm-8 col-xs-10" >


        <!--***** BASIC FORM *****-->
        <div class="card form" id="form1">
            <div class="card-header">
                <h3>Formulaire d'ajout d'un Mode de paiement</h3>  

            </div>
            <br>
            <form id="ajout_modepaiement" name="formmodepaiement" enctype="multipart/form-data" method="post" action="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalparametre/hopitalmodepaiement/hopitalajouter/ajout_modepaiement'); ?>&pagecom=<?php echo NUM_PAGE + 1; ?>" style="padding: 2%;">

                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group" style="margin-left:15px;">
                            <label class="control-label" >Code mode paiement &nbsp;<g>*</g></label>
                            <div class="inputGroupContainer">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                    <input value="<?php echo $_SESSION['formmodepaiement'][NUM_PAGE]["code"]; ?>" onkeyup="this.value = this.value.toUpperCase();" class="form-control" placeholder="" type="text" name="code" id="code" />
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
                                    <input value="<?php echo $_SESSION['formmodepaiement'][NUM_PAGE]["modepaiement"]; ?>" onkeyup="this.value = this.value.toLowerCase();" style="text-transform: capitalize;" class="form-control" placeholder="" type="text" name="modepaiement" id="modepaiement" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class=" panel-footer">
                    <div class="row">
                        <br>
                        <div class="col-sm-12">
                            <b style="color: red">Champs Obligatoires *</b>
                        </div>
                        <br>
                        <div class="col-sm-12 text-center">
                            <center><button id="validateBtn" type="submit" name="insmodepaiement" class="btn btn-success"><i class="glyphicon glyphicon-check"></i> Enregistrer</button>
                                <button type="reset" id="resetBtn" class="btn btn-primary"><i class="glyphicon glyphicon-remove"></i> Effacer</button>
                                <a href="javascript:history.go(-1)" class="btn btn-primary"><i class="glyphicon glyphicon-backward"></i> Quitter</a>
                            </center><br>
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

        $('#ajout_modepaiement').bootstrapValidator({
//        live: 'disabled',
            message: 'Cette valeur est invalide',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok', invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                code: {
                    message: 'Code de la modepaiement invalide',
                    validators: {
                        notEmpty: {
                            message: 'Le code de la modepaiement est obligatoire'
                        },
                        stringLength: {
                            min: 2,
                            message: 'Le code de la modepaiement doit avoir au moins 2 characteres de long'
                        },
                        remote: {
                            type: 'POST',
                            url: './hopitalpages/hopitalparametre/hopitalmodepaiement/remoteformvalidationmodepaiement.php', message: 'Le code doit etre unique'
                        }
                    }
                },
                modepaiement: {
                    message: 'Nom de la modepaiement invalide',
                    validators: {
                        notEmpty: {
                            message: 'Le nom de la modepaiement est obligatoire'
                        }, stringLength: {
                            min: 2,
                            message: 'Le nom de la modepaiement doit avoir au moins 2 characteres de long'
                        }
                    }
                },
                campus: {
                    validators: {
                        notEmpty: {
                            message: 'Le campus est obligatoire'
                        }
                    }
                }
            }
        });

        // Validate the form manually
        //    $('#validateBtn').click(function() {
        //        $('#ajout_modepaiement').bootstrapValidator('validate');
//    });
//
        //    $('#resetBtn').click(function() {
        //        $('#ajout_modepaiement').data('bootstrapValidator').resetForm(true);
//    });
    });
</script>
