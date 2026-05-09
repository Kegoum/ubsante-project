
<?php

if (isset($_REQUEST["idlignecaisse"])) {
    $id = $_REQUEST["idlignecaisse"];
    $rsltb = $con->query("select * from hp_ligne_caisse where idlignecaisse='" . $id . "'") or die(mysqli_error($con));
    $row = mysqli_fetch_assoc($rsltb);
    $eta = "Actif";
    $mont = 0;
    $rslt = $con->query("select * from hp_ligne_caisse as lc where lc.idcaisse='" . $row["idcaisse"] . "' and "
            . "lc.paiementlignecaisse='" . $eta . "' and idlignecaisse<>'" . $id . "' ") or die(mysqli_error($con));
    while ($rowd = mysqli_fetch_assoc($rslt)) {
        if ($rowd["operationlignecaisse"] == "Encaissement") {
            $mont = $mont + $rowd["montantlignecaisse"];
        } else {
            $mont = $mont - $rowd["montantlignecaisse"];
        }
    }

// R�cup�ration du num�ro de l'�tape en cours
    if (empty($_GET['pagecom']) or ! is_numeric($_GET['pagecom'])) {
        define('NUM_PAGE', 1);
    } else {
        // En situation r�elle, il faudrait v�rifier l'existence de cette page
        define('NUM_PAGE', intval($_GET['pagecom']));
    }

// D�claration de la variable de session
    if (empty($_SESSION['formdecaissemente'])) {
        $_SESSION['formdecaissemente'] = array();
    }

    if (empty($_SESSION['formdecaissemente'])) {
        $_SESSION['formdecaissemente'] = array();
        $_SESSION['formdecaissemente'][1] = array(
            'idlignecaisse' => $_GET["idlignecaisse"],
            'datejour' => $row["datejourlignecaisse"],
            'but' => $row["datejourlignecaisse"],
            'montant' => $mont,
            'montvers' => $row["montantlignecaisse"],
            'reste' => ($mont - $row["montantlignecaisse"])
        );
    }


    switch (NUM_PAGE) {

        case 2:
            // Récupération des informations du formulaire précédent
            if (!empty($_POST)) {

                $_SESSION['formdecaissemente'][NUM_PAGE - 1] = array(
                    'idlignecaisse' => $_GET["idlignecaisse"],
                    'but' => trim(htmlspecialchars($_POST["but"])),
                    'datejour' => trim(htmlspecialchars($_POST["datejour"])),
                    'montant' => floatval(trim(htmlspecialchars($_POST["montant"]))),
                    'montvers' => floatval(trim(htmlspecialchars($_POST["montvers"]))),
                    'reste' => floatval(trim(htmlspecialchars($_POST["reste"])))
                );
            }

            require('hopitalpages/hopitaldecaissement/hopitalediter/form_terminer.php');
            break;

        case 1:
        default:
            // Valeurs par défaut
            if (empty($_SESSION['formdecaissemente'][NUM_PAGE])) {

                $_SESSION['formdecaissemente'][NUM_PAGE] = array(
                    'idlignecaisse' => $_GET["idlignecaisse"],
                    'datejour' => $row["datejourlignecaisse"],
                    'but' => $row["datejourlignecaisse"],
                    'montant' => $mont,
                    'montvers' => $row["montantlignecaisse"],
                    'reste' => ($mont - $row["montantlignecaisse"])
                );
            } else if (($_SESSION['formdecaissemente'][NUM_PAGE]["idlignecaisse"] != $_REQUEST["idlignecaisse"])) {

                $_SESSION['formdecaissemente'][NUM_PAGE] = array(
                    'idlignecaisse' => $_GET["idlignecaisse"],
                    'datejour' => $row["datejourlignecaisse"],
                    'but' => $row["datejourlignecaisse"],
                    'montant' => $mont,
                    'montvers' => $row["montantlignecaisse"],
                    'reste' => ($mont - $row["montantlignecaisse"])
                );
            }
            require('hopitalpages/hopitaldecaissement/hopitalediter/form_edit_decaissement.php');
            break;
    }
}