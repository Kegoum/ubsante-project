<?php
if (!empty($_GET["actionpm"])) {
    $a = 'hopitalpages/hopitalpatient/hopitalcommandepharmaciepatient/commander_patient';
    $id = $_REQUEST["ordonnance"];
    switch ($_GET["actionpm"]) {
        case "remove":
            if (!empty($_SESSION["cart_prodlordp" . $id])) {

                foreach ($_SESSION["cart_prodlordp" . $id] as $k => $v) {
                    if (($_SESSION["cart_prodlordp" . $id][$k]["idart"] == $_GET["idp"])) {
                        if (empty($_SESSION["cart_prodlordp" . $id])) {
                            unset($_SESSION["cart_prodlordp" . $id]);
                        } else {
                            unset($_SESSION["cart_prodlordp" . $id][$k]);
                        }
                    }
                }
            }
            die('<meta http-equiv="refresh" content="0; URL='.$url.'?page=' . base64_encode($a) . '&ordonnance=' . $id . '">');
            break;
        case "edit":

            $total_pricev = 0;
            $productparidp = $con->query("select * from hp_ligne_ordonnance as lbl left join "
                        . "hp_produit as a on lbl.idproduit=a.idproduit left join hp_categorie as c "
                        . "on a.idcategorie=c.idcategorie where lbl.idligneordonnance='" . $_GET["idp"] . "'");
                $rowpp = mysqli_fetch_assoc($productparidp);
                
                $productparid = $con->query("select * from hp_boutique as lbl left join "
                        . "hp_produit as a on lbl.idproduit=a.idproduit left join hp_categorie as c "
                        . "on a.idcategorie=c.idcategorie where lbl.idproduit='" . $rowpp["idproduit"] . "'");
                $rowp = mysqli_fetch_assoc($productparid);
            foreach ($_SESSION["cart_prodlordp" . $id] as $k => $v) {
                if (($_SESSION["cart_prodlordp" . $id][$k]["idart"] == $_GET["idp"])) {
                    $q = $_POST["qteprd"];
                    if (($rowpp["stockligneordonnance"] - $rowpp["stocklivreligneordonnance"]) <= $q) {
                        $q = ($rowpp["stockligneordonnance"] - $rowpp["stocklivreligneordonnance"]);
                    }
                    if ($rowp["stockproduit"] >= $q) {
                        $_SESSION["cart_prodlordp" . $id][$k]["qteart"] = $q;
                    } else {

                        $rsltuarpa = $con->query("select * from hp_conversion where idunite='" . $rowpp["idunite"] . "' "
                                . "and idproduit='" . $rowp["idproduit"] . "'") or die(mysqli_error($con));
                        $npharmaciepa = mysqli_num_rows($rsltuarpa);

                        $rowarpa = mysqli_fetch_assoc($rsltuarpa);
                        if ($npharmaciepa != 0) {
                            if ($rowpp["stockligneordonnance"] > $rowarpa["stockconversion"]) {
                                $pro = $rowarpa["stockconversion"];
                                $_SESSION["cart_prodlordp" . $id][$k]["qteart"] = $pro;
                                echo "<script language='javascript'>alert('Desole produits insuffisants en stock')</script>";
                            } else {
                                $_SESSION["cart_prodlordp" . $id][$k]["qteart"] = $q;
                            }
                        } else {
                            $pro = $rowp["stockproduit"];
                            $_SESSION["cart_prodlordp" . $id][$k]["qteart"] = $pro;
                            echo "<script language='javascript'>alert('Desole produits insuffisants en stock')</script>";
                        }
                    }
                    if ($q < ($rowpp["stockligneordonnance"] - $rowpp["stocklivreligneordonnance"])) {
                        $_SESSION["cart_prodlordp" . $id][$k]["stockok"] = FALSE;
                    } else {
                        $_SESSION["cart_prodlordp" . $id][$k]["stockok"] = TRUE;
                    }
                }
                $total_pricev += $_SESSION["cart_prodlordp" . $id][$k]["prixartliv"] * $_SESSION["cart_prodlordp" . $id][$k]["qteart"];
            }
            die('<meta http-equiv="refresh" content="0; URL='.$url.'?page=' . base64_encode($a) . '&ordonnance=' . $id . '">');
            break;
        case "empty":
            unset($_SESSION["cart_prodlordp" . $id]);
            die('<meta http-equiv="refresh" content="0; URL='.$url.'?page=' . base64_encode($a) . '&ordonnance=' . $id . '">');
            break;
    }
}
?>

<?php
$total_pricev = 0.00;
if (isset($_SESSION["cart_prodlordp" . $id])) {
    ?>	
    <?php
    foreach ($_SESSION["cart_prodlordp" . $id] as $prod) {
        $productparid = $con->query("select * from hp_ligne_ordonnance as lbl left join "
                . "hp_produit as a on lbl.idproduit=a.idproduit left join hp_categorie as c "
                . "on a.idcategorie=c.idcategorie where lbl.idligneordonnance='" . $prod["idart"] . "'");
        $product_info = mysqli_fetch_assoc($productparid);
        $total_pricev += $prod["prixartliv"] * $prod["qteart"];
        ?>
        <div class="row">
            <div class="col-sm-3" style="text-align: center;">
                <form method="post" name="frmCartEdit" id="frmCartEdit" action="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitalcommandepharmaciepatient/panier_menu') ?>&actionpm=edit&idp=<?php echo $prod["idart"]; ?>&ordonnance=<?php echo $_REQUEST["ordonnance"]; ?>" >
                        <div class="input-group">
                            <div class="row">
                                <div class="col-sm-3">
                                    <input type="text" name="qteprd" id="<?php echo $prod["idart"]; ?>" value="<?php echo $prod["qteart"]; ?>" size="1" />
                                </div>
                                <div class="col-sm-6">
                                    <?php
                                    $rsltua = $con->query("select * from hp_unite where idunite='" . $prod["uniteartliv"] . "'") or die(mysqli_error($con));
                                    $rowa = mysqli_fetch_assoc($rsltua);
                                    print nl2br(htmlspecialchars($rowa["codeunite"]));
                                    ?> 
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
                <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitalcommandepharmaciepatient/panier_menu') ?>&actionpm=remove&idp=<?php echo $prod["idart"]; ?>&ordonnance=<?php echo $_REQUEST["ordonnance"]; ?>" title="Supprimer ce produit du panier">
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
    if ($_SESSION["session_prodslordp" . $id] != 0) {
            ?>
            <div class="row" style="text-align: center; color: red"> Total : <span id="total_price"><?php echo number_format($total_pricev, 2) . " F CFA"; ?></span> 
            </div><br>
            <div class="row" style="text-align: center">
                <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitalcommandepharmaciepatient/traite_commander_patient') ?>&ordonnance=<?php echo $_REQUEST["ordonnance"]; ?>&prixt=<?php echo $total_pricev; ?>" title="Envoyer le bon de livraison" class="btn btn-primary">
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