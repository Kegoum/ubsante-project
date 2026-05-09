<?php
if (!empty($_GET["actionpm"])) {
    $a = 'hotelpages/pharmaciehotel/commandepharmaciehotel/commander_divers';
    
    switch ($_GET["actionpm"]) {
        case "remove":
            if (!empty($_SESSION["cart_prodvb"])) {

                foreach ($_SESSION["cart_prodvb"] as $k => $v) {
                    if (($_SESSION["cart_prodvb"][$k]["idart"] == $_GET["idp"])) {
                        if (empty($_SESSION["cart_prodvb"])) {
                            unset($_SESSION["cart_prodvb"]);
                        } else {
                            unset($_SESSION["cart_prodvb"][$k]);
                        }
                    }
                }
            }
            if (isset($_SESSION["loginproprietaire"])) {
                die('<meta http-equiv="refresh" content="0; URL=indexadmin.php?page=' . base64_encode($a) . '">');
            } else if (($_SESSION["code_service"] == "DG")) {
                    die('<meta http-equiv="refresh" content="0; URL=indexdg.php?page=' . base64_encode($a) . '">');
                } else {
                die('<meta http-equiv="refresh" content="0; URL=indexpersonnel.php?page=' . base64_encode($a) . '">');
            }
            break;
        case "edit":

            $total_pricev = 0;
            $productparid = $con->query("select * from hotel_magasin_pharmacie as mb left join hotel_article_point_hotel "
                            . "as aph on mb.id_article_point_hotel=aph.id_article_point_hotel left join hotel_article as a on "
                            . "aph.id_article=a.id_article where mb.id_magasin_pharmacie='" . $_GET["idp"] . "'");
            $rowp = mysqli_fetch_assoc($productparid);

            foreach ($_SESSION["cart_prodvb"] as $k => $v) {
                if (($_SESSION["cart_prodvb"][$k]["idart"] == $_GET["idp"])) {
                    $_SESSION["cart_prodvb"][$k]["qteart"] = $_POST["qteprd"];
                }
                $total_pricev += $_SESSION["cart_prodvb"][$k]["prixart"] * $_SESSION["cart_prodvb"][$k]["qteart"];
            }
            if (isset($_SESSION["loginproprietaire"])) {
                die('<meta http-equiv="refresh" content="0; URL=indexadmin.php?page=' . base64_encode($a) . '">');
            } else if (($_SESSION["code_service"] == "DG")) {
                    die('<meta http-equiv="refresh" content="0; URL=indexdg.php?page=' . base64_encode($a) . '">');
                } else {
                die('<meta http-equiv="refresh" content="0; URL=indexpersonnel.php?page=' . base64_encode($a) . '">');
            }
            break;
        case "empty":
            unset($_SESSION["cart_prodvb"]);
            if (isset($_SESSION["loginproprietaire"])) {
                die('<meta http-equiv="refresh" content="0; URL=indexadmin.php?page=' . base64_encode($a) . '">');
            } else if (($_SESSION["code_service"] == "DG")) {
                    die('<meta http-equiv="refresh" content="0; URL=indexdg.php?page=' . base64_encode($a) . '">');
                } else {
                die('<meta http-equiv="refresh" content="0; URL=indexpersonnel.php?page=' . base64_encode($a) . '">');
            }
            break;
    }
}
?>

