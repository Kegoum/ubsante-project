
<div class="row">
    <?php
//    echo"<script language='javascript'>alert('ok')</script>";
    if (!empty($_GET["actionp"])) {
        $a = 'hotelpages/economathotel/bonlivraisonhotel/livraison';

        switch ($_GET["actionp"]) {
            case "add":
                $qt = 1;
                $productparid = $con->query("select * from hotel_article_point_hotel as aph left join hotel_article "
                        . "as a on aph.id_article=a.id_article left join hotel_categorie as c on a.id_categorie=c.id_categorie "
                        . "left join hotel_fourniture as f on a.id_fourniture=f.id_fourniture where "
                        . "aph.id_article_point_hotel='" . $_GET["idp"] . "'");
                $rowp = mysqli_fetch_assoc($productparid);
                $idlinge = NULL;
                $prixlinge = 0;
                $rsltlin = $con->query("select * from hotel_linge where id_article_point_hotel='" . $rowp["id_article_point_hotel"] . "'") or die(mysqli_error($con));
                $nblin = mysqli_num_rows($rsltlin);
                if ($nblin != 0) {
                    $rowlin = mysqli_fetch_assoc($rsltlin);
                    $idlinge = $rowlin["id_linge"];
                    $prixlinge = $rowlin["prix_lavage_linge"];
                }
                $prodArray = array($rowp["id_article_point_hotel"] => array(
                        'idart' => $rowp["id_article_point_hotel"],
                        'idlingeart' => $idlinge,
                        'prixlingeart' => $prixlinge,
                        'designationart' => $rowp["libelle_article"],
                        'qteart' => $qt,
                        'prixarta' => $rowp["prix_achat_article"],
                        'prixartv' => $rowp["prix_vente_article"],
                        'uniteartl' => $rowp["unite_achat_article"],
                        'unitearta' => $rowp["unite_achat_article"],
                        'uniteartv' => $rowp["unite_vente_article"],
                        'unitearts' => $rowp["unite_sortie_article"]
                ));
                $ider = $rowp["id_article_point_hotel"];

                if (!empty($_SESSION["cart_prodvlex"])) {
                    $f = FALSE;
                    foreach ($_SESSION["cart_prodvlex"] as $k => $v) {
                        if (($_SESSION["cart_prodvlex"][$k]["idart"] == $_GET["idp"])) {
                            $f = TRUE;
                            $_SESSION["cart_prodvlex"][$k]["qteart"] = $_SESSION["cart_prodvlex"][$k]["qteart"] + 1;
                        }
                    }
                    if (!$f) {
                        $_SESSION["cart_prodvlex"] = array_merge($_SESSION["cart_prodvlex"], $prodArray);
                    }
                } else {
                    $_SESSION["cart_prodvlex"] = $prodArray;
                }

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
</div>