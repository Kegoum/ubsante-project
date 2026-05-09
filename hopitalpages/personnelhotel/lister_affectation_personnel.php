<?php
if (isset($_REQUEST["personnel"])) {
    $id = $_REQUEST["personnel"];
    $rslt = $con->query("select * from hotel_personnel as pe left join hotel_affectation as af on "
            . "pe.id_personnel=af.id_personnel left join service_point_hotel as spa on "
            . "af.id_service_point_hotel=spa.id_service_point_hotel left join hotel_point_hotel as pa on "
            . "spa.id_point_hotel=pa.id_point_hotel left join hotel_service as s on spa.id_service=s.id_service "
            . "where pe.id_personnel='" . $id . "'") or die(mysqli_error($con));
    $row = mysqli_fetch_assoc($rslt);
    ?>
<div class="row">
    <div class="col-lg-12">
        <!--<a href="javascript:history.go(-1)" class="btn btn-success btn-sm pull-left">Pr&eacute;c&eacute;dent</a>-->
        <h2 class="page-header">
            Liste <small> des Affectations de <?php echo $row["prenom_pe"]; ?> <?php echo $row["nom_pe"]; ?> - <?php echo $row["code_pe"]; ?></small>
            <?php
            if (isset($_SESSION["login_proprietaire"]) && isset($_SESSION["mot_de_passe_proprietaire"])) {
                ?>
                <a href="indexadmin.php?page=<?php echo base64_encode('hotelpages/personnelhotel/affecter_personnel') ?>&personnel=<?php echo $id ?>" class="pull-right">
                    <img src="hotelimages/process-icon-new.png" title="Nouveau" alt="Nouveau">
                </a>
                <?php
            }
            ?>
        </h2>
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover" id="dataTables-client">
                <thead>
                    <tr class="btn-success">
                        <th>Date</th>
                        <th>Point Hotel</th>
                        <th>Service</th>
                        <th>Etat</th>
                        <!--<th>Op&eacute;ration</th>-->
                    </tr>
                </thead>
                 <tbody>
                <?php
                // On r?cup?re les 2 derniers billets
                lister_affectation_personnel($id, $con);
                ?>
                 </tbody>
            </table>

        </div>
    </div>
</div>    
    <?php
}
?> 