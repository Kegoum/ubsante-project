<?php
if (isset($_SESSION['formdecaissement']) && $_SESSION['formdecaissement'] != NULL) {
    inserer_decaissement($_SESSION['formdecaissement'],$con);
} else {
    echo "<script language='javascript'>$('div.addnull').show('slow').delay(3000).hide('slow');</script>";
}
?>