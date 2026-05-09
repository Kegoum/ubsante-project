
<div class="row">
    <?php
    if (!empty($_GET["actionp"])) {
        $a = 'hotelpages/pharmaciehotel/commandepharmaciehotel/commander_divers';

        switch ($_GET["actionp"]) {
            case "add":
                if ((!empty($_POST["qteprd"])) && ($_POST["qteprd"] > 0)) {
                    $qt = $_POST["qteprd"];
                    $productparid = $con->query("select * from hotel_magasin_pharmacie as mb left join hotel_article_point_hotel "
                            . "as aph on mb.id_article_point_hotel=aph.id_article_point_hotel left join hotel_article as a on "
                            . "aph.id_article=a.id_article where mb.id_magasin_pharmacie='" . $_GET["idp"] . "'");
                    $rowp = mysqli_fetch_assoc($productparid);
                    $pr1 = $rowp["prix_vente_article_mb"];

                    $pr = $pr1;
                    $prodArray = array($rowp["id_magasin_pharmacie"] => array(
                            'idart' => $rowp["id_magasin_pharmacie"],
                            'designationart' => $rowp["libelle_article"],
                            'qteart' => $qt,
                            'prixart' => $pr
                    ));
                    $ider = $rowp["id_magasin_pharmacie"];

                    if (!empty($_SESSION["cart_prodvb"])) {
                        $f = FALSE;
                        foreach ($_SESSION["cart_prodvb"] as $k => $v) {
                            if (($_SESSION["cart_prodvb"][$k]["idart"] == $_GET["idp"])) {
                                $f = TRUE;
                                $q = $_SESSION["cart_prodvb"][$k]["qteart"] + $_POST["qteprd"];
                                $_SESSION["cart_prodvb"][$k]["qteart"] = $_SESSION["cart_prodvb"][$k]["qteart"] + $_POST["qteprd"];
                            }
                        }
                        if (!$f) {
                            $_SESSION["cart_prodvb"] = array_merge($_SESSION["cart_prodvb"], $prodArray);
                        }
                    } else {
                        $_SESSION["cart_prodvb"] = $prodArray;
                    }
                } else if ((!empty($_POST["qteprda"])) && ($_POST["qteprda"] > 0)) {
                    $qt = $_POST["qteprda"];
                    $productparid = $con->query("select * from hotel_magasin_pharmacie as mb left join hotel_article_point_hotel "
                            . "as aph on mb.id_article_point_hotel=aph.id_article_point_hotel left join hotel_article as a on "
                            . "aph.id_article=a.id_article where mb.id_magasin_pharmacie='" . $_GET["idp"] . "'");
                    $rowp = mysqli_fetch_assoc($productparid);
                    $pr1 = $rowp["prix_vente_article_mb"];

                    $pr = $pr1;
                    $prodArray = array($rowp["id_magasin_pharmacie"] => array(
                            'idart' => $rowp["id_magasin_pharmacie"],
                            'designationart' => $rowp["libelle_article"],
                            'qteart' => $qt,
                            'prixart' => $pr
                    ));
                    $ider = $rowp["id_magasin_pharmacie"];

                    if (!empty($_SESSION["cart_prodvb"])) {
                        $f = FALSE;
                        foreach ($_SESSION["cart_prodvb"] as $k => $v) {
                            if (($_SESSION["cart_prodvb"][$k]["idart"] == $_GET["idp"])) {
                                $f = TRUE;
                                $q = $_SESSION["cart_prodvb"][$k]["qteart"] + $_POST["qteprda"];
                                $_SESSION["cart_prodvb"][$k]["qteart"] = $_SESSION["cart_prodvb"][$k]["qteart"] + $_POST["qteprda"];
                            }
                        }
                        if (!$f) {
                            $_SESSION["cart_prodvb"] = array_merge($_SESSION["cart_prodvb"], $prodArray);
                        }
                    } else {
                        $_SESSION["cart_prodvb"] = $prodArray;
                    }
                    ?>
                    <?php
                } else {
                    echo "<script language='javascript'>$('div.alertartneg').show('slow').delay(8000).hide('slow');</script>";
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