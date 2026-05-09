<?php

if (isset($_SESSION['formprodunite']) && $_SESSION['formprodunite'] != NULL) {
    inserer_unite_produit($_SESSION['formprodunite'],$con);
} else {
    echo "<script language='javascript'>$('div.alertaddnull').show('slow').delay(8000).hide('slow');</script>";
}
?>