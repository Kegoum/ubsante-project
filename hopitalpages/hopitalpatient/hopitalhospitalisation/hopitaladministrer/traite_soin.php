  
<?php
if (isset($_REQUEST["idsoinpatient"])) {
    $id = $_REQUEST["idsoinpatient"];

//        echo "<script language='javascript'>alert('okok')</script>";
    if (isset($_SESSION["cart_prodvsoina".$id]) && $_SESSION["cart_prodvsoina".$id] != NULL) {
//        print_r($_SESSION["cart_prodvsoina".$id]);
        $datef = trim(htmlspecialchars($_POST["datef"]));
        $heuref= trim(htmlspecialchars($_POST["heuref"]));
       
        administrer_soin_patient($id, $_REQUEST["prixt"], $datef, $heuref, $_SESSION["cart_prodvsoina".$id], $con);

//    ajouter_commande_client($_SESSION['formcom'],$con);
//    unset($_POST);unset($_SESSION['formcom']);
    } else {
        echo "<script language='javascript'>$('div.alertvoyagevide').show('slow').delay(8000).hide('slow');</script>";
    }
}
?>