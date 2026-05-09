<div class="panel panel-default">
    <div class="panel-heading">
        Liste des bons de livraison du Bar non valid&eacute;s
    </div>
    <div class="panel-body">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover" id="dataTables-chambre">
                <thead>
                    <tr class="btn-success">
                        <th>N&deg;</th>
                        <!--<th>Service</th>-->
                        <th>Code</th>
                        <th>Montant</th>
                        <th>Etat</th>
                        <th>Date</th>
                        <th>Op&eacute;ration</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (isset($_REQUEST["pharmacie"])) {
                        lister_livraison_pharmacie_alert($_REQUEST["pharmacie"], $con);
                    }
                    if (isset($_SESSION["id_pharmacie"])) {
                        lister_livraison_pharmacie_alert($_SESSION["id_pharmacie"],$con);
                    }
                    ?>
                </tbody>
            </table>
        </div>

    </div>
</div>