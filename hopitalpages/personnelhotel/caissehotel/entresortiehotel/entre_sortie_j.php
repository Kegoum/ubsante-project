<?php
if (isset($_POST["datecj"])) {
    $date = $_POST["datecj"];

    $idph=$_SESSION["id_point_hotel"];
    $rsltuser = $con->query("select * from hotel_caisse as c left join hotel_compte_personnel as cp on "
            . "c.caissier=cp.id_compte_personnel where c.id_point_hotel='".$idph."' and cast(c.date_caisse "
            . "as DATE)='" . $date . "'") or die(mysqli_error($con));
    $mtt = 0;
    ?>
    <!--<a href="javascript:history.go(-1)" class="btn btn-success btn-sm pull-left">Pr&eacute;c&eacute;dent</a>-->

    <h2>Contr&ocirc;le du <?php echo $date ?></h2>
    <a href="hotelpages/personnelhotel/caissehotel/entresortiehotel/print_entre_sortie_j_pdf.php?datecj=<?php echo $date ?>&pointhotel=<?php echo $idph ?>" class="btn btn-lg btn-success" target="_blank">
        <span title="Imprimer la liste" alt="editer"><i class="fa fa-file-pdf-o"></i> Impriner</span>
    </a>
    <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover" id="dataTables-client">
                <thead>
                    <tr class="btn-success">
                <th>Caissier</th>
                <th>Date</th>
                <th>op&eacute;ration</th>
                <th>But</th>
                <th>Montant</th>
            </tr>
        </thead>
        <tbody>

            <?php
            while ($recuser = mysqli_fetch_assoc($rsltuser)) {
                ?>
                <tr >
                    <td><?php print nl2br(htmlspecialchars($recuser["login_pe"])) ?></td>
                    <td><?php print nl2br(htmlspecialchars($recuser["date_caisse"])) ?></td>
                    <td><?php print nl2br(htmlspecialchars($recuser["operation"])) ?></td>
                    <td><?php print nl2br(htmlspecialchars($recuser["but"])) ?></td>
                    <td>
                        <?php
                        if ($recuser["operation"] == "Versement") {
                            print number_format(nl2br(htmlspecialchars($recuser["montant_caisse"])), 0, ',', ' ');
                            $mtt = $mtt + $recuser["montant_caisse"];
                        } else {
                            print "-" . number_format(nl2br(htmlspecialchars($recuser["montant_caisse"])), 0, ',', ' ');
                            $mtt = $mtt - $recuser["montant_caisse"];
                        }
                        ?>
                    </td>
                </tr>
                <?php
            }
            ?>
            <tr >
                <td>TOTAL</td>
                <td></td>
                <td></td>
                <td></td>
                <td><?php echo number_format($mtt, 0, ',', ' ') ?></td>
            </tr>
        </tbody>
    </table>
    </div>
    <a href="hotelpages/personnelhotel/caissehotel/entresortiehotel/print_entre_sortie_j_pdf.php?datecj=<?php echo $date ?>&pointhotel=<?php echo $idph ?>" class="btn btn-lg btn-success" target="_blank">
        <span title="Imprimer la liste" alt="editer"><i class="fa fa-file-pdf-o"></i> Impriner</span>
    </a>
    <?php
}
?>
