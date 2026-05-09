<style>
    .glyphicon-remove-circle:hover{
        color: red;
    }
    .glyphicon glyphicon-edit{
        color: green;
    }
</style>
<?php

//gestion des chambres

function inserer_chambre($reg, $con) {
//    echo"<script language='javascript'>alert('ok')</script>";

    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    if (($reg != NULL) && isset($reg["1"])) {
        $req = $con->query("select * from hp_chambre where codechambre='" . addslashes($reg["1"]["code"]) . "'") or die(mysqli_error($con));
        $nb = mysqli_num_rows($req);
        if (($nb == 0)) {
            $con->query("insert into hp_chambre(codechambre, libellechambre, placechambre, idcategoriechambre, datechambre) "
                            . "values('" . addslashes($reg["1"]["code"]) . "', '" . addslashes($reg["1"]["chambre"]) . "', '" . ($reg["1"]["place"]) . "', "
                            . "'" . $reg["1"]["categorie"] . "', NOW())") or die(mysqli_error($con));
//            $con->query("insert into log(iduser,operation,dateLog) values('{$_SESSION['iduser']}','Ajout dans la table hp_chambre de la valeure {$reg["1"]["chambre"]}',now())") or die(mysqli_error($con));
            echo "<script language='javascript'>$('div.addok').show('slow').delay(8000).hide('slow');</script>";
            unset($_SESSION['formchambre']);
            $pagp = 'hopitalpages/hopitalparametre/hopitalchambre/lister_chambre';
            die('<meta http-equiv="refresh" content="3 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
        } else {
            echo "<script language='javascript'>$('div.addko').show('slow').delay(8000).hide('slow');</script>";
            $pagp = 'hopitalpages/hopitalparametre/hopitalchambre/hopitalajouter/ajout_chambre';
            die('<meta http-equiv="refresh" content="3 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
        }
    } else {
//        echo "<script language='javascript'>$('div.alertaddnull').show('slow').delay(8000).hide('slow');</script>";
    }
}

function lister_chambre($con) {

    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    $rsltuser = $con->query("select * from hp_chambre as p left join hp_categorie_chambre as ch on "
            . "p.idcategoriechambre=ch.idcategoriechambre order by p.libellechambre asc") or die(mysqli_error($con));
    $num = 0;
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        $num = $num + 1;
        ?>
        <tr>
            <td></td>
            <td><?php print $num ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["libellecategoriechambre"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["codechambre"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["libellechambre"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["placechambre"])) ?></td>
            <td><?php print number_format((nl2br(htmlspecialchars(($recuser["prixcategoriechambre"])))), 0, '.', ' ') ?> F CFA</td>
            <td>
                <?php
                if ((isset($_SESSION["loginproprietaire"]) && isset($_SESSION["motdepasseproprietaire"])) || (isset($_SESSION["logincomptepersonnel"]) && isset($_SESSION["motdepassecomptepersonnel"]) && ($_SESSION["etatcomptepersonnel"]))) {
                    if ($recuser["etatchambre"]) {
                        ?>
                        <span title="Libre" data-toggle="tooltip" alt="oui" class="label-success label">Libre</span>
                        <?php
                    } else {
                        ?>
                        <!--<a href='<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalparametre/hopitalchambre/chambre_ajax'); ?>&idchambre=<?php echo $recuser["idchambre"]; ?>&activer=activer' onclick="return(confirm('Etes-vous s&ucirc;r de vouloir Libérer cette chambre ?'));" >-->
                            <span title="Occup&eacute;e " data-toggle="tooltip" alt="non" class="label-warning label">Occup&eacute;e</span>
                        <!--</a>-->
                        <?php
                    }
                } else {
                    if ($recuser["etatchambre"]) {
                        ?>
                        <span title="Activ&eacute;" data-toggle="tooltip" alt="oui" class="label-success label">Activ&eacute;</span>
                        <?php
                    } else {
                        ?>
                        <span title="D&eacute;sactiv&eacute; " data-toggle="tooltip" alt="non" class="label-warning label">D&eacute;sactiv&eacute;</span>
                        <?php
                    }
                }
                ?>
            </td>
             <td>
        <!--                <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalparametre/hopitalchambre/detail_chambre') ?>&chambre=<?php echo $recuser["idchambre"] ?>">
                    <span title="Detail de cette chambre" alt="detail"><i class="glyphicon glyphicon-eye-open"></i></span>
                </a>
                &nbsp;&nbsp;-->
                <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalparametre/hopitalchambre/hopitalediter/edit_chambre') ?>&idchambre=<?php echo $recuser["idchambre"] ?>">
                    <span title="Modifier cette chambre" alt="editer"><i class="glyphicon glyphicon-pencil"></i></span>
                </a>
                &nbsp;&nbsp;
                <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalparametre/hopitalchambre/hopitallit/lister_lit') ?>&idchambre=<?php echo $recuser["idchambre"] ?>">
                    <span title="G&eacute;rer les lits de cette chambre" alt="detail"><i class="glyphicon glyphicon-bed"></i></span>
                </a>
            </td>
        </tr>
        <?php
    }
}

function update_chambre($reg, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    if (($reg != NULL) && isset($reg["1"])) {
        $req = $con->query("select * from hp_chambre where codechambre='" . addslashes($reg["1"]["codee"]) . "'") or die(mysqli_error($con));
        $nb = mysqli_num_rows($req);
        if (($nb == 0)) {
            $con->query("update hp_chambre set idcategoriechambre='" . $reg["1"]["categoriee"] . "', placechambre='" . ($reg["1"]["place"]) . "', "
                            . "codechambre='" . addslashes($reg["1"]["codee"]) . "', libellechambre='" . addslashes($reg["1"]["chambree"]) . "' "
                            . "where idchambre='" . $reg["1"]["idchambre"] . "'") or die(mysqli_error($con));
//            $con->query("insert into log(iduser,operation,dateLog) values('{$_SESSION['iduser']}','Mise a jour dans la table hp_chambre de la valeure {$reg["1"]["chambre"]}',now())") or die(mysqli_error($con));
            unset($_SESSION['formchambree']);
            echo "<script language='javascript'>$('div.editok').show('slow').delay(8000).hide('slow');</script>";
            $pagp = 'hopitalpages/hopitalparametre/hopitalchambre/lister_chambre';
            die('<meta http-equiv="refresh" content="3; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
        } else {
            $rowv = mysqli_fetch_assoc($req);
            if ($rowv["idchambre"] == $reg["1"]["idchambre"]) {
                $con->query("update hp_chambre set idcategoriechambre='" . $reg["1"]["categoriee"] . "', placechambre='" . ($reg["1"]["place"]) . "', "
                                . "codechambre='" . addslashes($reg["1"]["codee"]) . "', libellechambre='" . addslashes($reg["1"]["chambree"]) . "' "
                                . "where idchambre='" . $reg["1"]["idchambre"] . "'") or die(mysqli_error($con));
//            $con->query("insert into log(iduser,operation,dateLog) values('{$_SESSION['iduser']}','Mise a jour dans la table hp_chambre de la valeure {$reg["1"]["chambre"]}',now())") or die(mysqli_error($con));
                unset($_SESSION['formchambree']);
                echo "<script language='javascript'>$('div.editok').show('slow').delay(8000).hide('slow');</script>";
                $pagp = 'hopitalpages/hopitalparametre/hopitalchambre/lister_chambre';
                die('<meta http-equiv="refresh" content="3; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
            } else {
                echo "<script language='javascript'>$('div.addko').show('slow').delay(8000).hide('slow');</script>";
                $pagp = 'hopitalpages/hopitalparametre/hopitalchambre/hopitalediter/edit_chambre';
                die('<meta http-equiv="refresh" content="3; URL=' . $url . '?page=' . base64_encode($pagp) . '&idchambre=' . $reg["1"]["idchambre"] . '">');
            }
        }
    } else {
//        echo "<script language='javascript'>$('div.alertaddnull').show('slow').delay(8000).hide('slow');</script>";
    }
}

//fonction pour ajouter un categoriechambre
function inserer_categoriechambre($reg, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    if (($reg != NULL) && isset($reg["1"])) {
        $req = $con->query("select * from hp_categorie_chambre where libellecategoriechambre='" . addslashes($reg["1"]["libelle"]) . "'") or die(mysqli_error($con));
        $nb = mysqli_num_rows($req);
        if (($nb == 0)) {
            $con->query("insert into hp_categorie_chambre(libellecategoriechambre,prixcategoriechambre, datecategoriechambre) values('" . addslashes($reg["1"]["libelle"]) . "', "
                            . " '" . $reg["1"]["prix"] . "', NOW())") or die(mysqli_error($con));
//            $con->query("insert into log(iduser,operation,dateLog) values('{$_SESSION['iduser']}','Ajout dans la table hp_categorie_chambre de la valeure {$reg["1"]["categoriechambre"]}',now())") or die(mysqli_error($con));
            echo "<script language='javascript'>$('div.addok').show('slow').delay(8000).hide('slow');</script>";
            unset($_SESSION['formcategoriechambre']);
            $pagp = 'hopitalpages/hopitalparametre/hopitalchambre/hopitalcategoriechambre/lister_categoriechambre';
            die('<meta http-equiv="refresh" content="3 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
        } else {
            echo "<script language='javascript'>$('div.addko').show('slow').delay(8000).hide('slow');</script>";
            $pagp = 'hopitalpages/hopitalparametre/hopitalchambre/hopitalcategoriechambre/hopitalajouter/ajout_categoriechambre';
            die('<meta http-equiv="refresh" content="3 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
        }
    }
}

function lister_categoriechambre($con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    $rsltuser = $con->query("select * from hp_categorie_chambre ") or die(mysqli_error($con));
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        ?>
        <tr >
            <td></td>
            <td><?php print nl2br(htmlspecialchars($recuser["idcategoriechambre"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["libellecategoriechambre"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["prixcategoriechambre"])) ?></td>
            <td>
                <?php
                if ((isset($_SESSION["loginproprietaire"]) && isset($_SESSION["motdepasseproprietaire"])) || (isset($_SESSION["logincomptepersonnel"]) && isset($_SESSION["motdepassecomptepersonnel"]) && ($_SESSION["etatcomptepersonnel"]))) {
                    if ($recuser["etatcategoriechambre"]) {
                        ?>
                        <a href='<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalparametre/hopitalchambre/hopitalcategoriechambre/categoriechambre_ajax'); ?>&idcategoriechambre=<?php echo $recuser["idcategoriechambre"]; ?>&desactiver=desactiver' onclick="return(confirm('Etes-vous s&ucirc;r de vouloir Désactiver cette catégorie ?'));" >
                            <span title="Activ&eacute;" data-toggle="tooltip" alt="oui" class="label-success label">Activ&eacute;</span>
                        </a>
                <?php
            } else {
                ?>
                        <a href='<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalparametre/hopitalchambre/hopitalcategoriechambre/categoriechambre_ajax'); ?>&idcategoriechambre=<?php echo $recuser["idcategoriechambre"]; ?>&activer=activer' onclick="return(confirm('Etes-vous s&ucirc;r de vouloir Activer cette catégorie ?'));" >
                            <span title="D&eacute;sactiv&eacute; " data-toggle="tooltip" alt="non" class="label-warning label">D&eacute;sactiv&eacute;</span>
                        </a>
                        <?php
                    }
                } else {
                    if ($recuser["etatcategoriechambre"]) {
                        ?>
                        <span title="Activ&eacute;" data-toggle="tooltip" alt="oui" class="label-success label">Activ&eacute;</span>
                        <?php
                    } else {
                        ?>
                        <span title="D&eacute;sactiv&eacute; " data-toggle="tooltip" alt="non" class="label-warning label">D&eacute;sactiv&eacute;</span>
                        <?php
                    }
                }
                ?>
            </td>
            <td>
        <?php
        if ((isset($_SESSION["loginproprietaire"]) && isset($_SESSION["motdepasseproprietaire"])) || (isset($_SESSION["logincomptepersonnel"]) && isset($_SESSION["motdepassecomptepersonnel"]) && ($_SESSION["etatcomptepersonnel"]))) {
            ?>
                    <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalparametre/hopitalchambre/hopitalcategoriechambre/hopitalediter/edit_categoriechambre'); ?>&idcategoriechambre=<?php echo $recuser["idcategoriechambre"]; ?>" >
                        <span title="Modifier cette catégorie" alt="editer"><i class="glyphicon glyphicon-edit"></i></span>
                    </a>
                    &nbsp;&nbsp;
                    <a href='<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalparametre/hopitalchambre/hopitalcategoriechambre/categoriechambre_ajax'); ?>&idcategoriechambre=<?php echo $recuser["idcategoriechambre"]; ?>&supprimer=supprimer' onclick="return(confirm('Etes-vous s&ucirc;r de vouloir Supprimer cette catégorie ?'));" >
                        <span title="Supprimer cette catégorie " alt="suppr">  <i class="glyphicon glyphicon-trash"></i></span>
                    </a>
            <?php
        }
        ?>
            </td>
        </tr>
        <?php
    }
}

function update_categoriechambre($reg, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    if (($reg != NULL) && isset($reg["1"])) {
        $req = $con->query("select * from hp_categorie_chambre where libellecategoriechambre='" . addslashes($reg["1"]["libellee"]) . "'") or die(mysqli_error($con));
        $nb = mysqli_num_rows($req);
        if (($nb == 0)) {
            $con->query("update hp_categorie_chambre set libellecategoriechambre='" . addslashes($reg["1"]["libellee"]) . "' "
                            . ", prixcategoriechambre='" . addslashes($reg["1"]["prixe"]) . "'"
                            . "where idcategoriechambre='" . $reg["1"]["idcategoriechambre"] . "'") or die(mysqli_error($con));
//            $con->query("insert into log(iduser,operation,dateLog) values('{$_SESSION['iduser']}','Mise a jour dans la table hp_categorie_chambre de la valeure {$reg["1"]["categoriechambre"]}',now())") or die(mysqli_error($con));
            unset($_SESSION['formcategoriechambree']);
            echo "<script language='javascript'>$('div.editok').show('slow').delay(8000).hide('slow');</script>";
            $pagp = 'hopitalpages/hopitalparametre/hopitalchambre/hopitalcategoriechambre/lister_categoriechambre';
            die('<meta http-equiv="refresh" content="3; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
        } else {
            $rowv = mysqli_fetch_assoc($req);
            if ($rowv["idcategoriechambre"] == $reg["1"]["idcategoriechambre"]) {
                $con->query("update hp_categorie_chambre set libellecategoriechambre='" . addslashes($reg["1"]["libellee"]) . "' "
                                . ", prixcategoriechambre='" . addslashes($reg["1"]["prixe"]) . "'"
                                . "where idcategoriechambre='" . $reg["1"]["idcategoriechambre"] . "'") or die(mysqli_error($con));
//            $con->query("insert into log(iduser,operation,dateLog) values('{$_SESSION['iduser']}','Mise a jour dans la table hp_categorie_chambre de la valeure {$reg["1"]["categoriechambre"]}',now())") or die(mysqli_error($con));
                unset($_SESSION['formcategoriechambree']);
                echo "<script language='javascript'>$('div.editok').show('slow').delay(8000).hide('slow');</script>";
                $pagp = 'hopitalpages/hopitalparametre/hopitalchambre/hopitalcategoriechambre/lister_categoriechambre';
                die('<meta http-equiv="refresh" content="3; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
            } else {
                echo "<script language='javascript'>$('div.addko').show('slow').delay(8000).hide('slow');</script>";
                $pagp = 'hopitalpages/hopitalparametre/hopitalchambre/hopitalcategoriechambre/hopitalediter/edit_categoriechambre';
                die('<meta http-equiv="refresh" content="3; URL=' . $url . '?page=' . base64_encode($pagp) . '&idcategoriechambre=' . $reg["1"]["idcategoriechambre"] . '">');
            }
        }
    }
}

//fonction pour ajouter un materiel
function inserer_materiel($reg, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    if (($reg != NULL) && isset($reg["1"])) {
        $req = $con->query("select * from hp_materiel where libellemateriel='" . addslashes($reg["1"]["libelle"]) . "'") or die(mysqli_error($con));
        $nb = mysqli_num_rows($req);
        if (($nb == 0)) {
            $con->query("insert into hp_materiel(libellemateriel,typemateriel, datemateriel) values('" . addslashes($reg["1"]["libelle"]) . "', "
                            . " '" . $reg["1"]["type"] . "', NOW())") or die(mysqli_error($con));
//            $con->query("insert into log(iduser,operation,dateLog) values('{$_SESSION['iduser']}','Ajout dans la table hp_materiel de la valeure {$reg["1"]["materiel"]}',now())") or die(mysqli_error($con));
            echo "<script language='javascript'>$('div.addok').show('slow').delay(8000).hide('slow');</script>";
            unset($_SESSION['formmateriel']);
            $pagp = 'hopitalpages/hopitalparametre/hopitalchambre/hopitalmateriel/lister_materiel';
            die('<meta http-equiv="refresh" content="3 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
        } else {
            echo "<script language='javascript'>$('div.addko').show('slow').delay(8000).hide('slow');</script>";
            $pagp = 'hopitalpages/hopitalparametre/hopitalchambre/hopitalmateriel/hopitalajouter/ajout_materiel';
            die('<meta http-equiv="refresh" content="3 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
        }
    }
}

function lister_materiel($con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    $rsltuser = $con->query("select * from hp_materiel ") or die(mysqli_error($con));
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        ?>
        <tr >
            <td></td>
            <td><?php print nl2br(htmlspecialchars($recuser["idmateriel"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["libellemateriel"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["typemateriel"])) ?></td>
            <td>
        <?php
        if ((isset($_SESSION["loginproprietaire"]) && isset($_SESSION["motdepasseproprietaire"])) || (isset($_SESSION["logincomptepersonnel"]) && isset($_SESSION["motdepassecomptepersonnel"]) && ($_SESSION["etatcomptepersonnel"]))) {
            if ($recuser["etatmateriel"]) {
                ?>
                        <a href='<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalparametre/hopitalchambre/hopitalmateriel/materiel_ajax'); ?>&idmateriel=<?php echo $recuser["idmateriel"]; ?>&desactiver=desactiver' onclick="return(confirm('Etes-vous s&ucirc;r de vouloir Désactiver ce matériel ?'));" >
                            <span title="Activ&eacute;" data-toggle="tooltip" alt="oui" class="label-success label">Activ&eacute;</span>
                        </a>
                        <?php
                    } else {
                        ?>
                        <a href='<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalparametre/hopitalchambre/hopitalmateriel/materiel_ajax'); ?>&idmateriel=<?php echo $recuser["idmateriel"]; ?>&activer=activer' onclick="return(confirm('Etes-vous s&ucirc;r de vouloir Activer ce matériel ?'));" >
                            <span title="D&eacute;sactiv&eacute; " data-toggle="tooltip" alt="non" class="label-warning label">D&eacute;sactiv&eacute;</span>
                        </a>
                        <?php
                    }
                } else {
                    if ($recuser["etatmateriel"]) {
                        ?>
                        <span title="Activ&eacute;" data-toggle="tooltip" alt="oui" class="label-success label">Activ&eacute;</span>
                        <?php
                    } else {
                        ?>
                        <span title="D&eacute;sactiv&eacute; " data-toggle="tooltip" alt="non" class="label-warning label">D&eacute;sactiv&eacute;</span>
                        <?php
                    }
                }
                ?>
            </td>
            <td>
        <?php
        if ((isset($_SESSION["loginproprietaire"]) && isset($_SESSION["motdepasseproprietaire"])) || (isset($_SESSION["logincomptepersonnel"]) && isset($_SESSION["motdepassecomptepersonnel"]) && ($_SESSION["etatcomptepersonnel"]))) {
            ?>
                    <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalparametre/hopitalchambre/hopitalmateriel/hopitalediter/edit_materiel'); ?>&idmateriel=<?php echo $recuser["idmateriel"]; ?>" >
                        <span title="Modifier ce matériel" alt="editer"><i class="glyphicon glyphicon-edit"></i></span>
                    </a>
                    &nbsp;&nbsp;
                    <a href='<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalparametre/hopitalchambre/hopitalmateriel/materiel_ajax'); ?>&idmateriel=<?php echo $recuser["idmateriel"]; ?>&supprimer=supprimer' onclick="return(confirm('Etes-vous s&ucirc;r de vouloir Supprimer ce matériel ?'));" >
                        <span title="Supprimer ce matériel " alt="suppr">  <i class="glyphicon glyphicon-trash"></i></span>
                    </a>
            <?php
        }
        ?>
            </td>
        </tr>
        <?php
    }
}

function update_materiel($reg, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    if (($reg != NULL) && isset($reg["1"])) {
        $req = $con->query("select * from hp_materiel where libellemateriel='" . addslashes($reg["1"]["libellee"]) . "'") or die(mysqli_error($con));
        $nb = mysqli_num_rows($req);
        if (($nb == 0)) {
            $con->query("update hp_materiel set libellemateriel='" . addslashes($reg["1"]["libellee"]) . "' "
                            . ", typemateriel='" . addslashes($reg["1"]["typee"]) . "'"
                            . "where idmateriel='" . $reg["1"]["idmateriel"] . "'") or die(mysqli_error($con));
//            $con->query("insert into log(iduser,operation,dateLog) values('{$_SESSION['iduser']}','Mise a jour dans la table hp_materiel de la valeure {$reg["1"]["materiel"]}',now())") or die(mysqli_error($con));
            unset($_SESSION['formmateriele']);
            echo "<script language='javascript'>$('div.editok').show('slow').delay(8000).hide('slow');</script>";
            $pagp = 'hopitalpages/hopitalparametre/hopitalchambre/hopitalmateriel/lister_materiel';
            die('<meta http-equiv="refresh" content="3; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
        } else {
            $rowv = mysqli_fetch_assoc($req);
            if ($rowv["idmateriel"] == $reg["1"]["idmateriel"]) {
                $con->query("update hp_materiel set libellemateriel='" . addslashes($reg["1"]["libellee"]) . "' "
                                . ", typemateriel='" . addslashes($reg["1"]["typee"]) . "'"
                                . "where idmateriel='" . $reg["1"]["idmateriel"] . "'") or die(mysqli_error($con));
//            $con->query("insert into log(iduser,operation,dateLog) values('{$_SESSION['iduser']}','Mise a jour dans la table hp_materiel de la valeure {$reg["1"]["materiel"]}',now())") or die(mysqli_error($con));
                unset($_SESSION['formmateriele']);
                echo "<script language='javascript'>$('div.editok').show('slow').delay(8000).hide('slow');</script>";
                $pagp = 'hopitalpages/hopitalparametre/hopitalchambre/hopitalmateriel/lister_materiel';
                die('<meta http-equiv="refresh" content="3; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
            } else {
                echo "<script language='javascript'>$('div.addko').show('slow').delay(8000).hide('slow');</script>";
                $pagp = 'hopitalpages/hopitalparametre/hopitalchambre/hopitalmateriel/hopitalediter/edit_materiel';
                die('<meta http-equiv="refresh" content="3; URL=' . $url . '?page=' . base64_encode($pagp) . '&idmateriel=' . $reg["1"]["idmateriel"] . '">');
            }
        }
    }
}

//fonction pour ajouter un lit
function inserer_lit($reg, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    if (($reg != NULL) && isset($reg["1"])) {
        $reqc = $con->query("select * from hp_chambre where idchambre='" . ($reg["1"]["idchambre"]) . "'") or die(mysqli_error($con));
        $rowc = mysqli_fetch_assoc($reqc);
        $reql = $con->query("select * from hp_lit where idchambre='" . ($reg["1"]["idchambre"]) . "' and etatlit=true") or die(mysqli_error($con));
        $nbl = mysqli_num_rows($reql);
        if (($nbl < $rowc["placechambre"])) {
            $req = $con->query("select * from hp_lit where codelit='" . addslashes($reg["1"]["code"]) . "'") or die(mysqli_error($con));
            $nb = mysqli_num_rows($req);
            if (($nb == 0)) {
                $con->query("insert into hp_lit(idchambre, libellelit,codelit, datelit) values('" . $reg["1"]["idchambre"] . "', "
                                . "'" . addslashes($reg["1"]["libelle"]) . "', '" . $reg["1"]["code"] . "', NOW())") or die(mysqli_error($con));
//            $con->query("insert into log(iduser,operation,dateLog) values('{$_SESSION['iduser']}','Ajout dans la table hp_lit de la valeure {$reg["1"]["lit"]}',now())") or die(mysqli_error($con));
                echo "<script language='javascript'>$('div.addok').show('slow').delay(8000).hide('slow');</script>";
                unset($_SESSION['formlit']);
                $pagp = 'hopitalpages/hopitalparametre/hopitalchambre/hopitallit/lister_lit';
                die('<meta http-equiv="refresh" content="3 ; URL=' . $url . '?page=' . base64_encode($pagp) . '&idchambre=' . $reg["1"]["idchambre"] . '">');
            } else {
                echo "<script language='javascript'>$('div.addko').show('slow').delay(8000).hide('slow');</script>";
                $pagp = 'hopitalpages/hopitalparametre/hopitalchambre/hopitallit/hopitalajouter/ajout_lit';
                die('<meta http-equiv="refresh" content="3 ; URL=' . $url . '?page=' . base64_encode($pagp) . '&idchambre=' . $reg["1"]["idchambre"] . '">');
            }
        } else {
            echo "<script language='javascript'>$('div.addkolitc').show('slow').delay(8000).hide('slow');</script>";
            $pagp = 'hopitalpages/hopitalparametre/hopitalchambre/hopitallit/lister_lit';
            die('<meta http-equiv="refresh" content="3 ; URL=' . $url . '?page=' . base64_encode($pagp) . '&idchambre=' . $reg["1"]["idchambre"] . '">');
        }
    }
}

function lister_lit($id, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    $rsltuser = $con->query("select * from hp_lit as l where l.idchambre='" . $id . "' ") or die(mysqli_error($con));
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        ?>
        <tr >
            <td></td>
            <td><?php print nl2br(htmlspecialchars($recuser["idlit"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["codelit"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["libellelit"])) ?></td>
            <td>
                <?php
                if ((isset($_SESSION["loginproprietaire"]) && isset($_SESSION["motdepasseproprietaire"])) || (isset($_SESSION["logincomptepersonnel"]) && isset($_SESSION["motdepassecomptepersonnel"]) && ($_SESSION["etatcomptepersonnel"]))) {
                    if ($recuser["etatlit"]) {
                        ?>
                        <a href='<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalparametre/hopitalchambre/hopitallit/lit_ajax'); ?>&idlit=<?php echo $recuser["idlit"]; ?>&desactiver=desactiver' onclick="return(confirm('Etes-vous s&ucirc;r de vouloir Désactiver ce lit ?'));" >
                            <span title="Activ&eacute;" data-toggle="tooltip" alt="oui" class="label-success label">Activ&eacute;</span>
                        </a>
                        <?php
                    } else {
                        ?>
                        <a href='<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalparametre/hopitalchambre/hopitallit/lit_ajax'); ?>&idlit=<?php echo $recuser["idlit"]; ?>&activer=activer' onclick="return(confirm('Etes-vous s&ucirc;r de vouloir Activer ce lit ?'));" >
                            <span title="D&eacute;sactiv&eacute; " data-toggle="tooltip" alt="non" class="label-warning label">D&eacute;sactiv&eacute;</span>
                        </a>
                        <?php
                    }
                } else {
                    if ($recuser["etatlit"]) {
                        ?>
                        <span title="Activ&eacute;" data-toggle="tooltip" alt="oui" class="label-success label">Activ&eacute;</span>
                        <?php
                    } else {
                        ?>
                        <span title="D&eacute;sactiv&eacute; " data-toggle="tooltip" alt="non" class="label-warning label">D&eacute;sactiv&eacute;</span>
                        <?php
                    }
                }
                ?>
            </td>
            <td>
                <?php
                if ((isset($_SESSION["loginproprietaire"]) && isset($_SESSION["motdepasseproprietaire"])) || (isset($_SESSION["logincomptepersonnel"]) && isset($_SESSION["motdepassecomptepersonnel"]) && ($_SESSION["etatcomptepersonnel"]))) {
                    if ($recuser["statutlit"]) {
                        ?>
                        <span title="Libre" data-toggle="tooltip" alt="oui" class="label-success label">Libre</span>
                        <?php
                    } else {
                        ?>
                        <a href='<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalparametre/hopitalchambre/hopitallit/lit_ajax'); ?>&idlit=<?php echo $recuser["idlit"]; ?>&liberer=liberer' onclick="return(confirm('Etes-vous s&ucirc;r de vouloir Libérer ce lit ?'));" >
                            <span title="Occup&eacute; " data-toggle="tooltip" alt="non" class="label-warning label">Occup&eacute;</span>
                        </a>
                        <?php
                    }
                } else {
                    if ($recuser["statutlit"]) {
                        ?>
                        <span title="Activ&eacute;" data-toggle="tooltip" alt="oui" class="label-success label">Libre</span>
                        <?php
                    } else {
                        ?>
                        <span title="Occup&eacute; " data-toggle="tooltip" alt="non" class="label-warning label">Occup&eacute;</span>
                        <?php
                    }
                }
                ?>
            </td>
            <td>
        <?php
        if ((isset($_SESSION["loginproprietaire"]) && isset($_SESSION["motdepasseproprietaire"])) || (isset($_SESSION["logincomptepersonnel"]) && isset($_SESSION["motdepassecomptepersonnel"]) && ($_SESSION["etatcomptepersonnel"]))) {
            ?>
                    <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalparametre/hopitalchambre/hopitallit/hopitalediter/edit_lit'); ?>&idlit=<?php echo $recuser["idlit"]; ?>" >
                        <span title="Modifier ce lit" alt="editer"><i class="glyphicon glyphicon-edit"></i></span>
                    </a>
<!--                    &nbsp;&nbsp;
                    <a href='<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalparametre/hopitalchambre/hopitallit/lit_ajax'); ?>&idlit=<?php echo $recuser["idlit"]; ?>&supprimer=supprimer' onclick="return(confirm('Etes-vous s&ucirc;r de vouloir Supprimer ce lit ?'));" >
                        <span title="Supprimer ce lit " alt="suppr">  <i class="glyphicon glyphicon-trash"></i></span>
                    </a>-->
            <?php
        }
        ?>
            </td>
        </tr>
        <?php
    }
}

function update_lit($reg, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    if (($reg != NULL) && isset($reg["1"])) {
        $reql = $con->query("select * from hp_lit as l left join hp_chambre as c on l.idchambre=c.idchambre "
                . "where l.idlit='" . $reg["1"]["idlit"] . "'") or die(mysqli_error($con));
        $row = mysqli_fetch_assoc($reql);
        $req = $con->query("select * from hp_lit where codelit='" . addslashes($reg["1"]["codee"]) . "'") or die(mysqli_error($con));
        $nb = mysqli_num_rows($req);
        if (($nb == 0)) {
            $con->query("update hp_lit set libellelit='" . addslashes($reg["1"]["libellee"]) . "' "
                            . ", codelit='" . addslashes($reg["1"]["codee"]) . "'"
                            . "where idlit='" . $reg["1"]["idlit"] . "'") or die(mysqli_error($con));
//            $con->query("insert into log(iduser,operation,dateLog) values('{$_SESSION['iduser']}','Mise a jour dans la table hp_lit de la valeure {$reg["1"]["lit"]}',now())") or die(mysqli_error($con));
            unset($_SESSION['formlite']);
            echo "<script language='javascript'>$('div.editok').show('slow').delay(8000).hide('slow');</script>";
            $pagp = 'hopitalpages/hopitalparametre/hopitalchambre/hopitallit/lister_lit';
            die('<meta http-equiv="refresh" content="3; URL=' . $url . '?page=' . base64_encode($pagp) . '&idchambre=' . $row["idchambre"] . '">');
        } else {
            $rowv = mysqli_fetch_assoc($req);
            if ($rowv["idlit"] == $reg["1"]["idlit"]) {
                $con->query("update hp_lit set libellelit='" . addslashes($reg["1"]["libellee"]) . "' "
                                . ", codelit='" . addslashes($reg["1"]["codee"]) . "'"
                                . "where idlit='" . $reg["1"]["idlit"] . "'") or die(mysqli_error($con));
//           $con->query("insert into log(iduser,operation,dateLog) values('{$_SESSION['iduser']}','Mise a jour dans la table hp_lit de la valeure {$reg["1"]["lit"]}',now())") or die(mysqli_error($con));
                unset($_SESSION['formlite']);
                echo "<script language='javascript'>$('div.editok').show('slow').delay(8000).hide('slow');</script>";
                $pagp = 'hopitalpages/hopitalparametre/hopitalchambre/hopitallit/lister_lit';
                die('<meta http-equiv="refresh" content="3; URL=' . $url . '?page=' . base64_encode($pagp) . '&idchambre=' . $row["idchambre"] . '">');
            } else {
                echo "<script language='javascript'>$('div.addko').show('slow').delay(8000).hide('slow');</script>";
                $pagp = 'hopitalpages/hopitalparametre/hopitalchambre/hopitallit/hopitalediter/edit_lit';
                die('<meta http-equiv="refresh" content="3; URL=' . $url . '?page=' . base64_encode($pagp) . '&idlit=' . $reg["1"]["idlit"] . '">');
            }
        }
    }
}
?>