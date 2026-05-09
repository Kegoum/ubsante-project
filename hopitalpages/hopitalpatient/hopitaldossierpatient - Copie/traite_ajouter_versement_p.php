  
<?php

if (isset($_SESSION['formvoyp']) && $_SESSION['formvoyp'] != NULL) {
    ajouter_versement_client_p($_SESSION['formvoyp'],$con);
//    unset($_POST);unset($_SESSION['formvoyp']);
} else {
    echo "<script language='javascript'>$('div.alertvoyagevide').show('slow').delay(8000).hide('slow');</script>";
}
?>