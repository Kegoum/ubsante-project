<?php
if (!empty($_GET["actionpm"])) {
    $a = 'hotelpages/restauranthotel/bonlivraisonhotel/livraison';
    switch ($_GET["actionpm"]) {
        case "remove":
            if (!empty($_SESSION["cart_prodvlir"])) {

                foreach ($_SESSION["cart_prodvlir"] as $k => $v) {
                    if (($_SESSION["cart_prodvlir"][$k]["idart"] == $_GET["idp"])) {
                        if (empty($_SESSION["cart_prodvlir"])) {
                            unset($_SESSION["cart_prodvlir"]);
                        } else {
                            unset($_SESSION["cart_prodvlir"][$k]);
                        }
                    }
                }
            }
            if (isset($_SESSION["loginproprietaire"])) {
                die('<meta http-equiv="refresh" content="0; URL=indexadmin.php?page=' . base64_encode($a) . '">');
            } else {
                die('<meta http-equiv="refresh" content="0; URL=indexpersonnel.php?page=' . base64_encode($a) . '">');
            }
            break;
        case "edit":

            $total_pricev = 0;
            $productparid = $con->query("select * from hotel_article as a left join hotel_categorie as c on "
                    . "a.id_categorie=c.id_categorie left join hotel_fourniture as f on a.id_fourniture=f.id_fourniture where "
                    . "a.id_article='" . $_GET["idp"] . "'");
            $rowp = mysqli_fetch_assoc($productparid);

            foreach ($_SESSION["cart_prodvlir"] as $k => $v) {
                if (($_SESSION["cart_prodvlir"][$k]["idart"] == $_GET["idp"])) {
                    $q = $_POST["qteprd"];
                    if ($rowp["stock_article"] >= $q) {
                        $_SESSION["cart_prodvlir"][$k]["qteart"] = $_POST["qteprd"];
                    } else {
                        $pro = $rowp["stock_article"];
                        $_SESSION["cart_prodvlir"][$k]["qteart"] = $pro;
                        echo "<script language='javascript'>alert('Desole articles insuffisants en stock')</script>";
                    }
                }
                $total_pricev += $_SESSION["cart_prodvlir"][$k]["uniteartv"] * $_SESSION["cart_prodvlir"][$k]["qteart"];
            }
            if (isset($_SESSION["loginproprietaire"])) {
                die('<meta http-equiv="refresh" content="0; URL=indexadmin.php?page=' . base64_encode($a) . '">');
            } else {
                die('<meta http-equiv="refresh" content="0; URL=indexpersonnel.php?page=' . base64_encode($a) . '">');
            }
            break;
        case "empty":
            unset($_SESSION["cart_prodvlir"]);
            if (isset($_SESSION["loginproprietaire"])) {
                die('<meta http-equiv="refresh" content="0; URL=indexadmin.php?page=' . base64_encode($a) . '">');
            } else {
                die('<meta http-equiv="refresh" content="0; URL=indexpersonnel.php?page=' . base64_encode($a) . '">');
            }
            break;
    }
}
?>

