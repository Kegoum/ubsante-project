<?php
if (!empty($_GET["actionpm"])) {
    $a = 'hopitalpages/hopitalmagasin/hopitalboncommande/commande';
    switch ($_GET["actionpm"]) {
        case "remove":
            if (!empty($_SESSION["cart_prodvcex"])) {

                foreach ($_SESSION["cart_prodvcex"] as $k => $v) {
                    if (($_SESSION["cart_prodvcex"][$k]["idart"] == $_GET["idp"])) {
                        if (empty($_SESSION["cart_prodvcex"])) {
                            unset($_SESSION["cart_prodvcex"]);
                        } else {
                            unset($_SESSION["cart_prodvcex"][$k]);
                        }
                    }
                }
            }
            die('<meta http-equiv="refresh" content="0; URL=' . $url . '?page=' . base64_encode($a) . '">');

            break;
        case "edit":

            $total_pricev = 0;
            $productparid = $con->query("select * from hp_produit as a left join hp_categorie as c on "
                    . "a.idcategorie=c.idcategorie where a.idproduit='" . $_GET["idp"] . "'");
            $rowp = mysqli_fetch_assoc($productparid);

            foreach ($_SESSION["cart_prodvcex"] as $k => $v) {
                if (($_SESSION["cart_prodvcex"][$k]["idart"] == $_GET["idp"])) {
                    $_SESSION["cart_prodvcex"][$k]["qteart"] = $_POST["qteprd"];
                }
                $total_pricev += $_SESSION["cart_prodvcex"][$k]["prixarta"] * $_SESSION["cart_prodvcex"][$k]["qteart"];
            }
            die('<meta http-equiv="refresh" content="0; URL='.$url.'?page=' . base64_encode($a) . '">');
            break;
        case "empty":
            unset($_SESSION["cart_prodvcex"]);
            die('<meta http-equiv="refresh" content="0; URL='.$url.'?page=' . base64_encode($a) . '">');
            break;
    }
}
?>

<?php
$total_pricev = 0.00;
if (isset($_SESSION["cart_prodvcex"])) {
    ?>	
    <?php
    foreach ($_SESSION["cart_prodvcex"] as $prod) {
        $productparid = $con->query("select * from hp_produit as a left join hp_categorie as c on "
                . "a.idcategorie=c.idcategorie where a.idproduit='" . $prod["idart"] . "'");
        $product_info = mysqli_fetch_assoc($productparid);
        $total_pricev += $prod["prixarta"] * $prod["qteart"];
        ?>
        <div class="row">
            <div class="col-sm-3" style="text-align: center;">
                <form method="post" name="frmCartEdit" id="frmCartEdit" action="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalmagasin/hopitalboncommande/panier_menu') ?>&actionpm=edit&idp=<?php echo $prod["idart"]; ?>" >
                    <div class="input-group">
                        <input type="text" name="qteprd" id="<?php echo $prod["idart"]; ?>" value="<?php echo $prod["qteart"]; ?>" size="1" />
                        <div class="input-group-btn">
                            <button type="submit" name="envoiproduit" value="modifier" title="Modifier cette quantit&eacute;" class=" btn-xs btn-primary" ><i class="glyphicon glyphicon-edit"></i></button>
                        </div>
                    </div>
                </form>

            </div>
            <div class="col-sm-7">
                <?php echo $prod["designationart"] ?> &nbsp;&nbsp; 
                <?php echo $prod["prixarta"] ?> F CFA

            </div>
            <div class="col-sm-1 pull-left">
                <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalmagasin/hopitalboncommande/panier_menu') ?>&actionpm=remove&idp=<?php echo $prod["idart"]; ?>" title="Supprimer ce produit du panier">
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
        if ($_SESSION["session_prodsvcex"] != 0) {
            ?>
            <div class="row" style="text-align: center; color: red"> Total : <span id="total_price"><?php echo number_format($total_pricev, 2) . " F CFA"; ?></span> 
            </div><br>
            <div class="row" style="text-align: center">
                <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalmagasin/hopitalboncommande/traite_commande') ?>&prixt=<?php echo $total_pricev; ?>" title="Enregistrer et imprimer la facture" class="btn btn-primary">
                    <span title="Enregistrer et imprimer la facture" alt="vois"><i class="glyphicon glyphicon-shopping-cart"></i></span>
                    Commander
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