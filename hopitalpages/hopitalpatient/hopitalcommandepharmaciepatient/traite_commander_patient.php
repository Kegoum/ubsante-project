  
<?php

//        echo "<script language='javascript'>alert('okok')</script>";
if (isset($_REQUEST["ordonnance"])) {
    $id = $_REQUEST["ordonnance"];
    if (isset($_SESSION["cart_prodlordp" . $id]) && $_SESSION["cart_prodlordp" . $id] != NULL) {
//        print_r($_SESSION["cart_prodlordp" . $id]);
        ajouter_commande_pharmacie_patient($_REQUEST["ordonnance"], $_REQUEST["prixt"], $_SESSION["cart_prodlordp" . $id], $con);

//    ajouter_commande_patient($_SESSION['formcom'],$con);
//    unset($_POST);unset($_SESSION['formcom']);
    } else {
        echo "<script language='javascript'>$('div.alertvoyagevide').show('slow').delay(8000).hide('slow');</script>";
    }
}
?>