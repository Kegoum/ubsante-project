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

if (isset($_REQUEST["bonlivraison"])) {
    $id = $_REQUEST["bonlivraison"];
    $date = date('Y-m-d');
    $date2 = date('d-m-Y');

    $req = $con->query("select * from hp_bon_livraison as bl where bl.idbonlivraison='" . $id . "'") or die(mysqli_error($con));
    $row = mysqli_fetch_assoc($req);
    $reql = $con->query("select * from hp_ligne_bon_livraison as lbl left join hp_produit as a on "
            . "lbl.idproduit=a.idproduit left join hp_categorie as c on a.idcategorie=c.idcategorie where "
            . "lbl.idbonlivraison='" . $id . "'") or die(mysqli_error($con));
    
    $rsltph = $con->query('select * from hp_magasin as pa where pa.idmagasin=' . $row["idmagasin"] . '') or die(mysqli_error($con));
    $rowph = mysqli_fetch_assoc($rsltph);
    ?>

    <page backtop="5mm" backbottom="5mm" backleft="5mm" backright="5mm">
        <div align="center" style="border-radius: 3mm; border: none; background: #DDDDAA;" >
            <h3>Bon de Livraison <?php echo $row["codebonlivraison"]; ?></h3>
            <?php echo strtoupper($rowhote["hopitalproprietaire"]); ?><br>
            <?php echo strtoupper($rowhote["sloganproprietaire"]); ?><br>
            B. P. <?php echo $rowhote["bpproprietaire"]; ?> 
            T&eacute;l: <?php echo $rowhote["telephoneproprietaire"]; ?>
            E-mail<?php echo $rowhote["emailproprietaire"]; ?>
        </div>

        <table cellspacing="0" style="padding: 1px; width: 100%; border: solid 2px #000000; border-radius: 10px; font-size: 9pt; ">
            <thead>
                <tr>
                    <th style="width: 100%; text-align: center; border: solid 1px #000000;" colspan="6">
            <h4><?php echo $rowph["nommagasin"]; ?></h4>
            </th>
            </tr>
            <tr>
                <th style="width: 5%; border: solid 1px #000000;">N&deg;</th>
                <th style="width: 40%; border: solid 1px #000000;">D&eacute;signation</th>
                <th style="width: 10%; border: solid 1px #000000;">Qt&eacute;</th>
                <th style="width: 15%; border: solid 1px #000000;">P. A.</th>
                <th style="width: 15%; border: solid 1px #000000;">U. A.</th>
                <th style="width: 15%; border: solid 1px #000000;">Prix Total</th>
            </tr>
            </thead>
            <tbody>
                <?php
                $nb = 0;
                $tqte=0;
                $tpu=0;
                $tpt=0;
                while ($rowl = mysqli_fetch_assoc($reql)) {
                    $nb = $nb + 1;
                    ?>
                    <tr>
                        <td style="width: 5%; border: solid 1px #000000;text-align: center; "><?php echo $nb ?></td>
                        <td style="width: 40%; border: solid 1px #000000;text-align: left; "><?php echo $rowl["libelleproduit"] ?></td>
                        <td style="width: 10%; border: solid 1px #000000;text-align: left; "><?php echo $rowl["stocklignebonlivraison"] ?></td>
                        <td style="width: 15%; border: solid 1px #000000;text-align: right; "><?php echo number_format($rowl["prixachatlignebonlivraison"], 0, ',', ' ') ?></td>
                        <td style="width: 15%; border: solid 1px #000000;text-align: right; ">
                            <?php
                                $rsltua = $con->query("select * from hp_unite where idunite='" . $rowl["idunite"] . "'") or die(mysqli_error($con));
                                $rowa = mysqli_fetch_assoc($rsltua);
                                print nl2br(htmlspecialchars($rowa["codeunite"]));
                                ?>
                        </td>
                        <td style="width: 15%; border: solid 1px #000000;text-align: right; ">
                            <?php echo number_format(($rowl["prixachatlignebonlivraison"] * $rowl["stocklignebonlivraison"]), 0, ',', ' ') ?></td>
                    </tr>
                    <?php
                    $tqte=$tqte+$rowl["stocklignebonlivraison"];
                    $tpu=$tpu+$rowl["prixachatlignebonlivraison"];
                    $tpt=$tpt+($rowl["stocklignebonlivraison"] * $rowl["prixachatlignebonlivraison"]);
                }
                ?>
            </tbody>
            <tfoot>
                <tr>
                    <th style="width: 45%; border: solid 1px #000000;text-align: center;" colspan="2">Livraison du : <?php echo $row["datebonlivraison"] ?></th>
                    <td style="width: 10%; border: solid 1px #000000;text-align: left; "><?php echo $tqte ?></td>
                    <td style="width: 45%; border: solid 1px #000000;text-align: right; background: #CCFFCC; font-size: 10pt;  " colspan="3"><?php echo number_format(($tpt), 0, ',', ' ') ?></td>
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

