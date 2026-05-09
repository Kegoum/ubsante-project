
<?php
if (isset($_REQUEST["client"])) {
    $ch = $_REQUEST["client"];
    $rslt = $con->query("select * from hotel_client where id_client='" . $ch . "'") or die(mysqli_error($con));
    $row = mysqli_fetch_assoc($rslt);
    ?>
    <div class="row">
        <div class="col-lg-12">
            <!--<a href="javascript:history.go(-1)" class="btn btn-success btn-sm pull-left">Pr&eacute;c&eacute;dent</a>-->
            <h2 class="page-header">Liste des dossiers de <small> <?php echo $row["nom_client"]; ?> <?php echo $row["prenom_client"]; ?> - <?php echo $row["cni_client"]; ?></small></h2>
            <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover" id="dataTables-client">
                <thead>
                    <tr class="btn-success">
                            <th>Code</th>
                            <th>H&ocirc;tel</th>
                            <th>Logement</th>
                            <th>Prix U</th>
                            <th>Montant</th>
                            <th>Nombre de personnes</th>
                        <th>Date Entr&eacute;e</th>
                        <th>Date Sortie</th>
                            <th>Op&eacute;ration</th>
                        </tr>
                    </thead>
                <tbody>
                    <?php
                    // On r?cup?re les 2 derniers billets
                    lister_dossier_client($ch,$con);
                    ?>
                </tbody>
                </table>

            </div>
        </div>
    </div>   
    <?php
}
?> 