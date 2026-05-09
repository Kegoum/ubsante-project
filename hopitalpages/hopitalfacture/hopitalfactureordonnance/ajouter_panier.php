
<div class="row">
    <?php
    $idc = $_REQUEST["idfacture"];
    $iiii = $_GET["idp"];
//    echo "<script language='javascript'>alert('ololok')</script>";
    if (!empty($_GET["actionp"])) {
        $a = 'hopitalpages/hopitalfacture/hopitalfactureordonnance/paie_facture_patient';
        $stag = 1;
        switch ($_GET["actionp"]) {
            case "add":
                $ligneok = TRUE;
                $productparid = $con->query("select * from hp_ligne_ordonnance as lo left join hp_produit as p on lo.idproduit=p.idproduit "
                        . "where lo.idligneordonnance='" . $_GET["idp"] . "'");
                $rowp = mysqli_fetch_assoc($productparid);
                $stocc = $rowp["stockligneordonnance"];
                $rsltuv2 = $con->query("select * from hp_conversion where idunite='" . $rowp["idunite"] . "' and "
                        . "idproduit='" . $rowp["idproduit"] . "'") or die(mysqli_error($con));
                $rowvv = mysqli_fetch_assoc($rsltuv2);
                $qt = $rowp["stockligneordonnance"];


                $pr = ($rowvv["prixconversion"]);
                $rsltuserb = $con->query("select SUM(mb.stockboutique) as stock from hp_boutique as mb where "
                        . "mb.idproduit='" . $rowp["idproduit"] . "' group by mb.idproduit") or die(mysqli_error($con));
                $nbb = mysqli_num_rows($rsltuserb);
                $qtes = 0;
                if ($nbb != 0) {
                    $recuserb = mysqli_fetch_assoc($rsltuserb);
                    if ($rowp["uniteventeproduit"] != $rowp["idunite"]) {
                        $rsltuv2b = $con->query("select * from hp_conversion where idunite='" . $rowp["uniteventeproduit"] . "' and "
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
                $prodArray = array($rowp["idligneordonnance"] => array(
                        'idart' => $rowp["idligneordonnance"],
                        'designationart' => $rowp["libelleproduit"],
                        'qteart' => $qt,
                        'prixart' => $pr,
                        'uniteart' => $rowp["idunite"],
                        'stockok' => $ligneok
                ));
                $ider = $rowp["idligneordonnance"];

                if (!empty($_SESSION["cart_prodvfactordo" . $idc])) {
                    $f = FALSE;
                    foreach ($_SESSION["cart_prodvfactordo" . $idc] as $k => $v) {
                        if (($_SESSION["cart_prodvfactordo" . $idc][$k]["idart"] == $_GET["idp"])) {
                            $f = TRUE;
                            $q = $_SESSION["cart_prodvfactordo" . $idc][$k]["qteart"] + 1;
                            if ($q > $qtes) {
                                $q = $qtes;
                            } else if ($q > $stocc) {
                                $q = $stocc;
                            }
                            $_SESSION["cart_prodvfactordo" . $idc][$k]["qteart"] = $q;
                        }
                    }
                    if (!$f) {
                        $_SESSION["cart_prodvfactordo" . $idc] = array_merge($_SESSION["cart_prodvfactordo" . $idc], $prodArray);
                    }
                } else {
                    $_SESSION["cart_prodvfactordo" . $idc] = $prodArray;
                }

                die('<meta http-equiv="refresh" content="0; URL=' . $url . '?page=' . base64_encode($a) . '&idfacture=' . $idc . '&pagecom=' . $stag . '">');
                break;
        }
    }
    ?>
</div>