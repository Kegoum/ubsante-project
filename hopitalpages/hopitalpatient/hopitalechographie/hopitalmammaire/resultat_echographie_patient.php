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

if ((isset($_REQUEST["idechographiepatient"]))) {
    $idep = $_REQUEST["idechographiepatient"];

    $date = date('Y-m-d');
    $date2 = date('d-m-Y');


    $req_fin = $con->query("select * from hp_echographie_patient as ep left join hp_sous_dossier as sd on "
            . "ep.idsousdossier=sd.idsousdossier left join hp_dossier as d on sd.iddossier=d.iddossier "
            . "left join hp_patient as p on d.idpatient=p.idpatient left join hp_departement as dp on "
            . "p.residencepatient=dp.iddepartement where ep.idechographiepatient='" . $idep . "'") or die(mysqli_error($con));
    $row = mysqli_fetch_assoc($req_fin);
    $req_fine = $con->query("select * from hp_echographie as e left join hp_acte as l on e.idacte=l.idacte "
            . "left join hp_service as s on l.idservice=s.idservice where e.idechographie='" . $row["idechographie"] . "'") or die(mysqli_error($con));
    $rowe = mysqli_fetch_assoc($req_fine);

    $reqr = $con->query("select * from hp_mammaire as n left join hp_resultat_echographie as r on n.idresultatechographie=r.idresultatechographie "
            . "where r.idechographiepatient='" . $idep . "' "
            . "") or die(mysqli_error($con));
    $rownf = mysqli_fetch_array($reqr);
    ?>

    <page backtop="5mm" backbottom="5mm" backleft="5mm" backright="5mm">

        <table style="width: 100%; font-size: 11pt;">
            <tr>
                <td colspan="2" style="text-align: center; width: 100%;">
                    <b style="font-size : 20pt;"><?php echo strtoupper($rowhote["hopitalproprietaire"]); ?> </b>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: center; width: 100%"><?php echo ($rowhote["adressehopital"]); ?></td>
            </tr>
            <tr>
                <td style="text-align: left; width: 50%">B. P. <?php echo $rowhote["bpproprietaire"]; ?> <?php echo $rowhote["cheflieuregion"]; ?></td>
                <td style="text-align: right; width: 50%">T&eacute;l: <?php echo $rowhote["telephoneproprietaire"]; ?></td>
            </tr>
        </table>
        <hr>
        <!--<hr>-->
    <!--        <table style="width: 100%; font-size: 14pt;">
            <tr>
                <td style="text-align: left; width: 17%">&nbsp;</td>
                <td style="text-align: center; width: 66%"><i><?php // echo $rowhote["textehopital"];        ?></i></td>
                <td style="text-align: right; width: 17%">&nbsp;</td>
            </tr>
        </table>-->
        <br>
        <table cellspacing="0" style="width: 100%; text-align: center; font-size: 7px" align="center">
            <tr>
                <td style="width: 100%; text-align: center; font-size: 10pt;">
                    <b style="font-size : 16pt;"><?php echo strtoupper("Compte rendu de l'exploration echographique"); ?>
                    </b>
                </td>
            </tr>
        </table>
        <br>
        <table align="center" style="width: 100%; text-align: justify; font-size: 11pt; border-radius: 5mm; border: 1mm #007ee5; height: 100mm;" >
            <tr>
                <td style="width: 100%; text-align: center">


                    Date de réalisation de L’examen : 
                    <?php
                    $datj = explode('-', $rownf["datejourmammaire"]);
                    $datej = $datj[2] . " / " . $datj[1] . " / " . $datj[0];
                    echo $datej;
                    ?>
                </td>
            </tr>
            <tr>
                <td style="width: 100%; ">
                    Noms et prénoms : Mme <?php echo $row["nompatient"]; ?> <?php echo $row["prenompatient"]; ?>. 
                    &nbsp;&nbsp;&nbsp;&acirc;ge : 
                    <?php
                    $today = date('Y-m-d H:i:s');
                    $dif = dateDiff($row["datenaissancepatient"], $today);
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
                    &nbsp;&nbsp;&nbsp;sexe : <?php echo $row["sexepatient"]; ?> 
                    &nbsp;&nbsp;&nbsp;profession : <?php echo $row["professionpatient"]; ?>
                </td>
            </tr>
            <tr>
                <td style="width: 100%; ">
                    Type d’examen : <?php echo $rowe["nomechographie"]; ?> 
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Indications : <?php echo $row["indicationechographiepatient"]; ?>.
                </td>
            </tr>
            <tr>
                <td style="width: 100%; ">
                    Prescripteur : <?php echo $row["prescripteurechographiepatient"]; ?>.
                </td>
            </tr>
        </table>
         <br> <br>
        <table cellspacing="0" style="padding: 1px; width: 100%; font-size: 11pt; ">
                                <tbody>

                                <tr>
                                    <td>
                                        <b>* &nbsp;&nbsp;&nbsp; <u>A l'examen physique</u> : </b>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <?php print nl2br(stripcslashes($rownf['physiquemammaire'])); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        &nbsp;
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <b>* &nbsp;&nbsp;&nbsp; <u>A l'exploration ultra sonographique</u> : </b>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <?php print nl2br(stripcslashes($rownf['sonographiquemammaire'])); ?>
                                    </td>
                                </tr>
                                </tbody>
        </table>
            <!--<p style=" text-align: center;">-->
                 &nbsp;&nbsp;&nbsp;  &nbsp;&nbsp;&nbsp; <h4><u>CONCLUSION</u> : </h4>
<!--            </p>
            <p style="text-align: justify;">-->
                <b><?php echo $rownf['conclusionmammaire']; ?></b>
            <!--</p>-->
        <br><br>
        <div align="right" >
            <?php echo $rowhote["cheflieuregion"]; ?>, le <?php echo $date2; ?><br><br>  
            L'&eacute;chographiste
        </div>
        <!--<br><br><br><br>-->

        <div align="center" >
            <b style="font-size: 8pt;">
            <!--<<--> 
                <?php // echo ($rowhote["sloganproprietaire"]); ?> 
                <!-->>--> 
            </b>
        </div>

    </page>
    <?php
}
?>

