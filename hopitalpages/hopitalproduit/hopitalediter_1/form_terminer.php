<?php

if (isset($_SESSION['formprode']) && $_SESSION['formprode'] != NULL) {
    update_produit($_SESSION['formprode'],$con);
} else {
    echo "<script language='javascript'>$('div.alertaddnull').show('slow').delay(8000).hide('slow');</script>";
}
?>