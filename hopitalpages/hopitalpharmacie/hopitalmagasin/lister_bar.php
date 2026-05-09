<?php $page_active="Bar"; ?>
<div class="row">
    <div class="col-lg-12">
        <!--<a href="javascript:history.go(-1)" class="btn btn-success btn-sm pull-left">Pr&eacute;c&eacute;dent</a>-->
        <h2 class="page-header">
            Liste <small> des Bars</small>
        </h2>
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover" id="dataTables-client">
                <thead>
                    <tr class="btn-success">
                        <th>Nom Bar</th>
                        <th>Type</th>
                        <th>Contact</th>
                        <th>Point H&ocirc;tel</th>
                        <th>R&eacute;gion</th>
                        <th>Date</th>
                        <th>Op&eacute;ration</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                // On r?cup?re les 2 derniers billets
                lister_bar_etat($_SESSION["id_point_hotel"],$con);
                ?>
                </tbody>
            </table>

        </div>
    </div>
</div>   