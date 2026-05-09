<?php
$_SESSION["session_prodsvaae"] = 0;
if (!empty($_SESSION["cart_prodvaae"])) {
//        $_SESSION["session_prodsvaae"] = count($_SESSION["cart_prodvaae"]);
    foreach ($_SESSION["cart_prodvaae"] as $k => $v) {
        $_SESSION["session_prodsvaae"] = $_SESSION["session_prodsvaae"] + $_SESSION["cart_prodvaae"][$k]["qteart"];
    }
}
$rslt = $con->query("select * from hotel_article_point_hotel as aph left join hotel_article as a on "
        . "aph.id_article=a.id_article left join hotel_categorie as c on a.id_categorie=c.id_categorie left "
        . "join hotel_fourniture as f on a.id_fourniture=f.id_fourniture where "
        . "aph.id_point_hotel='" . $_SESSION["id_point_hotel"] . "' order by a.libelle_article asc") or die(mysqli_error($con));
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
                        <th>Fourniture</th>
                        <th>Cat&eacute;gorie</th>
                        <th>Stock</th>
                        <th>unit&eacute; achat</th>
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
                            <td><?php print nl2br(htmlspecialchars($row["stock_article"])) ?></td>
                            <td>
                                <?php
                                $rsltua = $con->query("select * from hotel_unite where id_unite='" . $row["unite_achat_article"] . "'") or die(mysqli_error($con));
                                $rowa = mysqli_fetch_assoc($rsltua);
                                print nl2br(htmlspecialchars($rowa["libelle_unite"]));
                                ?>
                            </td>
                            <td>
                                <?php
                                $rsltus = $con->query("select * from hotel_unite where id_unite='" . $row["unite_sortie_article"] . "'") or die(mysqli_error($con));
                                $rows = mysqli_fetch_assoc($rsltus);
                                print nl2br(htmlspecialchars($rows["libelle_unite"]));
                                ?>
                            </td>
                            <td>
                                <!--<input type="text" hidden="" value="1" id="qteprd" name="qteprd">-->

                                <?php
                                if (isset($_SESSION["login_proprietaire"])) {
                                    ?>
                                    <a href="indexadmin.php?page=<?php echo base64_encode('hotelpages/fourniturehotel/hotelarticleavarie/hotelajouter/ajouter_panier') ?>&actionp=add&idp=<?php echo $row["id_article_point_hotel"]; ?>" class="add-to-cart btn btn-success" type="submit">
                                        Ajouter
                                    </a>
                                    <?php
                                } else if (($_SESSION["code_service"] == "DG")) {
                                    ?>
                                    <a href="indexdg.php?page=<?php echo base64_encode('hotelpages/fourniturehotel/hotelarticleavarie/hotelajouter/ajouter_panier') ?>&actionp=add&idp=<?php echo $row["id_article_point_hotel"]; ?>" class="add-to-cart btn btn-success" type="submit">
                                        Ajouter
                                    </a>
                                    <?php
                                } else {
                                    ?>
                                    <a href="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/fourniturehotel/hotelarticleavarie/hotelajouter/ajouter_panier') ?>&actionp=add&idp=<?php echo $row["id_article_point_hotel"]; ?>" class="add-to-cart btn btn-success" type="submit">
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
            if (isset($_SESSION["session_prodsvaae"])) {
                echo $_SESSION["session_prodsvaae"];
            } else {
                echo '0';
            }
            ?>
        </span><br>
        <?php
        include("hotelpages/fourniturehotel/hotelarticleavarie/hotelajouter/panier_menu.php");
        ?>
    </div>
</div>