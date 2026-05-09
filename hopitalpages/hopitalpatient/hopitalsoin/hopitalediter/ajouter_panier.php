
<div class="row">
    <?php
    $idc = $_REQUEST["idsoinpatient"];
//    echo "<script language='javascript'>alert('ololok')</script>";
    if (!empty($_GET["actionp"])) {
        $a = 'hopitalpages/hopitalpatient/hopitalsoin/hopitalediter/edit_soin';
        $stag = 1;
        switch ($_GET["actionp"]) {
            case "add":
                $qt = 1;
                $rsltp = $con->query("select * from hp_produit as a left join hp_categorie as c on "
                        . "a.idcategorie=c.idcategorie where a.idproduit='" . $_GET["idp"] . "'") or die(mysqli_error($con));
                $rowp = mysqli_fetch_assoc($rsltp);
                $rsltuserb = $con->query("select SUM(mb.stockboutique) as stock from hp_boutique as mb where "
                        . "mb.idproduit='" . $_GET["idp"] . "' group by mb.idproduit") or die(mysqli_error($con));
                $nbb = mysqli_num_rows($rsltuserb);
                $rsltuv2 = $con->query("select * from hp_conversion where idunite='" . $rowp["uniteventeproduit"] . "' and "
                        . "idproduit='" . $_GET["idp"] . "'") or die(mysqli_error($con));
                $rowvv = mysqli_fetch_assoc($rsltuv2);

                $pr = ($rowvv["prixconversion"]);
                $qtes = 0;
                if ($nbb != 0) {
                    $recuserb = mysqli_fetch_assoc($rsltuserb);

                    $qtes = $qtes + (($recuserb["stock"]));
                }
                if ($qt > $qtes) {
                    $qtes = $qtes + (($rowvv["stockconversion"]));
                }
                if ($qt > $qtes) {
                    $qt = $qtes;
                }


                $prodArray = array($rowp["idproduit"] => array(
                        'idart' => $rowp["idproduit"],
                        'designationart' => $rowp["libelleproduit"],
                        'qteart' => $qt,
                        'prixart' => $pr,
                        'uniteart' => $rowp["uniteventeproduit"]
                ));
                $ider = $rowp["idproduit"];

                if (!empty($_SESSION["cart_prodvsoine" . $idc])) {
                    $f = FALSE;
                    foreach ($_SESSION["cart_prodvsoine" . $idc] as $k => $v) {
                        if (($_SESSION["cart_prodvsoine" . $idc][$k]["idart"] == $_GET["idp"])) {
                            $f = TRUE;
//                            $q = $_SESSION["cart_prodvsoine" . $idc][$k]["qteart"] + 1;
//                            $_SESSION["cart_prodvsoine" . $idc][$k]["qteart"] = $_SESSION["cart_prodvsoine" . $idc][$k]["qteart"] + 1;
                        }
                    }
                    if (!$f) {
                        $_SESSION["cart_prodvsoine" . $idc] = array_merge($_SESSION["cart_prodvsoine" . $idc], $prodArray);
                    }
                } else {
                    $_SESSION["cart_prodvsoine" . $idc] = $prodArray;
                }

                die('<meta http-equiv="refresh" content="0; URL=' . $url . '?page=' . base64_encode($a) . '&idsoinpatient=' . $idc . '&pagecom=' . $stag . '">');
                break;
        }
    }
    ?>
</div>