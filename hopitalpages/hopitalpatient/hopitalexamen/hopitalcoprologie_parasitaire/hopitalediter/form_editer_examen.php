
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
                        <form id="edit_note" name="formexamencoprologie_parasitairee" enctype="multipart/form-data" method="post" action="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitalexamen/hopitalcoprologie_parasitaire/hopitalediter/edit_examen'); ?>&idcoprologieparasitaire=<?php echo $_REQUEST["idcoprologieparasitaire"]; ?>&pagecom=<?php echo NUM_PAGE + 1; ?>" style="padding: 2%;">
                            <input type="hidden" name="laboratoire" value="<?php echo $_SESSION['formexamencoprologie_parasitairee'][NUM_PAGE]['laboratoire'] ?>" id="laboratoire"/>&nbsp;&nbsp;
 <input type="hidden" name="idexamenpatient" value="<?php echo $_SESSION['formexamencoprologie_parasitairee'][NUM_PAGE]['idexamenpatient'] ?>" id="idexamenpatient"/>&nbsp;&nbsp;

                            <div class="row">
                                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label>Date pr&eacute;l&egrave;vement : </label>
                                        <input name="prelevement" value="<?php echo $_SESSION['formexamencoprologie_parasitairee'][NUM_PAGE]["prelevement"]; ?>"  placeholder="" type="date" class="form-control" id="prelevement" required >
                                    </div>
                                </div> 
                                <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                                    <div class="form-group">
                                        <label>Prescripteur : </label>
                                        <input name="prescription" value="<?php echo $_SESSION['formexamencoprologie_parasitairee'][NUM_PAGE]["prescription"]; ?>"  placeholder="" type="text" class="form-control" id="but" >
                                    </div>
                                </div> 
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <label>Orientation clinique : </label>
                                        <input name="orientation" value="<?php echo $_SESSION['formexamencoprologie_parasitairee'][NUM_PAGE]["orientation"]; ?>"  placeholder="" type="text" class="form-control" id="orientation">
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
                                <label>Annalyse macroscopique : </label>
                                </div>
                                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                                    <div class="form-group">
                                        <label>Glaire : </label>
                                        <input name="glaire" value="<?php echo $_SESSION['formexamencoprologie_parasitairee'][NUM_PAGE]["glaire"]; ?>"  placeholder="" type="text" class="form-control" id="glaire">
                                    </div>
                                </div> 
                                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                                    <div class="form-group">
                                        <label>Consistance : </label>
                                        <input name="cons" value="<?php echo $_SESSION['formexamencoprologie_parasitairee'][NUM_PAGE]["cons"]; ?>"  placeholder="" type="text" class="form-control" id="cons" >
                                    </div>
                                </div> 
                                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                                    <div class="form-group">
                                        <label>Odeur : </label>
                                        <input name="odeur" value="<?php echo $_SESSION['formexamencoprologie_parasitairee'][NUM_PAGE]["odeur"]; ?>"  placeholder="" type="text" class="form-control" id="odeur" >
                                    </div>
                                </div> 
                                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                                    <div class="form-group">
                                        <label>Couleur : </label>
                                        <input name="couleur" value="<?php echo $_SESSION['formexamencoprologie_parasitairee'][NUM_PAGE]["couleur"]; ?>"  placeholder="" type="text" class="form-control" id="couleur" >
                                    </div>
                                </div> 
                                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                                    <div class="form-group">
                                        <label>Sang : </label>
                                        <input name="sang" value="<?php echo $_SESSION['formexamencoprologie_parasitairee'][NUM_PAGE]["sang"]; ?>"  placeholder="" type="text" class="form-control" id="sang" >
                                    </div>
                                </div> 
                                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                                    <div class="form-group">
                                        <label>Parasites adultes : </label>
                                        <input name="parasiteadulte" value="<?php echo $_SESSION['formexamencoprologie_parasitairee'][NUM_PAGE]["parasiteadulte"]; ?>"  placeholder="" type="text" class="form-control" id="parasiteadulte" >
                                    </div>
                                </div> 
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label>Gros d&eacute;bris alimentaire : </label>
                                        <input name="debris" value="<?php echo $_SESSION['formexamencoprologie_parasitairee'][NUM_PAGE]["debris"]; ?>"  placeholder="" type="text" class="form-control" id="debris" >
                                    </div>
                                </div> 
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <label>Annalyse microscopique : </label>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    Etat frais / coloration au logo / coloration &agrave; l'eau physiologique
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label>Digestion : </label>
                                        <input name="digestion" value="<?php echo $_SESSION['formexamencoprologie_parasitairee'][NUM_PAGE]["digestion"]; ?>"  placeholder="" type="text" class="form-control" id="digestion" >
                                    </div>
                                </div> 
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label>Trichomonas intestinalis : </label>
                                        <input name="etattv" value="<?php echo $_SESSION['formexamencoprologie_parasitairee'][NUM_PAGE]["etattv"]; ?>"  placeholder="" type="text" class="form-control" id="etattv" >
                                    </div>
                                </div> 
                                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                                    <div class="form-group">
                                        <label>Levures : </label>
                                        <input name="etatlev" value="<?php echo $_SESSION['formexamencoprologie_parasitairee'][NUM_PAGE]["etatlev"]; ?>"  placeholder="" type="text" class="form-control" id="etatlev" >
                                    </div>
                                </div> 
                                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                                    <div class="form-group">
                                        <label>Parasite : </label>
                                        <input name="parasite" value="<?php echo $_SESSION['formexamencoprologie_parasitairee'][NUM_PAGE]["parasite"]; ?>"  placeholder="" type="text" class="form-control" id="parasite" >
                                    </div>
                                </div> 
                                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                                    <div class="form-group">
                                        <label>Leucocytes : </label>
                                        <input name="leucocyte" value="<?php echo $_SESSION['formexamencoprologie_parasitairee'][NUM_PAGE]["leucocyte"]; ?>"  placeholder="" type="text" class="form-control" id="leucocyte" >
                                    </div>
                                </div> 
                                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                                    <div class="form-group">
                                        <label>Hematies : </label>
                                        <input name="hematie" value="<?php echo $_SESSION['formexamencoprologie_parasitairee'][NUM_PAGE]["hematie"]; ?>"  placeholder="" type="text" class="form-control" id="hematie" >
                                    </div>
                                </div> 
                                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                                    <div class="form-group">
                                        <label>Clue-cells : </label>
                                        <input name="clue" value="<?php echo $_SESSION['formexamencoprologie_parasitairee'][NUM_PAGE]["clue"]; ?>"  placeholder="" type="text" class="form-control" id="clue" >
                                    </div>
                                </div> 
                                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                                    <div class="form-group">
                                        <label>Cellules &eacute;pith&eacute;liales : </label>
                                        <input name="cellule" value="<?php echo $_SESSION['formexamencoprologie_parasitairee'][NUM_PAGE]["cellule"]; ?>"  placeholder="" type="text" class="form-control" id="cellule" >
                                    </div>
                                </div> 
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label>Type de la cristaux vaginale : </label>
                                        <input name="cristaux" value="<?php echo $_SESSION['formexamencoprologie_parasitairee'][NUM_PAGE]["cristaux"]; ?>"  placeholder="" type="text" class="form-control" id="cristaux">
                                    </div>
                                </div> 
                            </div>
                            
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <label>Interpretaion et conclusion : </label>
                                            <textarea name="interpretation" placeholder="" class="form-control" id="interpretation"><?php echo $_SESSION['formexamencoprologie_parasitairee'][NUM_PAGE]['interpretation']; ?></textarea>
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
        $('#edit_note').bootstrapValidator({
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
//        $('#edit_note').bootstrapValidator('validate');
//    });
//
//    $('#resetBtn').click(function() {
//        $('#edit_note').data('bootstrapValidator').resetForm(true);
//    });
    });
</script>
