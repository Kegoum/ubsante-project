
<div class="single-product-tab-area mg-tb-15">
    <!-- Single pro tab review Start-->
    <div class="single-pro-review-area">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="sparkline12-list mt-b-30">
                        <div class="sparkline12-hd">
                            <div class="main-sparkline12-hd">
                                <h1 style=" text-align: center;"><?php echo $rowe["nomlaboratoire"]; ?></h1>
                                <h5>
                                    <small> Nons et pr&eacute;maxs : </small> 
                                    <?php echo $row["nompatient"]; ?> <?php echo $row["prenompatient"]; ?>
                                </h5>

                                <h5>
                                    <small>Age : </small>
                                    <?php
                                    $date = date('Y-m-d');
                                    $daten = $date = date('Y-m-d') - $row["datenaissancepatient"];
                                    ?>
                                    <?php echo $daten; ?> an(s)
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <small>Sexe : </small>
                                    <?php echo $row["sexepatient"]; ?>
                                </h5>
                            </div>
                        </div>
                        <form id="ajout_note" name="formechographievih" enctype="multipart/form-data" method="post" action="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitalechographie/hopitalvih/hopitalajouter/ajout_echographie'); ?>&idechographiepatient=<?php echo $_REQUEST["idechographiepatient"]; ?>&pagecom=<?php echo NUM_PAGE + 1; ?>" style="padding: 2%;">
                            <input type="hidden" name="laboratoire" value="<?php echo $_SESSION['formechographievih'][NUM_PAGE]['laboratoire'] ?>" id="laboratoire"/>&nbsp;&nbsp;

                            <div class="row">
                                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label>Date pr&eacute;l&egrave;vement : </label>
                                        <input name="prelevement" value="<?php echo $_SESSION['formechographievih'][NUM_PAGE]["prelevement"]; ?>"  placeholder="" type="date" class="form-control" id="prelevement" >
                                    </div>
                                </div> 
                                <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                                    <div class="form-group">
                                        <label>Prescription : </label>
                                        <input name="prescription" value="<?php echo $_SESSION['formechographievih'][NUM_PAGE]["prescription"]; ?>"  placeholder="" type="text" class="form-control" id="but" >
                                    </div>
                                </div> 
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <label>Orientation clinique : </label>
                                        <input name="orientation" value="<?php echo $_SESSION['formechographievih'][NUM_PAGE]["orientation"]; ?>"  placeholder="" type="text" class="form-control" id="orientation">
                                    </div>
                                </div> 
                            </div>

                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style=" text-align: center;">
                                    <h4><?php echo $rowe["typeechographie"]; ?></h4>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <label>M&eacute;thode / Technique : </label>
                                        <input name="methode" value="<?php echo $_SESSION['formechographievih'][NUM_PAGE]["methode"]; ?>"  placeholder="" type="text" class="form-control" id="methode">
                                    </div>
                                </div> 
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label>R&eacute;sultat : </label>
                                        <textarea name="resultat" placeholder="" class="form-control" id="resultat"><?php echo $_SESSION['formechographievih'][NUM_PAGE]['resultat']; ?></textarea>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label>Interpretaion et conclusion : </label>
                                        <textarea name="interpretation" placeholder="" class="form-control" id="interpretation"><?php echo $_SESSION['formechographievih'][NUM_PAGE]['interpretation']; ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                    <b style="color: red">Champs Obligatoires *</b>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                    <center><button id="validateBtn" type="submit" name="insnote" class="btn btn-success"><i class="glyphicon glyphicon-check"></i> Enregistrer</button>
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
        $('#ajout_note').bootstrapValidator({
//        live: 'disabled',
            message: 'Cette valeur est invalide',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                max: {
                    message: 'Nom de l\'note invalide',
                    validators: {
                        notEmpty: {
                            message: 'Le max de l\'note est obligatoire'
                        }
                    }
                },
                premax: {
                    message: 'Premax de l\'note invalide',
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
//        $('#ajout_note').bootstrapValidator('validate');
//    });
//
//    $('#resetBtn').click(function() {
//        $('#ajout_note').data('bootstrapValidator').resetForm(true);
//    });
    });
</script>
