
<div class="row">
    <?php
//    echo"<script language='javascript'>alert('ok')</script>";
    if (!empty($_GET["actionp"])) {
        $a = 'hotelpages/restauranthotel/bonlivraisonhotel/livraison';

        switch ($_GET["actionp"]) {
            case "add":
                $qt = 1;
                    $productparid = $con->query("select * from hotel_article as a left join hotel_categorie as c on "
        . "a.id_categorie=c.id_categorie left join hotel_fourniture as f on a.id_fourniture=f.id_fourniture where "
                            . "a.id_article='" . $_GET["idp"] . "'");
                    $rowp = mysqli_fetch_assoc($productparid);
                    
                    $prodArray = array($rowp["id_article"] => array(
                            'idart' => $rowp["id_article"],
                            'designationart' => $rowp["libelle_article"],
                            'qteart' => $qt,
                            'prixarta' => $rowp["prix_achat_article"],
                            'prixartv' => $rowp["prix_vente_article"],
                            'unitearta' => $rowp["unite_achat_article"],
                            'uniteartv' => $rowp["unite_vente_article"],
                            'unitearts' => $rowp["unite_sortie_article"]
                    ));
                    $ider = $rowp["id_article"];

                    if (!empty($_SESSION["cart_prodvlir"])) {
                        $f = FALSE;
                        foreach ($_SESSION["cart_prodvlir"] as $k => $v) {
                            if (($_SESSION["cart_prodvlir"][$k]["idart"] == $_GET["idp"])) {
                                $f = TRUE;
                                $q = $_SESSION["cart_prodvlir"][$k]["qteart"] + 1;
                                if ($rowp["stock_article"]>=$q){
                                $_SESSION["cart_prodvlir"][$k]["qteart"] = $_SESSION["cart_prodvlir"][$k]["qteart"] + 1;
                                }  else {
                                    $pro=$rowp["stock_article"];
                                    $_SESSION["cart_prodvlir"][$k]["qteart"] = $pro;
                                    echo "<script language='javascript'>alert('Desole articles insuffisants en stock')</script>";
                                }
                            }
                        }
                        if (!$f) {
                            $_SESSION["cart_prodvlir"] = array_merge($_SESSION["cart_prodvlir"], $prodArray);
                        }
                    } else {
                        $_SESSION["cart_prodvlir"] = $prodArray;
                    }
                
                if (isset($_SESSION["loginproprietaire"])) {
                    die('<meta http-equiv="refresh" content="0; URL=indexadmin.php?page=' . base64_encode($a) . '">');
                } else {
                    die('<meta http-equiv="refresh" content="0; URL=indexpersonnel.php?page=' . base64_encode($a) . '">');
                }
                break;
        }
    }
    ?>
</div>