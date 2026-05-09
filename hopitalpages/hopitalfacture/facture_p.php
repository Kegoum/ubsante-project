
<?php
if ((isset($_REQUEST["dated"])) && (isset($_REQUEST["datef"]))) {

    $dated = addslashes($_REQUEST["dated"]);
    $datef = addslashes($_REQUEST["datef"]);

    $datedd = explode('-', $dated);
    $datede = $datedd[2] . "-" . $datedd[1] . "-" . $datedd[0];

    $datedf = explode('-', $datef);
    $datefe = $datedf[2] . "-" . $datedf[1] . "-" . $datedf[0];
    ?>

    <input type="hidden" name="location" id="location" />
    <input type="hidden" name="dated" id="dated" value="<?php echo $dated; ?>" />
    <input type="hidden" name="datef" id="datef" value="<?php echo $datef; ?>" />
    <div style="clear:both"></div>
    <div class="data-table-area mg-b-15">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="sparkline13-list">
                        <div class="sparkline13-hd">
                            <div class="main-sparkline13-hd">
                                <h1>Factures du <?php echo $datede; ?> au  <?php echo $datefe; ?></h1>

                                <select placeholder="Filtrer les donn&eacute;es" name="multiSelectSearch" id="multiSelectSearch" multiple class="form-control select2_demo_3 selectpicker" title="Filtrer les donn&eacute;es">
                                    <?php
                                    $sql_query = "SELECT DISTINCT etatfacture as location FROM hp_facture where datefacture BETWEEN '" . $dated . "' and '" . $datef . "'";
                                    $resultset = mysqli_query($con, $sql_query) or die("database error:" . mysqli_error($con));
                                    while ($developer = mysqli_fetch_assoc($resultset)) {
                                        echo '<option value="' . $developer["location"] . '">';
                                        if ($developer["location"]) {
                                            echo 'Payée';
                                        } else {
                                            echo 'Impayée';
                                        }
                                        echo '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
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
                                        <th data-field="state" data-checkbox="true"></th>
                                            <th>Code</th>
                                            <th>Objet</th>
                                            <th>Patient</th>
                                            <th>Montant</th>
                                            <th>Avance</th>
                                            <th>Reste</th>
                                            <th>Etat</th>
                                            <th>Date</th>
                                            <th>op&eacute;ration</th>
                                        </tr>
                                    </thead>
                                    <tbody> 

                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--<script src="hopitalplugin/historique/search_facture.js"></script>-->
    <script>
$(document).ready(function() {
//    alert('coooollll4');
    var dated = $('#dated').val();
    var datef = $('#datef').val();
    var searchQuery='';
//    alert(dated);
    listRecords(dated, datef, searchQuery);
    $('#multiSelectSearch').change(function() {
        $('#location').val($('#multiSelectSearch').val());
        searchQuery = $('#location').val();
        listRecords(dated, datef, searchQuery);
        
    });
});
function listRecords(dated, datef, searchQuery) {
//    alert('coooollll');
    $.ajax({
        url: "hopitalpages/hopitalfacture/facture_search.php",
        method: "POST",
        dataType: "json",
        data: {query: searchQuery, dated: dated, datef: datef},
        success: function(response) {
            $('tbody').html(response.html);
//            alert('coooollll5');
        }
    });
}
    </script>
    
    <?php
//    echo "<script language='javascript'>alert('slow')</script>";
    ?>
    <div class="insert-post-ads1" style="margin-top:20px;">

    </div>
    <?php
}
?>
