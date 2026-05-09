  
<?php
if (isset($_REQUEST["idfacture"])) {
    $id = $_REQUEST["idfacture"];

//        echo "<script language='javascript'>alert('okok')</script>";
    if (isset($_SESSION["cart_prodvfactordo".$id]) && $_SESSION["cart_prodvfactordo".$id] != NULL) {
//        print_r($_SESSION["cart_prodvfactordo".$id]);
        $versa = trim(htmlspecialchars($_POST["versa"]));
        $montvers= trim(htmlspecialchars($_POST["montvers"]));
        $montt = trim(htmlspecialchars($_POST["montt"]));
        $reste= trim(htmlspecialchars($_POST["reste"]));
        $paiement = trim(htmlspecialchars($_POST["paiement"]));
        $datejour= trim(htmlspecialchars($_POST["datejour"]));
       
        inserer_facture_ordonnance_patient($id, $montvers, $montt, $paiement, $datejour, $_SESSION["cart_prodvfactordo".$id], $con);

//    ajouter_commande_client($_SESSION['formcom'],$con);
//    unset($_POST);unset($_SESSION['formcom']);
    } else {
        echo "<script language='javascript'>$('div.alertvoyagevide').show('slow').delay(8000).hide('slow');</script>";
    }
}
?>