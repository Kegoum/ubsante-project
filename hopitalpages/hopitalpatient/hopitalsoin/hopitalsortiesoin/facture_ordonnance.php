<style>
    div.recu
    {
        width:       12mm;
        height:      3mm;
        overflow: hidden;
        border:2px solid #999;
        margin:0px;
        background-color:#999;
    }
</style>
<?php
include('../../../hopitalconnexion/connexion.php');

$reqhote = $con->query("select * from hp_proprietaire as p left join hp_departement as d on "
        . "p.iddepartement=d.iddepartement left join hp_region as r on d.idregion=r.idregion") or die(mysqli_error($con));
$rowhote = NULL;
while ($rowhote1 = mysqli_fetch_assoc($reqhote)) {
    $rowhote = $rowhote1;
}

if (isset($_REQUEST["livraisonordonnance"])) {
    $id = $_REQUEST["livraisonordonnance"];
    $date = date('Y-m-d');
    $date2 = date('d-m-Y');

    $req = $con->query("select * from hp_livraison_ordonnance as lo left join hp_ordonnance as o on "
            . "lo.idordonnance=o.idordonnance left join hp_sous_dossier as sd on o.idsousdossier=sd.idsousdossier left "
            . "join hp_dossier as d on sd.iddossier=d.iddossier left join hp_patient as p on d.idpatient=p.idpatient "
            . "where lo.idlivraisonordonnance='" . $id . "'") or die(mysqli_error($con));
    $row = mysqli_fetch_assoc($req);
    $reql = $con->query("select * from hp_ligne_livraison_ordonnance as l left join hp_boutique as mb on "
            . "l.idboutique=mb.idboutique left join hp_produit as a on mb.idproduit=a.idproduit where "
            . "l.idlivraisonordonnance='" . $id . "'") or die(mysqli_error($con));
    
    $rsltph = $con->query('select * from hp_pharmacie where idpharmacie=' . $row["idpharmacie"] . '') or die(mysqli_error($con));
    $rowph = mysqli_fetch_assoc($rsltph);
    ?>

    <page backtop="5mm" backbottom="5mm" backleft="5mm" backright="5mm">
        <div align="center" style="border-radius: 3mm; border: none; background: #DDDDAA;" >
            <h3>FACTURE ORDONNANCE <?php echo $rowph["nompharmacie"]; ?></h3>
            <?php echo strtoupper($rowhote["hopitalproprietaire"]); ?><br>
            <?php echo strtoupper($rowhote["sloganproprietaire"]); ?><br>
            B. P. <?php echo $rowhote["bpproprietaire"]; ?> 
            T&eacute;l: <?php echo $rowhote["telephoneproprietaire"]; ?>
            E-mail<?php echo $rowhote["emailproprietaire"]; ?>
        </div>

        <table cellspacing="0" style="padding: 1px; width: 100%; border: solid 2px #000000; border-radius: 10px; font-size: 9pt; ">
            <thead>
                <tr>
                    <th style="width: 100%; text-align: center; border: solid 1px #000000;" colspan="8">
            <h4><?php echo $row["nompatient"] ?> <?php echo $row["prenompatient"] ?> - <?php echo $row["codepatient"] ?></h4>
            </th>
            </tr>
            <tr>
                <th style="width: 5%; border: solid 1px #000000;">N&deg;</th>
                <th style="width: 40%; border: solid 1px #000000;">D&eacute;signation</th>
                <th style="width: 15%; border: solid 1px #000000;">Qt&eacute;</th>
                <th style="width: 20%; border: solid 1px #000000;">P. U.</th>
                <th style="width: 20%; border: solid 1px #000000;">Prix Total</th>

            </tr>
            </thead>
            <tbody>
                <?php
                $nb = 0;
                $tqte=0;
                $tpu=0;
                $tpt=0;
                while ($rowl = mysqli_fetch_assoc($reql)) {
                    $rsltu = $con->query('select * from hp_unite where idunite=' . $rowl["idunite"] . '') or die(mysqli_error($con));
    $rowu = mysqli_fetch_assoc($rsltu);
                    $nb = $nb + 1;
                    ?>
                    <tr>
                        <td style="width: 5%; border: solid 1px #000000;text-align: center; "><?php echo $nb ?></td>
                        <td style="width: 40%; border: solid 1px #000000;text-align: left; "><?php echo $rowl["libelleproduit"] ?></td>
                        <td style="width: 15%; border: solid 1px #000000;text-align: left; "><?php echo $rowl["stocklignelivraisonordonnance"] ?> <?php echo $rowu["codeunite"] ?></td>
                        <td style="width: 20%; border: solid 1px #000000;text-align: right; "><?php echo number_format($rowl["prixlignelivraisonordonnance"], 0, ',', ' ') ?></td>
                        <td style="width: 20%; border: solid 1px #000000;text-align: right; "><?php echo number_format(($rowl["stocklignelivraisonordonnance"] * $rowl["prixlignelivraisonordonnance"]), 0, ',', ' ') ?></td>
                    </tr>
                    <?php
                    $tqte=$tqte+$rowl["stocklignelivraisonordonnance"];
                    $tpu=$tpu+$rowl["prixlignelivraisonordonnance"];
                    $tpt=$tpt+($rowl["stocklignelivraisonordonnance"] * $rowl["prixlignelivraisonordonnance"]);
                }
                ?>
            </tbody>
            <tfoot>
                <tr>
                    <th style="width: 45%; border: solid 1px #000000;text-align: center;" colspan="2">Facture du : <?php echo $row["datelivraisonordonnance"] ?></th>
                    <td style="width: 15%; border: solid 1px #000000;text-align: left; "><?php echo $tqte ?></td>
                    <td style="width: 40%; border: solid 1px #000000;text-align: right; background: #CCFFCC; font-size: 10pt;  " colspan="2"><?php echo number_format(($tpt), 0, ',', ' ') ?></td>
                </tr>
            </tfoot>
        </table>
        <br><br><br>
        <div align="right" >
            Fait &agrave; <?php echo $rowhote["cheflieuregion"]; ?>, le <?php echo $date2; ?>
        </div>
    </page>
    <?php
}
?>

