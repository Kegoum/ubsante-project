 
<div class="data-table-area mg-b-15 animated zoomIn">
    <div class="container-fluid">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="sparkline13-list">
                        <div class="sparkline13-hd">
                            <div class="main-sparkline13-hd">
                                <?php
                                if ((isset($_SESSION["loginproprietaire"]) && isset($_SESSION["motdepasseproprietaire"])) || (isset($_SESSION["logincomptepersonnel"]) && isset($_SESSION["motdepassecomptepersonnel"]) && ($_SESSION["etatcomptepersonnel"]) && (($_SESSION["rolepersonnel"] == "Directeur de Centre") || ($_SESSION["rolepersonnel"] == "Chef de Service") || ($_SESSION["rolepersonnel"] == "Médecin") || ($_SESSION["rolepersonnel"] == "Sage Femme")))) {
                                ?>
                                <div >
                                    <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalvaccin/hopitalajouter/ajout_vaccin'); ?>" class="btn btn-primary btn-sm pull-right"><i class="glyphicon glyphicon-plus"></i> Ajouter</a>
                                </div>
                                    <?php
                                }
                                ?>
                                <h1>Liste des Vaccins</h1>
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
                                            <th>Op&eacute;ration</th>
                                            <th>Num&eacute;ro</th>
                                            <th>Sexe</th>
                                            <th>Nom</th>
                                            <th>Date de naissance</th>
                                            <th>Quartier</th>
                                            <th>Nom parent</th>
                                            <th>Contact</th>
                                            <th>BCG</th>
                                            <th>Polio 0</th>
                                            <th>Polio 1</th>
                                            <th>Polio 2</th>
                                            <th>Polio 3</th>
                                            <th>VPI</th>
                                            <th>Penta 1</th>
                                            <th>Penta 2</th>
                                            <th>Penta 3</th>
                                            <th>Pneumo 1</th>
                                            <th>Pneumo 2</th>
                                            <th>Pneumo 3</th>
                                            <th>Rota 1</th>
                                            <th>Rota 2</th>
                                            <th>VAR 1</th>
                                            <th>VAR 2</th>
                                            <th>VAA</th>
                                            <th>Vita 6 mois</th>
                                            <th>Vita 1 an</th>
                                            <th>Vita 1 an 6 mois</th>
                                            <th>Vita 2 ans</th>
                                            <th>Vita 2 ans 6 mois</th>
                                            <th>Vita 3 ans</th>
                                            <th>Vita 3 ans 6 mois</th>
                                            <th>Vita 4 ans</th>
                                            <th>Vita 4 ans 6 mois</th>
                                            <th>Vita 5 ans</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        lister_vaccin($con);
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