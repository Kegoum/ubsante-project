<script>

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
                                <h1>
                                    Consultation de : <?php
                                    echo $row["codepatient"];
                                    ?> <?php echo $row["nompatient"]; ?> <?php
                                    echo $row["prenompatient"];
                                    ?>
                                </h1>

                            </div>
                        </div>
                        <form id="ajout_param" name="formconsultationplan" enctype="multipart/form-data" method="post" action="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitalconsultation/hopitalajouterplan/ajout_consultation'); ?>&idconsultation=<?php echo $_REQUEST["idconsultation"]; ?>&pagecom=<?php echo NUM_PAGE + 1; ?>" style="padding: 2%;">
                            <div class="row">

                                <div class="col-xs-6 col-sm-3 col-md-3">
                                    <b>  Param&egrave;tre </b>
                                </div>
                                <div class="col-xs-6 col-sm-3 col-md-3">
                                    <b>Valeurs Patient </b>
                                </div> 
                                <div class="col-xs-6 col-sm-3 col-md-3">
                                    <b>Valeurs normales </b>
                                </div>
                            </div>
                            <?php
                            while ($recfnp = mysqli_fetch_assoc($rsltcp)) {
                                ?>
                                <div class="row">
                                    <!--<div class="col-xs-6 col-sm-3 col-md-3">-->
                                    <?php // print nl2br(htmlspecialchars($recfnp["datejourparametrepatient"])) ?> 
                                    <?php // print nl2br(htmlspecialchars($recfnp["heureparametrepatient"])) ?>
                                    <!--</div>-->
                                    <div class="col-xs-6 col-sm-3 col-md-3">
                                        <?php print nl2br(htmlspecialchars($recfnp["libelleparametre"])) ?>
                                    </div>
                                    <div class="col-xs-6 col-sm-3 col-md-3">
                                        <?php print nl2br(htmlspecialchars($recfnp["valeurparametrepatient"])) ?> 
                                        <?php print nl2br(htmlspecialchars($recfnp["codeunite"])) ?> 
                                    </div> 
                                    <div class="col-xs-6 col-sm-3 col-md-3">
                                        <?php print nl2br(htmlspecialchars($recfnp["valeurminparametre"])) ?> - 
                                        <?php print nl2br(htmlspecialchars($recfnp["valeurmaxparametre"])) ?> 
                                        <?php print nl2br(htmlspecialchars($recfnp["codeunite"])) ?> 
                                    </div>
                                </div>
                                <?php
                            }
                            ?>

                            <br>

                            <div class="row">
                                <div class="col-xs-12 col-sm-6 col-md-6">
                                    <div class="form-group">
                                        <label>But</label>
                                        <input name="but" value="<?php echo $_SESSION['formconsultationplan'][NUM_PAGE]["but"]; ?>"  placeholder="But de la consultation" type="text" class="form-control" id="but" required>
                                    </div>
                                </div> 
                                <div class="col-xs-12 col-sm-6 col-md-6">
                                    <div class="form-group">
                                        <label>Signe</label>
                                        <textarea name="signe" placeholder="signe" class="form-control" id="signe"><?php echo $_SESSION['formconsultationplan'][NUM_PAGE]["signe"]; ?></textarea>
                                    </div>
                                </div>  
                                <div class="col-xs-12 col-sm-6 col-md-6">
                                    <div class="form-group">
                                        <label>Sympt&ocirc;me</label>
                                        <textarea name="symptome" placeholder="symptome" class="form-control" id="diagnostique"><?php echo $_SESSION['formconsultationplan'][NUM_PAGE]["symptome"]; ?></textarea>
                                    </div>
                                </div>  
                                <div class="col-xs-12 col-sm-6 col-md-6">
                                    <div class="form-group">
                                        <label>Diagnostique</label>
                                        <textarea name="diagnostique" placeholder="diagnostique" class="form-control" id="diagnostique"><?php echo $_SESSION['formconsultationplan'][NUM_PAGE]["diagnostique"]; ?></textarea>
                                    </div>
                                </div> 
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                    <b style="color: red">Champs Obligatoires *</b>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                    <center><button id="validateBtn" type="submit" name="insparam" class="btn btn-success"><i class="glyphicon glyphicon-check"></i> Suivant</button>
                                    </center><br>
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
        $('#ajout_param').bootstrapValidator({
//        live: 'disabled',
            message: 'Cette valeur est invalide',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                valeurmin: {
                    message: 'Nom de l\'param invalide',
                    validators: {
                        notEmpty: {
                            message: 'Le valeurmin de l\'param est obligatoire'
                        }
                    }
                },
                valeurmax: {
                    message: 'Prevaleurmin de l\'param invalide',
                    validators: {
                    }
                },
                photo: {
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
//        $('#ajout_param').bootstrapValidator('validate');
//    });
//
//    $('#resetBtn').click(function() {
//        $('#ajout_param').data('bootstrapValidator').resetForm(true);
//    });
    });
</script>
