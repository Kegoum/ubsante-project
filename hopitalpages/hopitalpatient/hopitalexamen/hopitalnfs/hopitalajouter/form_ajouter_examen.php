<script>
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
                        <form id="ajout_note" name="formexamennfs" enctype="multipart/form-data" method="post" action="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitalexamen/hopitalnfs/hopitalajouter/ajout_examen'); ?>&idexamenpatient=<?php echo $_REQUEST["idexamenpatient"]; ?>&pagecom=<?php echo NUM_PAGE + 1; ?>" style="padding: 2%;">
                            <input type="hidden" name="laboratoire" value="<?php echo $_SESSION['formexamennfs'][NUM_PAGE]['laboratoire'] ?>" id="laboratoire"/>&nbsp;&nbsp;

                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <label>Orientation clinique : </label>
                                        <input name="orientation" value="<?php echo $_SESSION['formexamennfs'][NUM_PAGE]["orientation"]; ?>"  placeholder="" type="text" class="form-control" id="orientation">
                                    </div>
                                </div> 
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label>Date pr&eacute;l&egrave;vement : </label>
                                        <input name="prelevement" value="<?php echo $_SESSION['formexamennfs'][NUM_PAGE]["prelevement"]; ?>"  placeholder="" type="date" class="form-control" id="prelevement" required >
                                    </div>
                                </div> 
                                <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                                    <div class="form-group">
                                        <label>Prescripteur : </label>
                                        <input name="prescription" value="<?php echo $_SESSION['formexamennfs'][NUM_PAGE]["prescription"]; ?>"  placeholder="" type="text" class="form-control" id="but" >
                                    </div>
                                </div> 
                            </div>
                            <div class="alert alert-info"><em style="color: #FC331C">Veuillez cocher les lignes a remplir</em></div>

                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style=" text-align: center;">
                                    <h4><?php echo $rowe["typeexamen"]; ?></h4>
                                </div>
                            </div>
                            <table class="table table-bordered table-striped table-condensed" border="0">
                                <thead>
                                    <tr class="btn-info ">
                                        <th>El&eacute;ments</th>
                                        <th rowspan="2">Valeurs patients</th>
                                        <th colspan="4">Valeurs normales</th>
                                    </tr>

                                    <tr class="btn-info ">
                                        <th><input onclick="CocheTout(this, 'tligne[]');" type="checkbox" /> </th>
                                        <th>0 &agrave; 29 jours</th>
                                        <th><= 6 ans</th>
                                        <th>Adultes Femmes</th>
                                        <th>Adultes Hommes</th>
                                    </tr>
                                </thead>
                                <?php
                                $gq = $_SESSION['formexamennfs'][NUM_PAGE]['nbexamen'];
