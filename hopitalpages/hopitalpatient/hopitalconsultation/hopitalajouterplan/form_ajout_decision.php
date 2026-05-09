<script>

    $(document).ready(function() {
        choixDecision(document.formconsultationplan.decision.value);
    });
    function CocheTout(ref, name) {
        var form = ref;

        while (form.parentNode && form.nodeName.toLowerCase() != 'form') {
            form = form.parentNode;
        }

        var elements = form.getElementsByTagName('input');

        for (var i = 0; i < elements.length; i++) {
            if (elements[i].type == 'checkbox' && elements[i].name == name) {
                elements[i].checked = ref.checked;
            }
        }
    }

    function choixDecision(chaine)
    {
        var a = document.getElementById("divexam");
        var b = document.getElementById("divprod");

        if (chaine == 'Ordonnance') {
            b.style.display = "block";
            a.style.display = "none";
        }
        if (chaine == 'Examen') {
            a.style.display = "block";
            b.style.display = "none";
        }

    }
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

                                <div class="alert alert-info"><em style="color: #FC331C">Veuillez cocher les lignes a remplir</em></div>
                            </div>
                        </div>
                        <form id="ajout_param" name="formconsultationplan" enctype="multipart/form-data" method="post" action="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitalconsultation/hopitalajouterplan/ajout_consultation'); ?>&idconsultation=<?php echo $_REQUEST["idconsultation"]; ?>&pagecom=<?php echo NUM_PAGE + 1; ?>" style="padding: 2%;">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <label class="control-label">
                                        Quel est le plan du traitement ? <b style=" color: red">*</b>
                                    </label>
                                </div>
                                </div>
                                <div class="row">
                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
                                    <div class="custom-control custom-radio image-checkbox">
                                        <label class="custom-control-label" for="hospitalisation">
                                            <input value="Hospitalisation" <?php if ($_SESSION['formconsultationplan'][NUM_PAGE]["decisionhospitalisation"]) { ?> checked <?php } ?> type="checkbox" class="custom-control-input" id="hospitalisation" name="decisionhospitalisation">
                                            <p class="caption">Hospitalisation</p>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                                    <div class="custom-control custom-radio image-checkbox">
                                        <label class="custom-control-label" for="ordonnance">
                                            <input value="Ordonnance" <?php if ($_SESSION['formconsultationplan'][NUM_PAGE]["decisionordonnance"]) { ?> checked <?php } ?> type="checkbox" class="custom-control-input" id="ordonnance" name="decisionordonnance" >
                                            <p class="caption">Ordonnance</p>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                                    <div class="custom-control custom-radio image-checkbox">
                                        <label class="custom-control-label" for="examen">
                                            <input value="Examen" <?php if ($_SESSION['formconsultationplan'][NUM_PAGE]["decisionexamen"]) { ?> checked <?php } ?> type="checkbox" class="custom-control-input" id="examen" name="decisionexamen" >
                                            <p class="caption">Examen</p>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                                    <div class="custom-control custom-radio image-checkbox">
                                        <label class="custom-control-label" for="echographie">
                                            <input value="Echographie" <?php if ($_SESSION['formconsultationplan'][NUM_PAGE]["decisionechographie"]) { ?> checked <?php } ?> type="checkbox" class="custom-control-input" id="echographie" name="decisionechographie" >
                                            <p class="caption">Echographie</p>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                                    <div class="custom-control custom-radio image-checkbox">
                                        <label class="custom-control-label" for="acte">
                                            <input value="Acte" <?php if ($_SESSION['formconsultationplan'][NUM_PAGE]["decisionacte"]) { ?> checked <?php } ?> type="checkbox" class="custom-control-input" id="examen" name="decisionacte" >
                                            <p class="caption">Autre</p>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                    <b style="color: red">Champs Obligatoires *</b>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                    <center>
                                        <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitalconsultation/hopitalajouterplan/ajout_consultation'); ?>&idconsultation=<?php echo $_REQUEST["idconsultation"]; ?>&pagecom=<?php echo NUM_PAGE - 1; ?>" class="btn btn-primary"><i class=" glyphicon glyphicon-backward"></i> Pr&eacute;c&eacute;dent</a>
                                        <button id="validateBtn" type="submit" name="insparam" class="btn btn-success"><i class="glyphicon glyphicon-check"></i> Enregistrer</button>
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
    $(document).ready(function() {
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
