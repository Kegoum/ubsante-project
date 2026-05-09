
<div class="single-product-tab-area mg-tb-15">
    <!-- Single pro tab review Start-->
    <div class="single-pro-review-area">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="sparkline12-list mt-b-30">
                        <div class="sparkline12-hd">
                            <div class="main-sparkline12-hd">
                                <h1>Formulaire d'ajout d'un Examen</h1>
                            </div>
                        </div>
                        <form id="ajout_examen" name="formexamen" enctype="multipart/form-data" method="post" action="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalparametre/hopitalexamen/hopitalajouter/ajout_examen'); ?>&pagecom=<?php echo NUM_PAGE + 1; ?>" style="padding: 2%;">

                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="chosen-select-single">
                                        <label class="control-label">Laboratoire </label>
                                        <?php
                                        $rsltbv = $con->query("select * from hp_laboratoire as l left join hp_service as s on l.idservice=s.idservice  "
                                                . "order by l.nomlaboratoire asc ") or die(mysqli_error($con));
                                        ?>
                                        <select data-placeholder="Choisissez un Laboratoire..." class="select2_demo_3 form-control" name="laboratoire" id="laboratoire">
                                            <option value="" selected="selected">- Choisissez un Laboratoire-</option>
                                            <?php
                                            /* Construction de la première liste : on se sert du tableau PHP */
                                            while ($rowr = mysqli_fetch_assoc($rsltbv)) {
                                                ?>
                                                <option value="<?php echo($rowr['idlaboratoire']); ?>" <?php if ($_SESSION['formexamen'][NUM_PAGE]["laboratoire"] == $rowr["idlaboratoire"]) { ?> selected <?php } ?>><?php echo($rowr["nomlaboratoire"]); ?></option>
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
                                                <input value="<?php echo $_SESSION['formexamen'][NUM_PAGE]["codep"]; ?>" onkeyup="this.value = this.value.toUpperCase();" class="form-control" placeholder=" " type="text" name="codep" id="codep" />
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
                                                <input value="<?php echo $_SESSION['formexamen'][NUM_PAGE]["examen"]; ?>" onkeyup="this.value = this.value.toLowerCase();" style="text-transform: capitalize;" class="form-control" placeholder="" type="text" name="examen" id="examen" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="chosen-select-single" style="margin-left:15px;">
                                        <label class="control-label">Type </label>
                                        <select data-placeholder="Choisissez un type..." class="select2_demo_3 form-control" name="type" id="type">
                                            <option value=""> - Choisissez un type - </option>
                                            <option value="Sérologie de Widal et Felix" <?php if ($_SESSION['formexamen'][NUM_PAGE]["type"] == "Sérologie de Widal et Felix") { ?> selected <?php } ?>>S&eacute;rologie de Widal et Felix</option>
                                            <option value="Sérologie V.I.H" <?php if ($_SESSION['formexamen'][NUM_PAGE]["type"] == "Sérologie V.I.H") { ?> selected <?php } ?>>S&eacute;rologie V.I.H</option>
                                            <option value="Coprologie Parasitaire: Selles" <?php if ($_SESSION['formexamen'][NUM_PAGE]["type"] == "Coprologie Parasitaire: Selles") { ?> selected <?php } ?>>Coprologie Parasitaire: Selles</option>
                                            <option value="Prélèvement Cervico-Vaginal: PCV" <?php if ($_SESSION['formexamen'][NUM_PAGE]["type"] == "Prélèvement Cervico-Vaginal: PCV") { ?> selected <?php } ?>>Pr&eacute;l&egrave;vement Cervico-Vaginal: PCV</option>
                                            <option value="Numération Formule Sanguine (NFS)" <?php if ($_SESSION['formexamen'][NUM_PAGE]["type"] == "Numération Formule Sanguine (NFS)") { ?> selected <?php } ?>>Num&eacute;ration Formule Sanguine (NFS)</option>
                                            <option value="Autre" <?php if ($_SESSION['formexamen'][NUM_PAGE]["type"] == "Autre") { ?> selected <?php } ?>>Autre</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group" style="margin-left:15px;">
                                        <label class="control-label" >Montant </label>
                                        <div class="inputGroupContainer">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                                <input value="<?php echo $_SESSION['formexamen'][NUM_PAGE]["montant"]; ?>" class="form-control" placeholder="" type="text" name="montant" id="montant" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group" style="margin-left:15px;">
                                        <label class="control-label" >Resultat </label>
                                        <div class="inputGroupContainer">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                                <input value="<?php echo $_SESSION['formexamen'][NUM_PAGE]["resultat"]; ?>" class="form-control" placeholder="" type="text" name="resultat" id="resultat" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="chosen-select-single" style="margin-left:15px;">
                                        <label class="control-label">Unit&eacute; </label>
                                        <?php
                                        $rsltp = $con->query("select * from hp_unite") or die(mysqli_error($con));
                                        ?>
                                        <select data-placeholder="Choisissez une unite..." class="select2_demo_3 form-control" name="unite" id="unite">
                                            <option value=""> - Choisissez une unite - </option>
                                            <?php
                                            while ($rowp = mysqli_fetch_assoc($rsltp)) {
                                                ?>
                                                <option value="<?php echo $rowp["idunite"]; ?>" <?php if ($rowp["idunite"] == $_SESSION['formexamen'][NUM_PAGE]["unite"]) { ?> selected <?php } ?>><?php echo $rowp["codeunite"]; ?> - <?php echo $rowp["libelleunite"]; ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-3 col-xs-6">
                                    <div class="form-group" style="margin-left:15px;">
                                        <label class="control-label" >Valeur minimale </label>
                                        <div class="inputGroupContainer">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                                <input value="<?php echo $_SESSION['formexamen'][NUM_PAGE]["valmin"]; ?>" class="form-control" placeholder="" type="text" name="valmin" id="valmin" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-3 col-xs-6">
                                    <div class="form-group" style="margin-left:15px;">
                                        <label class="control-label" >Valeur maximale </label>
                                        <div class="inputGroupContainer">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                                <input value="<?php echo $_SESSION['formexamen'][NUM_PAGE]["valmax"]; ?>" class="form-control" placeholder="" type="text" name="valmax" id="valmax" />
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
                                        <center><button id="validateBtn" type="submit" name="insexamen" class="btn btn-success"><i class="glyphicon glyphicon-check"></i> Enregistrer</button>
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

        $('#ajout_examen').bootstrapValidator({
//        live: 'disabled',
            message: 'Cette valeur est invalide',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                codep: {
                    message: 'Code du examen invalide',
                    validators: {
                        notEmpty: {
                            message: 'Le code du examen est obligatoire'
                        },
                        stringLength: {
                            min: 1,
                            max: 5,
                            message: 'Le code du examen doit etre entre 1 et 5 characteres de long'
                        },
                        regexp: {
                            regexp: /^[a-zA-Z0-9]+$/,
                            message: 'Le code du examen peut contenir seulement les lettres de l\'alphabet et les chiffres'
                        },
                        remote: {
                            type: 'POST',
                            url: './hopitalpages/hopitalparametre/hopitalexamen/remoteformvalidationexamen.php',
                            message: 'Le code doit etre unique'
                        }
                    }
                },
                examen: {
                    validators: {
                        notEmpty: {
                            message: 'Le nom du examen est obligatoire'
                        }
                    }
                }
            }
        });

        // Validate the form manually
//    $('#validateBtn').click(function() {
//        $('#ajout_examen').bootstrapValidator('validate');
//    });
//
//    $('#resetBtn').click(function() {
//        $('#ajout_examen').data('bootstrapValidator').resetForm(true);
//    });
    });
</script>
