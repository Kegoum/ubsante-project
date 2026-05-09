<?php
if (isset($_REQUEST["boncommande"])) {
    $id = $_REQUEST["boncommande"];
    $_SESSION["session_prodsvlebc" . $id] = 0;
    if (!empty($_SESSION["cart_prodvlebc" . $id])) {
//        $_SESSION["session_prodsvlebc".$id] = count($_SESSION["cart_prodvlebc".$id]);
        foreach ($_SESSION["cart_prodvlebc" . $id] as $k => $v) {
            $_SESSION["session_prodsvlebc" . $id] = $_SESSION["session_prodsvlebc" . $id] + $_SESSION["cart_prodvlebc" . $id][$k]["qteart"];
        }
    }

    $rslt = $con->query("select * from hp_ligne_bon_commande as lbl left join hp_produit as a on "
            . "lbl.idproduit=a.idproduit left join hp_categorie as c on a.idcategorie=c.idcategorie where "
            . "lbl.idboncommande='" . $id . "' order by a.libelleproduit asc") or die(mysqli_error($con));
//    $row = mysqli_fetch_assoc($rslt);
    ?><br>
<div class="data-table-area mg-b-15">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
                <div class="sparkline13-list">
                    <div class="sparkline13-hd">
                        <div class="main-sparkline13-hd">
                            <h1 >Livraison Externe </h1>  
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
                            <th>Code</th>
                            <th>D&eacute;signation</th>
                            <th>D.C.I. /PRINCIPE ACTIF</th>
                            <th>Stock</th>
                            <th>Stock Command&eacute;</th>
                            <th>Prix Achat</th>
                            <th>Prix Vente</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($row = mysqli_fetch_assoc($rslt)) {
                            ?>
                            <tr>
                                            <td></td>
                                <td>
                                    <!--<input type="text" hidden="" value="1" id="qteprd" name="qteprd">-->

                                    <?php
                                    if ($row["etatligneboncommande"] == "En Cours") {
                                        ?>
                                    <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalmagasin/hopitalbonlivraisonc/ajouter_panier') ?>&actionp=add&idp=<?php echo $row["idligneboncommande"]; ?>&boncommande=<?php echo $_REQUEST["boncommande"]; ?>" class="add-to-cart btn btn-xs btn-primary" type="submit" style="color: white;">
                                            Ajouter
                                        </a>
                                        <?php
                                    }
                                    ?>
                                </td>
                                <td><?php print nl2br(htmlspecialchars($row["codeproduit"])) ?></td>
                                <td><?php print nl2br(htmlspecialchars($row["libelleproduit"])) ?></td>
                                <td><?php print nl2br(htmlspecialchars($row["libellecategorie"])) ?></td>
                                <td>
                                    <b><?php
                                        print nl2br(htmlspecialchars($row["stockproduit"]));
                                        ?></b>
                                    &nbsp;
                                    <?php
                                    $rsltua = $con->query("select * from hp_unite where idunite='" . $row["uniteachatproduit"] . "'") or die(mysqli_error($con));
                                    $rowa = mysqli_fetch_assoc($rsltua);
                                    print nl2br(htmlspecialchars($rowa["codeunite"]));
                                    ?>
                                </td>
                                <td>
                                    <?php print nl2br(htmlspecialchars($row["stockligneboncommande"])); ?>
                                    &nbsp;
                                    <?php
                                    $rsltuab = $con->query("select * from hp_unite where idunite='" . $row["idunite"] . "'") or die(mysqli_error($con));
                                    $rowab = mysqli_fetch_assoc($rsltuab);
                                    print nl2br(htmlspecialchars($rowab["codeunite"]));
                                    ?>
                                </td>
                                <td><?php print nl2br(htmlspecialchars($row["prixachatproduit"])) ?></td>
                                <td><?php print nl2br(htmlspecialchars($row["prixventeproduit"])) ?></td>
                                
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
            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12 well">
                <?php
                if (isset($_SESSION["session_prodsvlebc" . $id])) {
                    echo $_SESSION["session_prodsvlebc" . $id];
                } else {
                    echo '0';
                }
                ?>
            </span><br>
            <?php
            include("hopitalpages/hopitalmagasin/hopitalbonlivraisonc/panier_menu.php");
            ?>
            </div>
        </div>
    </div>
</div>
    <?php
}
?>