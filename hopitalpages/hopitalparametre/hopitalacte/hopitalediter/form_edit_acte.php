
<div class="single-product-tab-area mg-tb-15">
    <!-- Single pro tab review Start-->
    <div class="single-pro-review-area">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="sparkline12-list mt-b-30">
                        <div class="sparkline12-hd">
                            <div class="main-sparkline12-hd">
                                <h1>Formulaire de modification d'un Acte</h1>
                            </div>
                        </div>
                        <form id="edit_acte" name="formactee" enctype="multipart/form-data" method="post" action="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalparametre/hopitalacte/hopitalediter/edit_acte'); ?>&pagecom=<?php echo NUM_PAGE + 1; ?>&idacte=<?php echo $_REQUEST["idacte"]; ?>" style="padding: 2%;">

                            <input value="<?php echo $_SESSION['formactee'][NUM_PAGE]["idacte"]; ?>" type="hidden" name="idacte" id="idacte" />
                            
                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group" style="margin-left:15px;">
                                        <label class="control-label">Code <g style="color: red">*</g></label>
                                        <div class="inputGroupContainer">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                                <input value="<?php echo $_SESSION['formactee'][NUM_PAGE]["codee"]; ?>" class="form-control" placeholder=" " type="text" name="codee" id="code" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group" style="margin-left:15px;">
                                        <label class="control-label">D&eacute;signation <g style="color: red">*</g></label>
                                        <div class="inputGroupContainer">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                                <input value="<?php echo $_SESSION['formactee'][NUM_PAGE]["designationpe"]; ?>" class="form-control" placeholder=" " type="text" name="designationpe" id="designationp" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3 col-sm-3 col-xs-6">
                                    <div class="chosen-select-single">
                                        <label class="control-label">Service </label>
                                        <?php
                                        $rsltbv = $con->query("select * from hp_service as d where d.etatservice=true "
                                                . "order by d.nomservice asc ") or die(mysqli_error($con));
                                        ?>
                                        <select data-placeholder="Choisissez un Service..." class="select2_demo_3 form-control" name="service" id="service">
                                            <option value="" selected="selected">- Choisissez un Service-</option>
                                            <?php
                                            /* Construction de la première liste : on se sert du tableau PHP */
                                            while ($rowr = mysqli_fetch_assoc($rsltbv)) {
                                                ?>
                                                <option value="<?php echo($rowr['idservice']); ?>" <?php if ($_SESSION['formactee'][NUM_PAGE]["service"] == $rowr["idservice"]) { ?> selected <?php } ?>><?php echo($rowr["nomservice"]); ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                               <div class="col-md-3 col-sm-3 col-xs-6">
                                    <div class="chosen-select-single">
                                        <label class="control-label">Type <g style="color: red">*</g></label>
                                        <select data-placeholder="Choisissez un Type..." class="select2_demo_3 form-control" name="typee" id="type" required>
                                            <option value="" selected="selected">- Choisissez un Type-</option>
                                            <option value="Simple" <?php if ($_SESSION['formactee'][NUM_PAGE]["typee"] == "Simple") { ?> selected <?php } ?>>Simple</option>
                                            <option value="Médical" <?php if ($_SESSION['formactee'][NUM_PAGE]["typee"] == "Médical") { ?> selected <?php } ?>>Médical</option>
                                        </select>
                                    </div>
                                </div>
                               <div class="col-md-3 col-sm-3 col-xs-6">
                                    <div class="chosen-select-single">
                                        <label class="control-label">Cat&eacute;gorie <g style="color: red">*</g></label>
                                        <select data-placeholder="Choisissez une Cat&eacute;gorie..." class="select2_demo_3 form-control" name="categoriee" id="categorie" required>
                                            <option value="" selected="selected">- Choisissez une Cat&eacute;gorie-</option>
                                            <option value="Accouchement" <?php if ($_SESSION['formactee'][NUM_PAGE]["categoriee"] == "Accouchement") { ?> selected <?php } ?>>Accouchement</option>
                                            <option value="Consultation" <?php if ($_SESSION['formactee'][NUM_PAGE]["categoriee"] == "Consultation") { ?> selected <?php } ?>>Consultation</option>
                                            <option value="Consultation Prénatale" <?php if ($_SESSION['formactee'][NUM_PAGE]["categoriee"] == "Consultation Prénatale") { ?> selected <?php } ?>>Consultation Pr&eacute;natale</option>
                                            <option value="Circoncision" <?php if ($_SESSION['formactee'][NUM_PAGE]["categoriee"] == "Circoncision") { ?> selected <?php } ?>>Circoncision</option>
                                            <option value="Echographie" <?php if ($_SESSION['formactee'][NUM_PAGE]["categoriee"] == "Echographie") { ?> selected <?php } ?>>Echographie</option>
                                            <option value="Episiotomie" <?php if ($_SESSION['formactee'][NUM_PAGE]["categoriee"] == "Episiotomie") { ?> selected <?php } ?>>Episiotomie</option>
                                            <option value="Hospitalisation" <?php if ($_SESSION['formactee'][NUM_PAGE]["categoriee"] == "Hospitalisation") { ?> selected <?php } ?>>Hospitalisation</option>
                                            <option value="Incision" <?php if ($_SESSION['formactee'][NUM_PAGE]["categoriee"] == "Incision") { ?> selected <?php } ?>>Incision</option>
                                            <option value="Infiltration" <?php if ($_SESSION['formactee'][NUM_PAGE]["categoriee"] == "Infiltration") { ?> selected <?php } ?>>Infiltration</option>
                                            <option value="Injection" <?php if ($_SESSION['formactee'][NUM_PAGE]["categoriee"] == "Injection") { ?> selected <?php } ?>>Injection</option>
                                            <option value="Mise En Observation" <?php if ($_SESSION['formactee'][NUM_PAGE]["categoriee"] == "Mise En Observation") { ?> selected <?php } ?>>Mise En Observation</option>
                                            <option value="Pancement" <?php if ($_SESSION['formactee'][NUM_PAGE]["categoriee"] == "Pancement") { ?> selected <?php } ?>>Pancement</option>
                                            <option value="Ponction" <?php if ($_SESSION['formactee'][NUM_PAGE]["categoriee"] == "Ponction") { ?> selected <?php } ?>>Ponction</option>
                                            <option value="Soins" <?php if ($_SESSION['formactee'][NUM_PAGE]["categoriee"] == "Soins") { ?> selected <?php } ?>>Soins</option>
                                            <option value="Vaccination" <?php if ($_SESSION['formactee'][NUM_PAGE]["categoriee"] == "Vaccination") { ?> selected <?php } ?>>Vaccination</option>
                                            <option value="Autre" <?php if ($_SESSION['formactee'][NUM_PAGE]["categoriee"] == "Autre") { ?> selected <?php } ?>>Autre</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-3 col-xs-6">
                                    <div class="form-group" style="margin-left:15px;">
                                        <label class="control-label" >Montant </label>
                                        <div class="inputGroupContainer">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                                <input value="<?php echo $_SESSION['formactee'][NUM_PAGE]["montant"]; ?>" class="form-control" placeholder="" type="text" name="montant" id="montant" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="chosen-select-single">
                                        <label class="control-label">Description </label>
                                        <textarea class="form-control" name="descriptione" id="description"><?php echo ($_SESSION['formactee'][NUM_PAGE]["descriptione"]); ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <br>
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

        var idacte = document.getElementById('idacte').value;
//        alert(idacte);
        $('#edit_acte').bootstrapValidator({
//        live: 'disabled',
            message: 'Cette valeur est invalide',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                designationpe: {
                    message: 'Désignation invalide',
                    validators: {
                        notEmpty: {
                            message: 'La Désignation est obligatoire'
                        },
                        remote: {
                            type: 'POST',
                            data: {idacte: idacte},
                            dataType: 'json',
                            url: './hopitalpages/hopitalparametre/hopitalacte/remoteformvalidationacte.php',
                            message: 'Le code doit etre unique'
                        }
                    }
                },
                typee: {
                    validators: {
                        notEmpty: {
                            message: 'Le type est obligatoire'
                        }
                    }
                },
                service: {
                    validators: {
                        notEmpty: {
                            message: 'Le service est obligatoire'
                        }
                    }
                }
            }
        });

        // Validate the form manually
//        $('#validateBtnpe').click(function () {
//            $('#edit_acte').bootstrapValidator('validate');
//        });
//
//        $('#resetBtnpe').click(function () {
//            $('#edit_acte').data('bootstrapValidator').resetForm(true);
//        });
    });
</script>
