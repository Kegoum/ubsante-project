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
                                    Consultation de : <?php
                                    echo $row["codepatient"];
                                    ?> <?php echo $row["nompatient"]; ?> <?php
                                    echo $row["prenompatient"];
                                    ?>
                                </h1>

                                <!--<div class="alert alert-info"><em style="color: #FC331C">Veuillez cocher les lignes a remplir</em></div>-->
                            </div>
                        </div>
                        <form id="ajout_param" name="formconsultation" enctype="multipart/form-data" method="post" action="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitalconsultation/hopitalajouter/ajout_consultation'); ?>&idconsultation=<?php echo $_REQUEST["idconsultation"]; ?>&pagecom=<?php echo NUM_PAGE + 1; ?>" style="padding: 2%;">

                            <div class="row">
                                But : <?php echo $_SESSION['formconsultation'][1]["but"]; ?><br>
                                Signe : <?php echo $_SESSION['formconsultation'][1]["signe"]; ?><br>
                                Symptome : <?php echo $_SESSION['formconsultation'][1]["symptome"]; ?><br>
                                Diagnostique : <?php echo $_SESSION['formconsultation'][1]["diagnostique"]; ?>
                            </div><br>

                            <?php
                            if ($_SESSION['formconsultation'][2]["decisionexamen"]) {
                                if (isset($_SESSION["cart_prodvexa" . $idc])) {
                                    ?>	
                                    <?php
                                    foreach ($_SESSION["cart_prodvexa" . $idc] as $prod) {
                                        ?>
                                        <div class="product-prod" onMouseOver="document.getElementById('remove<?php echo $prod["idart"]; ?>').style.display = 'block';"  onMouseOut="document.getElementById('remove<?php echo $prod["idart"]; ?>').style.display = '';" >
                                            <?php echo $prod["designationart"] ?> 
                                        </div>
                                        <?php
                                    }
                                }
                            }
                            if ($_SESSION['formconsultation'][2]["decisionordonnance"]) {

                                if (isset($_SESSION["cart_prodvord" . $idc])) {
                                    ?>	
                                    <?php
                                    foreach ($_SESSION["cart_prodvord" . $idc] as $ord) {
                                        ?>
                                        <div class="product-prod" onMouseOver="document.getElementById('remove<?php echo $ord["idart"]; ?>').style.display = 'block';"  onMouseOut="document.getElementById('remove<?php echo $ord["idart"]; ?>').style.display = '';" >
                                            <?php echo $ord["designationart"] ?> &nbsp;&nbsp;
                                            <?php echo $ord["qteart"]; ?> <?php echo $ord["uniteart"]; ?>
                                        </div>
                                        <?php
                                    }
                                }
                            }
                            if ($_SESSION['formconsultation'][2]["decisionhospitalisation"]) {
                                if (isset($_SESSION["cart_prodvhos" . $idc])) {
                                    ?>
                                    Salle : <?php
                                    $rsltpmo1 = $con->query("select * from hp_chambre as ch left join hp_categorie_chambre as cc on "
                                            . "ch.idcategoriechambre=cc.idcategoriechambre where "
                                            . "ch.idchambre='" . $_SESSION['formconsultation'][3]["salle"] . "'") or die(mysqli_error($con));
                                    $rowmo = mysqli_fetch_assoc($rsltpmo1);
                                    echo($rowmo["codechambre"]);
                                    ?> - <?php echo($rowmo["placechambre"]); ?> place(s) - <?php echo number_format((nl2br(htmlspecialchars(($rowmo["prixcategoriechambre"])))), 0, '.', ' '); ?>
                                    <br>
                                    Lit : <?php
                                    $req = $con->query("select * from hp_lit as l where l.idlit='" . $_SESSION['formconsultation'][3]["lit"] . "' ") or die(mysqli_error($con));
                                    $rowm = mysqli_fetch_array($req);
                                    echo $rowm["libellelit"];
                                    ?><br>

                                    <?php
                                    foreach ($_SESSION["cart_prodvhos" . $idc] as $hos) {
                                        ?>
                                        <div class="product-prod" onMouseOver="document.getElementById('remove<?php echo $hos["idart"]; ?>').style.display = 'block';"  onMouseOut="document.getElementById('remove<?php echo $hos["idart"]; ?>').style.display = '';" >
                                            <?php echo $hos["designationart"] ?> &nbsp;&nbsp;
                                            <?php echo $hos["prixart"]; ?>
                                        </div>
                                        <?php
                                    }
                                }
                            }
                            ?>
                            <div class="row">

                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                    <center>
                                        <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitalconsultation/hopitalajouter/ajout_consultation'); ?>&idconsultation=<?php echo $_REQUEST["idconsultation"]; ?>&pagecom=<?php echo NUM_PAGE - 1; ?>" class="btn btn-warning"><i class=" glyphicon glyphicon-backward"></i> Pr&eacute;c&eacute;dent</a>
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
