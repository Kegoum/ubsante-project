
    <div align="center">
        <h2>Liste <small> des Payements des personnels</small></h2>
        <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover" id="dataTables-client">
            <thead>
                <tr class="btn-success">
                        <th>Personnel</th>
                        <th>Date D&eacute;but</th>
                        <th>Date fin</th>
                        <th>Salaire de base</th>
                        <th>R&eacute;mun&eacute;ration Brute</th>
                        <th>Tatal retenue</th>
                        <th>Net &agrave; payer</th>
                        <th>Op&eacute;ration</th>
                    </tr>
                </thead>
            <tbody>
                <?php
                // On r?cup?re les 2 derniers billets
                list_paye($con);
                ?>
            </tbody>
            </table>

        </div>
    </div>  