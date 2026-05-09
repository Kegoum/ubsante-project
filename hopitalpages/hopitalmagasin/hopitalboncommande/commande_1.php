<?php
$_SESSION["session_prodsvcex"] = 0;
if (!empty($_SESSION["cart_prodvcex"])) {
//        $_SESSION["session_prodsvcex"] = count($_SESSION["cart_prodvcex".$id]);
    foreach ($_SESSION["cart_prodvcex"] as $k => $v) {
        $_SESSION["session_prodsvcex"] = $_SESSION["session_prodsvcex"] + $_SESSION["cart_prodvcex"][$k]["qteart"];
    }
}
$rslt = $con->query("select * from hp_produit as a left join hp_categorie as c on a.idcategorie=c.idcategorie ")
        or die(mysqli_error($con));
?><br>
<div class="row">
    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
        <div class="data-table-area mg-b-15">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="sparkline13-list">
                            <div class="sparkline13-hd">
                                <div class="main-sparkline13-hd">
                                    <h1 >Commande Externe </h1>  
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
                                                <th>D&eacute;signation</th>
                                                <th>Cat&eacute;gorie</th>
                                                <th>Stock</th>
                                                <th>Stock min</th>
                                                <th>Stock max</th>
                                                <th>Prix achat</th>
                                                <th>Prix vente</th>
                                                <th>Op&eacute;ration</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            while ($row = mysqli_fetch_assoc($rslt)) {
                                                ?>
                                                <tr>
                                                    <td></td>
                                                    <td><?php print nl2br(htmlspecialchars($row["codeproduit"])) ?></td>
                                                    <td><?php print nl2br(htmlspecialchars($row["libelleproduit"])) ?></td>
                                                    <td><?php print nl2br(htmlspecialchars($row["libellecategorie"])) ?></td>
                                                    <td>
                                                        <?php
                                                        if ($row["stockminproduit"] >= $row["stockproduit"]) {
                                                            ?>
                                                            <b style="color: red">
                                                                <?php
                                                                print nl2br(htmlspecialchars($row["stockproduit"]));
                                                                ?>
                                                            </b>
                                                            <?php
                                                        } else {
                                                            ?>
                                                            <b>
                                                                <?php
                                                                print nl2br(htmlspecialchars($row["stockproduit"]));
                                                                ?>
                                                            </b>
                                                            <?php
                                                        }
                                                        ?>&nbsp;
                                                        <?php
                                                        $rsltua = $con->query("select * from hp_unite where idunite='" . $row["uniteachatproduit"] . "'") or die(mysqli_error($con));
                                                        $rowa = mysqli_fetch_assoc($rsltua);
                                                        print nl2br(htmlspecialchars($rowa["libelleunite"]));
                                                        ?>
                                                    </td>
                                                    <td><?php print nl2br(htmlspecialchars($row["stockminproduit"])) ?></td>
                                                    <td><?php print nl2br(htmlspecialchars($row["stockmaxproduit"])) ?></td>
                                                    <td><?php print nl2br(htmlspecialchars($row["prixachatproduit"])) ?></td>
                                                    <td><?php print nl2br(htmlspecialchars($row["prixventeproduit"])) ?></td>

                                                    <td>
                                                        <!--<input type="text" hidden="" value="1" id="qteprd" name="qteprd">-->

                                                        <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalmagasin/hopitalboncommande/ajouter_panier') ?>&actionp=add&idp=<?php echo $row["idproduit"]; ?>" class="add-to-cart btn btn-success" type="submit">
                                                            Ajouter
                                                        </a>
                                                    </td>
                                                </tr>
                                                <?php
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
    </div>

    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 well">
        <span class="badge b">
            <?php
            if (isset($_SESSION["session_prodsvcex"])) {
                echo $_SESSION["session_prodsvcex"];
            } else {
                echo '0';
            }
            ?>
        </span>
        <a href="#modalfromproduit" role="button" data-toggle="modal" class="pull-right btn btn-xs btn-primary">
            <i class="glyphicon glyphicon-plus"></i> Nouveau
        </a>
        <?php
        include("hopitalpages/hopitalmagasin/hopitalboncommande/hotelajouter/ajouter_produit.php");
        ?>
        <br>
        <br>
        <?php
        include("hopitalpages/hopitalmagasin/hopitalboncommande/panier_menu.php");
        ?>
    </div>
</div>