
<?php
if (isset($_REQUEST["patient"])) {
    $ch = $_REQUEST["patient"];
    $rslt = $con->query("select * from hp_patient where idpatient='" . $ch . "'") or die(mysqli_error($con));
    $row = mysqli_fetch_assoc($rslt);
    $rsltpl = $con->query("select * from hp_hospitalisation as pl left join hp_sous_dossier as sd on "
            . "pl.idsousdossier=sd.idsousdossier left join hp_dossier as d on "
            . "sd.iddossier=d.iddossier  where d.idpatient='" . $ch . "' "
            . "and pl.sortiehospitalisation=false order by pl.datehospitalisation desc ") or die(mysqli_error($con));
    $rowpl = mysqli_fetch_assoc($rsltpl);
    ?>
    <div class="data-table-area mg-b-15 animated zoomIn">
        <div class="container-fluid">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="sparkline13-list">
                            <div class="sparkline13-hd">
                                <div class="main-sparkline13-hd">
                                    <h1>Registre de <small> <?php echo $row["nompatient"]; ?> <?php echo $row["prenompatient"]; ?> - <?php echo $row["codepatient"]; ?></small></h1>
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
                            <th>Date</th>
                            <th>Client</th>
                            <th>Operation</th>
                            <th>Montant</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // On r?cup?re les 2 derniers billets
                        affiche_registre_patient($ch,$con);
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
    </div>
    <?php
}
?> 