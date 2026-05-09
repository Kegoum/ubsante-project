  
<?php

if (isset($_SESSION['formversautre']) && $_SESSION['formversautre'] != NULL) {
    ajouter_versement_autre($_SESSION['formversautre'],$con);
//    unset($_POST);unset($_SESSION['formversautre']);
} else {
    echo "<script language='javascript'>$('div.alertvoyagevide').show('slow').delay(8000).hide('slow');</script>";
}
?>