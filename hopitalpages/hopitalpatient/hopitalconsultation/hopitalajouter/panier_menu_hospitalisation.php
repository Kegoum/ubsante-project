<?php
    $idc=$_REQUEST["idconsultation"];
    $a = 'hopitalpages/hopitalpatient/hopitalconsultation/hopitalajouter/ajout_consultation';
    $stag = 3;
    
if (!empty($_GET["actionpm"])) {
    
    switch ($_GET["actionpm"]) {
        case "remove":
            if (!empty($_SESSION["cart_prodvhos".$idc])) {

                foreach ($_SESSION["cart_prodvhos".$idc] as $k => $v) {
                    if (($_SESSION["cart_prodvhos".$idc][$k]["idart"] == $_GET["idp"])) {
                        if (empty($_SESSION["cart_prodvhos".$idc])) {
                            unset($_SESSION["cart_prodvhos".$idc]);
                        } else {
                            unset($_SESSION["cart_prodvhos".$idc][$k]);
                        }
                    }
                }
            }
               die('<meta http-equiv="refresh" content="0; URL=' . $url . '?page=' . base64_encode($a) . '&idconsultation=' . $idc . '&pagecom='.$stag.'">');
            break;
        case "edit":

            $total_pricev = 0;
            $productparid = $con->query("select * from hp_soin as a where a.idsoin='" . $_GET["idp"] . "'");
            $rowp = mysqli_fetch_assoc($productparid);
            $per=1;
            if ($_POST["periodeprd"]>1){
                $per=$_POST["periodeprd"];
            }
            foreach ($_SESSION["cart_prodvhos".$idc] as $k => $v) {
                if (($_SESSION["cart_prodvhos".$idc][$k]["idart"] == $_GET["idp"])) {
                    $_SESSION["cart_prodvhos".$idc][$k]["qteart"] = $_POST["qteprd"];
                    $_SESSION["cart_prodvhos".$idc][$k]["dateart"] = $_POST["dateprd"];
                    $_SESSION["cart_prodvhos".$idc][$k]["heureart"] = $_POST["heureprd"];
                    $_SESSION["cart_prodvhos".$idc][$k]["dosageart"] = $_POST["dosageprd"];
                    $_SESSION["cart_prodvhos".$idc][$k]["intervalleart"] = $_POST["intervalleprd"];
                    $_SESSION["cart_prodvhos".$idc][$k]["periodeart"] = $per;
                }
                $total_pricev += $_SESSION["cart_prodvhos".$idc][$k]["prixart"] * $_SESSION["cart_prodvhos".$idc][$k]["qteart"];
            }
               die('<meta http-equiv="refresh" content="0; URL=' . $url . '?page=' . base64_encode($a) . '&idconsultation=' . $idc . '&pagecom='.$stag.'">');
            break;
        case "empty":
            unset($_SESSION["cart_prodvhos".$idc]);
               die('<meta http-equiv="refresh" content="0; URL=' . $url . '?page=' . base64_encode($a) . '&idconsultation=' . $idc . '&pagecom='.$stag.'">');
            break;
    }
}
?>

<?php
$total_pricev = 0.00;
if (isset($_SESSION["cart_prodvhos".$idc])) {
    ?>	
    <?php
    foreach ($_SESSION["cart_prodvhos".$idc] as $prod) {
        $productparid = $con->query("select * from hp_soin as a where a.idsoin='" . $prod["idart"] . "'");
        $product_info = mysqli_fetch_assoc($productparid);
        $total_pricev += $prod["prixart"] * $prod["qteart"];

        ?>
        <div class="row">
            <div class="col-sm-7" style="text-align: center;">
                <form method="post" name="frmCartEdit" id="frmCartEdit" action="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitalconsultation/hopitalajouter/panier_menu_hospitalisation') ?>&actionpm=edit&idp=<?php echo $prod["idart"]; ?>&idconsultation=<?php echo $_REQUEST["idconsultation"]; ?>" >
                    <div class="input-group">
                        <div class="row">
                            <div class="col-sm-1">
                                <input type="text" name="qteprd" id="<?php echo $prod["idart"]; ?>" value="<?php echo $prod["qteart"]; ?>" size="1" readonly />
                            </div>
                            <div class="col-sm-2">
                                <input type="text" name="dosageprd" id="<?php echo $prod["dosageart"]; ?>" value="<?php echo $prod["dosageart"]; ?>" />
                            </div>
                            <div class="col-sm-1">
                                <input type="text" name="intervalleprd" id="<?php echo $prod["intervalleart"]; ?>" value="<?php echo $prod["intervalleart"]; ?>" />
                            </div>
                            <div class="col-sm-1">
                                <input type="text" name="periodeprd" id="<?php echo $prod["periodeart"]; ?>" min="1" value="<?php echo $prod["periodeart"]; ?>" />
                            </div>
                            <div class="col-sm-4">
                                <input type="date" name="dateprd" id="<?php echo $prod["dateart"]; ?>" value="<?php echo $prod["dateart"]; ?>" size="1" />
                            </div>
                            <div class="col-sm-2">
                                <input type="time" name="heureprd" id="<?php echo $prod["heureart"]; ?>" value="<?php echo $prod["heureart"]; ?>" size="1" />
                            </div>
                            <div class="col-sm-1">
                                <div class="input-group-btn">
                                    <button type="submit" name="envoiproduit" value="modifier" title="Modifier cette quantit&eacute;" class="btn-xs btn-primary" ><i class="glyphicon glyphicon-edit"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-sm-4">
                <?php echo $prod["designationart"] ?> &nbsp;&nbsp; 
                <?php echo $prod["prixart"] ?> 
                <!--F CFA-->

            </div>
            <div class="col-sm-1 pull-left">
                <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitalconsultation/hopitalajouter/panier_menu_hospitalisation') ?>&actionpm=remove&idp=<?php echo $prod["idart"]; ?>&idconsultation=<?php echo $_REQUEST["idconsultation"]; ?>" title="Supprimer ce soin du panier">
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
    if ($_SESSION["session_prodshos".$idc] != 0) {
        ?>
        <div class="row" style="text-align: center; color: red"> Total : <span id="total_price"><?php echo number_format($total_pricev, 2) . " F CFA"; ?></span> 
        </div><br>
        <!--<div class="row" style="text-align: center">-->
           
<!--            <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitalconsultation/hopitalajouter/ajout_consultation'); ?>&idconsultation=<?php echo $_REQUEST["idconsultation"]; ?>&pagecom=<?php echo ($stag + 1); ?>" title="Enregistrer et imprimer la facture" class="btn btn-primary">
                <span title="Enregistrer " alt="vois"><i class="glyphicon glyphicon-shopping-cart"></i></span>
                Enregistrer
            </a>-->
        <!--</div>-->
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