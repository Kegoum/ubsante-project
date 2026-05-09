
<?php

    ?>
    <div class="row">
        <div class="col-sm-3"></div>
        <div class="col-sm-6 well">
            <!--<a href="javascript:history.go(-1)" class="btn btn-info btn-sm pull-left">Pr&eacute;c&eacute;dent</a>--> 
             <fieldset><legend>Liste <small> des Factures</small></legend>
            <form id="entreesortiej_form" role="form" name="form_annee" action="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalfacture/facture_p'); ?>" method="post">
                <div class="row">

                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group" style="margin-left:15px;">
                            <label class="control-label" >Date Début &nbsp;<g>*</g></label>
                            <div class="inputGroupContainer">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                    <input value="" class="form-control"   placeholder="Date Début" type="date" name="dated" id="dated" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group" style="margin-left:15px;">
                            <label class="control-label" >Date Fin &nbsp;<g>*</g></label>
                            <div class="inputGroupContainer">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                    <input value="" class="form-control"   placeholder="Date Fin" type="date" name="datef" id="datef" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class=" panel-footer">
                    <div class="row">
                        <br>
                        <div class="col-sm-12">
                            <b style="color: red">Champs Obligatoires *</b>
                        </div>
                        <br>
                        <div class="col-sm-12 text-center">
                            <center><button id="validateBtn" type="submit" name="recherchep" class="btn btn-success"><i class="glyphicon glyphicon-check"></i> Enregistrer</button>
                                <button type="reset" id="resetBtn" class="btn btn-primary"><i class="glyphicon glyphicon-remove"></i> Effacer</button>
                                <a href="javascript:history.go(-1)" class="btn btn-primary"><i class="glyphicon glyphicon-backward"></i> Quitter</a>
                            </center><br>
                        </div>
                    </div>
                </div>
            </form>

        </fieldset>
        </div>
        <div class="col-sm-3"></div>
    </div>
    <?php

?>