
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

                $productparid = $con->query("select * from hp_produit as a where a.idproduit='" . $_GET["idp"] . "'");
                $rowp = mysqli_fetch_assoc($productparid);
                
                    $rsltuv2 = $con->query("select * from hp_conversion where idunite='" . $rowp["uniteventeproduit"] . "' and "
                            . "idproduit='" . $rowp["idproduit"] . "'") or die(mysqli_error($con));
                    $rowvv = mysqli_fetch_assoc($rsltuv2);
                    $pr = ($rowvv["prixconversion"]);
                
                $prodArray = array($rowp["idproduit"] => array(
                        'idart' => $rowp["idproduit"],
                        'designationart' => $rowp["libelleproduit"],
                        'qteart' => $qt,
                        'prixart' => $pr,
                        'uniteart' => $rowp["uniteventeproduit"]
                ));
                $ider = $rowp["idproduit"];

                if (!empty($_SESSION["cart_prodvsoina" . $idc])) {
                    $f = FALSE;
                    foreach ($_SESSION["cart_prodvsoina" . $idc] as $k => $v) {
                        if (($_SESSION["cart_prodvsoina" . $idc][$k]["idart"] == $_GET["idp"])) {
                            $f = TRUE;
                            $q = $_SESSION["cart_prodvsoina" . $idc][$k]["qteart"] + 1;
                            $_SESSION["cart_prodvsoina" . $idc][$k]["qteart"] = $_SESSION["cart_prodvsoina" . $idc][$k]["qteart"] + 1;
                        }
                    }
                    if (!$f) {
                        $_SESSION["cart_prodvsoina" . $idc] = array_merge($_SESSION["cart_prodvsoina" . $idc], $prodArray);
                    }
                } else {
                    $_SESSION["cart_prodvsoina" . $idc] = $prodArray;
                }

                die('<meta http-equiv="refresh" content="0; URL=' . $url . '?page=' . base64_encode($a) . '&idsoinpatient=' . $idc . '&pagecom=' . $stag . '">');
                break;
        }
    }
    ?>
</div>