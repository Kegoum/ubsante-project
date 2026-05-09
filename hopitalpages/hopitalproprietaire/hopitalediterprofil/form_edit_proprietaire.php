
<div class="single-product-tab-area mg-tb-15">
    <!-- Single pro tab review Start-->
    <div class="single-pro-review-area">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="sparkline12-list mt-b-30">
                        <div class="sparkline12-hd">
                            <div class="main-sparkline12-hd">
                                <h1>Formulaire de modification du profil</h1>
                            </div>
                        </div>
                        <form id="edit_proprietaire" name="formproprietaireep" enctype="multipart/form-data" method="post" action="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalproprietaire/hopitalediterprofil/edit_proprietaire'); ?>&idproprietaire=<?php echo $_REQUEST["idproprietaire"]; ?>&pagecom=<?php echo NUM_PAGE + 1; ?>" style="padding: 2%;">

                            <input value="<?php echo $_SESSION['formproprietaireep'][NUM_PAGE]["idproprietaire"]; ?>" type="hidden" name="idproprietaire" id="idproprietaire" />

                            
                            <div class="row">
                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <div class="form-group">
                                        <label class="control-label" >Entreprise &nbsp;<g style="color: red">*</g></label>
                                        <div class="inputGroupContainer">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                                <input value="<?php echo $_SESSION['formproprietaireep'][NUM_PAGE]["hopital"]; ?>" class="form-control" placeholder="" type="text" name="hopital" id="hopital" required="" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <div class="form-group">
                                        <label class="control-label" >Aire sant&eacute; &nbsp;</label>
                                        <div class="inputGroupContainer">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                                <input value="<?php echo $_SESSION['formproprietaireep'][NUM_PAGE]["airesante"]; ?>" class="form-control" placeholder="" type="text" name="airesante" id="airesante" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <div class="form-group">
                                        <label class="control-label">Nom Propri&eacute;taire &nbsp;<g style="color: red">*</g></label>
                                        <div class="inputGroupContainer">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                                <input value="<?php echo $_SESSION['formproprietaireep'][NUM_PAGE]["nome"]; ?>" class="form-control" placeholder=" " type="text" name="nome" id="nome" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <div class="form-group">
                                        <label class="control-label">Type Entreprise &nbsp;</label>
                                        <div class="inputGroupContainer">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                                <input value="<?php echo $_SESSION['formproprietaireep'][NUM_PAGE]["typee"]; ?>" class="form-control" onkeyup="this.value = this.value.toLowerCase();" style="text-transform: capitalize;" placeholder="" type="text" name="typee" id="typee" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <div class="chosen-select-single">
                                        <label class="control-label">D&eacute;partement <g style="color: red">*</g></label>
                                        <?php
                                        $rsltbv = $con->query("select * from hp_departement as d left join hp_region as r on d.idregion=r.idregion "
                                                . "order by d.libelledepartement asc ") or die(mysqli_error($con));
                                        ?>
                                        <select data-placeholder="Choisissez un departement..." class="select2_demo_3 form-control" name="iddepartement" id="iddepartement" required>
                                            <option value="" selected="selected">- Choisissez un departement-</option>
                                            <?php
                                            /* Construction de la première liste : on se sert du tableau PHP */
                                            while ($rowr = mysqli_fetch_assoc($rsltbv)) {
                                                ?>
                                                <option value="<?php echo($rowr['iddepartement']); ?>" <?php if ($_SESSION['formproprietaireep'][NUM_PAGE]["iddepartement"] == $rowr["iddepartement"]) { ?> selected <?php } ?>><?php echo($rowr["libelledepartement"]); ?> - <?php echo($rowr["libelleregion"]); ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <div class="form-group">
                                        <label class="control-label">Arrondissement </label>
                                        <div class="inputGroupContainer">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                                <input value="<?php echo $_SESSION['formproprietaireep'][NUM_PAGE]["arrondissement"]; ?>" class="form-control" placeholder="" type="text" name="arrondissement" id="arrondissement" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <div class="form-group">
                                        <label class="control-label">District </label>
                                        <div class="inputGroupContainer">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                                <input value="<?php echo $_SESSION['formproprietaireep'][NUM_PAGE]["district"]; ?>" class="form-control" placeholder="" type="text" name="district" id="district" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <div class="form-group">
                                        <label class="control-label">Site web </label>
                                        <div class="inputGroupContainer">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                                <input value="<?php echo $_SESSION['formproprietaireep'][NUM_PAGE]["site"]; ?>" class="form-control" placeholder="" type="text" name="site" id="site" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <div class="form-group">
                                        <label class="control-label" >Boite Postale </label>
                                        <div class="inputGroupContainer">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                                <input value="<?php echo $_SESSION['formproprietaireep'][NUM_PAGE]["bp"]; ?>" class="form-control" placeholder="" type="text" name="bp" id="bp" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <div class="form-group">
                                        <label class="control-label" >Login &nbsp;<g style="color: red">*</g></label>
                                        <div class="inputGroupContainer">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                                <input value="<?php echo $_SESSION['formproprietaireep'][NUM_PAGE]["logine"]; ?>" class="form-control" placeholder="" type="text" name="logine" id="logine" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <div class="form-group">
                                        <label class="control-label">Mot de passe &nbsp;<g style="color: red">*</g></label>
                                        <div class="inputGroupContainer">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                                <input value="<?php echo $_SESSION['formproprietaireep'][NUM_PAGE]["motdepasse"]; ?>" class="form-control" placeholder=" " type="password" name="motdepasse" id="motdepasse" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <div class="form-group">
                                        <label class="control-label">Confirmer le Mot de passe &nbsp;<g style="color: red">*</g></label>
                                        <div class="inputGroupContainer">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                                <input value="<?php echo $_SESSION['formproprietaireep'][NUM_PAGE]["motdepasse2"]; ?>" class="form-control" placeholder=" " type="password" name="motdepasse2" id="motdepasse2" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                                    <div class="row">
                                        <div class="col-md-3 col-sm-3 col-xs-6">
                                            <div class="form-group">
                                                <label class="control-label" >T&eacute;l&eacute;phone&nbsp;</label>
                                                <div class="inputGroupContainer">
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                                        <input value="<?php echo $_SESSION['formproprietaireep'][NUM_PAGE]["tele"]; ?>" class="form-control" placeholder="" type="text" name="tele" id="tele" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-3 col-xs-6">
                                            <div class="form-group">
                                                <label class="control-label">E-Mail&nbsp;</label>
                                                <div class="inputGroupContainer">
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                                        <input value="<?php echo $_SESSION['formproprietaireep'][NUM_PAGE]["emaile"]; ?>" class="form-control" placeholder=" " type="text" name="emaile" id="emaile" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-3 col-xs-6">
                                            <div class="form-group">
                                                <label class="control-label" >Date cr&eacute;ation </label>
                                                <div class="inputGroupContainer">
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                                        <input value="<?php echo $_SESSION['formproprietaireep'][NUM_PAGE]["datecreation"]; ?>" class="form-control" placeholder="" type="date" name="datecreation" id="datecreation" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-3 col-xs-6">
                                            <div class="form-group">
                                                <label class="control-label" >N&deg; contribuable </label>
                                                <div class="inputGroupContainer">
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                                        <input value="<?php echo $_SESSION['formproprietaireep'][NUM_PAGE]["nocontribuable"]; ?>" class="form-control" placeholder="" type="text" name="nocontribuable" id="nocontribuable" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="control-label">Adresse &nbsp;</label>
                                        <div class="inputGroupContainer">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                                <input value="<?php echo $_SESSION['formproprietaireep'][NUM_PAGE]["adresse"]; ?>" class="form-control" placeholder="" type="text" name="adresse" id="adresse" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="control-label">Slogan &nbsp;</label>
                                        <div class="inputGroupContainer">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                                <input value="<?php echo $_SESSION['formproprietaireep'][NUM_PAGE]["slogan"]; ?>" class="form-control" placeholder="" type="text" name="slogan" id="slogan" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label class="control-label" >Texte &nbsp;</label>
                                        <div class="inputGroupContainer">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                                <input value="<?php echo $_SESSION['formproprietaireep'][NUM_PAGE]["texte"]; ?>" class="form-control" placeholder="" type="text" name="texte" id="textea" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
    <br>
 <fieldset class="space_data"><legend>LOGO ET FILIGRANNE (pour background des PDF selon les types de format)</legend>
    <div class="row">
        
                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <div class="form-group">
                                        <label>Logo :</label>
                                        <div class="fileupload fileupload-new" data-provides="fileupload">
                                            <input type="hidden" name="photostring" value="<?php echo $_SESSION['formproprietaireep'][NUM_PAGE]['photostring']; ?>">
                                            <img src="hopitalupload/logo/<?php echo $_SESSION['formproprietaireep'][NUM_PAGE]['photostring']; ?>" style="width: 20mm; height: 20mm;">
                                            <div class="fileupload-preview thumbnail" style="width: 90px; height: 95px;"></div>
                                            <div>
                                                <span class="btn btn-file btn-primary"><span class="fileupload-new">Sélectionner une image</span>
                                                    <span class="fileupload-exists">Changer</span><input type="file" name="photoe" id="photoe" /></span>
                                                <a href="#" class="btn btn-primary fileupload-exists" data-dismiss="fileupload">Supprimer</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
        
                                <div class="col-md-2 col-sm-2 col-xs-12">
                                    <div class="form-group">
                                        <label>Filigrane A5 Portrait :</label>
                                        <div class="fileupload fileupload-new" data-provides="fileupload">
                                            <input type="hidden" name="filigranea5pa" value="<?php echo $_SESSION['formproprietaireep'][NUM_PAGE]['filigranea5pa']; ?>">
                                            <img src="hopitalupload/logo/<?php echo $_SESSION['formproprietaireep'][NUM_PAGE]['filigranea5pa']; ?>" style="width: 20mm; height: 20mm;">
                                            <div class="fileupload-preview thumbnail" style="width: 90px; height: 95px;"></div>
                                            <div>
                                                <span class="btn btn-file btn-primary"><span class="fileupload-new">Sélectionner une image</span>
                                                    <span class="fileupload-exists">Changer</span><input type="file" name="filigranea5pn" id="filigranea5pn" /></span>
                                                <a href="#" class="btn btn-primary fileupload-exists" data-dismiss="fileupload">Supprimer</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2 col-sm-2 col-xs-12">
                                    <div class="form-group">
                                        <label>Filigrane A5 Payisage :</label>
                                        <div class="fileupload fileupload-new" data-provides="fileupload">
                                            <input type="hidden" name="filigranea5la" value="<?php echo $_SESSION['formproprietaireep'][NUM_PAGE]['filigranea5la']; ?>">
                                            <img src="hopitalupload/logo/<?php echo $_SESSION['formproprietaireep'][NUM_PAGE]['filigranea5la']; ?>" style="width: 20mm; height: 20mm;">
                                            <div class="fileupload-preview thumbnail" style="width: 90px; height: 95px;"></div>
                                            <div>
                                                <span class="btn btn-file btn-primary"><span class="fileupload-new">Sélectionner une image</span>
                                                    <span class="fileupload-exists">Changer</span><input type="file" name="filigranea5ln" id="filigranea5ln" /></span>
                                                <a href="#" class="btn btn-primary fileupload-exists" data-dismiss="fileupload">Supprimer</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2 col-sm-2 col-xs-12">
                                    <div class="form-group">
                                        <label>Filigrane A4 Portrait :</label>
                                        <div class="fileupload fileupload-new" data-provides="fileupload">
                                            <input type="hidden" name="filigranea4pa" value="<?php echo $_SESSION['formproprietaireep'][NUM_PAGE]['filigranea4pa']; ?>">
                                            <img src="hopitalupload/logo/<?php echo $_SESSION['formproprietaireep'][NUM_PAGE]['filigranea4pa']; ?>" style="width: 20mm; height: 20mm;">
                                            <div class="fileupload-preview thumbnail" style="width: 90px; height: 95px;"></div>
                                            <div>
                                                <span class="btn btn-file btn-primary"><span class="fileupload-new">Sélectionner une image</span>
                                                    <span class="fileupload-exists">Changer</span><input type="file" name="filigranea4pn" id="filigranea4pn" /></span>
                                                <a href="#" class="btn btn-primary fileupload-exists" data-dismiss="fileupload">Supprimer</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2 col-sm-2 col-xs-12">
                                    <div class="form-group">
                                        <label>Filigrane A4 Payisage :</label>
                                        <div class="fileupload fileupload-new" data-provides="fileupload">
                                            <input type="hidden" name="filigranea4la" value="<?php echo $_SESSION['formproprietaireep'][NUM_PAGE]['filigranea4la']; ?>">
                                            <img src="hopitalupload/logo/<?php echo $_SESSION['formproprietaireep'][NUM_PAGE]['filigranea4la']; ?>" style="width: 20mm; height: 20mm;">
                                            <div class="fileupload-preview thumbnail" style="width: 90px; height: 95px;"></div>
                                            <div>
                                                <span class="btn btn-file btn-primary"><span class="fileupload-new">Sélectionner une image</span>
                                                    <span class="fileupload-exists">Changer</span><input type="file" name="filigranea4ln" id="filigranea4ln" /></span>
                                                <a href="#" class="btn btn-primary fileupload-exists" data-dismiss="fileupload">Supprimer</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
    </div>
</fieldset>
                            <div class="row">
                                <div class=" panel-footer">
                                    <div class="row">
                                        <br>
                                        <div class="col-sm-12">
                                            <b style="color: red">Champs Obligatoires *</b>
                                        </div>
                                        <br>
                                        <div class="col-sm-12 text-center">
                                            <center><button id="validateBtn" type="submit" name="insproprietaire" class="btn btn-success"><i class="glyphicon glyphicon-check"></i> Enregistrer</button>
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

        var idproprietaire = document.getElementById('idproprietaire').value;
        $('#edit_proprietaire').bootstrapValidator({
//        live: 'disabled',
            message: 'Cette valeur est invalide',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                nome: {
                    message: 'Nom de l\'proprietaire invalide',
                    validators: {
                        notEmpty: {
                            message: 'Le nom de l\'proprietaire est obligatoire'
                        }
                    }
                },
                logine: {
                    message: 'Login de l\'proprietaire invalide',
                    validators: {
                        notEmpty: {
                            message: 'Le login de l\'proprietaire est obligatoire'
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
//                            url: './hopitalpages/hopitalproprietaire/remoteformvalidationproprietaire.php',
//                            // Send { username: 'its value', email: 'its value' } to the back-end
//                            data: function(validator) {
//                                return {
//                                    idproprietaire: validator.getFieldElements('idproprietaire').val(),
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
//                            url: './hopitalpages/hopitalproprietaire/remoteformvalidationproprietaire.php',
//                            // Send { username: 'its value', email: 'its value' } to the back-end
//                            data: function(validator) {
//                                return {
//                                    idproprietaire: validator.getFieldElements('idproprietaire').val(),
//                                    pass1e: validator.getFieldElements('pass1e').val()
//                                };
//                            },
//                            message: 'L\'Adresse mail est incorrecte'
//                        }
                    }
                },
                tele: {
                    message: 'Téléphone de l\'proprietaire invalide',
                    validators: {
                        regexp: {
                            regexp: /^[0-9 \]+$/,
                            message: 'Le Téléphone doit contenir seulement les chiffres'
                        }
                    }
                }
            }
        });

        // Validate the form manually
//    $('#validateBtn').click(function() {
//        $('#edit_proprietaire').bootstrapValidator('validate');
//    });
//
//    $('#resetBtn').click(function() {
//        $('#edit_proprietaire').data('bootstrapValidator').resetForm(true);
//    });
    });
</script>
