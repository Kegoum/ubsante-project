
<div class="single-product-tab-area mg-tb-15">
    <!-- Single pro tab review Start-->
    <div class="single-pro-review-area">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="sparkline12-list mt-b-30">
                        <div class="sparkline12-hd">
                            <div class="main-sparkline12-hd">
                                <h1>Affectation <small> de <?php echo $row["prenompersonnel"]; ?> <?php echo $row["nompersonnel"]; ?> - <?php echo $row["codepersonnel"]; ?></small></h1>
                            </div>
                        </div>
                        <form id="affecter_personnel" name="formaffectation" enctype="multipart/form-data" method="post" action="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpersonnel/hopitalaffectation/affecter_personnel'); ?>&personnel=<?php echo $_REQUEST["personnel"]; ?>&pagecom=<?php echo NUM_PAGE + 1; ?>" style="padding: 2%;">

                            <input value="<?php echo $_SESSION['formaffectation'][NUM_PAGE]["idpersonnel"]; ?>" type="hidden" name="idpersonnel" id="idpersonnel" />

                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group" style="margin-left:15px;">
                                        <label class="control-label">Ancien R&ocirc;le</label>  
                                        <div class="inputGroupContainer">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                                <input value="<?php echo $_SESSION['formaffectation'][NUM_PAGE]["rolea"]; ?>" class="validate[required] text-input form-control" placeholder="" type="text" name="rolea" id="rolea" readonly />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group" style="margin-left:15px;">
                                        <label class="control-label" >Ancien Service</label> 
                                        <div class="inputGroupContainer">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                                <input value="<?php echo $_SESSION['formaffectation'][NUM_PAGE]["servicea"]; ?>" class="form-control" placeholder="" type="hidden" name="servicea" id="servicea" readonly />
                                                <input value="<?php echo $recuser["nomservice"]; ?>" class="form-control" placeholder="" type="text" name="servpaa" id="servpaa" readonly />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row ">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="control-label" >Nouveau R&ocirc;le &nbsp;<g style="color: red">*</g></label>
                                        <div class="inputGroupContainer">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>

                                                <select class="form-control" name="role" id="role">
                                                    <option value=""> - Choisissez un r&ocirc;le - </option>
                                                    <option value="Chef de Service" <?php if ($_SESSION['formaffectation'][NUM_PAGE]["role"] == "Chef de Service") { ?> selected <?php } ?>>Chef de Service</option>
                                                    <option value="Médecin" <?php if ($_SESSION['formaffectation'][NUM_PAGE]["role"] == "Médecin") { ?> selected <?php } ?>>M&eacute;decin</option>
                                                    <option value="Accueil" <?php if ($_SESSION['formaffectation'][NUM_PAGE]["role"] == "Accueil") { ?> selected <?php } ?>>Accueil</option>
                                                    <option value="Infirmier" <?php if ($_SESSION['formaffectation'][NUM_PAGE]["role"] == "Infirmier") { ?> selected <?php } ?>>Infirmier</option>
                                                    <option value="Caisse" <?php if ($_SESSION['formaffectation'][NUM_PAGE]["role"] == "Caisse") { ?> selected <?php } ?>>Caisse</option>
                                                    <option value="Laborantin" <?php if ($_SESSION['formaffectation'][NUM_PAGE]["role"] == "Laborantin") { ?> selected <?php } ?>>Laborantin</option>
                                                    <option value="Pharmacien" <?php if ($_SESSION['formaffectation'][NUM_PAGE]["role"] == "Pharmacien") { ?> selected <?php } ?>>Pharmacien</option>
                                                <option value="Echographe" <?php if ($_SESSION['formaffectation'][NUM_PAGE]["role"] == "Echographe") { ?> selected <?php } ?>>Echographe</option>
                                                    </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <div class="chosen-select-single">
                                        <label class="control-label">Nouveau Service </label>
                                        <?php
                                        $rsltbv = $con->query("select * from hp_service as d  "
                                                . "order by d.nomservice asc ") or die(mysqli_error($con));
                                        ?>
                                        <select data-placeholder="Choisissez un service..." class="select2_demo_3 form-control" name="service" id="service">
                                            <option value="" selected="selected">- Choisissez un service-</option>
                                            <?php
                                            /* Construction de la première liste : on se sert du tableau PHP */
                                            while ($rowr = mysqli_fetch_assoc($rsltbv)) {
                                                ?>
                                                <option value="<?php echo($rowr['idservice']); ?>" <?php if ($_SESSION['formaffectation'][NUM_PAGE]["service"] == $rowr["idservice"]) { ?> selected <?php } ?>><?php echo($rowr["nomservice"]); ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row ">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="control-label" >Salaire &nbsp;</label>
                                        <div class="inputGroupContainer">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                                <input value="<?php echo $_SESSION['formaffectation'][NUM_PAGE]["salaire"]; ?>" class="form-control" placeholder="" type="text" name="salaire" id="salaire" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="control-label" >Type de paiement &nbsp;</label>
                                        <div class="inputGroupContainer">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                                <select class="form-control" name="typepaiement" id="typepaiement">
                                                    <option value=""> - Choisissez un Type - </option>
                                                    <option value="Heure" <?php if ($_SESSION['formaffectation'][NUM_PAGE]["typepaiement"] == "Heure") { ?> selected <?php } ?>>Heure</option>
                                                    <option value="Jour" <?php if ($_SESSION['formaffectation'][NUM_PAGE]["typepaiement"] == "Jour") { ?> selected <?php } ?>>Jour</option>
                                                    <option value="Mois" <?php if ($_SESSION['formaffectation'][NUM_PAGE]["typepaiement"] == "Mois") { ?> selected <?php } ?>>Mois</option>
                                                </select>
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

        var idpersonnel = document.getElementById('idpersonnel').value;
        $('#affecter_personnel').bootstrapValidator({
//        live: 'disabled',
            message: 'Cette valeur est invalide',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                nome: {
                    message: 'Nom de l\'personnel invalide',
                    validators: {
                        notEmpty: {
                            message: 'Le nom de l\'personnel est obligatoire'
                        }
                    }
                },
                rolee: {
                    message: 'Rôle de l\'personnel invalide',
                    validators: {
                        notEmpty: {
                            message: 'Le Rôle de l\'personnel est obligatoire'
                        }
                    }
                },
                logine: {
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
                pass1e: {
                    validators: {
                        identical: {
                            field: 'pass2e'
                        }
//                        ,
//                        remote: {
//                            type: 'POST',
//                            url: './hopitalpages/hopitalpersonnel/remoteformvalidationpersonnel.php',
//                            // Send { username: 'its value', email: 'its value' } to the back-end
//                            data: function(validator) {
//                                return {
//                                    idpersonnel: validator.getFieldElements('idpersonnel').val(),
//                                    email: validator.getFieldElements('email').val()
//                                };
//                            },
//                            message: 'Le mot de passe est incorrect'
//                        }
                    }
                },
                pass2e: {
                    validators: {
                        identical: {
                            field: 'pass1e'
                        }
                    }
                },
                emaile: {
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
//                                    idpersonnel: validator.getFieldElements('idpersonnel').val(),
//                                    pass1e: validator.getFieldElements('pass1e').val()
//                                };
//                            },
//                            message: 'L\'Adresse mail est incorrecte'
//                        }
                    }
                },
                tele: {
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
//        $('#affecter_personnel').bootstrapValidator('validate');
//    });
//
//    $('#resetBtn').click(function() {
//        $('#affecter_personnel').data('bootstrapValidator').resetForm(true);
//    });
    });


</script>
