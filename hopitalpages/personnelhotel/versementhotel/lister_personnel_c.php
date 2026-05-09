<?php $page_active = "Personnel"; ?>
<div class="row">
    <div class="col-lg-12">
        <!--<a href="javascript:history.go(-1)" class="btn btn-success btn-sm pull-left">Pr&eacute;c&eacute;dent</a>-->
        <h2 class="page-header">Liste <small> des Personnel</small></h2>
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover" id="dataTables-client">
                <thead>
                    <tr class="btn-success">
                        <th>Nom</th>
                        <th>Pr&eacute;nom</th>
                        <th>T&eacute;l&eacute;phone</th>
                        <th>Email</th>
                        <th>Service</th>
                        <th>Op&eacute;ration</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                // On r?cup?re les 2 derniers billets
                lister_personnel_c($con);
                ?>
                </tbody>
            </table>

        </div>
    </div>
</div>   