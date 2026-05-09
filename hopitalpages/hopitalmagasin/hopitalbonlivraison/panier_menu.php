<script language="JavaScript">
    jQuery(document).ready(function() {
        // binds form submission and fields to the validation engine
        jQuery("#pointhotel_form").validationEngine('attach');
    });
    /**
     *
     * @param {jqObject} the field where the validation applies
     * @param {Array[String]} validation rules for this field
     * @param {int} rule index
     * @param {Map} form options
     * @return an error string if validation failed
     */
    function checkHELLO(field, rules, i, options) {
        if (field.val() != "HELLO") {
            // this allows to use i18 for the error msgs
            return options.allrules.validate2fields.alertText;
        }
    }

</script>

<?php
if (!empty($_GET["actionpm"])) {
    $a = 'hotelpages/economathotel/bonlivraisonhotel/livraison';
    switch ($_GET["actionpm"]) {
        case "remove":
            if (!empty($_SESSION["cart_prodvlex"])) {

                foreach ($_SESSION["cart_prodvlex"] as $k => $v) {
                    if (($_SESSION["cart_prodvlex"][$k]["idart"] == $_GET["idp"])) {
                        if (empty($_SESSION["cart_prodvlex"])) {
                            unset($_SESSION["cart_prodvlex"]);
                        } else {
                            unset($_SESSION["cart_prodvlex"][$k]);
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
            $productparid = $con->query("select * from hotel_article_point_hotel as aph left join hotel_article "
                        . "as a on aph.id_article=a.id_article left join hotel_categorie as c on a.id_categorie=c.id_categorie "
                        . "left join hotel_fourniture as f on a.id_fourniture=f.id_fourniture where "
                        . "aph.id_article_point_hotel='" . $_GET["idp"] . "'");
            $rowp = mysqli_fetch_assoc($productparid);

            foreach ($_SESSION["cart_prodvlex"] as $k => $v) {
                if (($_SESSION["cart_prodvlex"][$k]["idart"] == $_GET["idp"])) {
                    $q = $_POST["qteprd"];
                    $_SESSION["cart_prodvlex"][$k]["qteart"] = $_POST["qteprd"];
                    $_SESSION["cart_prodvlex"][$k]["prixarta"] = $_POST["prixprd"];
                }
                $total_pricev += $_SESSION["cart_prodvlex"][$k]["prixarta"] * $_SESSION["cart_prodvlex"][$k]["qteart"];
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
            unset($_SESSION["cart_prodvlex"]);
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
if (isset($_SESSION["cart_prodvlex"])) {
    ?>	
    <?php
    foreach ($_SESSION["cart_prodvlex"] as $prod) {
        $productparid = $con->query("select * from hotel_article_point_hotel as aph left join hotel_article "
                        . "as a on aph.id_article=a.id_article left join hotel_categorie as c on a.id_categorie=c.id_categorie "
                        . "left join hotel_fourniture as f on a.id_fourniture=f.id_fourniture where "
                        . "aph.id_article_point_hotel='" . $prod["idart"] . "'");
        $product_info = mysqli_fetch_assoc($productparid);
        $total_pricev += $prod["prixarta"] * $prod["qteart"];
        ?>
        <div class="row">
            <div class="col-sm-5" style="text-align: center;">
                <?php
                if (isset($_SESSION["loginproprietaire"])) {
                    ?>
                    <form method="post" name="frmCartEdit" id="frmCartEdit" action="indexadmin.php?page=<?php echo base64_encode('hotelpages/economathotel/bonlivraisonhotel/panier_menu') ?>&actionpm=edit&idp=<?php echo $prod["idart"]; ?>" >
                        <div class="input-group">
                            <div class="row">
                                <div class="col-sm-3">
                                    <input type="text" name="qteprd" id="<?php echo $prod["idart"]; ?>" value="<?php echo $prod["qteart"]; ?>" size="1" />
                                </div>
                                <div class="col-sm-6">
                                    <input type="text" name="prixprd" id="<?php echo $prod["idart"]; ?>" value="<?php echo $prod["prixarta"]; ?>" size="4" />
                                </div>
                                <div class="col-sm-3">
                                    <div class="input-group-btn">
                                        <button type="submit" name="envoiarticle" value="modifier" title="Modifier cette quantit&eacute;" class="btn btn-xs btn-success" ><i class="glyphicon glyphicon-edit"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <?php
                } else if (($_SESSION["code_service"] == "DG")) {
                    ?>
                    <form method="post" name="frmCartEdit" id="frmCartEdit" action="indexdg.php?page=<?php echo base64_encode('hotelpages/economathotel/bonlivraisonhotel/panier_menu') ?>&actionpm=edit&idp=<?php echo $prod["idart"]; ?>" >
                        <div class="input-group">
                            <div class="row">
                                <div class="col-sm-3">
                                    <input type="text" name="qteprd" id="<?php echo $prod["idart"]; ?>" value="<?php echo $prod["qteart"]; ?>" size="1" />
                                </div>
                                <div class="col-sm-6">
                                    <input type="text" name="prixprd" id="<?php echo $prod["idart"]; ?>" value="<?php echo $prod["prixarta"]; ?>" size="4" />
                                </div>
                                <div class="col-sm-3">
                                    <div class="input-group-btn">
                                        <button type="submit" name="envoiarticle" value="modifier" title="Modifier cette quantit&eacute;" class="btn btn-xs btn-success" ><i class="glyphicon glyphicon-edit"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <?php
                } else {
                    ?>
                    <form method="post" name="frmCartEdit" id="frmCartEdit" action="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/economathotel/bonlivraisonhotel/panier_menu') ?>&actionpm=edit&idp=<?php echo $prod["idart"]; ?>" >
                        <div class="input-group">
                            <div class="row">
                                <div class="col-sm-3">
                                    <input type="text" name="qteprd" id="<?php echo $prod["idart"]; ?>" value="<?php echo $prod["qteart"]; ?>" size="1" />
                                </div>
                                <div class="col-sm-6">
                                    <input type="text" name="prixprd" id="<?php echo $prod["idart"]; ?>" value="<?php echo $prod["prixarta"]; ?>" size="4" />
                                </div>
                                <div class="col-sm-3">
                                    <div class="input-group-btn">
                                        <button type="submit" name="envoiarticle" value="modifier" title="Modifier cette quantit&eacute;" class="btn btn-xs btn-success" ><i class="glyphicon glyphicon-edit"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <?php
                }
                ?>
            </div>
            <div class="col-sm-5">
                <?php echo $prod["designationart"] ?> &nbsp;&nbsp; 
                <?php echo $prod["prixarta"] ?> F CFA

            </div>
            <div class="col-sm-1 pull-left">
                <?php
                if (isset($_SESSION["loginproprietaire"])) {
                    ?>
                    <a href="indexadmin.php?page=<?php echo base64_encode('hotelpages/economathotel/bonlivraisonhotel/panier_menu') ?>&actionpm=remove&idp=<?php echo $prod["idart"]; ?>" title="Supprimer ce produit du panier">
                        <i class="glyphicon glyphicon-trash"></i>
                    </a>
                    <?php
                } else if (($_SESSION["code_service"] == "DG")) {
                    ?>
                    <a href="indexdg.php?page=<?php echo base64_encode('hotelpages/economathotel/bonlivraisonhotel/panier_menu') ?>&actionpm=remove&idp=<?php echo $prod["idart"]; ?>" title="Supprimer ce produit du panier">
                        <i class="glyphicon glyphicon-trash"></i>
                    </a>
                    <?php
                } else {
                    ?>
                    <a href="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/economathotel/bonlivraisonhotel/panier_menu') ?>&actionpm=remove&idp=<?php echo $prod["idart"]; ?>" title="Supprimer ce produit du panier">
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
        if ($_SESSION["session_prodsvlex"] != 0) {
            ?>
            <div class="row" style="text-align: center; color: red"> Total : <span id="total_price"><?php echo number_format($total_pricev, 2) . " F CFA"; ?></span> 
            </div><br>
            <form id="pointhotel_form" action="indexadmin.php?page=<?php echo base64_encode('hotelpages/economathotel/bonlivraisonhotel/traite_livraison') ?>&prixt=<?php echo $total_pricev; ?>" method="post">
                <div class="row ">
                    <div class="col-sm-12">
                        <div class="form-group" style="margin-left:15px;">
                            <label>Fournisseur (Laisser vide si inconnu)</label> <br>
                            <input class="form-control" placeholder="Le nom du fournisseur" type="text" name="nomf" id="nomf" />
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
    } else if (($_SESSION["code_service"] == "DG")) {
        if ($_SESSION["session_prodsvlex"] != 0) {
            ?>
            <div class="row" style="text-align: center; color: red"> Total : <span id="total_price"><?php echo number_format($total_pricev, 2) . " F CFA"; ?></span> 
            </div><br>
            <form id="pointhotel_form" action="indexdg.php?page=<?php echo base64_encode('hotelpages/economathotel/bonlivraisonhotel/traite_livraison') ?>&prixt=<?php echo $total_pricev; ?>" method="post">
                <div class="row ">
                    <div class="col-sm-12">
                        <div class="form-group" style="margin-left:15px;">
                            <label>Fournisseur (Laisser vide si inconnu)</label> <br>
                            <input class="form-control" placeholder="Le nom du fournisseur" type="text" name="nomf" id="nomf" />
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
        if ($_SESSION["session_prodsvlex"] != 0) {
            ?>
            <div class="row" style="text-align: center; color: red">
                Total : <span id="total_price"><?php echo number_format($total_pricev, 2, ',', ' ') . "F CFA"; ?></span> 
            </div><br>
            <form id="pointhotel_form" action="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/economathotel/bonlivraisonhotel/traite_livraison') ?>&prixt=<?php echo $total_pricev; ?>" method="post">
                <div class="row ">
                    <div class="col-sm-12">
                        <div class="form-group" style="margin-left:15px;">
                            <label>Fournisseur (Laisser vide si inconnu)</label> <br>
                            <input class="form-control" placeholder="Le nom du fournisseur" type="text" name="nomf" id="nomf" />
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