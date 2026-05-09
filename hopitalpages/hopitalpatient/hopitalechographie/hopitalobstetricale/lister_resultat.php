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

    $reqr = $con->query("select * from hp_obstetricale as n left join hp_resultat_echographie as r on n.idresultatechographie=r.idresultatechographie "
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
                                            <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitalechographie/hopitalobstetricale/hopitalediter/edit_echographie'); ?>&idobstetricale=<?php echo $rownf["idobstetricale"]; ?>" class="btn btn-primary btn-sm pull-right"><i class="glyphicon glyphicon-edit"></i> Modifier</a>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                    <h1 style=" text-align: center;">Compte rendu d'exploration echographique </h1>
                                    <a href="hopitalpages/hopitalpatient/hopitalechographie/hopitalobstetricale/resultat_echographie_patient_pdf.php?idechographiepatient=<?php echo $idep ?>" class="btn btn-lg btn-success pull-right" target="_blank">
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
                                        <small> DDR : </small> <?php echo $rownf["datedernierregleobstetricale"]; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <small> DPA : </small> <?php echo $rownf["dpaobstetricale"]; ?>

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
                                        <?php echo $rownf["datejourobstetricale"]; ?>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <small>Heure : </small>
                                        <?php echo $rownf["heureobstetricale"]; ?>
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
                                        <td colspan="3">
                                            Localisation de la grossesse <b><?php print nl2br(htmlspecialchars($rownf['localisationobstetricale'])); ?></b> 
                                        </td>
                                        <td>
                                            Nombre de foetus <b><?php print nl2br(htmlspecialchars($rownf['nombrefoetusobstetricale'])); ?></b> 
                                        </td>
                                    </tr>
                                    <tr><td colspan="4">* Signes de vitalit&eacute; :</td></tr>

                                    <tr>
                                        <td colspan="4">
                                            <b>-</b>  Mouvements actifs : <b><?php print nl2br(htmlspecialchars($rownf['mouvementactifobstetricale'])); ?></b>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4">
                                            <b>-</b> Activit&eacute; cardiaque :  <b><?php print nl2br(htmlspecialchars($rownf['activitecardiaqueobstetricale'])); ?></b>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4">
                                            <b>-</b> Fr&eacute;quence cardiaque <b><?php print nl2br(htmlspecialchars($rownf['frequencecardiaqueobstetricale'])); ?> </b> battements par minutes
                                        </td>
                                    </tr>    
                                    <tr><td colspan="4">* Biom&eacute;trie :</td></tr>
                                    <tr>
                                        <td>
                                            BIP : <b><?php print nl2br(htmlspecialchars($rownf['bipobstetricale'])); ?></b> mm
                                        </td>
                                        <td>
                                            PC : <b><?php print nl2br(htmlspecialchars($rownf['pcobstetricale'])); ?></b> mm
                                        </td>
                                        <td>
                                            PA : <b><?php print nl2br(htmlspecialchars($rownf['paobstetricale'])); ?></b> mm
                                        </td>
                                        <td>
                                            LF : <b><?php print nl2br(htmlspecialchars($rownf['longueurfemoraleobstetricale'])); ?></b> mm  
                                        </td>
                                    </tr> 
                                    <tr>
                                        <td >
                                            RCF :  <b><?php print nl2br(htmlspecialchars($rownf['rcfobstetricale'])); ?></b> bpm
                                        </td>
                                        <td>
                                            PFE : <b><?php print nl2br(htmlspecialchars($rownf['poidsfoetalobstetricale'])); ?></b> g
                                        </td>
                                        <td></td>
                                        <td></td>
                                    </tr>   
                                    <tr>
                                        <td colspan="4">
                                            Soit un &acirc;ge &eacute;chographique d&eacute;termin&eacute; &agrave; <b><?php print nl2br(htmlspecialchars($rownf['semaineobstetricale'])); ?></b> SA 
                                            et <b><?php print nl2br(htmlspecialchars($rownf['jourobstetricale'])); ?></b> jour(s),  
                                             DPA : <b><?php print nl2br(htmlspecialchars($rownf['dpaobstetricale'])); ?></b>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4">
                                            *  Morphologie foetale : (ventricules cérébraux, estomac, coeur, rachis, poumons, foie, membres…) <b><?php print nl2br(htmlspecialchars($rownf['morphologieobstetricale'])); ?></b> 
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4">
                                            *  Pr&eacute;sentation <b><?php print nl2br(htmlspecialchars($rownf['presentationobstetricale'])); ?></b>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4">
                                            *  Placenta :
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4">
                                            -  Insertion <b><?php print nl2br(htmlspecialchars($rownf['placentainsertionobstetricale'])); ?></b> 
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4">
                                            -  &Eacute;cho structure : <b><?php print nl2br(htmlspecialchars($rownf['placentaechostructureobstetricale'])); ?></b> 
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4">
                                            * Liquide amniostique : <b><?php print nl2br(htmlspecialchars($rownf['liquideamniostiqueobstetricale'])); ?></b> 
                                            et en quantit&eacute; <b><?php print nl2br(htmlspecialchars($rownf['quantiteliquideobstetricale'])); ?></b>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4">
                                            * Col : <b><?php print nl2br(htmlspecialchars($rownf['colobstetricale'])); ?></b> mm 
                                            et long de <b><?php print nl2br(htmlspecialchars($rownf['collongueurobstetricale'])); ?></b> mm
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
                                    <?php print trim(stripcslashes($rownf['conclusionobstetricale'])); ?>
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