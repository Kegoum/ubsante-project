
<div class="single-product-tab-area mg-tb-15">
    <!-- Single pro tab review Start-->
    <div class="single-pro-review-area">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="sparkline12-list mt-b-30">
                        <div class="sparkline12-hd">
                            <div class="main-sparkline12-hd">
                                <h1>Formulaire d'ajout d'une Consultation</h1>
                            </div>
                        </div>
                        <form id="ajout_grilleprix" name="formgrilleprix" enctype="multipart/form-data" method="post" action="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalparametre/hopitalgrilleprix/hopitalajouter/ajout_grilleprix'); ?>&pagecom=<?php echo NUM_PAGE + 1; ?>" style="padding: 2%;">

                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group" style="margin-left:15px;">
                                        <label class="control-label">D&eacute;signation <g style="color: red">*</g></label>
                                        <div class="inputGroupContainer">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                                <input value="<?php echo $_SESSION['formgrilleprix'][NUM_PAGE]["designationp"]; ?>" class="form-control" placeholder=" " type="text" name="designationp" id="designationp" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="chosen-select-single">
                                        <label class="control-label">Type <g style="color: red">*</g></label>
                                        <select data-placeholder="Choisissez un Type..." class="select2_demo_3 form-control" name="type" id="type" required>
                                            <option value="" selected="selected">- Choisissez un Type-</option>
                                            <option value="Généraliste" <?php if ($_SESSION['formgrilleprix'][NUM_PAGE]["type"] == "Généraliste") { ?> selected <?php } ?>>Généraliste</option>
                                            <option value="Spécialiste" <?php if ($_SESSION['formgrilleprix'][NUM_PAGE]["type"] == "Spécialiste") { ?> selected <?php } ?>>Spécialiste</option>
                                            <option value="Vaccination" <?php if ($_SESSION['formgrilleprix'][NUM_PAGE]["type"] == "Vaccination") { ?> selected <?php } ?>>Vaccination</option>
                                            <option value="Prénatale" <?php if ($_SESSION['formgrilleprix'][NUM_PAGE]["type"] == "Prénatale") { ?> selected <?php } ?>>Prénatale</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="chosen-select-single">
                                        <label class="control-label">Acte </label>
                                        <?php
                                        $rsltbv = $con->query("select * from hp_acte as d  "
                                                . "where d.etatacte=true order by d.libelleacte asc ") or die(mysqli_error($con));
                                        ?>
                                        <select data-placeholder="Choisissez un Acte..." class="select2_demo_3 form-control" name="acte" id="acte">
                                            <option value="" selected="selected">- Choisissez un Acte -</option>
                                            <?php
                                            /* Construction de la première liste : on se sert du tableau PHP */
                                            while ($rowr = mysqli_fetch_assoc($rsltbv)) {
                                                ?>
                                                <option value="<?php echo($rowr['idacte']); ?>" <?php if ($_SESSION['formgrilleprix'][NUM_PAGE]["acte"] == $rowr["idacte"]) { ?> selected <?php } ?>><?php echo($rowr["libelleacte"]); ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group" style="margin-left:15px;">
                                        <label class="control-label" >Montant </label>
                                        <div class="inputGroupContainer">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                                <input value="<?php echo $_SESSION['formgrilleprix'][NUM_PAGE]["montant"]; ?>" class="form-control" placeholder="" type="text" name="montant" id="montant" />
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
                                        <center><button id="validateBtn" type="submit" name="insgrilleprix" class="btn btn-success"><i class="glyphicon glyphicon-check"></i> Enregistrer</button>
                                            <button type="reset" id="resetBtn" class="btn btn-primary"><i class="glyphicon glyphicon-remove"></i> Effacer</button>
                                            <a href="javascript:history.go(-1)" class="btn btn-primary"><i class="glyphicon glyphicon-backward"></i> Quitter</a>
                                        </center><br>
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

        $('#ajout_grilleprix').bootstrapValidator({
//        live: 'disabled',
            message: 'Cette valeur est invalide',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                designationp: {
                    message: 'Désignation invalide',
                    validators: {
                        notEmpty: {
                            message: 'La Désignation est obligatoire'
                        },
                        remote: {
                            type: 'POST',
                            url: './hopitalpages/hopitalparametre/hopitalgrilleprix/remoteformvalidationgrilleprix.php',
                            message: 'Le code doit etre unique'
                        }
                    }
                },
                type: {
                    validators: {
                        notEmpty: {
                            message: 'Le type est obligatoire'
                        }
                    }
                },
                categorie: {
                    validators: {
                        notEmpty: {
                            message: 'La catégorie est obligatoire'
                        }
                    }
                }
            }
        });

        // Validate the form manually
//    $('#validateBtn').click(function() {
//        $('#ajout_grilleprix').bootstrapValidator('validate');
//    });
//
//    $('#resetBtn').click(function() {
//        $('#ajout_grilleprix').data('bootstrapValidator').resetForm(true);
//    });
    });
</script>
