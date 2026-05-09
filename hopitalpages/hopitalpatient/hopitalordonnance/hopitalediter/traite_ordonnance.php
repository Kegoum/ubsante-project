  
<?php
if (isset($_REQUEST["idordonnance"])) {
    $id = $_REQUEST["idordonnance"];

//        echo "<script language='javascript'>alert('okok')</script>";
    if (isset($_SESSION["cart_prodvordoe".$id]) && $_SESSION["cart_prodvordoe".$id] != NULL) {
//        print_r($_SESSION["cart_prodvordoe".$id]);
//        $datef = trim(htmlspecialchars($_POST["datef"]));
//        $heuref= trim(htmlspecialchars($_POST["heuref"]));
       
        modifier_ordonnance($id, $_REQUEST["prixt"], $_SESSION["cart_prodvordoe".$id], $con);

//    ajouter_commande_client($_SESSION['formcom'],$con);
//    unset($_POST);unset($_SESSION['formcom']);
    } else {
        echo "<script language='javascript'>$('div.alertvoyagevide').show('slow').delay(8000).hide('slow');</script>";
    }
}
?>