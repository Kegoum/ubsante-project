
<div class="single-product-tab-area mg-tb-15">
    <!-- Single pro tab review Start-->
    <div class="single-pro-review-area">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="sparkline12-list mt-b-30">
                        <div class="sparkline12-hd">
                            <div class="main-sparkline12-hd">
                                <h1>Formulaire de modification d'un D&eacute;artement</h1>
                            </div>
                        </div>
                        <form id="edit_departement" name="formdepartemente" enctype="multipart/form-data" method="post" action="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalparametre/hopitaldepartement/hopitalediter/edit_departement'); ?>&pagecom=<?php echo NUM_PAGE + 1; ?>&iddepartement=<?php echo $_REQUEST["iddepartement"]; ?>" style="padding: 2%;">

                            <input value="<?php echo $_SESSION['formdepartemente'][NUM_PAGE]["iddepartement"]; ?>" type="hidden" name="iddepartement" id="iddepartement" />
                            
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group" style="margin-left:15px;">
                                        <label class="control-label">R&eacute;gion &nbsp;<g style="color: red">*</g></label>
                                        <div class="inputGroupContainer">
                                            <div class="input-group">
                                                <?php
                                                $rsltp = $con->query("select * from hp_region ") or die(mysqli_error($con));
                                                ?>
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                                <select class="form-control" name="regione" id="regione">
                                                    <option value=""> - Choisissez le region - </option>
                                                    <?php
                                                    while ($rowp = mysqli_fetch_assoc($rsltp)) {
                                                        ?>
                                                        <option value="<?php echo $rowp["idregion"]; ?>" <?php if ($rowp["idregion"] == $_SESSION['formdepartemente'][NUM_PAGE]["regione"]) { ?> selected <?php } ?>><?php echo $rowp["libelleregion"]; ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group" style="margin-left:15px;">
                                        <label class="control-label" >Nom&nbsp;<g style="color: red">*</g></label>
                                        <div class="inputGroupContainer">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                                <input value="<?php echo $_SESSION['formdepartemente'][NUM_PAGE]["departemente"]; ?>" onkeyup="this.value = this.value.toLowerCase();" style="text-transform: capitalize;" class="form-control" placeholder="" type="text" name="departemente" id="departemente" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group" style="margin-left:15px;">
                                        <label class="control-label" >Chef lieu <g style="color: red">*</g></label>
                                        <div class="inputGroupContainer">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                                <input value="<?php echo $_SESSION['formdepartemente'][NUM_PAGE]["cheflieue"]; ?>" class="form-control" placeholder="" type="text" name="cheflieue" id="cheflieue" />
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

         var iddepartement = document.getElementById('iddepartement').value;
//        alert(iddepartement);
        $('#edit_departement').bootstrapValidator({
//        live: 'disabled',
            message: 'Cette valeur est invalide',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                departemente: {
                    message: 'Nom du departement invalide',
                    validators: {
                        notEmpty: {
                            message: 'Le nom de la departement est obligatoire'
                        },
                        stringLength: {
                            min: 2,
                            message: 'Le nom de la departement doit avoir au moins 2 characteres de long'
                        },
                        remote: {
                            type: 'POST',
                            data: {iddepartement: iddepartement},
                            dataType: 'json',
                            url: './hopitalpages/hopitalparametre/hopitaldepartement/remoteformvalidationdepartement.php',
                            message: 'Le nom doit etre unique'
                        }
                    }
                },
                regione: {
                    validators: {
                        notEmpty: {
                            message: 'Le region de la departement est obligatoire'
                        }
                    }
                }
            }
        });

        // Validate the form manually
//        $('#validateBtnpe').click(function () {
//            $('#edit_departement').bootstrapValidator('validate');
//        });

//        $('#resetBtnpe').click(function () {
//            $('#edit_departement').data('bootstrapValidator').resetForm(true);
//        });
    });
</script>
