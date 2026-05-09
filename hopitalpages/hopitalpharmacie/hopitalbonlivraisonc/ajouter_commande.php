
<div class="row">
    <?php
//    echo"<script language='javascript'>alert('ok')</script>";
    if (!empty($_GET["actionp"])) {
        $a = 'hopitalpages/hopitalpharmacie/hopitalbonlivraisonc/livraison';

        $id = $_REQUEST["boncommande"];
        switch ($_GET["actionp"]) {
            case "add":
                $productparid = $con->query("select * from hp_ligne_bon_commande_interne as lbl left join "
                        . "hp_produit as a on lbl.idproduit=a.idproduit left join hp_categorie as c "
                        . "on a.idcategorie=c.idcategorie where lbl.idligneboncommandeinterne='" . $_GET["idp"] . "'");
                $rowp = mysqli_fetch_assoc($productparid);

                $proccc = ($rowp["stockligneboncommandeinterne"]);
                $prodArrayc = array($rowp["idproduit"] => array(
                        'idart' => $rowp["idproduit"],
                        'designationart' => $rowp["libelleproduit"],
                        'qteart' => $proccc,
                        'prixarta' => $rowp["prixachatproduit"],
                        'prixartv' => $rowp["prixventeproduit"],
                        'unitearta' => $rowp["uniteachatproduit"],
                        'uniteartv' => $rowp["uniteventeproduit"],
                        'unitearts' => $rowp["unitesortieproduit"]
                ));
                if (!empty($_SESSION["cart_prodvcex"])) {
                    $f = FALSE;
                    foreach ($_SESSION["cart_prodvcex"] as $k => $v) {
                        if (($_SESSION["cart_prodvcex"][$k]["idart"] == $rowp["idproduit"])) {
                            $f = TRUE;
                            $_SESSION["cart_prodvcex"][$k]["qteart"] = $_SESSION["cart_prodvcex"][$k]["qteart"] + $proccc;
                        }
                    }
                    if (!$f) {
                        $_SESSION["cart_prodvcex"] = array_merge($_SESSION["cart_prodvcex"], $prodArrayc);
                    }
                } else {
                    $_SESSION["cart_prodvcex"] = $prodArrayc;
                }

                die('<meta http-equiv="refresh" content="0; URL='.$url.'?page=' . base64_encode($a) . '&boncommande=' . $id . '">');
                break;
        }
    }
    ?>
</div>