<?php
if (isset($_REQUEST["enseignant"])) {
    $id=$_REQUEST["enseignant"];
    ?>
    <div align="center">
        <h2>Liste <small> des Payements</small></h2>
        <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover" id="dataTables-etudiant">
            <thead>
                <tr class="btn-success">
                        <th>Date D&eacute;but</th>
                        <th>Date fin</th>
                        <th>R&eacute;mun&eacute;ration Brute</th>
                        <th>Total retenue</th>
                        <th>Net &agrave; payer</th>
                        <th>Op&eacute;ration</th>
                    </tr>
                </thead>
            <tbody>
                <?php
                // On r?cup?re les 2 derniers billets
                list_paye_enseignant($id,$con);
                ?>
            </tbody>
            </table>

        </div>
    </div>    
    <?php
}
?>