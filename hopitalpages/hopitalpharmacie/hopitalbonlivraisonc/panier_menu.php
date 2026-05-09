<?php
if (!empty($_GET["actionpm"])) {
    $a = 'hopitalpages/hopitalpharmacie/hopitalbonlivraisonc/livraison';
    $id = $_REQUEST["boncommande"];
    switch ($_GET["actionpm"]) {
        case "remove":
            if (!empty($_SESSION["cart_prodvlibc" . $id])) {

                foreach ($_SESSION["cart_prodvlibc" . $id] as $k => $v) {
                    if (($_SESSION["cart_prodvlibc" . $id][$k]["idart"] == $_GET["idp"])) {
                        if (empty($_SESSION["cart_prodvlibc" . $id])) {
                            unset($_SESSION["cart_prodvlibc" . $id]);
                        } else {
                            unset($_SESSION["cart_prodvlibc" . $id][$k]);
                        }
                    }
                }
            }
            die('<meta http-equiv="refresh" content="0; URL=' . $url . '?page=' . base64_encode($a) . '&boncommande=' . $id . '">');
            break;
        case "edit":

            $total_pricev = 0;
            $productparid = $con->query("select * from hp_ligne_bon_commande_interne as lbl left join "
                    . "hp_produit as a on lbl.idproduit=a.idproduit left join hp_categorie as c "
                    . "on a.idcategorie=c.idcategorie where lbl.idligneboncommandeinterne='" . $_GET["idp"] . "'");
            $rowp = mysqli_fetch_assoc($productparid);
            $rsltu = $con->query("select * from hp_conversion where idunite='" . $rowp["uniteachatproduit"] . "' and "
                    . "idproduit='" . $rowp["idproduit"] . "'") or die(mysqli_error($con));
            $rowu = mysqli_fetch_assoc($rsltu);
            foreach ($_SESSION["cart_prodvlibc" . $id] as $k => $v) {
                $rsltuv2 = $con->query("select * from hp_conversion where idunite='" . $_POST["uniteprd"] . "' and "
                        . "idproduit='" . $rowp["idproduit"] . "'") or die(mysqli_error($con));
                $rowvv = mysqli_fetch_assoc($rsltuv2);
                $pr=$rowvv["prixconversion"];
                if (($_SESSION["cart_prodvlibc" . $id][$k]["idart"] == $_GET["idp"])) {

                    $qtep = $rowp["stockproduit"];
                    $qtec = $rowp["stockligneboncommandeinterne"];
                    $stoccp = $rowp["stocklivreligneboncommandeinterne"];
                    $qtel = $_POST["qteprd"];
                    if ($rowp["idunite"] == $_POST["uniteprd"]) {
                        if (($qtec - $stoccp) <= $qtel) {
                            $qtel = ($qtec - $stoccp);
                        }
                        if ($rowp["idunite"] != $rowp["uniteachatproduit"]) {
                            if ($rowu["conversion"] != 0) {
                                $qtep = (($qtep) * ($rowvv["conversion"]) / $rowu["conversion"]);
                            }
                        }
                        if ($qtel > ($qtep)) {
                                 echo "<script language='javascript'>alert('Desole produits insuffisants en stock')</script>";
                            $qtel = ($qtep);
                        }
                        $_SESSION["cart_prodvlibc" . $id][$k]["qteart"] = $qtel;
                        $_SESSION["cart_prodvlibc" . $id][$k]["prixartliv"] = $pr;
                        $_SESSION["cart_prodvlibc" . $id][$k]["uniteartliv"] = $_POST["uniteprd"];
                        if ($qtel < ($qtec - $stoccp)) {
                            $_SESSION["cart_prodvlibc" . $id][$k]["stockok"] = FALSE;
                        } else {
                            $_SESSION["cart_prodvlibc" . $id][$k]["stockok"] = TRUE;
                        }
                    }  else {
                        $rsltuv2b = $con->query("select * from hp_conversion where idunite='" . $rowp["idunite"] . "' and "
                                . "idproduit='" . $rowp["idproduit"] . "'") or die(mysqli_error($con));
                        $rowvvb = mysqli_fetch_assoc($rsltuv2b);
                        if ($rowvvb["conversion"] != 0) {
                            $qtec = (($qtec) * ($rowvv["conversion"]) / $rowvvb["conversion"]);
                            $stoccp = (($stoccp) * ($rowvv["conversion"]) / $rowvvb["conversion"]);
                        }
                        if (($qtec - $stoccp) <= $qtel) {
                            $qtel = ($qtec - $stoccp);
                        }
                        if ($_POST["uniteprd"] != $rowp["uniteachatproduit"]) {
                            if ($rowu["conversion"] != 0) {
                                $qtep = (($qtep) * ($rowvv["conversion"]) / $rowu["conversion"]);
                            }
                        }
                        if ($qtel > ($qtep)) {
                                 echo "<script language='javascript'>alert('Desole produits insuffisants en stock')</script>";
                            $qtel = ($qtep);
                        }
                        $_SESSION["cart_prodvlibc" . $id][$k]["qteart"] = $qtel;
                        $_SESSION["cart_prodvlibc" . $id][$k]["prixartliv"] = $pr;
                        $_SESSION["cart_prodvlibc" . $id][$k]["uniteartliv"] = $_POST["uniteprd"];
                        if ($qtel < ($qtec - $stoccp)) {
                            $_SESSION["cart_prodvlibc" . $id][$k]["stockok"] = FALSE;
                        } else {
                            $_SESSION["cart_prodvlibc" . $id][$k]["stockok"] = TRUE;
                        }
                    }
                }
                $total_pricev += $_SESSION["cart_prodvlibc" . $id][$k]["prixartliv"] * $_SESSION["cart_prodvlibc" . $id][$k]["qteart"];
            }
            die('<meta http-equiv="refresh" content="0; URL=' . $url . '?page=' . base64_encode($a) . '&boncommande=' . $id . '">');
            break;
        case "empty":
            unset($_SESSION["cart_prodvlibc" . $id]);
            die('<meta http-equiv="refresh" content="0; URL=' . $url . '?page=' . base64_encode($a) . '&boncommande=' . $id . '">');
            break;
    }
}
?>

