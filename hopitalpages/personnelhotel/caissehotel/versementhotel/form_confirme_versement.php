
<div class="row">
    <div class="col-sm-3"></div>
    <div class="col-sm-6">
        <!--<a href="javascript:history.go(-1)" class="btn btn-success btn-sm pull-left">Pr&eacute;c&eacute;dent</a>-->
        <h3 class=" text-center">Formulaire de Versement </h3>  
        <form id="versement_form" name="formversement" enctype="multipart/form-data" method="post" action="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/personnelhotel/caissehotel/versementhotel/versement'); ?>&pageversautre=<?php echo NUM_PAGE + 1; ?>">
            <h3 style="text-align: center">Confirmez vous ce Versement ? </h3>
            <div class="row ">
                <div class="col-sm-12">
                    <h4>Montant : <?php echo number_format($_SESSION['formversautre'][1]["montant"], 0, ',', ' '); ?> F CFA </h4>
                </div> 
            </div>  
            <div class="row ">
                <div class="col-sm-12">
                    <h4>But : <?php echo nl2br(htmlspecialchars($_SESSION['formversautre'][1]["but"])); ?> </h4>
                </div> 
            </div>  
            <div class="row pull-right">
                <div class="col-sm-12">
                    <a href="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/personnelhotel/caissehotel/versementhotel/versement'); ?>&pageversautre=<?php echo NUM_PAGE - 1; ?>" class="btn btn-success" type="submit"><i class="icon-backward"></i> Pr&eacute;c&eacute;dent</a>&nbsp;
                    <button type="reset" class="btn btn-danger"><i class="icon-remove"></i> Effacer</button>
                    <button type="submit" name="insversautre" class="btn btn-success"><i class="icon-check"></i> Confirmer</button>

                </div>
            </div>
        </form>
    </div>
    <div class="col-sm-3"></div>
</div>  