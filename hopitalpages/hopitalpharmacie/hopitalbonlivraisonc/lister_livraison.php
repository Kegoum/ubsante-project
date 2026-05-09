<?php
$codeb = "BAR";
$codebr = "BARESTO";

    $rsltservb = $con->query("select * from service_point_hotel as spa left join hotel_service as s on "
            . "spa.id_service=s.id_service where spa.id_point_hotel='" . $_SESSION["id_point_hotel"] . "' "
            . "and (s.code_service='" . $codeb . "')") or die(mysqli_error($con));
    $rowservb = mysqli_fetch_assoc($rsltservb);
	$rsltservbrb = $con->query("select * from service_point_hotel as spa left join hotel_service as s on "
            . "spa.id_service=s.id_service where spa.id_point_hotel='" . $_SESSION["id_point_hotel"] . "' "
            . "and ((s.code_service='" . $codebr . "'))") or die(mysqli_error($con));
    $rowservbrb = mysqli_fetch_assoc($rsltservbrb);
	
	$rsltlivb = $con->query("select DISTINCT(bc.id_pharmacie) as pharmaciea from hotel_bon_livraison_interne as bc where (((bc.id_service_point_hotel='" . $rowservb["id_service_point_hotel"] . "') or (bc.id_service_point_hotel='" . $rowservbrb["id_service_point_hotel"] . "'))and bc.id_pharmacie is not null)") or die(mysqli_error($con));
    

                    ?>
<div class="data-table-area mg-b-15">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="sparkline13-list">
                    <div class="sparkline13-hd">
                        <div class="main-sparkline13-hd">
        <h1>Liste des bons de livraison de ,,,,,
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
                        lister_livraison_pharmacie($_REQUEST["pharmacie"], $con);
                    }else if (isset($_SESSION["idpharmacie"])) {
                        lister_livraison_pharmacie($_SESSION["idpharmacie"],$con);
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