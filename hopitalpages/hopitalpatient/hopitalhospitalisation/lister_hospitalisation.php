<?php
if (isset($_REQUEST["idconsultation"])) {
    $id = $_REQUEST["idconsultation"];
    $req_fin = $con->query("select * from hp_consultation as c left join hp_sous_dossier as sd on c.idsousdossier=sd.idsousdossier "
            . "left join hp_dossier as d on sd.iddossier=d.iddossier left join hp_patient as p on d.idpatient=p.idpatient left join "
            . "hp_departement as dp on p.residencepatient=dp.iddepartement where c.idconsultation='" . $id . "'") or die(mysqli_error($con));
    $row = mysqli_fetch_assoc($req_fin);
    ?>
    <div class="data-table-area mg-b-15">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="sparkline13-list">
                        <div class="sparkline13-hd">
                            <div class="main-sparkline13-hd">
                                <h1>Consultations de 
                                    <?php echo $row["codepatient"]; ?> <?php echo $row["nompatient"]; ?> <?php
                                    echo $row["prenompatient"];
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
                                            <th>Code</th>
                                            <th>But</th>
                                            <th>Diagnostique</th>
                                            <th>R&eacute;sultat</th>
                                            <th>Traitement</th>
                                            <th>Etat</th>
                                            <th>Op&eacute;ration</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        lister_consultation($id, $con);
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
