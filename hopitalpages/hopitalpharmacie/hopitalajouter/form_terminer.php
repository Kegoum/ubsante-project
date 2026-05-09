<?php
if (isset($_SESSION['formpharmacie']) && $_SESSION['formpharmacie'] != NULL) {
    inserer_pharmacie($_SESSION['formpharmacie'],$con);
} else {
    echo "<script language='javascript'>$('div.addnull').show('slow').delay(3000).hide('slow');</script>";
}
?>