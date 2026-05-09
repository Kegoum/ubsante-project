
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
                
                $productparid = $con->query("select * from hp_acte as a where a.idacte='" . $_GET["idp"] . "'");
                $rowp = mysqli_fetch_assoc($productparid);
//                $pr1 = $rowp["prixventeacte"];
                
                $pr = $rowp["prixacte"];
                $prodArray = array($rowp["idacte"] => array(
                        'idart' => $rowp["idacte"],
                        'designationart' => $rowp["libelleacte"],
                        'qteart' => $qt,
                        'prixart' => $pr
                ));
                $ider = $rowp["idacte"];

                if (!empty($_SESSION["cart_prodvactplan".$idc])) {
                    $f = FALSE;
                    foreach ($_SESSION["cart_prodvactplan".$idc] as $k => $v) {
                        if (($_SESSION["cart_prodvactplan".$idc][$k]["idart"] == $_GET["idp"])) {
                            $f = TRUE;
                            $q = $_SESSION["cart_prodvactplan".$idc][$k]["qteart"] + 1;
                            $_SESSION["cart_prodvactplan".$idc][$k]["qteart"] = $_SESSION["cart_prodvactplan".$idc][$k]["qteart"] + 1;
                        }
                    }
                    if (!$f) {
                        $_SESSION["cart_prodvactplan".$idc] = array_merge($_SESSION["cart_prodvactplan".$idc], $prodArray);
                    }
                } else {
                    $_SESSION["cart_prodvactplan".$idc] = $prodArray;
                }

               die('<meta http-equiv="refresh" content="0; URL=' . $url . '?page=' . base64_encode($a) . '&idconsultation=' . $idc . '&pagecom='.$stag.'">');
             break;
        }
    }
    ?>
</div>