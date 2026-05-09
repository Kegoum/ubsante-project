  
<?php

//        echo "<script language='javascript'>alert('okok')</script>";
    if (isset($_SESSION["cart_prodvcib"]) && $_SESSION["cart_prodvcib"] != NULL) {
//        print_r($_SESSION["cart_prodvcib"]);
        ajouter_commande_pharmacie($_REQUEST["prixt"], $_SESSION["cart_prodvcib"], $con);

//    ajouter_commande_client($_SESSION['formcom'],$con);
//    unset($_POST);unset($_SESSION['formcom']);
    } else {
        echo "<script language='javascript'>$('div.alertvoyagevide').show('slow').delay(8000).hide('slow');</script>";
    }
?>