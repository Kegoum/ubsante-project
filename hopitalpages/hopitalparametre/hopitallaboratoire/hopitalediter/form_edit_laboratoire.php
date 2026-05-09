
<div class="single-product-tab-area mg-tb-15">
    <!-- Single pro tab review Start-->
    <div class="single-pro-review-area">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="sparkline12-list mt-b-30">
                        <div class="sparkline12-hd">
                            <div class="main-sparkline12-hd">
                                <h1>Formulaire de modification d'un Laboratoire</h1>
                            </div>
                        </div>
                        <form id="edit_laboratoire" name="formlaboratoiree" enctype="multipart/form-data" method="post" action="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalparametre/hopitallaboratoire/hopitalediter/edit_laboratoire'); ?>&pagecom=<?php echo NUM_PAGE + 1; ?>&idlaboratoire=<?php echo $_REQUEST["idlaboratoire"]; ?>" style="padding: 2%;">

                            <input value="<?php echo $_SESSION['formlaboratoiree'][NUM_PAGE]["idlaboratoire"]; ?>" type="hidden" name="idlaboratoire" id="idlaboratoire" />

                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="chosen-select-single">
                                        <label class="control-label">Service </label>
                                        <?php
                                        $rsltbv = $con->query("select * from hp_service as d  "
                                                . "order by d.nomservice asc ") or die(mysqli_error($con));
                                        ?>
                                        <select data-placeholder="Choisissez un Service..." class="select2_demo_3 form-control" name="service" id="service">
                                            <option value="" selected="selected">- Choisissez un Service-</option>
                                            <?php
                                            /* Construction de la première liste : on se sert du tableau PHP */
                                            while ($rowr = mysqli_fetch_assoc($rsltbv)) {
                                                ?>
                                                <option value="<?php echo($rowr['idservice']); ?>" <?php if ($_SESSION['formlaboratoiree'][NUM_PAGE]["service"] == $rowr["idservice"]) { ?> selected <?php } ?>><?php echo($rowr["nomservice"]); ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group" style="margin-left:15px;">
                                        <label class="control-label">Code&nbsp;<g style="color: red">*</g></label>
                                        <div class="inputGroupContainer">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                                <input value="<?php echo $_SESSION['formlaboratoiree'][NUM_PAGE]["codepe"]; ?>" onkeyup="this.value = this.value.toUpperCase();" class="form-control" placeholder=" " type="text" name="codepe" id="codepe" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group" style="margin-left:15px;">
                                        <label class="control-label" >Nom <g style="color: red">*</g></label>
                                        <div class="inputGroupContainer">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                                <input value="<?php echo $_SESSION['formlaboratoiree'][NUM_PAGE]["laboratoiree"]; ?>" onkeyup="this.value = this.value.toLowerCase();" style="text-transform: capitalize;" class="form-control" placeholder="" type="text" name="laboratoiree" id="laboratoiree" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group" style="margin-left:15px;">
                                        <label class="control-label" >But </label>
                                        <div class="inputGroupContainer">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                                <input value="<?php echo $_SESSION['formlaboratoiree'][NUM_PAGE]["but"]; ?>" class="form-control" placeholder="" type="text" name="but" id="but" />
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

        var idlaboratoire = document.getElementById('idlaboratoire').value;
//        alert(idlaboratoire);
        $('#edit_laboratoire').bootstrapValidator({
//        live: 'disabled',
            message: 'Cette valeur est invalide',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                codepe: {
                    message: 'Code du laboratoire invalide',
                    validators: {
                        notEmpty: {
                            message: 'Le code du laboratoire est obligatoire'
                        },
                        stringLength: {
                            min: 1,
                            max: 5,
                            message: 'Le code du laboratoire doit etre entre 1 et 5 characteres de long'
                        },
                        regexp: {
                            regexp: /^[a-zA-Z0-9]+$/,
                            message: 'Le code du laboratoire peut contenir seulement les lettres de l\'alphabet et les chiffres'
                        },
                        remote: {
                            type: 'POST',
                            data: {idlaboratoire: idlaboratoire},
                            dataType: 'json',
                            url: './hopitalpages/hopitalparametre/hopitallaboratoire/remoteformvalidationlaboratoire.php',
                            message: 'Le code doit etre unique'
                        }
                    }
                },
                laboratoiree: {
                    validators: {
                        notEmpty: {
                            message: 'Le nom du laboratoire est obligatoire'
                        }
                    }
                }
            }
        });

        // Validate the form manually
//        $('#validateBtnpe').click(function () {
//            $('#edit_laboratoire').bootstrapValidator('validate');
//        });
//
//        $('#resetBtnpe').click(function () {
//            $('#edit_laboratoire').data('bootstrapValidator').resetForm(true);
//        });
    });
</script>
