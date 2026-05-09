
<div class="row">
    <?php
    if (!empty($_GET["actionp"])) {
        $a = 'hopitalpages/hopitalpatient/hopitalsortiesoinpatient/sortiesoin_patient';

        $id = $_REQUEST["soinpatient"];
        switch ($_GET["actionp"]) {
            case "add":
                $ligneok = TRUE;
                $productparidp = $con->query("select * from hp_ligne_soin_patient as lbl left join "
                        . "hp_produit as a on lbl.idproduit=a.idproduit left join hp_categorie as c "
                        . "on a.idcategorie=c.idcategorie where lbl.idlignesoinpatient='" . $_GET["idp"] . "'");
                $rowpp = mysqli_fetch_assoc($productparidp);
                
                $productparid = $con->query("select * from hp_boutique as lbl where lbl.idproduit='" . $rowpp["idproduit"] . "'");
                $rowp = mysqli_fetch_assoc($productparid);
                $qt = ($rowpp["quantitelignesoinpatient"] - (int)($rowpp["quantitelivrelignesoinpatient"]));
                $rsltuarp = $con->query("select * from hp_conversion where idunite='" . $rowpp["idunitesoinpatient"] . "' "
                        . "and idproduit='" . $rowpp["idproduit"] . "'") or die(mysqli_error($con));
                $rowarp = mysqli_fetch_assoc($rsltuarp);
//                $prixliv = $rowpp["prixventeproduit"];
////                    echo"<script language='javascript'>alert($pv)</script>";
//                if ($rowpp["idunitesoinpatient"] != $rowpp["uniteventeproduit"]) {
                    $prixliv = $rowarp["prixconversion"];
//                } else {
//                    $prixliv = $rowpp["prixventeproduit"];
//                }
                    $pppp=$rowpp["libelleproduit"];
                    echo "<script language='javascript'>alert($pppp)</script>";
    
                $prodArray = array($rowpp["idlignesoinpatient"] => array(
                        'idart' => $rowpp["idlignesoinpatient"],
                        'idbout' => $rowp["idboutique"],
                        'designationart' => $rowpp["libelleproduit"],
                        'qteart' => $qt,
                        'prixarta' => $rowpp["prixachatproduit"],
                        'prixartv' => $rowpp["prixventeproduit"],
                        'prixartliv' => $prixliv,
                        'unitearta' => $rowpp["uniteachatproduit"],
                        'uniteartv' => $rowpp["uniteventeproduit"],
                        'uniteartliv' => $rowpp["idunitesoinpatient"],
                        'unitearts' => $rowpp["unitesortieproduit"],
                        'stockok' => $ligneok
                ));
                
                if (!empty($_SESSION["cart_prodlsosop" . $id])) {
                    $f = FALSE;
                    foreach ($_SESSION["cart_prodlsosop" . $id] as $k => $v) {
                        if (($_SESSION["cart_prodlsosop" . $id][$k]["idart"] == $_GET["idp"])) {
                            $f = TRUE;
                            $q = $_SESSION["cart_prodlsosop" . $id][$k]["qteart"] + $qt;
                            if (($rowpp["quantitelignesoinpatient"] - $rowpp["quantitelivrelignesoinpatient"]) <= $q) {
                                $q = ($rowpp["quantitelignesoinpatient"] - $rowpp["quantitelivrelignesoinpatient"]);
                            }

                            if ($rowpp["stockproduit"] >= $q) {
                                $_SESSION["cart_prodlsosop" . $id][$k]["qteart"] = $q;
                            } else {
                                $rsltuarpa = $con->query("select * from hp_conversion where idunite='" . $rowpp["idunitesoinpatient"] . "' "
                                        . "and idproduit='" . $rowpp["idproduit"] . "'") or die(mysqli_error($con));
                                $npharmaciepa = mysqli_num_rows($rsltuarpa);

                                $rowarpa = mysqli_fetch_assoc($rsltuarpa);
                                if ($npharmaciepa != 0) {
                                    if ($rowpp["quantitelignesoinpatient"] > $rowarpa["stockconversion"]) {
                                        $pro = $rowarpa["stockconversion"];
                                        $_SESSION["cart_prodlsosop" . $id][$k]["qteart"] = $pro;

                                        $proccc = (($rowpp["quantitelignesoinpatient"] - $rowpp["quantitelivrelignesoinpatient"]) - $rowarpa["stockconversion"]);
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
                                        $_SESSION["cart_prodlsosop" . $id][$k]["qteart"] = $q;
                                    }
                                } else {
                                    $pro = $rowpp["stockproduit"];
                                    $_SESSION["cart_prodlsosop" . $id][$k]["qteart"] = $pro;

                                    $proccc = (($rowpp["quantitelignesoinpatient"] - $rowpp["quantitelivrelignesoinpatient"]) - $rowpp["stockproduit"]);
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
                            $_SESSION["cart_prodlsosop" . $id] = array_merge($_SESSION["cart_prodlsosop" . $id], $prodArray);
                        } else {

                            $rsltuarpa = $con->query("select * from hp_conversion where idunite='" . $rowpp["idunitesoinpatient"] . "' "
                                    . "and idproduit='" . $rowpp["idproduit"] . "'") or die(mysqli_error($con));
                            $npharmaciepa = mysqli_num_rows($rsltuarpa);

                            $rowarpa = mysqli_fetch_assoc($rsltuarpa);
                            if ($npharmaciepa != 0) {
                                if ($rowpp["quantitelignesoinpatient"] > $rowarpa["stockconversion"]) {
                                    $proccc = (($rowpp["quantitelignesoinpatient"] - $rowpp["quantitelivrelignesoinpatient"]) - $rowarpa["stockconversion"]);
                                    $ligneok = FALSE;
                                    $prodArray = array($rowpp["idlignesoinpatient"] => array(
                                            'idart' => $rowpp["idlignesoinpatient"],
                                            'idbout' => $rowp["idboutique"],
                                            'designationart' => $rowpp["libelleproduit"],
                                            'qteart' => $rowarpa["stockconversion"],
                                            'prixarta' => $rowpp["prixachatproduit"],
                                            'prixartv' => $rowpp["prixventeproduit"],
                                            'prixartliv' => $prixliv,
                                            'unitearta' => $rowpp["uniteachatproduit"],
                                            'uniteartv' => $rowpp["uniteventeproduit"],
                                            'uniteartliv' => $rowpp["idunitesoinpatient"],
                                            'unitearts' => $rowpp["unitesortieproduit"],
                                            'stockok' => $ligneok
                                    ));
                                    $_SESSION["cart_prodlsosop" . $id] = array_merge($_SESSION["cart_prodlsosop" . $id], $prodArray);

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
                                    $_SESSION["cart_prodlsosop" . $id] = array_merge($_SESSION["cart_prodlsosop" . $id], $prodArray);
                                }
                            } else {
                                $proccc = (($rowpp["quantitelignesoinpatient"] - $rowpp["quantitelivrelignesoinpatient"]) - $rowpp["stockproduit"]);
                                $ligneok = FALSE;
                                $prodArray = array($rowpp["idlignesoinpatient"] => array(
                                        'idart' => $rowpp["idlignesoinpatient"],
                                        'idbout' => $rowp["idboutique"],
                                        'designationart' => $rowpp["libelleproduit"],
                                        'qteart' => $rowpp["stockproduit"],
                                        'prixarta' => $rowpp["prixachatproduit"],
                                        'prixartv' => $rowpp["prixventeproduit"],
                                        'prixartliv' => $prixliv,
                                        'unitearta' => $rowpp["uniteachatproduit"],
                                        'uniteartv' => $rowpp["uniteventeproduit"],
                                        'uniteartliv' => $rowpp["idunitesoinpatient"],
                                        'unitearts' => $rowpp["unitesortieproduit"],
                                        'stockok' => $ligneok
                                ));
                                $_SESSION["cart_prodlsosop" . $id] = array_merge($_SESSION["cart_prodlsosop" . $id], $prodArray);

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
                        $_SESSION["cart_prodlsosop" . $id] = $prodArray;
                    } else {

                        $rsltuarpa = $con->query("select * from hp_conversion where idunite='" . $rowpp["idunitesoinpatient"] . "' "
                                . "and idproduit='" . $rowpp["idproduit"] . "'") or die(mysqli_error($con));
                        $npharmaciepa = mysqli_num_rows($rsltuarpa);

                        $rowarpa = mysqli_fetch_assoc($rsltuarpa);
                        if ($npharmaciepa != 0) {
                            if ($rowpp["quantitelignesoinpatient"] > $rowarpa["stockconversion"]) {

                                $proccc = (($rowpp["quantitelignesoinpatient"] - $rowpp["quantitelivrelignesoinpatient"]) - $rowarpa["stockconversion"]);
                                $ligneok = FALSE;
                                $prodArray = array($rowpp["idlignesoinpatient"] => array(
                                        'idart' => $rowpp["idlignesoinpatient"],
                                        'idbout' => $rowp["idboutique"],
                                        'designationart' => $rowpp["libelleproduit"],
                                        'qteart' => $rowarpa["stockconversion"],
                                        'prixarta' => $rowpp["prixachatproduit"],
                                        'prixartv' => $rowpp["prixventeproduit"],
                                        'prixartliv' => $prixliv,
                                        'unitearta' => $rowpp["uniteachatproduit"],
                                        'uniteartv' => $rowpp["uniteventeproduit"],
                                        'uniteartliv' => $rowpp["idunitesoinpatient"],
                                        'unitearts' => $rowpp["unitesortieproduit"],
                                        'stockok' => $ligneok
                                ));
                                $_SESSION["cart_prodlsosop" . $id] = $prodArray;

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
                                $_SESSION["cart_prodlsosop" . $id] = $prodArray;
                            }
                        } else {

                            $proccc = (($rowpp["quantitelignesoinpatient"] - $rowpp["quantitelivrelignesoinpatient"]) - $rowpp["stockproduit"]);
                            $ligneok = FALSE;
                            $prodArray = array($rowpp["idlignesoinpatient"] => array(
                                    'idart' => $rowpp["idlignesoinpatient"],
                                    'idbout' => $rowp["idboutique"],
                                    'designationart' => $rowpp["libelleproduit"],
                                    'qteart' => $rowpp["stockproduit"],
                                    'prixarta' => $rowpp["prixachatproduit"],
                                    'prixartv' => $rowpp["prixventeproduit"],
                                    'prixartliv' => $prixliv,
                                    'unitearta' => $rowpp["uniteachatproduit"],
                                    'uniteartv' => $rowpp["uniteventeproduit"],
                                    'uniteartliv' => $rowpp["idunitesoinpatient"],
                                    'unitearts' => $rowpp["unitesortieproduit"],
                                    'stockok' => $ligneok
                            ));
                            $_SESSION["cart_prodlsosop" . $id] = $prodArray;

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

                die('<meta http-equiv="refresh" content="0; URL='.$url.'?page=' . base64_encode($a) . '&soinpatient=' . $id . '">');
                break;
        }
    }
    ?>
</div>