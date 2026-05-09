<?php
$rslt = $con->query("select * from hotel_client as pe where pe.id_client='" . $_REQUEST["client"] . "'") or die(mysqli_error($con));
$row = mysqli_fetch_assoc($rslt);
?>
<div class="row">
    <div class="col-lg-12">
        <!--<a href="javascript:history.go(-1)" class="btn btn-success btn-sm pull-left">Pr&eacute;c&eacute;dent</a>-->
        <h3 class=" text-center">Formulaire de Versement de <small> <?php echo $row["nom_client"]; ?> <?php echo $row["prenom_client"]; ?> - <?php echo $row["cni_client"]; ?></small></h3>  
        <?php
        if (isset($_SESSION["loginproprietaire"])) {
            ?>
            <form id="versement_form" name="formversement" enctype="multipart/form-data" method="post" action="indexadmin.php?page=<?php echo base64_encode('hotelpages/clienthotel/dossierclienthotel/ajout_versement_p'); ?>&pageverp=<?php echo NUM_PAGE + 1; ?>&client=<?php echo $_REQUEST["client"] ?>">
            <?php
        } else if (($_SESSION["code_service"] == "DG")) {
            ?>
            <form id="versement_form" name="formversement" enctype="multipart/form-data" method="post" action="indexdg.php?page=<?php echo base64_encode('hotelpages/clienthotel/dossierclienthotel/ajout_versement_p'); ?>&pageverp=<?php echo NUM_PAGE + 1; ?>&client=<?php echo $_REQUEST["client"] ?>">
            <?php
        } else {
            ?>
            <form id="versement_form" name="formversement" enctype="multipart/form-data" method="post" action="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/clienthotel/dossierclienthotel/ajout_versement_p'); ?>&pageverp=<?php echo NUM_PAGE + 1; ?>&client=<?php echo $_REQUEST["client"] ?>">
            <?php
        }
        ?>
        <h3 style="text-align: center">Confirmez vous ce Versement ? </h3>
            <div class="row ">
                <div class="col-sm-6">
                    <h4>Montant : <?php echo number_format($_SESSION['formvoyp'][1]["montant"], 0, ',', ' '); ?> F CFA </h4>
                </div> 
            </div>  
            <div class="row">
                <div class="col-sm-6 col-sm-offset-6">
                    <?php
        if (isset($_SESSION["loginproprietaire"])) {
            ?>
            <a href="indexadmin.php?page=<?php echo base64_encode('hotelpages/clienthotel/dossierclienthotel/ajout_versement_p'); ?>&pageverp=<?php echo NUM_PAGE - 1; ?>&client=<?php echo $_REQUEST["client"] ?>" class="btn btn-success" type="submit"><i class="icon-backward"></i> Pr&eacute;c&eacute;dent</a>&nbsp;
                    <?php
        } else if (($_SESSION["code_service"] == "DG")) {
            ?>
            <a href="indexdg.php?page=<?php echo base64_encode('hotelpages/clienthotel/dossierclienthotel/ajout_versement_p'); ?>&pageverp=<?php echo NUM_PAGE - 1; ?>&client=<?php echo $_REQUEST["client"] ?>" class="btn btn-success" type="submit"><i class="icon-backward"></i> Pr&eacute;c&eacute;dent</a>&nbsp;
                    <?php
        } else {
            ?>
            <a href="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/clienthotel/dossierclienthotel/ajout_versement_p'); ?>&pageverp=<?php echo NUM_PAGE - 1; ?>&client=<?php echo $_REQUEST["client"] ?>" class="btn btn-success" type="submit"><i class="icon-backward"></i> Pr&eacute;c&eacute;dent</a>&nbsp;
                    <?php
        }
        ?>
                    <button type="reset" class="btn btn-danger"><i class="icon-remove"></i> Effacer</button>
                    <button type="submit" name="insvoy" class="btn btn-success"><i class="icon-check"></i> Confirmer</button>

                </div>
            </div>
        </form>
    </div>
</div>  