
<div class="row">
    <?php
    $idc=$_REQUEST["idconsultation"];
//    echo "<script language='javascript'>alert('ololok')</script>";
    if (!empty($_GET["actionp"])) {
        $a = 'hopitalpages/hopitalpatient/hopitalconsultation/hopitalajouter/ajout_consultation';
    $stag = 3;
        switch ($_GET["actionp"]) {
            case "add":
                $qt = 1;
                
                $productparid = $con->query("select * from hp_echographie as a where a.idechographie='" . $_GET["idp"] . "'");
                $rowp = mysqli_fetch_assoc($productparid);
//                $pr1 = $rowp["prixventeechographie"];
                
                $pr = $rowp["prixechographie"];
                $prodArray = array($rowp["idechographie"] => array(
                        'idart' => $rowp["idechographie"],
                        'designationart' => $rowp["nomechographie"],
                        'qteart' => $qt,
                        'prixart' => $pr
                ));
                $ider = $rowp["idechographie"];

                if (!empty($_SESSION["cart_prodvecho".$idc])) {
                    $f = FALSE;
                    foreach ($_SESSION["cart_prodvecho".$idc] as $k => $v) {
                        if (($_SESSION["cart_prodvecho".$idc][$k]["idart"] == $_GET["idp"])) {
                            $f = TRUE;
                            $q = $_SESSION["cart_prodvecho".$idc][$k]["qteart"] + 1;
                            $_SESSION["cart_prodvecho".$idc][$k]["qteart"] = $_SESSION["cart_prodvecho".$idc][$k]["qteart"] + 1;
                        }
                    }
                    if (!$f) {
                        $_SESSION["cart_prodvecho".$idc] = array_merge($_SESSION["cart_prodvecho".$idc], $prodArray);
                    }
                } else {
                    $_SESSION["cart_prodvecho".$idc] = $prodArray;
                }

               die('<meta http-equiv="refresh" content="0; URL=' . $url . '?page=' . base64_encode($a) . '&idconsultation=' . $idc . '&pagecom='.$stag.'">');
             break;
        }
    }
    ?>
</div>