<?php
if (isset($_SESSION['formservice']) && $_SESSION['formservice'] != NULL) {
    inserer_service($_SESSION['formservice'],$con);
} else {
    echo "<script language='javascript'>$('div.addnull').show('slow').delay(3000).hide('slow');</script>";
}
?>