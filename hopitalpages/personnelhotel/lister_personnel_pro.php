<?php $page_active="Personnel"; ?>
<div class="row">
    <div class="col-lg-12">
        <!--<a href="javascript:history.go(-1)" class="btn btn-success btn-sm pull-left">Pr&eacute;c&eacute;dent</a>-->
        <h2 class="page-header">
            Liste <small> des Personnels</small>
            <?php
            if (isset($_SESSION["login_proprietaire"]) && isset($_SESSION["mot_de_passe_proprietaire"])) {
                ?>
        <a href="indexproprietaire.php?page=<?php echo base64_encode('hotelpages/personnelhotel/ajouter_personnel') ?>" class="pull-right">
            <img src="hotelimages/process-icon-new.png" title="Nouveau" alt="Nouveau">
        </a>
                <?php
            } else if (isset($_SESSION["login_personnel"]) && isset($_SESSION["mot_de_passe_personnel"]) && ($_SESSION["etat_compte_personnel"])) {
                ?>
<!--        <a href="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/personnelhotel/ajouter_personnel') ?>" class="pull-right">
            <img src="hotelimages/process-icon-new.png" title="Nouveau" alt="Nouveau">
        </a>-->
                <?php
            }
            ?>
        </h2>
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover" id="dataTables-client">
                <thead>
                    <tr class="btn-success">
                        <th>Code</th>
                        <th>Nom</th>
                        <th>Pr&eacute;nom</th>
                        <th>T&eacute;l&eacute;phone</th>
                        <th>Email</th>
                        <th>Point d'Hotel</th>
                        <th>Service</th>
                        <th>Date</th>
                        <th>Compte</th>
                        <th>Op&eacute;ration</th>
                    </tr>
                </thead>
                 <tbody>
                <?php
                // On r?cup?re les 2 derniers billets
                lister_personnel($con);
                ?>
                 </tbody>
            </table>

        </div>
    </div>
</div>   