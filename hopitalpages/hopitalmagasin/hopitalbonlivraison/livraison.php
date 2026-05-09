<?php
$_SESSION["session_prodsvlex"] = 0;
if (!empty($_SESSION["cart_prodvlex"])) {
//        $_SESSION["session_prodsvlex"] = count($_SESSION["cart_prodvlex"]);
    foreach ($_SESSION["cart_prodvlex"] as $k => $v) {
        $_SESSION["session_prodsvlex"] = $_SESSION["session_prodsvlex"] + $_SESSION["cart_prodvlex"][$k]["qteart"];
    }
}
$rslt = $con->query("select * from hotel_produit_point_hotel as aph left join hotel_produit as a on "
        . "aph.id_produit=a.id_produit left join hotel_categorie as c on a.id_categorie=c.id_categorie left join "
        . "hotel_fourniture as f on a.id_fourniture=f.id_fourniture order by f.libelle_fourniture asc ") or die(mysqli_error($con));
//    $row = mysqli_fetch_assoc($rslt);
?><br>
<div class="row">
    <div class="col-sm-12">
        <h2 class="page-header">Livraison Economat </h2>  
    </div>
</div>
<div class="row">
    <div class="col-sm-9">
                        <!--<form id="addvente_form" method="post" action="indexadmin.php?page=<?php echo base64_encode('hotelpages/economathotel/bonlivraisonhotel/ajouter_panier') ?>&actionp=add&idp=<?php echo $row["id_produit"]; ?>">-->
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover" id="dataTables-chambre">
                <thead>
                    <tr class="btn-success">
                        <th>Code</th>
                        <th>D&eacute;signation</th>
                        <th>Fourniture</th>
                        <th>Cat&eacute;gorie</th>
                        <th>Stock</th>
                        <th>Prix Achat</th>
                        <th>Prix Vente</th>
                        <th>Prix Lavage</th>
                        <th>unit&eacute; achat</th>
                        <th>unit&eacute; vente</th>
                        <th>unit&eacute; sortie</th>
                        <th>Op&eacute;ration</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($row = mysqli_fetch_assoc($rslt)) {
                        $rsltlin = $con->query("select * from hotel_linge where id_produit_point_hotel='" . $row["id_produit_point_hotel"] . "'") or die(mysqli_error($con));
                        $nblin = mysqli_num_rows($rsltlin);
                        ?>
                        <tr>
                            <td><?php print nl2br(htmlspecialchars($row["code_produit"])) ?></td>
                            <td><?php print nl2br(htmlspecialchars($row["libelle_produit"])) ?></td>
                            <td><?php print nl2br(htmlspecialchars($row["libelle_fourniture"])) ?></td>
                            <td><?php print nl2br(htmlspecialchars($row["libelle_categorie"])) ?></td>
                            <td><?php print nl2br(htmlspecialchars($row["stock_produit"])) ?></td>
                            <td><?php print nl2br(htmlspecialchars($row["prix_achat_produit"])) ?></td>
                            <td><?php print nl2br(htmlspecialchars($row["prix_vente_produit"])) ?></td>
                            <td>
                                <?php
                                if ($nblin != 0) {
                                    $rowlin = mysqli_fetch_assoc($rsltlin);
                                    print nl2br(htmlspecialchars($rowlin["prix_lavage_linge"]));
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                $rsltua = $con->query("select * from hotel_unite where id_unite='" . $row["unite_achat_produit"] . "'") or die(mysqli_error($con));
                                $rowa = mysqli_fetch_assoc($rsltua);
                                print nl2br(htmlspecialchars($rowa["libelle_unite"]));
                                ?>
                            </td>
                            <td>
                                <?php
                                $rsltuv = $con->query("select * from hotel_unite where id_unite='" . $row["unite_vente_produit"] . "'") or die(mysqli_error($con));
                                $rowv = mysqli_fetch_assoc($rsltuv);
                                print nl2br(htmlspecialchars($rowv["libelle_unite"]));
                                ?>
                            </td>
                            <td>
                                <?php
                                $rsltus = $con->query("select * from hotel_unite where id_unite='" . $row["unite_sortie_produit"] . "'") or die(mysqli_error($con));
                                $rows = mysqli_fetch_assoc($rsltus);
                                print nl2br(htmlspecialchars($rows["libelle_unite"]));
                                ?>
                            </td>
                            <td>
                                <!--<input type="text" hidden="" value="1" id="qteprd" name="qteprd">-->

                                <?php
                                if (isset($_SESSION["loginproprietaire"])) {
                                    ?>
                                    <a href="indexadmin.php?page=<?php echo base64_encode('hotelpages/economathotel/bonlivraisonhotel/ajouter_panier') ?>&actionp=add&idp=<?php echo $row["id_produit_point_hotel"]; ?>" class="add-to-cart btn btn-success" type="submit">
                                        Ajouter
                                    </a>
                                    <?php
                                } else if (($_SESSION["code_service"] == "DG")) {
                                    ?>
                                    <a href="indexdg.php?page=<?php echo base64_encode('hotelpages/economathotel/bonlivraisonhotel/ajouter_panier') ?>&actionp=add&idp=<?php echo $row["id_produit_point_hotel"]; ?>" class="add-to-cart btn btn-success" type="submit">
                                        Ajouter
                                    </a>
                                    <?php
                                } else {
                                    ?>
                                    <a href="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/economathotel/bonlivraisonhotel/ajouter_panier') ?>&actionp=add&idp=<?php echo $row["id_produit_point_hotel"]; ?>" class="add-to-cart btn btn-success" type="submit">
                                        Ajouter
                                    </a>
                                    <?php
                                }
                                ?>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <!--</form>-->
    </div><br>
    <div class="col-sm-3">
        <span class="badge b">
            <?php
            if (isset($_SESSION["session_prodsvlex"])) {
                echo $_SESSION["session_prodsvlex"];
            } else {
                echo '0';
            }
            ?>
        </span>
        <a href="#modalfromproduit" role="button" data-toggle="modal" class="pull-right">
            <img src="hotelimages/process-icon-new.png" title="Nouveau" alt="Nouveau">
        </a>
        <?php
        include("hotelpages/economathotel/bonlivraisonhotel/hotelajouter/ajouter_produit.php");
        ?>
        <br>
        <br>
        <?php
        include("hotelpages/economathotel/bonlivraisonhotel/panier_menu.php");
        ?>
    </div>
</div>