<?php
$total_pricev = 0.00;
if (isset($_SESSION["cart_prodvlibc" . $id])) {
    ?>	
    <?php
    foreach ($_SESSION["cart_prodvlibc" . $id] as $prod) {
        $productparid = $con->query("select * from hp_ligne_bon_commande_interne as lbl left join "
                . "hp_produit as a on lbl.idproduit=a.idproduit left join hp_categorie as c "
                . "on a.idcategorie=c.idcategorie where lbl.idligneboncommandeinterne='" . $prod["idart"] . "'");
        $product_info = mysqli_fetch_assoc($productparid);
        $total_pricev += $prod["prixartliv"] * $prod["qteart"];
        ?>
        <div class="row">
            <div class="col-sm-3" style="text-align: center;">
                <form method="post" name="frmCartEdit" id="frmCartEdit" action="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpharmacie/hopitalbonlivraisonc/panier_menu') ?>&actionpm=edit&idp=<?php echo $prod["idart"]; ?>&boncommande=<?php echo $_REQUEST["boncommande"]; ?>" >
                    <div class="input-group">
                        <div class="row">
                            <div class="col-sm-3">
                                <input type="text" name="qteprd" id="<?php echo $prod["idart"]; ?>" value="<?php echo $prod["qteart"]; ?>" size="1" />
                            </div>
                            <div class="col-sm-6">
                                <?php
//                                $rsltua = $con->query("select * from hp_unite where idunite='" . $prod["uniteartliv"] . "'") or die(mysqli_error($con));
//                                $rowa = mysqli_fetch_assoc($rsltua);
//                                print nl2br(htmlspecialchars($rowa["codeunite"]));

                                $productparidu = $con->query("select * from hp_conversion as c left join hp_unite "
                                        . "as u on c.idunite=u.idunite where c.idproduit='" . $product_info["idproduit"] . "'");
                                ?> <select name="uniteprd" id="<?php echo $prod["idart"]; ?>" class="text-input">
                                    <!--<option value="<?php echo($rowua["idunite"]); ?>" <?php if ($prod["uniteartliv"] == $rowua["idunite"]) { ?>selected<?php } ?> ><?php echo($rowua["libelleunite"]); ?></option>-->
                                    <?php
                                    /* Construction de la première liste : on se sert du tableau PHP */
                                    while ($rowuv = mysqli_fetch_assoc($productparidu)) {
                                        ?>
                                        <option value="<?php echo($rowuv["idunite"]); ?>" <?php if ($prod["uniteartliv"] == $rowuv["idunite"]) { ?>selected<?php } ?>><?php echo($rowuv["libelleunite"]); ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-sm-3">
                                <div class="input-group-btn">
                                    <button type="submit" name="envoiproduit" value="modifier" title="Modifier cette quantit&eacute;" class=" btn-xs btn-primary" ><i class="glyphicon glyphicon-edit"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-sm-7">

                <?php echo $prod["designationart"] ?> &nbsp;&nbsp; 
                <?php echo $prod["prixartliv"] ?> F CFA

            </div>
            <div class="col-sm-1 pull-left">
                <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpharmacie/hopitalbonlivraisonc/panier_menu') ?>&actionpm=remove&idp=<?php echo $prod["idart"]; ?>&boncommande=<?php echo $_REQUEST["boncommande"]; ?>" title="Supprimer ce produit du panier">
                    <i class="glyphicon glyphicon-trash"></i>
                </a>
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
    if ($_SESSION["session_prodsvlibc" . $id] != 0) {
        ?>
        <div class="row" style="text-align: center; color: red"> Total : <span id="total_price"><?php echo number_format($total_pricev, 2) . " F CFA"; ?></span> 
        </div><br>
        <div class="row" style="text-align: center">
            <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpharmacie/hopitalbonlivraisonc/traite_livraison') ?>&boncommande=<?php echo $_REQUEST["boncommande"]; ?>&prixt=<?php echo $total_pricev; ?>" title="Envoyer le bon de livraison" class="btn btn-primary">
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
    ?>
    <div class="row" style="text-align: center">
        <!--<br><br>-->
        Panier vide !!!
    </div>
    <?php
}
?>