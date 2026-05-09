
<div class="single-product-tab-area mg-tb-15">
    <!-- Single pro tab review Start-->
    <div class="single-pro-review-area">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="sparkline12-list mt-b-30">
                        <div class="sparkline12-hd">
                            <div class="main-sparkline12-hd">
                                <h2>SYSTEME NATIONAL D'INFORMATION SANITAIRE</h2>

                                <h3> RAPPORT MENSUEL D'ACTIVITES DES CENTRES DE SANTE INTEGRES ET ASSIMILES</h3>
                            </div>
                        </div>
                        <form id="entreesortiej_form" role="form" name="form_annee" action="hopitalpages/hopitalinformationsanitaire/informationsanitaire_pdf.php" target="blank" method="post">
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group" style="margin-left:15px;">
                                        <label for="moisis" class="control-label">Mois <g>*</g></label>
                                        <div class="input-group date moisis" data-date="" data-date-format="MM yyyy" data-link-field="moisis" data-link-format="MM yyyy">
                                            <input class="form-control" size="16" type="text" name="mois" value="" readonly>
                                            <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                                            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                        </div>
                                        <input class="form-control" type="hidden" id="moisis" name="moisis" value=""  /><br/> 
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
?>