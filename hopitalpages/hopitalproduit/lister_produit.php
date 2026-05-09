
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
                                    <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalproduit/hopitalajouter/ajouter_produit'); ?>" class="btn btn-primary btn-sm pull-right"><i class="glyphicon glyphicon-plus"></i> Ajouter</a>
                                </div>
                                <?php
                            }
                            ?>
                            <h1>Liste des produits </h1>
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
                                            <th>Image</th>
                                        <th>Code</th>
                                        <th>D&eacute;signation</th>
                                        <th>Stock</th>
                                        <th>Stock Min</th>
                                        <th>Stock Max</th>
                                        <th>Prix Achat</th>
                                        <th>Prix Vente</th>
                                        <th>unit&eacute; achat</th>
                                        <th>unit&eacute; vente</th>
                                        <th>unit&eacute; sortie</th>
                        <th>D.C.I. /Principe actif</th>
                        <th>Famille</th>
                        <th>Forme et Dosage</th>
                        <th>Conditionnement</th>
                        <th>Laboratoire</th>
                                        <th>Etat</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if(isset($_SESSION["idmagasin"])){
                                    lister_produit($con, $_SESSION["idmagasin"] );
                                    }else{
                                        lister_produit($con, NULL );
//                                        lister_produit($con, $_REQUEST["idmagasin"] );
                                    }
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
include('hopitalpages/hopitalproduit/hopitalprix/editer_prix_vente.php');
?>