<?php

// Connexion à la base de données
include('../../../hopitalconnexion/connexion.php');

if (isset($_REQUEST["boncommande"])) {
    $id = $_REQUEST["boncommande"];
    $date = date('Y-m-d');
    $date2 = date('d-m-Y');

    $req = $con->query("select * from hp_bon_commande_interne as bl left join hp_pharmacie as s on "
            . "bl.idpharmacie=s.idpharmacie where bl.idboncommandeinterne='" . $id . "'") or die(mysqli_error($con));
    $row = mysqli_fetch_assoc($req);
    $reql = $con->query("select * from hp_ligne_bon_commande_interne as lbl left join hp_produit as a on "
            . "lbl.idproduit=a.idproduit left join hp_categorie as c on a.idcategorie=c.idcategorie where "
            . "lbl.idboncommandeinterne='" . $id . "'") or die(mysqli_error($con));
    
    $mtt = 0;
    $date2 = date('d-m-Y');

    $num = 1;
    $etatmagasin = " \t  \t Bon de Commande $row[nompharmacie] du $row[dateboncommandeinterne] \t \t \n";
    $etatmagasin .= "No \t DESIGNATION \t QUANTITE \t PRIX UNITAIRE \t PRIX TOTAL \t \n";
    $tqte = 0;
    $tpu = 0;
    $tpt = 0;
    while ($rowl = mysqli_fetch_assoc($reql)) {
        $prt = $rowl["prixligneboncommandeinterne"] * $rowl["stockligneboncommandeinterne"];

        $rsltua = $con->query("select * from hp_unite where idunite='" . $rowl["idunite"] . "'") or die(mysqli_error($con));
        $rowa = mysqli_fetch_assoc($rsltua);

        $etatmagasin .= "$num \t $rowl[libelleproduit] \t $rowl[stockligneboncommandeinterne]  $rowa[codeunite] \t "
                . "$rowl[prixligneboncommandeinterne] \t $prt \t \n";
        $tqte=$tqte+$rowl["stockligneboncommandeinterne"];
                    $tpu=$tpu+$rowl["prixligneboncommandeinterne"];
                    $tpt=$tpt+($rowl["stockligneboncommandeinterne"] * $rowl["prixligneboncommandeinterne"]);
        $num = $num + 1;
    }
    $etatmagasin .= " TOTAL \t \t $tqte \t \t $tpt \t \n";

    header("Content-type: application/vnd.ms-excel; charset=UTF-16LE");
    header("Content-disposition: attachment; filename=facturecommandepharmacieexcel.xls");
    print $etatmagasin;
    exit;
}
?>