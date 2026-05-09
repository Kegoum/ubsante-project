
<div class="single-product-tab-area mg-tb-15">
    <!-- Single pro tab review Start-->
    <div class="single-pro-review-area">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="sparkline12-list mt-b-30">
                        <div class="sparkline12-hd">
                            <div class="main-sparkline12-hd">
                                <h1 style=" text-align: center;">Compte rendu de l'exploration echographique</h1>
                                <h5>
                                    <small> Nons et pr&eacute;noms : </small> 
                                    <?php echo $row["nompatient"]; ?> <?php echo $row["prenompatient"]; ?>
                                </h5>

                                <h5>
                                    <small>Age / Sexe : </small>
                                    <?php
                                    if ($row["datenaissancepatient"] != NULL) {
                                        $date = date('Y-m-d');
                                        $daten = ageBirthday($row["datenaissancepatient"]);
                                        ?>
                                        <?php echo $daten; ?> ans / <?php
                                        echo $row["sexepatient"];
                                    }
                                    ?>
                                </h5>
                            </div>
                        </div>
                        <form id="edit_note" name="formechographieabdominopelviennee" enctype="multipart/form-data" method="post" action="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitalechographie/hopitalabdominopelvienne/hopitalediter/edit_echographie'); ?>&idabdominopelvienne=<?php echo $_REQUEST["idabdominopelvienne"]; ?>&pagecom=<?php echo NUM_PAGE + 1; ?>" style="padding: 2%;">
                            <input type="hidden" name="idacte" value="<?php echo $_SESSION['formechographieabdominopelviennee'][NUM_PAGE]['idacte'] ?>" id="idacte"/>&nbsp;&nbsp;
                            <input type="hidden" name="idechographiepatient" value="<?php echo $_SESSION['formechographieabdominopelviennee'][NUM_PAGE]['idechographiepatient'] ?>" id="idechographiepatient"/>&nbsp;&nbsp;

                            <div class="row">
                                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label>PRESCRIPTEUR : </label>
                                        <input name="prescripteur" value="<?php echo $_SESSION['formechographieabdominopelviennee'][NUM_PAGE]["prescripteur"]; ?>"  placeholder="" type="text" class="form-control" id="but" >
                                    </div>
                                </div> 
                                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label>INDICATION : </label>
                                        <input name="indication" value="<?php echo $_SESSION['formechographieabdominopelviennee'][NUM_PAGE]["indication"]; ?>"  placeholder="" type="text" class="form-control" id="indication">
                                    </div>
                                </div> 
                                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                                    <div class="form-group">
                                        <label>Type d’examen : </label>
                                        <input name="designatione" value="<?php echo $rowe["nomechographie"]; ?>"  placeholder="" type="text" class="form-control" id="designatione" >
                                    </div>
                                </div> 
                                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label>Date d'examen : </label>
                                        <input name="datejour" value="<?php echo $_SESSION['formechographieabdominopelviennee'][NUM_PAGE]["datejour"]; ?>"  placeholder="" type="date" class="form-control" id="datejour" required >
                                    </div>
                                </div>
                            </div> 
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style=" text-align: center;">
                                    <h4><u>RESULTATS</u></h4>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <label>&Eacute;tage Abdominale : </label>
                                        <textarea name="abdominale" placeholder="" class="form-control" id="abdominale"><?php echo $_SESSION['formechographieabdominopelviennee'][NUM_PAGE]['abdominale']; ?></textarea>
                                        <br />

                                        <script type="text/javascript">
                                            CKEDITOR.replace('abdominale', {});
                                        </script>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <label>&Eacute;tage Pelvienne : </label>
                                        <textarea name="pelvienne" placeholder="" class="form-control" id="pelvienne"><?php echo $_SESSION['formechographieabdominopelviennee'][NUM_PAGE]['pelvienne']; ?></textarea>
                                        <br />

                                        <script type="text/javascript">
                                            CKEDITOR.replace('pelvienne', {});
                                        </script>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <label><u>Conclusion</u> </label>
                                        <textarea name="conclusion" placeholder="conclusion" class="form-control" id="conclusion"><?php echo $_SESSION['formechographieabdominopelviennee'][NUM_PAGE]['conclusion']; ?></textarea>
                                        <script type="text/javascript">
                                            CKEDITOR.replace('conclusion', {});
                                        </script>
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
