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
                                    Administrer le vaccin de : <?php
                                    echo $row["numerovaccin"];
                                    ?> <?php echo $row["nomvaccin"]; ?> 
                                </h1>
                            </div>
                        </div>
                        <form id="ajout_param" name="formadministrevaccin" enctype="multipart/form-data" method="post" action="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalvaccin/hopitaldossiervaccin/hopitaladministrer/administrer_vaccin'); ?>&idvaccin=<?php echo $_REQUEST["idvaccin"]; ?>&pagecom=<?php echo NUM_PAGE + 1; ?>" style="padding: 2%;">

                            <div class="row">
                                <div class="col-xs-6 col-sm-3 col-md-3">
                                    <div class="form-group">
                                        <label>Date du jour</label>
                                        <input required name="datejour" value="<?php echo $_SESSION['formadministrevaccin'][NUM_PAGE]["datejour"]; ?>"  placeholder="date de vaccination" type="date" class="form-control" id="datejour0">
                                    </div>
                                </div> 
                                <div class="col-xs-6 col-sm-3 col-md-3">
                                    <div class="form-group">
                                        <label>Date du rendez-vous</label>
                                        <input required name="daterdv" value="<?php echo $_SESSION['formadministrevaccin'][NUM_PAGE]["daterdv"]; ?>"  placeholder="date du rendez-vous" type="date" class="form-control" id="datejour1">
                                    </div>
                                </div> 
                                <div class="col-xs-12 col-sm-6 col-md-6">
                                    <div class="review-content-section">
                                        <div class="chosen-select-single mg-b-20">
                                            <label class="control-label" >Vaccin <b style="color: red">*</b></label> 
                                            <select name="vaccin[]" id="vaccin" multiple class="select2_demo_2 form-control">
                                                <option value="" >- Choisissez un Vaccin-</option>
                                                <?php
                                                /* Construction de la première liste : on se sert du tableau PHP */
                                                if ($row["bcgvaccin"] == NULL) {
                                                    ?>
                                                    <option value="bcgvaccin" <?php if ($_SESSION['formadministrevaccin'][NUM_PAGE]["vaccin"] == "bcgvaccin") { ?> selected <?php } ?>>BCG</option>
                                                    <?php
                                                }
                                                if ($row["polio0vaccin"] == NULL) {
                                                    ?>
                                                    <option value="polio0vaccin" <?php if ($_SESSION['formadministrevaccin'][NUM_PAGE]["vaccin"] == "polio0vaccin") { ?> selected <?php } ?>>POLIO 0</option>
                                                    <?php
                                                }
                                                if ($row["polio1vaccin"] == NULL) {
                                                    ?>
                                                    <option value="polio1vaccin" <?php if ($_SESSION['formadministrevaccin'][NUM_PAGE]["vaccin"] == "polio1vaccin") { ?> selected <?php } ?>>POLIO 1</option>
                                                    <?php
                                                }
                                                if ($row["polio2vaccin"] == NULL) {
                                                    ?>
                                                    <option value="polio2vaccin" <?php if ($_SESSION['formadministrevaccin'][NUM_PAGE]["vaccin"] == "polio2vaccin") { ?> selected <?php } ?>>POLIO 2</option>
                                                    <?php
                                                }
                                                if ($row["polio3vaccin"] == NULL) {
                                                    ?>
                                                    <option value="polio3vaccin" <?php if ($_SESSION['formadministrevaccin'][NUM_PAGE]["vaccin"] == "polio3vaccin") { ?> selected <?php } ?>>POLIO 3</option>
                                                    <?php
                                                }
                                                if ($row["vpivaccin"] == NULL) {
                                                    ?>
                                                    <option value="vpivaccin" <?php if ($_SESSION['formadministrevaccin'][NUM_PAGE]["vaccin"] == "vpivaccin") { ?> selected <?php } ?>>VPI</option>
                                                    <?php
                                                }
                                                if ($row["penta1vaccin"] == NULL) {
                                                    ?>
                                                    <option value="penta1vaccin" <?php if ($_SESSION['formadministrevaccin'][NUM_PAGE]["vaccin"] == "penta1vaccin") { ?> selected <?php } ?>>PENTA 1</option>
                                                    <?php
                                                }
                                                if ($row["penta2vaccin"] == NULL) {
                                                    ?>
                                                    <option value="penta2vaccin" <?php if ($_SESSION['formadministrevaccin'][NUM_PAGE]["vaccin"] == "penta2vaccin") { ?> selected <?php } ?>>PENTA 2</option>
                                                    <?php
                                                }
                                                if ($row["penta3vaccin"] == NULL) {
                                                    ?>
                                                    <option value="penta3vaccin" <?php if ($_SESSION['formadministrevaccin'][NUM_PAGE]["vaccin"] == "penta3vaccin") { ?> selected <?php } ?>>PENTA 3</option>
                                                    <?php
                                                }
                                                if ($row["pneumo1vaccin"] == NULL) {
                                                    ?>
                                                    <option value="pneumo1vaccin" <?php if ($_SESSION['formadministrevaccin'][NUM_PAGE]["vaccin"] == "pneumo1vaccin") { ?> selected <?php } ?>>PNEUMO 1</option>
                                                    <?php
                                                }
                                                if ($row["pneumo2vaccin"] == NULL) {
                                                    ?>
                                                    <option value="pneumo2vaccin" <?php if ($_SESSION['formadministrevaccin'][NUM_PAGE]["vaccin"] == "pneumo2vaccin") { ?> selected <?php } ?>>PNEUMO 2</option>
                                                    <?php
                                                }
                                                if ($row["pneumo3vaccin"] == NULL) {
                                                    ?>
                                                    <option value="pneumo3vaccin" <?php if ($_SESSION['formadministrevaccin'][NUM_PAGE]["vaccin"] == "pneumo3vaccin") { ?> selected <?php } ?>>PNEUMO 3</option>
                                                    <?php
                                                }
                                                if ($row["rota1vaccin"] == NULL) {
                                                    ?>
                                                    <option value="rota1vaccin" <?php if ($_SESSION['formadministrevaccin'][NUM_PAGE]["vaccin"] == "rota1vaccin") { ?> selected <?php } ?>>ROTA 1</option>
                                                    <?php
                                                }
                                                if ($row["rota2vaccin"] == NULL) {
                                                    ?>
                                                    <option value="rota2vaccin" <?php if ($_SESSION['formadministrevaccin'][NUM_PAGE]["vaccin"] == "rota2vaccin") { ?> selected <?php } ?>>ROTA 2</option>
                                                    <?php
                                                }
                                                if ($row["var1vaccin"] == NULL) {
                                                    ?>
                                                    <option value="var1vaccin" <?php if ($_SESSION['formadministrevaccin'][NUM_PAGE]["vaccin"] == "var1vaccin") { ?> selected <?php } ?>>VAR 1</option>
                                                    <?php
                                                }
                                                if ($row["var2vaccin"] == NULL) {
                                                    ?>
                                                    <option value="var2vaccin" <?php if ($_SESSION['formadministrevaccin'][NUM_PAGE]["vaccin"] == "var2vaccin") { ?> selected <?php } ?>>VAR 2</option>
                                                    <?php
                                                }
                                                if ($row["vaavaccin"] == NULL) {
                                                    ?>
                                                    <option value="vaavaccin" <?php if ($_SESSION['formadministrevaccin'][NUM_PAGE]["vaccin"] == "vaavaccin") { ?> selected <?php } ?>>VAA</option>
                                                    <?php
                                                }
                                                if ($row["vita6mvaccin"] == NULL) {
                                                    ?>
                                                    <option value="vita6mvaccin" <?php if ($_SESSION['formadministrevaccin'][NUM_PAGE]["vaccin"] == "vita6mvaccin") { ?> selected <?php } ?>>VITA 6 mois</option>
                                                    <?php
                                                }
                                                if ($row["vita1avaccin"] == NULL) {
                                                    ?>
                                                    <option value="vita1avaccin" <?php if ($_SESSION['formadministrevaccin'][NUM_PAGE]["vaccin"] == "vita1avaccin") { ?> selected <?php } ?>>VITA 1 an</option>
                                                    <?php
                                                }
                                                if ($row["vita1a6mvaccin"] == NULL) {
                                                    ?>
                                                    <option value="vita1a6mvaccin" <?php if ($_SESSION['formadministrevaccin'][NUM_PAGE]["vaccin"] == "vita1a6mvaccin") { ?> selected <?php } ?>>VITA 1 an 6 mois</option>
                                                    <?php
                                                }
                                                if ($row["vita2avaccin"] == NULL) {
                                                    ?>
                                                    <option value="vita2avaccin" <?php if ($_SESSION['formadministrevaccin'][NUM_PAGE]["vaccin"] == "vita2avaccin") { ?> selected <?php } ?>>VITA 2 ans</option>
                                                    <?php
                                                }
                                                if ($row["vita2a6mvaccin"] == NULL) {
                                                    ?>
                                                    <option value="vita2a6mvaccin" <?php if ($_SESSION['formadministrevaccin'][NUM_PAGE]["vaccin"] == "vita2a6mvaccin") { ?> selected <?php } ?>>VITA 2 ans 6 mois</option>
                                                    <?php
                                                }
                                                if ($row["vita3avaccin"] == NULL) {
                                                    ?>
                                                    <option value="vita3avaccin" <?php if ($_SESSION['formadministrevaccin'][NUM_PAGE]["vaccin"] == "vita3avaccin") { ?> selected <?php } ?>>VITA 3 ans</option>
                                                    <?php
                                                }
                                                if ($row["vita3a6mvaccin"] == NULL) {
                                                    ?>
                                                    <option value="vita3a6mvaccin" <?php if ($_SESSION['formadministrevaccin'][NUM_PAGE]["vaccin"] == "vita3a6mvaccin") { ?> selected <?php } ?>>VITA 3 ans 6 mois</option>
                                                    <?php
                                                }
                                                if ($row["vita4avaccin"] == NULL) {
                                                    ?>
                                                    <option value="vita4avaccin" <?php if ($_SESSION['formadministrevaccin'][NUM_PAGE]["vaccin"] == "vita4avaccin") { ?> selected <?php } ?>>VITA 4 ans</option>
                                                    <?php
                                                }
                                                if ($row["vita4a6mvaccin"] == NULL) {
                                                    ?>
                                                    <option value="vita4a6mvaccin" <?php if ($_SESSION['formadministrevaccin'][NUM_PAGE]["vaccin"] == "vita4a6mvaccin") { ?> selected <?php } ?>>VITA 4 ans 6 mois</option>
                                                    <?php
                                                }
                                                if ($row["vita5avaccin"] == NULL) {
                                                    ?>
                                                    <option value="vita5avaccin" <?php if ($_SESSION['formadministrevaccin'][NUM_PAGE]["vaccin"] == "vita5avaccin") { ?> selected <?php } ?>>VITA 5 ans</option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div> 
                            </div>
                            <div class="row">
                                <div class="col-xs-6 col-sm-3 col-md-3">
                                    <div class="form-group">
                                        <label>Masse</label>
                                        <input required name="masse" value="<?php echo $_SESSION['formadministrevaccin'][NUM_PAGE]["masse"]; ?>"  placeholder="masse de l'enfant" type="number" class="form-control" id="masse">
                                    </div>
                                </div> 
                                <div class="col-xs-6 col-sm-3 col-md-3">
                                    <div class="form-group">
                                        <label>Taille</label>
                                        <input required name="taille" value="<?php echo $_SESSION['formadministrevaccin'][NUM_PAGE]["taille"]; ?>"  placeholder="taille de l'enfant" type="number" class="form-control" id="taille">
                                    </div>
                                </div> 
                                <div class="col-xs-6 col-sm-3 col-md-3">
                                    <div class="form-group">
                                        <label>Circonférence de la tête</label>
                                        <input required name="ctete" value="<?php echo $_SESSION['formadministrevaccin'][NUM_PAGE]["ctete"]; ?>"  placeholder="circonférence de la tête de l'enfant" type="number" class="form-control" id="ctete">
                                    </div>
                                </div> 
                                <div class="col-xs-6 col-sm-3 col-md-3">
                                    <div class="form-group">
                                        <label>Circonférence de du bras</label>
                                        <input required name="cbras" value="<?php echo $_SESSION['formadministrevaccin'][NUM_PAGE]["cbras"]; ?>"  placeholder="circonférence du bras de l'enfant" type="number" class="form-control" id="cbras">
                                    </div>
                                </div> 
                            </div>
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
