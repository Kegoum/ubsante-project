
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
                
                $productparid = $con->query("select * from hp_examen as a where a.idexamen='" . $_GET["idp"] . "'");
                $rowp = mysqli_fetch_assoc($productparid);
                $rsltuar = $con->query("select * from hp_unite where idunite='" . $rowp["idunite"] . "'") or die(mysqli_error($con));
                $rowar = mysqli_fetch_assoc($rsltuar);
                $idunit = $rowar["idunite"];
                $uniteart = $rowar["libelleunite"];
//                $pr1 = $rowp["prixventeexamen"];
                
                $pr = $rowp["prixexamen"];
                $prodArray = array($rowp["idexamen"] => array(
                        'idart' => $rowp["idexamen"],
                        'designationart' => $rowp["nomexamen"],
                        'qteart' => $qt,
                        'prixart' => $pr,
                        'idunit' => $idunit,
                        'uniteart' => $uniteart
                ));
                $ider = $rowp["idexamen"];

                if (!empty($_SESSION["cart_prodvexaplan".$idc])) {
                    $f = FALSE;
                    foreach ($_SESSION["cart_prodvexaplan".$idc] as $k => $v) {
                        if (($_SESSION["cart_prodvexaplan".$idc][$k]["idart"] == $_GET["idp"])) {
                            $f = TRUE;
                            $q = $_SESSION["cart_prodvexaplan".$idc][$k]["qteart"] + 1;
                            $_SESSION["cart_prodvexaplan".$idc][$k]["qteart"] = $_SESSION["cart_prodvexaplan".$idc][$k]["qteart"] + 1;
                        }
                    }
                    if (!$f) {
                        $_SESSION["cart_prodvexaplan".$idc] = array_merge($_SESSION["cart_prodvexaplan".$idc], $prodArray);
                    }
                } else {
                    $_SESSION["cart_prodvexaplan".$idc] = $prodArray;
                }

               die('<meta http-equiv="refresh" content="0; URL=' . $url . '?page=' . base64_encode($a) . '&idconsultation=' . $idc . '&pagecom='.$stag.'">');
             break;
        }
    }
    ?>
</div>