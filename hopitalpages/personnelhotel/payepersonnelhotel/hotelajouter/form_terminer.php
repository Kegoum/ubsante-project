<?php

if (isset($_SESSION['formpaye']) && $_SESSION['formpaye'] != NULL) {
    insert_paye($_REQUEST["personnel"], $_SESSION['formpaye'],$con);
} else {
    echo "<script language='javascript'>$('div.alertaddnull').show('slow').delay(8000).hide('slow');</script>";
}
?>