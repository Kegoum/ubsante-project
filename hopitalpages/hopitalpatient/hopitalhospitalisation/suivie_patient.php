
<script>
    $(document).on("click", ".administrer-soin", function (e) {

        e.preventDefault();

        var _self = $(this);

        var myBookId = _self.data('id');
        $("#idsoinpatientadm").val(myBookId);
        
        var myBookPatient = _self.data('patient');
        $("#patientadm").val(myBookPatient);
        var myBookSoin = _self.data('soin');
        $("#soinadm").val(myBookSoin);
//    $("#btnchap").submit();
//        $("#btnchap").ajaxForm({
//        }).submit();

//    $(_self.attr('href')).modal('show');
    });

</script>

<?php
if ((isset($_REQUEST["idhospitalisation"]))) {
//    $dated = $_POST["datedcp"];
//    $datef = $_POST["datefcp"];
    $id = $_REQUEST["idhospitalisation"];
    $req_fin = $con->query("select * from hp_hospitalisation as h left join hp_sous_dossier as sd on "
            . "h.idsousdossier=sd.idsousdossier left join hp_dossier as d on sd.iddossier=d.iddossier left join "
            . "hp_patient as p on d.idpatient=p.idpatient left join hp_departement as de on p.residencepatient=de.iddepartement "
            . "left join hp_region as r on de.idregion=r.idregion where h.idhospitalisation='" . $id . "'") or die(mysqli_error($con));
    $recuser = mysqli_fetch_assoc($req_fin);
    $rsltpl = $con->query("select * from hp_deplacement_patient as dp left join hp_facture as f on "
            . "dp.iddeplacementpatient=f.iddeplacementpatient where dp.idhospitalisation='" . $recuser["idhospitalisation"] . "' "
            . "and dp.regledeplacementpatient=false order by dp.datedeplacementpatient desc limit 0,1 ") or die(mysqli_error($con));
    $rowpl = mysqli_fetch_assoc($rsltpl);
    $rsltpl2 = $con->query("select * from hp_deplacement_patient as dp left join hp_facture as f on "
            . "dp.iddeplacementpatient=f.iddeplacementpatient where dp.idhospitalisation='" . $recuser["idhospitalisation"] . "' "
            . "and dp.regledeplacementpatient=false order by dp.datedeplacementpatient desc limit 0,1") or die(mysqli_error($con));
    $rowpl2 = mysqli_fetch_assoc($rsltpl2);
    $today = date('Y-m-d H:i:s');
    $dif = dateDiff($rowpl["datedebutdeplacementpatient"], $today);
    $rsltuarpa = $con->query("select * from hp_soin_patient as lo left join hp_soin as a on "
            . "lo.idsoin=a.idsoin where lo.idhospitalisation='" . $recuser["idhospitalisation"] . "'") or die(mysqli_error($con));
    ?>
    <div class="data-table-area mg-b-15">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="sparkline13-list">
                        <div class="sparkline13-hd">
                            <div class="main-sparkline13-hd">

                                <h1>
                                    Fiche de planification et de suivie des patients en hospitalisation <br>
                                    Noms et pr&eacute;noms <?php echo $recuser["nompatient"]; ?> <?php
                                    echo $recuser["prenompatient"];
                                    ?>
                                </h1>
                            </div>
                        </div>

                        <table id="table" data-toggle="table" data-pagination="true" data-search="true" data-show-columns="true" data-show-pagination-switch="true" data-show-refresh="true" data-key-events="true" data-show-toggle="true" data-resizable="true" data-cookie="true"
                               data-cookie-id-table="saveId" data-show-export="true" data-click-to-select="true" data-toolbar="#toolbar">
                            <thead>
                                <tr>
                                    <th data-field="state" data-checkbox="true"></th>
                                    <th>MEDICAMENTS Voie administration Posologie</th>
                                    <th>Date/ heure administration selon NYCTHEMERE</th>
                                    <th>Op&eacute;ration</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                while ($rowarpa = mysqli_fetch_assoc($rsltuarpa)) {
                                    ?>
                                    <tr >
                                        <td></td>
                                        <td>
                                            <?php print nl2br(htmlspecialchars($rowarpa["libellesoin"])) ?> &nbsp;&nbsp;&nbsp;
                                            <?php print nl2br(htmlspecialchars($rowarpa["dosagesoinpatient"])) ?>/
                                            <?php print nl2br(htmlspecialchars($rowarpa["intervallesoinpatient"])) ?>&nbsp;&nbsp;
                                            <?php print nl2br(htmlspecialchars($rowarpa["periodesoinpatient"])) ?> fois
                                        </td>
                                        <td>

                                            <?php
                                            $rsltuarpaa = $con->query("select * from hp_administration_soin_patient as asp left join hp_compte_personnel a"
                                                    . "s cp on asp.idcomptepersonnel=cp.idcomptepersonnel where asp.idsoinpatient='" . $rowarpa["idsoinpatient"] . "'") or die(mysqli_error($con));
                                            while ($rowarpaa = mysqli_fetch_assoc($rsltuarpaa)) {
                                                print $rowarpaa["datejouradministrationsoinpatient"];
                                                ?> <?php print $rowarpaa["heureadministrationsoinpatient"]; ?> <?php
                                                print $rowarpaa["logincomptepersonnel"];?> | <?php
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            $pati=$recuser["codepatient"]."-".$recuser["nompatient"]."-".$recuser["prenompatient"];
                                            $soi=$rowarpa["libellesoin"];
                                            if (($rowarpa["etatsoinpatient"] == "Payé") || (($rowarpa["idhospitalisation"] != NULL) && ($rowarpa["etatsoinpatient"] != "Livré"))) {
                                                if ((isset($_SESSION["loginproprietaire"]) && isset($_SESSION["motdepasseproprietaire"])) || (isset($_SESSION["logincomptepersonnel"]) && isset($_SESSION["motdepassecomptepersonnel"]) && ($_SESSION["etatcomptepersonnel"]) && (($_SESSION["rolepersonnel"] == "Médecin") || ($_SESSION["rolepersonnel"] == "Infirmier")))) {
                                                    ?> 
                                                    <a href="#modaladminsoin" role="button" data-toggle="modal" data-id="<?php echo $rowarpa["idsoinpatient"] ?>" data-patient="<?php echo $pati ?>" data-soin="<?php echo $soi ?>" class="administrer-soin">
                                                        <span title="Administrer ce soin" alt="editer"><i class="glyphicon glyphicon-credit-cardglyphicon glyphicon-check"></i></span>
                                                    </a>
                                                    <?php
                                                }
                                            }
                                            ?> 
                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </tbody>
                        </table>    
                    </div>
                </div>
            </div>
        </div>       
    </div>
    <?php
}
?>
<?php
include('hopitalpages/hopitalpatient/hopitalhospitalisation/hopitaladministrer/administrer_soin.php');
?>