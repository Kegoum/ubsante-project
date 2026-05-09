<?php
if (!empty($_GET["actionpm"])) {
    $a = 'hotelpages/fourniturehotel/hotelarticleavarie/hotelajouter/ajouter_article_avarie';
   
    switch ($_GET["actionpm"]) {
        case "remove":
            if (!empty($_SESSION["cart_prodvaae"])) {

                foreach ($_SESSION["cart_prodvaae"] as $k => $v) {
                    if (($_SESSION["cart_prodvaae"][$k]["idart"] == $_GET["idp"])) {
                        if (empty($_SESSION["cart_prodvaae"])) {
                            unset($_SESSION["cart_prodvaae"]);
                        } else {
                            unset($_SESSION["cart_prodvaae"][$k]);
                        }
                    }
                }
            }
            if (isset($_SESSION["login_proprietaire"])) {
                die('<meta http-equiv="refresh" content="0; URL=indexadmin.php?page=' . base64_encode($a) . '">');
            } else if (($_SESSION["code_service"] == "DG")) {
                    die('<meta http-equiv="refresh" content="0; URL=indexdg.php?page=' . base64_encode($a) . '">');
                } else {
                die('<meta http-equiv="refresh" content="0; URL=indexpersonnel.php?page=' . base64_encode($a) . '">');
            }
            break;
        case "edit":

            $total_pricev = 0;
            $productparid = $con->query("select * from hotel_article_point_hotel as aph left join hotel_article as a on "
                    . "aph.id_article=a.id_article left join hotel_categorie as c on a.id_categorie=c.id_categorie left "
                    . "join hotel_fourniture as f on a.id_fourniture=f.id_fourniture where "
                    . "aph.id_article_point_hotel='" . $_GET["idp"] . "'");
            $rowp = mysqli_fetch_assoc($productparid);

            foreach ($_SESSION["cart_prodvaae"] as $k => $v) {
                if (($_SESSION["cart_prodvaae"][$k]["idart"] == $_GET["idp"])) {
                    $q = $_POST["qteprd"];
                    if ($rowp["stock_article"] >= $q) {
                        $_SESSION["cart_prodvaae"][$k]["qteart"] = $q;
                    } else {

                        $rsltuarpa = $con->query("select * from hotel_convertion where id_unite='" . $rowp["unite_sortie_article"] . "' "
                                . "and id_article_point_hotel='" . $rowp["id_article_point_hotel"] . "'") or die(mysqli_error($con));
                        $nbarpa = mysqli_num_rows($rsltuarpa);

                        $rowarpa = mysqli_fetch_assoc($rsltuarpa);
                        if ($nbarpa != 0) {
                            if ($q > $rowarpa["stock_convertion"]) {
                                $pro = $rowarpa["stock_convertion"];
                                $_SESSION["cart_prodvaae"][$k]["qteart"] = $pro;
                                echo "<script language='javascript'>alert('Desole articles insuffisants en stock')</script>";
                            } else {
                                $_SESSION["cart_prodvaae"][$k]["qteart"] = $q;
                            }
                        } else {
                            $pro = $rowp["stock_article"];
                            $_SESSION["cart_prodvaae"][$k]["qteart"] = $pro;
                            echo "<script language='javascript'>alert('Desole articles insuffisants en stock')</script>";
                        }
                    }
                
                }
                $total_pricev += $_SESSION["cart_prodvaae"][$k]["prixarts"] * $_SESSION["cart_prodvaae"][$k]["qteart"];
            }
            if (isset($_SESSION["login_proprietaire"])) {
                die('<meta http-equiv="refresh" content="0; URL=indexadmin.php?page=' . base64_encode($a) . '">');
            } else if (($_SESSION["code_service"] == "DG")) {
                    die('<meta http-equiv="refresh" content="0; URL=indexdg.php?page=' . base64_encode($a) . '">');
                } else {
                die('<meta http-equiv="refresh" content="0; URL=indexpersonnel.php?page=' . base64_encode($a) . '">');
            }
            break;
        case "empty":
            unset($_SESSION["cart_prodvaae"]);
            if (isset($_SESSION["login_proprietaire"])) {
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
if (isset($_SESSION["cart_prodvaae"])) {
    ?>	
    <?php
    foreach ($_SESSION["cart_prodvaae"] as $prod) {
        $productparid = $con->query("select * from hotel_article_point_hotel as aph left join hotel_article as a on "
                . "aph.id_article=a.id_article left join hotel_categorie as c on a.id_categorie=c.id_categorie left "
                . "join hotel_fourniture as f on a.id_fourniture=f.id_fourniture where "
                . "aph.id_article_point_hotel='" . $prod["idart"] . "'");
        $product_info = mysqli_fetch_assoc($productparid);
        $total_pricev += $prod["prixarts"] * $prod["qteart"];
        ?>
        <div class="row">
            <div class="col-sm-3" style="text-align: center;">
                <?php
                if (isset($_SESSION["login_proprietaire"])) {
                    ?>
                    <form method="post" name="frmCartEdit" id="frmCartEdit" action="indexadmin.php?page=<?php echo base64_encode('hotelpages/fourniturehotel/hotelarticleavarie/hotelajouter/panier_menu') ?>&actionpm=edit&idp=<?php echo $prod["idart"]; ?>" >
                        <div class="input-group">
                            <div class="row">
                                <div class="col-sm-3">
                                    <input type="text" name="qteprd" id="<?php echo $prod["idart"]; ?>" value="<?php echo $prod["qteart"]; ?>" size="1" />
                                </div>
                                <div class="col-sm-6">
                                    <?php
                                    $rsltua = $con->query("select * from hotel_unite where id_unite='" . $prod["unitearts"] . "'") or die(mysqli_error($con));
                                    $rowa = mysqli_fetch_assoc($rsltua);
                                    print nl2br(htmlspecialchars($rowa["code_unite"]));
                                    ?> 
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
                    <form method="post" name="frmCartEdit" id="frmCartEdit" action="indexdg.php?page=<?php echo base64_encode('hotelpages/fourniturehotel/hotelarticleavarie/hotelajouter/panier_menu') ?>&actionpm=edit&idp=<?php echo $prod["idart"]; ?>" >
                        <div class="input-group">
                            <div class="row">
                                <div class="col-sm-3">
                                    <input type="text" name="qteprd" id="<?php echo $prod["idart"]; ?>" value="<?php echo $prod["qteart"]; ?>" size="1" />
                                </div>
                                <div class="col-sm-6">
                                    <?php
                                    $rsltua = $con->query("select * from hotel_unite where id_unite='" . $prod["unitearts"] . "'") or die(mysqli_error($con));
                                    $rowa = mysqli_fetch_assoc($rsltua);
                                    print nl2br(htmlspecialchars($rowa["code_unite"]));
                                    ?> 
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
                    <form method="post" name="frmCartEdit" id="frmCartEdit" action="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/fourniturehotel/hotelarticleavarie/hotelajouter/panier_menu') ?>&actionpm=edit&idp=<?php echo $prod["idart"]; ?>" >
                        <div class="input-group">
                            <div class="row">
                                <div class="col-sm-3">
                                    <input type="text" name="qteprd" id="<?php echo $prod["idart"]; ?>" value="<?php echo $prod["qteart"]; ?>" size="1" />
                                </div>
                                <div class="col-sm-6">
                                    <?php
                                    $rsltua = $con->query("select * from hotel_unite where id_unite='" . $prod["unitearts"] . "'") or die(mysqli_error($con));
                                    $rowa = mysqli_fetch_assoc($rsltua);
                                    print nl2br(htmlspecialchars($rowa["code_unite"]));
                                    ?> 
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
            <div class="col-sm-7">

                <?php echo $prod["designationart"] ?> &nbsp;&nbsp;
                <?php echo $prod["prixarts"]; ?> F CFA
            </div>
            <div class="col-sm-1 pull-left">
                <?php
                if (isset($_SESSION["login_proprietaire"])) {
                    ?>
                    <a href="indexadmin.php?page=<?php echo base64_encode('hotelpages/fourniturehotel/hotelarticleavarie/hotelajouter/panier_menu') ?>&actionpm=remove&idp=<?php echo $prod["idart"]; ?>" title="Supprimer ce produit du panier">
                        <i class="glyphicon glyphicon-trash"></i>
                    </a>
                    <?php
                } else if (($_SESSION["code_service"] == "DG")) {
                    ?>
                    <a href="indexdg.php?page=<?php echo base64_encode('hotelpages/fourniturehotel/hotelarticleavarie/hotelajouter/panier_menu') ?>&actionpm=remove&idp=<?php echo $prod["idart"]; ?>" title="Supprimer ce produit du panier">
                        <i class="glyphicon glyphicon-trash"></i>
                    </a>
                    <?php
                } else {
                    ?>
                    <a href="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/fourniturehotel/hotelarticleavarie/hotelajouter/panier_menu') ?>&actionpm=remove&idp=<?php echo $prod["idart"]; ?>" title="Supprimer ce produit du panier">
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
    if (isset($_SESSION["login_proprietaire"])) {
        if ($_SESSION["session_prodsvaae"] != 0) {
            ?>
            <div class="row" style="text-align: center">
                <a href="indexadmin.php?page=<?php echo base64_encode('hotelpages/fourniturehotel/hotelarticleavarie/hotelajouter/traite_article_avarie') ?>" title="Envoyer dans les articles avaries" class="btn btn-success">
                    <span title="Envoyer dans les articles avaries" alt="vois"></span>
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
    } else if (($_SESSION["code_service"] == "DG")) {
        if ($_SESSION["session_prodsvaae"] != 0) {
            ?>
            <div class="row" style="text-align: center">
                <a href="indexdg.php?page=<?php echo base64_encode('hotelpages/fourniturehotel/hotelarticleavarie/hotelajouter/traite_article_avarie') ?>" title="Envoyer dans les articles avaries" class="btn btn-success">
                    <span title="Envoyer dans les articles avaries" alt="vois"></span>
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
        if ($_SESSION["session_prodsvaae"] != 0) {
            ?>
            <div class="row" style="text-align: center">
                <a href="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/fourniturehotel/hotelarticleavarie/hotelajouter/traite_article_avarie') ?>" title="Envoyer dans les articles avaries" class="btn btn-success">
                    <span title="Envoyer dans les articles avaries" alt="vois"></span>
                    Envoyer
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
    if (isset($_SESSION["login_proprietaire"])) {
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