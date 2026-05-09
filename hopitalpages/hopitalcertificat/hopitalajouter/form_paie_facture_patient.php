
<script type="text/javascript">

    function versementtotal()
    {
        document.getElementById("rest").value = "";
        var montv = parseFloat(document.getElementById("montvers").value);
//        $(#formul).get(0).reset(); //Fonctionne
//        document.getElementById("ajout_facture").reset();
        vera = 0;
        if (document.getElementById("versa").value != "") {
            var vera = parseFloat(document.getElementById("versa").value);
        }
        var montt = parseFloat(document.getElementById("montt").value);
        if (montv != 0)
        {
            if ((montv + vera) > montt) {
                alert('Le montant versé est supérieur au montant total de la facture');
                document.getElementById("montvers").value = "";
            } else {
                document.getElementById("montvers").value = montv;
                document.getElementById("rest").value = (montt) - (montv + vera);
            }

        }

    }
</script>

<div class="col-md-12 col-sm-12 col-xs-12" >
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h4 style=" color: white;">Ajout d'un Paiement de la facture : <?php echo $row["codefacture"] ?></h2></h4>  
        </div>
        <form id="ajout_facture" name="formfacture" enctype="multipart/form-data" method="post" action="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalfacture/hopitalajouter/paie_facture_patient'); ?>&idfacture=<?php echo $_REQUEST["idfacture"]; ?>&pagecom=<?php echo NUM_PAGE + 1; ?>" style="padding: 2%;">

            <fieldset class="space_data"><legend class="titre">Finance</legend>
                <div class="row">
                    <div class="col-xs-4 col-sm-4 col-md-4">
                        <div class="form-group">
                            <label>Ancien versement</label>
                            <input name="versa" placeholder="Verssement" value="<?php echo $_SESSION['formfacture'][NUM_PAGE]["versa"]; ?>" type="number" class="form-control" id="versa" readonly="">
                        </div>
                    </div> 
                    <div class="col-xs-4 col-sm-4 col-md-4">
                        <div class="form-group">
                            <label>Nouveau versement</label>
                            <input name="montvers" placeholder="Verssement" value="<?php echo $_SESSION['formfacture'][NUM_PAGE]["montvers"]; ?>" type="number" onblur="versementtotal();" class="form-control" id="montvers" required>
                        </div>
                    </div> 
                    <div class="col-xs-4 col-sm-4 col-md-4">
                        <div class="form-group">
                            <label>Montant Facture</label>
                            <input name="montt" value="<?php echo $_SESSION['formfacture'][NUM_PAGE]["montt"]; ?>" placeholder="Montant Total" type="number" class="form-control" id="montt" readonly="" required>
                        </div>
                    </div>  
                </div>
                <div class="row">
                    <div class="col-xs-4 col-sm-4 col-md-4">
                        <div class="form-group">
                            <label>Reste</label>
                            <input name="reste" value="<?php echo $_SESSION['formfacture'][NUM_PAGE]["reste"]; ?>" pattern="^([0-9]+)$" maxlength="254" placeholder="Reste &agrave; payer" type="text" class="form-control" id="rest" readonly>
                        </div>
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4">
                        <?php
                        $rsltp = $con->query("select * from hp_mode_paiement as mp ") or die(mysqli_error($con));
                        ?>
                        <div class="chosen-select-single">
                            <label class="control-label">Mode de paiement &nbsp;<g>*</g></label>
                            <select data-placeholder="Choisissez un Mode de paiement..." class="select2_demo_3 form-control" name="paiement" id="paiement" required>
                                <option value=""> - Choisissez le Mode de paiement - </option>
                                <?php
                                while ($rowp = mysqli_fetch_assoc($rsltp)) {
                                    ?>
                                    <option value="<?php echo $rowp["idmodepaiement"]; ?>" <?php if ($rowp["idmodepaiement"] == $_SESSION['formfacture'][NUM_PAGE]["paiement"]) { ?> selected <?php } ?>><?php echo $rowp["libellemodepaiement"]; ?> </option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>  
                    <div class="col-xs-4 col-sm-4 col-md-4">
                        <div class="form-group">
                            <label>Date du jour</label>
                            <input name="datejour" value="<?php echo $_SESSION['formfacture'][NUM_PAGE]["datejour"]; ?>"  placeholder="date de paiement" type="date" class="form-control" id="datejour">
                        </div>
                    </div> 
                </div>
            </fieldset> 
            <div class="row">
                <div class=" panel-footer">
                    <div class="row">
                        <br>
                        <div class="col-sm-12">
                            <b style="color: red">Champs Obligatoires *</b>
                        </div>
                        <br>
                        <div class="col-sm-12 text-center">
                            <center><button id="validateBtn" type="submit" name="insfacture" class="btn btn-success"><i class="glyphicon glyphicon-check"></i> Enregistrer</button>
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

<script type="text/javascript">
    $(document).ready(function() {
        // Generate a simple captcha
        function randomNumber(min, max) {
            return Math.floor(Math.random() * (max - min + 1) + min);
        }
        ;
        $('#captchaOperation').html([randomNumber(1, 100), '+', randomNumber(1, 200), '='].join(' '));
        $('#ajout_facture').bootstrapValidator({
//        live: 'disabled',
            message: 'Cette valeur est invalide',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                nom: {
                    message: 'Nom de l\'facture invalide',
                    validators: {
                        notEmpty: {
                            message: 'Le nom de l\'facture est obligatoire'
                        }
                    }
                },
                prenom: {
                    message: 'Prenom de l\'facture invalide',
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
//        $('#ajout_facture').bootstrapValidator('validate');
//    });
//
//    $('#resetBtn').click(function() {
//        $('#ajout_facture').data('bootstrapValidator').resetForm(true);
//    });
    });
</script>
