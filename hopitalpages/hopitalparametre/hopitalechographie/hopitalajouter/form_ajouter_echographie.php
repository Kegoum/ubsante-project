
<div class="single-product-tab-area mg-tb-15">
    <!-- Single pro tab review Start-->
    <div class="single-pro-review-area">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="sparkline12-list mt-b-30">
                        <div class="sparkline12-hd">
                            <div class="main-sparkline12-hd">
                                <h1>Formulaire d'ajout d'un Echographie</h1>
                            </div>
                        </div>
                        <form id="ajout_echographie" name="formechographie" enctype="multipart/form-data" method="post" action="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalparametre/hopitalechographie/hopitalajouter/ajout_echographie'); ?>&pagecom=<?php echo NUM_PAGE + 1; ?>" style="padding: 2%;">

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
                                                <option value="<?php echo($rowr['idservice']); ?>" <?php if ($_SESSION['formechographie'][NUM_PAGE]["service"] == $rowr["idservice"]) { ?> selected <?php } ?>><?php echo($rowr["nomservice"]); ?></option>
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
                                                <input value="<?php echo $_SESSION['formechographie'][NUM_PAGE]["codep"]; ?>" onkeyup="this.value = this.value.toUpperCase();" class="form-control" placeholder=" " type="text" name="codep" id="codep" />
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
                                                <input value="<?php echo $_SESSION['formechographie'][NUM_PAGE]["echographie"]; ?>" onkeyup="this.value = this.value.toLowerCase();" style="text-transform: capitalize;" class="form-control" placeholder="" type="text" name="echographie" id="echographie" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="chosen-select-single" style="margin-left:15px;">
                                        <label class="control-label">Type </label>
                                        <select data-placeholder="Choisissez un type..." class="select2_demo_3 form-control" name="type" id="type">
                                            <option value=""> - Choisissez un type - </option>
                                            <option value="Obstétricale 1" <?php if ($_SESSION['formechographie'][NUM_PAGE]["type"] == "Obstétricale 1") { ?> selected <?php } ?>>Obstétricale 1</option>
                                            <option value="Obstétricale 2 3" <?php if ($_SESSION['formechographie'][NUM_PAGE]["type"] == "Obstétricale 2 3") { ?> selected <?php } ?>>Obstétricale 2 3</option>
                                            <option value="Abdominale" <?php if ($_SESSION['formechographie'][NUM_PAGE]["type"] == "Abdominale") { ?> selected <?php } ?>>Abdominale</option>
                                            <option value="Abdomino - Pelvienne" <?php if ($_SESSION['formechographie'][NUM_PAGE]["type"] == "Abdomino - Pelvienne") { ?> selected <?php } ?>>Abdomino - Pelvienne</option>
                                            <option value="Mammaire" <?php if ($_SESSION['formechographie'][NUM_PAGE]["type"] == "Mammaire") { ?> selected <?php } ?>>Mammaire</option>
                                            <option value="Pelvienne" <?php if ($_SESSION['formechographie'][NUM_PAGE]["type"] == "Pelvienne") { ?> selected <?php } ?>>Pelvienne</option>
                                            <option value="Pelvienne Endovaginale" <?php if ($_SESSION['formechographie'][NUM_PAGE]["type"] == "Pelvienne Endovaginale") { ?> selected <?php } ?>>Pelvienne Endovaginale</option>
                                            <option value="Prostatique" <?php if ($_SESSION['formechographie'][NUM_PAGE]["type"] == "Prostatique") { ?> selected <?php } ?>>Prostatique</option>
                                            <option value="Testiculaire" <?php if ($_SESSION['formechographie'][NUM_PAGE]["type"] == "Testiculaire") { ?> selected <?php } ?>>Testiculaire</option>
                                            <option value="Partie Molle" <?php if ($_SESSION['formechographie'][NUM_PAGE]["type"] == "Partie Molle") { ?> selected <?php } ?>>Partie Molle</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="chosen-select-single" style="margin-left:15px;">
                                        <label class="control-label">Acte </label>
                                        <?php
                                        $consuv = "Echographie";
                                        $rsltp = $con->query("select * from hp_acte where categorieacte='" . $consuv . "' and etatacte=true") or die(mysqli_error($con));
                                        ?>
                                        <select data-placeholder="Choisissez un acte..." class="select2_demo_3 form-control" name="acte" id="acte">
                                            <option value=""> - Choisissez un acte - </option>
                                            <?php
                                            while ($rowp = mysqli_fetch_assoc($rsltp)) {
                                                ?>
                                                <option value="<?php echo $rowp["idacte"]; ?>" <?php if ($rowp["idacte"] == $_SESSION['formechographie'][NUM_PAGE]["acte"]) { ?> selected <?php } ?>><?php echo $rowp["libelleacte"]; ?> - <?php echo $rowp["prixacte"]; ?></option>
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
                                                <input value="<?php echo $_SESSION['formechographie'][NUM_PAGE]["montant"]; ?>" class="form-control" placeholder="" type="text" name="montant" id="montantac" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group" style="margin-left:15px;">
                                        <label class="control-label" >Resultat </label>
                                        <div class="inputGroupContainer">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                                <input value="<?php echo $_SESSION['formechographie'][NUM_PAGE]["resultat"]; ?>" class="form-control" placeholder="" type="text" name="resultat" id="resultat" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-3 col-xs-6">
                                    <div class="form-group" style="margin-left:15px;">
                                        <label class="control-label" >Valeur minimale </label>
                                        <div class="inputGroupContainer">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                                <input value="<?php echo $_SESSION['formechographie'][NUM_PAGE]["valmin"]; ?>" class="form-control" placeholder="" type="text" name="valmin" id="valmin" />
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
                                                <input value="<?php echo $_SESSION['formechographie'][NUM_PAGE]["valmax"]; ?>" class="form-control" placeholder="" type="text" name="valmax" id="valmax" />
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
                                        <center><button id="validateBtn" type="submit" name="insechographie" class="btn btn-success"><i class="glyphicon glyphicon-check"></i> Enregistrer</button>
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
    $(document).ready(function () {
        // Generate a simple captcha
        function randomNumber(min, max) {
            return Math.floor(Math.random() * (max - min + 1) + min);
        }
        ;
        $('#captchaOperation').html([randomNumber(1, 100), '+', randomNumber(1, 200), '='].join(' '));

        $('#ajout_echographie').bootstrapValidator({
//        live: 'disabled',
            message: 'Cette valeur est invalide',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                codep: {
                    message: 'Code du echographie invalide',
                    validators: {
                        notEmpty: {
                            message: 'Le code du echographie est obligatoire'
                        },
                        stringLength: {
                            min: 1,
                            max: 5,
                            message: 'Le code du echographie doit etre entre 1 et 5 characteres de long'
                        },
                        regexp: {
                            regexp: /^[a-zA-Z0-9]+$/,
                            message: 'Le code du echographie peut contenir seulement les lettres de l\'alphabet et les chiffres'
                        },
                        remote: {
                            type: 'POST',
                            url: './hopitalpages/hopitalparametre/hopitalechographie/remoteformvalidationechographie.php',
                            message: 'Le code doit etre unique'
                        }
                    }
                },
                echographie: {
                    validators: {
                        notEmpty: {
                            message: 'Le nom du echographie est obligatoire'
                        }
                    }
                }
            }
        });

        // Validate the form manually
//    $('#validateBtn').click(function() {
//        $('#ajout_echographie').bootstrapValidator('validate');
//    });
//
//    $('#resetBtn').click(function() {
//        $('#ajout_echographie').data('bootstrapValidator').resetForm(true);
//    });
    });



    $(document).ready(function () {
        $("#acte").change(function () {
            var moid = $(this).val();
//            alert("dd");
            $.ajax({
                url: './hopitalpages/hopitalparametre/hopitalechographie/getprixacte.php',
                type: 'post',
                data: {ma: moid},
                dataType: 'json',
                success: function (response) {
                    var len = response.length;
                    for (var i = 0; i < len; i++) {
                        var id = response[i]['ide'];
                        var lib = response[i]['libe'];

                        document.getElementById("montantac").value = "";
                        document.getElementById("montantac").value = lib;
                    }
                }
            });
        });
    });

</script>
