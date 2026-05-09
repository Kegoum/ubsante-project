  
<?php

//        echo "<script language='javascript'>alert('okok')</script>";
if (isset($_REQUEST["soinpatient"])) {
    $id = $_REQUEST["soinpatient"];
    if (isset($_SESSION["cart_prodlsosop" . $id]) && $_SESSION["cart_prodlsosop" . $id] != NULL) {
//        print_r($_SESSION["cart_prodlsosop" . $id]);
        ajouter_sortiesoin_patient($_REQUEST["soinpatient"], $_REQUEST["prixt"], $_SESSION["cart_prodlsosop" . $id], $con);

//    ajouter_commande_patient($_SESSION['formcom'],$con);
//    unset($_POST);unset($_SESSION['formcom']);
    } else {
        echo "<script language='javascript'>$('div.alertvoyagevide').show('slow').delay(8000).hide('slow');</script>";
    }
}
?>