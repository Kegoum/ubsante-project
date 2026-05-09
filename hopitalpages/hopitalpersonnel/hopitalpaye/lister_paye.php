
<div class="data-table-area mg-b-15">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="sparkline13-list">
                    <div class="sparkline13-hd">
                        <div class="main-sparkline13-hd">
                            <?php
//            if ((($_SESSION["issamrole"] == "Super Administrateur") || ($_SESSION["issamrole"] == "Administrateur")) || ($_SESSION["issamrole"] == "Secrétaire") || ($_SESSION["issamrole"] == "Chef Scolarité")) {
                            if ((($_SESSION["issamrole"] == "Super Administrateur") || ($_SESSION["issamrole"] == "Administrateur"))) {
                                ?>
                                <a href="<?php echo $url; ?>?page=<?php echo base64_encode('ubschoolpages/ubschoolenseignant/ubschoolpaye/list_enseignant'); ?>" class="btn btn-primary pull-right" ><i class="glyphicon glyphicon-plus"></i> Ajouter un Paiement</a>
                                <?php
                            }
                            ?>
                            <h1>Liste <small> des Payements des enseignants</small></h1>
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
                                        <th>Enseignant</th>
                                        <th>Date du jour</th>
                                        <th>Mode de paiement</th>
                                        <th>Salaire de base</th>
                                        <th>R&eacute;mun&eacute;ration Brute</th>
                                        <th>Tatal retenue</th>
                                        <th>Net &agrave; payer</th>
                                        <th>Op&eacute;ration</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // On r?cup?re les 2 derniers billets
                                    list_paye($con);
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
