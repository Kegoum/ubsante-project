
<?php ?>

<div class="single-product-tab-area mg-tb-15">
    <!-- Single pro tab review Start-->
    <div class="single-pro-review-area">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="sparkline12-list mt-b-30">
                        <div class="sparkline12-hd">
                            <div class="main-sparkline12-hd">
                                <h1>Formulaire de Valorisation des stocks</h1>
                            </div>
                        </div>
                        <form id="info_formvalorisation" name="formvalorisationinfo" enctype="multipart/form-data" method="post" action="<?php echo $url; ?>?page=<?php echo base64_encode('sotcocogpages/sotcocogbonlivraison/sotcocogvalorisation/valider'); ?>&idlignebonlivraison=<?php echo $_REQUEST["idlignebonlivraison"]; ?>&pagecom=<?php echo NUM_PAGE + 1; ?>">

                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="review-content-section">
                                        <label class="control-label">Date </label>  
                                        <div class="input-group date datejour2" data-date="" data-date-format="DD dd MM yyyy" data-link-field="datejour2" data-link-format="yyyy-mm-dd">
											<input class="form-control" size="16" type="text" value="" readonly>
											<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
											<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
										</div>
										<input class="form-control" type="hidden" id="datejour2" name="datejour" /><br/> 
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <h4>Stock Initial</h4>
                                    <div class="row">
                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                            <label class="control-label" >Quantit&eacute; </label>
                                            <div class="input-group mg-b-pro-edt">
                                                <span class="input-group-addon"><i class="fa fa-home" aria-hidden="true"></i></span>
                                                <input value="<?php echo $_SESSION['formvalorisation'][NUM_PAGE]["qtei"]; ?>" class="form-control" placeholder="" type="text" name="qtei" id="qtei" readonly/>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                            <label class="control-label" >Prix Unitaire &nbsp;</label>
                                            <div class="input-group mg-b-pro-edt">
                                                <span class="input-group-addon"><i class="fa fa-money" aria-hidden="true"></i></span>
                                                <input value="<?php echo $_SESSION['formvalorisation'][NUM_PAGE]["prixui"]; ?>" class="form-control" placeholder="" type="text" name="prixui" id="prixui" readonly />
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                            <label class="control-label" >Prix Total </label>
                                            <div class="input-group mg-b-pro-edt">
                                                <span class="input-group-addon"><i class="fa fa-money" aria-hidden="true"></i></span>
                                                <input value="<?php echo $_SESSION['formvalorisation'][NUM_PAGE]["prixti"]; ?>" class="form-control" placeholder="" type="text" name="prixti" id="prixti" readonly />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <div class="row">
                                        <h4>Entr&eacute;e</h4>
                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                            <label class="control-label" >Quantit&eacute; </label>
                                            <div class="input-group mg-b-pro-edt">
                                                <span class="input-group-addon"><i class="fa fa-home" aria-hidden="true"></i></span>
                                                <input value="<?php echo $_SESSION['formvalorisation'][NUM_PAGE]["qtee"]; ?>" class="form-control" placeholder="" type="text" name="qtee" id="qtee" readonly/>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                            <label class="control-label" >Prix Unitaire &nbsp;</label>
                                            <div class="input-group mg-b-pro-edt">
                                                <span class="input-group-addon"><i class="fa fa-money" aria-hidden="true"></i></span>
                                                <input value="<?php echo $_SESSION['formvalorisation'][NUM_PAGE]["prixue"]; ?>" class="form-control" placeholder="" type="text" name="prixue" id="prixue" readonly />
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                            <label class="control-label" >Prix Total </label>
                                            <div class="input-group mg-b-pro-edt">
                                                <span class="input-group-addon"><i class="fa fa-money" aria-hidden="true"></i></span>
                                                <input value="<?php echo $_SESSION['formvalorisation'][NUM_PAGE]["prixte"]; ?>" class="form-control" placeholder="" type="text" name="prixte" id="prixte" readonly />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <h4>Valorisation du Stock</h4>
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <div class="chosen-select-single mg-b-20">
                                        <label class="control-label" >Valorisation</label>
                                        <?php
                                        $rsltpmo1 = $con->query("select * from sot_valorisation_stock where idvalorisationstock='" . $_SESSION['formvalorisation'][NUM_PAGE]["valorisation"] . "'") or die(mysqli_error($con));
                                        ?>
                                        <select name="valorisation" id="valorisation"  class="select2_demo_2 form-control intitulemoc">
                                            <?php
                                            while ($ligne = mysqli_fetch_assoc($rsltpmo1)) {
                                                ?>
                                                <option value="<?php echo($ligne["idvalorisationstock"]); ?>" <?php if ($_SESSION['formvalorisation'][NUM_PAGE]['valorisation'] == $ligne["idvalorisationstock"]) { ?> selected <?php } ?>><?php echo($ligne["libellevalorisationstock"]); ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <input value="<?php echo $_SESSION['formvalorisation'][NUM_PAGE]["codevalorisation"]; ?>" class="form-control" placeholder="" type="hidden" name="codevalorisation" id="codevalorisation" />
                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
                                    <label class="control-label" >Transport </label>
                                    <div class="input-group mg-b-pro-edt">
                                        <span class="input-group-addon"><i class="fa fa-money" aria-hidden="true"></i></span>
                                        <input value="<?php echo $_SESSION['formvalorisation'][NUM_PAGE]["transport"]; ?>" class="form-control" placeholder="" type="text" name="transport" id="transport"  onkeyup="CalculRevient();" />
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
                                    <label class="control-label" >Frais de Gestion </label>
                                    <div class="input-group mg-b-pro-edt">
                                        <span class="input-group-addon"><i class="fa fa-money" aria-hidden="true"></i></span>
                                        <input value="<?php echo $_SESSION['formvalorisation'][NUM_PAGE]["fraisgestion"]; ?>" class="form-control" placeholder="" type="text" name="fraisgestion" id="fraisgestion" onkeyup="CalculRevient();" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <h4>Stock Final</h4>
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                    <label class="control-label" >Quantit&eacute; </label>
                                    <div class="input-group mg-b-pro-edt">
                                        <span class="input-group-addon"><i class="fa fa-home" aria-hidden="true"></i></span>
                                        <input value="<?php echo $_SESSION['formvalorisation'][NUM_PAGE]["qter"]; ?>" class="form-control" placeholder="" type="text" name="qter" id="qter" readonly/>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                    <label class="control-label" >Prix de Revient &nbsp;</label>
                                    <div class="input-group mg-b-pro-edt">
                                        <span class="input-group-addon"><i class="fa fa-money" aria-hidden="true"></i></span>
                                        <input value="<?php echo $_SESSION['formvalorisation'][NUM_PAGE]["prixur"]; ?>" class="form-control" placeholder="" type="text" name="prixur" id="prixur" readonly />
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                    <label class="control-label" >Prix Total </label>
                                    <div class="input-group mg-b-pro-edt">
                                        <span class="input-group-addon"><i class="fa fa-money" aria-hidden="true"></i></span>
                                        <input value="<?php echo $_SESSION['formvalorisation'][NUM_PAGE]["prixtr"]; ?>" class="form-control" placeholder="" type="text" name="prixtr" id="prixtr" readonly />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <b style="color: red">Champs Obligatoires *</b>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <div class="text-center mg-b-pro-edt custom-pro-edt-ds">
                                        <button type="submit" class="btn btn-primary waves-effect waves-light m-r-10">Enregistrer</button>
                                    </div>
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

        $('#captchaOperation').html([randomNumber(1, 100), '+', randomNumber(1, 200), '='].join(' '));

        $('#info_formvalorisation').bootstrapValidator({
//        live: 'disabled',
            message: 'Cette valeur est invalide',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                fournisseur: {
                    message: 'Fournisseur invalide',
                    validators: {
                        notEmpty: {
                            message: 'Le Fournisseur est obligatoire'
                        }
                    }
                },
                devise: {
                    validators: {
                        notEmpty: {
                            message: 'La Devise est obligatoire'
                        }
                    }
                },
                paiement: {
                    validators: {
                        notEmpty: {
                            message: 'Le Paiement est obligatoire'
                        }
                    }
                }
            }
        });

        // Validate the form manually
