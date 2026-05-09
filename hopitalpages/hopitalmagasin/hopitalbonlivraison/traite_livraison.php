  
<?php

//        echo "<script language='javascript'>alert('okok')</script>";
    if (isset($_SESSION["cart_prodvlex"]) && $_SESSION["cart_prodvlex"] != NULL) {
        $nomfourn = "";
        if (isset($_POST["nomf"]) && ($_POST["nomf"]!=NULL)) {
//             echo "<script language='javascript'>alert('four')</script>";
            $nomfourn = trim(htmlspecialchars($_POST["nomf"]));
        }else{ 
//            echo "<script language='javascript'>alert('nonfour')</script>";
            $nomfourn = "Inconnu";
        }
        
//        print_r($_SESSION["cart_prodvlex"]);
        ajouter_livraison($_REQUEST["prixt"], $nomfourn, $_SESSION["cart_prodvlex"], $con);

//    ajouter_commande_client($_SESSION['formcom'],$con);
//    unset($_POST);unset($_SESSION['formcom']);
    } else {
        echo "<script language='javascript'>$('div.alertvoyagevide').show('slow').delay(8000).hide('slow');</script>";
    }
?>