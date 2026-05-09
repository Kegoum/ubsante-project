
<script>
    $(document).on("click", ".prix-vente", function(e) {

        e.preventDefault();

        var _self = $(this);

        var myBookId = _self.data('id');
        $("#idproduitphv").val(myBookId);
//    $("#btnchap").submit();
//        $("#btnchap").ajaxForm({
//        }).submit();

//    $(_self.attr('href')).modal('show');
    });

</script>
<?php
if (isset($_REQUEST["idsoin"])) {
    $id = $_REQUEST["idsoin"];
    $req_fin = $con->query("select * from hp_soin as c where c.idsoin='" . $id . "'") or die(mysqli_error($con));
    $row = mysqli_fetch_assoc($req_fin);
    ?>
<div class="data-table-area mg-b-15">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="sparkline13-list">
                    <div class="sparkline13-hd">
                        <div class="main-sparkline13-hd">
                            <?php
                            if ((isset($_SESSION["loginproprietaire"]) && isset($_SESSION["motdepasseproprietaire"])) || ((($_SESSION["rolepersonnel"] == "Directeur de Centre") || ($_SESSION["rolepersonnel"] == "Chef de Service") || ($_SESSION["rolepersonnel"] == "Médecin") || ($_SESSION["rolepersonnel"] == "Accueil") || ($_SESSION["rolepersonnel"] == "Magasinier")))) {
                                ?>
                                <div >
                                    <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalparametre/hopitalsoin/hopitalproduit/hopitalajouter/ajouter_produit'); ?>&idsoin=<?php echo $id ?>" class="btn btn-primary btn-sm pull-right"><i class="glyphicon glyphicon-plus"></i> Ajouter</a>
                                </div>
                                <?php
                            }
                            ?>
                            <h1>Liste des produits de <?php echo $row["libellesoin"] ?> </h1>
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
                                        <th>Op&eacute;ration</th>
                                        <th>Code</th>
                                        <th>D&eacute;signation</th>
                                        <th>Cat&eacute;gorie</th>
                                        <th>Prix Vente</th>
                                        <th>unit&eacute; vente</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                        lister_produit_soin($id, $con);
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