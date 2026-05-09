<?php
if (isset($_SESSION['formlaboratoire']) && $_SESSION['formlaboratoire'] != NULL) {
    inserer_laboratoire($_SESSION['formlaboratoire'],$con);
} else {
    echo "<script language='javascript'>$('div.addnull').show('slow').delay(3000).hide('slow');</script>";
}
?>