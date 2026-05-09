<?php
$_SESSION["session_prodsvaaba"] = 0;
if (!empty($_SESSION["cart_prodvaaba"])) {
//        $_SESSION["session_prodsvaaba"] = count($_SESSION["cart_prodvaaba"]);
    foreach ($_SESSION["cart_prodvaaba"] as $k => $v) {
        $_SESSION["session_prodsvaaba"] = $_SESSION["session_prodsvaaba"] + $_SESSION["cart_prodvaaba"][$k]["qteart"];
    }
}
$rslt = $con->query("select * from hotel_magasin_pharmacie as mb left join hotel_pharmacie as b on mb.id_pharmacie=b.id_pharmacie left "
            . "join hotel_article_point_hotel as aph on mb.id_article_point_hotel=aph.id_article_point_hotel left join "
            . "hotel_article as a on aph.id_article=a.id_article left join hotel_categorie as c on "
            . "a.id_categorie=c.id_categorie where mb.id_pharmacie='" . $_REQUEST["pharmacie"] . "'") or die(mysqli_error($con));
//    $row = mysqli_fetch_assoc($rslt);
?><br>
<div class="row">
    <div class="col-sm-12">
        <h2 class="page-header">Articles Avaries </h2>  
    </div>
</div>
<div class="row">
    <div class="col-sm-9">
                        <!--<form id="addvente_form" method="post" action="indexadmin.php?page=<?php echo base64_encode('hotelpages/fourniturehotel/hotelarticleavarie/hotelajouter/ajouter_panier') ?>&actionp=add&idp=<?php echo $row["id_article_point_hotel"]; ?>">-->
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover" id="dataTables-chambre">
                <thead>
                    <tr class="btn-success">
                        <th>Code</th>
                        <th>D&eacute;signation</th>
                        <th>Cat&eacute;gorie</th>
                        <th>Stock</th>
                        <th>Unit&eacute; vente</th>
                        <th>Unit&eacute; sortie</th>
                        <th>Op&eacute;ration</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($row = mysqli_fetch_assoc($rslt)) {
                        ?>
                        <tr>
                            <td><?php print nl2br(htmlspecialchars($row["code_article"])) ?></td>
                            <td><?php print nl2br(htmlspecialchars($row["libelle_article"])) ?></td>
                            <td><?php print nl2br(htmlspecialchars($row["libelle_categorie"])) ?></td>
                            <td><?php print nl2br(htmlspecialchars($row["stock_article_mb"])) ?></td>
                            <td>
                                <?php
                                $rsltua = $con->query("select * from hotel_unite where id_unite='" . $row["id_unite"] . "'") or die(mysqli_error($con));
                                $rowa = mysqli_fetch_assoc($rsltua);
                                print nl2br(htmlspecialchars($rowa["code_unite"]));
                                ?>
                            </td>
                            <td>
                                <?php
                                $rsltus = $con->query("select * from hotel_unite where id_unite='" . $row["unite_sortie_article"] . "'") or die(mysqli_error($con));
                                $rows = mysqli_fetch_assoc($rsltus);
                                print nl2br(htmlspecialchars($rows["code_unite"]));
                                ?>
                            </td>
                            <td>
                                <!--<input type="text" hidden="" value="1" id="qteprd" name="qteprd">-->

                                <?php
                                if (isset($_SESSION["loginproprietaire"])) {
                                    ?>
                                    <a href="indexadmin.php?page=<?php echo base64_encode('hotelpages/pharmaciehotel/hotelarticleavarie/hotelajouter/ajouter_panier') ?>&actionp=add&idp=<?php echo $row["id_magasin_pharmacie"]; ?>&pharmacie=<?php echo $_REQUEST["pharmacie"]; ?>" class="add-to-cart btn btn-success" type="submit">
                                        Ajouter
                                    </a>
                                    <?php
                                } else if (($_SESSION["code_service"] == "DG")) {
                                    ?>
                                    <a href="indexdg.php?page=<?php echo base64_encode('hotelpages/pharmaciehotel/hotelarticleavarie/hotelajouter/ajouter_panier') ?>&actionp=add&idp=<?php echo $row["id_magasin_pharmacie"]; ?>&pharmacie=<?php echo $_REQUEST["pharmacie"]; ?>" class="add-to-cart btn btn-success" type="submit">
                                        Ajouter
                                    </a>
                                    <?php
                                } else {
                                    ?>
                                    <a href="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/pharmaciehotel/hotelarticleavarie/hotelajouter/ajouter_panier') ?>&actionp=add&idp=<?php echo $row["id_magasin_pharmacie"]; ?>&pharmacie=<?php echo $_REQUEST["pharmacie"]; ?>" class="add-to-cart btn btn-success" type="submit">
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
            if (isset($_SESSION["session_prodsvaaba"])) {
                echo $_SESSION["session_prodsvaaba"];
            } else {
                echo '0';
            }
            ?>
        </span><br>
        <?php
        include("hotelpages/pharmaciehotel/hotelarticleavarie/hotelajouter/panier_menu.php");
        ?>
    </div>
</div>