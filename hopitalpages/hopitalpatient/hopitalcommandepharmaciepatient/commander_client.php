<?php
if (isset($_REQUEST["client"])) {
    $id = $_REQUEST["client"];
    $_SESSION["session_prodsvb" . $id] = 0;
    if (!empty($_SESSION["cart_prodvb" . $id])) {
//        $_SESSION["session_prodsvb"] = count($_SESSION["cart_prodvb".$id]);
        foreach ($_SESSION["cart_prodvb" . $id] as $k => $v) {
            $_SESSION["session_prodsvb" . $id] = $_SESSION["session_prodsvb" . $id] + $_SESSION["cart_prodvb" . $id][$k]["qteart"];
        }
    }
    $rslt = $con->query("select * from hotel_client where id_client='" . $_REQUEST["client"] . "'") or die(mysqli_error($con));
    $row = mysqli_fetch_assoc($rslt);
    $rsltbar = $con->query("select * from hotel_magasin_bar as mb left join hotel_article_point_hotel as aph on "
            . "mb.id_article_point_hotel=aph.id_article_point_hotel left join hotel_article as a on "
            . "aph.id_article=a.id_article where mb.id_bar='" . $_SESSION["id_bar"] . "'") or die(mysqli_error($con));
    $nbbar = mysqli_num_rows($rsltbar);
?><br>
    <div class="row">
        <h2 class="page-header">Commande de <small> <?php echo $row["nom_client"]; ?> <?php echo $row["prenom_client"]; ?> - <?php echo $row["cni_client"]; ?></small> </h2>  
    </div>
    <div class="row">
        <div class="col-sm-7 well">
            <div class="row">
                <?php
                while ($rowbar = mysqli_fetch_assoc($rsltbar)) {
                    ?>
                    <div class="col-sm-6">
                        <div class="info-box">
                            <span class="info-box-icon bg-green"><i class="fa fa-glass"></i></span>

                            <div class="info-box-content">
                        <?php
                        if (isset($_SESSION["loginproprietaire"])) {
                            ?>
                            <form id="addvente_form" method="post" action="indexadmin.php?page=<?php echo base64_encode('hotelpages/clienthotel/commandebarclienthotel/ajouter_panier') ?>&actionp=add&idp=<?php echo $rowbar["id_magasin_bar"]; ?>&client=<?php echo $_REQUEST["client"]; ?>">
                                <input type="text" hidden="" value="1" id="qteprd" name="qteprd">
                                <span class="info-box-text"><?php echo $rowbar["libelle_article"] ?></span>
                                        <span class="info-box-number"><?php echo $rowbar["prix_vente_article_mb"] ?> F CFA</span>
                                        <button  class="btn-success pull-right" type="submit">
                                            Ajouter
                                        </button>
                            </form>
                            <?php
                        } else if (($_SESSION["code_service"] == "DG")) {
                            ?>
                            <form id="addvente_form" method="post" action="indexdg.php?page=<?php echo base64_encode('hotelpages/clienthotel/commandebarclienthotel/ajouter_panier') ?>&actionp=add&idp=<?php echo $rowbar["id_magasin_bar"]; ?>&client=<?php echo $_REQUEST["client"]; ?>">
                                <input type="text" hidden="" value="1" id="qteprd" name="qteprd">
                                <span class="info-box-text"><?php echo $rowbar["libelle_article"] ?></span>
                                        <span class="info-box-number"><?php echo $rowbar["prix_vente_article_mb"] ?> F CFA</span>
                                        <button  class="btn-success pull-right" type="submit">
                                            Ajouter
                                        </button>
                            </form>
                            <?php
                        } else {
                            ?>
                            <form id="addvente_form" method="post" action="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/clienthotel/commandebarclienthotel/ajouter_panier') ?>&actionp=add&idp=<?php echo $rowbar["id_magasin_bar"]; ?>&client=<?php echo $_REQUEST["client"]; ?>">
                                <input type="text" hidden="" value="1" id="qteprd" name="qteprd">
                                <span class="info-box-text"><?php echo $rowbar["libelle_article"] ?></span>
                                        <span class="info-box-number"><?php echo $rowbar["prix_vente_article_mb"] ?> F CFA</span>
                                        <button  class="btn-success pull-right" type="submit">
                                            Ajouter
                                        </button>
                            </form>
                            <?php
                        }
                        ?>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
        <div class="col-sm-5 well">
            <span class="badge b">
                <?php
                if (isset($_SESSION["session_prodsvb" . $id])) {
                    echo $_SESSION["session_prodsvb" . $id];
                } else {
                    echo '0';
                }
                ?>
            </span><br>
            <?php
            include("hotelpages/clienthotel/commandebarclienthotel/panier_menu.php");
            ?>
        </div>
    </div>
    <?php
}
?>