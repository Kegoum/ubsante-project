<script language="JavaScript">
    jQuery(document).ready(function () {
        // binds form submission and fields to the validation engine
        jQuery("#entreesortiej_form").validationEngine('attach');
        jQuery("#entreesortiep_form").validationEngine('attach');
    });
    /**
     *
     * @param {jqObject} the field where the validation applies
     * @param {Array[String]} validation rules for this field
     * @param {int} rule index
     * @param {Map} form options
     * @return an error string if validation failed
     */
    function checkHELLO(field, rules, i, options) {
        if (field.val() != "HELLO") {
            // this allows to use i18 for the error msgs
            return options.allrules.validate2fields.alertText;
        }
    }

    $(function () {
        $('#datecj').datepicker();
        $('#datecj').on('changeDate', function (ev) {
            $(this).datepicker('hide');
        });
        $('#datedcp').datepicker();
        $('#datedcp').on('changeDate', function (ev) {
            $(this).datepicker('hide');
        });
        $('#datefcp').datepicker();
        $('#datefcp').on('changeDate', function (ev) {
            $(this).datepicker('hide');
        });
    });

</script>
<div class="row">
    <div class="col-sm-3"></div>
    <div class="col-sm-6 well">
        <!--<a href="javascript:history.go(-1)" class="btn btn-success btn-sm pull-left">Pr&eacute;c&eacute;dent</a>--> 
        <fieldset><legend> Etat Journalier du magasin</legend>
            <?php
            $rsltb = $con->query("select * from hotel_pharmacie as r left join hotel_point_hotel as ph on "
                    . "r.id_point_hotel=ph.id_point_hotel where r.id_point_hotel='" . $_SESSION["id_point_hotel"] . "'") or die(mysqli_error($con));
            if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                ?>
                <form id="entreesortiej_form" role="form" name="form_annee" action="indexadmin.php?page=<?php echo base64_encode('hotelpages/pharmaciehotel/magasinhotel/etat_magasin_hotel_j'); ?>" method="post">
                    <div id="alerte" class="alert alert-danger" style="display:none"> <strong>La date de fin doit être postérieure à la date de debut !</strong> </div>
                    <div class="row">
                            <div class="col-sm-3"></div>
                            <div class="col-sm-6">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                            <input name="datecj" placeholder="Veuillez entrer un jour" type="text" class="validate[required,custom[date],past[NOW]] text-input form-control"  id="datecj" data-date-format="yyyy-mm-dd">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                            <select name="nompharmacie" id="nompharmacie" class="validate[required] text-input form-control">
                                                <option value="" selected="selected">- Choisissez un Bar-</option>
                                                <?php
                                                /* Construction de la première liste : on se sert du tableau PHP */
                                                while ($rowb = mysqli_fetch_assoc($rsltb)) {
                                                    ?>
                                                    <option value="<?php echo($rowb["id_pharmacie"]); ?>" ><?php echo($rowb["nom_pharmacie"]); ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <input type="submit" id="Submitcj" class="btn btn-success" name="storecj" value="Affiche">
                            </div> 
                        </div>
                    </form>
                <?php
            } else if (isset($_SESSION["login_personnel"]) && (isset($_SESSION["mot_de_passe_personnel"])) && ($_SESSION["etat_compte_personnel"])) {
                if (($_SESSION["code_service"] == "ECONO")) {
                    ?>
                    <form id="entreesortiej_form" role="form" name="form_annee" action="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/pharmaciehotel/magasinhotel/etat_magasin_hotel_j'); ?>" method="post">
                        <div id="alerte" class="alert alert-danger" style="display:none"> <strong>La date de fin doit être postérieure à la date de debut !</strong> </div>
                        <div class="row">
                            <div class="col-sm-3"></div>
                            <div class="col-sm-6">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                            <input name="datecj" placeholder="Veuillez entrer un jour" type="text" class="validate[required,custom[date],past[NOW]] text-input form-control"  id="datecj" data-date-format="yyyy-mm-dd">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                            <select name="nompharmacie" id="nompharmacie" class="validate[required] text-input form-control">
                                                <option value="" selected="selected">- Choisissez un Bar-</option>
                                                <?php
                                                /* Construction de la première liste : on se sert du tableau PHP */
                                                while ($rowb = mysqli_fetch_assoc($rsltb)) {
                                                    ?>
                                                    <option value="<?php echo($rowb["id_pharmacie"]); ?>" ><?php echo($rowb["nom_pharmacie"]); ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <input type="submit" id="Submitcj" class="btn btn-success" name="storecj" value="Affiche">
                            </div> 
                        </div>
                    </form>
                    <?php
                } else if (($_SESSION["code_service"] == "DG")) {
                    ?>
                    <form id="entreesortiej_form" role="form" name="form_annee" action="indexdg.php?page=<?php echo base64_encode('hotelpages/pharmaciehotel/magasinhotel/etat_magasin_hotel_j'); ?>" method="post">
                        <div id="alerte" class="alert alert-danger" style="display:none"> <strong>La date de fin doit être postérieure à la date de debut !</strong> </div>
                        <div class="row">
                            <div class="col-sm-3"></div>
                            <div class="col-sm-6">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                            <input name="datecj" placeholder="Veuillez entrer un jour" type="text" class="validate[required,custom[date],past[NOW]] text-input form-control"  id="datecj" data-date-format="yyyy-mm-dd">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                                            <select name="nompharmacie" id="nompharmacie" class="validate[required] text-input form-control">
                                                <option value="" selected="selected">- Choisissez un Bar-</option>
                                                <?php
                                                /* Construction de la première liste : on se sert du tableau PHP */
                                                while ($rowb = mysqli_fetch_assoc($rsltb)) {
                                                    ?>
                                                    <option value="<?php echo($rowb["id_pharmacie"]); ?>" ><?php echo($rowb["nom_pharmacie"]); ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <input type="submit" id="Submitcj" class="btn btn-success" name="storecj" value="Affiche">
                            </div> 
                        </div>
                    </form>
                    <?php
                }
            }
            ?>
        </fieldset>
    </div>
    <div class="col-sm-3"></div>
</div>