<?php

if (isset($_REQUEST["activer"])) {
    $id = trim($_REQUEST["idpointage"]);
    $rsltens = $con->query("select * from hp_pointage as c left join hp_affectation as eg on c.idaffectation=eg.idaffectation "
            . "where c.idpointage='" . $id . "' ") or die(mysqli_error($con));
        $recens = mysqli_fetch_assoc($rsltens);
        $idmc=$recens["idpersonnel"];
     $con->query(" update pointage set etatpointage=1 where idpointage='" . $id . "' ") or die(mysqli_error($con));

        echo "<script language='javascript'>alert('Pointage Validés avec succes')</script>";
        $pagp = 'hopitalpages/hopitalpersonnel/hopitalpointage/lister_pointage_personnel';
        die('<meta http-equiv="refresh" content="0 ; URL=' . $url . '?page=' . base64_encode($pagp) . '&idpersonnel='.$idmc.'">');    
}

if (isset($_REQUEST["desactiver"])) {
    $id = trim($_REQUEST["idpointage"]);
   $rsltens = $con->query("select * from hp_pointage as c left join hp_affectation as eg on c.idaffectation=eg.idaffectation "
            . "where c.idpointage='" . $id . "' ") or die(mysqli_error($con));
        $recens = mysqli_fetch_assoc($rsltens);
        $idmc=$recens["idpersonnel"];
     $con->query(" update pointage set etatpointage=0 where idpointage='" . $id . "' ") or die(mysqli_error($con));

        echo "<script language='javascript'>alert('Pointage Annulés avec succes')</script>";
        $pagp = 'hopitalpages/hopitalpersonnel/hopitalpointage/lister_pointage_personnel';
        die('<meta http-equiv="refresh" content="0 ; URL=' . $url . '?page=' . base64_encode($pagp) . '&idpersonnel='.$idmc.'">');    
}

?>