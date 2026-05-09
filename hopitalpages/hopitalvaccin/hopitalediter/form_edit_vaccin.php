<script language="JavaScript">
    
</script>
<div class="single-product-tab-area mg-tb-15">
    <!-- Single pro tab review Start-->
    <div class="single-pro-review-area">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="sparkline12-list mt-b-30">
                        <div class="sparkline12-hd">
                            <div class="main-sparkline12-hd">
                                <h1>Modification d'un vaccin</h1>
                            </div>
                        </div>
                        <form id="ajout_vaccin" name="formvaccine" enctype="multipart/form-data" method="post" action="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalvaccin/hopitalediter/edit_vaccin'); ?>&idvaccin=<?php echo $_REQUEST["idvaccin"]; ?>&pagecom=<?php echo NUM_PAGE + 1; ?>" style="padding: 2%;">
                            <input value="<?php echo $_SESSION['formvaccine'][NUM_PAGE]["idvaccin"]; ?>" type="hidden" name="idvaccin" id="idvaccin" />
                            <div class="row">
                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <div class="chosen-select-single">
                                        <label class="control-label">Sexe <g style="color: red">*</g></label>
                                        <select data-placeholder="Choisissez un sexe..." class=" form-control" name="sexe" id="sexe" required>
                                            <option value="" selected="selected">- Choisissez un sexe-</option>
                                            <option value="Masculin" <?php if ($_SESSION['formvaccine'][NUM_PAGE]["sexe"] == "Masculin") { ?> selected <?php } ?>>Masculin</option>
                                            <option value="Féminin" <?php if ($_SESSION['formvaccine'][NUM_PAGE]["sexe"] == "Féminin") { ?> selected <?php } ?>>F&eacute;minin</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <div class="form-group">
                                        <label class="control-label">Nom &nbsp;<g style="color: red">*</g></label>
                                        <div class="inputGroupContainer">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                                <input value="<?php echo $_SESSION['formvaccine'][NUM_PAGE]["nom"]; ?>" class="form-control" placeholder=" " type="text" name="nom" id="nom" required />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <div class="form-group">
                                        <label class="control-label" >Date de naissance <g style="color: red">*</g></label>
                                        <div class="inputGroupContainer">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                                <input value="<?php echo $_SESSION['formvaccine'][NUM_PAGE]["datenais"]; ?>" class="form-control" placeholder="" type="date" name="datenais" id="datenais" required />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <div class="form-group">
                                        <label class="control-label">Quartier &nbsp;</label>
                                        <div class="inputGroupContainer">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                                <input value="<?php echo $_SESSION['formvaccine'][NUM_PAGE]["quartier"]; ?>" class="form-control" placeholder="" type="text" name="quartier" id="quartier" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <div class="form-group">
                                        <label class="control-label" >Nom parent </label>
                                        <div class="inputGroupContainer">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                                <input value="<?php echo $_SESSION['formvaccine'][NUM_PAGE]["nomparent"]; ?>" class="form-control" placeholder="" type="text" name="nomparent" id="nomparent" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <div class="form-group">
                                        <label class="control-label" >Contact <g style="color: red">*</g></label>
                                        <div class="inputGroupContainer">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                                <input value="<?php echo $_SESSION['formvaccine'][NUM_PAGE]["telc"]; ?>" class="form-control" placeholder="" type="text" name="telc" id="telc" />
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
                                            <center>
                                                <button id="validateBtn" type="submit" name="insvaccin" class="btn btn-success"><i class="glyphicon glyphicon-check"></i> Modifier</button>
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

        $('#ajout_vaccin').bootstrapValidator({
//        live: 'disabled',
            message: 'Cette valeur est invalide',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                nom: {
                    message: 'Nom de l\'vaccin invalide',
                    validators: {
                        notEmpty: {
                            message: 'Le nom de l\'vaccin est obligatoire'
                        }
                    }
                },
                role: {
                    message: 'Rôle de l\'vaccin invalide',
                    validators: {
                        notEmpty: {
                            message: 'Le Rôle de l\'vaccin est obligatoire'
                        }
                    }
                },
                login: {
                    message: 'Login de l\'vaccin invalide',
                    validators: {
                        notEmpty: {
                            message: 'Le login de l\'vaccin est obligatoire'
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
                            message: 'Le mot de passe de l\'vaccin est obligatoire'
                        },
                        identical: {
                            field: 'pass2'
                        }
//                        ,
//                        remote: {
//                            type: 'POST',
//                            url: './hopitalpages/hopitalvaccin/remoteformvalidationvaccin.php',
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
//                            url: './hopitalpages/hopitalvaccin/remoteformvalidationvaccin.php',
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
                    message: 'Téléphone de l\'vaccin invalide',
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
//        $('#ajout_vaccin').bootstrapValidator('validate');
//    });
//
//    $('#resetBtn').click(function() {
//        $('#ajout_vaccin').data('bootstrapValidator').resetForm(true);
//    });
    });

</script>