<?php
$total_pricev = 0.00;
if (isset($_SESSION["cart_prodvlir"])) {
    ?>	
    <?php
    foreach ($_SESSION["cart_prodvlir"] as $prod) {
        $productparid = $con->query("select * from hotel_article as a left join hotel_categorie as c on "
                . "a.id_categorie=c.id_categorie left join hotel_fourniture as f on a.id_fourniture=f.id_fourniture where "
                . "a.id_article='" . $prod["idart"] . "'");
        $product_info = mysqli_fetch_assoc($productparid);
        $total_pricev += $prod["uniteartv"] * $prod["qteart"];
        ?>
        <div class="row">
            <div class="col-sm-3" style="text-align: center;">
                <?php
                if (isset($_SESSION["loginproprietaire"])) {
                    ?>
                    <form method="post" name="frmCartEdit" id="frmCartEdit" action="indexadmin.php?page=<?php echo base64_encode('hotelpages/restauranthotel/bonlivraisonhotel/panier_menu') ?>&actionpm=edit&idp=<?php echo $prod["idart"]; ?>" >
                        <div class="input-group">
                            <input type="text" name="qteprd" id="<?php echo $prod["idart"]; ?>" value="<?php echo $prod["qteart"]; ?>" size="1" />
                            <div class="input-group-btn">
                                <button type="submit" name="envoiarticle" value="modifier" title="Modifier cette quantit&eacute;" class="btn btn-xs btn-success" ><i class="glyphicon glyphicon-edit"></i></button>
                            </div>
                        </div>
                    </form>
                    <?php
                } else {
                    ?>
                    <form method="post" name="frmCartEdit" id="frmCartEdit" action="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/restauranthotel/bonlivraisonhotel/panier_menu') ?>&actionpm=edit&idp=<?php echo $prod["idart"]; ?>" >
                        <div class="input-group">
                            <input type="text" name="qteprd" id="<?php echo $prod["idart"]; ?>" value="<?php echo $prod["qteart"]; ?>" size="1" />
                            <div class="input-group-btn">
                                <button type="submit" name="envoiarticle" value="modifier" title="Modifier cette quantit&eacute;" class="btn btn-xs btn-success" ><i class="glyphicon glyphicon-edit"></i></button>
                            </div>
                        </div>
                    </form>
                    <?php
                }
                ?>
            </div>
            <div class="col-sm-7">
                <?php echo $prod["designationart"] ?> &nbsp;&nbsp; 
                <?php echo $prod["uniteartv"] ?> F CFA

            </div>
            <div class="col-sm-1 pull-left">
                <?php
                if (isset($_SESSION["loginproprietaire"])) {
                    ?>
                    <a href="indexadmin.php?page=<?php echo base64_encode('hotelpages/restauranthotel/bonlivraisonhotel/panier_menu') ?>&actionpm=remove&idp=<?php echo $prod["idart"]; ?>" title="Supprimer ce produit du panier">
                        <i class="glyphicon glyphicon-trash"></i>
                    </a>
                    <?php
                } else {
                    ?>
                    <a href="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/restauranthotel/bonlivraisonhotel/panier_menu') ?>&actionpm=remove&idp=<?php echo $prod["idart"]; ?>" title="Supprimer ce produit du panier">
                        <i class="glyphicon glyphicon-trash"></i>
                    </a>
                    <?php
                }
                ?>
            </div>
        </div>
        <hr>
        <?php
    }

    $poi = (int) ($total_pricev / 6500);
    $_SESSION["point_fidelite"] = $poi;
    $reductio = ((int) ($poi / 5)) * 650;
    ?>
    <?php
    if (isset($_SESSION["loginproprietaire"])) {
        if ($_SESSION["session_prodsvlir"] != 0) {
            ?>
            <div class="row" style="text-align: center; color: red"> Total : <span id="total_price"><?php echo number_format($total_pricev, 2) . " F CFA"; ?></span> 
            </div><br>
            <div class="row" style="text-align: center">
                <a href="indexadmin.php?page=<?php echo base64_encode('hotelpages/restauranthotel/bonlivraisonhotel/traite_livraison') ?>&prixt=<?php echo $total_pricev; ?>" title="Envoyer le bon de livraison" class="btn btn-success">
                    <span title="Envoyer le bon de livraison" alt="vois"></span>
                    Envoyer
                </a>
            </div>
            <?php
        } else {
            ?>
            <div class="row" style="text-align: center">
                Panier vide !!! 
            </div>
            <?php
        }
    } else {
        if ($_SESSION["session_prodsvlir"] != 0) {
            ?>
            <div class="row" style="text-align: center; color: red">
                Total : <span id="total_price"><?php echo number_format($total_pricev, 2, ',', ' ') . "F CFA"; ?></span> 
            </div><br>
            <div class="row" style="text-align: center">
                <a href="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/restauranthotel/bonlivraisonhotel/traite_livraison') ?>&prixt=<?php echo $total_pricev; ?>" title="Envoyer le bon de livraison" class="btn btn-success">
                    <span title="Envoyer le bon de livraison" alt="vois"></span>
                    Envoyer
                </a>
            </div>
            <?php
        } else {
            ?>
            <div class="row" style="text-align: center">
                <!--<br><br>-->
                Panier vide !!! 
            </div>
            <?php
        }
    }
} else {
    if (isset($_SESSION["loginproprietaire"])) {
        ?>
        <div class="row" style="text-align: center">
            <!--<br><br>-->
            Panier vide !!!
        </div>
        <?php
    } else {
        ?>
        <div class="row" style="text-align: center">
            <!--<br><br>-->
            Panier vide !!! 
        </div>
        <?php
    }
}
?>