<?php
if ($_REQUEST["recu"]) {
    $rsltc = $con->query("select * from recu as r left join enseignant as e on r.idenseignant=e.idenseignant where "
            . "r.idrecu='" . $_REQUEST["recu"] . "' ") or die(mysqli_error($con));
    $row = mysqli_fetch_assoc($rsltc);

    ?>
    <div class="data-table-area mg-b-15">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="sparkline13-list">
                        <div class="sparkline13-hd">
                            <div class="main-sparkline13-hd">
                                
                                <h1>D&eacute;tail du re&ccedil;u <?php echo $row["norecu"] ?></h1>
                                <h5>Mr/Mme <?php echo $row["nom"] ?> <?php echo $row["prenom"] ?></h5>
                                
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover" id="dataTables-etudiant">
                                        <thead>
                                            <tr class="btn-primary">
                                                <th>Date du cours</th>
                                                <th>Heure d&eacute;but</th>
                                                <th>Heure de fin</th>
                                                <th>Nombre d'heures</th>
                                                <!--<th>Nombre d'heures D&eacute;cimal</th>-->
                                                <th>Etat</th>
                                                <th>Pay&eacute;</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            // On r?cup?re les 2 derniers billets
                                            lister_detail_paye($_REQUEST["recu"], $con);
                                            ?>
                                        </tbody>
                                    </table>

                                </div>
                            </div>

                            <?php
                        } else {
                            
                        }
                        ?>