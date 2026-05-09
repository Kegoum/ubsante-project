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
include('../../../../hopitalconnexion/connexion.php');
include('../../../../hopitalincludes/fonctionglobale.php');

$reqhote = $con->query("select * from hp_proprietaire as p left join hp_departement as d on "
        . "p.iddepartement=d.iddepartement left join hp_region as r on d.idregion=r.idregion ") or die(mysqli_error($con));
$rowhote = NULL;
while ($rowhote1 = mysqli_fetch_assoc($reqhote)) {
    $rowhote = $rowhote1;
}

if ((isset($_REQUEST["idexamenpatient"]))) {
    $idep = $_REQUEST["idexamenpatient"];

    $date = date('Y-m-d');
    $date2 = date('d-m-Y');


    $req_fin = $con->query("select * from hp_examen_patient as ep left join hp_sous_dossier as sd on "
            . "ep.idsousdossier=sd.idsousdossier left join hp_dossier as d on sd.iddossier=d.iddossier "
            . "left join hp_patient as p on d.idpatient=p.idpatient left join hp_departement as dp on "
            . "p.residencepatient=dp.iddepartement where ep.idexamenpatient='" . $idep . "'") or die(mysqli_error($con));
    $row = mysqli_fetch_assoc($req_fin);
    $req_fine = $con->query("select * from hp_examen as e left join hp_laboratoire as l on e.idlaboratoire=l.idlaboratoire "
            . "left join hp_service as s on l.idservice=s.idservice left join hp_unite as u on e.idunite=u.idunite "
            . "where e.idexamen='" . $row["idexamen"] . "'") or die(mysqli_error($con));
    $rowe = mysqli_fetch_assoc($req_fine);
    ?>

    <page backtop="5mm" backbottom="5mm" backleft="5mm" backright="5mm">

        <table style="width: 100%; font-size: 10pt;">
            <tr>
                <td style="text-align: center; width: 30%;">
            <u>REPUBLIQUE DU CAMEROUN</u><br>
            <u>PAIX-TRAVAIL-PATRIE</u><br>
            <u style=' font-size: 8pt;'>MINISTERE DE LA SANTE PUBLIQUE</u><br><br>
            <u style=' font-size: 8pt;'>DISTRICT DE SANTE DE NKOLNDONGO</u>
            </td>
            <td style="text-align: center; width: 40%">
                <b style="font-size : 12pt;"><?php echo strtoupper($rowhote["hopitalproprietaire"]); ?> </b><br>
                <?php echo ($rowhote["adressehopital"]); ?><br>
                T&eacute;l: <?php echo $rowhote["telephoneproprietaire"]; ?>
            </td>
            <td style="text-align: center; width: 30%">
            <u>REPUBLIC OF CAMEROON</u><br>
            <u>PEACE-WORK-FARTHERLAND</u><br>
            <u style=' font-size: 8pt;'>MINISTRY OF PUBLIC HEALTH</u><br><br>
            <u style=' font-size: 8pt;'>NKOLNDONGO HEALTH DISTRICT </u>
            </td>
            </tr>
        </table>
        <hr>
        <!--<hr>-->
    <!--        <table style="width: 100%; font-size: 14pt;">
            <tr>
                <td style="text-align: left; width: 17%">&nbsp;</td>
                <td style="text-align: center; width: 66%"><i><?php // echo $rowhote["textehopital"];   ?></i></td>
                <td style="text-align: right; width: 17%">&nbsp;</td>
            </tr>
        </table>-->
        <table cellspacing="0" style="width: 100%; text-align: center; font-size: 7px" align="center">
            <tr>
                <td style="width: 100%; text-align: center; font-size: 10pt;">
                    <b style="font-size : 16pt;">BULLETIN D'EXAMEN
                    </b>
                </td>
            </tr>
        </table>
        <table style="width: 100%; font-size: 12pt;" >
            <tr>
                <td style="width: 100%; font-size: 12pt;">
                    <div>
                        <small> Nons et pr&eacute;noms : </small> 
                        <?php echo $row["nompatient"]; ?> <?php echo $row["prenompatient"]; ?>
                    </div>

                    <div>
                        <small>Age : </small>
                        <?php
                        $today = date('Y-m-d H:i:s');
                        $dif = dateDiff($row["datenaissancepatient"], $today);
//                                        print_r($dif);
                        ?>
                        <?php
                        if ($dif[0] != 0) {
                            ?>
                            &nbsp;&nbsp;<?php echo $dif[0] . " an(s)"; ?>
                            <?php
                        } else if ($dif[1] != 0) {
                            ?>
                            &nbsp;&nbsp; <?php echo $dif[1] . " mois"; ?>
                            <?php
                        } else if ($dif[2] != 0) {
                            ?>
                            &nbsp;&nbsp;<?php echo $dif[2] . " Jours "; ?>
                            <?php
                        }
                        ?> 
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <small>Sexe : </small>
                        <?php echo $row["sexepatient"]; ?>
                    </div>
                    <div>
                        <small>Orientation clinique : </small>
                        <?php echo $row["orientationexamenpatient"]; ?>
                    </div>
                    <div>
                        <small>Adresse / T&eacute;l : </small>
                        <?php echo $row["telephonepatient"]; ?>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <small>Date : </small>
                        <?php echo $row["dateprelevementexamenpatient"]; ?>
                    </div>
                </td>
            </tr>
        </table>

        <?php
        $reqr = $con->query("select * from hp_resultat_examen where idexamenpatient='" . $idep . "'") or die(mysqli_error($con));
        $rownf = mysqli_fetch_array($reqr);
        ?>
        <br>
        <table cellspacing="0" style="padding: 1px; width: 100%; border: solid 2px #000000; border-radius: 10px; font-size: 9pt; ">
            <thead>
                <tr>
                    <th style=" width: 50%; border: solid 1px #000000;">EXAMENS DEMANDES</th>
                    <th style=" width: 50%; border: solid 1px #000000;">RESULTAT</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style=" width: 50%; border: solid 1px #000000;">
                        <b><?php print nl2br(htmlspecialchars($rowe['nomexamen'])); ?></b>
                    </td>
                    <td style=" width: 50%; border: solid 1px #000000;">
                        <b><?php print nl2br(htmlspecialchars($rownf['conteneurresultatexamen'])); ?></b>
                    </td>
                </tr>
            </tbody>
        </table>
        <br><br>
        <div align="right" >
            <small>Prescripteur : </small>
                        <?php echo $row["prescriptionexamenpatient"]; ?>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <?php echo $rowhote["cheflieuregion"]; ?>, le <?php echo $date2; ?><br><br>  
            Signature du technicien
        </div>
        <br><br><br><br>

        <div align="center" >
            <b style="font-size: 8pt;">
            <!--<<--> 
                <?php echo ($rowhote["sloganproprietaire"]); ?> 
                <!-->>--> 
            </b>
        </div>

    </page>
    <?php
}
?>