//    $('#validateBtn').click(function() {
//        $('#info_formvalorisation').bootstrapValidator('validate');
//    });
//
//    $('#resetBtn').click(function() {
//        $('#info_formvalorisation').data('bootstrapValidator').resetForm(true);
//    });
    });
</script>

<script language="JavaScript">
    $(document).ready(function () {
        CalculRevient();
    });
    function CalculRevient()
    {
        document.getElementById("qter").value = "";
        document.getElementById("prixur").value = "";
        document.getElementById("prixtr").value = "";
        var qi = parseFloat(document.getElementById("qtei").value);
        var pi = parseFloat(document.getElementById("prixui").value);
        var ti = parseFloat(document.getElementById("prixti").value);

        var qe = parseFloat(document.getElementById("qtee").value);
        var pe = parseFloat(document.getElementById("prixue").value);
        var te = parseFloat(document.getElementById("prixte").value);

        var transport = parseFloat(document.getElementById("transport").value);
//        alert(transport);
        var fg = parseFloat(document.getElementById("fraisgestion").value);
        var code = (document.getElementById("codevalorisation").value);
//        alert(code);
        if (pi > 0)
        {
            if (code = "CUMPFE") {
                var q = qi + qe;
                var t = ti + te + transport + fg;
                var p = t / q;
//            Math.max(a,b) donne le plus grand entre a et b
//              toFixed(2) limite à 2 chiffres après la virgule
                document.getElementById("qter").value = (Math.max((((q))), 0)).toFixed(2);
                document.getElementById("prixur").value = (Math.max((((p))), 0)).toFixed(2);
                document.getElementById("prixtr").value = (Math.max((((t))), 0)).toFixed(2);
            }

        } else {
            if (code = "CUMPFE") {
                var q = qe;
                var t = te + transport + fg;
//        alert(fg);
                var p = t / q;
//            Math.max(a,b) donne le plus grand entre a et b
//              toFixed(2) limite à 2 chiffres après la virgule
                document.getElementById("qter").value = (Math.max((((q))), 0)).toFixed(2);
                document.getElementById("prixur").value = (Math.max((((p))), 0)).toFixed(2);
                document.getElementById("prixtr").value = (Math.max((((t))), 0)).toFixed(2);
            }
        }
    }

</script>
