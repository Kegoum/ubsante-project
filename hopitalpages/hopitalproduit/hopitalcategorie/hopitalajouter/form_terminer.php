<?php
if (isset($_SESSION['formcategorie']) && $_SESSION['formcategorie'] != NULL) {
    inserer_categorie($_SESSION['formcategorie'],$con);
} else {
    echo "<script language='javascript'>$('div.addnull').show('slow').delay(3000).hide('slow');</script>";
}
?>