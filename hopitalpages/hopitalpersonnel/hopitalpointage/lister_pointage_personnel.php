<?php
if ($_REQUEST["idpersonnel"]) {
//    $rsltc = $con->query("select * from hp_pointage as p left join hp_affectation as a on p.idaffectation=a.idaffectation "
//            . "where a.idpersonnel='" . $_REQUEST["idpersonnel"] . "' ") or die(mysqli_error($con));
//    $row = mysqli_fetch_assoc($rsltc);
    $rsltens = $con->query("select * from hp_personnel where idpersonnel='" . $_REQUEST["idpersonnel"] . "'") or die(mysqli_error($con));
    $rece = mysqli_fetch_assoc($rsltens);
    ?>
    <div class="data-table-area mg-b-15">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="sparkline13-list">
                        <div class="sparkline13-hd">
                            <div class="main-sparkline13-hd">
                                &nbsp;&nbsp;
                                <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpersonnel/hopitalpointage/pointage_personnel'); ?>&idpersonnel=<?php echo $_REQUEST["idpersonnel"] ?>" class="pull-right btn btn-xs btn-primary">
                                    <span title="Attribuer les Pointages &agrave; ce personnel" alt="cours"><i class="glyphicon glyphicon-plus"></i> Ajouter</span>
                                </a>
                                <h1>Gestion des Pointages</h1>
                                <h5>Liste <small> des Pointages du personnel </small> 

                                    <?php
                                    print nl2br(htmlspecialchars($rece["codepersonnel"]));
                                    ?> <?php print nl2br(htmlspecialchars($rece["nompersonnel"])); ?> <?php print nl2br(htmlspecialchars($rece["prenompersonnel"])); ?> &nbsp;&nbsp;
                                    - <?php print nl2br(htmlspecialchars($rece["rolepersonnel"])); ?>
                                </h5>
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
                                                <th>Date du jour</th>
                                                <th>Heure d&eacute;but</th>
                                                <th>Heure de fin</th>
                                                <th>Nombre d'heures</th>
                                                <!--<th>Nombre d'heures D&eacute;cimal</th>-->
                                                <th>Type</th>
                                                <th>Etat</th>
                                                <th>Pay&eacute;</th>
                                                <!--<th>Op&eacute;ration</th>-->
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            // On r?cup?re les 2 derniers billets
                                            lister_pointage_personnel($_REQUEST["idpersonnel"], $con);
                                            ?>
                                        </tbody>
                                    </table>

                        </div><br>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
                            <?php
                        } else {
                            
                        }
                        ?>