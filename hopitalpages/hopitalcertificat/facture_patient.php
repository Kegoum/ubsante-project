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
include('../../hopitalconnexion/connexion.php');

$reqhote = $con->query("select * from hp_proprietaire as p left join hp_departement as d on "
        . "p.iddepartement=d.iddepartement left join hp_region as r on d.idregion=r.idregion ") or die(mysqli_error($con));
$rowhote = NULL;
while ($rowhote1 = mysqli_fetch_assoc($reqhote)) {
    $rowhote = $rowhote1;
}

if (isset($_REQUEST["idlignecaisse"])) {
    $id = $_REQUEST["idlignecaisse"];
    $date = date('Y-m-d');
    $date2 = date('d-m-Y');

    $req = $con->query("select * from hp_ligne_caisse as bl left join hp_facture as sph on bl.idfacture=sph.idfacture "
            . "where bl.idlignecaisse='" . $id . "'") or die(mysqli_error($con));
    $row = mysqli_fetch_assoc($req);


    $rowpcon = NULL;
    $rowpexa = NULL;
    $rowpech = NULL;
    $rowpact = NULL;
    $rowpord = NULL;
    if ($row["idconsultation"] != NULL) {
        $rsltniv = $con->query("select * from hp_consultation as c left join hp_sous_dossier as sd on c.idsousdossier=sd.idsousdossier "
                . "left join hp_dossier as d on sd.iddossier=d.iddossier left join hp_patient as p on d.idpatient=p.idpatient left join "
                . "hp_departement as dp on p.residencepatient=dp.iddepartement where "
                . "c.idconsultation='" . $row["idconsultation"] . "'") or die(mysqli_error($con));
        $rowpcon = mysqli_fetch_assoc($rsltniv);
    } else if ($row["idexamenpatient"] != NULL) {
        $rsltniv = $con->query("select * from hp_examen_patient as c left join hp_sous_dossier as sd on c.idsousdossier=sd.idsousdossier "
                . "left join hp_dossier as d on sd.iddossier=d.iddossier left join hp_patient as p on d.idpatient=p.idpatient left join "
                . "hp_departement as dp on p.residencepatient=dp.iddepartement where "
                . "c.idexamenpatient='" . $row["idexamenpatient"] . "'") or die(mysqli_error($con));
        $rowpexa = mysqli_fetch_assoc($rsltniv);
    } else if ($row["idechographiepatient"] != NULL) {
        $rsltniv = $con->query("select * from hp_echographie_patient as c left join hp_sous_dossier as sd on c.idsousdossier=sd.idsousdossier "
                . "left join hp_dossier as d on sd.iddossier=d.iddossier left join hp_patient as p on d.idpatient=p.idpatient left join "
                . "hp_departement as dp on p.residencepatient=dp.iddepartement where "
                . "c.idechographiepatient='" . $row["idechographiepatient"] . "'") or die(mysqli_error($con));
        $rowpech = mysqli_fetch_assoc($rsltniv);
    } else if ($row["idactepatient"] != NULL) {
        $rsltniv = $con->query("select * from hp_acte_patient as c left join hp_sous_dossier as sd on c.idsousdossier=sd.idsousdossier "
                . "left join hp_dossier as d on sd.iddossier=d.iddossier left join hp_patient as p on d.idpatient=p.idpatient left join "
                . "hp_departement as dp on p.residencepatient=dp.iddepartement where "
                . "c.idactepatient='" . $row["idactepatient"] . "'") or die(mysqli_error($con));
        $rowpact = mysqli_fetch_assoc($rsltniv);
    } else if ($row["idordonnance"] != NULL) {
        $rsltniv = $con->query("select * from hp_ordonnance as c left join hp_sous_dossier as sd on c.idsousdossier=sd.idsousdossier "
                . "left join hp_dossier as d on sd.iddossier=d.iddossier left join hp_patient as p on d.idpatient=p.idpatient left join "
                . "hp_departement as dp on p.residencepatient=dp.iddepartement where "
                . "c.idordonnance='" . $row["idordonnance"] . "'") or die(mysqli_error($con));
        $rowpord = mysqli_fetch_assoc($rsltniv);
    }
    ?>

    <page backtop="5mm" backbottom="5mm" backleft="5mm" backright="5mm">
        <div align="center" style="border-radius: 3mm; border: none; background: #DDDDAA;" >
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
            <h4>
                Re&ccedil;u n&deg; <?php echo $row["codelignecaisse"]; ?>
            </h4>
            <h6>
                Patient : 
                <?php
                if ($rowpcon != NULL) {
//                    print ("Consultation : ");
                    ?> 
                    <?php
                    print ($rowpcon["codepatient"] . " " . $rowpcon["nompatient"] . " " . $rowpcon["prenompatient"]);
                } else if ($rowpexa != NULL) {
//                    print ("Examen : ");
                    ?> 
                    <?php
                    print ($rowpexa["codepatient"] . " " . $rowpexa["nompatient"] . " " . $rowpexa["prenompatient"]);
                } else if ($rowpech != NULL) {
//                    print ("Echographie : ");
                    ?> 
                    <?php
                    print ($rowpech["codepatient"] . " " . $rowpech["nompatient"] . " " . $rowpech["prenompatient"]);
                } else if ($rowpact != NULL) {
//                    print ("Autre : ");
                    ?> 
                    <?php
                    print ($rowpact["codepatient"] . " " . $rowpact["nompatient"] . " " . $rowpact["prenompatient"]);
                } else if ($rowpord != NULL) {
//                    print ("Ordonance : ");
                    ?> 
                    <?php
                    print ($rowpord["codepatient"] . " " . $rowpord["nompatient"] . " " . $rowpord["prenompatient"]);
                }
                ?>
            </h6>
            </th>
            </tr>
            <tr>
                <th style="width: 40%; border: solid 1px #000000;">D&eacute;signation</th>
                <th style="width: 20%; border: solid 1px #000000;">Prix</th>
            </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="width: 40%; border: solid 1px #000000;text-align: left; ">
                        <?php
                        if ($rowpcon != NULL) {
                            print ("Consultation : ");
                            ?> 
                            <?php
                            print nl2br(htmlspecialchars($rowpcon["codeconsultation"]));
                        } else if ($rowpexa != NULL) {
                            print ("Examen : ");
                            ?> 
                            <?php
                            print nl2br(htmlspecialchars($rowpexa["codeexamenpatient"]));
                        } else if ($rowpech != NULL) {
                            print ("Echographie : ");
                            ?> 
                            <?php
                            print nl2br(htmlspecialchars($rowpech["codeechographiepatient"]));
                        } else if ($rowpact != NULL) {
                            print ("Autre : ");
                            ?> 
                            <?php
                            print nl2br(htmlspecialchars($rowpact["codeactepatient"]));
                        } else if ($rowpord != NULL) {
                            print ("Ordonance : ");
                            ?> 
                            <?php
                            print nl2br(htmlspecialchars($rowpord["codeordonnance"]));
                        }
                        ?>
                    </td>
                    <td style="width: 20%; border: solid 1px #000000;text-align: right; "><?php echo number_format(($row["montantlignecaisse"]), 0, ',', ' ') ?></td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <th style="width: 45%; border: solid 1px #000000;text-align: center;" colspan="2">Re&ccedil;u du : <?php echo $row["datejourlignecaisse"] ?></th>
                    <td style="width: 45%; border: solid 1px #000000;text-align: right; background: #CCFFCC; font-size: 10pt;  " colspan="3"><?php echo number_format(($row["montantlignecaisse"]), 0, ',', ' ') ?></td>
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

