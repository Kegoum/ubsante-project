<?php
if ((isset($_POST["datedcp"])) && (isset($_POST["datefcp"]))) {
    $dated = $_POST["datedcp"];
    $datef = $_POST["datefcp"];
    $montantc=0;
    $montantp=0;
    $montantn=0;
    $reqnp = $conn->query("select *  from hotel_commande_restaurant as cr left join "
            . "hotel_restaurant as r on cr.id_restaurant=r.id_restaurant where r.id_point_hotel='".$_SESSION["id_point_hotel"]."' and "
            . "(cast(cr.date_commande_r as DATE) BETWEEN '" . $dated . "' and '" . $datef . "')") or die(mysqli_error($conn));
    while($rownp = mysqli_fetch_array($reqnp)){
        $montantc=$montantc+$rownp["montant_commande_r"];
        $montantp=$montantp+$rownp["montant_commande_r_avance"];
    }
    $montantn=$montantc-$montantp;
    
     $montantbc=0;
    $montantbp=0;
    $montantbn=0;
    $reqnpb = $conn->query("select *  from hotel_commande_bar as cr left join hotel_bar as r on cr.id_bar=r.id_bar "
            . "where r.id_point_hotel='".$_SESSION["id_point_hotel"]."' and (cast(cr.date_commande_bar as DATE) "
            . "BETWEEN '" . $dated . "' and '" . $datef . "')") or die(mysqli_error($conn));
    while($rownp = mysqli_fetch_array($reqnpb)){
        $montantbc=$montantbc+$rownp["montant_commande_bar"];
        $montantbp=$montantbp+$rownp["montant_commande_bar_avance"];
    }
    $montantbn=$montantbc-$montantbp;
    $mtt = 0;
    ?>
    <div class="data-table-area mg-b-15">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="sparkline13-list">
                        <div class="sparkline13-hd">
                            <div class="main-sparkline13-hd">
                                <h1>Finances du <?php echo $dated ?> au <?php echo $datef ?></h1>
                                <a href="hotelpages/hotelfinance/print_finance_p_pdf.php?dated=<?php echo $dated ?>&datef=<?php echo $datef ?>" class="btn btn-lg btn-success" target="_blank">
                                    <span title="Imprimer la liste" alt="editer"><i class="fa fa-file-pdf-o"></i> Impriner</span>
                                </a>
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
                                            <th>Date</th>
                                            <th>Objet</th>
                                            <th>Finance total</th>
                                            <th>Finance r&eacute;gl&eacute;e</th>
                                            <th>Finance non r&eacute;gl&eacute;e</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                        <tr>
                                            <td>Restaurant</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>Date</td>
                                            <td>Objet</td>
                                            <td><?php echo number_format($montantc, 0, ',', ' '); ?></td>
                                            <td><?php echo number_format($montantp, 0, ',', ' '); ?></td>
                                            <td><?php echo number_format($montantn, 0, ',', ' '); ?></td>
                                        </tr>
                                        <tr>
                                            <td>Bar</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>Date</td>
                                            <td>Objet</td>
                                            <td><?php echo number_format($montantbc, 0, ',', ' '); ?></td>
                                            <td><?php echo number_format($montantbp, 0, ',', ' '); ?></td>
                                            <td><?php echo number_format($montantbn, 0, ',', ' '); ?></td>
                                        </tr>
                                           
                                            <?php
                                        
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <a href="hotelpages/hotelfinance/print_finance_p_pdf.php?dated=<?php echo $dated ?>&datef=<?php echo $datef ?>" class="btn btn-lg btn-success" target="_blank">
                            <span title="Imprimer la liste" alt="editer"><i class="fa fa-file-pdf-o"></i> Impriner</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
}
?>
