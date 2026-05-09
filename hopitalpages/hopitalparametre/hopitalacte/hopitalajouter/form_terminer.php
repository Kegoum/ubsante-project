<?php
if (isset($_SESSION['formacte']) && $_SESSION['formacte'] != NULL) {
    inserer_acte($_SESSION['formacte'],$con);
} else {
    echo "<script language='javascript'>$('div.addnull').show('slow').delay(3000).hide('slow');</script>";
}
?>