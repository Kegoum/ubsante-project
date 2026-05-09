
<div class="single-product-tab-area mg-tb-15">
    <!-- Single pro tab review Start-->
    <div class="single-pro-review-area">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="sparkline12-list mt-b-30">
                        <div class="sparkline12-hd">
                            <div class="main-sparkline12-hd">
                                <h1 style=" text-align: center;">Compte rendu d'exploitation echographique</h1>
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
                        <form id="edit_note" name="formechographieobstetricalee" enctype="multipart/form-data" method="post" action="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitalechographie/hopitalobstetricale/hopitalediter/edit_echographie'); ?>&idobstetricale=<?php echo $_REQUEST["idobstetricale"]; ?>&pagecom=<?php echo NUM_PAGE + 1; ?>" style="padding: 2%;">
                            <input type="hidden" name="idacte" value="<?php echo $_SESSION['formechographieobstetricalee'][NUM_PAGE]['idacte'] ?>" id="idacte"/>&nbsp;&nbsp;
<input type="hidden" name="idechographiepatient" value="<?php echo $_SESSION['formechographieobstetricalee'][NUM_PAGE]['idechographiepatient'] ?>" id="idechographiepatient"/>&nbsp;&nbsp;

                            <div class="row">
                                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                                    <div class="form-group">
                                        <label>DDR : </label>
                                        <input name="ddr" value="<?php echo $_SESSION['formechographieobstetricalee'][NUM_PAGE]["ddr"]; ?>"  placeholder="" type="date" class="form-control" id="ddr" >
                                    </div>
                                </div> 
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label>Examen demand&eacute; par : </label>
                                        <input name="prescripteur" value="<?php echo $_SESSION['formechographieobstetricalee'][NUM_PAGE]["prescripteur"]; ?>"  placeholder="" type="text" class="form-control" id="but" >
                                    </div>
                                </div> 
                                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                                    <div class="form-group">
                                        <label>Type d’examen : </label>
                                        <input name="designatione" value="<?php echo $rowe["nomechographie"]; ?>"  placeholder="" type="text" class="form-control" id="designatione" >
                                    </div>
                                </div> 
                            </div> 
                            <div class="row">
                                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label>Indication : </label>
                                        <input name="indication" value="<?php echo $_SESSION['formechographieobstetricalee'][NUM_PAGE]["indication"]; ?>"  placeholder="" type="text" class="form-control" id="indication">
                                    </div>
                                </div> 
                                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label>Date d'examen : </label>
                                        <input name="datejour" value="<?php echo $_SESSION['formechographieobstetricalee'][NUM_PAGE]["datejour"]; ?>"  placeholder="" type="date" class="form-control" id="datejour" required >
                                    </div>
                                </div> 
                                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label>Heure : </label>
                                        <input name="heurejour" value="<?php echo $_SESSION['formechographieobstetricalee'][NUM_PAGE]["heurejour"]; ?>"  placeholder="" type="time" class="form-control" id="heurejour" >
                                    </div>
                                </div> 
                            </div> 

                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style=" text-align: center;">
                                    <h4><u>RESULTATS</u></h4>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
                                    <div class="form-group">
                                        <label>Localisation de la grossesse : </label>
                                        <input name="localisation" value="<?php echo $_SESSION['formechographieobstetricalee'][NUM_PAGE]["localisation"]; ?>"  placeholder="" type="text" class="form-control" id="localisation">
                                    </div>
                                </div> 
                                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-">
                                    <div class="form-group">
                                        <label>Nombre de foetus : </label>
                                        <input name="nbfoetus" value="<?php echo $_SESSION['formechographieobstetricalee'][NUM_PAGE]["nbfoetus"]; ?>"  placeholder="" type="text" class="form-control" id="nbfoetus">
                                    </div>
                                </div> 
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <label>* Signes de vitalit&eacute; : </label>
                                </div> 
                            </div>
                            <div class="row"> 
                                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label>Mouvements actifs : </label>
                                        <input name="mouvement" value="<?php echo $_SESSION['formechographieobstetricalee'][NUM_PAGE]["mouvement"]; ?>"  placeholder="" type="text" class="form-control" id="mouvement" >
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label>Activit&eacute; cardiaque : </label>
                                        <input name="ac" value="<?php echo $_SESSION['formechographieobstetricalee'][NUM_PAGE]["ac"]; ?>"  placeholder="" type="text" class="form-control" id="ac" >
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label>Fr&eacute;quence cardiaque ... battements par minutes: </label>
                                        <input name="frequencecardiaque" value="<?php echo $_SESSION['formechographieobstetricalee'][NUM_PAGE]["frequencecardiaque"]; ?>"  placeholder="" type="text" class="form-control" id="frequencecardiaque" >
                                    </div>
                                </div>  
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <label>* Biom&eacute;trie : </label>
                                </div> 
                            </div>
                            <div class="row"> 
                                <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
                                    <div class="form-group">
                                        <label>BIP ... mm : </label>
                                        <input name="bip" value="<?php echo $_SESSION['formechographieobstetricalee'][NUM_PAGE]["bip"]; ?>"  placeholder="" type="text" class="form-control" id="bip" >
                                    </div>
                                </div> 
                                <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
                                    <div class="form-group">
                                        <label>PC ...mm : </label>
                                        <input name="pc" value="<?php echo $_SESSION['formechographieobstetricalee'][NUM_PAGE]["pc"]; ?>"  placeholder="" type="text" class="form-control" id="pc" >
                                    </div>
                                </div> 
                                <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
                                    <div class="form-group">
                                        <label>PA ... mm : </label>
                                        <input name="pa" value="<?php echo $_SESSION['formechographieobstetricalee'][NUM_PAGE]["pa"]; ?>"  placeholder="" type="text" class="form-control" id="pa" >
                                    </div>
                                </div> 
                                <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
                                    <div class="form-group">
                                        <label>LF ... mm : </label>
                                        <input name="longueurfemorale" value="<?php echo $_SESSION['formechographieobstetricalee'][NUM_PAGE]["longueurfemorale"]; ?>"  placeholder="" type="text" class="form-control" id="longueurfemorale" >
                                    </div>
                                </div> 
                                <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
                                    <div class="form-group">
                                        <label>RCF ... bpm : </label>
                                        <input name="rcf" value="<?php echo $_SESSION['formechographieobstetricalee'][NUM_PAGE]["rcf"]; ?>"  placeholder="" type="text" class="form-control" id="rcf" >
                                    </div>
                                </div> 
                                <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
                                    <div class="form-group">
                                        <label>Poids foetal estim&eacute;  ... g : </label>
                                        <input name="poids" value="<?php echo $_SESSION['formechographieobstetricalee'][NUM_PAGE]["poids"]; ?>"  placeholder="" type="text" class="form-control" id="poids" >
                                    </div>
                                </div> 
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                                    <div class="form-group">
                                        <label>Age &eacute;chographique ... SA : </label>
                                        <input name="semaine" value="<?php echo $_SESSION['formechographieobstetricalee'][NUM_PAGE]["semaine"]; ?>"  placeholder="" type="text" class="form-control" id="semaine" >
                                    </div>
                                </div> 
                                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                                    <div class="form-group">
                                        <label>et ...jour(s) : </label>
                                        <input name="jour" value="<?php echo $_SESSION['formechographieobstetricalee'][NUM_PAGE]["jour"]; ?>"  placeholder="" type="text" class="form-control" id="jour" >
                                    </div>
                                </div> 
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label>Correspondant &agrave; une Date Probable d'Accouchement (DPA) : </label>
                                        <input name="dpa" value="<?php echo $_SESSION['formechographieobstetricalee'][NUM_PAGE]["dpa"]; ?>"  placeholder="" type="date" class="form-control" id="dpa" >
                                    </div>
                                </div> 
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <label>* &nbsp;&nbsp;&nbsp; Morphologie foetale (ventricules, c&eacute;r&eacute;baux, estomac, coeur, rachis, poumons, foie, membres, ...) : </label>
                                        <input name="morphologie" value="<?php echo $_SESSION['formechographieobstetricalee'][NUM_PAGE]["morphologie"]; ?>"  placeholder="" type="text" class="form-control" id="morphologie" >
                                    </div>
                                </div> 
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <label>* &nbsp;&nbsp;&nbsp;  Pr&eacute;sentation : </label>
                                        <input name="presentation" value="<?php echo $_SESSION['formechographieobstetricalee'][NUM_PAGE]["presentation"]; ?>"  placeholder="" type="text" class="form-control" id="presentation" >
                                    </div>
                                </div> 
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <label>* &nbsp;&nbsp;&nbsp; Placenta : </label>
                                </div> 
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label>Insertion : </label>
                                        <input name="placentai" value="<?php echo $_SESSION['formechographieobstetricalee'][NUM_PAGE]["placentai"]; ?>"  placeholder="" type="text" class="form-control" id="placentai" >
                                    </div>
                                </div> 
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label>Echo structure : </label>
                                        <input name="placentae" value="<?php echo $_SESSION['formechographieobstetricalee'][NUM_PAGE]["placentae"]; ?>"  placeholder="" type="text" class="form-control" id="placentae" >
                                    </div>
                                </div> 
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label>* &nbsp;&nbsp;&nbsp; Liquide amniostique : </label>
                                        <input name="liqam" value="<?php echo $_SESSION['formechographieobstetricalee'][NUM_PAGE]["liqam"]; ?>"  placeholder="" type="text" class="form-control" id="liqam" >
                                    </div>
                                </div> 
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label>et en quantit&eacute; : </label>
                                        <input name="qte" value="<?php echo $_SESSION['formechographieobstetricalee'][NUM_PAGE]["qte"]; ?>"  placeholder="" type="text" class="form-control" id="qte" >
                                    </div>
                                </div> 
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                                    <div class="form-group">
                                        <label>Col : </label>
                                        <input name="col1" value="<?php echo $_SESSION['formechographieobstetricalee'][NUM_PAGE]["col1"]; ?>"  placeholder="" type="text" class="form-control" id="col1" >
                                    </div>
                                </div> 
                                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                                    <div class="form-group">
                                        <label>Col long de ... mm : </label>
                                        <input name="col2" value="<?php echo $_SESSION['formechographieobstetricalee'][NUM_PAGE]["col2"]; ?>"  placeholder="" type="text" class="form-control" id="col2" >
                                    </div>
                                </div> 
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label>Sexe : </label>
                                        <input name="sexe" value="<?php echo $_SESSION['formechographieobstetricalee'][NUM_PAGE]["sexe"]; ?>"  placeholder="" type="text" class="form-control" id="sexe" >
                                    </div>
                                </div> 
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <label><u>Conclusion</u> </label>
                                        <textarea name="conclusion" placeholder="" class="form-control" id="conclusion"><?php echo $_SESSION['formechographieobstetricalee'][NUM_PAGE]['conclusion']; ?></textarea>
                                        <br />

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
