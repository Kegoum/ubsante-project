<?php
if (isset($_SESSION['formparametre']) && $_SESSION['formparametre'] != NULL) {
    inserer_parametre($_SESSION['formparametre'],$con);
} else {
    echo "<script language='javascript'>$('div.addnull').show('slow').delay(3000).hide('slow');</script>";
}
?>