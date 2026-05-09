
<div class="row">
    <?php
    $idc = $_REQUEST["idfacture"];
    $iiii = $_GET["idp"];
//    echo "<script language='javascript'>alert('ololok')</script>";
    if (!empty($_GET["actionp"])) {
        $a = 'hopitalpages/hopitalfacture/hopitalfacturesoinpatient/paie_facture_patient';
        $stag = 1;
        switch ($_GET["actionp"]) {
            case "add":
                $ligneok = TRUE;
                $productparid = $con->query("select * from hp_ligne_soin_patient as lo left join hp_produit as p on lo.idproduit=p.idproduit "
                        . "where lo.idlignesoinpatient='" . $_GET["idp"] . "'");
                $rowp = mysqli_fetch_assoc($productparid);
                $stocc = $rowp["quantitelignesoinpatient"];
                $rsltuv2 = $con->query("select * from hp_conversion where idunite='" . $rowp["idunite"] . "' and "
                        . "idproduit='" . $rowp["idproduit"] . "'") or die(mysqli_error($con));
                $rowvv = mysqli_fetch_assoc($rsltuv2);
                $qt = $rowp["quantitelignesoinpatient"];


                $pr = ($rowvv["prixconversion"]);
                $rsltuserb = $con->query("select SUM(mb.stockboutique) as stock from hp_boutique as mb where "
                        . "mb.idproduit='" . $rowp["idproduit"] . "' group by mb.idproduit") or die(mysqli_error($con));
                $nbb = mysqli_num_rows($rsltuserb);
                $qtes = 0;
                if ($nbb != 0) {
                    $recuserb = mysqli_fetch_assoc($rsltuserb);
                    if ($recuserb["idunite"] != $rowp["idunite"]) {
                        $rsltuv2b = $con->query("select * from hp_conversion where idunite='" . $recuserb["idunite"] . "' and "
                                . "idproduit='" . $rowp["idproduit"] . "'") or die(mysqli_error($con));
                        $rowvvb = mysqli_fetch_assoc($rsltuv2b);
                        if ($rowvvb["conversion"] != 0) {
                            $qtes = $qtes + (($recuserb["stock"]) * ($rowvv["conversion"]) / $rowvvb["conversion"]);
                        }
                    } else {
                        $qtes = $qtes + (($recuserb["stock"]));
                    }
                }
                if ($qt > $qtes) {

                    if ($rowp["uniteventeproduit"] != $rowp["idunite"]) {
                        $rsltuv2b = $con->query("select * from hp_conversion where idunite='" . $rowp["uniteventeproduit"] . "' and "
                                . "idproduit='" . $rowp["idproduit"] . "'") or die(mysqli_error($con));
                        $rowvvb = mysqli_fetch_assoc($rsltuv2b);
                        if ($rowvvb["conversion"] != 0) {
                            $qtes = $qtes + (($rowvv["stockconversion"]) * ($rowvv["conversion"]) / $rowvvb["conversion"]);
                        }
                    } else {
                        $qtes = $qtes + (($rowvv["stockconversion"]));
                    }
                }
                if ($qt > $qtes) {
                    $qt = $qtes;
                }
                $prodArray = array($rowp["idlignesoinpatient"] => array(
                        'idart' => $rowp["idlignesoinpatient"],
                        'designationart' => $rowp["libelleproduit"],
                        'qteart' => $qt,
                        'prixart' => $pr,
                        'uniteart' => $rowp["idunite"],
                        'stockok' => $ligneok
                ));
                $ider = $rowp["idligneordonnance"];

                if (!empty($_SESSION["cart_prodvfactsopa" . $idc])) {
                    $f = FALSE;
                    foreach ($_SESSION["cart_prodvfactsopa" . $idc] as $k => $v) {
                        if (($_SESSION["cart_prodvfactsopa" . $idc][$k]["idart"] == $_GET["idp"])) {
                            $f = TRUE;
                            $q = $_SESSION["cart_prodvfactsopa" . $idc][$k]["qteart"] + 1;
                            if ($q > $qtes) {
                                $q = $qtes;
                            } else if ($q > $stocc) {
                                $q = $stocc;
                            }
                            $_SESSION["cart_prodvfactsopa" . $idc][$k]["qteart"] = $q;
                        }
                    }
                    if (!$f) {
                        $_SESSION["cart_prodvfactsopa" . $idc] = array_merge($_SESSION["cart_prodvfactsopa" . $idc], $prodArray);
                    }
                } else {
                    $_SESSION["cart_prodvfactsopa" . $idc] = $prodArray;
                }

                die('<meta http-equiv="refresh" content="0; URL=' . $url . '?page=' . base64_encode($a) . '&idfacture=' . $idc . '&pagecom=' . $stag . '">');
                break;
        }
    }
    ?>
</div>