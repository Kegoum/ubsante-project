
<div class="row">
    <?php
//    echo"<script language='javascript'>alert('ok')</script>";
    if (!empty($_GET["actionp"])) {
        $a = 'hopitalpages/hopitalmagasin/hopitalbonlivraisonc/livraison';

        $id = $_REQUEST["boncommande"];
        switch ($_GET["actionp"]) {
            case "add":
                $ligneok = TRUE;
                $productparid = $con->query("select * from hp_ligne_bon_commande as lbl left join "
                        . "hp_produit as a on lbl.idproduit=a.idproduit left join hp_categorie as c "
                        . "on a.idcategorie=c.idcategorie where lbl.idligneboncommande='" . $_GET["idp"] . "'");
                $rowp = mysqli_fetch_assoc($productparid);
                $qt = ($rowp["stockligneboncommande"] - $rowp["stocklivreligneboncommande"]);

                $prixliv = $rowp["prixachatproduit"];
                $prodArray = array($rowp["idligneboncommande"] => array(
                        'idart' => $rowp["idligneboncommande"],
                        'designationart' => $rowp["libelleproduit"],
                        'qteart' => $qt,
                        'prixarta' => $rowp["prixachatproduit"],
                        'prixartv' => $rowp["prixventeproduit"],
                        'prixartliv' => $prixliv,
                        'unitearta' => $rowp["uniteachatproduit"],
                        'uniteartv' => $rowp["uniteventeproduit"],
                        'uniteartliv' => $rowp["idunite"],
                        'unitearts' => $rowp["unitesortieproduit"],
                        'stockok' => $ligneok
                ));
                $ider = $rowp["idligneboncommande"];

                if (!empty($_SESSION["cart_prodvlebc" . $id])) {
                    $f = FALSE;
                    foreach ($_SESSION["cart_prodvlebc" . $id] as $k => $v) {
                        if (($_SESSION["cart_prodvlebc" . $id][$k]["idart"] == $_GET["idp"])) {
                            $f = TRUE;
                            $q = $_SESSION["cart_prodvlebc" . $id][$k]["qteart"] + $qt;
                            if (($rowp["stockligneboncommande"] - $rowp["stocklivreligneboncommande"]) <= $q) {
                                $q = ($rowp["stockligneboncommande"] - $rowp["stocklivreligneboncommande"]);
                            }
                            $_SESSION["cart_prodvlebc" . $id][$k]["qteart"] = $q;
                        }
                    }
                    if (!$f) {
                        $_SESSION["cart_prodvlebc" . $id] = array_merge($_SESSION["cart_prodvlebc" . $id], $prodArray);
                    }
                } else {
                    $_SESSION["cart_prodvlebc" . $id] = $prodArray;
                }

                die('<meta http-equiv="refresh" content="0; URL='.$url.'?page=' . base64_encode($a) . '&boncommande=' . $id . '">');
                
                break;
        }
    }
    ?>
</div>