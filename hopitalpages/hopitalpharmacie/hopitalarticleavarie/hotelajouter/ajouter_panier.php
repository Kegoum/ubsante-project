
<div class="row">
    <?php
//    echo"<script language='javascript'>alert('ok')</script>";
    if (!empty($_GET["actionp"])) {
        $a = 'hotelpages/pharmaciehotel/hotelarticleavarie/hotelajouter/ajouter_article_avarie';
        $idb = $_REQUEST["pharmacie"];
        switch ($_GET["actionp"]) {
            case "add":
                $productparid = $con->query("select * from hotel_magasin_pharmacie as mb left join hotel_pharmacie as b on mb.id_pharmacie=b.id_pharmacie left "
                        . "join hotel_article_point_hotel as aph on mb.id_article_point_hotel=aph.id_article_point_hotel left join "
                        . "hotel_article as a on aph.id_article=a.id_article left join hotel_categorie as c on "
                        . "a.id_categorie=c.id_categorie where mb.id_magasin_pharmacie='" . $_GET["idp"] . "'");
                $rowp = mysqli_fetch_assoc($productparid);
                $qt = 1;

                $prixs = $rowp["prix_achat_article"];
//                    echo"<script language='javascript'>alert($pv)</script>";
                if ($rowp["unite_sortie_article"] != $rowp["unite_achat_article"]) {
                    $rsltuarpa = $con->query("select * from hotel_convertion where id_unite='" . $rowp["unite_sortie_article"] . "' "
                            . "and id_article_point_hotel='" . $rowp["id_article_point_hotel"] . "'") or die(mysqli_error($con));
                    $npharmaciepa = mysqli_num_rows($rsltuarpa);
                    if ($npharmaciepa != 0) {
                        $rowarpa = mysqli_fetch_assoc($rsltuarpa);
                        if ($rowarpa["convertion"] != 0) {
                            $prixs = $rowp["prix_achat_article"] / $rowarpa["convertion"];
                        }
                    }
                }
                $prodArray = array($rowp["id_magasin_pharmacie"] => array(
                        'idart' => $rowp["id_magasin_pharmacie"],
                        'designationart' => $rowp["libelle_article"],
                        'qteart' => $qt,
                        'prixarta' => $rowp["prix_achat_article"],
                        'prixarts' => $prixs,
                        'unitearta' => $rowp["unite_achat_article"],
                        'uniteartv' => $rowp["unite_vente_article"],
                        'unitearts' => $rowp["unite_sortie_article"]
                ));
                $ider = $rowp["id_magasin_pharmacie"];

                if (!empty($_SESSION["cart_prodvaaba"])) {
                    $f = FALSE;
                    foreach ($_SESSION["cart_prodvaaba"] as $k => $v) {
                        if (($_SESSION["cart_prodvaaba"][$k]["idart"] == $_GET["idp"])) {
                            $f = TRUE;
                            $q = $_SESSION["cart_prodvaaba"][$k]["qteart"] + $qt;

                            if ($rowp["stock_article_mb"] >= $q) {
                                $_SESSION["cart_prodvaaba"][$k]["qteart"] = $q;
                            } else {
                                $pro = $rowp["stock_article_mb"];
                                $_SESSION["cart_prodvaaba"][$k]["qteart"] = $pro;

                                echo "<script language='javascript'>alert('Desole article insuffisant en stock !')</script>";
                            }
                        }
                    }
                    if (!$f) {
                        if ($rowp["stock_article_mb"] >= $qt) {
                            $_SESSION["cart_prodvaaba"] = array_merge($_SESSION["cart_prodvaaba"], $prodArray);
                        } else {

                            $prodArray = array($rowp["id_magasin_pharmacie"] => array(
                                    'idart' => $rowp["id_magasin_pharmacie"],
                                    'designationart' => $rowp["libelle_article"],
                                    'qteart' => $rowp["stock_article_mb"],
                                    'prixarta' => $rowp["prix_achat_article"],
                                    'prixarts' => $prixs,
                                    'unitearta' => $rowp["unite_achat_article"],
                                    'uniteartv' => $rowp["unite_vente_article"],
                                    'unitearts' => $rowp["unite_sortie_article"],
                            ));
                            $_SESSION["cart_prodvaaba"] = array_merge($_SESSION["cart_prodvaaba"], $prodArray);
                            echo "<script language='javascript'>alert('Desole article insuffisant en stock !')</script>";
                        }
                    }
                } else {
                    if ($rowp["stock_article_mb"] >= $qt) {
                        $_SESSION["cart_prodvaaba"] = $prodArray;
                    } else {

                        $prodArray = array($rowp["id_magasin_pharmacie"] => array(
                                'idart' => $rowp["id_magasin_pharmacie"],
                                'designationart' => $rowp["libelle_article"],
                                'qteart' => $rowp["stock_article_mb"],
                                'prixarta' => $rowp["prix_achat_article"],
                                'prixarts' => $prixs,
                                'unitearta' => $rowp["unite_achat_article"],
                                'uniteartv' => $rowp["unite_vente_article"],
                                'unitearts' => $rowp["unite_sortie_article"]
                        ));
                        $_SESSION["cart_prodvaaba"] = $prodArray;
                        echo "<script language='javascript'>alert('Desole article insuffisant en stock !')</script>";
                    }
                }

                if (isset($_SESSION["loginproprietaire"])) {
                    die('<meta http-equiv="refresh" content="0; URL=indexadmin.php?page=' . base64_encode($a) . '&pharmacie=' . $idb . '">');
                } else if (($_SESSION["code_service"] == "DG")) {
                    die('<meta http-equiv="refresh" content="0; URL=indexdg.php?page=' . base64_encode($a) . '&pharmacie=' . $idb . '">');
                } else {
                    die('<meta http-equiv="refresh" content="0; URL=indexpersonnel.php?page=' . base64_encode($a) . '&pharmacie=' . $idb . '">');
                }
                break;
        }
    }
    ?>
</div>