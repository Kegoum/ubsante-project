<?php
if (isset($_SESSION['formmagasin']) && $_SESSION['formmagasin'] != NULL) {
    inserer_magasin($_SESSION['formmagasin'],$con);
} else {
    echo "<script language='javascript'>$('div.addnull').show('slow').delay(3000).hide('slow');</script>";
}
?>