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

//    $(function() {
//        $('#datecj').datepicker();
//        $('#datecj').on('changeDate', function(ev) {
//            $(this).datepicker('hide');
//        });
//        $('#datedcp').datepicker();
//        $('#datedcp').on('changeDate', function(ev) {
//            $(this).datepicker('hide');
//        });
//        $('#datefcp').datepicker();
//        $('#datefcp').on('changeDate', function(ev) {
//            $(this).datepicker('hide');
//        });
//    });
//
//    }
</script>
<div class="col-xs-12 col-sm-12 col-md-12 well">
    <!--<a href="javascript:history.go(-1)" class="btn btn-success btn-sm pull-left">Pr&eacute;c&eacute;dent</a>--> 
    <fieldset><legend> Contr&ocirc;le Journalier</legend>
        <?php
        if (isset($_SESSION["login_proprietaire"]) && (isset($_SESSION["mot_de_passe_proprietaire"]))) {
            ?>
            <form id="entreesortiej_form" role="form" name="form_annee" action="indexadmin.php?page=<?php echo base64_encode('hotelpages/personnelhotel/caissehotel/entresortiehotel/entre_sortie_j'); ?>" method="post">
                <div id="alerte" class="alert alert-danger" style="display:none"> <strong>La date de fin doit être postérieure à la date de debut !</strong> </div>
                <div class="row">
                    <div class="col-sm-3"></div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <input name="datecj" placeholder="Veuillez entrer un jour" type="text" class="validate[required,custom[date],past[NOW]] text-input form-control"  id="datecj" data-date-format="yyyy-mm-dd">
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <input type="submit" id="Submitcj" class="btn btn-success" name="storecj" value="Affiche">
                    </div> <br />
                </div>    
            </form>
            <?php
        } else if (isset($_SESSION["login_personnel"]) && (isset($_SESSION["mot_de_passe_personnel"])) && ($_SESSION["etat_compte_personnel"])) {
            if (($_SESSION["code_service"] == "DG")) {
                ?>
                <form id="entreesortiej_form" role="form" name="form_annee" action="indexdg.php?page=<?php echo base64_encode('hotelpages/personnelhotel/caissehotel/entresortiehotel/entre_sortie_j'); ?>" method="post">
                    <div id="alerte" class="alert alert-danger" style="display:none"> <strong>La date de fin doit être postérieure à la date de debut !</strong> </div>
                    <div class="row">
                        <div class="col-sm-3"></div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <input name="datecj" placeholder="Veuillez entrer un jour" type="text" class="validate[required,custom[date],past[NOW]] text-input form-control"  id="datecj" data-date-format="yyyy-mm-dd">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <input type="submit" id="Submitcj" class="btn btn-success" name="storecj" value="Affiche">
                        </div> <br />
                    </div>    
                </form>
                <?php
            }
        }
        ?>
    </fieldset>
    <fieldset><legend>Contr&ocirc;le P&eacute;riodique</legend>
        <?php
        if (isset($_SESSION["login_proprietaire"]) && (isset($_SESSION["mot_de_passe_proprietaire"]))) {
            ?>
            <form id="entreesortiep_form" role="form" name="form_annee" action="indexadmin.php?page=<?php echo base64_encode('hotelpages/personnelhotel/caissehotel/entresortiehotel/entre_sortie_p'); ?>'); ?>" method="post">
                <div id="alertcp" class="alert alert-danger" style="display:none"> <strong>La date de fin doit être postérieure à la date de debut !</strong> </div>
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <input name="datedcp" placeholder="Votre D&eacute;but de p&eacute;riode" type="text" class="validate[required,custom[date],past[NOW]] text-input form-control"  id="datedcp" data-date-format="yyyy-mm-dd">
                            <div class="alert alert-block alert-danger alertdatedcp" style="display:none">
                                <h4>Erreur !</h4>
                                D&eacute;but de p&eacute;riode invalide !
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <input name="datefcp" placeholder="Votre Fin de p&eacute;riode" type="text" class="validate[required,custom[date],future[datedcp]] text-input form-control" id="datefcp" data-date-format="yyyy-mm-dd" >
                            <div class="alert alert-block alert-danger alertdatefcp" style="display:none">
                                <h4>Erreur !</h4>
                                Fin de p&eacute;riode invalide !
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <input type="submit" id="Submitcp" class="btn btn-success" name="storecp" value="Afficher">
                    </div>
                </div>
            </form>
            <?php
        } else if (isset($_SESSION["login_personnel"]) && (isset($_SESSION["mot_de_passe_personnel"])) && ($_SESSION["etat_compte_personnel"])) {
            if (($_SESSION["code_service"] == "DG")) {
                ?>
                <form id="entreesortiep_form" role="form" name="form_annee" action="indexdg.php?page=<?php echo base64_encode('hotelpages/personnelhotel/caissehotel/entresortiehotel/entre_sortie_p'); ?>'); ?>" method="post">
                    <div id="alertcp" class="alert alert-danger" style="display:none"> <strong>La date de fin doit être postérieure à la date de debut !</strong> </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <input name="datedcp" placeholder="Votre D&eacute;but de p&eacute;riode" type="text" class="validate[required,custom[date],past[NOW]] text-input form-control"  id="datedcp" data-date-format="yyyy-mm-dd">
                                <div class="alert alert-block alert-danger alertdatedcp" style="display:none">
                                    <h4>Erreur !</h4>
                                    D&eacute;but de p&eacute;riode invalide !
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <input name="datefcp" placeholder="Votre Fin de p&eacute;riode" type="text" class="validate[required,custom[date],future[datedcp]] text-input form-control" id="datefcp" data-date-format="yyyy-mm-dd" >
                                <div class="alert alert-block alert-danger alertdatefcp" style="display:none">
                                    <h4>Erreur !</h4>
                                    Fin de p&eacute;riode invalide !
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <input type="submit" id="Submitcp" class="btn btn-success" name="storecp" value="Afficher">
                        </div>
                    </div>
                </form>
                <?php
            }
        }
        ?>
    </fieldset>
</div>