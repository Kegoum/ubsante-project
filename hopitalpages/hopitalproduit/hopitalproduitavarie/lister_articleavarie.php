
    <div class="row">
        <div class="col-lg-2"></div>
        <div class="col-lg-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Liste des Articles avaries
                    <?php
                    if (isset($_SESSION["login_proprietaire"]) && (isset($_SESSION["mot_de_passe_proprietaire"]))) {
                        ?>
                        <a href="indexadmin.php?page=<?php echo base64_encode('hotelpages/fourniturehotel/hotelarticleavarie/hotelajouter/ajouter_article_avarie') ?>" class="pull-right">
                            <img src="hotelimages/process-icon-new.png" title="Nouveau" alt="Nouveau">
                        </a>
                        <?php
                    } else if (isset($_SESSION["login_personnel"]) && (isset($_SESSION["mot_de_passe_personnel"])) && ($_SESSION["etat_compte_personnel"])) {
                        if (($_SESSION["code_service"] == "ECONO")) {
                            ?>
                            <a href="indexpersonnel.php?page=<?php echo base64_encode('hotelpages/fourniturehotel/hotelarticleavarie/hotelajouter/ajouter_article_avarie') ?>" class="pull-right">
                                <img src="hotelimages/process-icon-new.png" title="Nouveau" alt="Nouveau">
                            </a>
                            <?php
                        }if (($_SESSION["code_service"] == "DG")) {
                            ?>
                            <a href="indexdg.php?page=<?php echo base64_encode('hotelpages/fourniturehotel/hotelarticleavarie/hotelajouter/ajouter_article_avarie') ?>" class="pull-right">
                                <img src="hotelimages/process-icon-new.png" title="Nouveau" alt="Nouveau">
                            </a>
                            <?php
                        }
                    }
                    ?>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-produit">
                            <thead>
                                <tr class="btn-success">
                                    <th>N&deg;</th>
                                    <th>Code</th>
                                    <th>D&eacute;signation</th>
                                    <th>Service</th>
                                    <th>Personnel</th>
                                    <th>Stock</th>
                                    <th>Prix</th>
                                    <th>Date</th>
                                    <!--<th>Op&eacute;ration</th>-->
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                lister_article_avarie($_SESSION["id_point_hotel"], $con);
                                ?>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-lg-2"></div>
    </div>