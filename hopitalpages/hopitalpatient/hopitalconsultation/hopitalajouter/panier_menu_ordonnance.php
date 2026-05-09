<?php
    $idc=$_REQUEST["idconsultation"];
    $a = 'hopitalpages/hopitalpatient/hopitalconsultation/hopitalajouter/ajout_consultation';
    $stag = 3;
    
if (!empty($_GET["actionpm"])) {
    
    switch ($_GET["actionpm"]) {
        case "remove":
            if (!empty($_SESSION["cart_prodvord".$idc])) {

                foreach ($_SESSION["cart_prodvord".$idc] as $k => $v) {
                    if (($_SESSION["cart_prodvord".$idc][$k]["idart"] == $_GET["idp"])) {
                        if (empty($_SESSION["cart_prodvord".$idc])) {
                            unset($_SESSION["cart_prodvord".$idc]);
                        } else {
                            unset($_SESSION["cart_prodvord".$idc][$k]);
                        }
                    }
                }
            }
               die('<meta http-equiv="refresh" content="0; URL=' . $url . '?page=' . base64_encode($a) . '&idconsultation=' . $idc . '&pagecom='.$stag.'">');
            break;
        case "edit":

            $total_pricev = 0;
            $productparid = $con->query("select * from hp_produit as a left join hp_categorie as c on "
                    . "a.idcategorie=c.idcategorie where a.idproduit='" . $_GET["idp"] . "'");
            $rowp = mysqli_fetch_assoc($productparid);
            foreach ($_SESSION["cart_prodvord".$idc] as $k => $v) {
                if (($_SESSION["cart_prodvord".$idc][$k]["idart"] == $_GET["idp"])) {
                    $_SESSION["cart_prodvord".$idc][$k]["qteart"] = $_POST["qteprd"];
                    $_SESSION["cart_prodvord".$idc][$k]["prixart"] = $rowp["prixventeproduit"];
                    $rsltuar = $con->query("select * from hp_unite where idunite='" . $_POST["uniteprd"] . "'") or die(mysqli_error($con));
                    $rowar = mysqli_fetch_assoc($rsltuar);
                    $rsltuarp = $con->query("select * from hp_conversion where idunite='" . $_POST["uniteprd"] . "' and "
                            . "idproduit='" . $_GET["idp"] . "'") or die(mysqli_error($con));
                    $rowarp = mysqli_fetch_assoc($rsltuarp);
//                    echo"<script language='javascript'>alert($pv)</script>";
                    if ($rowarp != NULL) {
                        $_SESSION["cart_prodvord".$idc][$k]["prixart"] = $rowarp["prixconversion"];
                    } else {
                        $_SESSION["cart_prodvord".$idc][$k]["prixart"] = $rowp["prixventeproduit"];
                    }
                    $idunit = $rowar["idunite"];
                    $uniteart = $rowar["libelleunite"];
                    $_SESSION["cart_prodvord".$idc][$k]["idunit"] = $idunit;
                    $_SESSION["cart_prodvord".$idc][$k]["uniteart"] = $uniteart;
                }
                $total_pricev += $_SESSION["cart_prodvord".$idc][$k]["prixart"] * $_SESSION["cart_prodvord".$idc][$k]["qteart"];
            }
               die('<meta http-equiv="refresh" content="0; URL=' . $url . '?page=' . base64_encode($a) . '&idconsultation=' . $idc . '&pagecom='.$stag.'">');
            break;
        case "empty":
            unset($_SESSION["cart_prodvord".$idc]);
               die('<meta http-equiv="refresh" content="0; URL=' . $url . '?page=' . base64_encode($a) . '&idconsultation=' . $idc . '&pagecom='.$stag.'">');
            break;
    }
}
?>

<?php
$total_pricev = 0.00;
if (isset($_SESSION["cart_prodvord".$idc])) {
    ?>	
    <?php
    foreach ($_SESSION["cart_prodvord".$idc] as $prod) {
        $productparid = $con->query("select * from hp_produit as a left join hp_categorie as c on "
                . "a.idcategorie=c.idcategorie where a.idproduit='" . $prod["idart"] . "'");
        $product_info = mysqli_fetch_assoc($productparid);
        $total_pricev += $prod["prixart"] * $prod["qteart"];

        $productparidu = $con->query("select * from hp_conversion as c left join hp_unite "
                . "as u on c.idunite=u.idunite where c.idproduit='" . $prod["idart"] . "'");
        $productparidua = $con->query("select * from hp_unite where "
                . "idunite='" . $product_info["uniteventeproduit"] . "'");
        $rowua = mysqli_fetch_assoc($productparidua);
        ?>
        <div class="row">
            <div class="col-sm-5" style="text-align: center;">
                <form method="post" name="frmCartEdit" id="frmCartEdit" action="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitalconsultation/hopitalajouter/panier_menu_ordonnance') ?>&actionpm=edit&idp=<?php echo $prod["idart"]; ?>&idconsultation=<?php echo $_REQUEST["idconsultation"]; ?>" >
                    <div class="input-group">
                        <div class="row">
                            <div class="col-sm-3">
                                <input type="text" name="qteprd" id="<?php echo $prod["idart"]; ?>" value="<?php echo $prod["qteart"]; ?>" size="1" />
                            </div>
                            <div class="col-sm-6">
                                <select name="uniteprd" id="<?php echo $prod["idart"]; ?>" class="text-input">
                                    <!--<option value="<?php echo($rowua["idunite"]); ?>" <?php if ($prod["idunit"] == $rowua["idunite"]) { ?>selected<?php } ?> ><?php echo($rowua["libelleunite"]); ?></option>-->
                                    <?php
                                    /* Construction de la première liste : on se sert du tableau PHP */
                                    while ($rowuv = mysqli_fetch_assoc($productparidu)) {
                                        ?>
                                        <option value="<?php echo($rowuv["idunite"]); ?>" <?php if ($prod["idunit"] == $rowuv["idunite"]) { ?>selected<?php } ?>><?php echo($rowuv["libelleunite"]); ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-sm-3">
                                <div class="input-group-btn">
                                    <button type="submit" name="envoiproduit" value="modifier" title="Modifier cette quantit&eacute;" class="btn-xs btn-primary" ><i class="glyphicon glyphicon-edit"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-sm-6">
                <?php echo $prod["designationart"] ?> &nbsp;&nbsp; 
                <?php // echo $prod["qteart"]*$prod["prixart"] ?> 
                <!--F CFA-->

            </div>
            <div class="col-sm-1 pull-left">
                <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitalconsultation/hopitalajouter/panier_menu_ordonnance') ?>&actionpm=remove&idp=<?php echo $prod["idart"]; ?>&idconsultation=<?php echo $_REQUEST["idconsultation"]; ?>" title="Supprimer ce produit du panier">
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
    if ($_SESSION["session_prodsord".$idc] != 0) {
        ?>
        <div class="row" style="text-align: center; color: red"> Total : <span id="total_price"><?php echo number_format($total_pricev, 2) . " F CFA"; ?></span> 
        </div><br>
<!--        <div class="row" style="text-align: center">
            <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitalconsultation/hopitalajouter/ajout_consultation'); ?>&idconsultation=<?php echo $_REQUEST["idconsultation"]; ?>&pagecom=<?php echo ($stag + 1); ?>" title="Enregistrer et imprimer la facture" class="btn btn-primary">
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