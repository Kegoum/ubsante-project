<?php
session_start();

include('../../hopitalconnexion/connexion.php');

$keyword = '%' . $_POST['keyworda'] . '%';
//$sql = "SELECT * FROM hotel_patient as c WHERE c.nom_patient LIKE (:keyword) and c.archive_patient=true  "
//        . "ORDER BY c.nom_patient ASC LIMIT 0, 10";

$req = $con->query("SELECT * FROM hp_patient as c WHERE c.codepatient LIKE '" . $keyword . "' or c.telephonepatient "
        . "LIKE '" . $keyword . "' or c.nompatient LIKE '" . $keyword . "' or c.prenompatient LIKE '" . $keyword . "' "
        . "ORDER BY c.codepatient ASC LIMIT 0, 10");
?>
<br><br>
<?php
while ($rs = mysqli_fetch_assoc($req)) {
    // put in bold the written text
    $name = str_replace($_POST['keyworda'], '<b>' . $_POST['keyworda'] . '</b>', $rs['nompatient']);
    $prenom = str_replace($_POST['keyworda'], '<b>' . $_POST['keyworda'] . '</b>', $rs['prenompatient']);
    $code = str_replace($_POST['keyworda'], '<b>' . $_POST['keyworda'] . '</b>', $rs['codepatient']);
    $tel = str_replace($_POST['keyworda'], '<b>' . $_POST['keyworda'] . '</b>', $rs['telephonepatient']);

    // add new option

    echo '<li onclick="set_item(\'' . $rs['idpatient'] . '\',\'' . str_replace("'", "\'", $rs['codepatient']) . '\')">' . $name . ' ' . $prenom . ' - ' . $code . ' - ' . $tel . '</li>';
    echo '<br>';
}
?>