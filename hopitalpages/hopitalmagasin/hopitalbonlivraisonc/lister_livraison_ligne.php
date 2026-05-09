<?php
if (isset($_REQUEST["bonlivraison"])){
$rslt = $con->query("select * from hotel_bon_livraison_interne as a left join hotel_service as c on "
            . "a.id_service=c.id_service where a.id_bon_livraison_interne='".$_REQUEST["bonlivraison"]."'") or die(mysqli_error($con));
$row = mysqli_fetch_assoc($rslt);
?>
<div class="panel panel-default">
    <div class="panel-heading">
        D&eacute;tail du bon de livraison num&eacute;ro
        <?php
        echo $row["code_bli"];
        ?>
    </div>
    <div class="panel-body">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover" id="dataTables-chambre">
                <thead>
                    <tr class="btn-success">
                        <th>N&deg;</th>
                        <th>Code</th>
                        <th>D&eacute;signation</th>
                        <th>Cat&eacute;gorie</th>
                        <th>Stock</th>
                        <th>unit&eacute; vente</th>
                        <th>unit&eacute; sortie</th>
                        <th>Etat</th>
                        <th>Op&eacute;ration</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    lister_livraison_bar_ligne($_REQUEST["bonlivraison"], $con);
                    ?>
                </tbody>
            </table>
        </div>

    </div>
</div>
<?php 
}
?>