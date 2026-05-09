
<script type="text/javascript">

    function testDecaissement()
    {
        document.getElementById("rest").value = "";
        var montv = parseFloat(document.getElementById("montvers").value);
//        $(#formul).get(0).reset(); //Fonctionne
//        document.getElementById("ajout_facture").reset();
        montt = 0;
        if (document.getElementById("montant").value != "") {
            var montt = parseFloat(document.getElementById("montant").value);
        }
        if (montv != 0)
        {
            if ((montv) > montt) {
                alert('Le montant versé est supérieur au montant total en caisse');
                document.getElementById("montvers").value = "";
                document.getElementById("rest").value = (montt);
            } else {
                document.getElementById("montvers").value = montv;
                document.getElementById("rest").value = (montt) - (montv);
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
                                <h1>Cr&eacute;er un d&eacute;caissement</h1>
                            </div>
                        </div>
                        <form id="ajout_decaissement" name="formdecaissement" enctype="multipart/form-data" method="post" action="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitaldecaissement/hopitalajouter/ajout_decaissement'); ?><?php if (isset($_REQUEST["idcaisse"])) { ?>&idcaisse=<?php echo $_REQUEST["idcaisse"]; ?><?php } ?>&pagecom=<?php echo NUM_PAGE + 1; ?>" style="padding: 2%;">
                            <div class="row">
                                <div class="col-xs-12 col-sm-4 col-md-4">
                                    <div class="form-group">
                                        <label>Montant en caisse</label>
                                        <input name="montant" placeholder="" value="<?php echo $_SESSION['formdecaissement'][NUM_PAGE]["montant"]; ?>" type="text" class="form-control" id="montant" readonly="">
                                    </div>
                                </div> 
                                <div class="col-xs-12 col-sm-4 col-md-4">
                                    <div class="form-group">
                                        <label>Montant du d&eacute;caissement</label>
                                        <input name="montvers" placeholder="" value="<?php echo $_SESSION['formdecaissement'][NUM_PAGE]["montvers"]; ?>" type="text" onblur="testDecaissement();" class="form-control" id="montvers" required>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-4 col-md-4">
                                    <div class="form-group">
                                        <label>Reste en caisse</label>
                                        <input name="reste" value="<?php echo $_SESSION['formdecaissement'][NUM_PAGE]["reste"]; ?>" placeholder="" type="text" class="form-control" id="rest" readonly>
                                    </div>
                                </div>  
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-4 col-md-4">
                                    <div class="form-group">
                                        <label>Date du jour</label>
                                        <input name="datejour" value="<?php echo $_SESSION['formdecaissement'][NUM_PAGE]["datejour"]; ?>"  placeholder="date de paiement" type="date" class="form-control" id="datejour" required>
                                    </div>
                                </div> 
                                <div class="col-xs-12 col-sm-8 col-md-8">
                                    <div class="form-group">
                                        <label class="control-label">But du d&eacute;caissement &nbsp;<g>*</g></label>
                                        <textarea class="form-control" name="but" id="but" required><?php echo $_SESSION['formdecaissement'][NUM_PAGE]["but"]; ?></textarea>
                                    </div>
                                </div> 
                            </div>
                            <div class="row">
                                <div class=" panel-footer">
                                    <div class="row">
                                        <br>
                                        <div class="col-sm-12">
                                            <b style="color: red">Champs Obligatoires *</b>
                                        </div>
                                        <br>
                                        <div class="col-sm-12 text-center">
                                            <center><button id="validateBtn" type="submit" name="insbudget" class="btn btn-success"><i class="glyphicon glyphicon-check"></i> Enregistrer</button>
                                                <button type="reset" id="resetBtn" class="btn btn-primary"><i class="glyphicon glyphicon-remove"></i> Effacer</button>
                                                <a href="javascript:history.go(-1)" class="btn btn-primary"><i class="glyphicon glyphicon-backward"></i> Quitter</a>
                                            </center><br>
                                        </div>
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
        ;
        $('#captchaOperation').html([randomNumber(1, 100), '+', randomNumber(1, 200), '='].join(' '));

//        var idcaisse = document.getElementById('idcaisse').value;
        $('#ajout_decaissement').bootstrapValidator({
//        live: 'disabled',
            message: 'Cette valeur est invalide',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                moisd: {
                    message: 'mois du decaissement invalide',
                    validators: {
                        notEmpty: {
                            message: 'Le mois du decaissement est obligatoire'
                        }
                    }
                }
            }
        });

        // Validate the form manually
//    $('#validateBtn').click(function() {
//        $('#ajout_decaissement').bootstrapValidator('validate');
//    });
//
//    $('#resetBtn').click(function() {
//        $('#ajout_decaissement').data('bootstrapValidator').resetForm(true);
//    });
    });
</script>
