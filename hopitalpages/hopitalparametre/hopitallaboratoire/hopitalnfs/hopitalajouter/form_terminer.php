<?php
if (isset($_SESSION['formnfs']) && $_SESSION['formnfs'] != NULL) {
    inserer_nfs($_SESSION['formnfs'],$con);
} else {
    echo "<script language='javascript'>$('div.addnull').show('slow').delay(3000).hide('slow');</script>";
}
?>