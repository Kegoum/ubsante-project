
<div class="row">
    <?php
    if (!empty($_GET["actionp"])) {
        $a = 'hopitalpages/hopitalmagasin/hopitalboncommande/commande';

        switch ($_GET["actionp"]) {
            case "add":
                $qt = 1;
                $productparid = $con->query("select * from hp_produit as a left join hp_categorie as c on "
                        . "a.idcategorie=c.idcategorie where a.idproduit='" . $_GET["idp"] . "'");
                $rowp = mysqli_fetch_assoc($productparid);
                
                $prodArray = array($rowp["idproduit"] => array(
                        'idart' => $rowp["idproduit"],
                        'designationart' => $rowp["libelleproduit"],
                        'qteart' => $qt,
                        'prixarta' => $rowp["prixachatproduit"],
                        'prixartv' => $rowp["prixventeproduit"],
                        'unitearta' => $rowp["uniteachatproduit"],
                        'uniteartv' => $rowp["uniteventeproduit"],
                        'unitearts' => $rowp["unitesortieproduit"]
                ));
                $ider = $rowp["idproduit"];

                if (!empty($_SESSION["cart_prodvcex"])) {
                    $f = FALSE;
                    foreach ($_SESSION["cart_prodvcex"] as $k => $v) {
                        if (($_SESSION["cart_prodvcex"][$k]["idart"] == $_GET["idp"])) {
                            $f = TRUE;
                            $q = $_SESSION["cart_prodvcex"][$k]["qteart"] + 1;
                            $_SESSION["cart_prodvcex"][$k]["qteart"] = $_SESSION["cart_prodvcex"][$k]["qteart"] + 1;
                        }
                    }
                    if (!$f) {
                        $_SESSION["cart_prodvcex"] = array_merge($_SESSION["cart_prodvcex"], $prodArray);
                    }
                } else {
                    $_SESSION["cart_prodvcex"] = $prodArray;
                }

                die('<meta http-equiv="refresh" content="0; URL='.$url.'?page=' . base64_encode($a) . '">');
                break;
        }
    }
    ?>
</div>