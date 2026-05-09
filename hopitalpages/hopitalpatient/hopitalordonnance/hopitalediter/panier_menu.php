<?php
$idc = $_REQUEST["idordonnance"];
$a = 'hopitalpages/hopitalpatient/hopitalordonnance/hopitalediter/edit_ordonnance';
$stag = 1;

if (!empty($_GET["actionpm"])) {

    switch ($_GET["actionpm"]) {
        case "remove":
            if (!empty($_SESSION["cart_prodvordoe" . $idc])) {

                foreach ($_SESSION["cart_prodvordoe" . $idc] as $k => $v) {
                    if (($_SESSION["cart_prodvordoe" . $idc][$k]["idart"] == $_GET["idp"])) {
                        if (empty($_SESSION["cart_prodvordoe" . $idc])) {
                            unset($_SESSION["cart_prodvordoe" . $idc]);
                        } else {
                            unset($_SESSION["cart_prodvordoe" . $idc][$k]);
                        }
                    }
                }
            }
            die('<meta http-equiv="refresh" content="0; URL=' . $url . '?page=' . base64_encode($a) . '&idordonnance=' . $idc . '&pagecom=' . $stag . '">');
            break;
        case "edit":

            $total_pricev = 0;
            $qt = $_POST["qteprd"];
            $productparid = $con->query("select * from hp_produit as a where a.idproduit='" . $_GET["idp"] . "'");
            $rowp = mysqli_fetch_assoc($productparid);
            foreach ($_SESSION["cart_prodvordoe" . $idc] as $k => $v) {
                $rsltuv2 = $con->query("select * from hp_conversion where idunite='" . $_POST["uniteprd"] . "' and "
                        . "idproduit='" . $_GET["idp"] . "'") or die(mysqli_error($con));
                $rowvv = mysqli_fetch_assoc($rsltuv2);
                $pr = ($rowvv["prixconversion"]);
                if (($_SESSION["cart_prodvordoe" . $idc][$k]["idart"] == $_GET["idp"])) {
                    $rsltuserb = $con->query("select SUM(mb.stockboutique) as stock from hp_boutique as mb where "
                            . "mb.idproduit='" . $_GET["idp"] . "' group by mb.idproduit") or die(mysqli_error($con));
                    $nbb = mysqli_num_rows($rsltuserb);
                    $qtes = 0;
                    if ($nbb != 0) {
                        $recuserb = mysqli_fetch_assoc($rsltuserb);
                        $qtes = $qtes + (($recuserb["stock"]));
                    }
                    if ($qt > $qtes) {
                        $qtes = $qtes + (($rowvv["stockconversion"]));
                    }
                    if ($qt > $qtes) {
                        $qt = $qtes;
                    }
                    $_SESSION["cart_prodvordoe" . $idc][$k]["qteart"] = $qt;
                    $_SESSION["cart_prodvordoe" . $idc][$k]["prixart"] = $pr;
                    $_SESSION["cart_prodvordoe" . $idc][$k]["uniteart"] = $_POST["uniteprd"];
                }
                $total_pricev += $_SESSION["cart_prodvordoe" . $idc][$k]["prixart"] * $_SESSION["cart_prodvordoe" . $idc][$k]["qteart"];
            }
            die('<meta http-equiv="refresh" content="0; URL=' . $url . '?page=' . base64_encode($a) . '&idordonnance=' . $idc . '&pagecom=' . $stag . '">');
            break;
        case "empty":
            unset($_SESSION["cart_prodvordoe" . $idc]);
            die('<meta http-equiv="refresh" content="0; URL=' . $url . '?page=' . base64_encode($a) . '&idordonnance=' . $idc . '&pagecom=' . $stag . '">');
            break;
    }
}
?>

