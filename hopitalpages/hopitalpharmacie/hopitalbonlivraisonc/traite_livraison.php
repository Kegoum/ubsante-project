  
<?php
if (isset($_REQUEST["boncommande"])) {
    $id = $_REQUEST["boncommande"];

//        echo "<script language='javascript'>alert('okok')</script>";
    if (isset($_SESSION["cart_prodvlibc".$id]) && $_SESSION["cart_prodvlibc".$id] != NULL) {
//        print_r($_SESSION["cart_prodvlibc".$id]);
        ajouter_livraisonc_pharmacie($id, $_REQUEST["prixt"], $_SESSION["cart_prodvlibc".$id], $con);

//    ajouter_commande_client($_SESSION['formcom'],$con);
//    unset($_POST);unset($_SESSION['formcom']);
    } else {
        echo "<script language='javascript'>$('div.alertvoyagevide').show('slow').delay(8000).hide('slow');</script>";
    }
}
?>