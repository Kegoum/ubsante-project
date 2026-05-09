
<div class="single-product-tab-area mg-tb-15">
    <!-- Single pro tab review Start-->
    <div class="single-pro-review-area">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="sparkline12-list mt-b-30">
                        <div class="sparkline12-hd">
                            <div class="main-sparkline12-hd">
                                <h1>Parametre Propri&eacute;taire</h1>
                            </div>
                        </div>
                        <form id="edit_proprietaire" name="formproprietaireep" enctype="multipart/form-data" method="post" action="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalparametre/hopitalproprietaire/edit_proprietaire'); ?>&pagecom=<?php echo NUM_PAGE + 1; ?>" style="padding: 2%;">

                            <div class="row">
                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <div class="form-group">
                                        <label class="control-label" >Entreprise &nbsp;<g style="color: red">*</g></label>
                                        <div class="inputGroupContainer">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                                <input value="<?php echo $_SESSION['formproprietaireep'][NUM_PAGE]["hopital"]; ?>" class="form-control" placeholder="" type="text" name="hopital" id="hopital" />
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
                            </div>
                            <div class="row">
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
                                <div class="col-md-8 col-sm-8 col-xs-8">
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6 col-xs-12">
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
                                        <div class="col-md-6 col-sm-6  col-xs-12">
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
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6  col-xs-12">
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
                                        <div class="col-md-6 col-sm-6  col-xs-12">
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
                                </div>
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
    $(document).ready(function () {
        // Generate a simple captcha
        function randomNumber(min, max) {
            return Math.floor(Math.random() * (max - min + 1) + min);
        }
        ;
        $('#captchaOperation').html([randomNumber(1, 100), '+', randomNumber(1, 200), '='].join(' '));

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
                    message: 'Nom du proprietaire invalide',
                    validators: {
                        notEmpty: {
                            message: 'Le nom du proprietaire est obligatoire'
                        }
                    }
                },
                hopital: {
                    message: 'Login de l\'proprietaire invalide',
                    validators: {
                        notEmpty: {
                            message: 'l\'Entreprise est obligatoire'
                        }
                    }
                },
                emaile: {
                    validators: {
                        emailAddress: {
                            message: 'Adresse mail invalide'
                        }
                    }
                },
                tele: {
                    message: 'Téléphone du proprietaire invalide',
                    validators: {
//                        regexp: {
//                            regexp: /^[0-9]+$/,
//                            message: 'Le Téléphone doit contenir seulement les chiffres'
//                        }
                    }
                },
                bp: {
                    message: 'Boite postale du proprietaire invalide',
                    validators: {
                        regexp: {
                            regexp: /^[0-9]+$/,
                            message: 'La Boite postale doit contenir seulement les chiffres'
                        }
                    }
                },
                photoe: {
                    validators: {
                        file: {
//                        extension: 'png',
//                        extension: {'png', 'PNG', 'jpeg', 'JPEG', 'gif', 'GIF'},
//                        extension: ('png', 'PNG', 'jpeg', 'JPEG', 'gif', 'GIF'),
//                        extension: ('png', 'JPEG'),
//                        maxSize: 5*1024*1024,
                            message: 'Veuillez choisir une taille inferieur à 5M'
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
