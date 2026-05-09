
<div class="row">
    <?php
    $idc=$_REQUEST["idconsultation"];
//    echo "<script language='javascript'>alert('ololok')</script>";
    if (!empty($_GET["actionp"])) {
        $a = 'hopitalpages/hopitalpatient/hopitalconsultation/hopitalajouterplan/ajout_consultation';
    $stag = 2;
        switch ($_GET["actionp"]) {
            case "add":
                $qt = 1;
                
                $productparid = $con->query("select * from hp_produit as a left join hp_categorie as c on "
                        . "a.idcategorie=c.idcategorie where a.idproduit='" . $_GET["idp"] . "'");
                $rowp = mysqli_fetch_assoc($productparid);
                $rsltuar = $con->query("select * from hp_unite where idunite='" . $rowp["uniteventeproduit"] . "'") or die(mysqli_error($con));
                $rowar = mysqli_fetch_assoc($rsltuar);
                $idunit = $rowar["idunite"];
                $uniteart = $rowar["libelleunite"];
//                $pr1 = $rowp["prixventeproduit"];
                
                $rsltuarp = $con->query("select * from hp_conversion where idunite='" . $idunit . "' and "
                        . "idproduit='" . $_GET["idp"] . "'") or die(mysqli_error($con));
                $rowarp = mysqli_fetch_assoc($rsltuarp);
                $pr1 = $rowarp["prixconversion"];
                
                $pr = $pr1;
                $prodArray = array($rowp["idproduit"] => array(
                        'idart' => $rowp["idproduit"],
                        'designationart' => $rowp["libelleproduit"],
                        'qteart' => $qt,
                        'prixart' => $pr,
                        'idunit' => $idunit,
                        'uniteart' => $uniteart
                ));
                $ider = $rowp["idproduit"];

                if (!empty($_SESSION["cart_prodvordplan".$idc])) {
                    $f = FALSE;
                    foreach ($_SESSION["cart_prodvordplan".$idc] as $k => $v) {
                        if (($_SESSION["cart_prodvordplan".$idc][$k]["idart"] == $_GET["idp"])) {
                            $f = TRUE;
                            $q = $_SESSION["cart_prodvordplan".$idc][$k]["qteart"] + 1;
                            $_SESSION["cart_prodvordplan".$idc][$k]["qteart"] = $_SESSION["cart_prodvordplan".$idc][$k]["qteart"] + 1;
                        }
                    }
                    if (!$f) {
                        $_SESSION["cart_prodvordplan".$idc] = array_merge($_SESSION["cart_prodvordplan".$idc], $prodArray);
                    }
                } else {
                    $_SESSION["cart_prodvordplan".$idc] = $prodArray;
                }

               die('<meta http-equiv="refresh" content="0; URL=' . $url . '?page=' . base64_encode($a) . '&idconsultation=' . $idc . '&pagecom='.$stag.'">');
             break;
        }
    }
    ?>
</div>