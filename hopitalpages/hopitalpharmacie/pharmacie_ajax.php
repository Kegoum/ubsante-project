<?php

if (isset($_REQUEST["desactiver"])) {
    $id = trim($_REQUEST["idpharmacie"]);

    $con->query(" update hp_pharmacie set etatpharmacie=0 where idpharmacie='" . $id . "' ") or die(mysqli_error($con));

    echo "<script language='javascript'>alert('Pharmacie Désactivée avec succes')</script>";
    $pagp = 'hopitalpages/hopitalpharmacie/lister_pharmacie';
    die('<meta http-equiv="refresh" content="0 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
}

if (isset($_REQUEST["activer"])) {
    $id = trim($_REQUEST["idpharmacie"]);
    $con->query(" update hp_pharmacie set etatpharmacie=1 where idpharmacie='" . $id . "' ") or die(mysqli_error($con));

    echo "<script language='javascript'>alert('Pharmacie Activée avec succes')</script>";
    $pagp = 'hopitalpages/hopitalpharmacie/lister_pharmacie';
    die('<meta http-equiv="refresh" content="0 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
}

if (isset($_REQUEST["validerlivraisonligne"])) {
    $idr = trim($_REQUEST["idlignebonlivraisoninterne"]);
    $etat = "Valider";
    $nbnval = 0;
    $idbl = NULL;
    $reqb = $con->query("select * from hp_pharmacie where idpharmacie='" . $_SESSION["idpharmacie"] . "'") or die(mysqli_error($con));
    $rowb = mysqli_fetch_assoc($reqb);
    $reqlbl = $con->query("select * from hp_ligne_bon_livraison_interne as lbl left join hp_produit as a on "
            . "lbl.idproduit=a.idproduit where lbl.idlignebonlivraisoninterne='" . $idr . "'") or die(mysqli_error($con));
    while ($rowlbl = mysqli_fetch_assoc($reqlbl)) {
        $idbl = $rowlbl["idbonlivraisoninterne"];
        $reqamb = $con->query("select * from hp_boutique as mb left join hp_produit as a on mb.idproduit=a.idproduit where mb.idproduit='" . $rowlbl["idproduit"] . "' and "
                . "mb.idpharmacie='" . $rowb["idpharmacie"] . "'") or die(mysqli_error($con));
        $nbamb = mysqli_num_rows($reqamb);
        
        if ($nbamb != 0) {
            $rowamb = mysqli_fetch_assoc($reqamb);
            $stock = $rowamb["stockboutique"] + $rowlbl["stocklignebonlivraisoninterne"];
            if ($rowamb["iduniteboutique"] != $rowlbl["idunite"]) {
               $rsltuarpa = $con->query("select * from hp_conversion where idunite='" . $rowlbl["idunite"] . "' "
                        . "and idproduit='" . $rowlbl["idproduit"] . "'") or die(mysqli_error($con));
                $npharmaciepa = mysqli_num_rows($rsltuarpa);
                $rowarpa = mysqli_fetch_assoc($rsltuarpa);
                if ($npharmaciepa != 0) {
                    if ($rowarpa["conversion"] != 0) {
                        $stockara = $rowlbl["stocklignebonlivraisoninterne"] / $rowarpa["conversion"];
                        $stock = $rowamb["stockboutique"] + $stockara;
                    }
                }
            }

            $rsltl = $con->query("update hp_boutique set stockboutique='" . $stock . "', "
                    . "prixventeboutique='" . $rowlbl["prixventelignebonlivraisoninterne"] . "' where "
                    . "idboutique='" . $rowamb["idboutique"] . "'") or die(mysqli_error($con));
        } else {
            $stock = $rowlbl["stocklignebonlivraisoninterne"];
            if ($rowlbl["uniteventeproduit"] != $rowlbl["idunite"]) {
                $rsltuarpa = $con->query("select * from hp_conversion where idunite='" . $rowlbl["idunite"] . "' "
                        . "and idproduit='" . $rowlbl["idproduit"] . "'") or die(mysqli_error($con));
                $npharmaciepa = mysqli_num_rows($rsltuarpa);
                $rowarpa = mysqli_fetch_assoc($rsltuarpa);
                if ($npharmaciepa != 0) {
                    if ($rowarpa["conversion"] != 0) {
                        $stockara = $rowlbl["stocklignebonlivraisoninterne"] / $rowarpa["conversion"];
                        $stock = $stockara;
                    }
                }
            }
            $rsltl = $con->query("insert into hp_boutique set idpharmacie='" . $rowb["idpharmacie"] . "', "
                    . "iduniteboutique='" . $rowlbl["uniteventeproduit"] . "', idproduit='" . $rowlbl["idproduit"] . "', "
                    . "stockboutique='" . $stock . "', stockminboutique='" . $rowlbl["stockminproduit"] . "', "
                    . "stockmaxboutique='" . $rowlbl["stockmaxproduit"] . "', prixventeboutique='" . $rowlbl["prixventeproduit"] . "', "
                    . "dateboutique=NOW() ") or die(mysqli_error($con));
        }
        $rslt = $con->query("update hp_ligne_bon_livraison_interne set etatlignebonlivraisoninterne='" . $etat . "' where "
                . "idlignebonlivraisoninterne='" . $rowlbl["idlignebonlivraisoninterne"] . "'") or die(mysqli_error($con));
        $obj = $rowlbl["stocklignebonlivraisoninterne"] . "-" . addslashes($rowlbl["libelleproduit"]);
        $op = "Vlidation Livraison Interne";
//        if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["mot_de_passe_proprietaire"]))) {
//            $rsltvente = $con->query("insert into hp_historique(idproduit, id_proprietaire, objet_h, "
//                    . "operation_h, date_histo) values('" . $rowlbl["idproduit"] . "', "
//                    . "'" . $_SESSION["id_proprietaire"] . "', '" . $obj . "', '" . $op . "', NOW())") or die(mysqli_error($con));
//        } else if (isset($_SESSION["login_personnel"]) && (isset($_SESSION["mot_de_passe_personnel"])) && ($_SESSION["etat_compte_personnel"])) {
        $rsltvente = $con->query("insert into hp_trace(idproduit, idcomptepersonnel, "
                . "objet, operation, datetrace) values('" . $rowlbl["idproduit"] . "', "
                . "'" . $_SESSION["idcomptepersonnel"] . "', '" . $obj . "', '" . $op . "', NOW())") or die(mysqli_error($con));
//            } else if (($_SESSION["code_service"] == "DG")) {
//                $rsltvente = $con->query("insert into hp_historique(idproduit, id_compte_personnel, "
//                        . "objet_h, operation_h, date_histo) values('" . $rowlbl["idproduit"] . "', "
//                        . "'" . $_SESSION["id_compte_personnel"] . "', '" . $obj . "', '" . $op . "', NOW())") or die(mysqli_error($con));
//            }
//        }
    }
    $rslt = $con->query("update hp_bon_livraison_interne set idcomptepersonnelrecep='" . $_SESSION["idcomptepersonnel"] . "', "
            . "etatbonlivraisoninterne='" . $etat . "' where idbonlivraisoninterne='" . $idr . "'") or die(mysqli_error($con));

    echo "<script language='javascript'>alert('Bon de livraison validé avec succes!')</script>";
    $pagp = 'hopitalpages/hopitalpharmacie/hopitalbonlivraisonc/lister_livraison_ligne';
    die('<meta http-equiv="refresh" content="0 ; URL=' . $url . '?page=' . base64_encode($pagp) . '&bonlivraison=' . $idbl . '">');
}

if (isset($_REQUEST["validerlivraison"])) {
    $idr = trim($_REQUEST["idbonlivraisoninterne"]);
    $etat = "Valider";
    $nbnval = 0;
    $idbl = NULL;
    $reqb = $con->query("select * from hp_pharmacie where idpharmacie='" . $_SESSION["idpharmacie"] . "'") or die(mysqli_error($con));
    $rowb = mysqli_fetch_assoc($reqb);
    $reqlbl = $con->query("select * from hp_ligne_bon_livraison_interne as lbl left join hp_produit as a on "
            . "lbl.idproduit=a.idproduit where lbl.idbonlivraisoninterne='" . $idr . "'") or die(mysqli_error($con));
    while ($rowlbl = mysqli_fetch_assoc($reqlbl)) {
        $idbl = $rowlbl["idbonlivraisoninterne"];
        $reqamb = $con->query("select * from hp_boutique as mb left join hp_produit as a on mb.idproduit=a.idproduit where mb.idproduit='" . $rowlbl["idproduit"] . "' and "
                . "mb.idpharmacie='" . $rowb["idpharmacie"] . "'") or die(mysqli_error($con));
        $nbamb = mysqli_num_rows($reqamb);
        
        if ($nbamb != 0) {
            $rowamb = mysqli_fetch_assoc($reqamb);
            $stock = $rowamb["stockboutique"] + $rowlbl["stocklignebonlivraisoninterne"];
            if ($rowamb["iduniteboutique"] != $rowlbl["idunite"]) {
               $rsltuarpa = $con->query("select * from hp_conversion where idunite='" . $rowlbl["idunite"] . "' "
                        . "and idproduit='" . $rowlbl["idproduit"] . "'") or die(mysqli_error($con));
                $npharmaciepa = mysqli_num_rows($rsltuarpa);
                $rowarpa = mysqli_fetch_assoc($rsltuarpa);
                $rsltuarpaa = $con->query("select * from hp_conversion where idunite='" . $rowamb["iduniteboutique"] . "' "
                        . "and idproduit='" . $rowlbl["idproduit"] . "'") or die(mysqli_error($con));
                $rowarpaa = mysqli_fetch_assoc($rsltuarpaa);
                if ($npharmaciepa != 0) {
                    if ($rowarpa["conversion"] != 0) {
                        $stockara = $rowarpaa["conversion"]*$rowlbl["stocklignebonlivraisoninterne"] / $rowarpa["conversion"];
                        $stock = $rowamb["stockboutique"] + $stockara;
                    }
                }
            }

            $rsltl = $con->query("update hp_boutique set stockboutique='" . $stock . "', "
                    . "prixventeboutique='" . $rowlbl["prixventelignebonlivraisoninterne"] . "' where "
                    . "idboutique='" . $rowamb["idboutique"] . "'") or die(mysqli_error($con));
        } else {
            $stock = $rowlbl["stocklignebonlivraisoninterne"];
            if ($rowlbl["uniteventeproduit"] != $rowlbl["idunite"]) {
                $rsltuarpa = $con->query("select * from hp_conversion where idunite='" . $rowlbl["idunite"] . "' "
                        . "and idproduit='" . $rowlbl["idproduit"] . "'") or die(mysqli_error($con));
                $npharmaciepa = mysqli_num_rows($rsltuarpa);
                $rowarpa = mysqli_fetch_assoc($rsltuarpa);
                $rsltuarpaa = $con->query("select * from hp_conversion where idunite='" . $rowlbl["uniteventeproduit"] . "' "
                        . "and idproduit='" . $rowlbl["idproduit"] . "'") or die(mysqli_error($con));
                $rowarpaa = mysqli_fetch_assoc($rsltuarpaa);
                if ($npharmaciepa != 0) {
                    if ($rowarpa["conversion"] != 0) {
                        $stockara = $rowarpaa["conversion"]*$rowlbl["stocklignebonlivraisoninterne"] / $rowarpa["conversion"];
                        $stock = $stockara;
                    }
                }
            }
            $rsltl = $con->query("insert into hp_boutique set idpharmacie='" . $rowb["idpharmacie"] . "', "
                    . "iduniteboutique='" . $rowlbl["uniteventeproduit"] . "', idproduit='" . $rowlbl["idproduit"] . "', "
                    . "stockboutique='" . $stock . "', stockminboutique='" . $rowlbl["stockminproduit"] . "', "
                    . "stockmaxboutique='" . $rowlbl["stockmaxproduit"] . "', prixventeboutique='" . $rowlbl["prixventelignebonlivraisoninterne"] . "', "
                    . "dateboutique=NOW() ") or die(mysqli_error($con));
        }
        $rslt = $con->query("update hp_ligne_bon_livraison_interne set etatlignebonlivraisoninterne='" . $etat . "' where "
                . "idlignebonlivraisoninterne='" . $rowlbl["idlignebonlivraisoninterne"] . "'") or die(mysqli_error($con));
        $obj = $rowlbl["stocklignebonlivraisoninterne"] . "-" . addslashes($rowlbl["libelleproduit"]);
        $op = "Vlidation Livraison Interne";
//        if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["mot_de_passe_proprietaire"]))) {
//            $rsltvente = $con->query("insert into hp_historique(idproduit, id_proprietaire, objet_h, "
//                    . "operation_h, date_histo) values('" . $rowlbl["idproduit"] . "', "
//                    . "'" . $_SESSION["id_proprietaire"] . "', '" . $obj . "', '" . $op . "', NOW())") or die(mysqli_error($con));
//        } else if (isset($_SESSION["login_personnel"]) && (isset($_SESSION["mot_de_passe_personnel"])) && ($_SESSION["etat_compte_personnel"])) {
        $rsltvente = $con->query("insert into hp_trace(idproduit, idcomptepersonnel, "
                . "objet, operation, datetrace) values('" . $rowlbl["idproduit"] . "', "
                . "'" . $_SESSION["idcomptepersonnel"] . "', '" . $obj . "', '" . $op . "', NOW())") or die(mysqli_error($con));
//            } else if (($_SESSION["code_service"] == "DG")) {
//                $rsltvente = $con->query("insert into hp_historique(idproduit, id_compte_personnel, "
//                        . "objet_h, operation_h, date_histo) values('" . $rowlbl["idproduit"] . "', "
//                        . "'" . $_SESSION["id_compte_personnel"] . "', '" . $obj . "', '" . $op . "', NOW())") or die(mysqli_error($con));
//            }
//        }
    }
    $rslt = $con->query("update hp_bon_livraison_interne set idcomptepersonnelrecep='" . $_SESSION["idcomptepersonnel"] . "', "
            . "etatbonlivraisoninterne='" . $etat . "' where idbonlivraisoninterne='" . $idr . "'") or die(mysqli_error($con));

    echo "<script language='javascript'>alert('Bon de livraison validé avec succes!')</script>";
    $pagp = 'hopitalpages/hopitalpharmacie/hopitalbonlivraisonc/lister_livraison_ligne';
    die('<meta http-equiv="refresh" content="0 ; URL=' . $url . '?page=' . base64_encode($pagp) . '&bonlivraison=' . $idbl . '">');
}

if (isset($_REQUEST["supprimer"])) {
    $id = trim($_REQUEST["idpharmacie"]);
    $req = $con->query("select * from hp_affectation where idpharmacie='" . $id . "'") or die(mysqli_error($con));
    $nb = mysqli_num_rows($req);
    if (($nb == 0)) {
        $con->query(" delete from hp_pharmacie where idpharmacie='" . $id . "' ") or die(mysqli_error($con));

        echo "<script language='javascript'>alert('Suppression terminée')</script>";
        $pagp = 'hopitalpages/hopitalpharmacie/lister_pharmacie';
        die('<meta http-equiv="refresh" content="0 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
    } else {

        echo "<script language='javascript'>alert('Impossible de surprimer ce pharmacie car il y a des Affectations !!!')</script>";
        $pagp = 'hopitalpages/hopitalpharmacie/lister_pharmacie';
        die('<meta http-equiv="refresh" content="0 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
    }
}
?>