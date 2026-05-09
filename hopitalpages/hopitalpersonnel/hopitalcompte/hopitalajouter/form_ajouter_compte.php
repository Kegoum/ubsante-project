
<div class="single-product-tab-area mg-tb-15">
    <!-- Single pro tab review Start-->
    <div class="single-pro-review-area">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="sparkline12-list mt-b-30">
                        <div class="sparkline12-hd">
                            <div class="main-sparkline12-hd">
                                <h1>Association d'un Compte <small> &agrave; <?php echo $row["nompersonnel"] ?>  <?php echo $row["prenompersonnel"] ?></h1>
                            </div>
                        </div>
                        <form id="ajout_compte" name="formcomptepersonnel" enctype="multipart/form-data" method="post" action="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpersonnel/hopitalcompte/hopitalajouter/ajout_compte'); ?>&personnel=<?php echo $_REQUEST["personnel"]; ?>&pagecom=<?php echo NUM_PAGE + 1; ?>" style="padding: 2%;">

                            <div class="row ">
                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <div class="form-group" style="margin-left:15px;">
                                        <label class="control-label">Login</label>  
                                        <div class="inputGroupContainer">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-log-in"></i></span>
                                                <input name="loginp" placeholder="Login" class="form-control" type="text">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row ">
                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <div class="form-group" style="margin-left:15px;">
                                        <label class="control-label">Mot de passe</label>  
                                        <div class="inputGroupContainer">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-globe"></i></span>
                                                <input name="pas1" placeholder="Mot de passe" class="text-input form-control" type="password" id="pas1">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <div class="form-group" style="margin-left:15px;">
                                        <label class="control-label">Confirmer le mot de passe</label>  
                                        <div class="inputGroupContainer">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-file"></i></span>
                                                <input name="pas2" placeholder="Confirmer le mot de passe" class="form-control" type="password" id="pas2">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class=" panel-footer">
                                    <div class="row">
                                        <br>
                                        <div class="col-sm-12">
                                            <b style="color: red">Champs Obligatoires *</b>
                                        </div>
                                        <br>
                                        <div class="col-sm-12 text-center">
                                            <center><button id="validateBtn" type="submit" name="inspersonnel" class="btn btn-success"><i class="glyphicon glyphicon-check"></i> Enregistrer</button>
                                                <button type="reset" id="resetBtn" class="btn btn-primary"><i class="glyphicon glyphicon-remove"></i> Effacer</button>
                                                <a href="javascript:history.go(-1)" class="btn btn-primary"><i class="glyphicon glyphicon-backward"></i> Quitter</a>
                                            </center><br>
                                        </div>
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

        $('#ajout_compte').bootstrapValidator({
//        live: 'disabled',
            message: 'Cette valeur est invalide',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                nom: {
                    message: 'Nom de l\'personnel invalide',
                    validators: {
                        notEmpty: {
                            message: 'Le nom de l\'personnel est obligatoire'
                        }
                    }
                },
                role: {
                    message: 'Rôle de l\'personnel invalide',
                    validators: {
                        notEmpty: {
                            message: 'Le Rôle de l\'personnel est obligatoire'
                        }
                    }
                },
                login: {
                    message: 'Login de l\'personnel invalide',
                    validators: {
                        notEmpty: {
                            message: 'Le login de l\'personnel est obligatoire'
                        },
                        regexp: {
                            regexp: /^[a-zA-Z0-9_\.]+$/,
                            message: 'Le login doit contenir seulement les lettres de l\'alphabet, les chiffres, le point and la barre de 8(_)'
                        }
                    }
                },
                pass1: {
                    validators: {
                        notEmpty: {
                            message: 'Le mot de passe du personnel est obligatoire'
                        },
                        identical: {
                            field: 'pass2'
                        }
//                        ,
//                        remote: {
//                            type: 'POST',
//                            url: './hopitalpages/hopitalpersonnel/remoteformvalidationpersonnel.php',
//                            // Send { username: 'its value', email: 'its value' } to the back-end
//                            data: function(validator) {
//                                return {
//                                    email: validator.getFieldElements('email').val()
//                                };
//                            },
//                            message: 'Le mot de passe est incorrect'
//                        }
                    }
                },
                pass2: {
                    validators: {
                        identical: {
                            field: 'pass1'
                        }
                    }
                },
                email: {
                    validators: {
                        notEmpty: {
                            message: 'L\'Adresse mail est obligatoire'
                        },
                        emailAddress: {
                            message: 'Adresse mail invalide'
                        }
//                        ,
//                        remote: {
//                            type: 'POST',
//                            url: './hopitalpages/hopitalpersonnel/remoteformvalidationpersonnel.php',
//                            // Send { username: 'its value', email: 'its value' } to the back-end
//                            data: function(validator) {
//                                return {
//                                    pass1: validator.getFieldElements('pass1').val()
//                                };
//                            },
//                            message: 'L\'Adresse mail est incorrecte'
//                        }
                    }
                },
                tel: {
                    message: 'Téléphone de l\'personnel invalide',
                    validators: {
                        regexp: {
                            regexp: /^[0-9]+$/,
                            message: 'Le Téléphone doit contenir seulement les chiffres'
                        }
                    }
                }
            }
        });

        // Validate the form manually
//    $('#validateBtn').click(function() {
//        $('#ajout_compte').bootstrapValidator('validate');
//    });
//
//    $('#resetBtn').click(function() {
//        $('#ajout_compte').data('bootstrapValidator').resetForm(true);
//    });
    });


    $(document).ready(function() {
        $("#role").change(function() {
            var chaine = $(this).val();
            choixRole(chaine);
        });
    });
    function raz(liste)
    {
        d = document.formcomptepersonnel.elements[liste].length;
        for (t = d; t >= 1; t--)
            document.formcomptepersonnel.elements[liste].options[t] = null;
    }

    $(document).ready(function() {
        $("#villec").change(function() {
            var moid = $(this).val();
            raz("communec");
            $.ajax({
                url: './hopitalpages/hopitalpersonnel/getcommune.php',
                type: 'post',
                data: {ma: moid},
                dataType: 'json',
                success: function(response) {
                    var len = response.length;
                    for (var i = 0; i < len; i++) {
                        var id = response[i]['ide'];
                        var lib = response[i]['libe'];
                        var servi = lib.replace(/&#039;/gi, "\'");
                        new_options = new Option(servi, id);
                        document.formcomptepersonnel.elements["communec"].options[document.formcomptepersonnel.elements["communec"].length] = new_options;

                    }
                }
            });
        });
    });

</script>
