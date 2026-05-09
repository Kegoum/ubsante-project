<?php
if (isset($_SESSION['formexamen']) && $_SESSION['formexamen'] != NULL) {
    inserer_examen($_SESSION['formexamen'],$con);
} else {
    echo "<script language='javascript'>$('div.addnull').show('slow').delay(3000).hide('slow');</script>";
}
?>