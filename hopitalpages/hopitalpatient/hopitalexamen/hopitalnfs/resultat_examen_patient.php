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

        <table style="width: 100%; font-size: 13pt;">
            <tr>
                <td colspan="2" style="text-align: center; width: 100%;">
                    <b><h1><?php echo strtoupper($rowhote["hopitalproprietaire"]); ?> </h1></b>
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
        <hr>
        <table style="width: 100%; font-size: 14pt;">
            <tr>
                <td style="text-align: left; width: 17%">&nbsp;</td>
                <td style="text-align: center; width: 66%"><i><?php echo $rowhote["textehopital"]; ?></i></td>
                <td style="text-align: right; width: 17%">&nbsp;</td>
            </tr>
        </table>
        <table cellspacing="0" style="width: 100%; text-align: center; font-size: 7px" align="center">
            <tr>
                <td style="width: 100%; text-align: center; font-size: 10pt;">
                    <h1 style="border-radius: 3mm; border: solid 1px #000000;">
                        <?php echo strtoupper($rowe["nomlaboratoire"]); ?>
                    </h1>
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
                        <small>Sexe : </small>
                        <?php echo $row["sexepatient"]; ?>
                    </div>
                    <div>
                        <small>Orientation clinique : </small>
                        <?php echo $row["orientationexamenpatient"]; ?>
                    </div>
                    <div>
                        <small>Date pr&eacute;l&egrave;vement : </small>
                        <?php echo $row["dateprelevementexamenpatient"]; ?>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <small>Prescripteur : </small>
                        <?php echo $row["prescriptionexamenpatient"]; ?>
                    </div>
                </td>
            </tr>
        </table>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style=" text-align: center;">
                <h4><?php echo $rowe["typeexamen"]; ?></h4>
            </div>
        </div>
        <table cellspacing="0" style="padding: 1px; width: 100%; border: solid 2px #000000; border-radius: 10px; font-size: 9pt; ">

            <thead>
                <tr class="btn-info ">
                    <th style="width: 30%; text-align: center; border: solid 1px #000000;">El&eacute;ments</th>
                    <th rowspan="2" style="width: 10%; text-align: center; border: solid 1px #000000;">Valeurs patients</th>
                    <th colspan="4" style="width: 60%; text-align: center; border: solid 1px #000000;">Valeurs normales</th>
                </tr>

                <tr class="btn-info ">
                    <th style="width: 30%; text-align: center; border: solid 1px #000000;"></th>
                    <th style="width: 15%; text-align: center; border: solid 1px #000000;">0 &agrave; 29 jours</th>
                    <th style="width: 15%; text-align: center; border: solid 1px #000000;">&#60;= 6 ans</th>
                    <th style="width: 15%; text-align: center; border: solid 1px #000000;">Adultes Femmes</th>
                    <th style="width: 15%; text-align: center; border: solid 1px #000000;">Adultes Hommes</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $reqr = $con->query("select * from hp_nfs as n left join hp_resultat_examen as r on n.idresultatexamen=r.idresultatexamen "
                        . "where r.idexamenpatient='" . $idep . "' "
                        . "") or die(mysqli_error($con));
                $rownf = mysqli_fetch_array($reqr);
                $reqmc = $con->query("select * from hp_detail_nfs as dn left join hp_ligne_nfs as n on dn.idlignenfs=n.idlignenfs "
                        . "left join hp_unite as u on n.idunite=u.idunite where dn.idnfs='" . $rownf["idnfs"] . "' "
                        . "") or die(mysqli_error($con));
                while ($rowlnf = mysqli_fetch_array($reqmc)) {
                    ?>
                    <tr>
                        <td style="width: 30%; text-align: left; border: solid 1px #000000;">
                            <?php print nl2br(htmlspecialchars($rowlnf['libellelignenfs'])); ?> 
                            (<?php print nl2br(htmlspecialchars($rowlnf['codelignenfs'])); ?>)
                        </td>
                        <td style="width: 10%; text-align: center; border: solid 1px #000000;">
                            <b>
                                <?php
                                if ($dif[0] != 0) {
                                    if ($dif[2] <= 6) {
                                        if (($rowlnf['valeurdetailnfs'] >= $rowlnf['6anminlignenfs']) && ($rowlnf['valeurdetailnfs'] <= $rowlnf['6anmaxlignenfs'])) {
                                            ?>
                                            <label style="color: green;"><?php echo $rowlnf['valeurdetailnfs']; ?></label>
                                            <?php
                                        } else if (($rowlnf['valeurdetailnfs'] > $rowlnf['6anmaxlignenfs'])) {
                                            ?>
                                            <label style="color: red;"><?php echo $rowlnf['valeurdetailnfs']; ?></label>
                                            <?php
                                        } else if (($rowlnf['valeurdetailnfs'] < $rowlnf['6anminlignenfs'])) {
                                            ?>
                                            <label style="color: #660066;"><?php echo $rowlnf['valeurdetailnfs']; ?></label>
                                            <?php
                                        }
                                    } else {
                                        if ($row["sexepatient"] == "Masculin") {
                                            if (($rowlnf['valeurdetailnfs'] >= $rowlnf['adultehommeminlignenfs']) && ($rowlnf['valeurdetailnfs'] <= $rowlnf['adultehommaxinlignenfs'])) {
                                                ?>
                                                <label style="color: green;"><?php echo $rowlnf['valeurdetailnfs']; ?></label>
                                                <?php
                                            } else if (($rowlnf['valeurdetailnfs'] > $rowlnf['adultehommaxinlignenfs'])) {
                                                ?>
                                                <label style="color: red;"><?php echo $rowlnf['valeurdetailnfs']; ?></label>
                                                <?php
                                            } else if (($rowlnf['valeurdetailnfs'] < $rowlnf['adultehommeminlignenfs'])) {
                                                ?>
                                                <label style="color: #660066;"><?php echo $rowlnf['valeurdetailnfs']; ?></label>
                                                <?php
                                            }
                                        } else {
                                            if (($rowlnf['valeurdetailnfs'] >= $rowlnf['adultefemmeminlignenfs']) && ($rowlnf['valeurdetailnfs'] <= $rowlnf['adultefemmemaxlignenfs'])) {
                                                ?>
                                                <label style="color: green;"><?php echo $rowlnf['valeurdetailnfs']; ?></label>
                                                <?php
                                            } else if (($rowlnf['valeurdetailnfs'] > $rowlnf['adultefemmemaxlignenfs'])) {
                                                ?>
                                                <label style="color: red;"><?php echo $rowlnf['valeurdetailnfs']; ?></label>
                                                <?php
                                            } else if (($rowlnf['valeurdetailnfs'] < $rowlnf['adultefemmeminlignenfs'])) {
                                                ?>
                                                <label style="color: #660066;"><?php echo $rowlnf['valeurdetailnfs']; ?></label>
                                                <?php
                                            }
                                        }
                                    }
                                } else if ($dif[1] != 0) {
                                    if (($rowlnf['valeurdetailnfs'] >= $rowlnf['6anminlignenfs']) && ($rowlnf['valeurdetailnfs'] <= $rowlnf['6anmaxlignenfs'])) {
                                        ?>
                                        <label style="color: green;"><?php echo $rowlnf['valeurdetailnfs']; ?></label>
                                        <?php
                                    } else if (($rowlnf['valeurdetailnfs'] > $rowlnf['6anmaxlignenfs'])) {
                                        ?>
                                        <label style="color: red;"><?php echo $rowlnf['valeurdetailnfs']; ?></label>
                                        <?php
                                    } else if (($rowlnf['valeurdetailnfs'] < $rowlnf['6anminlignenfs'])) {
                                        ?>
                                        <label style="color: #660066;"><?php echo $rowlnf['valeurdetailnfs']; ?></label>
                                        <?php
                                    }
                                } else if ($dif[2] != 0) {
                                    if ($dif[2] <= 29) {
                                        if (($rowlnf['valeurdetailnfs'] >= $rowlnf['29jourminlignenfs']) && ($rowlnf['valeurdetailnfs'] <= $rowlnf['29jourmaxlignenfs'])) {
                                            ?>
                                            <label style="color: green;"><?php echo $rowlnf['valeurdetailnfs']; ?></label>
                                            <?php
                                        } else if (($rowlnf['valeurdetailnfs'] > $rowlnf['29jourmaxlignenfs'])) {
                                            ?>
                                            <label style="color: red;"><?php echo $rowlnf['valeurdetailnfs']; ?></label>
                                            <?php
                                        } else if (($rowlnf['valeurdetailnfs'] < $rowlnf['29jourminlignenfs'])) {
                                            ?>
                                            <label style="color: #660066;"><?php echo $rowlnf['valeurdetailnfs']; ?></label>
                                            <?php
                                        }
                                    }
                                } else {
                                    ?>
                                    <label ><?php echo $rowlnf['valeurdetailnfs']; ?></label>
                                    <?php
                                }
                                ?>
                            </b>
                        </td>
                        <td style="width: 15%; text-align: center; border: solid 1px #000000;">
                            <?php print nl2br(htmlspecialchars($rowlnf['29jourminlignenfs'])); ?> - 
                            <?php print nl2br(htmlspecialchars($rowlnf['29jourmaxlignenfs'])); ?>
                        </td>
                        <td style="width: 15%; text-align: center; border: solid 1px #000000;">
                            <?php print nl2br(htmlspecialchars($rowlnf['6anminlignenfs'])); ?> - 
                            <?php print nl2br(htmlspecialchars($rowlnf['6anmaxlignenfs'])); ?>
                        </td>
                        <td style="width: 15%; text-align: center; border: solid 1px #000000;">
                            <?php print nl2br(htmlspecialchars($rowlnf['adultefemmeminlignenfs'])); ?> - 
                            <?php print nl2br(htmlspecialchars($rowlnf['adultefemmemaxlignenfs'])); ?>
                        </td>
                        <td style="width: 15%; text-align: center; border: solid 1px #000000;">
                            <?php print nl2br(htmlspecialchars($rowlnf['adultehommeminlignenfs'])); ?> - 
                            <?php print nl2br(htmlspecialchars($rowlnf['adultehommemaxlignenfs'])); ?> 
                            <?php print nl2br(htmlspecialchars($rowlnf["codeunite"])) ?> 
                        </td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <p style=" text-align: justify">
                    Interpretaion et conclusion :
                    <b><?php echo $rownf['interpretationnfs']; ?></b>
                </p>
            </div>
        </div>
        <br><br><br>
        <div align="right" >
            Date et signature du technicien <br>  <?php echo $date2; ?>
        </div>
        <br><br><br><br>

        <div align="center" >
            <b>
            <!--<<--> 
                <?php echo ($rowhote["sloganproprietaire"]); ?> 
                <!-->>--> 
            </b>
        </div>

    </page>
    <?php
}
?>

