<?php
    
    ?>
    <div class="data-table-area mg-b-15">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="sparkline13-list">
                        <div class="sparkline13-hd">
                            <div class="main-sparkline13-hd">
                               <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalparametre/hopitalchambre/hopitalajouter/ajout_chambre'); ?>" class="btn btn-primary btn-sm pull-right"><i class="glyphicon glyphicon-plus"></i> Ajouter</a>
                               <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalparametre/hopitalchambre/hopitalmateriel/lister_materiel'); ?>" class="btn btn-primary btn-sm pull-right"><i class="glyphicon glyphicon-list"></i> Mat&eacute;riel</a>
                               <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalparametre/hopitalchambre/hopitalcategoriechambre/lister_categoriechambre'); ?>" class="btn btn-primary btn-sm pull-right"><i class="glyphicon glyphicon-list"></i> Cat&eacute;gorie</a>
                                <h1>Gestion des Salles </h1>
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
                                            <th>Cat&eacute;gorie</th>
                                            <th>Code</th>
                                            <th>D&eacute;signation</th>
                                            <th>Nombre d'occupants</th>
                                            <th>Prix</th>
                                            <th>Etat</th>
                                            <th>Op&eacute;ration</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        lister_chambre($con);
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

?>