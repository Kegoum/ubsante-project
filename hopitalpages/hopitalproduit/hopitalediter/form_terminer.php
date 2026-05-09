<?php

if (isset($_SESSION['formproduite']) && $_SESSION['formproduite'] != NULL) {
    update_produit($_SESSION['formproduite'],$con);
} else {
    echo "<script language='javascript'>$('div.alertaddnull').show('slow').delay(8000).hide('slow');</script>";
}
?>