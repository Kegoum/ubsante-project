<?php

if (isset($_SESSION['formvalorisation']) && $_SESSION['formvalorisation'] != NULL && isset($_SESSION['formvalorisation']["1"])) {

    $idma = $_SESSION['formvalorisation']["1"]["idlignebonlivraison"];

    $rsltv = $con->query("select * from sot_ligne_bon_livraison as lbl left join sot_ligne_bon_commande as lbc on "
            . "lbl.idligneboncommande=lbc.idligneboncommande left join sot_ligne_demande_approvisionnement as lda on "
            . "lbc.idlignedemandeapprovisionnement=lda.idlignedemandeapprovisionnement left join sot_materiaux as m "
            . "on lda.idmateriaux=m.idmateriaux left join sot_unite as u on m.idunite=u.idunite left "
            . "join sot_type_materiaux as s on m.idtypemateriaux=s.idtypemateriaux left join sot_valorisation_stock "
            . "as v on m.idvalorisationstock=v.idvalorisationstock where "
            . "lbl.idlignebonlivraison='" . $idma . "'") or die(mysqli_error($con));
    $rowv = mysqli_fetch_assoc($rsltv);
    $rsltdav = $con->query("select * from sot_demande_approvisionnement as da where da.iddemandeapprovisionnement='" . $rowv["iddemandeapprovisionnement"] . "'") or die(mysqli_error($con));
    $rowdav = mysqli_fetch_assoc($rsltdav);
if($rowda["idmagasin"]!=NULL){
$rsltdavm = $con->query("select * from sot_magasin as da where da.idmagasin='" . $rowda["idmagasin"] . "'") or die(mysqli_error($con));
    $rowdavm = mysqli_fetch_assoc($rsltdavm);
    $rslt = $con->query("insert into sot_achat_materiaux(iduser, idmateriaux, idunite, idlignebonlivraison, idmarche, datejourachatmateriaux, "
            . "quantiteachatmateriaux, prixunitaireachatmateriaux, quantitefinaleachatmateriaux, prixunitairefinalachatmateriaux, "
            . "transportachatmateriaux, fraisgestionachatmateriaux, dateachatmateriaux) values('" . $_SESSION["iduser"] . "', "
            . "'" . $rowv["idmateriaux"] . "', '" . $rowv["idunite"] . "', '" . $idma . "', '" . $rowdavm["idmarche"] . "', "
            . "'" . $_SESSION['formvalorisation'][1]["datejour"] . "', '" . $_SESSION['formvalorisation'][1]["qtee"] . "', '" . $_SESSION['formvalorisation'][1]["prixue"] . "', "
            . "'" . $_SESSION['formvalorisation'][1]["qter"] . "', '" . $_SESSION['formvalorisation'][1]["prixur"] . "', "
            . "'" . $_SESSION['formvalorisation'][1]["transport"] . "', '" . $_SESSION['formvalorisation'][1]["fraisgestion"] . "', "
            . "NOW())") or die(mysqli_error($con));
    $rsltiv = $con->query("select * from sot_ligne_magasin as lm where "
            . "lm.idmateriaux='" . $rowv["idmateriaux"] . "' and lm.idmagasin='" . $rowda["idmagasin"] . "'") or die(mysqli_error($con));
    $nbiv = mysqli_num_rows($rsltiv);
    if ($nbiv == 0) {
        $rsltvente = $con->query("insert into sot_ligne_magasin(idmagasin, idmateriaux, quantitelignemagasin, "
                . "prixunitairelignemagasin, date) values('" . $rowda["idmagasin"] . "', '" . $rowv["idmateriaux"] . "', "
                . "'" . $_SESSION['formvalorisation']["1"]["qter"] . "', '" . $_SESSION['formvalorisation']["1"]["prixur"] . "', "
                . "NOW())") or die(mysqli_error($con));
    }else{
        $rowiv = mysqli_fetch_assoc($rsltiv);
        $con->query("update sot_ligne_magasin set quantitelignemagasin='" . $_SESSION['formvalorisation']["1"]["qter"] . "', "
                . "prixunitairelignemagasin='" . $_SESSION['formvalorisation']["1"]["prixur"] . "' where "
                . "idmagasin='" . $rowda["idmagasin"] . "' and idmateriaux='" . $rowv["idmateriaux"] . "'") or die(mysqli_error($con));
    }
    $etat="Valider";
        $con->query("update sot_ligne_bon_livraison set etatlignebonlivraison='" . $etat . "' where idlignebonlivraison='" . $idma . "'") or die(mysqli_error($con));
   $tou=1;
   $reqcoml = $con->query("select * from sot_ligne_bon_livraison where idbonlivraison='" . $rowv["idbonlivraison"] . "' and "
           . "(etatlignebonlivraison='En Cours')") or die(mysqli_error($con));
        $nbda = mysqli_num_rows($reqcoml);
        if ($nbda != 0) {
            $tou = 0;
        }
        if ($tou == 1) {
            $con->query("update sot_bon_livraison set etatbonlivraison='" . $etat . "' where idbonlivraison='" . $rowv["idbonlivraison"] . "'") or die(mysqli_error($con));
        }
		}else if($rowda["idpointprefabrication"]!=NULL){
    $rslt = $con->query("insert into sot_achat_materiaux(iduser, idmateriaux, idunite, idlignebonlivraison, datejourachatmateriaux, "
            . "quantiteachatmateriaux, prixunitaireachatmateriaux, quantitefinaleachatmateriaux, prixunitairefinalachatmateriaux, "
            . "transportachatmateriaux, fraisgestionachatmateriaux, dateachatmateriaux) values('" . $_SESSION["iduser"] . "', "
            . "'" . $rowv["idmateriaux"] . "', '" . $rowv["idunite"] . "', '" . $idma . "', "
            . "'" . $_SESSION['formvalorisation'][1]["datejour"] . "', '" . $_SESSION['formvalorisation'][1]["qtee"] . "', '" . $_SESSION['formvalorisation'][1]["prixue"] . "', "
            . "'" . $_SESSION['formvalorisation'][1]["qter"] . "', '" . $_SESSION['formvalorisation'][1]["prixur"] . "', "
            . "'" . $_SESSION['formvalorisation'][1]["transport"] . "', '" . $_SESSION['formvalorisation'][1]["fraisgestion"] . "', "
            . "NOW())") or die(mysqli_error($con));
    $rsltiv = $con->query("select * from sot_materiaux_prefabrication_use as lm where "
            . "lm.idmateriaux='" . $rowv["idmateriaux"] . "' and lm.idpointprefabrication='" . $rowda["idpointprefabrication"] . "'") or die(mysqli_error($con));
    $nbiv = mysqli_num_rows($rsltiv);
    if ($nbiv == 0) {
        $rsltvente = $con->query("insert into sot_materiaux_prefabrication_use(idpointprefabrication, idmateriaux, quantitemateriauxprefabricationuse, "
                . "prixmateriauxprefabricationuse) values('" . $rowda["idpointprefabrication"] . "', '" . $rowv["idmateriaux"] . "', "
                . "'" . $_SESSION['formvalorisation']["1"]["qter"] . "', '" . $_SESSION['formvalorisation']["1"]["prixur"] . "' )") or die(mysqli_error($con));
    }else{
        $rowiv = mysqli_fetch_assoc($rsltiv);
        $con->query("update sot_materiaux_prefabrication_use set quantitemateriauxprefabricationuse='" . $_SESSION['formvalorisation']["1"]["qter"] . "', "
                . "prixmateriauxprefabricationuse='" . $_SESSION['formvalorisation']["1"]["prixur"] . "' where "
                . "idpointprefabrication='" . $rowda["idpointprefabrication"] . "' and idmateriaux='" . $rowv["idmateriaux"] . "'") or die(mysqli_error($con));
    }
    $etat="Valider";
        $con->query("update sot_ligne_bon_livraison set etatlignebonlivraison='" . $etat . "' where idlignebonlivraison='" . $idma . "'") or die(mysqli_error($con));
   $tou=1;
   $reqcoml = $con->query("select * from sot_ligne_bon_livraison where idbonlivraison='" . $rowv["idbonlivraison"] . "' and "
           . "(etatlignebonlivraison='En Cours')") or die(mysqli_error($con));
        $nbda = mysqli_num_rows($reqcoml);
        if ($nbda != 0) {
            $tou = 0;
        }
        if ($tou == 1) {
            $con->query("update sot_bon_livraison set etatbonlivraison='" . $etat . "' where idbonlivraison='" . $rowv["idbonlivraison"] . "'") or die(mysqli_error($con));
        }
		}else if($rowda["idpointenrobe"]!=NULL){
    $rslt = $con->query("insert into sot_achat_materiaux(iduser, idmateriaux, idunite, idlignebonlivraison, datejourachatmateriaux, "
            . "quantiteachatmateriaux, prixunitaireachatmateriaux, quantitefinaleachatmateriaux, prixunitairefinalachatmateriaux, "
            . "transportachatmateriaux, fraisgestionachatmateriaux, dateachatmateriaux) values('" . $_SESSION["iduser"] . "', "
            . "'" . $rowv["idmateriaux"] . "', '" . $rowv["idunite"] . "', '" . $idma . "', "
            . "'" . $_SESSION['formvalorisation'][1]["datejour"] . "', '" . $_SESSION['formvalorisation'][1]["qtee"] . "', '" . $_SESSION['formvalorisation'][1]["prixue"] . "', "
            . "'" . $_SESSION['formvalorisation'][1]["qter"] . "', '" . $_SESSION['formvalorisation'][1]["prixur"] . "', "
            . "'" . $_SESSION['formvalorisation'][1]["transport"] . "', '" . $_SESSION['formvalorisation'][1]["fraisgestion"] . "', "
            . "NOW())") or die(mysqli_error($con));
    $rsltiv = $con->query("select * from sot_materiaux_enrobe_use as lm where "
            . "lm.idmateriaux='" . $rowv["idmateriaux"] . "' and lm.idpointenrobe='" . $rowda["idpointenrobe"] . "'") or die(mysqli_error($con));
    $nbiv = mysqli_num_rows($rsltiv);
    if ($nbiv == 0) {
        $rsltvente = $con->query("insert into sot_materiaux_enrobe_use(idpointenrobe, idmateriaux, quantitemateriauxenrobeuse, "
                . "prixmateriauxenrobeuse) values('" . $rowda["idpointenrobe"] . "', '" . $rowv["idmateriaux"] . "', "
                . "'" . $_SESSION['formvalorisation']["1"]["qter"] . "', '" . $_SESSION['formvalorisation']["1"]["prixur"] . "' )") or die(mysqli_error($con));
    }else{
        $rowiv = mysqli_fetch_assoc($rsltiv);
        $con->query("update sot_materiaux_enrobe_use set quantitemateriauxenrobeuse='" . $_SESSION['formvalorisation']["1"]["qter"] . "', "
                . "prixmateriauxenrobeuse='" . $_SESSION['formvalorisation']["1"]["prixur"] . "' where "
                . "idpointenrobe='" . $rowda["idpointenrobe"] . "' and idmateriaux='" . $rowv["idmateriaux"] . "'") or die(mysqli_error($con));
    }
    $etat="Valider";
        $con->query("update sot_ligne_bon_livraison set etatlignebonlivraison='" . $etat . "' where idlignebonlivraison='" . $idma . "'") or die(mysqli_error($con));
   $tou=1;
   $reqcoml = $con->query("select * from sot_ligne_bon_livraison where idbonlivraison='" . $rowv["idbonlivraison"] . "' and "
           . "(etatlignebonlivraison='En Cours')") or die(mysqli_error($con));
        $nbda = mysqli_num_rows($reqcoml);
        if ($nbda != 0) {
            $tou = 0;
        }
        if ($tou == 1) {
            $con->query("update sot_bon_livraison set etatbonlivraison='" . $etat . "' where idbonlivraison='" . $rowv["idbonlivraison"] . "'") or die(mysqli_error($con));
        }
		}else if($rowda["idpointbeton"]!=NULL){
    $rslt = $con->query("insert into sot_achat_materiaux(iduser, idmateriaux, idunite, idlignebonlivraison, datejourachatmateriaux, "
            . "quantiteachatmateriaux, prixunitaireachatmateriaux, quantitefinaleachatmateriaux, prixunitairefinalachatmateriaux, "
            . "transportachatmateriaux, fraisgestionachatmateriaux, dateachatmateriaux) values('" . $_SESSION["iduser"] . "', "
            . "'" . $rowv["idmateriaux"] . "', '" . $rowv["idunite"] . "', '" . $idma . "', "
            . "'" . $_SESSION['formvalorisation'][1]["datejour"] . "', '" . $_SESSION['formvalorisation'][1]["qtee"] . "', '" . $_SESSION['formvalorisation'][1]["prixue"] . "', "
            . "'" . $_SESSION['formvalorisation'][1]["qter"] . "', '" . $_SESSION['formvalorisation'][1]["prixur"] . "', "
            . "'" . $_SESSION['formvalorisation'][1]["transport"] . "', '" . $_SESSION['formvalorisation'][1]["fraisgestion"] . "', "
            . "NOW())") or die(mysqli_error($con));
    $rsltiv = $con->query("select * from sot_materiaux_beton_use as lm where "
            . "lm.idmateriaux='" . $rowv["idmateriaux"] . "' and lm.idpointbeton='" . $rowda["idpointbeton"] . "'") or die(mysqli_error($con));
    $nbiv = mysqli_num_rows($rsltiv);
    if ($nbiv == 0) {
        $rsltvente = $con->query("insert into sot_materiaux_beton_use(idpointbeton, idmateriaux, quantitemateriauxbetonuse, "
                . "prixmateriauxbetonuse) values('" . $rowda["idpointbeton"] . "', '" . $rowv["idmateriaux"] . "', "
                . "'" . $_SESSION['formvalorisation']["1"]["qter"] . "', '" . $_SESSION['formvalorisation']["1"]["prixur"] . "' )") or die(mysqli_error($con));
    }else{
        $rowiv = mysqli_fetch_assoc($rsltiv);
        $con->query("update sot_materiaux_beton_use set quantitemateriauxbetonuse='" . $_SESSION['formvalorisation']["1"]["qter"] . "', "
                . "prixmateriauxbetonuse='" . $_SESSION['formvalorisation']["1"]["prixur"] . "' where "
                . "idpointbeton='" . $rowda["idpointbeton"] . "' and idmateriaux='" . $rowv["idmateriaux"] . "'") or die(mysqli_error($con));
    }
    $etat="Valider";
        $con->query("update sot_ligne_bon_livraison set etatlignebonlivraison='" . $etat . "' where idlignebonlivraison='" . $idma . "'") or die(mysqli_error($con));
   $tou=1;
   $reqcoml = $con->query("select * from sot_ligne_bon_livraison where idbonlivraison='" . $rowv["idbonlivraison"] . "' and "
           . "(etatlignebonlivraison='En Cours')") or die(mysqli_error($con));
        $nbda = mysqli_num_rows($reqcoml);
        if ($nbda != 0) {
            $tou = 0;
        }
        if ($tou == 1) {
            $con->query("update sot_bon_livraison set etatbonlivraison='" . $etat . "' where idbonlivraison='" . $rowv["idbonlivraison"] . "'") or die(mysqli_error($con));
        }
		}else if($rowda["idpointconcassage"]!=NULL){
    $rslt = $con->query("insert into sot_achat_materiaux(iduser, idmateriaux, idunite, idlignebonlivraison, datejourachatmateriaux, "
            . "quantiteachatmateriaux, prixunitaireachatmateriaux, quantitefinaleachatmateriaux, prixunitairefinalachatmateriaux, "
            . "transportachatmateriaux, fraisgestionachatmateriaux, dateachatmateriaux) values('" . $_SESSION["iduser"] . "', "
            . "'" . $rowv["idmateriaux"] . "', '" . $rowv["idunite"] . "', '" . $idma . "', "
            . "'" . $_SESSION['formvalorisation'][1]["datejour"] . "', '" . $_SESSION['formvalorisation'][1]["qtee"] . "', '" . $_SESSION['formvalorisation'][1]["prixue"] . "', "
            . "'" . $_SESSION['formvalorisation'][1]["qter"] . "', '" . $_SESSION['formvalorisation'][1]["prixur"] . "', "
            . "'" . $_SESSION['formvalorisation'][1]["transport"] . "', '" . $_SESSION['formvalorisation'][1]["fraisgestion"] . "', "
            . "NOW())") or die(mysqli_error($con));
    $rsltiv = $con->query("select * from sot_materiaux_concassage_use as lm where "
            . "lm.idmateriaux='" . $rowv["idmateriaux"] . "' and lm.idpointconcassage='" . $rowda["idpointconcassage"] . "'") or die(mysqli_error($con));
    $nbiv = mysqli_num_rows($rsltiv);
    if ($nbiv == 0) {
        $rsltvente = $con->query("insert into sot_materiaux_concassage_use(idpointconcassage, idmateriaux, quantitemateriauxconcassageuse, "
                . "prixmateriauxconcassageuse) values('" . $rowda["idpointconcassage"] . "', '" . $rowv["idmateriaux"] . "', "
                . "'" . $_SESSION['formvalorisation']["1"]["qter"] . "', '" . $_SESSION['formvalorisation']["1"]["prixur"] . "' )") or die(mysqli_error($con));
    }else{
        $rowiv = mysqli_fetch_assoc($rsltiv);
        $con->query("update sot_materiaux_concassage_use set quantitemateriauxconcassageuse='" . $_SESSION['formvalorisation']["1"]["qter"] . "', "
                . "prixmateriauxconcassageuse='" . $_SESSION['formvalorisation']["1"]["prixur"] . "' where "
                . "idpointconcassage='" . $rowda["idpointconcassage"] . "' and idmateriaux='" . $rowv["idmateriaux"] . "'") or die(mysqli_error($con));
    }
    $etat="Valider";
        $con->query("update sot_ligne_bon_livraison set etatlignebonlivraison='" . $etat . "' where idlignebonlivraison='" . $idma . "'") or die(mysqli_error($con));
   $tou=1;
   $reqcoml = $con->query("select * from sot_ligne_bon_livraison where idbonlivraison='" . $rowv["idbonlivraison"] . "' and "
           . "(etatlignebonlivraison='En Cours')") or die(mysqli_error($con));
        $nbda = mysqli_num_rows($reqcoml);
        if ($nbda != 0) {
            $tou = 0;
        }
        if ($tou == 1) {
            $con->query("update sot_bon_livraison set etatbonlivraison='" . $etat . "' where idbonlivraison='" . $rowv["idbonlivraison"] . "'") or die(mysqli_error($con));
        }
		}
    unset($_SESSION['formvalorisation']);
    echo "<script language='javascript'>$('div.addok').show('slow').delay(8000).hide('slow');</script>";
    $pagp = 'sotcocogpages/sotcocogbonlivraison/lister_bonlivraison';
    die('<meta http-equiv="refresh" content="3 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
} else {

    echo "<script language='javascript'>$('div.addko').show('slow').delay(8000).hide('slow');</script>";
    $pagp = 'sotcocogpages/sotcocogbonlivraison/sotcocogvalorisation/valider';
    die('<meta http-equiv="refresh" content="3 ; URL=' . $url . '?page=' . base64_encode($pagp) . '&idlignebonlivraison=' . $idma . '">');
}
?>