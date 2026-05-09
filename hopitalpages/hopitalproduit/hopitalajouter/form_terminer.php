<?php

if (isset($_SESSION['formproduit']) && $_SESSION['formproduit'] != NULL) {
    inserer_produit($_SESSION['formproduit'],$con);
} else {
    echo "<script language='javascript'>$('div.alertaddnull').show('slow').delay(8000).hide('slow');</script>";
}
?>