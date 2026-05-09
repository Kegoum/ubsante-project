<script language="javascript">

    $(function() {
        $('#datepickerdnais').datepicker();
    });
</script>
<div class="col-md-12 col-sm-12 col-xs-12" >
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h4 style=" color: white;">Formulaire de modification d'une finance</h4>  
        </div>
        <form id="edit_finance" name="formfinancee" enctype="multipart/form-data" method="post" action="indexadmin.php?page=<?php echo base64_encode('issampages/issamfinance/issamediter/edit_finance'); ?>&idfinance=<?php echo $_REQUEST["idfinance"]; ?>&pagecom=<?php echo NUM_PAGE + 1; ?>" style="padding: 2%;">

            <input value="<?php echo $_SESSION['formfinancee'][NUM_PAGE]["idfinance"]; ?>" type="hidden" name="idfinance" id="idfinance" />

            <fieldset class="space_data"><legend class="titre">Informations Etudiant</legend>
                <div class="row">
                    <div class="col-xs-4 col-sm-4 col-md-4">
                        <div class="form-group">
                            <input name="nom" value="<?php echo $_SESSION['formfinancee'][NUM_PAGE]["nom"]; ?>" placeholder="nom" type="text" class="form-control" id="nome" onblur="verif_nom();" required>
                            <div class="alert alert-block alert-danger alertnom" style="display:none">
                                <h4>Erreur !</h4>
                                Nom invalide !
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4">
                        <div class="form-group">
                            <input name="prenom" value="<?php echo $_SESSION['formfinancee'][NUM_PAGE]["prenom"]; ?>" placeholder="pr&eacute;nom"  type="text" class="form-control" id="prenome" onblur="verif_prenom();">
                            <div class="alert alert-block alert-danger alertprenom" style="display:none">
                                <h4>Erreur !</h4>
                                Pr&eacute;nom invalide !
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4">
                        <div class="form-group">
                            <input name="datenais" value="<?php echo $_SESSION['formfinancee'][NUM_PAGE]["datenais"]; ?>" placeholder="Date de naissance" type="text" class="form-control" id="datepickerdnais" data-date-format="yyyy-mm-dd" required>
                            <div class="alert alert-block alert-danger alertdatenais" style="display:none">
                                <h4>Erreur !</h4>
                                Date de naissance invalide !
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-3 col-sm-3 col-md-3">
                        <div class="form-group">
                            <input name="lieunais" value="<?php echo $_SESSION['formfinancee'][NUM_PAGE]["lieunais"]; ?>" placeholder="Lieu de naissance"  type="text" class="form-control" id="lieunaise" onblur="verif_lieunais();">
                            <div class="alert alert-block alert-danger alertlieunais" style="display:none">
                                <h4>Erreur !</h4>
                                Lieu de naissance invalide !
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-3 col-sm-3 col-md-3">
                        <div class="form-group">
                            <select name="regor" class="form-control" required="">
                                <option value="">-R&eacute;gion d'origine-</option>
                                <option value="Yaoundé" <?php if ($_SESSION['formfinancee'][NUM_PAGE]["regor"] == "Yaoundé") { ?> selected <?php } ?>>Yaound&eacute;</option>
                                <option value="Ebolowa" <?php if ($_SESSION['formfinancee'][NUM_PAGE]["regor"] == "Ebolowa") { ?> selected <?php } ?>>Ebolowa</option>
                                <option value="Ngaoundéré" <?php if ($_SESSION['formfinancee'][NUM_PAGE]["regor"] == "Ngaoundéré") { ?> selected <?php } ?>>Ngaound&eacute;r&eacute;</option>
                                <option value="Douala" <?php if ($_SESSION['formfinancee'][NUM_PAGE]["regor"] == "Douala") { ?> selected <?php } ?>>Douala</option>
                                <option value="Bamenda" <?php if ($_SESSION['formfinancee'][NUM_PAGE]["regor"] == "Bamenda") { ?> selected <?php } ?>>Bamenda</option>
                                <option value="Bafoussam" <?php if ($_SESSION['formfinancee'][NUM_PAGE]["regor"] == "Bafoussam") { ?> selected <?php } ?>>Bafoussam</option>
                                <option value="Buéa" <?php if ($_SESSION['formfinancee'][NUM_PAGE]["regor"] == "Buéa") { ?> selected <?php } ?>>Bu&eacute;a</option>
                                <option value="Bertoua" <?php if ($_SESSION['formfinancee'][NUM_PAGE]["regor"] == "Bertoua") { ?> selected <?php } ?>>Bertoua</option>
                                <option value="Maroua" <?php if ($_SESSION['formfinancee'][NUM_PAGE]["regor"] == "Maroua") { ?> selected <?php } ?>>Maroua</option>
                                <option value="Garoua" <?php if ($_SESSION['formfinancee'][NUM_PAGE]["regor"] == "Garoua") { ?> selected <?php } ?>>Garoua</option>
                            </select>  
                        </div>
                    </div>
                    <div class="col-xs-3 col-sm-3 col-md-3">
                        <div class="form-group">
                            <input name="depor" value="<?php echo $_SESSION['formfinancee'][NUM_PAGE]["depor"]; ?>"  placeholder="D&eacute;partement d'origine" type="text" class="form-control" id="depore" onblur="verif_depor();" required>
                            <div class="alert alert-block alert-danger alertdepor" style="display:none">
                                <h4>Erreur !</h4>
                                D&eacute;partement d'origine invalide !
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-3 col-sm-3 col-md-3">
                        <div class="form-group">
                            <select name="sexe" class="form-control" required="">
                                <option value="">-Sexe-</option>
                                <option value="M" <?php if ($_SESSION['formfinancee'][NUM_PAGE]["sexe"] == "M") { ?> selected <?php } ?>>Masculin</option>
                                <option value="F" <?php if ($_SESSION['formfinancee'][NUM_PAGE]["sexe"] == "F") { ?> selected <?php } ?>>F&eacute;minin</option>
                            </select>    	
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-4 col-sm-4 col-md-4">
                        <div class="form-group">
                            <input name="quarthab" value="<?php echo $_SESSION['formfinancee'][NUM_PAGE]["quarthab"]; ?>"  placeholder="Quartier habit&eacute;" type="text" class="form-control" id="quarthabe" onblur="verif_quarthab();">
                            <div class="alert alert-block alert-danger alertquarthab" style="display:none">
                                <h4>Erreur !</h4>
                                Quartier habit&eacute; invalide !
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4">
                        <div class="form-group">
                            <input name="tel" value="<?php echo $_SESSION['formfinancee'][NUM_PAGE]["tel"]; ?>" type="number" pattern="^([0-9]+)$" maxlength="15" class="form-control" id="tele" onblur="verif_tel();" placeholder=" T&eacute;l&eacute;phone">
                            <div class="alert alert-block alert-danger alerttel" style="display:none">
                                <h4>Erreur !</h4>
                                T&eacute;l&eacute;phone invalide !
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4">
                        <div class="form-group">
                            <div class="fileupload fileupload-new" data-provides="fileupload">
                                <input type="hidden" name="photostring" value="<?php echo $_SESSION['formfinancee'][NUM_PAGE]['photostring']; ?>">
                            <img src="issamupload/finance/photo/<?php echo $_SESSION['formfinancee'][NUM_PAGE]['photostring']; ?>" style="width: 20mm; height: 20mm;">
                            <div class="fileupload-preview thumbnail" style="width: 90px; height: 95px;"></div>
                                <!--<div>-->
                                <span class="btn btn-file btn-primary"><span class="fileupload-new">Sélectionner une image</span>
                                    <span class="fileupload-exists">Changer</span><input type="file" name="photo" id="photo" /></span>
                                <a href="#" class="btn btn-primary fileupload-exists" data-dismiss="fileupload">Supprimer</a>
                                <!--</div>-->
                            </div>
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
                            <center><button id="validateBtn" type="submit" name="insfinance" class="btn btn-success"><i class="glyphicon glyphicon-check"></i> Enregistrer</button>
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
    $(document).ready(function () {
        // Generate a simple captcha
        function randomNumber(min, max) {
            return Math.floor(Math.random() * (max - min + 1) + min);
        }
        ;
        $('#captchaOperation').html([randomNumber(1, 100), '+', randomNumber(1, 200), '='].join(' '));

        var idfinance = document.getElementById('idfinance').value;
        $('#edit_finance').bootstrapValidator({
//        live: 'disabled',
            message: 'Cette valeur est invalide',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                
            }
        });

        // Validate the form manually
//    $('#validateBtn').click(function() {
//        $('#edit_finance').bootstrapValidator('validate');
//    });
//
//    $('#resetBtn').click(function() {
//        $('#edit_finance').data('bootstrapValidator').resetForm(true);
//    });
    });
</script>
