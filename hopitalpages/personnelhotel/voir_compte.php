<?php $page_active="Personnel"; ?>
<?php
if (isset($_REQUEST["personnel"])) {
    $idpers = $_REQUEST["personnel"];
    $rslt = $con->query("select * from hotel_compte_personnel as cp left join hotel_personnel as pe on cp.id_personnel=pe.id_personnel "
            . "where cp.id_personnel='" . $idpers . "'") or die(mysqli_error($con));
    $row = mysqli_fetch_assoc($rslt);
    ?>
    <div class="row">
        <div class="col-lg-12">
            <!--<a href="javascript:history.go(-1)" class="btn btn-success btn-sm pull-left">Pr&eacute;c&eacute;dent</a>-->
            <h2 class="page-header">Detail du compte de <small> <?php echo $row["nom_pe"] ?> <?php echo $row["prenom_pe"] ?> </small></h2>
            <div class="content_form">
                <table class="table table-bordered table-striped table-condensed" border="0">
                    <thead>
                        <tr class="btn-success ">
                            <th>Login</th>
                            <th colspan="2">Op&eacute;ration</th>
                        </tr>
                    </thead>
                    <?php
                    // On r?cup?re les 2 derniers billets
                    voir_compte( $idpers,$con);
                    ?>
                </table>

            </div>
        </div>
    </div>    
    <?php
}
?>