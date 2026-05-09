<?php
    $idc=$_REQUEST["idconsultation"];
    $a = 'hopitalpages/hopitalpatient/hopitalconsultation/hopitalajouterplan/ajout_consultation';
    $stag = 2;
    
if (!empty($_GET["actionpm"])) {
    
    switch ($_GET["actionpm"]) {
        case "remove":
            if (!empty($_SESSION["cart_prodvactplan".$idc])) {

                foreach ($_SESSION["cart_prodvactplan".$idc] as $k => $v) {
                    if (($_SESSION["cart_prodvactplan".$idc][$k]["idart"] == $_GET["idp"])) {
                        if (empty($_SESSION["cart_prodvactplan".$idc])) {
                            unset($_SESSION["cart_prodvactplan".$idc]);
                        } else {
                            unset($_SESSION["cart_prodvactplan".$idc][$k]);
                        }
                    }
                }
            }
               die('<meta http-equiv="refresh" content="0; URL=' . $url . '?page=' . base64_encode($a) . '&idconsultation=' . $idc . '&pagecom='.$stag.'">');
            break;
        case "edit":

            $total_pricev = 0;
            $productparid = $con->query("select * from hp_acte as a where a.idacte='" . $_GET["idp"] . "'");
            $rowp = mysqli_fetch_assoc($productparid);
            foreach ($_SESSION["cart_prodvactplan".$idc] as $k => $v) {
                if (($_SESSION["cart_prodvactplan".$idc][$k]["idart"] == $_GET["idp"])) {
                    $_SESSION["cart_prodvactplan".$idc][$k]["qteart"] = $_POST["qteprd"];
                    $_SESSION["cart_prodvactplan".$idc][$k]["prixart"] = $rowp["prixacte"];
                    
                }
                $total_pricev += $_SESSION["cart_prodvactplan".$idc][$k]["prixart"] * $_SESSION["cart_prodvactplan".$idc][$k]["qteart"];
            }
               die('<meta http-equiv="refresh" content="0; URL=' . $url . '?page=' . base64_encode($a) . '&idconsultation=' . $idc . '&pagecom='.$stag.'">');
            break;
        case "empty":
            unset($_SESSION["cart_prodvactplan".$idc]);
               die('<meta http-equiv="refresh" content="0; URL=' . $url . '?page=' . base64_encode($a) . '&idconsultation=' . $idc . '&pagecom='.$stag.'">');
            break;
    }
}
?>

<?php
$total_pricev = 0.00;
if (isset($_SESSION["cart_prodvactplan".$idc])) {
    ?>	
    <?php
    foreach ($_SESSION["cart_prodvactplan".$idc] as $prod) {
        $productparid = $con->query("select * from hp_acte as a where a.idacte='" . $prod["idart"] . "'");
        $product_info = mysqli_fetch_assoc($productparid);
        $total_pricev += $prod["prixart"] * $prod["qteart"];

        ?>
        <div class="row">
            
            <div class="col-sm-10">
                <?php echo $prod["designationart"] ?> &nbsp;&nbsp; 
                <?php echo $prod["prixart"] ?> 
                <!--F CFA-->

            </div>
            <div class="col-sm-1 pull-left">
                <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitalconsultation/hopitalajouterplan/panier_menu_acte') ?>&actionpm=remove&idp=<?php echo $prod["idart"]; ?>&idconsultation=<?php echo $_REQUEST["idconsultation"]; ?>" title="Supprimer ce acte du panier">
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
    if ($_SESSION["session_prodsactplan".$idc] != 0) {
        ?>
        <div class="row" style="text-align: center; color: red"> Total : <span id="total_price"><?php echo number_format($total_pricev, 2) . " F CFA"; ?></span> 
        </div><br>
<!--        <div class="row" style="text-align: center">
            <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitalconsultation/hopitalajouterplan/ajout_consultation'); ?>&idconsultation=<?php echo $_REQUEST["idconsultation"]; ?>&pagecom=<?php echo ($stag + 1); ?>" title="Enregistrer et imprimer la facture" class="btn btn-primary">
                <span title="Enregistrer " alt="vois"><i class="glyphicon glyphicon-shopping-cart"></i></span>
                Enregistrer
            </a>
        </div>-->
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