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
                        <form id="ajout_param" name="formconsultationplan" enctype="multipart/form-data" method="post" action="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitalconsultation/hopitalajouterplan/ajout_consultation'); ?>&idconsultation=<?php echo $_REQUEST["idconsultation"]; ?>&pagecom=<?php echo NUM_PAGE + 1; ?>" style="padding: 2%;">
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
                            <?php
                            if ($_SESSION['formconsultationplan'][1]["decisionexamen"]) {
                                ?><b><u>Examen</u></b><?php
                                if (isset($_SESSION["cart_prodvexaplan" . $idc])) {
                                    ?>	
                                    <?php
                                    foreach ($_SESSION["cart_prodvexaplan" . $idc] as $prod) {
                                        ?>
                                        <div class="product-prod" onMouseOver="document.getElementById('remove<?php echo $prod["idart"]; ?>').style.display = 'block';"  onMouseOut="document.getElementById('remove<?php echo $prod["idart"]; ?>').style.display = '';" >
                                            <?php echo $prod["designationart"] ?> 
                                        </div>
                                        <?php
                                    }
                                }
                            }
                            if ($_SESSION['formconsultationplan'][1]["decisionechographie"]) {
                                ?><b><u>Echographie</u></b><?php
                                if (isset($_SESSION["cart_prodvechoplan" . $idc])) {
                                    ?>	
                                    <?php
                                    foreach ($_SESSION["cart_prodvechoplan" . $idc] as $prod) {
                                        ?>
                                        <div class="product-prod" onMouseOver="document.getElementById('remove<?php echo $prod["idart"]; ?>').style.display = 'block';"  onMouseOut="document.getElementById('remove<?php echo $prod["idart"]; ?>').style.display = '';" >
                                            <?php echo $prod["designationart"] ?> 
                                        </div>
                                        <?php
                                    }
                                }
                            }
                            if ($_SESSION['formconsultationplan'][1]["decisionordonnance"]) {

                                ?>
                                <br>
                                <b><u>Ordonnance</u></b><?php
                                if (isset($_SESSION["cart_prodvordplan" . $idc])) {
                                    ?>	
                                    <?php
                                    foreach ($_SESSION["cart_prodvordplan" . $idc] as $ordplan) {
                                        ?>
                                        <div class="product-prod" onMouseOver="document.getElementById('remove<?php echo $ordplan["idart"]; ?>').style.display = 'block';"  onMouseOut="document.getElementById('remove<?php echo $ordplan["idart"]; ?>').style.display = '';" >
                                            <?php echo $ordplan["designationart"] ?> &nbsp;&nbsp;
                                            <?php echo $ordplan["qteart"]; ?> <?php echo $ordplan["uniteart"]; ?>
                                        </div>
                                        <?php
                                    }
                                }
                            }
                            if ($_SESSION['formconsultationplan'][1]["decisionacte"]) {
                                ?>
                                <br>
                                <b><u>Autre</u></b><?php
                                if (isset($_SESSION["cart_prodvactplan" . $idc])) {
                                    ?>	
                                    <?php
                                    foreach ($_SESSION["cart_prodvactplan" . $idc] as $prod) {
                                        ?>
                                        <div class="product-prod" onMouseOver="document.getElementById('remove<?php echo $prod["idart"]; ?>').style.display = 'block';"  onMouseOut="document.getElementById('remove<?php echo $prod["idart"]; ?>').style.display = '';" >
                                            <?php echo $prod["designationart"] ?> 
                                        </div>
                                        <?php
                                    }
                                }
                            }
                            if ($_SESSION['formconsultationplan'][1]["decisionhospitalisation"]) {
                                
                                ?>
                                <br>
                                <b><u>Hospitalisation</u></b><?php
                                if (isset($_SESSION["cart_prodvhosplan" . $idc])) {
                                    ?>
                                    Salle : <?php
                                    $rsltpmo1 = $con->query("select * from hp_chambre as ch left join hp_categorie_chambre as cc on "
                                            . "ch.idcategoriechambre=cc.idcategoriechambre where "
                                            . "ch.idchambre='" . $_SESSION['formconsultationplan'][2]["salle"] . "'") or die(mysqli_error($con));
                                    $rowmo = mysqli_fetch_assoc($rsltpmo1);
                                    echo($rowmo["codechambre"]);
                                    ?> - <?php echo($rowmo["placechambre"]); ?> place(s) - <?php echo number_format((nl2br(htmlspecialchars(($rowmo["prixcategoriechambre"])))), 0, '.', ' '); ?>
                                    <br>
                                    Lit : <?php
                                    $req = $con->query("select * from hp_lit as l where l.idlit='" . $_SESSION['formconsultationplan'][2]["lit"] . "' ") or die(mysqli_error($con));
                                    $rowm = mysqli_fetch_array($req);
                                    echo $rowm["libellelit"];
                                    ?><br>

                                    <?php
                                    foreach ($_SESSION["cart_prodvhosplan" . $idc] as $hosplan) {
                                        ?>
                                        <div class="product-prod" onMouseOver="document.getElementById('remove<?php echo $hosplan["idart"]; ?>').style.display = 'block';"  onMouseOut="document.getElementById('remove<?php echo $hosplan["idart"]; ?>').style.display = '';" >
                                            <?php echo $hosplan["designationart"] ?> &nbsp;&nbsp;
                                            <?php echo $hosplan["prixart"]; ?> &nbsp;&nbsp;
                                            <?php echo $hosplan["dosageart"]; ?> &nbsp;&nbsp;
                                            <?php echo $hosplan["intervalleart"]; ?>&nbsp;&nbsp;
                                            <?php echo $hosplan["periodeart"]; ?> &nbsp;&nbsp;
                                            <?php echo $hosplan["dateart"]; ?> &nbsp;&nbsp;
                                            <?php echo $hosplan["heureart"]; ?>
                                        </div>
                                        <?php
                                    }
                                }
                            }
                            ?>
                            <div class="row">

                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                    <center>
                                        <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitalconsultation/hopitalajouterplan/ajout_consultation'); ?>&idconsultation=<?php echo $_REQUEST["idconsultation"]; ?>&pagecom=<?php echo NUM_PAGE - 1; ?>" class="btn btn-warning"><i class=" glyphicon glyphicon-backward"></i> Pr&eacute;c&eacute;dent</a>
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
