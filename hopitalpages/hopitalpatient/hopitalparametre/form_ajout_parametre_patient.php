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
    function calculPoint(i)
    {
//        alert("kkookk");
        var pointcompo = 0;
        var param = 0;
        if ((document.getElementById("pointcompo").value) != "") {
            pointcompo = parseFloat(document.getElementById("pointcompo").value);
        }
        if ((document.getElementById("param" + i).value) != "") {
            param = parseFloat(document.getElementById("param" + i).value);
        }
        if (pointcompo < param) {
            alert('Le valeurminbre de point saisie est supérieur à celui de la composition');
            document.getElementById("param" + i).value = "";
        }
    }

    $(document).ready(function() {

        $("#composition").change(function() {
            var moid = $(this).val();
            document.getElementById("pointcompo").value = "";
            $.ajax({
                url: './ubschoolpages/hopitalparametre/getpoint.php',
                type: 'post',
                data: {ma: moid},
                dataType: 'json',
                success: function(response) {

                    var lenv = response.length;
                    for (var i = 0; i < lenv; i++) {
                        var point = response[i]['point'];
                        document.getElementById("pointcompo").value = point;
                    }
//                    calculPoint();
                }
            });
        });

    });

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
                                    Param&egrave;tres de : <?php
                                    if ($rowpcon != NULL) {
                                        echo $rowpcon["codepatient"];
                                        ?> <?php echo $rowpcon["nompatient"]; ?> <?php
                                        echo $rowpcon["prenompatient"];
                                    } else if ($rowpexa != NULL) {
                                        echo $rowpexa["codepatient"];
                                        ?> <?php echo $rowpexa["nompatient"]; ?> <?php
                                        echo $rowpexa["prenompatient"];
                                    } else if ($rowpord != NULL) {
                                        echo $rowpord["codepatient"];
                                        ?> <?php echo $rowpord["nompatient"]; ?> <?php
                                        echo $rowpord["prenompatient"];
                                    }
                                    ?>
                                </h1>

                                <div class="alert alert-info"><em style="color: #FC331C">Veuillez cocher les lignes a remplir</em></div>
                            </div>
                        </div>
                        <form id="ajout_param" name="formparametrepatient" enctype="multipart/form-data" method="post" action="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitalparametre/hopitalajouter/ajout_parametre_patient'); ?>&idconsultation=<?php echo $_REQUEST["idconsultation"]; ?>&pagecom=<?php echo NUM_PAGE + 1; ?>" style="padding: 2%;">

                            <div class="row">
                                <div class="col-xs-12 col-sm-6 col-md-6">
                                    <div class="form-group">
                                        <label>Date du jour</label>
                                        <input required name="datejour" value="<?php echo $_SESSION['formparametrepatient'][NUM_PAGE]["datejour"]; ?>"  placeholder="date des parametres" type="date" class="form-control" id="datejour0">
                                    </div>
                                </div> 
                                <div class="col-xs-12 col-sm-6 col-md-6">
                                    <div class="form-group">
                                        <label>heure du jour</label>
                                        <input required name="heurejour" value="<?php echo $_SESSION['formparametrepatient'][NUM_PAGE]["heurejour"]; ?>"  placeholder="heure des parametres" type="time" class="form-control" id="heurejour">
                                    </div>
                                </div> 
                            </div>
                            <table class="table table-bordered table-striped table-condensed" border="0">
                                <thead>
                                    <tr class="btn-info ">
                                        <!--<th>Mati&egrave;re</th>-->
                                        <th><input onclick="CocheTout(this, 'tparam[]');" type="checkbox" /> Param&egrave;tre</th>
                                        <th>Valeur minimale</th>
                                        <th>Valeur maximale</th>
                                        <th>Valeur du patient</th>
                                    </tr>
                                </thead>
                                <?php
                                $gq = $_SESSION['formparametrepatient'][NUM_PAGE]['nbparametre'];
//                echo "<script language='javascript'>alert($gq)</script>";
                                $aq = 0;
                                if ($gq > 0) {
                                    while ($aq < $gq) {
                                        ?>
                                        <tr>
                                            <td>
                                                <input type="hidden" name="parametre<?php echo $aq; ?>" value="<?php echo $_SESSION['formparametrepatient'][NUM_PAGE]['parametre' . $aq] ?>"/>&nbsp;&nbsp;
                                                <input type="hidden" name="libelle<?php echo $aq; ?>" value="<?php echo $_SESSION['formparametrepatient'][NUM_PAGE]['libelle' . $aq] ?>"/>&nbsp;&nbsp;
                                                <input type="hidden" name="valeurmin<?php echo $aq; ?>" value="<?php echo $_SESSION['formparametrepatient'][NUM_PAGE]['valeurmin' . $aq] ?>"/>&nbsp;&nbsp;
                                                <input type="hidden" name="valeurmax<?php echo $aq; ?>" value="<?php echo $_SESSION['formparametrepatient'][NUM_PAGE]['valeurmax' . $aq] ?>"/>&nbsp;&nbsp;
                                                <input type="hidden" name="unite<?php echo $aq; ?>" value="<?php echo $_SESSION['formparametrepatient'][NUM_PAGE]['unite' . $aq] ?>"/>&nbsp;&nbsp;
                                                <input type="checkbox" name="tparam[]" <?php if (in_array($aq, $_SESSION['formparametrepatient'][NUM_PAGE]['tparam[]'])) { ?> checked <?php } ?> value="<?php echo $aq ?>"/>&nbsp;&nbsp;
                                                <?php print nl2br(htmlspecialchars($_SESSION['formparametrepatient'][NUM_PAGE]['libelle' . $aq])); ?>
                                            </td>
                                            <td>
                                                <?php print nl2br(htmlspecialchars($_SESSION['formparametrepatient'][NUM_PAGE]['valeurmin' . $aq])); ?> <?php echo $_SESSION['formparametrepatient'][NUM_PAGE]['unite' . $aq] ?>
                                            </td>
                                            <td>
                                                <?php print nl2br(htmlspecialchars($_SESSION['formparametrepatient'][NUM_PAGE]['valeurmax' . $aq])); ?> <?php echo $_SESSION['formparametrepatient'][NUM_PAGE]['unite' . $aq] ?>
                                            </td>
                                            <td>
                                                <input type="text" value="<?php echo $_SESSION['formparametrepatient'][NUM_PAGE]['param' . $aq]; ?>" name="param<?php echo $aq ?>" id="param<?php echo $aq ?>"  placeholder="La param" class="form-control"> 
                                            </td>
                                        </tr>
                                        <?php
                                        $aq = $aq + 1;
                                    }
                                }
                                ?>
                                <input type="hidden" value="<?php echo $_SESSION['formparametrepatient'][NUM_PAGE]['nbparametre']; ?>" name="nbparametre" class="form-control">
                            </table>
                            <div class="row">
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                    <b style="color: red">Champs Obligatoires *</b>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                    <center><button id="validateBtn" type="submit" name="insparam" class="btn btn-success"><i class="glyphicon glyphicon-check"></i> Enregistrer</button>
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
