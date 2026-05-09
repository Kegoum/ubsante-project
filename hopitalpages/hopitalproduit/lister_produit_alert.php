<div class="panel panel-default">
    <div class="panel-heading">
        Liste des Articles en carence
    </div>
    <div class="panel-body">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover" id="dataTables-chambre">
                <thead>
                    <tr class="btn-success">
                        <th>N&deg;</th>
                        <th>Code</th>
                        <th>D&eacute;signation</th>
                        <th>Fourniture</th>
                        <th>Cat&eacute;gorie</th>
                        <th>Stock</th>
                        <th>Stock Min</th>
                        <th>Stock Max</th>
                        <th>Prix Achat</th>
                        <th>Prix Vente</th>
                        <th>Prix Lavage</th>
                        <th>unit&eacute; achat</th>
                        <th>unit&eacute; vente</th>
                        <th>unit&eacute; sortie</th>
                        <th>Etat</th>
                        <th>Date</th>
                        <th>Op&eacute;ration</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    lister_produit_alert($_SESSION["id_point_hotel"],$con);
                    ?>
                </tbody>
            </table>
        </div>

    </div>
</div>