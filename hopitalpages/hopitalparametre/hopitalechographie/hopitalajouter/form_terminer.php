<?php
if (isset($_SESSION['formechographie']) && $_SESSION['formechographie'] != NULL) {
    inserer_echographie($_SESSION['formechographie'],$con);
} else {
    echo "<script language='javascript'>$('div.addnull').show('slow').delay(3000).hide('slow');</script>";
}
?>