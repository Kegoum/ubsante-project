
<div class="data-table-area mg-b-15">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="sparkline13-list">
                    <div class="sparkline13-hd">
                        <div class="main-sparkline13-hd">
                            <?php
                            if ((isset($_SESSION["loginproprietaire"]) && isset($_SESSION["motdepasseproprietaire"])) || ((($_SESSION["rolepersonnel"] == "Directeur de Centre") || ($_SESSION["rolepersonnel"] == "Chef de Service") || ($_SESSION["rolepersonnel"] == "Médecin") || ($_SESSION["rolepersonnel"] == "Magasinier")))) {
                                ?>
                                <div >
                                    <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalmagasin/hopitalboncommande/commande'); ?>" class="btn btn-primary btn-sm pull-right"><i class="glyphicon glyphicon-plus"></i> Ajouter</a>
                                </div>
                                <?php
                            }
                            ?>
                            <h1>Liste des bons de commande </h1>
                        </div>
                    </div>
                    <div class="sparkline13-graph">
                        <div class="datatable-dashv1-list custom-datatable-overright">
                            <div id="toolbar">
                                <select class="form-control dt-tb">
                                    <option value="">Exporter</option>
                                    <option value="all">Exporter Tout</option>
                                    <option value="selected">Exporter la Selection</option>
                                </select>
                            </div>
                            <table id="table" data-toggle="table" data-pagination="true" data-search="true" data-show-columns="true" data-show-pagination-switch="true" data-show-refresh="true" data-key-events="true" data-show-toggle="true" data-resizable="true" data-cookie="true"
                                   data-cookie-id-table="saveId" data-show-export="true" data-click-to-select="true" data-toolbar="#toolbar">
                                <thead>
                                    <tr>
                                        <th data-field="state" data-checkbox="true"></th>
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
                                    if (isset($_REQUEST["idmagasin"])) {
                                        lister_commande($_REQUEST["idmagasin"], $con);
                                    }
                                    if (isset($_SESSION["idmagasin"])) {
                                        lister_commande($_SESSION["idmagasin"], $con);
                                    }
                                    ?>
                                </tbody>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>