<?php
if (isset($_REQUEST["bonlivraison"])){
$rslt = $con->query("select * from hp_bon_livraison_interne as a left join hp_pharmacie as c on "
            . "a.idpharmacie=c.idpharmacie where a.idbonlivraisoninterne='".$_REQUEST["bonlivraison"]."'") or die(mysqli_error($con));
$row = mysqli_fetch_assoc($rslt);
?>
<div class="data-table-area mg-b-15">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="sparkline13-list">
                    <div class="sparkline13-hd">
                        <div class="main-sparkline13-hd">
        <h1>D&eacute;tail du bon de livraison num&eacute;ro
        <?php
        echo $row["codebonlivraisoninterne"];
        ?></h1>
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
                        <th>Code</th>
                        <th>D&eacute;signation</th>
                        <th>Cat&eacute;gorie</th>
                        <th>Stock</th>
                        <th>Prix vente</th>
                        <th>Prix total</th>
                        <th>Etat</th>
                        <th>Op&eacute;ration</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    lister_livraison_pharmacie_ligne($_REQUEST["bonlivraison"], $con);
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