<?php
if (isset($_SESSION['formcaisse']) && $_SESSION['formcaisse'] != NULL) {
    inserer_caisse($_SESSION['formcaisse'],$con);
} else {
    echo "<script language='javascript'>$('div.addnull').show('slow').delay(3000).hide('slow');</script>";
}
?>