
<div class="row">
    <?php
    if (!empty($_GET["actionp"])) {
        $a = 'hopitalpages/hopitalpatient/hopitalcommandepharmaciepatient/commander_patient';

        $id = $_REQUEST["ordonnance"];
        switch ($_GET["actionp"]) {
            case "add":
                $ligneok = TRUE;
                $productparidp = $con->query("select * from hp_ligne_ordonnance as lbl left join "
                        . "hp_produit as a on lbl.idproduit=a.idproduit left join hp_categorie as c "
                        . "on a.idcategorie=c.idcategorie where lbl.idligneordonnance='" . $_GET["idp"] . "'");
                $rowpp = mysqli_fetch_assoc($productparidp);
                
                $productparid = $con->query("select * from hp_boutique as lbl left join "
                        . "hp_produit as a on lbl.idproduit=a.idproduit left join hp_categorie as c "
                        . "on a.idcategorie=c.idcategorie where lbl.idproduit='" . $rowpp["idproduit"] . "'");
                $rowp = mysqli_fetch_assoc($productparid);
                $qt = ($rowpp["stockligneordonnance"] - $rowpp["stocklivreligneordonnance"]);
                $rsltuarp = $con->query("select * from hp_conversion where idunite='" . $rowpp["idunite"] . "' "
                        . "and idproduit='" . $rowp["idproduit"] . "'") or die(mysqli_error($con));
                $rowarp = mysqli_fetch_assoc($rsltuarp);
//                $prixliv = $rowp["prixventeproduit"];
////                    echo"<script language='javascript'>alert($pv)</script>";
//                if ($rowpp["idunite"] != $rowp["uniteventeproduit"]) {
                    $prixliv = $rowarp["prixconversion"];
//                } else {
//                    $prixliv = $rowp["prixventeproduit"];
//                }
                $prodArray = array($rowpp["idligneordonnance"] => array(
                        'idart' => $rowpp["idligneordonnance"],
                        'idbout' => $rowp["idboutique"],
                        'designationart' => $rowp["libelleproduit"],
                        'qteart' => $qt,
                        'prixarta' => $rowp["prixachatproduit"],
                        'prixartv' => $rowp["prixventeproduit"],
                        'prixartliv' => $prixliv,
                        'unitearta' => $rowp["uniteachatproduit"],
                        'uniteartv' => $rowp["uniteventeproduit"],
                        'uniteartliv' => $rowpp["idunite"],
                        'unitearts' => $rowp["unitesortieproduit"],
                        'stockok' => $ligneok
                ));
                
                if (!empty($_SESSION["cart_prodlordp" . $id])) {
                    $f = FALSE;
                    foreach ($_SESSION["cart_prodlordp" . $id] as $k => $v) {
                        if (($_SESSION["cart_prodlordp" . $id][$k]["idart"] == $_GET["idp"])) {
                            $f = TRUE;
                            $q = $_SESSION["cart_prodlordp" . $id][$k]["qteart"] + $qt;
                            if (($rowpp["stockligneordonnance"] - $rowpp["stocklivreligneordonnance"]) <= $q) {
                                $q = ($rowpp["stockligneordonnance"] - $rowpp["stocklivreligneordonnance"]);
                            }

                            if ($rowp["stockproduit"] >= $q) {
                                $_SESSION["cart_prodlordp" . $id][$k]["qteart"] = $q;
                            } else {
                                $rsltuarpa = $con->query("select * from hp_conversion where idunite='" . $rowpp["idunite"] . "' "
                                        . "and idproduit='" . $rowp["idproduit"] . "'") or die(mysqli_error($con));
                                $npharmaciepa = mysqli_num_rows($rsltuarpa);

                                $rowarpa = mysqli_fetch_assoc($rsltuarpa);
                                if ($npharmaciepa != 0) {
                                    if ($rowpp["stockligneordonnance"] > $rowarpa["stockconversion"]) {
                                        $pro = $rowarpa["stockconversion"];
                                        $_SESSION["cart_prodlordp" . $id][$k]["qteart"] = $pro;

                                        $proccc = (($rowpp["stockligneordonnance"] - $rowpp["stocklivreligneordonnance"]) - $rowarpa["stockconversion"]);
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
                                        $_SESSION["cart_prodlordp" . $id][$k]["qteart"] = $q;
                                    }
                                } else {
                                    $pro = $rowp["stockproduit"];
                                    $_SESSION["cart_prodlordp" . $id][$k]["qteart"] = $pro;

                                    $proccc = (($rowpp["stockligneordonnance"] - $rowpp["stocklivreligneordonnance"]) - $rowp["stockproduit"]);
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
                    if (!$f) {
                        if ($rowp["stockproduit"] >= $qt) {
                            $_SESSION["cart_prodlordp" . $id] = array_merge($_SESSION["cart_prodlordp" . $id], $prodArray);
                        } else {

                            $rsltuarpa = $con->query("select * from hp_conversion where idunite='" . $rowpp["idunite"] . "' "
                                    . "and idproduit='" . $rowp["idproduit"] . "'") or die(mysqli_error($con));
                            $npharmaciepa = mysqli_num_rows($rsltuarpa);

                            $rowarpa = mysqli_fetch_assoc($rsltuarpa);
                            if ($npharmaciepa != 0) {
                                if ($rowpp["stockligneordonnance"] > $rowarpa["stockconversion"]) {
                                    $proccc = (($rowpp["stockligneordonnance"] - $rowpp["stocklivreligneordonnance"]) - $rowarpa["stockconversion"]);
                                    $ligneok = FALSE;
                                    $prodArray = array($rowpp["idligneordonnance"] => array(
                                            'idart' => $rowpp["idligneordonnance"],
                                            'idbout' => $rowp["idboutique"],
                                            'designationart' => $rowp["libelleproduit"],
                                            'qteart' => $rowarpa["stock_conversion"],
                                            'prixarta' => $rowp["prixachatproduit"],
                                            'prixartv' => $rowp["prixventeproduit"],
                                            'prixartliv' => $prixliv,
                                            'unitearta' => $rowp["uniteachatproduit"],
                                            'uniteartv' => $rowp["uniteventeproduit"],
                                            'uniteartliv' => $rowpp["idunite"],
                                            'unitearts' => $rowp["unitesortieproduit"],
                                            'stockok' => $ligneok
                                    ));
                                    $_SESSION["cart_prodlordp" . $id] = array_merge($_SESSION["cart_prodlordp" . $id], $prodArray);

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
                                    $_SESSION["cart_prodlordp" . $id] = array_merge($_SESSION["cart_prodlordp" . $id], $prodArray);
                                }
                            } else {
                                $proccc = (($rowpp["stockligneordonnance"] - $rowpp["stocklivreligneordonnance"]) - $rowp["stockproduit"]);
                                $ligneok = FALSE;
                                $prodArray = array($rowpp["idligneordonnance"] => array(
                                        'idart' => $rowpp["idligneordonnance"],
                                        'idbout' => $rowp["idboutique"],
                                        'designationart' => $rowp["libelleproduit"],
                                        'qteart' => $rowp["stockproduit"],
                                        'prixarta' => $rowp["prixachatproduit"],
                                        'prixartv' => $rowp["prixventeproduit"],
                                        'prixartliv' => $prixliv,
                                        'unitearta' => $rowp["uniteachatproduit"],
                                        'uniteartv' => $rowp["uniteventeproduit"],
                                        'uniteartliv' => $rowpp["idunite"],
                                        'unitearts' => $rowp["unitesortieproduit"],
                                        'stockok' => $ligneok
                                ));
                                $_SESSION["cart_prodlordp" . $id] = array_merge($_SESSION["cart_prodlordp" . $id], $prodArray);

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
                        $_SESSION["cart_prodlordp" . $id] = $prodArray;
                    } else {

                        $rsltuarpa = $con->query("select * from hp_conversion where idunite='" . $rowpp["idunite"] . "' "
                                . "and idproduit='" . $rowp["idproduit"] . "'") or die(mysqli_error($con));
                        $npharmaciepa = mysqli_num_rows($rsltuarpa);

                        $rowarpa = mysqli_fetch_assoc($rsltuarpa);
                        if ($npharmaciepa != 0) {
                            if ($rowpp["stockligneordonnance"] > $rowarpa["stockconversion"]) {

                                $proccc = (($rowpp["stockligneordonnance"] - $rowpp["stocklivreligneordonnance"]) - $rowarpa["stock_conversion"]);
                                $ligneok = FALSE;
                                $prodArray = array($rowpp["idligneordonnance"] => array(
                                        'idart' => $rowpp["idligneordonnance"],
                                        'idbout' => $rowp["idboutique"],
                                        'designationart' => $rowp["libelleproduit"],
                                        'qteart' => $rowarpa["stock_conversion"],
                                        'prixarta' => $rowp["prixachatproduit"],
                                        'prixartv' => $rowp["prixventeproduit"],
                                        'prixartliv' => $prixliv,
                                        'unitearta' => $rowp["uniteachatproduit"],
                                        'uniteartv' => $rowp["uniteventeproduit"],
                                        'uniteartliv' => $rowpp["idunite"],
                                        'unitearts' => $rowp["unitesortieproduit"],
                                        'stockok' => $ligneok
                                ));
                                $_SESSION["cart_prodlordp" . $id] = $prodArray;

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
                                $_SESSION["cart_prodlordp" . $id] = $prodArray;
                            }
                        } else {

                            $proccc = (($rowpp["stockligneordonnance"] - $rowpp["stocklivreligneordonnance"]) - $rowp["stockproduit"]);
                            $ligneok = FALSE;
                            $prodArray = array($rowpp["idligneordonnance"] => array(
                                    'idart' => $rowpp["idligneordonnance"],
                                    'idbout' => $rowp["idboutique"],
                                    'designationart' => $rowp["libelleproduit"],
                                    'qteart' => $rowp["stockproduit"],
                                    'prixarta' => $rowp["prixachatproduit"],
                                    'prixartv' => $rowp["prixventeproduit"],
                                    'prixartliv' => $prixliv,
                                    'unitearta' => $rowp["uniteachatproduit"],
                                    'uniteartv' => $rowp["uniteventeproduit"],
                                    'uniteartliv' => $rowpp["idunite"],
                                    'unitearts' => $rowp["unitesortieproduit"],
                                    'stockok' => $ligneok
                            ));
                            $_SESSION["cart_prodlordp" . $id] = $prodArray;

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

                die('<meta http-equiv="refresh" content="0; URL='.$url.'?page=' . base64_encode($a) . '&ordonnance=' . $id . '">');
                break;
        }
    }
    ?>
</div>