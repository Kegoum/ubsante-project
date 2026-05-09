<?php $page_active="Point Hotel"; ?>
<?php
if (isset($_REQUEST["pointhotel"])) {
    $idpointa = $_REQUEST["pointhotel"];
    $rslt = $conn->query("select * from hotel_point_hotel where id_point_hotel='" . $idpointa . "'") or die(mysqli_error($conn));
    $row = mysqli_fetch_assoc($rslt);
    ?>
    <div class="data-table-area mg-b-15">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="sparkline13-list">
                    <div class="sparkline13-hd">
                        <div class="main-sparkline13-hd">
                            <h1>Liste des Services de <small> <?php echo $row["nom_ph"] ?> </small></h1>
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
                                        <!--<th data-field="state" data-checkbox="true"></th>-->
                            <th>Nom Service</th>
                            <th>Contact</th>
                            <th>Op&eacute;ration</th>
                        </tr>
                    </thead>
                <tbody>
                    <?php
                    // On r?cup?re les 2 derniers billets
                    lister_servicepa($idpointa,$conn);
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