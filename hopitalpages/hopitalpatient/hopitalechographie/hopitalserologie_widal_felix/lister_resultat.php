<?php
if ((isset($_REQUEST["idechographiepatient"]))) {
    $idep = $_REQUEST["idechographiepatient"];

    $req_fin = $con->query("select * from hp_echographie_patient as ep left join hp_sous_dossier as sd on "
            . "ep.idsousdossier=sd.idsousdossier left join hp_dossier as d on sd.iddossier=d.iddossier "
            . "left join hp_patient as p on d.idpatient=p.idpatient left join hp_departement as dp on "
            . "p.residencepatient=dp.iddepartement where ep.idechographiepatient='" . $idep . "'") or die(mysqli_error($con));
    $row = mysqli_fetch_assoc($req_fin);
    $req_fine = $con->query("select * from hp_echographie as e left join hp_laboratoire as l on e.idlaboratoire=l.idlaboratoire "
            . "left join hp_service as s on l.idservice=s.idservice left join hp_unite as u on e.idunite=u.idunite "
            . "where e.idechographie='" . $row["idechographie"] . "'") or die(mysqli_error($con));
    $rowe = mysqli_fetch_assoc($req_fine);
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
                                    <h1 style=" text-align: center;"><?php echo $rowe["nomlaboratoire"]; ?></h1>
                                    <h5>
                                        <small> Nons et pr&eacute;noms : </small> 
                                        <?php echo $row["nompatient"]; ?> <?php echo $row["prenompatient"]; ?>
                                    </h5>

                                    <h5>
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
                                    </h5>
                                    <h5>
                                        <small>Orientation clinique : </small>
                                        <?php echo $row["orientationechographiepatient"]; ?>
                                    </h5>
                                    <h5>
                                        <small>Date pr&eacute;l&egrave;vement : </small>
                                        <?php echo $row["dateprelevementechographiepatient"]; ?>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <small>Prescription : </small>
                                        <?php echo $row["prescriptionechographiepatient"]; ?>
                                    </h5>
                                </div> 
                            </div>

                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style=" text-align: center;">
                                    <h4><?php echo $rowe["typeechographie"]; ?></h4>
                                </div>
                            </div>
                            <a href="hopitalpages/hopitalpatient/hopitalechographie/hopitalserologie_widal_felix/resultat_echographie_patient_pdf.php?idechographiepatient=<?php echo $idep ?>" class="btn btn-lg btn-success pull-right" target="_blank">
                                <span title="Imprimer le R&eacute;sultat des examans de ce patient" alt="editer"><i class="glyphicon glyphicon-file"></i> Imprimer le R&eacute;sultat</span>
                            </a>
                            <table class="table " border="0">
                                <tbody>
                                    <?php
                                    $reqr = $con->query("select * from hp_serologie_widal_felix as n left join hp_resultat_echographie as r on n.idresultatechographie=r.idresultatechographie "
                                            . "where r.idechographiepatient='" . $idep . "' "
                                            . "") or die(mysqli_error($con));
                                    $rownf = mysqli_fetch_array($reqr);
                                    ?>
                                <tr>
                                    <td>
                                        <b>.</b>
                                    </td>
                                    <td>
                                        TO : <b><?php print nl2br(htmlspecialchars($rownf['toserologiewidalfelix'])); ?></b>
                                    </td>
                                    <td>
                                        TH : <b><?php print nl2br(htmlspecialchars($rownf['thserologiewidalfelix'])); ?></b>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <b>.</b>
                                    </td>
                                    <td>
                                        AO : <b><?php print nl2br(htmlspecialchars($rownf['aoserologiewidalfelix'])); ?></b>
                                    </td>
                                    <td>
                                        AH : <b><?php print nl2br(htmlspecialchars($rownf['ahserologiewidalfelix'])); ?></b>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <b>.</b>
                                    </td>
                                    <td>
                                        BO : <b><?php print nl2br(htmlspecialchars($rownf['boserologiewidalfelix'])); ?></b>
                                    </td>
                                    <td>
                                        BH : <b><?php print nl2br(htmlspecialchars($rownf['bhserologiewidalfelix'])); ?></b>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <b>.</b>
                                    </td>
                                    <td>
                                        CO : <b><?php print nl2br(htmlspecialchars($rownf['coserologiewidalfelix'])); ?></b>
                                    </td>
                                    <td>
                                        CH : <b><?php print nl2br(htmlspecialchars($rownf['chserologiewidalfelix'])); ?></b>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <p style=" text-align: justify">
                                        Interpretaion et conclusion :
                                        <b><?php echo $rownf['interpretationserologiewidalfelix']; ?></b>
                                    </p>
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