<?php
$_SESSION["session_prodsvb"] = 0;
if (!empty($_SESSION["cart_prodvb"])) {
//        $_SESSION["session_prodsvb"] = count($_SESSION["cart_prodvb".$id]);
    foreach ($_SESSION["cart_prodvb"] as $k => $v) {
        $_SESSION["session_prodsvb"] = $_SESSION["session_prodsvb"] + $_SESSION["cart_prodvb"][$k]["qteart"];
    }
}
$rsltpharmacie = $con->query("select * from hotel_magasin_pharmacie as mb left join hotel_article_point_hotel as aph on "
        . "mb.id_article_point_hotel=aph.id_article_point_hotel left join hotel_article as a on "
        . "aph.id_article=a.id_article where mb.id_pharmacie='" . $_SESSION["id_pharmacie"] . "'") or die(mysqli_error($con));
$nbpharmacie = mysqli_num_rows($rsltpharmacie);
?><br>
<div class="row">
    <h2 >Commande Bar </h2>  
</div>
<div class="row">
    <div class="col-sm-7 well">
        <div class="row">
            <?php
            if ($nbpharmacie != 0) {
                while ($rowpharmacie = mysqli_fetch_assoc($rsltpharmacie)) {
                    ?>
                    <div class="col-sm-6">
                        <div class="info-box">
                            <span class="info-box-icon bg-green"><i class="fa fa-glass"></i></span>

                            <div class="info-box-content">
                                <?php
                                if (isset($_SESSION["loginproprietaire"])) {
                                    ?>
                                    <form id="addvente_form" method="post" action="indexadmin.php?page=<?php echo base64_encode('hotelpages/pharmaciehotel/commandepharmaciehotel/ajouter_panier') ?>&actionp=add&idp=<?php echo $rowpharmacie["id_magasin_pharmacie"]; ?>">
                                        <input type="text" hidden="" value="1" id="qteprd" name="qteprd">
                                        <span class="info-box-text"><?php echo $rowpharmacie["libelle_article"] ?></span>
                                        <span class="info-box-number"><?php echo $rowpharmacie["prix_vente_article_mb"] ?> F CFA</span>
                                        <button  class="btn-success pull-right" type="submit">
                                            Ajouter
                                        </button>
                                    </form>
                                    <?php
                                } else if (($_SESSION["code_service"] == "DG")) {
                                    ?>
                                    <form id="addvente_form" method="post" action="indexdg.php?page=<?php echo base64_encode('hotelpages/pharmaciehotel/commandepharmaciehotel/ajouter_panier') ?>&actionp=add&idp=<?php echo $rowpharmacie["id_magasin_pharmacie"]; ?>">
                                        <input type="text" hidden="" value="1" id="qteprd" name="qteprd">
                                        <span class="info-box-text"><?php echo $rowpharmacie["libelle_article"] ?></span>
                                        <span class="info-box-number"><?php echo $rowpharmacie["prix_vente_article_mb"] ?> F CFA</span>
                                        <button  class="btn-success pull-right" type="submit">
                                            Ajouter
                                        </button>
                                    </form>
                                    <?php
                                } else {
                                    ?>
                                    <form id="addvente_form" method="post" action="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/pharmaciehotel/commandepharmaciehotel/ajouter_panier') ?>&actionp=add&idp=<?php echo $rowpharmacie["id_magasin_pharmacie"]; ?>">
                                        <input type="text" hidden="" value="1" id="qteprd" name="qteprd">
                                        <span class="info-box-text"><?php echo $rowpharmacie["libelle_article"] ?></span>
                                        <span class="info-box-number"><?php echo $rowpharmacie["prix_vente_article_mb"] ?> F CFA</span>
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
            }
            ?>
        </div>
    </div>
    <div class="col-sm-5 well">
        <span class="badge b">
            <?php
            if (isset($_SESSION["session_prodsvb"])) {
                echo $_SESSION["session_prodsvb"];
            } else {
                echo '0';
            }
            ?>
        </span><br>
        <?php
        include("hotelpages/pharmaciehotel/commandepharmaciehotel/panier_menu.php");
        ?>
    </div>
</div>