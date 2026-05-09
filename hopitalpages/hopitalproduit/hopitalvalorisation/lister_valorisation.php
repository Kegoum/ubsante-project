
<!-- Static Table Start -->
<div class="data-table-area mg-tb-15">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="sparkline13-list">
                    <div class="sparkline13-hd">
                        <div class="main-sparkline13-hd">
                            <?php
                            if ((isset($_SESSION["loginproprietaire"]) && isset($_SESSION["motdepasseproprietaire"])) || ((($_SESSION["rolepersonnel"] == "Directeur de Centre") || ($_SESSION["rolepersonnel"] == "Chef de Service") || ($_SESSION["rolepersonnel"] == "Magasinier")))) {
                               ?>
                                <div >
                                    <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalproduit/hopitalvalorisation/hopitalajouter/ajout_valorisation'); ?>" class="btn btn-primary btn-sm pull-right"><i class="glyphicon glyphicon-plus"></i> Ajouter</a>
                                </div>
                                <?php
                            }
                            ?>
<h1>Liste <span class="table-project-n">des Valorisation des Stock</span></h1>
                            
                        </div>
                    </div>
                    <div class="sparkline13-graph">
                        <div class="datatable-dashv1-list custom-datatable-overright">
                            <div id="toolbar">
                                <select class="form-control">
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
                                        <th data-field="id">ID</th>
                                        <th>Code</th>
                                        <th>Libell&eacute;</th>
                                        <th data-field="etat" >Etat</th>
                                        <th data-field="date">Date</th>
                                        <th data-field="action">Op&eacute;ration</th>
                                    </tr>
                                </thead>
                                <tbody>
                     
                                    <?php
                                    lister_valorisationstock($con);
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
<!-- Static Table End -->