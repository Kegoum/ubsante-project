  
<?php

//        echo "<script language='javascript'>alert('okok')</script>";
if (isset($_REQUEST["client"])) {
    $id = $_REQUEST["client"];
    if (isset($_SESSION["cart_prodvb" . $id]) && $_SESSION["cart_prodvb" . $id] != NULL) {
//        print_r($_SESSION["cart_prodvb" . $id]);
        ajouter_commande_bar_client($_REQUEST["client"], $_REQUEST["prixt"], $_SESSION["cart_prodvb" . $id], $con);

//    ajouter_commande_client($_SESSION['formcom'],$con);
//    unset($_POST);unset($_SESSION['formcom']);
    } else {
        echo "<script language='javascript'>$('div.alertvoyagevide').show('slow').delay(8000).hide('slow');</script>";
    }
}
?>