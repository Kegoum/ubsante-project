<script>
    function CocheTout(ref, name) {
        var form = ref;

        while (form.parentNode && form.nodeName.toLowerCase() != 'form') {
            form = form.parentNode;
        }

        var elements = form.getElementsByTagName('input');

        for (var i = 0; i < elements.length; i++) {
            if (elements[i].type == 'checkbox' && elements[i].name == name) {
                elements[i].checked = ref.checked;
            }
        }
    }

</script>
<?php
if ($_REQUEST["idfacture"]) {
    $rsltc = $con->query('select * from hp_facture where idfacture=' . $_REQUEST["idfacture"] . ' ') or die(mysqli_error($con));
    $row = mysqli_fetch_assoc($rsltc);
    $rowpcon = NULL;
    $rowpexa = NULL;
    $rowpord = NULL;
    if ($row["idconsultation"] != NULL) {
        $rsltniv = $con->query("select * from hp_consultation as c left join hp_sous_dossier as sd on c.idsousdossier=sd.idsousdossier "
                . "left join hp_dossier as d on sd.iddossier=d.iddossier left join hp_patient as p on d.idpatient=p.idpatient left join "
                . "hp_departement as dp on p.residencepatient=dp.iddepartement where "
                . "c.idconsultation='" . $row["idconsultation"] . "'") or die(mysqli_error($con));
        $rowpcon = mysqli_fetch_assoc($rsltniv);
    } else if ($row["idexamenpatient"] != NULL) {
        $rsltniv = $con->query("select * from hp_examen_patient as c left join hp_sous_dossier as sd on c.idsousdossier=sd.idsousdossier "
                . "left join hp_dossier as d on sd.iddossier=d.iddossier left join hp_patient as p on d.idpatient=p.idpatient left join "
                . "hp_departement as dp on p.residencepatient=dp.iddepartement where "
                . "c.idexamenpatient='" . $row["idexamenpatient"] . "'") or die(mysqli_error($con));
        $rowpexa = mysqli_fetch_assoc($rsltniv);
    } else if ($row["idordonnance"] != NULL) {
        $rsltniv = $con->query("select * from hp_ordonnance as c left join hp_sous_dossier as sd on c.idsousdossier=sd.idsousdossier "
                . "left join hp_dossier as d on sd.iddossier=d.iddossier left join hp_patient as p on d.idpatient=p.idpatient left join "
                . "hp_departement as dp on p.residencepatient=dp.iddepartement where "
                . "c.idordonnance='" . $row["idordonnance"] . "'") or die(mysqli_error($con));
        $rowpord = mysqli_fetch_assoc($rsltniv);
    }
    ?>

<h2>Param&egrave;tres de : <?php
        if ($rowpcon != NULL) {
            echo $rowpcon["codepatient"];?> <?php
            echo $rowpcon["nompatient"];?> <?php
            echo $rowpcon["prenompatient"];
        } else if ($rowpexa != NULL) {
            echo $rowpexa["codepatient"];?> <?php
            echo $rowpexa["nompatient"];?> <?php
            echo $rowpexa["prenompatient"];
        } else if ($rowpord != NULL) {
            echo $rowpord["codepatient"];?> <?php
            echo $rowpord["nompatient"];?> <?php
            echo $rowpord["prenompatient"];
        }
        ?></h2>
    
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover" id="dataTables-eleve">
            <thead>
                <tr class="btn-info">
                    <th><input onclick="CocheTout(this, 'tjust[]');" type="checkbox" />N&deg;</th>
                    <th>Libelle</th>
                    <th>Valeur minimale</th>
                    <th>Valeur maximale</th>
                    <th>Valeur du patient</th>
                    <th>Op&eacute;ration</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // On r?cup?re les 2 derniers billets
                list_elevefacturedis($_REQUEST["idfacture"], $_REQUEST["seq"],$con);
                ?>
            </tbody>
        </table>
    </div>
    <?php
} else {
    
}
?>