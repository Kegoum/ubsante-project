<?php
if (isset($_REQUEST["personnel"])) {
    $id = $_REQUEST["personnel"];
    $rslt = $con->query("select * from hotel_personnel as pe left join hotel_affectation as af on pe.id_personnel=af.id_personnel 
        left join service_point_hotel as spa on af.id_point_hotel=spa.id_point_hotel and af.id_service=spa.id_service 
        where pe.id_personnel='" . $id . "'") or die(mysqli_error($con));
    $row = mysqli_fetch_assoc($rslt); ?>
<div class="row">
    <div class="col-lg-12">
        <!--<a href="javascript:history.go(-1)" class="btn btn-success btn-sm pull-left">Pr&eacute;c&eacute;dent</a>-->
        <h2 class="page-header">Main Courante <small> de <?php echo $row["nom_pe"] ?>  <?php echo $row["prenom_pe"] ?> </small></h2>
            <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover" id="dataTables-client">
                <thead>
                    <tr class="btn-success">
                        <th>Nom</th>
                        <th>Pr&eacute;nom</th>
                        <th>T&eacute;l&eacute;phone</th>
                        <th>Email</th>
                        <th>Point d'Hotel</th>
                        <th>Service</th>
                        <th>Date</th>
                        <th>Compte</th>
                        <th>Op&eacute;ration</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                // On r?cup?re les 2 derniers billets
                main_courante($id,$con);
                ?>
                </tbody>
            </table>
    </div>
</div>   
<?php
}
?>