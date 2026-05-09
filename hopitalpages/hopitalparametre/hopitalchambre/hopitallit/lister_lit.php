 
<?php
if (isset($_REQUEST["idchambre"])) {
    $id = $_REQUEST["idchambre"];
    $rslt = $con->query("select * from hp_chambre where idchambre='" . $id . "'") or die(mysqli_error($con));
    $row = mysqli_fetch_assoc($rslt);
    ?>
    <div class="data-table-area mg-b-15">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="sparkline13-list">
                        <div class="sparkline13-hd">
                            <div class="main-sparkline13-hd">
                                <?php
                                $reql = $con->query("select * from hp_lit where idchambre='" . ($id) . "' and etatlit=true") or die(mysqli_error($con));
                                $nbl = mysqli_num_rows($reql);
                                if (($nbl < $row["placechambre"])) {
                                    ?>
                                    <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalparametre/hopitalchambre/hopitallit/hopitalajouter/ajout_lit'); ?>&idchambre=<?php echo $id; ?>" class="btn btn-primary btn-sm pull-right"><i class="glyphicon glyphicon-plus"></i> Ajouter</a>
                                    <?php
                                }
                                ?>
                                <h1>Liste des Lits de <?php echo $row["libellechambre"] ?></h1>
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
                                            <th>ID</th>
                                            <th>Code</th>
                                            <th>Titre</th>
                                            <th>Etat</th>
                                            <th>Statut</th>
                                            <th>Op&eacute;ration</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        lister_lit($id, $con);
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
}
?>