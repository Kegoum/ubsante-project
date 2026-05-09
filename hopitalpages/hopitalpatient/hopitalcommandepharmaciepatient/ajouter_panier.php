
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
                
                $productparid = $con->query("select * from hp_boutique as lbl where lbl.idproduit='" . $rowpp["idproduit"] . "'");
                $rowp = mysqli_fetch_assoc($productparid);
                $qt = ($rowpp["stockligneordonnance"] - $rowpp["stocklivreligneordonnance"]);
                $rsltuarp = $con->query("select * from hp_conversion where idunite='" . $rowpp["idunite"] . "' "
                        . "and idproduit='" . $rowpp["idproduit"] . "'") or die(mysqli_error($con));
                $rowarp = mysqli_fetch_assoc($rsltuarp);
//                $prixliv = $rowpp["prixventeproduit"];
////                    echo"<script language='javascript'>alert($pv)</script>";
//                if ($rowpp["idunite"] != $rowpp["uniteventeproduit"]) {
                    $prixliv = $rowarp["prixconversion"];
//                } else {
//                    $prixliv = $rowpp["prixventeproduit"];
//                }
                $prodArray = array($rowpp["idligneordonnance"] => array(
                        'idart' => $rowpp["idligneordonnance"],
                        'idbout' => $rowp["idboutique"],
                        'designationart' => $rowpp["libelleproduit"],
                        'qteart' => $qt,
                        'prixarta' => $rowpp["prixachatproduit"],
                        'prixartv' => $rowpp["prixventeproduit"],
                        'prixartliv' => $prixliv,
                        'unitearta' => $rowpp["uniteachatproduit"],
                        'uniteartv' => $rowpp["uniteventeproduit"],
                        'uniteartliv' => $rowpp["idunite"],
                        'unitearts' => $rowpp["unitesortieproduit"],
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

                            if ($rowpp["stockproduit"] >= $q) {
                                $_SESSION["cart_prodlordp" . $id][$k]["qteart"] = $q;
                            } else {
                                $rsltuarpa = $con->query("select * from hp_conversion where idunite='" . $rowpp["idunite"] . "' "
                                        . "and idproduit='" . $rowpp["idproduit"] . "'") or die(mysqli_error($con));
                                $npharmaciepa = mysqli_num_rows($rsltuarpa);

                                $rowarpa = mysqli_fetch_assoc($rsltuarpa);
                                if ($npharmaciepa != 0) {
                                    if ($rowpp["stockligneordonnance"] > $rowarpa["stockconversion"]) {
                                        $pro = $rowarpa["stockconversion"];
                                        $_SESSION["cart_prodlordp" . $id][$k]["qteart"] = $pro;

                                        $proccc = (($rowpp["stockligneordonnance"] - $rowpp["stocklivreligneordonnance"]) - $rowarpa["stockconversion"]);
                                        $prodArrayc = array($rowpp["idproduit"] => array(
                                                'idart' => $rowpp["idproduit"],
                                                'designationart' => $rowpp["libelleproduit"],
                                                'qteart' => $proccc,
                                                'prixarta' => $rowpp["prixachatproduit"],
                                                'prixartv' => $rowpp["prixventeproduit"],
                                                'unitearta' => $rowpp["uniteachatproduit"],
                                                'uniteartv' => $rowpp["uniteventeproduit"],
                                                'unitearts' => $rowpp["unitesortieproduit"]
                                        ));
                                        if (!empty($_SESSION["cart_prodvcex"])) {
                                            $f = FALSE;
                                            foreach ($_SESSION["cart_prodvcex"] as $k => $v) {
                                                if (($_SESSION["cart_prodvcex"][$k]["idart"] == $rowpp["idproduit"])) {
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
                                    $pro = $rowpp["stockproduit"];
                                    $_SESSION["cart_prodlordp" . $id][$k]["qteart"] = $pro;

                                    $proccc = (($rowpp["stockligneordonnance"] - $rowpp["stocklivreligneordonnance"]) - $rowpp["stockproduit"]);
                                    $prodArrayc = array($rowpp["idproduit"] => array(
                                            'idart' => $rowpp["idproduit"],
                                            'designationart' => $rowpp["libelleproduit"],
                                            'qteart' => $proccc,
                                            'prixarta' => $rowpp["prixachatproduit"],
                                            'prixartv' => $rowpp["prixventeproduit"],
                                            'unitearta' => $rowpp["uniteachatproduit"],
                                            'uniteartv' => $rowpp["uniteventeproduit"],
                                            'unitearts' => $rowpp["unitesortieproduit"]
                                    ));
                                    if (!empty($_SESSION["cart_prodvcex"])) {
                                        $f = FALSE;
                                        foreach ($_SESSION["cart_prodvcex"] as $k => $v) {
                                            if (($_SESSION["cart_prodvcex"][$k]["idart"] == $rowpp["idproduit"])) {
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
                        if ($rowpp["stockproduit"] >= $qt) {
                            $_SESSION["cart_prodlordp" . $id] = array_merge($_SESSION["cart_prodlordp" . $id], $prodArray);
                        } else {

                            $rsltuarpa = $con->query("select * from hp_conversion where idunite='" . $rowpp["idunite"] . "' "
                                    . "and idproduit='" . $rowpp["idproduit"] . "'") or die(mysqli_error($con));
                            $npharmaciepa = mysqli_num_rows($rsltuarpa);

                            $rowarpa = mysqli_fetch_assoc($rsltuarpa);
                            if ($npharmaciepa != 0) {
                                if ($rowpp["stockligneordonnance"] > $rowarpa["stockconversion"]) {
                                    $proccc = (($rowpp["stockligneordonnance"] - $rowpp["stocklivreligneordonnance"]) - $rowarpa["stockconversion"]);
                                    $ligneok = FALSE;
                                    $prodArray = array($rowpp["idligneordonnance"] => array(
                                            'idart' => $rowpp["idligneordonnance"],
                                            'idbout' => $rowp["idboutique"],
                                            'designationart' => $rowpp["libelleproduit"],
                                            'qteart' => $rowarpa["stockconversion"],
                                            'prixarta' => $rowpp["prixachatproduit"],
                                            'prixartv' => $rowpp["prixventeproduit"],
                                            'prixartliv' => $prixliv,
                                            'unitearta' => $rowpp["uniteachatproduit"],
                                            'uniteartv' => $rowpp["uniteventeproduit"],
                                            'uniteartliv' => $rowpp["idunite"],
                                            'unitearts' => $rowpp["unitesortieproduit"],
                                            'stockok' => $ligneok
                                    ));
                                    $_SESSION["cart_prodlordp" . $id] = array_merge($_SESSION["cart_prodlordp" . $id], $prodArray);

                                    $prodArrayc = array($rowpp["idproduit"] => array(
                                            'idart' => $rowpp["idproduit"],
                                            'designationart' => $rowpp["libelleproduit"],
                                            'qteart' => $proccc,
                                            'prixarta' => $rowpp["prixachatproduit"],
                                            'prixartv' => $rowpp["prixventeproduit"],
                                            'unitearta' => $rowpp["uniteachatproduit"],
                                            'uniteartv' => $rowpp["uniteventeproduit"],
                                            'unitearts' => $rowpp["unitesortieproduit"]
                                    ));
                                    if (!empty($_SESSION["cart_prodvcex"])) {
                                        $f = FALSE;
                                        foreach ($_SESSION["cart_prodvcex"] as $k => $v) {
                                            if (($_SESSION["cart_prodvcex"][$k]["idart"] == $rowpp["idproduit"])) {
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
                                $proccc = (($rowpp["stockligneordonnance"] - $rowpp["stocklivreligneordonnance"]) - $rowpp["stockproduit"]);
                                $ligneok = FALSE;
                                $prodArray = array($rowpp["idligneordonnance"] => array(
                                        'idart' => $rowpp["idligneordonnance"],
                                        'idbout' => $rowp["idboutique"],
                                        'designationart' => $rowpp["libelleproduit"],
                                        'qteart' => $rowpp["stockproduit"],
                                        'prixarta' => $rowpp["prixachatproduit"],
                                        'prixartv' => $rowpp["prixventeproduit"],
                                        'prixartliv' => $prixliv,
                                        'unitearta' => $rowpp["uniteachatproduit"],
                                        'uniteartv' => $rowpp["uniteventeproduit"],
                                        'uniteartliv' => $rowpp["idunite"],
                                        'unitearts' => $rowpp["unitesortieproduit"],
                                        'stockok' => $ligneok
                                ));
                                $_SESSION["cart_prodlordp" . $id] = array_merge($_SESSION["cart_prodlordp" . $id], $prodArray);

                                $prodArrayc = array($rowpp["idproduit"] => array(
                                        'idart' => $rowpp["idproduit"],
                                        'designationart' => $rowpp["libelleproduit"],
                                        'qteart' => $proccc,
                                        'prixarta' => $rowpp["prixachatproduit"],
                                        'prixartv' => $rowpp["prixventeproduit"],
                                        'unitearta' => $rowpp["uniteachatproduit"],
                                        'uniteartv' => $rowpp["uniteventeproduit"],
                                        'unitearts' => $rowpp["unitesortieproduit"]
                                ));
                                if (!empty($_SESSION["cart_prodvcex"])) {
                                    $f = FALSE;
                                    foreach ($_SESSION["cart_prodvcex"] as $k => $v) {
                                        if (($_SESSION["cart_prodvcex"][$k]["idart"] == $rowpp["idproduit"])) {
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
                    if ($rowpp["stockproduit"] >= $qt) {
                        $_SESSION["cart_prodlordp" . $id] = $prodArray;
                    } else {

                        $rsltuarpa = $con->query("select * from hp_conversion where idunite='" . $rowpp["idunite"] . "' "
                                . "and idproduit='" . $rowpp["idproduit"] . "'") or die(mysqli_error($con));
                        $npharmaciepa = mysqli_num_rows($rsltuarpa);

                        $rowarpa = mysqli_fetch_assoc($rsltuarpa);
                        if ($npharmaciepa != 0) {
                            if ($rowpp["stockligneordonnance"] > $rowarpa["stockconversion"]) {

                                $proccc = (($rowpp["stockligneordonnance"] - $rowpp["stocklivreligneordonnance"]) - $rowarpa["stockconversion"]);
                                $ligneok = FALSE;
                                $prodArray = array($rowpp["idligneordonnance"] => array(
                                        'idart' => $rowpp["idligneordonnance"],
                                        'idbout' => $rowp["idboutique"],
                                        'designationart' => $rowpp["libelleproduit"],
                                        'qteart' => $rowarpa["stockconversion"],
                                        'prixarta' => $rowpp["prixachatproduit"],
                                        'prixartv' => $rowpp["prixventeproduit"],
                                        'prixartliv' => $prixliv,
                                        'unitearta' => $rowpp["uniteachatproduit"],
                                        'uniteartv' => $rowpp["uniteventeproduit"],
                                        'uniteartliv' => $rowpp["idunite"],
                                        'unitearts' => $rowpp["unitesortieproduit"],
                                        'stockok' => $ligneok
                                ));
                                $_SESSION["cart_prodlordp" . $id] = $prodArray;

                                $prodArrayc = array($rowpp["idproduit"] => array(
                                        'idart' => $rowpp["idproduit"],
                                        'designationart' => $rowpp["libelleproduit"],
                                        'qteart' => $proccc,
                                        'prixarta' => $rowpp["prixachatproduit"],
                                        'prixartv' => $rowpp["prixventeproduit"],
                                        'unitearta' => $rowpp["uniteachatproduit"],
                                        'uniteartv' => $rowpp["uniteventeproduit"],
                                        'unitearts' => $rowpp["unitesortieproduit"]
                                ));
                                if (!empty($_SESSION["cart_prodvcex"])) {
                                    $f = FALSE;
                                    foreach ($_SESSION["cart_prodvcex"] as $k => $v) {
                                        if (($_SESSION["cart_prodvcex"][$k]["idart"] == $rowpp["idproduit"])) {
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

                            $proccc = (($rowpp["stockligneordonnance"] - $rowpp["stocklivreligneordonnance"]) - $rowpp["stockproduit"]);
                            $ligneok = FALSE;
                            $prodArray = array($rowpp["idligneordonnance"] => array(
                                    'idart' => $rowpp["idligneordonnance"],
                                    'idbout' => $rowp["idboutique"],
                                    'designationart' => $rowpp["libelleproduit"],
                                    'qteart' => $rowpp["stockproduit"],
                                    'prixarta' => $rowpp["prixachatproduit"],
                                    'prixartv' => $rowpp["prixventeproduit"],
                                    'prixartliv' => $prixliv,
                                    'unitearta' => $rowpp["uniteachatproduit"],
                                    'uniteartv' => $rowpp["uniteventeproduit"],
                                    'uniteartliv' => $rowpp["idunite"],
                                    'unitearts' => $rowpp["unitesortieproduit"],
                                    'stockok' => $ligneok
                            ));
                            $_SESSION["cart_prodlordp" . $id] = $prodArray;

                            $prodArrayc = array($rowpp["idproduit"] => array(
                                    'idart' => $rowpp["idproduit"],
                                    'designationart' => $rowpp["libelleproduit"],
                                    'qteart' => $proccc,
                                    'prixarta' => $rowpp["prixachatproduit"],
                                    'prixartv' => $rowpp["prixventeproduit"],
                                    'unitearta' => $rowpp["uniteachatproduit"],
                                    'uniteartv' => $rowpp["uniteventeproduit"],
                                    'unitearts' => $rowpp["unitesortieproduit"]
                            ));
                            if (!empty($_SESSION["cart_prodvcex"])) {
                                $f = FALSE;
                                foreach ($_SESSION["cart_prodvcex"] as $k => $v) {
                                    if (($_SESSION["cart_prodvcex"][$k]["idart"] == $rowpp["idproduit"])) {
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