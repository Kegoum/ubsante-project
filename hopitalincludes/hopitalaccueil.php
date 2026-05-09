<?php ?>
<?php ?>
<?php
$rsltuser = $con->query("select * from hp_patient as p left join hp_departement as d on p.residencepatient=d.iddepartement "
        . "left join hp_region as r on d.idregion=r.idregion") or die(mysqli_error($con));
$nbp = mysqli_num_rows($rsltuser);
$rsltuserh = $con->query("select * from hp_hospitalisation as h left join hp_sous_dossier as sd on "
        . "h.idsousdossier=sd.idsousdossier left join hp_dossier as d on sd.iddossier=d.iddossier left join "
        . "hp_patient as p on d.idpatient=p.idpatient left join hp_departement as de on p.residencepatient=de.iddepartement "
        . "left join hp_region as r on de.idregion=r.idregion where h.sortiehospitalisation=false order by "
        . "h.datehospitalisation desc ") or die(mysqli_error($con));
$nbph = mysqli_num_rows($rsltuserh);

$rsltf = $con->query("select * from hp_facture as f") or die(mysqli_error($con));
$nbf = mysqli_num_rows($rsltf);
$rsltfnp = $con->query("select * from hp_facture as f where f.etatfacture=false ") or die(mysqli_error($con));
$nbfnp = mysqli_num_rows($rsltfnp);
$eta = "Actif";
$ope = "Décaissement";
$nbdc = 0;
$rsltuserd = $con->query("select * from hp_ligne_caisse as lc where "
        . "lc.paiementlignecaisse='" . $eta . "' and lc.operationlignecaisse='" . $ope . "' ") or die(mysqli_error($con));
$nbd = mysqli_num_rows($rsltuserd);
if (isset($_SESSION["idcaisse"]) && ($_SESSION["idcaisse"] != NULL)) {
    $rsltuserdc = $con->query("select * from hp_ligne_caisse as lc where "
            . "lc.idcaisse='" . $_SESSION["idcaisse"] . "' and lc.paiementlignecaisse='" . $eta . "' and lc.operationlignecaisse='" . $ope . "' ") or die(mysqli_error($con));

    $nbdc = mysqli_num_rows($rsltuserdc);
} else {
    $rsltuserdc = $con->query("select * from hp_ligne_caisse as lc where "
            . "lc.idcaisse IS NULL and lc.paiementlignecaisse='" . $eta . "' and lc.operationlignecaisse='" . $ope . "' ") or die(mysqli_error($con));

    $nbdc = mysqli_num_rows($rsltuserdc);
}

$pers = $con->query("select * from hp_personnel") or die(mysqli_error($con));
$nbpers = mysqli_num_rows($pers);

$nbphp = 0;
if ($nbp != 0) {
    $nbphp = ($nbph * 100) / $nbp;
}

