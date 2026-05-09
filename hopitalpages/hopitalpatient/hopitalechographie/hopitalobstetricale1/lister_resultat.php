<?php
if ((isset($_REQUEST["idechographiepatient"]))) {
    $idep = $_REQUEST["idechographiepatient"];

    $req_fin = $con->query("select * from hp_echographie_patient as ep left join hp_sous_dossier as sd on "
            . "ep.idsousdossier=sd.idsousdossier left join hp_dossier as d on sd.iddossier=d.iddossier "
            . "left join hp_patient as p on d.idpatient=p.idpatient left join hp_departement as dp on "
            . "p.residencepatient=dp.iddepartement where ep.idechographiepatient='" . $idep . "'") or die(mysqli_error($con));
    $row = mysqli_fetch_assoc($req_fin);
    $req_fine = $con->query("select * from hp_echographie as e left join hp_acte as l on e.idacte=l.idacte "
            . "left join hp_service as s on l.idservice=s.idservice where e.idechographie='" . $row["idechographie"] . "'") or die(mysqli_error($con));
    $rowe = mysqli_fetch_assoc($req_fine);

    $reqr = $con->query("select * from hp_obstetricale_1 as n left join hp_resultat_echographie as r on n.idresultatechographie=r.idresultatechographie "
            . "where r.idechographiepatient='" . $idep . "' "
            . "") or die(mysqli_error($con));
    $rownf = mysqli_fetch_array($reqr);
    ?>
    <div class="single-product-tab-area mg-tb-15">
        <!-- Single pro tab review Start-->
        <div class="single-pro-review-area">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="sparkline12-list mt-b-30">
                            <div class="sparkline12-hd">
                                <div class="main-sparkline12-hd">
                                    <?php
                                    if ((isset($_SESSION["loginproprietaire"]) && isset($_SESSION["motdepasseproprietaire"])) || (isset($_SESSION["logincomptepersonnel"]) && isset($_SESSION["motdepassecomptepersonnel"]) && ($_SESSION["etatcomptepersonnel"]) && (($_SESSION["rolepersonnel"] == "Echographe")))) {
                                          ?>
                                        <div >
                                            <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitalechographie/hopitalobstetricale1/hopitalediter/edit_echographie'); ?>&idobstetricale1=<?php echo $rownf["idobstetricale1"]; ?>" class="btn btn-primary btn-sm pull-right"><i class="glyphicon glyphicon-edit"></i> Modifier</a>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                    <h1 style=" text-align: center;">Compte rendu d'exploration echographique </h1>
                                    <a href="hopitalpages/hopitalpatient/hopitalechographie/hopitalobstetricale1/resultat_echographie_patient_pdf.php?idechographiepatient=<?php echo $idep ?>" class="btn btn-lg btn-success pull-right" target="_blank">
                                        <span title="Imprimer le R&eacute;sultat des &eacute;chographies de ce patient" alt="editer"><i class="glyphicon glyphicon-file"></i> Imprimer le R&eacute;sultat</span>
                                    </a>
                                    <h5>
                                        <small> Nons et pr&eacute;noms : </small> 
                                        <?php echo $row["nompatient"]; ?> <?php echo $row["prenompatient"]; ?>
                                    </h5>

                                    <h5>
                                        <small>Age / Sexe : </small>
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
                                        ?> / <?php echo $row["sexepatient"]; ?>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <small> DDR : </small> <?php echo $rownf["datedernierregleobstetricale1"]; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <small> DPA : </small> <?php echo $rownf["dpaobstetricale1"]; ?>

                                    </h5>
                                    <h5>
                                        <small>Type d’examen : </small>
                                        <?php echo $rowe["nomechographie"]; ?>
                                    </h5>
                                    <h5>
                                        <small>Prescripteur : </small>
                                        <?php echo $row["prescripteurechographiepatient"]; ?>
                                    </h5>
                                    <h5>
                                        <small>Indication : </small>
                                        <?php echo $row["indicationechographiepatient"]; ?>
                                    </h5>
                                    <h5>
                                        <small>Date d'examen : </small>
                                        <?php echo $rownf["datejourobstetricale1"]; ?>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <small>Heure : </small>
                                        <?php echo $rownf["heureobstetricale1"]; ?>
                                    </h5>

                                </div> 
                            </div>

                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style=" text-align: center;">
                                    <h4><u>RESULTATS</u></h4>
                                </div>
                            </div>
                            <table  border="0">
                                <tbody>

                                    <tr>
                                        <td colspan="4">
                                            <b>. &nbsp;&nbsp;&nbsp; <?php print nl2br(htmlspecialchars($rownf['gravideobstetricale1'])); ?></b> 
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4">
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                                            - &nbsp;&nbsp;&nbsp; Si&egrave;ge  : <b><?php print nl2br(htmlspecialchars($rownf['localisationobstetricale1'])); ?></b> 
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4">
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                                            - &nbsp;&nbsp;&nbsp; Nombre d'embryon c: <b><?php print nl2br(htmlspecialchars($rownf['nombrefoetusobstetricale1'])); ?></b> 
                                        </td>
                                    </tr>
                                    <tr><td colspan="4">. &nbsp;&nbsp;&nbsp; Signes de vitalit&eacute; :</td></tr>

                                    <tr>
                                        <td colspan="4">
                                             &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            - &nbsp;&nbsp;&nbsp; Mouvements actifs : <b><?php print nl2br(htmlspecialchars($rownf['mouvementactifobstetricale1'])); ?></b>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4">
                                             &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            - &nbsp;&nbsp;&nbsp; Activit&eacute; cardiaque :  <b><?php print nl2br(htmlspecialchars($rownf['activitecardiaqueobstetricale1'])); ?></b>
                                        de fr&eacute;quence <b><?php print nl2br(htmlspecialchars($rownf['frequencecardiaqueobstetricale1'])); ?> </b> battements par minutes
                                        </td>
                                    </tr>    
                                    <tr><td colspan="4">. &nbsp;&nbsp;&nbsp; Biom&eacute;trie :</td></tr>
                                    <tr>
                                        <td>
                                             &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            - &nbsp;&nbsp;&nbsp; longueur sac gestationnel : <b><?php print nl2br(htmlspecialchars($rownf['longueursacobstetricale1'])); ?></b> mm
                                        </td>
                                    </tr> 
                                    <tr>
                                        <td>
                                             &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            - &nbsp;&nbsp;&nbsp; Longueur cranio-caudale : <b><?php print nl2br(htmlspecialchars($rownf['longueurcranioobstetricale1'])); ?></b> mm
                                        </td>
                                    </tr> 
                                    <tr>
                                        <td>
                                             &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            - &nbsp;&nbsp;&nbsp; Soit un &acirc;ge &eacute;chographique gestationnel ce jour de <b><?php print nl2br(htmlspecialchars($rownf['semaineobstetricale1'])); ?></b> SA 
                                            et <b><?php print nl2br(htmlspecialchars($rownf['jourobstetricale1'])); ?></b> jour(s)
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4">
                                            . &nbsp;&nbsp;&nbsp; Trophoblaste : <b><?php print nl2br(htmlspecialchars($rownf['trophoblasteobstetricale1'])); ?></b> 
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4">
                                            . &nbsp;&nbsp;&nbsp; Col <b><?php print nl2br(htmlspecialchars($rownf['colobstetricale1'])); ?></b>, 
                                            et long de <b><?php print nl2br(htmlspecialchars($rownf['collongueurobstetricale1'])); ?></b>mm
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4">
                                            . &nbsp;&nbsp;&nbsp; Ovaries et annexes :
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4">
                                             &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            - &nbsp;&nbsp;&nbsp; L'ovaire droit : <b><?php print nl2br(htmlspecialchars($rownf['ovairedroitobstetricale1'])); ?></b> 
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4">
                                             &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            - &nbsp;&nbsp;&nbsp; L'ovaire gauche : <b><?php print nl2br(htmlspecialchars($rownf['ovairegaucheobstetricale1'])); ?></b> 
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4">
                                             &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            - &nbsp;&nbsp;&nbsp; Epanchement : <b><?php print nl2br(htmlspecialchars($rownf['epanchementobstetricale1'])); ?></b> 
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4">
                                             &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            - &nbsp;&nbsp;&nbsp; Vessie : <b><?php print nl2br(htmlspecialchars($rownf['vessieobstetricale1'])); ?></b>. 
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <br>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" >
                                    <h4><u>CONCLUSION</u> : </h4>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <?php print trim(stripcslashes($rownf['conclusionobstetricale1'])); ?>
                                </div>
                            </div>
                            <br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
}
?>