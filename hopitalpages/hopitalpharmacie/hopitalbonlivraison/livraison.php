<?php
$_SESSION["session_prodsvlir"] = 0;
if (!empty($_SESSION["cart_prodvlir"])) {
//        $_SESSION["session_prodsvlir"] = count($_SESSION["cart_prodvlir"]);
    foreach ($_SESSION["cart_prodvlir"] as $k => $v) {
        $_SESSION["session_prodsvlir"] = $_SESSION["session_prodsvlir"] + $_SESSION["cart_prodvlir"][$k]["qteart"];
    }
}
$rslt = $con->query("select * from hotel_article as a left join hotel_categorie as c on "
        . "a.id_categorie=c.id_categorie left join hotel_fourniture as f on a.id_fourniture=f.id_fourniture "
        . "order by f.libelle_fourniture asc ") or die(mysqli_error($con));
//    $row = mysqli_fetch_assoc($rslt);
?><br>
<div class="row">
    <div class="col-sm-12">
        <h2 class="page-header">Livraison restaurant </h2>  
    </div>
</div>
<div class="row">
    <div class="col-sm-9">
                        <!--<form id="addvente_form" method="post" action="indexadmin.php?page=<?php echo base64_encode('hotelpages/restauranthotel/bonlivraisonhotel/ajouter_panier') ?>&actionp=add&idp=<?php echo $row["id_article"]; ?>">-->
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
                        <th>unit&eacute; achat</th>
                        <th>unit&eacute; vente</th>
                        <th>unit&eacute; sortie</th>
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
                            <td><?php print nl2br(htmlspecialchars($row["libelle_fourniture"])) ?></td>
                            <td><?php print nl2br(htmlspecialchars($row["libelle_categorie"])) ?></td>
                            <td><?php print nl2br(htmlspecialchars($row["stock_article"])) ?> 
                                <?php print nl2br(htmlspecialchars($row["type_article"])) ?>(s)</td>
                            <td><?php print nl2br(htmlspecialchars($row["prix_achat_article"])) ?></td>
                            <td><?php print nl2br(htmlspecialchars($row["prix_vente_article"])) ?></td>
                            <td><?php print nl2br(htmlspecialchars($row["unite_achat_article"])) ?></td>
                            <td><?php print nl2br(htmlspecialchars($row["unite_vente_article"])) ?></td>
                            <td><?php print nl2br(htmlspecialchars($row["unite_sortie_article"])) ?></td>
                            <td>
                                <!--<input type="text" hidden="" value="1" id="qteprd" name="qteprd">-->

                                <?php
                                if (isset($_SESSION["loginproprietaire"])) {
                                    ?>
                                    <a href="indexadmin.php?page=<?php echo base64_encode('hotelpages/restauranthotel/bonlivraisonhotel/ajouter_panier') ?>&actionp=add&idp=<?php echo $row["id_article"]; ?>" class="add-to-cart btn btn-success" type="submit">
                                        Ajouter
                                    </a>
                                    <?php
                                } else {
                                    ?>
                                    <a href="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/restauranthotel/bonlivraisonhotel/ajouter_panier') ?>&actionp=add&idp=<?php echo $row["id_article"]; ?>" class="add-to-cart btn btn-success" type="submit">
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
            if (isset($_SESSION["session_prodsvlir"])) {
                echo $_SESSION["session_prodsvlir"];
            } else {
                echo '0';
            }
            ?>
        </span><br>
        <?php
        include("hotelpages/restauranthotel/bonlivraisonhotel/panier_menu.php");
        ?>
    </div>
</div>