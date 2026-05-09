<?php

include_once("../../hopitalconnexion/connexion.php");
$dated = $_POST["dated"];
$datef = $_POST["datef"];
if ($_POST["query"] != '') {

    $searchData = explode(",", $_POST["query"]);
    $searchValues = "'" . implode("', '", $searchData) . "'";
    $queryQuery = "
		SELECT * 
		FROM hp_facture 
		WHERE etatfacture IN (" . $searchValues . ") and DATE(datefacture) BETWEEN '" . $dated . "' and '" . $datef . "'  order by datefacture desc";
} else {
    $queryQuery = "
	SELECT * 
	FROM hp_facture where DATE(datefacture) BETWEEN '" . $dated . "' and '" . $datef . "' order by datefacture desc";
}
$resultset = mysqli_query($con, $queryQuery) or die("database error:" . mysqli_error($con));
$totalRecord = mysqli_num_rows($resultset);
$htmlRows = '';
if ($totalRecord) {
    while ($recfnp = mysqli_fetch_assoc($resultset)) {
        $lignecaisse = $recfnp["avancefacture"];
        $mont = $recfnp["montantfacture"];
        $montr = $mont - $lignecaisse;
        $patien = "";
        $but = "";
        $idssdoc = NULL;
        if ($recfnp["idconsultation"] != NULL) {
            $rsltniv = $con->query("select * from hp_consultation as c left join hp_sous_dossier as sd on c.idsousdossier=sd.idsousdossier "
                    . "left join hp_dossier as d on sd.iddossier=d.iddossier left join hp_patient as p on d.idpatient=p.idpatient where "
                    . "c.idconsultation='" . $recfnp["idconsultation"] . "'") or die(mysqli_error($con));
            $recniv = mysqli_fetch_assoc($rsltniv);
            $patien = $recniv["codepatient"] . " " . $recniv["nompatient"] . " " . $recniv["prenompatient"];
//                        print ("Consultation : ");
                        $rsltnivea = $con->query("select * from hp_acte as c where "
                                        . "c.idacte='" . $recniv["idacte"] . "'") or die(mysqli_error($con));
                                $rowpcone = mysqli_fetch_assoc($rsltnivea);
            $but = "Consultation " . $recniv["codeconsultation"]." - ".$rowpcone["libelleacte"];
        } else if ($recfnp["idexamenpatient"] != NULL) {
            $rsltniv = $con->query("select * from hp_examen_patient as c left join hp_sous_dossier as sd on c.idsousdossier=sd.idsousdossier "
                    . "left join hp_dossier as d on sd.iddossier=d.iddossier left join hp_patient as p on d.idpatient=p.idpatient where "
                    . "c.idexamenpatient='" . $recfnp["idexamenpatient"] . "'") or die(mysqli_error($con));
            $recniv = mysqli_fetch_assoc($rsltniv);
            $patien = $recniv["codepatient"] . " " . $recniv["nompatient"] . " " . $recniv["prenompatient"];
//                        print ("Examen : ");
                        $rsltnive = $con->query("select * from hp_examen as c where "
                                        . "c.idexamen='" . $recniv["idexamen"] . "'") or die(mysqli_error($con));
                                $rowpexae = mysqli_fetch_assoc($rsltnive);
            $but = "Examen " . $recniv["codeexamenpatient"]." - ".$rowpexae["nomexamen"];
        } else if ($recfnp["idechographiepatient"] != NULL) {
            $rsltniv = $con->query("select * from hp_echographie_patient as c left join hp_sous_dossier as sd on c.idsousdossier=sd.idsousdossier "
                    . "left join hp_dossier as d on sd.iddossier=d.iddossier left join hp_patient as p on d.idpatient=p.idpatient where "
                    . "c.idechographiepatient='" . $recfnp["idechographiepatient"] . "'") or die(mysqli_error($con));
            $recniv = mysqli_fetch_assoc($rsltniv);
            $patien = $recniv["codepatient"] . " " . $recniv["nompatient"] . " " . $recniv["prenompatient"];
//                        print ("Echographie : ");
                                $rsltnivec = $con->query("select * from hp_echographie as c where "
                                        . "c.idechographie='" . $recniv["idechographie"] . "'") or die(mysqli_error($con));
                                $rowpeche = mysqli_fetch_assoc($rsltnivec);
            $but = "Echographie " . $recniv["codeechographiepatient"]." - ".$rowpeche["nomechographie"];
        } else if ($recfnp["idactepatient"] != NULL) {
            $rsltniv = $con->query("select * from hp_acte_patient as c left join hp_sous_dossier as sd on c.idsousdossier=sd.idsousdossier "
                    . "left join hp_dossier as d on sd.iddossier=d.iddossier left join hp_patient as p on d.idpatient=p.idpatient where "
                    . "c.idactepatient='" . $recfnp["idactepatient"] . "'") or die(mysqli_error($con));
            $recniv = mysqli_fetch_assoc($rsltniv);
            $patien = $recniv["codepatient"] . " " . $recniv["nompatient"] . " " . $recniv["prenompatient"];
//                        print ("Autre : ");
                        $rsltnivea = $con->query("select * from hp_acte as c where "
                                        . "c.idacte='" . $recniv["idacte"] . "'") or die(mysqli_error($con));
                                $rowpcone = mysqli_fetch_assoc($rsltnivea);
            $but = "Autre " . $recniv["codeactepatient"]." - ".$rowpcone["libelleacte"];
        } else if ($recfnp["idordonnance"] != NULL) {
            $rsltniv = $con->query("select * from hp_ordonnance as c left join hp_sous_dossier as sd on c.idsousdossier=sd.idsousdossier "
                    . "left join hp_dossier as d on sd.iddossier=d.iddossier left join hp_patient as p on d.idpatient=p.idpatient where "
                    . "c.idordonnance='" . $recfnp["idordonnance"] . "'") or die(mysqli_error($con));
            $recniv = mysqli_fetch_assoc($rsltniv);
            $patien = $recniv["codepatient"] . " " . $recniv["nompatient"] . " " . $recniv["prenompatient"];
//                        print ("Ordonance : ");
            $idssdoc = $recniv["idsousdossier"];
            $but = "Ordonance " . $recniv["codeordonnance"];
        } else if ($recfnp["idsoinpatient"] != NULL) {
            $rsltniv = $con->query("select * from hp_soin_patient as c left join hp_hospitalisation as h on "
                    . "c.idhospitalisation=h.idhospitalisation left join hp_sous_dossier as sd on h.idsousdossier=sd.idsousdossier "
                    . "left join hp_dossier as d on sd.iddossier=d.iddossier left join hp_patient as p on d.idpatient=p.idpatient left join "
                    . "hp_departement as dp on p.residencepatient=dp.iddepartement where "
                    . "c.idsoinpatient='" . $recfnp["idsoinpatient"] . "'") or die(mysqli_error($con));
            $recniv = mysqli_fetch_assoc($rsltniv);
            $patien = $recniv["codepatient"] . " " . $recniv["nompatient"] . " " . $recniv["prenompatient"];
//                        print ("Soin : ");
                        $rsltnivea = $con->query("select * from hp_soin as c where "
                                        . "c.idsoin='" . $recniv["idsoin"] . "'") or die(mysqli_error($con));
                                $rowpcone = mysqli_fetch_assoc($rsltnivea);
            $but = "Soin " . $recniv["codesoinpatient"]." - ".$rowpcone["libellesoin"];
        }

        $eta = "";
        if ($recfnp["avancefacture"] == NULL) {
            $eta = "<span alt='non' class='label-danger label'><i class='label label-danger'>Impay&eacute;e</i></span>";
        } else {
            if ($recfnp["etatfacture"]) {
                $eta = "<span alt='non' class='label-success label'><i class='label label-success'>Pay&eacute;e</i></span>";
            } else {
                $eta = "<span alt='non' class='label-warning label'><i class='label label-warning'>Avanc&eacute;e</i></span>";
            }
        }
        $paged = "hopitalpages/hopitalfacture/lister_recu";
        $htmlRows .= '
	  <tr>
		   <td></td>
		   <td>' . $recfnp["codefacture"] . '</td>
		   <td>' . $but . '</td>
		   <td>' . $patien . '</td>
		   <td>' . $mont . '</td>
		   <td>' . $lignecaisse . '</td>
		   <td>' . $montr . '</td>
		   <td>' . $eta . '</td>
		   <td>' . $recfnp["datefacture"] . '</td>
		   <td>
                  
               </td>
	  </tr>';
        
//        $htmlRows .= '
//	  <tr>
//		   <td></td>
//		   <td>' . $recfnp["codefacture"] . '</td>
//		   <td>' . $but . '</td>
//		   <td>' . $patien . '</td>
//		   <td>' . $mont . '</td>
//		   <td>' . $lignecaisse . '</td>
//		   <td>' . $montr . '</td>
//		   <td>' . $eta . '</td>
//		   <td>' . $recfnp["datefacture"] . '</td>
//		   <td>
//                   <a href="\'' . $url . '\'?page=\'' . base64_encode($paged) . '\'&idfacture=\'' . $recfnp["idfacture"] . '\'">
//                       <span title="liste des re&ccedil;us de cette facture" alt="ajouter">
//                       <i class="glyphicon glyphicon-list-alt"></i>
//                       </span> 
//                   </a>
//               </td>
//	  </tr>';
    }
} else {
    $htmlRows .= '
		<tr>
			<td colspan="9" align="center">Aucune donnée trouvée</td>
		</tr>';
}

$data = array(
    "html" => $htmlRows
);
echo json_encode($data);
?>