  
<?php

if (isset($_SESSION['formvoy']) && $_SESSION['formvoy'] != NULL) {
    ajouter_versement($_SESSION['formvoy'],$con);
//    unset($_POST);unset($_SESSION['formvoy']);
} else {
    echo "<script language='javascript'>$('div.alertvoyagevide').show('slow').delay(8000).hide('slow');</script>";
}
?>