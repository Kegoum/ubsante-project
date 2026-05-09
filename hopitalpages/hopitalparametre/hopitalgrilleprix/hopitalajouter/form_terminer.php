<?php
if (isset($_SESSION['formgrilleprix']) && $_SESSION['formgrilleprix'] != NULL) {
    inserer_grilleprix($_SESSION['formgrilleprix'],$con);
} else {
    echo "<script language='javascript'>$('div.addnull').show('slow').delay(3000).hide('slow');</script>";
}
?>