<?php
$total_pricev = 0.00;
if (isset($_SESSION["cart_prodvordoe" . $idc])) {
    ?>	
    <?php
    foreach ($_SESSION["cart_prodvordoe" . $idc] as $prod) {
        $productparid = $con->query("select * from hp_produit as a where a.idproduit='" . $prod["idart"] . "'");
        $product_info = mysqli_fetch_assoc($productparid);
        $total_pricev += $prod["prixart"] * $prod["qteart"];

        $productparidu = $con->query("select * from hp_conversion as c left join hp_unite "
                . "as u on c.idunite=u.idunite where c.idproduit='" . $prod["idart"] . "'");
        $productparidua = $con->query("select * from hp_unite where "
                . "idunite='" . $product_info["uniteventeproduit"] . "'");
        $rowua = mysqli_fetch_assoc($productparidua);
        $productpariduas = $con->query("select * from hp_ordonnance as sp left join hp_ordonnance as s on sp.idordonnance=s.idordonnance "
                . "where sp.idordonnance='" . $idc . "'");
        $rowuas = mysqli_fetch_assoc($productpariduas);
        ?>
        <div class="row">
            <div class="col-sm-6" style="text-align: center;">
                <form method="post" name="frmCartEdit" id="frmCartEdit" action="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitalordonnance/hopitalediter/panier_menu') ?>&actionpm=edit&idp=<?php echo $prod["idart"]; ?>&idordonnance=<?php echo $_REQUEST["idordonnance"]; ?>" >
                    <div class="input-group">
                        <div class="row">
                            <div class="col-sm-2">
                                <input type="text" name="qteprd" id="<?php echo $prod["idart"]; ?>" value="<?php echo $prod["qteart"]; ?>" size="1" />
                            </div>
                            <div class="col-sm-6">
                                <!--<input type="text" name="uniteprd" id="<?php echo $prod["uniteart"]; ?>" value="<?php echo $prod["uniteart"]; ?>" size="1" />-->
                                <select name="uniteprd" id="<?php echo $prod["idart"]; ?>" class="text-input">
                                        <!--<option value="<?php echo($rowua["idunite"]); ?>" <?php if ($prod["idunit"] == $rowua["idunite"]) { ?>selected<?php } ?> ><?php echo($rowua["libelleunite"]); ?></option>-->
                                    <?php
                                    /* Construction de la première liste : on se sert du tableau PHP */
                                    while ($rowuv = mysqli_fetch_assoc($productparidu)) {
                                        ?>
                                        <option value="<?php echo($rowuv["idunite"]); ?>" <?php if ($prod["uniteart"] == $rowuv["idunite"]) { ?>selected<?php } ?>><?php echo($rowuv["libelleunite"]); ?></option>
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
            <div class="col-sm-5">
                <?php echo $prod["designationart"] ?> &nbsp;&nbsp; 
                <?php echo $prod["prixart"] ?> 
                <!--F CFA-->

            </div>
            <div class="col-sm-1 pull-left">
                <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitalordonnance/hopitalediter/panier_menu') ?>&actionpm=remove&idp=<?php echo $prod["idart"]; ?>&idordonnance=<?php echo $_REQUEST["idordonnance"]; ?>" title="Supprimer ce ordonnance du panier">
                    <i class="glyphicon glyphicon-trash"></i>
                </a>
            </div>
        </div>
        <hr>
        <?php
    }
    ?>
    <hr>
    <?php
    $poi = (int) ($total_pricev / 6500);
    $_SESSION["point_fidelite"] = $poi;
    $reductio = ((int) ($poi / 5)) * 650;
    ?>
    <?php
    if ($_SESSION["session_prodsordoe" . $idc] != 0) {
        ?>
        <div class="row" style="text-align: center; color: red"> Total : <span id="total_price"><?php echo number_format($total_pricev, 2) . " F CFA"; ?></span> 
        </div><br>
        <form id="pointhp_form" action="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitalordonnance/hopitalediter/traite_ordonnance') ?>&idordonnance=<?php echo $_REQUEST["idordonnance"]; ?>&prixt=<?php echo $total_pricev; ?>" method="post">
            <!--                <div class="row ">
                                <div class="col-sm-12">
                                    <div class="form-group" style="margin-left:15px;">
                                        <label>Date</label> <br>
                                        <input class="form-control" placeholder="" type="date" name="datef" id="datef" required />
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group" style="margin-left:15px;">
                                        <label>Heure </label> <br>
                                        <input class="form-control" placeholder="" type="time" name="heuref" id="heuref" required />
                                    </div>
                                </div>
                            </div>-->
            <div class="row" style="text-align: center">
                <button type="submit" title="Enregistrer les modifications de cet ordonnance" class="btn btn-success">
                    <span title="Enregistrer les modifications de cet ordonnance" alt="vois"></span>
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