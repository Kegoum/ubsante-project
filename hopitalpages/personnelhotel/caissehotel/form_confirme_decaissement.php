<?php
$moi = date('m');
$an = date('Y');
$op = "Versement";
$rsltuserv = $con->query("select SUM(montant_caisse) as vers from hotel_caisse where YEAR(date_caisse)='" . $an . "' and MONTH(date_caisse)='" . $moi . "' "
        . "and caissier='" . $_SESSION["id_compte_personnel"] . "' and operation='" . $op . "'") or die(mysqli_error($con));
$rowv = mysqli_fetch_assoc($rsltuserv);
$rsltuserr = $con->query("select SUM(montant_caisse) as retr from hotel_caisse where YEAR(date_caisse)='" . $an . "' and MONTH(date_caisse)='" . $moi . "' "
        . "and caissier='" . $_SESSION["id_compte_personnel"] . "' and operation<>'" . $op . "'") or die(mysqli_error($con));
$rowr = mysqli_fetch_assoc($rsltuserr);
$soe = $rowv["vers"] - $rowr["retr"];
?>
<div class="row">
    <div class="col-sm-3"></div>
    <div class="col-sm-6">
        <!--<a href="javascript:history.go(-1)" class="btn btn-success btn-sm pull-left">Pr&eacute;c&eacute;dent</a>-->
        <h3 class=" text-center">Formulaire de D&eacute;caissement </h3>  
        <?php
        if ($soe >= $_SESSION['formdecaisse'][1]["montant"]) {
            ?>
            <form id="decaissement_form" name="formdecaissement" enctype="multipart/form-data" method="post" action="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/personnelhotel/caissehotel/decaissement'); ?>&pagevoy=<?php echo NUM_PAGE + 1; ?>">
                <h3 style="text-align: center">Confirmez vous ce D&eacute;caissement ? </h3>
                <div class="row ">
                    <div class="col-sm-12">
                        <h4>Montant : <?php echo number_format($_SESSION['formdecaisse'][1]["montant"], 0, ',', ' '); ?> F CFA </h4>
                    </div> 
                </div>  
                <div class="row">
                    <div class="col-sm-12">
                        <h4>But : <?php echo trim(htmlspecialchars($_SESSION['formdecaisse'][1]["but"])) ?></h4>
                    </div> 
                </div>  
                <div class="row ">
                    <div class="col-sm-12">
                        <h4>
                            Service : 
                            <?php
                            $rsltspa = $con->query("select * from service_point_hotel as spa left join hotel_service as s on "
                                    . "spa.id_service=s.id_service where spa.id_service_point_hotel='" . $_SESSION['formdecaisse'][1]["serviced"] . "'") or die(mysqli_error($con));
                            $rows = mysqli_fetch_assoc($rsltspa);
                            echo $rows["nom_service"];
                            ?> 
                        </h4>
                    </div> 
                </div>  
                <div class="row">
                    <div class="col-sm-12">
                        <h4>
                            Personnel : 
                            <?php
                            $rsltppa = $con->query("select * from hotel_personnel as pe where "
                                    . "id_personnel='" . $_SESSION['formdecaisse'][1]["personneld"] . "'") or die(mysqli_error($con));
                            $rowp = mysqli_fetch_assoc($rsltppa);
                            echo $rowp["code_pe"]." - ".$rowp["nom_pe"]." ".$rowp["prenom_pe"];
                            ?> 
                        </h4>
                    </div> 
                </div>  
                <div class="row pull-right">
                    <div class="col-sm-12">
                        <a href="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/personnelhotel/caissehotel/decaissement'); ?>&pagevoy=<?php echo NUM_PAGE - 1; ?>" class="btn btn-success" type="submit"><i class="icon-backward"></i> Pr&eacute;c&eacute;dent</a>&nbsp;
                        <button type="reset" class="btn btn-danger"><i class="icon-remove"></i> Effacer</button>
                        <button type="submit" name="insvoy" class="btn btn-success"><i class="icon-check"></i> Confirmer</button>

                    </div>
                </div>
            </form>
            <?php
        } else {
            ?>
            <h3 style="text-align: center">D&eacute;caissement impossible </h3>
            <div class="row ">
                <div class="col-sm-6">
                    <h4>Montant <?php echo number_format($_SESSION['formdecaisse'][1]["montant"], 0, ',', ' '); ?> F CFA insuffisant </h4>
                </div>
            </div>  
            <div class="row">
                <div class="col-sm-6 col-sm-offset-6">
                    <a href="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/personnelhotel/caissehotel/decaissement'); ?>&pagevoy=<?php echo NUM_PAGE - 1; ?>" class="btn btn-success" type="submit"><i class="icon-backward"></i> Pr&eacute;c&eacute;dent</a>&nbsp;

                </div>
            </div>
            <?php
        }
        ?>
    </div>
    <div class="col-sm-3"></div>
</div>  