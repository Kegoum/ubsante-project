<div class="panel panel-default">
    <div class="panel-heading">
        Liste des bons de livraison du bar
        <?php
        if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
            ?>
            <a href="indexadmin.php?page=<?php echo base64_encode('hotelpages/barhotel/bonlivraisonhotel/livraison') ?>" class="pull-right">
                <img src="hotelimages/process-icon-new.png" title="Nouveau" alt="Nouveau">
            </a>
            <?php
        } else if (isset($_SESSION["login_personnel"]) && (isset($_SESSION["mot_de_passe_personnel"])) && ($_SESSION["etat_compte_personnel"])) {
            if (($_SESSION["code_service"] == "ECONO")) {
                ?>
                <a href="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/barhotel/bonlivraisonhotel/livraison') ?>" class="pull-right">
                    <img src="hotelimages/process-icon-new.png" title="Nouveau" alt="Nouveau">
                </a>
                <?php
            } else if (($_SESSION["code_service"] == "DG")) {
                ?>
                <a href="indexdg.php?page=<?php echo base64_encode('hotelpages/barhotel/bonlivraisonhotel/livraison') ?>" class="pull-right">
                    <img src="hotelimages/process-icon-new.png" title="Nouveau" alt="Nouveau">
                </a>
                <?php
            }
        }
        ?>
    </div>
    <div class="panel-body">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover" id="dataTables-chambre">
                <thead>
                    <tr class="btn-success">
                        <th>N&deg;</th>
                        <!--<th>Service</th>-->
                        <th>Code</th>
                        <th>Montant</th>
                        <th>Etat</th>
                        <th>Date</th>
                        <th>Op&eacute;ration</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    lister_livraison_bar($con);
                    ?>
                </tbody>
            </table>
        </div>

    </div>
</div>