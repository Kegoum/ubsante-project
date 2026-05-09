<?php
if (isset($_POST["datecj"])) {
    $date = $_POST["datecj"];

    $rsltuser = $conn->query("select * from hotel_historique as c where cast(c.date_histo as DATE)='" . $date . "'") or die(mysqli_error($conn));
    ?>
    <div class="data-table-area mg-b-15">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="sparkline13-list">
                    <div class="sparkline13-hd">
                        <div class="main-sparkline13-hd">
                            <h1>Historique du <?php echo $date ?></h1>
    <a href="hotelpages/historiquehotel/print_historique_j_pdf.php?datecj=<?php echo $date ?>" class="btn btn-lg btn-success" target="_blank">
        <span title="Imprimer la liste" alt="editer"><i class="fa fa-file-pdf-o"></i> Impriner</span>
    </a>
                        </div>
                    </div>
                    <div class="sparkline13-graph">
                        <div class="datatable-dashv1-list custom-datatable-overright">
                            <div id="toolbar">
                                <select class="form-control dt-tb">
                                    <option value="">Exporter</option>
                                    <option value="all">Exporter Tout</option>
                                    <option value="selected">Exporter la Selection</option>
                                </select>
                            </div>
                            <table id="table" data-toggle="table" data-pagination="true" data-search="true" data-show-columns="true" data-show-pagination-switch="true" data-show-refresh="true" data-key-events="true" data-show-toggle="true" data-resizable="true" data-cookie="true"
                                   data-cookie-id-table="saveId" data-show-export="true" data-click-to-select="true" data-toolbar="#toolbar">
                                <thead>
                                    <tr>
                                        <!--<th data-field="state" data-checkbox="true"></th>-->
                <th>Utilisateur</th>
                <th>Client</th>
                <th>Op&eacute;ration</th>
                <th>Objet</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>

            <?php
            while ($recuser = mysqli_fetch_assoc($rsltuser)) {
                ?>
                <tr >
                    <td>
                        <?php
                        if ($recuser["id_proprietaire"] != NULL) {
                            $reqch = $conn->query("select * from hotel_proprietaire as c where "
                                    . "c.id_proprietaire= '" . $recuser["id_proprietaire"] . "' ") or die(mysqli_error($conn));
                            $rowch = mysqli_fetch_assoc($reqch);
                            ?>
                            <?php print nl2br(htmlspecialchars($rowch["nom_p"])) ?> 
                            <?php print nl2br(htmlspecialchars($rowch["prenom_p"])) ?> - 
                            <?php print nl2br(htmlspecialchars($rowch["login_p"])) ?> - 
                            Propri&eacute;taire
                            <?php
                        }
                        if ($recuser["id_compte_personnel"] != NULL) {
                            $reqch = $conn->query("select * from hotel_compte_personnel as c left join hotel_personnel as p on "
                                    . "c.id_personnel=p.id_personnel where c.id_compte_personnel= '" . $recuser["id_compte_personnel"] . "' ") or die(mysqli_error($conn));
                            $rowch = mysqli_fetch_assoc($reqch);
                            ?>
                            <?php print nl2br(htmlspecialchars($rowch["nom_pe"])) ?> 
                            <?php print nl2br(htmlspecialchars($rowch["prenom_pe"])) ?> - 
                            <?php print nl2br(htmlspecialchars($rowch["login_pe"])) ?> - 
                            Personnel
                            <?php
                        }
                        ?>
                    </td>
                    <td>
                        <?php
                        if ($recuser["id_client"] != NULL) {
                            $reqch = $conn->query("select * from hotel_client as c where c.id_client= '" . $recuser["id_client"] . "' "
                                    . "") or die(mysqli_error($conn));
                            $rowch = mysqli_fetch_assoc($reqch);
                            ?>
                            <?php print nl2br(htmlspecialchars($rowch["nom_client"])) ?> 
                            <?php print nl2br(htmlspecialchars($rowch["prenom_client"])) ?> - 
                            <?php print nl2br(htmlspecialchars($rowch["cni_client"])) ?>
                            <?php
                        }
                        ?>
                    </td>
                    <td><?php print nl2br(htmlspecialchars($recuser["operation_h"])) ?></td>
                    <td><?php print nl2br(htmlspecialchars($recuser["objet_h"])) ?></td>
                    <td><?php print nl2br(htmlspecialchars($recuser["date_histo"])) ?></td>
                </tr>
                <?php
            }
            ?>
        </tbody>
    </table>
    </div>
                        </div>
    <a href="hotelpages/historiquehotel/print_historique_j_pdf.php?datecj=<?php echo $date ?>" class="btn btn-lg btn-success" target="_blank">
        <span title="Imprimer la liste" alt="editer"><i class="fa fa-file-pdf-o"></i> Impriner</span>
    </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
}
?>
