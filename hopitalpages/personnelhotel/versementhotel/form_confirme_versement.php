<?php
$rslt = $con->query("select * from hotel_personnel as pe left join hotel_affectation as af on "
        . "pe.id_personnel=af.id_personnel left join service_point_hotel as spa on "
        . "af.id_service_point_hotel=spa.id_service_point_hotel left join hotel_point_hotel as pa on "
        . "spa.id_point_hotel=pa.id_point_hotel left join hotel_service as s on spa.id_service=s.id_service "
        . "where pe.id_personnel='" . $_REQUEST["personnel"] . "'") or die(mysqli_error($con));
$row = mysqli_fetch_assoc($rslt);
?>
<div class="row">
    <div class="col-sm-3"></div>
    <div class="col-sm-6">
        <!--<a href="javascript:history.go(-1)" class="btn btn-success btn-sm pull-left">Pr&eacute;c&eacute;dent</a>-->
        <h3 class=" text-center">Formulaire de Versement de <small> <?php echo $row["nom_pe"]; ?> <?php echo $row["prenom_pe"]; ?> - <?php echo $row["tel_pe"]; ?></small></h3>  
        <form id="versement_form" name="formversement" enctype="multipart/form-data" method="post" action="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/personnelhotel/versementhotel/versement'); ?>&pagevoy=<?php echo NUM_PAGE + 1; ?>&personnel=<?php echo $_REQUEST["personnel"] ?>">
            <h3 style="text-align: center">Confirmez vous ce Versement ? </h3>
            <div class="row ">
                <div class="col-sm-6">
                    <h4>Montant : <?php echo number_format($_SESSION['formvoy'][1]["montant"], 0, ',', ' '); ?> F CFA </h4>
                </div> 
            </div>  
            <div class="row">
                <div class="col-sm-6 col-sm-offset-6">
                    <a href="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/personnelhotel/versementhotel/versement'); ?>&pagevoy=<?php echo NUM_PAGE - 1; ?>&personnel=<?php echo $_REQUEST["personnel"] ?>" class="btn btn-success" type="submit"><i class="icon-backward"></i> Pr&eacute;c&eacute;dent</a>&nbsp;
                    <button type="reset" class="btn btn-danger"><i class="icon-remove"></i> Effacer</button>
                    <button type="submit" name="insvoy" class="btn btn-success"><i class="icon-check"></i> Confirmer</button>

                </div>
            </div>
        </form>
    </div>
    <div class="col-sm-3"></div>
</div>  