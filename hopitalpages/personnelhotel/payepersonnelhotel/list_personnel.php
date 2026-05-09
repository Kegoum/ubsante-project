
<div align="center">
    <h2>Gestion des Paies</h2>
    <h2>Liste <small> des Personnels</small></h2>
    <div class="table-responsive">
       <form method="Post" action="#">
            <table class="table table-striped table-bordered table-hover" id="dataTables-client">
            <thead>
                <tr class="btn-success">
                        <th>Code</th>
                        <th>Nom</th>
                        <th>Pr&eacute;nom</th>
                        <th>T&eacute;l&eacute;phone</th>
                        <th>Op&eacute;ration</th>
                    </tr>
                </thead>
            <tbody>
                <?php
                // On r?cup?re les 2 derniers billets
                list_personnelpaye($con);
                ?>
            </tbody>
            </table>
        </form>
    </div>
</div>
