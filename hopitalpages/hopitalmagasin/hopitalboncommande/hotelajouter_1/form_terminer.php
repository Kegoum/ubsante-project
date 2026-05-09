<?php

if (isset($_SESSION['formprod']) && $_SESSION['formprod'] != NULL) {
    inserer_produit_commande($_SESSION['formprod'],$con);
} else {
    echo "<script language='javascript'>$('div.alertaddnull').show('slow').delay(8000).hide('slow');</script>";
}
?>