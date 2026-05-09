
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
                                    <small> Nons et pr&eacute;noms : </small> 
                                    <?php echo $row["nompatient"]; ?> <?php echo $row["prenompatient"]; ?>
                                </h5>

                                <h5>
                                    <small>Age : </small>
                                    <?php
                                    $date = date('Y-m-d');
                                    $daten = ageBirthday($row["datenaissancepatient"]);
                                    ?>
                                    <?php echo $daten; ?> an(s)
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <small>Sexe : </small>
                                    <?php echo $row["sexepatient"]; ?>
                                </h5>
                            </div>
                        </div>
                        <form id="ajout_note" name="formexamenpcv" enctype="multipart/form-data" method="post" action="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitalexamen/hopitalpcv/hopitalajouter/ajout_examen'); ?>&idexamenpatient=<?php echo $_REQUEST["idexamenpatient"]; ?>&pagecom=<?php echo NUM_PAGE + 1; ?>" style="padding: 2%;">
                            <input type="hidden" name="laboratoire" value="<?php echo $_SESSION['formexamenpcv'][NUM_PAGE]['laboratoire'] ?>" id="laboratoire"/>&nbsp;&nbsp;

                            <div class="row">
                                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label>Date pr&eacute;l&egrave;vement : </label>
                                        <input name="prelevement" value="<?php echo $_SESSION['formexamenpcv'][NUM_PAGE]["prelevement"]; ?>"  placeholder="" type="date" class="form-control" id="prelevement" required >
                                    </div>
                                </div> 
                                <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                                    <div class="form-group">
                                        <label>Prescripteur : </label>
                                        <input name="prescription" value="<?php echo $_SESSION['formexamenpcv'][NUM_PAGE]["prescription"]; ?>"  placeholder="" type="text" class="form-control" id="but" >
                                    </div>
                                </div> 
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <label>Orientation clinique : </label>
                                        <input name="orientation" value="<?php echo $_SESSION['formexamenpcv'][NUM_PAGE]["orientation"]; ?>"  placeholder="" type="text" class="form-control" id="orientation">
                                    </div>
                                </div> 
                            </div>
                            
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style=" text-align: center;">
                                    <h4><?php echo $rowe["typeexamen"]; ?></h4>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <label>Aspect du col : </label>
                                        <input name="col" value="<?php echo $_SESSION['formexamenpcv'][NUM_PAGE]["col"]; ?>"  placeholder="" type="text" class="form-control" id="col">
                                    </div>
                                </div> 
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <label>Leucorrh&eacute;es : </label>
                                </div>
                                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                                    <div class="form-group">
                                        <label>Quantit&eacute; : </label>
                                        <input name="leucqte" value="<?php echo $_SESSION['formexamenpcv'][NUM_PAGE]["leucqte"]; ?>"  placeholder="" type="text" class="form-control" id="leucqte" >
                                    </div>
                                </div> 
                                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                                    <div class="form-group">
                                        <label>Consistance : </label>
                                        <input name="leuccons" value="<?php echo $_SESSION['formexamenpcv'][NUM_PAGE]["leuccons"]; ?>"  placeholder="" type="text" class="form-control" id="leuccons" >
                                    </div>
                                </div> 
                                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                                    <div class="form-group">
                                        <label>Odeur : </label>
                                        <input name="leucodeur" value="<?php echo $_SESSION['formexamenpcv'][NUM_PAGE]["leucodeur"]; ?>"  placeholder="" type="text" class="form-control" id="leucodeur" >
                                    </div>
                                </div> 
                                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                                    <div class="form-group">
                                        <label>Couleur : </label>
                                        <input name="leuccouleur" value="<?php echo $_SESSION['formexamenpcv'][NUM_PAGE]["leuccouleur"]; ?>"  placeholder="" type="text" class="form-control" id="leuccouleur" >
                                    </div>
                                </div> 
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <label>Etat frais : </label>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label>Trichomonas vaginalis : </label>
                                        <input name="etattv" value="<?php echo $_SESSION['formexamenpcv'][NUM_PAGE]["etattv"]; ?>"  placeholder="" type="text" class="form-control" id="etattv" >
                                    </div>
                                </div> 
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label>Levures : </label>
                                        <input name="etatlev" value="<?php echo $_SESSION['formexamenpcv'][NUM_PAGE]["etatlev"]; ?>"  placeholder="" type="text" class="form-control" id="etatlev" >
                                    </div>
                                </div> 
                                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                                    <div class="form-group">
                                        <label>Leucocytes : </label>
                                        <input name="etatleuc" value="<?php echo $_SESSION['formexamenpcv'][NUM_PAGE]["etatleuc"]; ?>"  placeholder="" type="text" class="form-control" id="etatleuc" >
                                    </div>
                                </div> 
                                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                                    <div class="form-group">
                                        <label>H&eacute;maties : </label>
                                        <input name="etathema" value="<?php echo $_SESSION['formexamenpcv'][NUM_PAGE]["etathema"]; ?>"  placeholder="" type="text" class="form-control" id="etathema" >
                                    </div>
                                </div> 
                                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                                    <div class="form-group">
                                        <label>Clue-cells : </label>
                                        <input name="etatcc" value="<?php echo $_SESSION['formexamenpcv'][NUM_PAGE]["etatcc"]; ?>"  placeholder="" type="text" class="form-control" id="etatcc" >
                                    </div>
                                </div> 
                                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                                    <div class="form-group">
                                        <label>Cellules &eacute;pith&eacute;liales : </label>
                                        <input name="etatce" value="<?php echo $_SESSION['formexamenpcv'][NUM_PAGE]["etatce"]; ?>"  placeholder="" type="text" class="form-control" id="etatce" >
                                    </div>
                                </div> 
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <label>Coloration de GRAM : </label>
                                </div>
                                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                                    <div class="form-group">
                                        <label>Cocci gram n&eacute;gatif : </label>
                                        <input name="colorcgn" value="<?php echo $_SESSION['formexamenpcv'][NUM_PAGE]["colorcgn"]; ?>"  placeholder="" type="text" class="form-control" id="colorcgn" >
                                    </div>
                                </div> 
                                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                                    <div class="form-group">
                                        <label>Cocci gram positif : </label>
                                        <input name="colorcgp" value="<?php echo $_SESSION['formexamenpcv'][NUM_PAGE]["colorcgp"]; ?>"  placeholder="" type="text" class="form-control" id="colorcgp" >
                                    </div>
                                </div> 
                                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                                    <div class="form-group">
                                        <label>Bacilles gram n&eacute;gatif : </label>
                                        <input name="colorbgn" value="<?php echo $_SESSION['formexamenpcv'][NUM_PAGE]["colorbgn"]; ?>"  placeholder="" type="text" class="form-control" id="colorbgn" >
                                    </div>
                                </div> 
                                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                                    <div class="form-group">
                                        <label>Bacilles gram positif : </label>
                                        <input name="colorbgp" value="<?php echo $_SESSION['formexamenpcv'][NUM_PAGE]["colorbgp"]; ?>"  placeholder="" type="text" class="form-control" id="colorbgp" >
                                    </div>
                                </div> 
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <label>Type de la flore vaginale : </label>
                                        <input name="flore" value="<?php echo $_SESSION['formexamenpcv'][NUM_PAGE]["flore"]; ?>"  placeholder="" type="text" class="form-control" id="flore">
                                    </div>
                                </div> 
                            </div>
                            
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <label>Interpretaion et conclusion : </label>
                                            <textarea name="interpretation" placeholder="" class="form-control" id="interpretation"><?php echo $_SESSION['formexamenpcv'][NUM_PAGE]['interpretation']; ?></textarea>
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
