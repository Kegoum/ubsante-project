  
<?php

if (isset($_SESSION['formdecaisse']) && $_SESSION['formdecaisse'] != NULL) {
    ajouter_decaissement($_SESSION['formdecaisse'],$con);
//    unset($_POST);unset($_SESSION['formdecaisse']);
} else {
    echo "<script language='javascript'>$('div.alertvoyagevide').show('slow').delay(8000).hide('slow');</script>";
}
?>