//                echo "<script language='javascript'>alert($gq)</script>";
                                $aq = 0;
                                if ($gq > 0) {
                                    while ($aq < $gq) {
                                        ?>
                                        <tr>
                                            <td>
                                                <input type="hidden" name="idlignenfs<?php echo $aq; ?>" value="<?php echo $_SESSION['formexamennfs'][NUM_PAGE]['idlignenfs' . $aq] ?>" id="idlignenfs<?php echo $aq ?>"/>&nbsp;&nbsp;
                                                <input type="hidden" name="lib<?php echo $aq; ?>" value="<?php echo $_SESSION['formexamennfs'][NUM_PAGE]['lib' . $aq] ?>"/>&nbsp;&nbsp;
                                                <input type="hidden" name="code<?php echo $aq; ?>" value="<?php echo $_SESSION['formexamennfs'][NUM_PAGE]['code' . $aq] ?>"/>&nbsp;&nbsp;
                                                <input type="hidden" name="min29<?php echo $aq; ?>" value="<?php echo $_SESSION['formexamennfs'][NUM_PAGE]['min29' . $aq] ?>"/>&nbsp;&nbsp;
                                                <input type="hidden" name="max29<?php echo $aq; ?>" value="<?php echo $_SESSION['formexamennfs'][NUM_PAGE]['max29' . $aq] ?>"/>&nbsp;&nbsp;
                                                <input type="hidden" name="min6<?php echo $aq; ?>" value="<?php echo $_SESSION['formexamennfs'][NUM_PAGE]['min6' . $aq] ?>"/>&nbsp;&nbsp;
                                                <input type="hidden" name="max6<?php echo $aq; ?>" value="<?php echo $_SESSION['formexamennfs'][NUM_PAGE]['max6' . $aq] ?>"/>&nbsp;&nbsp;
                                                <input type="hidden" name="minf<?php echo $aq; ?>" value="<?php echo $_SESSION['formexamennfs'][NUM_PAGE]['minf' . $aq] ?>"/>&nbsp;&nbsp;
                                                <input type="hidden" name="maxf<?php echo $aq; ?>" value="<?php echo $_SESSION['formexamennfs'][NUM_PAGE]['maxf' . $aq] ?>"/>&nbsp;&nbsp;
                                                <input type="hidden" name="minh<?php echo $aq; ?>" value="<?php echo $_SESSION['formexamennfs'][NUM_PAGE]['minh' . $aq] ?>"/>&nbsp;&nbsp;
                                                <input type="hidden" name="maxh<?php echo $aq; ?>" value="<?php echo $_SESSION['formexamennfs'][NUM_PAGE]['maxh' . $aq] ?>"/>&nbsp;&nbsp;
                                                <input type="checkbox" name="tligne[]" <?php if (in_array($aq, $_SESSION['formexamennfs'][NUM_PAGE]['tligne[]'])) { ?> checked <?php } ?> value="<?php echo $aq ?>"/>&nbsp;&nbsp;
                                                <?php print nl2br(htmlspecialchars($_SESSION['formexamennfs'][NUM_PAGE]['lib' . $aq])); ?> 
                                                (<?php print nl2br(htmlspecialchars($_SESSION['formexamennfs'][NUM_PAGE]['code' . $aq])); ?>)
                                            </td>
                                            <td>
                                                <input type="text" value="<?php echo $_SESSION['formexamennfs'][NUM_PAGE]['valeur' . $aq]; ?>" name="valeur<?php echo $aq ?>" id="valeur<?php echo $aq ?>" placeholder="" class="" >
                                            </td>
                                            <td>
                                                <?php print nl2br(htmlspecialchars($_SESSION['formexamennfs'][NUM_PAGE]['min29' . $aq])); ?> - 
                                                <?php print nl2br(htmlspecialchars($_SESSION['formexamennfs'][NUM_PAGE]['max29' . $aq])); ?>
                                            </td>
                                            <td>
                                                <?php print nl2br(htmlspecialchars($_SESSION['formexamennfs'][NUM_PAGE]['min6' . $aq])); ?> - 
                                                <?php print nl2br(htmlspecialchars($_SESSION['formexamennfs'][NUM_PAGE]['max6' . $aq])); ?>
                                            </td>
                                            <td>
                                                <?php print nl2br(htmlspecialchars($_SESSION['formexamennfs'][NUM_PAGE]['minf' . $aq])); ?> - 
                                                <?php print nl2br(htmlspecialchars($_SESSION['formexamennfs'][NUM_PAGE]['maxf' . $aq])); ?>
                                            </td>
                                            <td>
                                                <?php print nl2br(htmlspecialchars($_SESSION['formexamennfs'][NUM_PAGE]['minh' . $aq])); ?> - 
                                                <?php print nl2br(htmlspecialchars($_SESSION['formexamennfs'][NUM_PAGE]['maxh' . $aq])); ?>
                                            </td>
                                        </tr>
                                        <?php
                                        $aq = $aq + 1;
                                    }
                                }
                                ?>
                                <input type="hidden" value="<?php echo $_SESSION['formexamennfs'][NUM_PAGE]['nbexamen']; ?>" name="nbexamen" id="nbexamen" class="form-control">
                            </table>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <label>Interpretaion et conclusion : </label>
                                            <textarea name="interpretation" placeholder="" class="form-control" id="interpretation"><?php echo $_SESSION['formexamennfs'][NUM_PAGE]['interpretation']; ?></textarea>
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
