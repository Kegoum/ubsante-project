<script language="JavaScript">

    $(function () {
        $('#datecj').datepicker();
        $('#datecj').on('changeDate', function (ev) {
            $(this).datepicker('hide');
        });
        $('#datedcp').datepicker();
        $('#datedcp').on('changeDate', function (ev) {
            $(this).datepicker('hide');
        });
        $('#datefcp').datepicker();
        $('#datefcp').on('changeDate', function (ev) {
            $(this).datepicker('hide');
        });
    });

</script>
<?php
if (isset($_GET["idpatient"])) {
    $id = $_GET["idpatient"];
    $req_fin = $con->query("select * from hp_patient as p left join hp_dossier as d on p.idpatient=d.idpatient "
            . "where p.idpatient='" . $id . "'") or die(mysqli_error($con));
    $row = mysqli_fetch_assoc($req_fin);
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
                                    <h1>
                                        Dossier de 
                                        <?php echo $row["codepatient"]; ?> <?php echo $row["nompatient"]; ?> <?php
                                        echo $row["prenompatient"];
                                        ?>
                                    </h1>
                                </div>
                            </div>
                            <form id="entreesortiej_form" role="form" name="form_annee" action="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpatient/hopitaldossierpatient/lister_dossier_patient') ?>&idpatient=<?php echo $_REQUEST["idpatient"] ?>" method="post">
                                <div id="alertcp" class="alert alert-danger" style="display:none"> <strong>La date de fin doit être postérieure à la date de debut !</strong> </div>
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <input name="datedcp" placeholder="Votre D&eacute;but de p&eacute;riode" type="text" class="form-control"  id="datedcp" data-date-format="yyyy-mm-dd">
                                            <div class="alert alert-block alert-danger alertdatedcp" style="display:none">
                                                <h4>Erreur !</h4>
                                                D&eacute;but de p&eacute;riode invalide !
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <input name="datefcp" placeholder="Votre Fin de p&eacute;riode" type="text" class=" form-control" id="datefcp" data-date-format="yyyy-mm-dd" >
                                            <div class="alert alert-block alert-danger alertdatefcp" style="display:none">
                                                <h4>Erreur !</h4>
                                                Fin de p&eacute;riode invalide !
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <input type="submit" id="Submitcp" class="btn btn-success" name="storecp" value="Affiche">
                                    </div> 
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
}
?>