<?php
$total_pricev = 0.00;
if (isset($_SESSION["cart_prodvb"])) {
    ?>	
    <?php
    foreach ($_SESSION["cart_prodvb"] as $prod) {
        $productparid = $con->query("select * from hotel_magasin_pharmacie as mb left join hotel_article_point_hotel "
                            . "as aph on mb.id_article_point_hotel=aph.id_article_point_hotel left join hotel_article as a on "
                            . "aph.id_article=a.id_article where mb.id_magasin_pharmacie='" . $prod["idart"] . "'");
        $product_info = mysqli_fetch_assoc($productparid);
        $total_pricev += $prod["prixart"] * $prod["qteart"];
        ?>
        <div class="row">
            <div class="col-sm-3" style="text-align: center;">
                <?php
                if (isset($_SESSION["loginproprietaire"])) {
                    ?>
                    <form method="post" name="frmCartEdit" id="frmCartEdit" action="indexadmin.php?page=<?php echo base64_encode('hotelpages/pharmaciehotel/commandepharmaciehotel/panier_menu') ?>&actionpm=edit&idp=<?php echo $prod["idart"]; ?>" >
                        <div class="input-group">
                            <input type="text" name="qteprd" id="<?php echo $prod["idart"]; ?>" value="<?php echo $prod["qteart"]; ?>" size="1" />
                            <div class="input-group-btn">
                                <button type="submit" name="envoiarticle" value="modifier" title="Modifier cette quantit&eacute;" class="btn btn-xs btn-success" ><i class="glyphicon glyphicon-edit"></i></button>
                            </div>
                        </div>
                    </form>
                    <?php
                } else if (($_SESSION["code_service"] == "DG")) {
                    ?>
                    <form method="post" name="frmCartEdit" id="frmCartEdit" action="indexdg.php?page=<?php echo base64_encode('hotelpages/pharmaciehotel/commandepharmaciehotel/panier_menu') ?>&actionpm=edit&idp=<?php echo $prod["idart"]; ?>" >
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
                    <form method="post" name="frmCartEdit" id="frmCartEdit" action="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/pharmaciehotel/commandepharmaciehotel/panier_menu') ?>&actionpm=edit&idp=<?php echo $prod["idart"]; ?>" >
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
                <?php echo $prod["prixart"] ?> F CFA

            </div>
            <div class="col-sm-1 pull-left">
                <?php
                if (isset($_SESSION["loginproprietaire"])) {
                    ?>
                    <a href="indexadmin.php?page=<?php echo base64_encode('hotelpages/pharmaciehotel/commandepharmaciehotel/panier_menu') ?>&actionpm=remove&idp=<?php echo $prod["idart"]; ?>" title="Supprimer ce produit du panier">
                        <i class="glyphicon glyphicon-trash"></i>
                    </a>
                    <?php
                } else if (($_SESSION["code_service"] == "DG")) {
                    ?>
                    <a href="indexdg.php?page=<?php echo base64_encode('hotelpages/pharmaciehotel/commandepharmaciehotel/panier_menu') ?>&actionpm=remove&idp=<?php echo $prod["idart"]; ?>" title="Supprimer ce produit du panier">
                        <i class="glyphicon glyphicon-trash"></i>
                    </a>
                    <?php
                } else {
                    ?>
                    <a href="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/pharmaciehotel/commandepharmaciehotel/panier_menu') ?>&actionpm=remove&idp=<?php echo $prod["idart"]; ?>" title="Supprimer ce produit du panier">
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
        if ($_SESSION["session_prodsvb"] != 0) {
            ?>
            <div class="row" style="text-align: center; color: red"> Total : <span id="total_price"><?php echo number_format($total_pricev, 2) . " F CFA"; ?></span> 
            </div><br>
            <div class="row" style="text-align: center">
                <a href="indexadmin.php?page=<?php echo base64_encode('hotelpages/pharmaciehotel/commandepharmaciehotel/traite_commander_divers') ?>&prixt=<?php echo $total_pricev; ?>" title="Enregistrer et imprimer la facture" class="btn btn-success">
                    <span title="Enregistrer et imprimer la facture" alt="vois"><i class="glyphicon glyphicon-shopping-cart"></i></span>
                    Enregistrer
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
    } else if (($_SESSION["code_service"] == "DG")) {
        if ($_SESSION["session_prodsvb"] != 0) {
            ?>
            <div class="row" style="text-align: center; color: red"> Total : <span id="total_price"><?php echo number_format($total_pricev, 2) . " F CFA"; ?></span> 
            </div><br>
            <div class="row" style="text-align: center">
                <a href="indexdg.php?page=<?php echo base64_encode('hotelpages/pharmaciehotel/commandepharmaciehotel/traite_commander_divers') ?>&prixt=<?php echo $total_pricev; ?>" title="Enregistrer et imprimer la facture" class="btn btn-success">
                    <span title="Enregistrer et imprimer la facture" alt="vois"><i class="glyphicon glyphicon-shopping-cart"></i></span>
                    Enregistrer
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
        if ($_SESSION["session_prodsvb"] != 0) {
            ?>
            <div class="row" style="text-align: center; color: red">
                Total : <span id="total_price"><?php echo number_format($total_pricev, 2, ',', ' ') . "F CFA"; ?></span> 
            </div><br>
            <div class="row" style="text-align: center">
                <a href="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/pharmaciehotel/commandepharmaciehotel/traite_commander_divers') ?>&prixt=<?php echo $total_pricev; ?>" title="Enregistrer et imprimer la facture" class="btn btn-success">
                    <span title="Enregistrer et imprimer la facture" alt="vois"><i class="glyphicon glyphicon-shopping-cart"></i></span>
                    Enregistrer
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
    } else if (($_SESSION["code_service"] == "DG")) {
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