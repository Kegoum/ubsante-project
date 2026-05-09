  
<?php
if (isset($_REQUEST["boncommande"])) {
    $id = $_REQUEST["boncommande"];

//        echo "<script language='javascript'>alert('okok')</script>";
    if (isset($_SESSION["cart_prodvlebc".$id]) && $_SESSION["cart_prodvlebc".$id] != NULL) {
//        print_r($_SESSION["cart_prodvlebc".$id]);
        $nomfourn = "";
        if (isset($_POST["nomf"]) && ($_POST["nomf"]!=NULL)) {
//             echo "<script language='javascript'>alert('four')</script>";
            $nomfourn = trim(htmlspecialchars($_POST["nomf"]));
        }else{ 
//            echo "<script language='javascript'>alert('nonfour')</script>";
            $nomfourn = "Inconnu";
        }
        $transp=0;
        if ((isset($_POST["nomf"]) && ($_POST["nomf"]!=NULL) && ($_POST["transport"]!=''))) {
            $transp=  floatval($_POST["transport"]);
        }
        ajouter_livraisonc_externe($id, $_REQUEST["prixt"], $transp, $nomfourn, $_SESSION["cart_prodvlebc".$id], $con);

//    ajouter_commande_client($_SESSION['formcom'],$con);
//    unset($_POST);unset($_SESSION['formcom']);
    } else {
        echo "<script language='javascript'>$('div.alertvoyagevide').show('slow').delay(8000).hide('slow');</script>";
    }
}
?>