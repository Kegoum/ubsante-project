<?php
if (isset($_SESSION['formunite']) && $_SESSION['formunite'] != NULL) {
    inserer_unite($_SESSION['formunite'],$con);
} else {
    echo "<script language='javascript'>$('div.addnull').show('slow').delay(3000).hide('slow');</script>";
}
?>