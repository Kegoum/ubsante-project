
<div class="row">
    <?php
    $idc = $_REQUEST["idconsultation"];
//    echo "<script language='javascript'>alert('ololok')</script>";
    if (!empty($_GET["actionp"])) {
        $a = 'hopitalpages/hopitalpatient/hopitalconsultation/hopitalajouterplan/ajout_consultation';
        $stag = 2;
        switch ($_GET["actionp"]) {
            case "add":
                $qt = 1;

                $productparid = $con->query("select * from hp_soin as a where a.idsoin='" . $_GET["idp"] . "'");
                $rowp = mysqli_fetch_assoc($productparid);
                $rsltm = $con->query("select * from hp_ligne_soin as ls left join hp_produit as a on "
                        . "ls.idproduit=a.idproduit where ls.idsoin='" . $rowp["idsoin"] . "'") or die(mysqli_error($con));
                $prils = 0;
                while ($rows = mysqli_fetch_assoc($rsltm)) {
                    $rsltuv2 = $con->query("select * from hp_conversion where idunite='" . $rows["idunite"] . "' and "
                            . "idproduit='" . $rows["idproduit"] . "'") or die(mysqli_error($con));
                    $rowvv = mysqli_fetch_assoc($rsltuv2);
                    $prils = $prils + ($rows["quantitelignesoin"] * $rowvv["prixconversion"]);
                }
                $pr = $rowp["montantsoin"] + $prils;
                $datej = date('Y-m-d');
                $heur = date('H:i');
                $dosa=0;
                $inter=0;
                $perio=0;
                $prodArray = array($rowp["idsoin"] => array(
                        'idart' => $rowp["idsoin"],
                        'designationart' => $rowp["libellesoin"],
                        'qteart' => $qt,
                        'prixart' => $pr,
                        'dateart' => $datej,
                        'heureart' => $heur,
                        'dosageart' => $dosa,
                        'intervalleart' => $inter,
                        'periodeart' => $perio
                ));
                $ider = $rowp["idsoin"];

                if (!empty($_SESSION["cart_prodvhosplan" . $idc])) {
                    $f = FALSE;
                    foreach ($_SESSION["cart_prodvhosplan" . $idc] as $k => $v) {
                        if (($_SESSION["cart_prodvhosplan" . $idc][$k]["idart"] == $_GET["idp"])) {
                            $f = TRUE;
                            $q = $_SESSION["cart_prodvhosplan" . $idc][$k]["qteart"] + 1;
                            $_SESSION["cart_prodvhosplan" . $idc][$k]["qteart"] = $_SESSION["cart_prodvhosplan" . $idc][$k]["qteart"] + 1;
                        }
                    }
                    if (!$f) {
                        $_SESSION["cart_prodvhosplan" . $idc] = array_merge($_SESSION["cart_prodvhosplan" . $idc], $prodArray);
                    }
                } else {
                    $_SESSION["cart_prodvhosplan" . $idc] = $prodArray;
                }

                die('<meta http-equiv="refresh" content="0; URL=' . $url . '?page=' . base64_encode($a) . '&idconsultation=' . $idc . '&pagecom=' . $stag . '">');
                break;
        }
    }
    ?>
</div>