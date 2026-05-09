<?php
if ((isset($_REQUEST["idexamenpatient"]))) {
    $idep = $_REQUEST["idexamenpatient"];

    $req_fin = $con->query("select * from hp_examen_patient as ep left join hp_sous_dossier as sd on "
            . "ep.idsousdossier=sd.idsousdossier left join hp_dossier as d on sd.iddossier=d.iddossier "
            . "left join hp_patient as p on d.idpatient=p.idpatient left join hp_departement as dp on "
            . "p.residencepatient=dp.iddepartement where ep.idexamenpatient='" . $idep . "'") or die(mysqli_error($con));
    $row = mysqli_fetch_assoc($req_fin);
    $req_fine = $con->query("select * from hp_examen as e left join hp_laboratoire as l on e.idlaboratoire=l.idlaboratoire "
            . "left join hp_service as s on l.idservice=s.idservice left join hp_unite as u on e.idunite=u.idunite "
            . "where e.idexamen='" . $row["idexamen"] . "'") or die(mysqli_error($con));
    $rowe = mysqli_fetch_assoc($req_fine);
    ?><?php
    $reqr = $con->query("select * from hp_pcv as n left join hp_resultat_examen as r on n.idresultatexamen=r.idresultatexamen "
            . "where r.idexamenpatient='" . $idep . "' "
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
                                    if ((isset($_SESSION["loginproprietaire"]) && isset($_SESSION["motdepasseproprietaire"])) || (isset($_SESSION["logincomptepersonnel"]) && isset($_SESSION["motdepassecomptepersonnel"]) && ($_SESSION["etatcomptepersonnel"]) && (($_SESSION["rolepersonnel"] == "Laborantin")))) {
                                         ?>
                                        <div >
                                            <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitalexamen/hopitalpcv/hopitalediter/edit_examen'); ?>&idpcv=<?php echo $rownf["idpcv"]; ?>" class="btn btn-primary btn-sm pull-right"><i class="glyphicon glyphicon-edit"></i> Modifier</a>
                                        </div>
                                        <?php
                                    }
                                    ?>
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
                                        <?php echo $row["orientationexamenpatient"]; ?>
                                    </h5>
                                    <h5>
                                        <small>Date pr&eacute;l&egrave;vement : </small>
                                        <?php echo $row["dateprelevementexamenpatient"]; ?>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <small>Prescripteur : </small>
                                        <?php echo $row["prescriptionexamenpatient"]; ?>
                                    </h5>
                                </div> 
                            </div>

                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style=" text-align: center;">
                                    <h4><?php echo $rowe["typeexamen"]; ?></h4>
                                </div>
                            </div>
                            <a href="hopitalpages/hopitalpatient/hopitalexamen/hopitalpcv/resultat_examen_patient_pdf.php?idexamenpatient=<?php echo $idep ?>" class="btn btn-lg btn-success pull-right" target="_blank">
                                <span title="Imprimer le R&eacute;sultat des examans de ce patient" alt="editer"><i class="glyphicon glyphicon-file"></i> Imprimer le R&eacute;sultat</span>
                            </a>
                            <table class="table " border="0">
                                <tbody>
                                    <tr>
                                        <td colspan="3">
                                <u>Aspect du col</u> : <b><?php print nl2br(htmlspecialchars($rownf['aspectcolpcv'])); ?></b>
                                </td>
                                </tr>
                                <tr>
                                    <td colspan="3">
                                <u>Leucorrh&eacute;es</u> :
                                </td>
                                </tr>
                                <tr>
                                    <td>
                                        <b>.</b>
                                    </td>
                                    <td>
                                        Quantit&eacute; : <b><?php print nl2br(htmlspecialchars($rownf['quantitepcv'])); ?></b>
                                    </td>
                                    <td>
                                        Consistance : <b><?php print nl2br(htmlspecialchars($rownf['consistancepcv'])); ?></b>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <b>.</b>
                                    </td>
                                    <td>
                                        Odeur : <b><?php print nl2br(htmlspecialchars($rownf['odeurpcv'])); ?></b>
                                    </td>
                                    <td>
                                        Couleur : <b><?php print nl2br(htmlspecialchars($rownf['couleurpcv'])); ?></b>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3">
                                <u>Etat frais</u> :
                                </td>
                                </tr>
                                <tr>
                                    <td>
                                        <b>.</b>
                                    </td>
                                    <td colspan="2">
                                        Trichomonas vaginalis : <b><?php print nl2br(htmlspecialchars($rownf['trichomonaspcv'])); ?></b>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <b>.</b>
                                    </td>
                                    <td colspan="2">
                                        Levures : <b><?php print nl2br(htmlspecialchars($rownf['levurespcv'])); ?></b>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <b>.</b>
                                    </td>
                                    <td>
                                        Leucocytes : <b><?php print nl2br(htmlspecialchars($rownf['leucocytepcv'])); ?></b>
                                    </td>
                                    <td>
                                        H&eacute;matie : <b><?php print nl2br(htmlspecialchars($rownf['hematiepcv'])); ?></b>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <b>.</b>
                                    </td>
                                    <td>
                                        Clue-cells : <b><?php print nl2br(htmlspecialchars($rownf['cluepcv'])); ?></b>
                                    </td>
                                    <td>
                                        Cellules &eacute;pith&eacute;liales : <b><?php print nl2br(htmlspecialchars($rownf['cellulepcv'])); ?></b>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3">
                                <u>Coloration de GRAM</u> :
                                </td>
                                </tr>
                                <tr>
                                    <td>
                                        <b>.</b>
                                    </td>
                                    <td>
                                        Cocci gram n&eacute;gatif : <b><?php print nl2br(htmlspecialchars($rownf['coccinegatifpcv'])); ?></b>
                                    </td>
                                    <td>
                                        Cocci gram positif : <b><?php print nl2br(htmlspecialchars($rownf['coccipositifpcv'])); ?></b>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <b>.</b>
                                    </td>
                                    <td>
                                        Bacilles gram n&eacute;gatif : <b><?php print nl2br(htmlspecialchars($rownf['bacillesnegatifpcv'])); ?></b>
                                    </td>
                                    <td>
                                        Bacilles gram positif : <b><?php print nl2br(htmlspecialchars($rownf['bacillespositifpcv'])); ?></b>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3">
                                <u>Type de la flore vaginale</u> : <b><?php print nl2br(htmlspecialchars($rownf['aspectcolpcv'])); ?></b>
                                </td>
                                </tr>
                                </tbody>
                            </table>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <p style=" text-align: justify">
                                        Interpretaion et conclusion :
                                        <b><?php echo $rownf['interpretationpcv']; ?></b>
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