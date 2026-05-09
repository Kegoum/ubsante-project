
<div class="row">
    <?php
//    echo"<script language='javascript'>alert('ok')</script>";
    if (!empty($_GET["actionp"])) {
        $a = 'hopitalpages/hopitalpharmacie/hopitalbonlivraisonc/livraison';

        $id = $_REQUEST["boncommande"];
        switch ($_GET["actionp"]) {
            case "add":
                $ligneok = TRUE;
                $productparid = $con->query("select * from hp_ligne_bon_commande_interne as lbl left join "
                        . "hp_produit as a on lbl.idproduit=a.idproduit left join hp_categorie as c "
                        . "on a.idcategorie=c.idcategorie where lbl.idligneboncommandeinterne='" . $_GET["idp"] . "'");
                $rowp = mysqli_fetch_assoc($productparid);
                $qt = ($rowp["stockligneboncommandeinterne"] - $rowp["stocklivreligneboncommandeinterne"]);
                $rsltuarp = $con->query("select * from hp_conversion where idunite='" . $rowp["idunite"] . "' "
                        . "and idproduit='" . $rowp["idproduit"] . "'") or die(mysqli_error($con));
                $rowarp = mysqli_fetch_assoc($rsltuarp);
                $rsltuarpaa = $con->query("select * from hp_conversion where idunite='" . $rowp["uniteachatproduit"] . "' "
                        . "and idproduit='" . $rowp["idproduit"] . "'") or die(mysqli_error($con));
                $rowarpaa = mysqli_fetch_assoc($rsltuarpaa);
                $prixliv = $rowarp["prixconversion"];
                $prodArray = array($rowp["idligneboncommandeinterne"] => array(
                        'idart' => $rowp["idligneboncommandeinterne"],
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
                $ider = $rowp["idligneboncommandeinterne"];

                if (!empty($_SESSION["cart_prodvlibc" . $id])) {
                    $f = FALSE;
                    foreach ($_SESSION["cart_prodvlibc" . $id] as $k => $v) {
                        if (($_SESSION["cart_prodvlibc" . $id][$k]["idart"] == $_GET["idp"])) {
                            $f = TRUE;
                            $q = $qt;
                            if (($rowp["stockligneboncommandeinterne"] - $rowp["stocklivreligneboncommandeinterne"]) <= $q) {
                                $q = ($rowp["stockligneboncommandeinterne"] - $rowp["stocklivreligneboncommandeinterne"]);
                            }
                            if ($rowp["uniteachatproduit"] == $rowp["idunite"]) {
                                if ($rowp["stockproduit"] >= $qt) {
                                    $_SESSION["cart_prodvlibc" . $id][$k]["qteart"] = $qt;
                                } else {
                                    $rsltuarpa = $con->query("select * from hp_conversion where idunite='" . $rowp["idunite"] . "' "
                                            . "and idproduit='" . $rowp["idproduit"] . "'") or die(mysqli_error($con));
                                    $npharmaciepa = mysqli_num_rows($rsltuarpa);

                                    $rowarpa = mysqli_fetch_assoc($rsltuarpa);
                                    if ($npharmaciepa != 0) {
                                        if ($rowp["stockligneboncommandeinterne"] > $rowarpa["stockconversion"]) {
                                            $pro = $rowarpa["stockconversion"];
                                            $_SESSION["cart_prodvlibc" . $id][$k]["qteart"] = $pro;

                                            $proccc = (($rowp["stockligneboncommandeinterne"] - $rowp["stocklivreligneboncommandeinterne"]) - $rowarpa["stockconversion"]);
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

                                            echo "<script language='javascript'>alert('Desole produit insuffisant en stock !')</script>";
                                        } else {
                                            $_SESSION["cart_prodvlibc" . $id][$k]["qteart"] = $q;
                                        }
                                    } else {
                                        $pro = $rowp["stockproduit"];
                                        $_SESSION["cart_prodvlibc" . $id][$k]["qteart"] = $pro;

                                        $proccc = (($rowp["stockligneboncommandeinterne"] - $rowp["stocklivreligneboncommandeinterne"]) - $rowp["stockproduit"]);
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

                                        echo "<script language='javascript'>alert('Desole produit insuffisant en stock !')</script>";
                                    }
                                }
                            } else {
                                if ($rowarpaa["stockconversion"] >= $qt) {
                                    $_SESSION["cart_prodvlibc" . $id][$k]["qteart"] = $qt;
                                } else {
                                    $rsltuarpa = $con->query("select * from hp_conversion where idunite='" . $rowp["uniteachatproduit"] . "' "
                                            . "and idproduit='" . $rowp["idproduit"] . "'") or die(mysqli_error($con));
                                    $npharmaciepa = mysqli_num_rows($rsltuarpa);

                                    $rowarpa = mysqli_fetch_assoc($rsltuarpa);
                                    if ($npharmaciepa != 0) {
                                        if ($rowp["stockligneboncommandeinterne"] > $rowarpa["stockconversion"]) {
                                            $pro = $rowarpa["stockconversion"];
                                            $_SESSION["cart_prodvlibc" . $id][$k]["qteart"] = $pro;

                                            $proccc = (($rowp["stockligneboncommandeinterne"] - $rowp["stocklivreligneboncommandeinterne"]) - $rowarpa["stockconversion"]);
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

                                            echo "<script language='javascript'>alert('Desole produit insuffisant en stock !')</script>";
                                        } else {
                                            $_SESSION["cart_prodvlibc" . $id][$k]["qteart"] = $q;
                                        }
                                    } else {
                                        $pro = $rowp["stockproduit"];
                                        $_SESSION["cart_prodvlibc" . $id][$k]["qteart"] = $pro;

                                        $proccc = (($rowp["stockligneboncommandeinterne"] - $rowp["stocklivreligneboncommandeinterne"]) - $rowp["stockproduit"]);
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

                                        echo "<script language='javascript'>alert('Desole produit insuffisant en stock !')</script>";
                                    }
                                }
                            }
                        }
                    }
                    if (!$f) {
                        if ($rowp["stockproduit"] >= $qt) {
                            $_SESSION["cart_prodvlibc" . $id] = array_merge($_SESSION["cart_prodvlibc" . $id], $prodArray);
                        } else {

                            $rsltuarpa = $con->query("select * from hp_conversion where idunite='" . $rowp["idunite"] . "' "
                                    . "and idproduit='" . $rowp["idproduit"] . "'") or die(mysqli_error($con));
                            $npharmaciepa = mysqli_num_rows($rsltuarpa);

                            $rowarpa = mysqli_fetch_assoc($rsltuarpa);
                            if ($npharmaciepa != 0) {
                                if ($rowp["stockligneboncommandeinterne"] > $rowarpa["stockconversion"]) {
                                    $proccc = (($rowp["stockligneboncommandeinterne"] - $rowp["stocklivreligneboncommandeinterne"]) - $rowarpa["stock_conversion"]);
                                    $ligneok = FALSE;
                                    $prodArray = array($rowp["idligneboncommandeinterne"] => array(
                                            'idart' => $rowp["idligneboncommandeinterne"],
                                            'designationart' => $rowp["libelleproduit"],
                                            'qteart' => $rowarpa["stock_conversion"],
                                            'prixarta' => $rowp["prixachatproduit"],
                                            'prixartv' => $rowp["prixventeproduit"],
                                            'prixartliv' => $prixliv,
                                            'unitearta' => $rowp["uniteachatproduit"],
                                            'uniteartv' => $rowp["uniteventeproduit"],
                                            'uniteartliv' => $rowp["idunite"],
                                            'unitearts' => $rowp["unitesortieproduit"],
                                            'stockok' => $ligneok
                                    ));
                                    $_SESSION["cart_prodvlibc" . $id] = array_merge($_SESSION["cart_prodvlibc" . $id], $prodArray);

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
                                } else {
                                    $_SESSION["cart_prodvlibc" . $id] = array_merge($_SESSION["cart_prodvlibc" . $id], $prodArray);
                                }
                            } else {
                                $proccc = (($rowp["stockligneboncommandeinterne"] - $rowp["stocklivreligneboncommandeinterne"]) - $rowp["stockproduit"]);
                                $ligneok = FALSE;
                                $prodArray = array($rowp["idligneboncommandeinterne"] => array(
                                        'idart' => $rowp["idligneboncommandeinterne"],
                                        'designationart' => $rowp["libelleproduit"],
                                        'qteart' => $rowp["stockproduit"],
                                        'prixarta' => $rowp["prixachatproduit"],
                                        'prixartv' => $rowp["prixventeproduit"],
                                        'prixartliv' => $prixliv,
                                        'unitearta' => $rowp["uniteachatproduit"],
                                        'uniteartv' => $rowp["uniteventeproduit"],
                                        'uniteartliv' => $rowp["idunite"],
                                        'unitearts' => $rowp["unitesortieproduit"],
                                        'stockok' => $ligneok
                                ));
                                $_SESSION["cart_prodvlibc" . $id] = array_merge($_SESSION["cart_prodvlibc" . $id], $prodArray);

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
                            }
                        }
                    }
                } else {
                    if ($rowp["stockproduit"] >= $qt) {
                        $_SESSION["cart_prodvlibc" . $id] = $prodArray;
                    } else {

                        $rsltuarpa = $con->query("select * from hp_conversion where idunite='" . $rowp["idunite"] . "' "
                                . "and idproduit='" . $rowp["idproduit"] . "'") or die(mysqli_error($con));
                        $npharmaciepa = mysqli_num_rows($rsltuarpa);

                        $rowarpa = mysqli_fetch_assoc($rsltuarpa);
                        if ($npharmaciepa != 0) {
                            if ($rowp["stockligneboncommandeinterne"] > $rowarpa["stockconversion"]) {

                                $proccc = (($rowp["stockligneboncommandeinterne"] - $rowp["stocklivreligneboncommandeinterne"]) - $rowarpa["stock_conversion"]);
                                $ligneok = FALSE;
                                $prodArray = array($rowp["idligneboncommandeinterne"] => array(
                                        'idart' => $rowp["idligneboncommandeinterne"],
                                        'designationart' => $rowp["libelleproduit"],
                                        'qteart' => $rowarpa["stock_conversion"],
                                        'prixarta' => $rowp["prixachatproduit"],
                                        'prixartv' => $rowp["prixventeproduit"],
                                        'prixartliv' => $prixliv,
                                        'unitearta' => $rowp["uniteachatproduit"],
                                        'uniteartv' => $rowp["uniteventeproduit"],
                                        'uniteartliv' => $rowp["idunite"],
                                        'unitearts' => $rowp["unitesortieproduit"],
                                        'stockok' => $ligneok
                                ));
                                $_SESSION["cart_prodvlibc" . $id] = $prodArray;

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
                            } else {
                                $_SESSION["cart_prodvlibc" . $id] = $prodArray;
                            }
                        } else {

                            $proccc = (($rowp["stockligneboncommandeinterne"] - $rowp["stocklivreligneboncommandeinterne"]) - $rowp["stockproduit"]);
                            $ligneok = FALSE;
                            $prodArray = array($rowp["idligneboncommandeinterne"] => array(
                                    'idart' => $rowp["idligneboncommandeinterne"],
                                    'designationart' => $rowp["libelleproduit"],
                                    'qteart' => $rowp["stockproduit"],
                                    'prixarta' => $rowp["prixachatproduit"],
                                    'prixartv' => $rowp["prixventeproduit"],
                                    'prixartliv' => $prixliv,
                                    'unitearta' => $rowp["uniteachatproduit"],
                                    'uniteartv' => $rowp["uniteventeproduit"],
                                    'uniteartliv' => $rowp["idunite"],
                                    'unitearts' => $rowp["unitesortieproduit"],
                                    'stockok' => $ligneok
                            ));
                            $_SESSION["cart_prodvlibc" . $id] = $prodArray;

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
                        }
                    }
                }

                die('<meta http-equiv="refresh" content="0; URL=' . $url . '?page=' . base64_encode($a) . '&boncommande=' . $id . '">');
                break;
        }
    }
    ?>
</div>