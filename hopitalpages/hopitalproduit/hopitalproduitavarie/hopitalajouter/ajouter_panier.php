
<div class="row">
    <?php
//    echo"<script language='javascript'>alert('ok')</script>";
    if (!empty($_GET["actionp"])) {
        $a = 'hotelpages/fourniturehotel/hotelarticleavarie/hotelajouter/ajouter_article_avarie';

        switch ($_GET["actionp"]) {
            case "add":
                $productparid = $con->query("select * from hotel_article_point_hotel as aph left join hotel_article as a on "
                        . "aph.id_article=a.id_article left join hotel_categorie as c on a.id_categorie=c.id_categorie left "
                        . "join hotel_fourniture as f on a.id_fourniture=f.id_fourniture where "
                        . "aph.id_article_point_hotel='" . $_GET["idp"] . "'");
                $rowp = mysqli_fetch_assoc($productparid);
                $qt = 1;

                $prixs = $rowp["prix_achat_article"];
//                    echo"<script language='javascript'>alert($pv)</script>";
                if ($rowp["unite_sortie_article"] != $rowp["unite_achat_article"]) {
                    $rsltuarpa = $con->query("select * from hotel_convertion where id_unite='" . $rowp["unite_sortie_article"] . "' "
                            . "and id_article_point_hotel='" . $rowp["id_article_point_hotel"] . "'") or die(mysqli_error($con));
                    $nbarpa = mysqli_num_rows($rsltuarpa);
                    if ($nbarpa != 0) {
                        $rowarpa = mysqli_fetch_assoc($rsltuarpa);
                        if ($rowarpa["convertion"]!=0){
                        $prixs = $rowp["prix_achat_article"]/$rowarpa["convertion"];
                        }
                    }
                }
                $prodArray = array($rowp["id_article_point_hotel"] => array(
                        'idart' => $rowp["id_article_point_hotel"],
                        'designationart' => $rowp["libelle_article"],
                        'qteart' => $qt,
                        'prixarta' => $rowp["prix_achat_article"],
                        'prixarts' => $prixs,
                        'unitearta' => $rowp["unite_achat_article"],
                        'uniteartv' => $rowp["unite_vente_article"],
                        'unitearts' => $rowp["unite_sortie_article"]
                ));
                $ider = $rowp["id_article_point_hotel"];

                if (!empty($_SESSION["cart_prodvaae"])) {
                    $f = FALSE;
                    foreach ($_SESSION["cart_prodvaae"] as $k => $v) {
                        if (($_SESSION["cart_prodvaae"][$k]["idart"] == $_GET["idp"])) {
                            $f = TRUE;
                            $q = $_SESSION["cart_prodvaae"][$k]["qteart"] + $qt;

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

                                        echo "<script language='javascript'>alert('Desole article insuffisant en stock !')</script>";
                                    } else {
                                        $_SESSION["cart_prodvaae"][$k]["qteart"] = $q;
                                    }
                                } else {
                                    $pro = $rowp["stock_article"];
                                    $_SESSION["cart_prodvaae"][$k]["qteart"] = $pro;

                                    echo "<script language='javascript'>alert('Desole article insuffisant en stock !')</script>";
                                }
                            }
                        }
                    }
                    if (!$f) {
                        if ($rowp["stock_article"] >= $qt) {
                            $_SESSION["cart_prodvaae"] = array_merge($_SESSION["cart_prodvaae"], $prodArray);
                        } else {

                            $rsltuarpa = $con->query("select * from hotel_convertion where id_unite='" . $rowp["unite_sortie_article"] . "' "
                                    . "and id_article_point_hotel='" . $rowp["id_article_point_hotel"] . "'") or die(mysqli_error($con));
                            $nbarpa = mysqli_num_rows($rsltuarpa);

                            $rowarpa = mysqli_fetch_assoc($rsltuarpa);
                            if ($nbarpa != 0) {
                                if ($qt > $rowarpa["stock_convertion"]) {
                                    $prodArray = array($rowp["id_article_point_hotel"] => array(
                                            'idart' => $rowp["id_article_point_hotel"],
                                            'designationart' => $rowp["libelle_article"],
                                            'qteart' => $rowarpa["stock_convertion"],
                                            'prixarta' => $rowp["prix_achat_article"],
                                            'prixarts' => $prixs,
                                            'unitearta' => $rowp["unite_achat_article"],
                                            'uniteartv' => $rowp["unite_vente_article"],
                                            'unitearts' => $rowp["unite_sortie_article"]
                                    ));
                                    $_SESSION["cart_prodvaae"] = array_merge($_SESSION["cart_prodvaae"], $prodArray);
                                    echo "<script language='javascript'>alert('Desole article insuffisant en stock !')</script>";
                                } else {
                                    $_SESSION["cart_prodvaae"] = array_merge($_SESSION["cart_prodvaae"], $prodArray);
                                }
                            } else {
                                $prodArray = array($rowp["id_article_point_hotel"] => array(
                                        'idart' => $rowp["id_article_point_hotel"],
                                        'designationart' => $rowp["libelle_article"],
                                        'qteart' => $rowp["stock_article"],
                                        'prixarta' => $rowp["prix_achat_article"],
                                        'prixarts' => $prixs,
                                        'unitearta' => $rowp["unite_achat_article"],
                                        'uniteartv' => $rowp["unite_vente_article"],
                                        'unitearts' => $rowp["unite_sortie_article"],
                                ));
                                $_SESSION["cart_prodvaae"] = array_merge($_SESSION["cart_prodvaae"], $prodArray);
                                echo "<script language='javascript'>alert('Desole article insuffisant en stock !')</script>";
                            }
                        }
                    }
                } else {
                    if ($rowp["stock_article"] >= $qt) {
                        $_SESSION["cart_prodvaae"] = $prodArray;
                    } else {

                        $rsltuarpa = $con->query("select * from hotel_convertion where id_unite='" . $rowp["unite_sortie_article"] . "' "
                                . "and id_article_point_hotel='" . $rowp["id_article_point_hotel"] . "'") or die(mysqli_error($con));
                        $nbarpa = mysqli_num_rows($rsltuarpa);

                        $rowarpa = mysqli_fetch_assoc($rsltuarpa);
                        if ($nbarpa != 0) {
                            if ($qt > $rowarpa["stock_convertion"]) {
                                $prodArray = array($rowp["id_article_point_hotel"] => array(
                                        'idart' => $rowp["id_article_point_hotel"],
                                        'designationart' => $rowp["libelle_article"],
                                        'qteart' => $rowarpa["stock_convertion"],
                                        'prixarta' => $rowp["prix_achat_article"],
                                        'prixarts' => $prixs,
                                        'unitearta' => $rowp["unite_achat_article"],
                                        'uniteartv' => $rowp["unite_vente_article"],
                                        'unitearts' => $rowp["unite_sortie_article"]
                                ));
                                $_SESSION["cart_prodvaae"] = $prodArray;
                                echo "<script language='javascript'>alert('Desole article insuffisant en stock !')</script>";
                            } else {
                                $_SESSION["cart_prodvaae"] = $prodArray;
                            }
                        } else {
                            $prodArray = array($rowp["id_article_point_hotel"] => array(
                                    'idart' => $rowp["id_article_point_hotel"],
                                    'designationart' => $rowp["libelle_article"],
                                    'qteart' => $rowp["stock_article"],
                                    'prixarta' => $rowp["prix_achat_article"],
                                    'prixarts' => $prixs,
                                    'unitearta' => $rowp["unite_achat_article"],
                                    'uniteartv' => $rowp["unite_vente_article"],
                                    'unitearts' => $rowp["unite_sortie_article"]
                            ));
                            $_SESSION["cart_prodvaae"] = $prodArray;
                            echo "<script language='javascript'>alert('Desole article insuffisant en stock !')</script>";
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
        }
    }
    ?>
</div>