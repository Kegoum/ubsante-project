<?php
if (isset($_GET["idconsultation"])) {
    $id = $_GET["idconsultation"];
    $req_fin = $con->query("select * from hp_consultation as c left join hp_sous_dossier as sd on c.idsousdossier=sd.idsousdossier "
            . "left join hp_dossier as d on sd.iddossier=d.iddossier left join hp_patient as p on d.idpatient=p.idpatient left join "
            . "hp_departement as dp on p.residencepatient=dp.iddepartement where c.idconsultation='" . $id . "'") or die(mysqli_error($con));
    $row = mysqli_fetch_assoc($req_fin);
    ?>
    <div class="data-table-area mg-b-15">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="sparkline13-list">
                        <div class="sparkline13-hd">
                            <div class="main-sparkline13-hd">
                                <?php
                                if ($row["etatconsultation"] != "Terminer") {
                                    ?> 
                                    <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitalconsultation/hopitalajouterplan/ajout_consultation') ?>&idconsultation=<?php echo $id ?>" class="btn btn-primary pull-right">
                                        <span title="Plan du traitement" alt="diag"><i class="glyphicon glyphicon-plus"></i> Le plan du traitement</span>
                                    </a>
                                    <?php
                                }
                                ?> 
                                <h1>Dossier de Consultations de 
                                    <?php echo $row["codepatient"]; ?> <?php echo $row["nompatient"]; ?> <?php
                                    echo $row["prenompatient"];
                                    ?></h1>
                            </div>
                        </div>

                        <?php
                        // On r?cup?re les 2 derniers billets
                        lister_dossier_consultation($id, $con);
                        ?>
                    </div>
                </div>
            </div>
        </div>       
    </div>
    <?php
}
?>