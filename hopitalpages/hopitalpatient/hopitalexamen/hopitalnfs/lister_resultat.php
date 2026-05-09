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

    $reqr = $con->query("select * from hp_nfs as n left join hp_resultat_examen as r on n.idresultatexamen=r.idresultatexamen "
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
                                            <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitalexamen/hopitalnfs/hopitalediter/edit_examen'); ?>&idnfs=<?php echo $rownf["idnfs"]; ?>" class="btn btn-primary btn-sm pull-right"><i class="glyphicon glyphicon-edit"></i> Modifier</a>
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
                            <a href="hopitalpages/hopitalpatient/hopitalexamen/hopitalnfs/resultat_examen_patient_pdf.php?idexamenpatient=<?php echo $idep ?>" class="btn btn-lg btn-success pull-right" target="_blank">
                                <span title="Imprimer le R&eacute;sultat des examans de ce patient" alt="editer"><i class="glyphicon glyphicon-file"></i> Imprimer le R&eacute;sultat</span>
                            </a>
                            <table class="table table-bordered table-striped table-condensed" border="0">
                                <thead>
                                    <tr class="btn-info ">
                                        <th>El&eacute;ments</th>
                                        <th rowspan="2">Valeurs patients</th>
                                        <th colspan="4">Valeurs normales</th>
                                    </tr>

                                    <tr class="btn-info ">
                                        <th></th>
                                        <th>0 &agrave; 29 jours</th>
                                        <th><= 6 ans</th>
                                        <th>Adultes Femmes</th>
                                        <th>Adultes Hommes</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                    $reqmc = $con->query("select * from hp_detail_nfs as dn left join hp_ligne_nfs as n on dn.idlignenfs=n.idlignenfs "
                                            . "left join hp_unite as u on n.idunite=u.idunite where dn.idnfs='" . $rownf["idnfs"] . "' "
                                            . "") or die(mysqli_error($con));
                                    while ($rowlnf = mysqli_fetch_array($reqmc)) {
                                        ?>
                                        <tr>
                                            <td>
                                                <?php print nl2br(htmlspecialchars($rowlnf['libellelignenfs'])); ?> 
                                                (<?php print nl2br(htmlspecialchars($rowlnf['codelignenfs'])); ?>)
                                            </td>
                                            <td>
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
                                                    }else{
                                                        ?>
                                                                <label ><?php echo $rowlnf['valeurdetailnfs']; ?></label>
                                                                <?php
                                                    }
                                                    ?>
                                                </b>
                                            </td>
                                            <td>
                                                <?php print nl2br(htmlspecialchars($rowlnf['29jourminlignenfs'])); ?> - 
                                                <?php print nl2br(htmlspecialchars($rowlnf['29jourmaxlignenfs'])); ?>
                                            </td>
                                            <td>
                                                <?php print nl2br(htmlspecialchars($rowlnf['6anminlignenfs'])); ?> - 
                                                <?php print nl2br(htmlspecialchars($rowlnf['6anmaxlignenfs'])); ?>
                                            </td>
                                            <td>
                                                <?php print nl2br(htmlspecialchars($rowlnf['adultefemmeminlignenfs'])); ?> - 
                                                <?php print nl2br(htmlspecialchars($rowlnf['adultefemmemaxlignenfs'])); ?>
                                            </td>
                                            <td>
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