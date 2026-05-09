<?php
if (!empty($_GET["actionpm"])) {
    $a = 'hopitalpages/hopitalmagasin/hopitalbonlivraisonc/livraison';
    $id = $_REQUEST["boncommande"];
    switch ($_GET["actionpm"]) {
        case "remove":
            if (!empty($_SESSION["cart_prodvlebc" . $id])) {

                foreach ($_SESSION["cart_prodvlebc" . $id] as $k => $v) {
                    if (($_SESSION["cart_prodvlebc" . $id][$k]["idart"] == $_GET["idp"])) {
                        if (empty($_SESSION["cart_prodvlebc" . $id])) {
                            unset($_SESSION["cart_prodvlebc" . $id]);
                        } else {
                            unset($_SESSION["cart_prodvlebc" . $id][$k]);
                        }
                    }
                }
            }
            die('<meta http-equiv="refresh" content="0; URL=' . $url . '?page=' . base64_encode($a) . '&boncommande=' . $id . '">');
            break;
        case "edit":

            $total_pricev = 0;
            $productparid = $con->query("select * from hp_ligne_bon_commande as lbl left join "
                    . "hp_produit as a on lbl.idproduit=a.idproduit left join hp_categorie as c "
                    . "on a.idcategorie=c.idcategorie where lbl.idligneboncommande='" . $_GET["idp"] . "'");
            $rowp = mysqli_fetch_assoc($productparid);

            foreach ($_SESSION["cart_prodvlebc" . $id] as $k => $v) {
                $rsltuv2 = $con->query("select * from hp_conversion where idunite='" . $_POST["uniteprd"] . "' and "
                        . "idproduit='" . $rowp["idproduit"] . "'") or die(mysqli_error($con));
                $rowvv = mysqli_fetch_assoc($rsltuv2);
                $pr = $_POST["prixprd"];
                if (($_SESSION["cart_prodvlebc" . $id][$k]["idart"] == $_GET["idp"])) {

                    $qtec = $rowp["stockligneboncommande"];
                    $stoccp = $rowp["stocklivreligneboncommande"];
                    $qtel = $_POST["qteprd"];
                    if ($rowp["idunite"] != $_POST["uniteprd"]) {
                        $rsltuv2b = $con->query("select * from hp_conversion where idunite='" . $rowp["idunite"] . "' and "
                                . "idproduit='" . $rowp["idproduit"] . "'") or die(mysqli_error($con));
                        $rowvvb = mysqli_fetch_assoc($rsltuv2b);
                        if ($rowvvb["conversion"] != 0) {
                            $qtec = (($rowp["stockligneboncommande"]) * ($rowvv["conversion"]) / $rowvvb["conversion"]);
                            $stoccp = (($rowp["stocklivreligneboncommande"]) * ($rowvv["conversion"]) / $rowvvb["conversion"]);
                        }
                    }
                    if ($qtel > ($qtec - $stoccp)) {
                        $qtel = ($qtec - $stoccp);
                    }
                    $_SESSION["cart_prodvlebc" . $id][$k]["qteart"] = $qtel;
                    $_SESSION["cart_prodvlebc" . $id][$k]["prixartliv"] = $pr;
                    $_SESSION["cart_prodvlebc" . $id][$k]["uniteartliv"] = $_POST["uniteprd"];
                    if ($qtel < ($qtec - $stoccp)) {
                        $_SESSION["cart_prodvlebc" . $id][$k]["stockok"] = FALSE;
                    } else {
                        $_SESSION["cart_prodvlebc" . $id][$k]["stockok"] = TRUE;
                    }
                }
                $total_pricev += $_SESSION["cart_prodvlebc" . $id][$k]["prixartliv"] * $_SESSION["cart_prodvlebc" . $id][$k]["qteart"];
            }

            die('<meta http-equiv="refresh" content="0; URL=' . $url . '?page=' . base64_encode($a) . '&boncommande=' . $id . '">');
            break;
        case "empty":
            unset($_SESSION["cart_prodvlebc" . $id]);
            die('<meta http-equiv="refresh" content="0; URL=' . $url . '?page=' . base64_encode($a) . '&boncommande=' . $id . '">');
            break;
    }
}
?>

<?php
$total_pricev = 0.00;
if (isset($_SESSION["cart_prodvlebc" . $id])) {
    ?>	
    <?php
    foreach ($_SESSION["cart_prodvlebc" . $id] as $prod) {
        $productparid = $con->query("select * from hp_ligne_bon_commande as lbl left join "
                . "hp_produit as a on lbl.idproduit=a.idproduit left join hp_categorie as c "
                . "on a.idcategorie=c.idcategorie where lbl.idligneboncommande='" . $prod["idart"] . "'");
        $product_info = mysqli_fetch_assoc($productparid);
        $total_pricev += $prod["prixartliv"] * $prod["qteart"];
        ?>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" >
                <form method="post" name="frmCartEdit" id="frmCartEdit" action="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalmagasin/hopitalbonlivraisonc/panier_menu') ?>&actionpm=edit&idp=<?php echo $prod["idart"]; ?>&boncommande=<?php echo $_REQUEST["boncommande"]; ?>" >
                    <div class="input-group">
                        <div class="row">
                            <div class="col-sm-1">
                                <input type="text" name="qteprd" id="<?php echo $prod["idart"]; ?>" value="<?php echo $prod["qteart"]; ?>" size="1" />
                            </div>
                            <div class="col-sm-4">
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
                            <div class="col-sm-5">
                                <input type="text" name="prixprd" id="<?php echo $prod["idart"]; ?>" value="<?php echo $prod["prixartliv"]; ?>" size="4" />
                            </div>
                            <div class="col-sm-1">
                                <div class="input-group-btn">
                                    <button type="submit" name="envoiproduit" value="modifier" title="Modifier cette quantit&eacute;" class=" btn-xs btn-success" ><i class="glyphicon glyphicon-edit"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">

                <?php echo $prod["designationart"] ?> &nbsp;&nbsp; 
                <?php echo $prod["qteart"] * $prod["prixartliv"] ?> F CFA

            </div>
            <div class="col-sm-1 pull-left">
                <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalmagasin/hopitalbonlivraisonc/panier_menu') ?>&actionpm=remove&idp=<?php echo $prod["idart"]; ?>&boncommande=<?php echo $_REQUEST["boncommande"]; ?>" title="Supprimer ce produit du panier">
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
    if ($_SESSION["session_prodsvlebc" . $id] != 0) {
        ?>
        <div class="row" style="text-align: center; color: red"> Total : <span id="total_price"><?php echo number_format($total_pricev, 2) . " F CFA"; ?></span> 
        </div><br>
        <form id="pointhp_form" action="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalmagasin/hopitalbonlivraisonc/traite_livraison') ?>&boncommande=<?php echo $_REQUEST["boncommande"]; ?>&prixt=<?php echo $total_pricev; ?>" method="post">
            <div class="row ">
                <div class="col-sm-12">
                    <div class="form-group" style="margin-left:15px;">
                        <label>Fournisseur (Laisser vide si inconnu)</label> <br>
                        <input class="form-control" placeholder="Le nom du fournisseur" type="text" name="nomf" id="nomf" />
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group" style="margin-left:15px;">
                        <label>Transport </label> <br>
                        <input class="form-control" placeholder="Le transport" type="text" name="transport" id="transport" />
                    </div>
                </div>
            </div>
            <div class="row" style="text-align: center">
                <button type="submit" title="Enregistrer le bon de livraison" class="btn btn-success">
                    <span title="Enregistrer le bon de livraison" alt="vois"></span>
                    Enregistrer
                </button>
            </div>
        </form>
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