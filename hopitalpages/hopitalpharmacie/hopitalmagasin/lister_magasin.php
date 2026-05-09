<div class="data-table-area mg-b-15">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="sparkline13-list">
                    <div class="sparkline13-hd">
                        <div class="main-sparkline13-hd">
                            <h1> Liste des produits de 
                                <?php
                                if (isset($_SESSION["nompharmacie"])) {
                                    echo $_SESSION["nompharmacie"];
                                }
                                if (isset($_REQUEST["pharmacie"])) {
                                    $rsltuser = $con->query("select * from hp_pharmacie where idpharmacie='" . $_REQUEST["pharmacie"] . "' ") or die(mysqli_error($con));
                                    $recuser = mysqli_fetch_assoc($rsltuser);
                                    echo $recuser["nompharmacie"];
                                }
                                ?>
                            </h1>
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
                        <th>D.C.I. /Principe actif</th>
                                        <th>Stock</th>
                                        <th>Stock min</th>
                                        <th>Stock max</th>
                                        <th>Prix vente</th>
                                        <th>Etat</th>
                                        <!--<th>Op&eacute;ration</th>-->
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (isset($_REQUEST["pharmacie"])) {
                                        lister_boutique($_REQUEST["pharmacie"], $con);
                                    }
                                    if (isset($_SESSION["idpharmacie"])) {
                                        lister_boutique($_SESSION["idpharmacie"], $con);
                                    }
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