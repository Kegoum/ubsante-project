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
                        <form id="ajout_param" name="formconsultation" enctype="multipart/form-data" method="post" action="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitalconsultation/hopitalajouter/ajout_consultation'); ?>&idconsultation=<?php echo $_REQUEST["idconsultation"]; ?>&pagecom=<?php echo NUM_PAGE + 1; ?>" style="padding: 2%;">
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
                                <div class="col-xs-12 col-sm-4 col-md-4">
                                    <div class="form-group">
                                        <label>1 - Motif consultation</label>
                                        <input name="but" value="<?php echo $_SESSION['formconsultation'][NUM_PAGE]["but"]; ?>"  placeholder="" type="text" class="form-control" id="but" required >
                                    </div>
                                </div> 
                                <div class="col-xs-12 col-sm-4 col-md-4">
                                    <div class="form-group">
                                        <label>2 - Histoire de la maladie actuelle</label>
                                        <input name="histoireconsultation" value="<?php echo $_SESSION['formconsultation'][NUM_PAGE]["histoireconsultation"]; ?>"  placeholder="" type="text" class="form-control" id="histoireconsultation" >
                                    </div>
                                </div>  
                                <div class="col-xs-12 col-sm-4 col-md-4">
                                    <div class="form-group">
                                        <label>3 - Autom&eacute;dication</label>
                                        <input name="automedicationconsultation" value="<?php echo $_SESSION['formconsultation'][NUM_PAGE]["automedicationconsultation"]; ?>"  placeholder="" type="text" class="form-control" id="automedicationconsultation" >
                                    </div>
                                </div>  
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <h3>
                                        4 - Ant&eacute;c&eacute;dents personnels 
                                    </h3>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-4 col-md-4">
                                    <div class="form-group" style="margin-left:15px;">
                                        <label>4.1 - M&eacute;dico-m&eacute;dicamenteux</label>
                                        <input name="medicoconsultation" value="<?php echo $_SESSION['formconsultation'][NUM_PAGE]["medicoconsultation"]; ?>"  placeholder="" type="text" class="form-control" id="medicoconsultation" >
                                    </div>
                                </div> 
                                <div class="col-xs-12 col-sm-4 col-md-4">
                                    <div class="form-group">
                                        <label>4.2 - Immunoallergiques</label>
                                        <input name="immunoallergiqueconsultation" value="<?php echo $_SESSION['formconsultation'][NUM_PAGE]["immunoallergiqueconsultation"]; ?>"  placeholder="" type="text" class="form-control" id="immunoallergiqueconsultation" >
                                    </div>
                                </div> 
                                <div class="col-xs-12 col-sm-4 col-md-4">
                                    <div class="form-group">
                                        <label>4.3 - Chirurgicaux</label>
                                        <input name="chirurgieconsultation" value="<?php echo $_SESSION['formconsultation'][NUM_PAGE]["chirurgieconsultation"]; ?>"  placeholder="" type="text" class="form-control" id="chirurgieconsultation" >
                                    </div>
                                </div>   
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-4 col-md-4">
                                    <div class="form-group" style="margin-left:15px;">
                                        <label>4.5 - Ant&eacute;nataux / nataux / Postnataux / D&eacute;veloppement psychomoteur / Alimentation</label>
                                        <input name="natauxconsultation" value="<?php echo $_SESSION['formconsultation'][NUM_PAGE]["natauxconsultation"]; ?>"  placeholder="" type="text" class="form-control" id="natauxconsultation" >
                                    </div>
                                </div> 
                                <div class="col-xs-12 col-sm-4 col-md-4">
                                    <div class="form-group">
                                        <label>4.6 - Etat vaccinal</label>
                                        <input name="vaccinconsultation" value="<?php echo $_SESSION['formconsultation'][NUM_PAGE]["vaccinconsultation"]; ?>"  placeholder="" type="text" class="form-control" id="vaccinconsultation" >
                                    </div>
                                </div>  
                                <div class="col-xs-12 col-sm-4 col-md-4">
                                    <div class="form-group">
                                        <label>4.7 - Gyn&eacute;cologiques et Obst&eacute;tricaux</label>
                                        <input name="gynecoobstetriqueconsultation" value="<?php echo $_SESSION['formconsultation'][NUM_PAGE]["gynecoobstetriqueconsultation"]; ?>"  placeholder="" type="text" class="form-control" id="gynecoobstetriqueconsultation" >
                                    </div>
                                </div> 
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-4 col-md-4">
                                    <div class="form-group" style="margin-left:15px;">
                                        <label>4.8 - Toxicologiques</label>
                                        <input name="toxicoconsultation" value="<?php echo $_SESSION['formconsultation'][NUM_PAGE]["toxicoconsultation"]; ?>"  placeholder="" type="text" class="form-control" id="toxicoconsultation" >
                                    </div>
                                </div> 
                                <div class="col-xs-12 col-sm-4 col-md-4">
                                    <div class="form-group">
                                        <label>4.9 - Environnementaux</label>
                                        <input name="environnementconsultation" value="<?php echo $_SESSION['formconsultation'][NUM_PAGE]["environnementconsultation"]; ?>"  placeholder="" type="text" class="form-control" id="environnementconsultation" >
                                    </div>
                                </div>   
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-4 col-md-4">
                                    <div class="form-group">
                                        <label>5 - Ant&eacute;c&eacute;dents Familiaux</label>
                                        <input name="antefamilialeconsultation" value="<?php echo $_SESSION['formconsultation'][NUM_PAGE]["antefamilialeconsultation"]; ?>"  placeholder="" type="text" class="form-control" id="antefamilialeconsultation" >
                                    </div>
                                </div>  
                                <div class="col-xs-12 col-sm-4 col-md-4">
                                    <div class="form-group">
                                        <label>6 - Examen physique</label>
                                        <input name="examenphysiqueconsultation" value="<?php echo $_SESSION['formconsultation'][NUM_PAGE]["examenphysiqueconsultation"]; ?>"  placeholder="" type="text" class="form-control" id="examenphysiqueconsultation" >
                                    </div>
                                </div> 
                                <div class="col-xs-12 col-sm-4 col-md-4">
                                    <div class="form-group">
                                        <label>7 - Diagnostique(s)</label>
                                        <input name="diagnostique" value="<?php echo $_SESSION['formconsultation'][NUM_PAGE]["diagnostique"]; ?>"  placeholder="" type="text" class="form-control" id="diagnostique" >
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