$nbfnpp = 0;
if ($nbf != 0) {
    $nbfnpp = ($nbfnp * 100) / $nbf;
}
$nbdcp = 0;
if ($nbd != 0) {
    $nbdcp = ($nbdc * 100) / $nbd;
}
if ((isset($_SESSION["logincomptepersonnel"]) && isset($_SESSION["motdepassecomptepersonnel"]) && ($_SESSION["etatcomptepersonnel"]))) {
    if (($_SESSION["rolepersonnel"] == "Accueil")) {
        ?>
        <div class="analytics-sparkle-area animated zoomIn">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-2 col-sm-6 col-xs-12"></div>
                    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                        <div class="analytics-sparkle-line reso-mg-b-30">
                            <div class="analytics-content">
                                <h5>Nouveau Patient</h5>
                                <h2>
                                    <!--<span class="counter"></span>--> 
                                    <span class="tuition-fees">
                                        <a title="Enregistrer un Patient" href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitalajouter/ajout_patient'); ?>" class="btn btn-primary btn-lg">
                                            Enregistrer un Patient
                                        </a>
                                    </span>
                                </h2>
                                <!--<span class="text-success"><?php // echo $nbphp;   ?>%</span>-->
                                <!--                            <div class="progress m-b-0">
                                                                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="<?php echo $nbphp; ?>" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $nbphp; ?>%;"> <span class="sr-only"><?php echo $nbphp; ?>%</span> </div>
                                                            </div>-->
                            </div>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                        <div class="analytics-sparkle-line reso-mg-b-30">
                            <div class="analytics-content">
                                <h5>Hostipatilasiton</h5>
                                <h2><span class="counter"><?php echo $nbph; ?></span> 
                                    <span class="tuition-fees">
                                        <a title="<?php echo $nbph; ?> Patient(s) Hostipatilasé(s)" href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/lister_patient_hospitalisation'); ?>">
                                            Patient(s)
                                        </a>
                                    </span>
                                </h2>
                                <span class="text-success"><?php echo $nbphp; ?>%</span>
                                <div class="progress m-b-0">
                                    <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="<?php echo $nbphp; ?>" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $nbphp; ?>%;"> <span class="sr-only"><?php echo $nbphp; ?>%</span> </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-sm-6 col-xs-12"></div>
                    <!-- ./col -->
                </div>
            </div>
        </div>
        <?php
    }
    if (($_SESSION["rolepersonnel"] == "Directeur de Centre") || ($_SESSION["rolepersonnel"] == "Administrateur")) {
        
    ?>
    <div class="analytics-sparkle-area animated zoomIn">
        <div class="container-fluid">
            <div class="row">
                 <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                    <div class="analytics-sparkle-line reso-mg-b-30">
                        <div class="analytics-content">
                            <h5>Personnel</h5>
                            <h2><span class="counter"><?php echo $nbpers; ?></span> 
                                <span class="tuition-fees">
                                    <a title="<?php echo $nbfnp; ?> Personnels" href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/personnel/lister_personnel'); ?>">
                                        Personnel
                                    </a>
                                </span>
                            </h2>
                            <span class="text-success"><?php echo $nbfnpp; ?>%</span>
                            <div class="progress m-b-0">
                                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="<?php echo $nbfnpp; ?>" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $nbfnpp; ?>%;"> <span class="sr-only"><?php echo $nbfnpp; ?>%</span> </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                    <div class="analytics-sparkle-line reso-mg-b-30">
                        <div class="analytics-content">
                            <h5>Patients</h5>
                            <h2><span class="counter"><?php echo $nbp; ?></span> 
                                <span class="tuition-fees">
                                    <a title="<?php echo $nbfnp; ?> Patients" href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/patient/lister_patient'); ?>">
                                        Liste Patient
                                    </a>
                                </span>
                            </h2>
                            <span class="text-success"><?php echo $nbp; ?>%</span>
                            <div class="progress m-b-0">
                                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="<?php echo $nbp; ?>" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $nbp; ?>%;"> <span class="sr-only"><?php echo $nbp; ?>%</span> </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                        <div class="analytics-sparkle-line reso-mg-b-30">
                            <div class="analytics-content">
                                <h5>Hostipatilasiton</h5>
                                <h2><span class="counter"><?php echo $nbph; ?></span> 
                                    <span class="tuition-fees">
                                        <a title="<?php echo $nbph; ?> Patient(s) Hostipatilasé(s)" href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/lister_patient_hospitalisation'); ?>">
                                            Patient(s)
                                        </a>
                                    </span>
                                </h2>
                                <span class="text-success"><?php echo $nbphp; ?>%</span>
                                <div class="progress m-b-0">
                                    <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="<?php echo $nbphp; ?>" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $nbphp; ?>%;"> <span class="sr-only"><?php echo $nbphp; ?>%</span> </div>
                                </div>
                            </div>
                        </div>
                    </div>
                 <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                    <div class="analytics-sparkle-line reso-mg-b-30">
                        <div class="analytics-content">
                            <h5>Factures impay&eacute;es</h5>
                            <h2><span class="counter"><?php echo $nbfnp; ?></span> 
                                <span class="tuition-fees">
                                    <a title="<?php echo $nbfnp; ?> Facture(s) impay&eacute;e(s)" href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalfacture/lister_facture'); ?>">
                                        Facture(s) impay&eacute;e(s)
                                    </a>
                                </span>
                            </h2>
                            <span class="text-success"><?php echo $nbfnpp; ?>%</span>
                            <div class="progress m-b-0">
                                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="<?php echo $nbfnpp; ?>" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $nbfnpp; ?>%;"> <span class="sr-only"><?php echo $nbfnpp; ?>%</span> </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ./col -->
            </div>
        </div>
    </div>
    <?php
    }

if (($_SESSION["rolepersonnel"] == "Caisse")) {
        
    ?>
    <div class="analytics-sparkle-area animated zoomIn">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                    <div class="analytics-sparkle-line reso-mg-b-30">
                        <div class="analytics-content">
                            <h5>Patient Comptoir</h5>
                            <h2>
                                <!--<span class="counter"></span>--> 
                                <span class="tuition-fees">
                                    <a title="Enregistrer un Patient au Comptoir" href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitalajoutercomptoir/ajout_patient'); ?>" class="btn btn-primary btn-lg">
                                        Enregistrer un Patient au Comptoir
                                    </a>
                                </span>
                            </h2>
                            <!--<span class="text-success"><?php // echo $nbphp;   ?>%</span>-->
                            <!--                            <div class="progress m-b-0">
                                                            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="<?php echo $nbphp; ?>" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $nbphp; ?>%;"> <span class="sr-only"><?php echo $nbphp; ?>%</span> </div>
                                                        </div>-->
                        </div>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                    <div class="analytics-sparkle-line reso-mg-b-30">
                        <div class="analytics-content">
                            <h5>Factures impay&eacute;es</h5>
                            <h2><span class="counter"><?php echo $nbfnp; ?></span> 
                                <span class="tuition-fees">
                                    <a title="<?php echo $nbfnp; ?> Facture(s) impay&eacute;e(s)" href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalfacture/lister_facture'); ?>">
                                        Facture(s) impay&eacute;e(s)
                                    </a>
                                </span>
                            </h2>
                            <span class="text-success"><?php echo $nbfnpp; ?>%</span>
                            <div class="progress m-b-0">
                                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="<?php echo $nbfnpp; ?>" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $nbfnpp; ?>%;"> <span class="sr-only"><?php echo $nbfnpp; ?>%</span> </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                    <div class="analytics-sparkle-line reso-mg-b-30">
                        <div class="analytics-content">
                            <h5>D&eacute;caissements</h5>
                            <h2><span class="counter"><?php echo $nbdc; ?></span> 
                                <span class="tuition-fees">
                                    <a title="<?php echo $nbdc; ?> D&eacute;caissement(s) personnel(s)" href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitaldecaissement/lister_decaissement'); ?>&idcaisse=<?php echo $_SESSION["idcaisse"]; ?>">
                                        D&eacute;caissement(s) personnel(s)
                                    </a>
                                </span>
                            </h2>
                            <span class="text-success"><?php echo $nbdcp; ?>%</span>
                            <div class="progress m-b-0">
                                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="<?php echo $nbdcp; ?>" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $nbdcp; ?>%;"> <span class="sr-only"><?php echo $nbdcp; ?>%</span> </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ./col -->
            </div>
        </div>
    </div>
    <?php
    }
}
?>
<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <!--            <div class="box-header well">
                            <h2><i class="glyphicon glyphicon-info-sign"></i> hopitalSA</h2>
            
                            <div class="box-icon">
            
                                <a href="#" class="btn btn-minimize btn-round btn-default"><i
                                        class="glyphicon glyphicon-chevron-up"></i></a>
                                <a href="#" class="btn btn-close btn-round btn-default"><i
                                        class="glyphicon glyphicon-remove"></i></a>
                            </div>
                        </div>-->
            <div class="box-content row">
                <div class="col-lg-12 col-md-12" style="text-align: center">
                   <img src="hopitalupload/logo/<?php echo $_SESSION["logoproprietaire"] ?>" style="width:34%" > 
                </div>

                <!-- Ads end -->

            </div>
        </div>
    </div>
</div>
