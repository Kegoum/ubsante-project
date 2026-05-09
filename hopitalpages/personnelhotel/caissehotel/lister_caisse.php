<?php $page_active = "Caisse"; ?>
<div class="row">
    <div class="col-lg-12">
        <!--<a href="javascript:history.go(-1)" class="btn btn-success btn-sm pull-left">Pr&eacute;c&eacute;dent</a>-->
        <h2 class="page-header">Etat de la caisse <small> </small></h2>
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover" id="dataTables-client">
                <thead>
                    <tr class="btn-success">
                        <th>Date</th>
                        <th>Caissier</th>
                        <th>Personnel</th>
                        <th>Service</th>
                        <th>Op&eacute;ration</th>
                        <th>But</th>
                        <th>Montant</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // On r?cup?re les 2 derniers billets
                    lister_caisse($con);
                    ?>
                </tbody>
            </table>

        </div>
    </div>
</div>   