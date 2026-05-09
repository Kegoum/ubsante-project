<?php

//gestion des Personnels
//fonction pour ajouter un Personnel

function inserer_personnel($reg, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);

    if (($reg != NULL) && isset($reg["1"])) {

        $nomp = addslashes($reg["1"]['nom']);
        $prenomp = addslashes($reg["1"]['prenom']);
        $telp = ($reg["1"]['tel']);
        $servpa = ($reg["1"]['service']);
        $rolep = ($reg["1"]['role']);
        $sal = ($reg["1"]['salaire']);
        $type = ($reg["1"]['typepaiement']);
        $rsltspe1ut = $con->query("select * from hp_service where "
                . "idservice='" . $reg["1"]['service'] . "'") or die(mysqli_error($con));
        $recut = mysqli_fetch_assoc($rsltspe1ut);
        $and = date('Y');
        $sand = substr($and, 2);
        $co = strtoupper(substr($recut["codeservice"], 0, 2));
        $tail2 = (strlen($sand . $co));

        $chaine = $sand . $co;
        $numid = $sand . $co . sprintf("%03d", 1);

        $req = $con->query("select SUBSTR(e.codepersonnel, '" . ($tail2 + 1) . "',3) as mat from hp_personnel as e where "
                . "SUBSTR(e.codepersonnel, 1,'" . $tail2 . "')='" . $chaine . "' order by SUBSTR(e.codepersonnel, "
                . "'" . ($tail2 + 1) . "',3) asc") or die(mysqli_error($con));
        $i = mysqli_num_rows($req);
        if ($i != 0) {
            $matri33 = '';
            while ($ro = mysqli_fetch_assoc($req)) {
                $matri33 = ($ro["mat"]);
            }
            $numid = $sand . $co . sprintf("%03d", ($matri33 + 1));
        }

        $but = "Recrutement";

        $con->query("insert into hp_personnel(nompersonnel, prenompersonnel, telephonepersonnel, rolepersonnel, codepersonnel, "
                        . "datepersonnel) values('" . $nomp . "', '" . $prenomp . "','" . $telp . "','" . $rolep . "', '" . $numid . "', NOW())")
                or die(mysqli_error($con));
        $resultat2 = $con->query("SELECT * FROM hp_personnel where codepersonnel='" . $numid . "'") or die(mysqli_error($con));
        $row2 = mysqli_fetch_assoc($resultat2);
        $con->query("insert into hp_affectation(idservice, idpersonnel, roleaffectation, dateaffectation, butaffectation, salaireaffectation, typepaiement) "
                        . "values('" . $servpa . "', '" . $row2["idpersonnel"] . "', '" . $rolep . "',NOW(),'" . $but . "','" . $sal . "','" . $type . "')") or die(mysqli_error($con));
        unset($_SESSION['formpersonnel']);
        echo "<script language='javascript'>$('div.addok').show('slow').delay(8000).hide('slow');</script>";
        $pagp = 'hopitalpages/hopitalpersonnel/lister_personnel';
        die('<meta http-equiv="refresh" content="3 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
    }
}

//fonction pour ajouter compte a un Personnel
function inserer_compte_personnel($reg, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    if (($reg != NULL) && isset($reg["1"])) {
        $reqcp = $con->query("select * from hp_compte_personnel where idpersonnel= '" . $reg["1"]["idpersonnel"] . "'") or die(mysqli_error($con));
        $rowcp = mysqli_fetch_assoc($reqcp);

        $reqcpp = $con->query("select * from hp_personnel where idpersonnel= '" . $reg["1"]["idpersonnel"] . "'") or die(mysqli_error($con));
        $rowcpp = mysqli_fetch_assoc($reqcpp);
        $idpers = $reg["1"]["idpersonnel"];
        $loginp = $reg["1"]["loginp"];
        $pas1 = $rowcp["motdepassecomptepersonnel"];
        if ($reg["1"]['pas1'] != NULL) {
            $pas1 = sha1($reg["1"]['pas1']);
        }
        $req = $con->query("select * from hp_proprietaire where loginproprietaire= '" . $loginp . "' and "
                . "motdepasseproprietaire= '" . $pas1 . "'") or die(mysqli_error($con));
        $nb = mysqli_num_rows($req);
        if (($nb == 0)) {
            $reqp = $con->query("select * from hp_compte_personnel where logincomptepersonnel= '" . $loginp . "' and "
                    . "motdepassecomptepersonnel= '" . $pas1 . "'") or die(mysqli_error($con));
            $nbp = mysqli_num_rows($reqp);

            $reqem = $con->query("select * from hp_compte_personnel where idpersonnel= '" . $idpers . "'") or die(mysqli_error($con));
            $nbem = mysqli_num_rows($reqem);
            if (($nbem == 0) && ($nbp == 0)) {
                $con->query("insert into hp_compte_personnel(idpersonnel, logincomptepersonnel, motdepassecomptepersonnel, rolecomptepersonnel) "
                                . "values('" . $idpers . "', '" . $loginp . "','" . $pas1 . "','" . $rowcpp["rolepersonnel"] . "')") or die(mysqli_error($con));

                unset($_SESSION['formcomptepersonnel']);
                echo "<script language='javascript'>$('div.addok').show('slow').delay(8000).hide('slow');</script>";
                $pagp = 'hopitalpages/hopitalpersonnel/lister_personnel';
                die('<meta http-equiv="refresh" content="3 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
            } else {
                echo "<script language='javascript'>$('div.addko').show('slow').delay(8000).hide('slow');</script>";
                $pagp = 'hopitalpages/hopitalpersonnel/hopitalcompte/hopitalajouter/ajout_compte';
                die('<meta http-equiv="refresh" content="3 ; URL=' . $url . '?page=' . base64_encode($pagp) . '&personnel=' . $idpers . '">');
            }
        } else {
            echo "<script language='javascript'>$('div.addko').show('slow').delay(8000).hide('slow');</script>";
            $pagp = 'hopitalpages/hopitalpersonnel/hopitalcompte/hopitalajouter/ajout_compte';
            die('<meta http-equiv="refresh" content="3 ; URL=' . $url . '?page=' . base64_encode($pagp) . '&personnel=' . $idpers . '">');
        }
    }
}

//fonction pour lister les Personnels
function lister_personnel($con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    $rsltuser = $con->query("select * from hp_personnel as pe left join hp_affectation as af on "
            . "pe.idpersonnel=af.idpersonnel left join hp_service as s on af.idservice=s.idservice "
            . "where af.etataffectation=true ") or die(mysqli_error($con));
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        $rsltcompte = $con->query('select * from hp_compte_personnel where idpersonnel=' . $recuser['idpersonnel'] . '') or die(mysqli_error($con));
        $nbcompte = mysqli_num_rows($rsltcompte);
        ?>

        <tr >
            <td><?php print nl2br(htmlspecialchars($recuser["codepersonnel"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["nompersonnel"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["prenompersonnel"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["telephonepersonnel"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["nomservice"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["rolepersonnel"])) ?></td>
            <td>
                <?php
                if (isset($_SESSION["loginproprietaire"])) {
                    if ($nbcompte == 0) {
                        ?>&nbsp;&nbsp;
                        <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpersonnel/hopitalcompte/hopitalajouter/ajout_compte') ?>&personnel=<?php echo $recuser["idpersonnel"] ?>">
                            <span title="Attribuer un Compte" alt="editer"><i class="glyphicon glyphicon-plus"></i></span>
                        </a>
                        <?php
                    } else {
                        $rowcompte = mysqli_fetch_assoc($rsltcompte);
                        print nl2br(htmlspecialchars($rowcompte["logincomptepersonnel"]));
                        if ($rowcompte["etatcomptepersonnel"]) {
                            ?>&nbsp;&nbsp;
                            <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpersonnel/hopitalcompte/comptepersonnel_ajax'); ?>&idcomptepersonnel=<?php echo $rowcompte["idcomptepersonnel"]; ?>&desactiverc=desactiver" onclick="return(confirm('Etes-vous s&ucirc;r de vouloir Désactiver ce Compte personnel ?'));">
                                <span title="Activ&eacute;" data-toggle="tooltip" alt="oui" ><i class="glyphicon glyphicon-check"></i></span>
                            </a>
                            <?php
                        } else {
                            ?>&nbsp;&nbsp;
                            <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpersonnel/hopitalcompte/comptepersonnel_ajax'); ?>&idcomptepersonnel=<?php echo $rowcompte["idcomptepersonnel"]; ?>&activerc=activer" onclick="return(confirm('Etes-vous s&ucirc;r de vouloir Activer ce Compte personnel ?'));">
                                <span title="D&eacute;sactiv&eacute; " data-toggle="tooltip" alt="non"><i class="glyphicon glyphicon-remove"></i></span>
                            </a>
                            <?php
                        }
                    }
                }
                ?>
            </td>
            <td><?php  print nl2br(htmlspecialchars($recuser["salaireaffectation"])) ?> / <?php  print nl2br(htmlspecialchars($recuser["typepaiement"])) ?></td>
            <td>
                <?php
                if (isset($_SESSION["loginproprietaire"])) {
                    ?>
                    <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpersonnel/hopitalediter/edit_personnel') ?>&personnel=<?php echo $recuser["idpersonnel"] ?>">
                        <span title="Modifier un Personnel" alt="editer"><i class="glyphicon glyphicon-edit"></i></span>
                    </a>&nbsp;&nbsp;
                    <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpersonnel/hopitalaffectation/lister_affectation_personnel') ?>&personnel=<?php echo $recuser["idpersonnel"] ?>">
                        <span title="Lister les affectations de ce Personnel" alt="listaffecter"><i class="glyphicon glyphicon-send"></i></span>
                    </a>
                    <?php
                    if ($nbcompte != 0) {
                        if ($recuser["rolepersonnel"] == "Caisse") {
                            $reqrest = $con->query("select * from hp_personnel_caisse as r left join hp_caisse as u on r.idcaisse=u.idcaisse "
                                    . "where r.idpersonnel='" . $recuser["idpersonnel"] . "'") or die(mysqli_error($con));
                            $nbrest = mysqli_num_rows($reqrest);
                            if ($nbrest != 0) {
                                $rowrest = mysqli_fetch_assoc($reqrest);
//                                
                                ?>&nbsp;&nbsp;
                                <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpersonnel/personnel_caisse_edit') ?>&personnel=<?php echo $recuser["idpersonnel"] ?>&caisse=<?php echo $rowrest["idcaisse"] ?>">
                                    <?php
                                    print nl2br(htmlspecialchars($rowrest["nomcaisse"]));
                                    ?>
                                </a>
                                <?php
                            } else {
                                ?>&nbsp;&nbsp;
                                <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpersonnel/personnel_caisse') ?>&personnel=<?php echo $recuser["idpersonnel"] ?>">
                                    <span title="Choisir une caisse" alt="caisse"><i class="glyphicon glyphicon-home"></i></span>
                                </a>
                                <?php
                            }
                        }
                        if ($recuser["rolepersonnel"] == "Magasinier") {
                            $reqrest = $con->query("select * from hp_personnel_magasin as r left join hp_magasin as u on r.idmagasin=u.idmagasin "
                                    . "where r.idpersonnel='" . $recuser["idpersonnel"] . "'") or die(mysqli_error($con));
                            $nbrest = mysqli_num_rows($reqrest);
                            if ($nbrest != 0) {
                                $rowrest = mysqli_fetch_assoc($reqrest);
//                                
                                ?>&nbsp;&nbsp;
                                <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpersonnel/personnel_magasin_edit') ?>&personnel=<?php echo $recuser["idpersonnel"] ?>&magasin=<?php echo $rowrest["idmagasin"] ?>">
                                    <?php
                                    print nl2br(htmlspecialchars($rowrest["nommagasin"]));
                                    ?>
                                </a>
                                <?php
                            } else {
                                ?>&nbsp;&nbsp;
                                <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpersonnel/personnel_magasin') ?>&personnel=<?php echo $recuser["idpersonnel"] ?>">
                                    <span title="Choisir un magasin" alt="magasin"><i class="glyphicon glyphicon-home"></i></span>
                                </a>
                                <?php
                            }
                        }
                        if ($recuser["rolepersonnel"] == "Pharmacien") {
                            $reqrest = $con->query("select * from hp_personnel_pharmacie as r left join hp_pharmacie as u on r.idpharmacie=u.idpharmacie "
                                    . "where r.idpersonnel='" . $recuser["idpersonnel"] . "'") or die(mysqli_error($con));
                            $nbrest = mysqli_num_rows($reqrest);
                            if ($nbrest != 0) {
                                $rowrest = mysqli_fetch_assoc($reqrest);
//                                
                                ?>&nbsp;&nbsp;
                                <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpersonnel/personnel_pharmacie_edit') ?>&personnel=<?php echo $recuser["idpersonnel"] ?>&pharmacie=<?php echo $rowrest["idpharmacie"] ?>">
                                    <?php
                                    print nl2br(htmlspecialchars($rowrest["nompharmacie"]));
                                    ?>
                                </a>
                                <?php
                            } else {
                                ?>&nbsp;&nbsp;
                                <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpersonnel/personnel_pharmacie') ?>&personnel=<?php echo $recuser["idpersonnel"] ?>">
                                    <span title="Choisir une pharmacie" alt="pharmacie"><i class="glyphicon glyphicon-home"></i></span>
                                </a>
                                <?php
                            }
                        }
                    }
                    ?>
                    <?php
                } else {
                    ?>
                    <?php
                }
                ?>

            </td>
        </tr>

        <?php
    }
}

//fonction pour modifier un Personnel
function update_personnel($reg, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);

    if (($reg != NULL) && isset($reg["1"])) {
        $id = ($reg["1"]['idpersonnel']);
        $nomp = addslashes($reg["1"]['nom']);
        $prenomp = addslashes($reg["1"]['prenom']);
        $telp = ($reg["1"]['tel']);
        $servpa = ($reg["1"]['service']);
        $rolep = ($reg["1"]['role']);
        $sal = ($reg["1"]['salaire']);
        $type = ($reg["1"]['typepaiement']);

        $con->query("update hp_personnel set nompersonnel='" . $nomp . "', prenompersonnel='" . $prenomp . "', "
                        . "telephonepersonnel='" . $telp . "', rolepersonnel='" . $rolep . "' where idpersonnel='" . $id . "'") or die(mysqli_error($con));

        $con->query("update hp_affectation set idservice='" . $servpa . "', salaireaffectation='" . $sal . "', typepaiement='" . $type . "' where idpersonnel='" . $id . "' and "
                        . "etataffectation=true") or die(mysqli_error($con));
        unset($_SESSION['formpersonnele']);
        echo "<script language='javascript'>$('div.addok').show('slow').delay(8000).hide('slow');</script>";
        $pagp = 'hopitalpages/hopitalpersonnel/lister_personnel';
        die('<meta http-equiv="refresh" content="3 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
    }
}

//fonction pour affecter un Personnel
function affecter_personnel($reg, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    if (($reg != NULL) && isset($reg["1"])) {
        $id = $reg["1"]['idpersonnel'];
        $rolepa = $reg["1"]['rolea'];
        $servpaa = $reg["1"]['servicea'];
        $rolep = $reg["1"]['role'];
        $servpa = $reg["1"]['service'];
        $sal = ($reg["1"]['salaire']);
        $type = ($reg["1"]['typepaiement']);
//    echo "<script language='javascript'>alert('ollll')</script>";
        if (($servpaa != $servpa) || ($rolepa != $rolep)) {
//        echo "<script language='javascript'>alert($pointapa)</script>";
            $but = "Affectation";
//    $etaaf = 0;
            $eta = 0;
            $con->query("update hp_affectation set etataffectation='" . $eta . "' where "
                            . "idservice='" . $servpaa . "' and "
                            . "idpersonnel='" . $id . "' and etataffectation=true") or die(mysqli_error($con));
            $con->query("insert into hp_affectation(idservice, idpersonnel, roleaffectation, dateaffectation, butaffectation, salaireaffectation, typepaiement) "
                            . "values( '" . $servpa . "', '" . $id . "', '" . $rolep . "',NOW(),'" . $but . "','" . $sal . "','" . $type . "')") or die(mysqli_error($con));
            $con->query("update hp_personnel set rolepersonnel='" . $rolep . "' where idpersonnel='" . $id . "'") or die(mysqli_error($con));
            unset($_SESSION['formaffectation']);
            echo "<script language='javascript'>$('div.addok').show('slow').delay(8000).hide('slow');</script>";
            $pagp = 'hopitalpages/hopitalpersonnel/lister_personnel';
            die('<meta http-equiv="refresh" content="3 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
        } else {
            echo "<script language='javascript'>$('div.addko').show('slow').delay(8000).hide('slow');</script>";
            $pagp = 'hopitalpages/hopitalpersonnel/lister_personnel';
            die('<meta http-equiv="refresh" content="3 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
        }
    }
}

//fonction pour lister les Personnels
function lister_affectation_personnel($id, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    $rsltuser = $con->query("select * from hp_affectation as af left join hp_personnel as pe "
            . "on pe.idpersonnel=af.idpersonnel left join hp_service as s on af.idservice=s.idservice "
            . "where af.idpersonnel='" . $id . "' ") or die(mysqli_error($con));
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        $rsltcompte = $con->query('select * from hp_compte_personnel where idpersonnel=' . $recuser['idpersonnel'] . '') or die(mysqli_error($con));
        $nbcompte = mysqli_num_rows($rsltcompte);
        ?>

        <tr >
            <td ></td>
            <td><?php print nl2br(htmlspecialchars($recuser["dateaffectation"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["roleaffectation"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["nomservice"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["salaireaffectation"])) ?> / <?php print nl2br(htmlspecialchars($recuser["typepaiement"])) ?></td>
            <td>
                <?php
                if ($recuser["etataffectation"]) {
                    ?>
                    <span title="Actif " data-toggle="tooltip" alt="oui" class="label label-success">Actif</span>
                    <?php
                } else {
                    ?>
                    <span title="Non Actif " data-toggle="tooltip" alt="non" class="label label-danger">Non actif</span>
                    <?php
                }
                ?>
            </td>
        </tr>

        <?php
    }
}

function ajouter_caissepers($idpers, $rest, $i, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    for ($j = 0; $j < $i; $j++) {
        $req = $con->query("select * from hp_personnel_caisse where idpersonnel= '" . $idpers . "' and idcaisse= '" . $rest[$j] . "'") or die(mysqli_error($con));
        $nb = mysqli_num_rows($req);
        if (($nb == 0)) {
            $rslt = $con->query("insert into hp_personnel_caisse(idpersonnel, idcaisse) values('" . $idpers . "', "
                    . "'" . $rest[$j] . "')") or die(mysqli_error($con));
        }
    }
    echo "<script language='javascript'>$('div.addok').show('slow').delay(8000).hide('slow');</script>";
    $pagp = 'hopitalpages/hopitalpersonnel/lister_personnel';
    die('<meta http-equiv="refresh" content="3 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
}

function editer_caissepers($idpers, $rest, $idrest, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    $rslt = $con->query("update hp_personnel_caisse set idcaisse='" . $rest . "' where "
            . "idcaisse='" . $idrest . "' and idpersonnel='" . $idpers . "'") or die(mysqli_error($con));

    echo "<script language='javascript'>$('div.editok').show('slow').delay(8000).hide('slow');</script>";
    $pagp = 'hopitalpages/hopitalpersonnel/lister_personnel';
    die('<meta http-equiv="refresh" content="3 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
}

function ajouter_magasinpers($idpers, $rest, $i, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    for ($j = 0; $j < $i; $j++) {
        $req = $con->query("select * from hp_personnel_magasin where idpersonnel= '" . $idpers . "' and idmagasin= '" . $rest[$j] . "'") or die(mysqli_error($con));
        $nb = mysqli_num_rows($req);
        if (($nb == 0)) {
            $rslt = $con->query("insert into hp_personnel_magasin(idpersonnel, idmagasin) values('" . $idpers . "', "
                    . "'" . $rest[$j] . "')") or die(mysqli_error($con));
        }
    }
    echo "<script language='javascript'>$('div.addok').show('slow').delay(8000).hide('slow');</script>";
    $pagp = 'hopitalpages/hopitalpersonnel/lister_personnel';
    die('<meta http-equiv="refresh" content="3 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
}

function editer_magasinpers($idpers, $rest, $idrest, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    $rslt = $con->query("update hp_personnel_magasin set idmagasin='" . $rest . "' where "
            . "idmagasin='" . $idrest . "' and idpersonnel='" . $idpers . "'") or die(mysqli_error($con));

    echo "<script language='javascript'>$('div.editok').show('slow').delay(8000).hide('slow');</script>";
    $pagp = 'hopitalpages/hopitalpersonnel/lister_personnel';
    die('<meta http-equiv="refresh" content="3 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
}

function ajouter_pharmaciepers($idpers, $rest, $i, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    for ($j = 0; $j < $i; $j++) {
        $req = $con->query("select * from hp_personnel_pharmacie where idpersonnel= '" . $idpers . "' and idpharmacie= '" . $rest[$j] . "'") or die(mysqli_error($con));
        $nb = mysqli_num_rows($req);
        if (($nb == 0)) {
            $rslt = $con->query("insert into hp_personnel_pharmacie(idpersonnel, idpharmacie) values('" . $idpers . "', "
                    . "'" . $rest[$j] . "')") or die(mysqli_error($con));
        }
    }
    echo "<script language='javascript'>$('div.addok').show('slow').delay(8000).hide('slow');</script>";
    $pagp = 'hopitalpages/hopitalpersonnel/lister_personnel';
    die('<meta http-equiv="refresh" content="3 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
}

function editer_pharmaciepers($idpers, $rest, $idrest, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    $rslt = $con->query("update hp_personnel_pharmacie set idpharmacie='" . $rest . "' where "
            . "idpharmacie='" . $idrest . "' and idpersonnel='" . $idpers . "'") or die(mysqli_error($con));

    echo "<script language='javascript'>$('div.editok').show('slow').delay(8000).hide('slow');</script>";
    $pagp = 'hopitalpages/hopitalpersonnel/lister_personnel';
    die('<meta http-equiv="refresh" content="3 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
}

function update_profil($nom, $prenom, $email, $tel, $login, $motdepasse1, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    $reqpe = $con->query("select * from hp_compte_personnel where id_comptepersonnel= '" . $_SESSION["id_compte_personnel"] . "' ") or die(mysqli_error($con));
    $rowpe = mysqli_fetch_assoc($reqpe);
    $reqp = $con->query("select * from hp_compte_personnel where login_pe= '" . $login . "' or password_pe= '" . sha1($motdepasse1) . "'") or die(mysqli_error($con));
    $nbp = mysqli_num_rows($reqp);
    if (($nbp == 0)) {
        $req = $con->query("select * from hp_proprietaire where login_p= '" . $login . "' or password_p= '" . sha1($motdepasse1) . "'") or die(mysqli_error($con));
        $nb = mysqli_num_rows($req);
        if (($nb == 0)) {
            $reqc = $con->query("select * from hp_compte_client where login_cl= '" . $login . "' or password_cl= '" . sha1($motdepasse1) . "'") or die(mysqli_error($con));
            $nbc = mysqli_num_rows($reqc);
            if (($nbc == 0)) {
                $reqem = $con->query("select * from hp_personnel where email_pe= '" . $email . "' ") or die(mysqli_error($con));
                $nbem = mysqli_num_rows($reqem);
                if (($nbem == 0)) {
                    if ($motdepasse1 == NULL) {
                        $rsltp = $con->query("update hp_personnel set nom_pe='" . $nom . "',prenom_pe='" . $prenom . "',"
                                . "email_pe='" . $email . "',tel_pe='" . $tel . "' where id_personnel='" . $rowpe["id_personnel"] . "'") or die(mysqli_error($con));

                        $rsltc = $con->query("update hp_compte_personnel set login_pe='" . $login . "' where id_compte_personnel= '" . $_SESSION["id_compte_personnel"] . "'") or die(mysqli_error($con));

                        $_SESSION["nom_personnel"] = $nom;
                        $_SESSION["prenom_personnel"] = $prenom;
                        $_SESSION["login_personnel"] = $login;
                        $_SESSION["telephone_personnel"] = $tel;
                        $_SESSION["email_personnel"] = $email;
                        echo "<script language='javascript'>$('div.alertmodifbon').show('slow').delay(8000).hide('slow');</script>";
                    } else {
                        $rsltp = $con->query("update hp_personnel set nom_pe='" . $nom . "',prenom_pe='" . $prenom . "',"
                                . "email_pe='" . $email . "',tel_pe='" . $tel . "' where id_personnel='" . $rowpe["id_personnel"] . "'") or die(mysqli_error($con));

                        $rsltc = $con->query("update hp_compte_personnel set login_pe='" . $login . "',password_pe='" . sha1($motdepasse1) . "' where id_compte_personnel= '" . $_SESSION["id_compte_personnel"] . "'") or die(mysqli_error($con));

                        $_SESSION["nom_personnel"] = $nom;
                        $_SESSION["prenom_personnel"] = $prenom;
                        $_SESSION["login_personnel"] = $login;
                        $_SESSION["mot_de_passe_personnel"] = sha1($motdepasse1);
                        $_SESSION["telephone_personnel"] = $tel;
                        $_SESSION["email_personnel"] = $email;

                        echo "<script language='javascript'>$('div.alertmodifbon').show('slow').delay(8000).hide('slow');</script>";
                    }
                } else {
                    $rowem = mysqli_fetch_assoc($reqem);
                    if (($rowem["id_personnel"] == $rowpe["id_personnel"])) {
                        if ($motdepasse1 == NULL) {
                            $rsltp = $con->query("update hp_personnel set nom_pe='" . $nom . "',prenom_pe='" . $prenom . "',"
                                    . "email_pe='" . $email . "',tel_pe='" . $tel . "' where id_personnel='" . $rowpe["id_personnel"] . "'") or die(mysqli_error($con));

                            $rsltc = $con->query("update hp_compte_personnel set login_pe='" . $login . "' where id_compte_personnel= '" . $_SESSION["id_compte_personnel"] . "'") or die(mysqli_error($con));

                            $_SESSION["nom_personnel"] = $nom;
                            $_SESSION["prenom_personnel"] = $prenom;
                            $_SESSION["login_personnel"] = $login;
                            $_SESSION["telephone_personnel"] = $tel;
                            $_SESSION["email_personnel"] = $email;
                            echo "<script language='javascript'>$('div.alertmodifbon').show('slow').delay(8000).hide('slow');</script>";
                        } else {
                            $rsltp = $con->query("update hp_personnel set nom_pe='" . $nom . "',prenom_pe='" . $prenom . "',"
                                    . "email_pe='" . $email . "',tel_pe='" . $tel . "' where id_personnel='" . $rowpe["id_personnel"] . "'") or die(mysqli_error($con));

                            $rsltc = $con->query("update hp_compte_personnel set login_pe='" . $login . "',password_pe='" . sha1($motdepasse1) . "' where id_compte_personnel= '" . $_SESSION["id_compte_personnel"] . "'") or die(mysqli_error($con));

                            $_SESSION["nom_personnel"] = $nom;
                            $_SESSION["prenom_personnel"] = $prenom;
                            $_SESSION["login_personnel"] = $login;
                            $_SESSION["mot_de_passe_personnel"] = sha1($motdepasse1);
                            $_SESSION["telephone_personnel"] = $tel;
                            $_SESSION["email_personnel"] = $email;

                            echo "<script language='javascript'>$('div.alertmodifbon').show('slow').delay(8000).hide('slow');</script>";
                        }
                    } else {
                        echo "<script language='javascript'>$('div.alertaddmauv').show('slow').delay(8000).hide('slow');</script>";
                    }
                }
            } else {
                echo "<script language='javascript'>$('div.alertaddmauv').show('slow').delay(8000).hide('slow');</script>";
            }
        } else {
            echo "<script language='javascript'>$('div.alertaddmauv').show('slow').delay(8000).hide('slow');</script>";
        }
    } else {
        $recuser = mysqli_fetch_array($reqp);
        if (($recuser["id_compte_personnel"] == $_SESSION["id_compte_personnel"])) {
            if ($motdepasse1 == NULL) {
                $rsltp = $con->query("update hp_personnel set nom_pe='" . $nom . "',prenom_pe='" . $prenom . "',"
                        . "email_pe='" . $email . "',tel_pe='" . $tel . "' where id_personnel='" . $rowpe["id_personnel"] . "'") or die(mysqli_error($con));

                $rsltc = $con->query("update hp_compte_personnel set login_pe='" . $login . "' where id_compte_personnel= '" . $_SESSION["id_compte_personnel"] . "'") or die(mysqli_error($con));

                $_SESSION["nom_personnel"] = $nom;
                $_SESSION["prenom_personnel"] = $prenom;
                $_SESSION["login_personnel"] = $login;
                $_SESSION["telephone_personnel"] = $tel;
                $_SESSION["email_personnel"] = $email;
                echo "<script language='javascript'>$('div.alertmodifbon').show('slow').delay(8000).hide('slow');</script>";
            } else {
                $rsltp = $con->query("update hp_personnel set nom_pe='" . $nom . "',prenom_pe='" . $prenom . "',"
                        . "email_pe='" . $email . "',tel_pe='" . $tel . "' where id_personnel='" . $rowpe["id_personnel"] . "'") or die(mysqli_error($con));

                $rsltc = $con->query("update hp_compte_personnel set login_pe='" . $login . "',password_pe='" . sha1($motdepasse1) . "' where id_compte_personnel= '" . $_SESSION["id_compte_personnel"] . "'") or die(mysqli_error($con));

                $_SESSION["nom_personnel"] = $nom;
                $_SESSION["prenom_personnel"] = $prenom;
                $_SESSION["login_personnel"] = $login;
                $_SESSION["mot_de_passe_personnel"] = sha1($motdepasse1);
                $_SESSION["telephone_personnel"] = $tel;
                $_SESSION["email_personnel"] = $email;

                echo "<script language='javascript'>$('div.alertmodifbon').show('slow').delay(8000).hide('slow');</script>";
            }
        } else {
            echo "<script language='javascript'>$('div.alertaddmauv').show('slow').delay(8000).hide('slow');</script>";
        }
    }
}

function update_profil_pro($nom, $prenom, $email, $tel, $login, $motdepasse1, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    $reqp = $con->query("select * from hp_proprietaire where login_p= '" . $login . "' or password_p= '" . sha1($motdepasse1) . "'") or die(mysqli_error($con));
    $nbp = mysqli_num_rows($reqp);
    if (($nbp == 0)) {
        $req = $con->query("select * from hp_compte_personnel where login_pe= '" . $login . "' or password_pe= '" . sha1($motdepasse1) . "'") or die(mysqli_error($con));
        $nb = mysqli_num_rows($req);
        if (($nb == 0)) {
            $reqc = $con->query("select * from hp_compte_client where login_cl= '" . $login . "' or password_cl= '" . sha1($motdepasse1) . "'") or die(mysqli_error($con));
            $nbc = mysqli_num_rows($reqc);
            if (($nbc == 0)) {
                $reqem = $con->query("select * from hp_proprietaire where email_p= '" . $email . "' ") or die(mysqli_error($con));
                $nbem = mysqli_num_rows($reqem);
                if (($nbem == 0)) {
                    if ($motdepasse1 == NULL) {
                        $rsltp = $con->query("update hp_proprietaire set nom_p='" . $nom . "',prenom_p='" . $prenom . "',"
                                . "email_p='" . $email . "',tel_p='" . $tel . "', login_p='" . $login . "' where id_proprietaire='" . $_SESSION["id_proprietaire"] . "'") or die(mysqli_error($con));

                        $_SESSION["nom_proprietaire"] = $nom;
                        $_SESSION["prenom_proprietaire"] = $prenom;
                        $_SESSION["telephone_proprietaire"] = $tel;
                        $_SESSION["loginproprietaire"] = $login;
                        $_SESSION["email_proprietaire"] = $email;
                        echo "<script language='javascript'>$('div.alertmodifbon').show('slow').delay(8000).hide('slow');</script>";
                    } else {
                        $rsltp = $con->query("update hp_proprietaire set nom_p='" . $nom . "',prenom_p='" . $prenom . "',"
                                . "email_p='" . $email . "',tel_p='" . $tel . "', login_p='" . $login . "' ,"
                                . "password_p='" . sha1($motdepasse1) . "' where id_proprietaire='" . $_SESSION["id_proprietaire"] . "'") or die(mysqli_error($con));

                        $_SESSION["nom_proprietaire"] = $nom;
                        $_SESSION["prenom_proprietaire"] = $prenom;
                        $_SESSION["telephone_proprietaire"] = $tel;
                        $_SESSION["loginproprietaire"] = $login;
                        $_SESSION["motdepasseproprietaire"] = sha1($motdepasse1);
                        $_SESSION["email_proprietaire"] = $email;

                        echo "<script language='javascript'>$('div.alertmodifbon').show('slow').delay(8000).hide('slow');</script>";
                    }
                } else {
                    $rowem = mysqli_fetch_assoc($reqem);
                    if (($rowem["id_proprietaire"] == $_SESSION["id_proprietaire"])) {
                        if ($motdepasse1 == NULL) {
                            $rsltp = $con->query("update hp_proprietaire set nom_p='" . $nom . "',prenom_p='" . $prenom . "',"
                                    . "email_p='" . $email . "',tel_p='" . $tel . "', login_p='" . $login . "' where id_proprietaire='" . $_SESSION["id_proprietaire"] . "'") or die(mysqli_error($con));

                            $_SESSION["nom_proprietaire"] = $nom;
                            $_SESSION["prenom_proprietaire"] = $prenom;
                            $_SESSION["telephone_proprietaire"] = $tel;
                            $_SESSION["loginproprietaire"] = $login;
                            $_SESSION["email_proprietaire"] = $email;
                            echo "<script language='javascript'>$('div.alertmodifbon').show('slow').delay(8000).hide('slow');</script>";
                        } else {
                            $rsltp = $con->query("update hp_proprietaire set nom_p='" . $nom . "',prenom_p='" . $prenom . "',"
                                    . "email_p='" . $email . "',tel_p='" . $tel . "', login_p='" . $login . "' ,"
                                    . "password_p='" . sha1($motdepasse1) . "' where id_proprietaire='" . $_SESSION["id_proprietaire"] . "'") or die(mysqli_error($con));

                            $_SESSION["nom_proprietaire"] = $nom;
                            $_SESSION["prenom_proprietaire"] = $prenom;
                            $_SESSION["telephone_proprietaire"] = $tel;
                            $_SESSION["loginproprietaire"] = $login;
                            $_SESSION["motdepasseproprietaire"] = sha1($motdepasse1);
                            $_SESSION["email_proprietaire"] = $email;

                            echo "<script language='javascript'>$('div.alertmodifbon').show('slow').delay(8000).hide('slow');</script>";
                        }
                    } else {
                        echo "<script language='javascript'>$('div.alertaddmauv').show('slow').delay(8000).hide('slow');</script>";
                    }
                }
            } else {
                echo "<script language='javascript'>$('div.alertaddmauv').show('slow').delay(8000).hide('slow');</script>";
            }
        } else {
            echo "<script language='javascript'>$('div.alertaddmauv').show('slow').delay(8000).hide('slow');</script>";
        }
    } else {
        $recuser = mysqli_fetch_array($reqp);
        if (($recuser["id_proprietaire"] == $_SESSION["id_proprietaire"])) {
            if ($motdepasse1 == NULL) {
                $rsltp = $con->query("update hp_proprietaire set nom_p='" . $nom . "',prenom_p='" . $prenom . "',"
                        . "email_p='" . $email . "',tel_p='" . $tel . "', login_p='" . $login . "' where id_proprietaire='" . $_SESSION["id_proprietaire"] . "'") or die(mysqli_error($con));

                $_SESSION["nom_proprietaire"] = $nom;
                $_SESSION["prenom_proprietaire"] = $prenom;
                $_SESSION["telephone_proprietaire"] = $tel;
                $_SESSION["loginproprietaire"] = $login;
                $_SESSION["email_proprietaire"] = $email;
                echo "<script language='javascript'>$('div.alertmodifbon').show('slow').delay(8000).hide('slow');</script>";
            } else {
                $rsltp = $con->query("update hp_proprietaire set nom_p='" . $nom . "',prenom_p='" . $prenom . "',"
                        . "email_p='" . $email . "',tel_p='" . $tel . "', login_p='" . $login . "' ,"
                        . "password_p='" . sha1($motdepasse1) . "' where id_proprietaire='" . $_SESSION["id_proprietaire"] . "'") or die(mysqli_error($con));

                $_SESSION["nom_proprietaire"] = $nom;
                $_SESSION["prenom_proprietaire"] = $prenom;
                $_SESSION["telephone_proprietaire"] = $tel;
                $_SESSION["loginproprietaire"] = $login;
                $_SESSION["motdepasseproprietaire"] = sha1($motdepasse1);
                $_SESSION["email_proprietaire"] = $email;

                echo "<script language='javascript'>$('div.alertmodifbon').show('slow').delay(8000).hide('slow');</script>";
            }
        } else {
            echo "<script language='javascript'>$('div.alertaddmauv').show('slow').delay(8000).hide('slow');</script>";
        }
    }
}

function update_personnel_profil($reg, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    if (($reg != NULL) && isset($reg["1"])) {

        $nomp = addslashes($reg["1"]['nome']);
        $prenomp = addslashes($reg["1"]['prenome']);
        $telp = ($reg["1"]['tele']);
        $login = ($reg["1"]['logine']);

        $reqpe = $con->query("select * from hp_compte_personnel where idcomptepersonnel= '" . $_SESSION["idcomptepersonnel"] . "' ") or die(mysqli_error($con));
        $rowpe = mysqli_fetch_assoc($reqpe);
        $motdepasse1 = $rowpe["motdepassecomptepersonnel"];
        if ($reg["1"]['pass1e'] != NULL) {
            $motdepasse1 = sha1($reg["1"]['pass1e']);
        }
        $req = $con->query("select * from hp_proprietaire where loginproprietaire= '" . $login . "' and motdepasseproprietaire= '" . sha1($motdepasse1) . "'") or die(mysqli_error($con));
        $nb = mysqli_num_rows($req);
        if (($nb == 0)) {
            $reqp = $con->query("select * from hp_compte_personnel where logincomptepersonnel= '" . $login . "' and motdepassecomptepersonnel= '" . sha1($motdepasse1) . "'") or die(mysqli_error($con));
            $nbp = mysqli_num_rows($reqp);
            if (($nbp == 0)) {
                $con->query("update hp_personnel set nompersonnel='" . $nomp . "', prenompersonnel='" . $prenomp . "', telephonepersonnel='" . $reg["1"]['tele'] . "' "
                                . "where idpersonnel='" . $rowpe["idpersonnel"] . "'") or die(mysqli_error($con));
                $con->query("update hp_compte_personnel set logincomptepersonnel='" . $reg["1"]['logine'] . "', motdepassecomptepersonnel='" . $motdepasse1 . "' "
                                . " where idcomptepersonnel='" . $reg["1"]['idcomptepersonnel'] . "'") or die(mysqli_error($con));
                $_SESSION["nompersonnel"] = $nomp;
                $_SESSION["prenompersonnel"] = $prenomp;
                $_SESSION["telephonepersonnel"] = $reg["1"]['tele'];
                $_SESSION["logincomptepersonnel"] = $reg["1"]['logine'];
                $_SESSION["motdepassecomptepersonnel"] = $motdepasse1;

                unset($_SESSION['formpersonnelep']);
                echo "<script language='javascript'>$('div.addok').show('slow').delay(8000).hide('slow');</script>";
                $pagp = 'hopitalpages/hopitalpersonnel/info_user';
                die('<meta http-equiv="refresh" content="3 ; URL=' . $url . '?page=' . base64_encode($pagp) . '">');
            } else {
                $rowv = mysqli_fetch_assoc($reqp);
                if ($rowv["idcomptepersonnel"] == $reg["1"]["idcomptepersonnel"]) {
                    $con->query("update hp_personnel set nompersonnel='" . $nomp . "', prenompersonnel='" . $prenomp . "', telephonepersonnel='" . $reg["1"]['tele'] . "' "
                                    . "where idpersonnel='" . $rowpe["idpersonnel"] . "'") or die(mysqli_error($con));
                    $con->query("update hp_compte_personnel set logincomptepersonnel='" . $reg["1"]['logine'] . "', motdepassecomptepersonnel='" . $motdepasse1 . "' "
                                    . " where idcomptepersonnel='" . $reg["1"]['idcomptepersonnel'] . "'") or die(mysqli_error($con));
                    $_SESSION["nompersonnel"] = $nomp;
                    $_SESSION["prenompersonnel"] = $prenomp;
                    $_SESSION["telephonepersonnel"] = $reg["1"]['tele'];
                    $_SESSION["logincomptepersonnel"] = $reg["1"]['logine'];
                    $_SESSION["motdepassecomptepersonnel"] = $motdepasse1;

                    unset($_SESSION['formpersonnelep']);
                    echo "<script language='javascript'>$('div.addok').show('slow').delay(8000).hide('slow');</script>";
                    $pagp = 'hopitalpages/hopitalpersonnel/info_user';

                    die('<meta http-equiv="refresh" content="3 ; URL=' . $url . '?page= $pagp ">');
                } else {
                    echo "<script language='javascript'>$('div.addko').show('slow').delay(8000).hide('slow');</script>";
                    $pagp = 'hopitalpages/hopitalpersonnel/hopitalediterprofil/edit_personnel';
                    die('<meta http-equiv="refresh" content="3 ; URL=' . $url . '?page=' . base64_encode($pagp) . '&idcomptepersonnel=' . $reg["1"]["idcomptepersonnel"] . '">');
                }
            }
        }
    }
}

//Gestion des payes
function lister_paye($con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    $rsltens = $con->query("select * from recu as r left join personnel as e on r.idpersonnel=e.idpersonnel order by r.daterecu desc") or die(mysqli_error($con));
    while ($recens = mysqli_fetch_assoc($rsltens)) {
        ?>

        <tr >
            <td></td>
            <td>
                <?php print nl2br(htmlspecialchars($recens["nom"])) ?> 
                <?php print nl2br(htmlspecialchars($recens["prenom"])) ?> - 
                <?php print nl2br(htmlspecialchars($recens["tel"])) ?>
            </td>
            <td><?php print nl2br(htmlspecialchars($recens["datejour"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recens["modepaiement"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recens["salairedebase"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recens["remunerationbrute"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recens["totalretenue"])) ?></td>
            <td><?php print $recens["remunerationbrute"] - ($recens["totalretenue"]) ?></td>
            <td>
        <!--                    <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpersonnel/hopitalpaye/edit_paye') ?>&recu=<?php echo $recens["idrecu"] ?>">
                        <span title="Modifier ce recu" alt="payer"><i class="glyphicon glyphicon-edit"></i></span>
                    </a>&nbsp;&nbsp;-->
                <a href="hopitalpages/hopitalpersonnel/hopitalpaye/print_recu_pdf.php?recu=<?php echo $recens["idrecu"] ?>" target="blanck">
                    <span title="Imprimer ce recu" alt="lister"><i class="glyphicon glyphicon-print"></i></span>
                </a> 
                &nbsp;&nbsp;
                <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpersonnel/hopitalpaye/detail_paye') ?>&recu=<?php echo $recens["idrecu"] ?>">
                    <span title="D&eacute;tail de ce recu" alt="payer"><i class="glyphicon glyphicon-list-alt"></i></span>
                </a>
            </td>
        </tr>

        <?php
    }
}

function lister_personnel_paye($con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);

    $rsltuser = $con->query("select * from hp_personnel as pe left join hp_affectation as af on "
            . "pe.idpersonnel=af.idpersonnel left join hp_service as s on af.idservice=s.idservice "
            . "where af.etataffectation=true ") or die(mysqli_error($con));
    while ($recuser = mysqli_fetch_assoc($rsltuser)) {
        ?>
        <tr >
            <td><?php print nl2br(htmlspecialchars($recuser["codepersonnel"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["nompersonnel"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["prenompersonnel"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["telephonepersonnel"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["nomservice"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recuser["rolepersonnel"])) ?></td>
            <td><?php // print nl2br(htmlspecialchars($recuser["salaireaffectation"])) ?> / <?php // print nl2br(htmlspecialchars($recuser["typepaiement"])) ?></td>
            <td>
                <?php
                if (isset($_SESSION["loginproprietaire"])) {
                    ?>
                    <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpersonnel/hopitalpaye/hopitalajouter/insert_paye') ?>&idpersonnel=<?php echo $recuser["idpersonnel"] ?>">
                        <span title="Payer ce Personnel" alt="add"><i class="glyphicon glyphicon-credit-card"></i></span>
                    </a>&nbsp;&nbsp;
                    <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpersonnel/hopitalpaye/lister_paye_personnel') ?>&idpersonnel=<?php echo $recuser["idpersonnel"] ?>">
                        <span title="Gérer les paies de ce Personnel" alt="add"><i class="glyphicon glyphicon-list-alt"></i></span>
                    </a>
                    <?php
                } else {
                    ?>
                    <?php
                }
                ?>
            </td>
        </tr>

        <?php
    }
}

function insert_paye($reg, $con) {

    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);

    if (($reg != NULL) && isset($reg["1"])) {

        $ide = $reg["1"]["idpersonnel"];
        $datejour = $reg["1"]["datejoureffectue"];
        $emploi = $reg["1"]["emploi"];
        $salairebase = $reg["1"]["salairebase"];
        $heure15 = $reg["1"]["heure15"];
        $heure20 = $reg["1"]["heure20"];
        $heure30 = $reg["1"]["heure30"];
        $heure40 = $reg["1"]["heure40"];
        $heure50 = $reg["1"]["heure50"];
        $anciennep = $reg["1"]["anciennep"];
        $rendementp = $reg["1"]["rendementp"];
        $logementp = $reg["1"]["logementp"];
        $caissei = $reg["1"]["caissei"];
        $deplacementi = $reg["1"]["deplacementi"];
        $representationi = $reg["1"]["representationi"];
        $remunerationbrute = $reg["1"]["remunerationbrute"];
        $retenuefiscales = $reg["1"]["retenuefiscales"];
        $irpp = $reg["1"]["irpp"];
        $cac = $reg["1"]["cac"];
        $taxec = $reg["1"]["taxec"];
        $redevanceaudio = $reg["1"]["redevanceaudio"];
        $creditf = $reg["1"]["creditf"];
        $fne = $reg["1"]["fne"];
        $retenuesociales = $reg["1"]["retenuesociales"];
        $cnps = $reg["1"]["cnps"];
        $autresretenue = $reg["1"]["autresretenue"];
        $acomptes = $reg["1"]["acomptes"];
        $avancee = $reg["1"]["avancee"];
        $saisiearret = $reg["1"]["saisiearret"];
        $cotisations = $reg["1"]["cotisations"];
        $autre = $reg["1"]["autre"];
        $netapayer = $reg["1"]["netapayer"];
        $totalretenue = $reg["1"]["totalretenue"];

        $reqen = $con->query("select * from hp_personnel as pe left join hp_affectation as af on "
                . "pe.idpersonnel=af.idpersonnel left join hp_service as s on af.idservice=s.idservice "
                . "where af.etataffectation=true and pe.idpersonnel='" . $ide . "'") or die(mysqli_error($con));
        $rowen = mysqli_fetch_assoc($reqen);
//        $_SESSION["personnelmauv"] = $rowen["login"];

        $but="";
        $nbh=0;
        if ($reg["1"]['typepaiement'] == "Heure") {
            $nbh=$nbh+$reg["1"]["qteeffectue"];
            for ($i = 0; $i < $reg["1"]["nbeffectue"]; $i++) {
                $nbh=$nbh+$reg["1"]["qteeffectue" . $i];
            }
        }
        $but=$nbh." heures";
        if ($reg["1"]['typepaiement'] == "Jour") {
            $but=$but." - ".$reg["1"]["libjeffectue"];
            for ($i = 0; $i < $reg["1"]["nbjeffectue"]; $i++) {
                $but=$but." - ".$reg["1"]["libjeffectue" . $i];
            }
        }
        if ($reg["1"]['typepaiement'] == "Mois") {
            $but="A partir du mois de ".$reg["1"]["libjeffectue"]." ".$reg["1"]["nbmeffectue"]." Mois";
        }
        $an = date('Y');
        $sand = substr($an, 2);
        $moi = date('m');
        $jou = date('d');
        $req = $con->query("select * from hp_recu_personnel as e where DAY(e.daterecupersonnel)='" . $jou . "' and "
                . "MONTH(e.daterecupersonnel)='" . $moi . "' and YEAR(e.daterecupersonnel)='" . $an . "'") or die(mysqli_error($con));
        $i = mysqli_num_rows($req);
        $norecu = "BP" . $jou . $moi . $sand . sprintf("%03d", ($i + 1));
        $con->query("insert into hp_recu_personnel(idaffectation, norecupersonnel, butrecupersonnel, "
                        . "datejour, salairedebase, remunerationbrute, heuresup15, heuresup20, "
                        . "heuresup30, heuresup40, heuresup50, ancienneteprime, rendementprime, logementprime, "
                        . "caisseindemnite, deplacementindemnite, representationindemnite, irpp, cac, taxecommunale, "
                        . "redevanceaudiovisuel, creditfoncier, fne, cnps, acomptesalaire, avanceexceptionnelle, "
                        . "saisiearret, cotisationsyndicale, autre, totalretenue, netapayer, daterecupersonnel) "
                        . "values('" . $rowen["idaffectation"] . "', '" . $norecu . "', '" . $but . "', "
                        . "'" . $reg["1"]["datejoureffectue"] . "', '" . $reg["1"]["salairebase"] . "', "
                        . "'" . $reg["1"]["remunerationbrute"] . "', '" . $reg["1"]["heure15"] . "', '" . $reg["1"]["heure20"] . "', '" . $reg["1"]["heure30"] . "', "
                        . "'" . $reg["1"]["heure40"] . "', '" . $reg["1"]["heure50"] . "', '" . $reg["1"]["anciennep"] . "', '" . $reg["1"]["rendementp"] . "', "
                        . "'" . $reg["1"]["logementp"] . "', '" . $reg["1"]["caissei"] . "', '" . $reg["1"]["deplacementi"] . "', '" . $reg["1"]["representationi"] . "', "
                        . "'" . $reg["1"]["irpp"] . "', '" . $reg["1"]["cac"] . "', '" . $reg["1"]["taxec"] . "', '" . $reg["1"]["redevanceaudio"] . "', '" . $reg["1"]["creditf"] . "', "
                        . "'" . $reg["1"]["fne"] . "', '" . $reg["1"]["cnps"] . "','" . $reg["1"]["acomptes"] . "', '" . $reg["1"]["avancee"] . "', "
                        . "'" . $reg["1"]["saisiearret"] . "', '" . $reg["1"]["cotisations"] . "', '" . $reg["1"]["autre"] . "', '" . $reg["1"]["totalretenue"] . "', '" . $reg["1"]["netapayer"] . "', "
                        . "NOW())") or die(mysqli_error($con));
        $reqrecu = $con->query("select * from hp_recu_personnel where idaffectation='" . $rowen["idaffectation"] . "' and norecupersonnel='" . $norecu . "'") or die(mysqli_error($con));
        $rowrecu = mysqli_fetch_assoc($reqrecu);
        if ($reg["1"]['typepaiement'] == "Heure") {
            if (($reg["1"]["libeffectue"] != '')) {
                $reqtapq = $con->query("select * from hp_ligne_pointage_recu where idrecupersonnel='" . $rowrecu["idrecupersonnel"] . "' "
                        . "and idpointage='" . $reg["1"]["libeffectue"] . "' ") or die(mysqli_error($con));
                $nbtapq = mysqli_num_rows($reqtapq);
                if ($nbtapq == 0) {
                    $con->query("insert into hp_ligne_pointage_recu(idpointage, idrecupersonnel, nombrepointagerecu, "
                                    . "prixpointagerecu, nombrepointagerecupayer) values('" . $reg["1"]["libeffectue"] . "', "
                                    . "'" . $rowrecu["idrecupersonnel"] . "', '" . $reg["1"]["qteeffectue"] . "', "
                                    . "'" . $reg["1"]['prixueffectue'] . "', '" . $reg["1"]["qteeffectue"] . "')") or die(mysqli_error($con));

                    $con->query("update hp_pointage set payepointage=1 where idpointage='" . $reg["1"]["libeffectue"] . "'") or die(mysqli_error($con));
                }
            }
            for ($i = 0; $i < $reg["1"]["nbeffectue"]; $i++) {
                if (($reg["1"]["libeffectue" . $i] != '')) {
                    $reqtapq = $con->query("select * from hp_ligne_pointage_recu where idrecupersonnel='" . $rowrecu["idrecupersonnel"] . "' "
                            . "and ideffectue='" . $reg["1"]["libeffectue" . $i] . "' ") or die(mysqli_error($con));
                    $nbtapq = mysqli_num_rows($reqtapq);
                    if ($nbtapq == 0) {
                        $con->query("insert into hp_ligne_pointage_recu(idpointage, idrecupersonnel, nombrepointagerecu, "
                                        . "prixpointagerecu, nombrepointagerecupayer) values('" . $reg["1"]["libeffectue" . $i] . "', "
                                        . "'" . $rowrecu["idrecupersonnel"] . "', '" . $reg["1"]["qteeffectue" . $i] . "', "
                                        . "'" . $reg["1"]['prixueffectue' . $i] . "', '" . $reg["1"]["qteeffectue" . $i] . "')") or die(mysqli_error($con));
                        $con->query("update hp_pointage set payepointage=1 where idpointage='" . $reg["1"]["libeffectue" . $i] . "'") or die(mysqli_error($con));
                    }
                }
            }
        }

        if ($reg["1"]['typepaiement'] == "Jour") {
            if (($reg["1"]["libjeffectue"] != '')) {
                $reqtapqp = $con->query("select * from hp_pointage where datejourpointage='" . $reg["1"]["libjeffectue"] . "' ") or die(mysqli_error($con));
                while ($rowp = mysqli_fetch_assoc($reqtapqp)) {
                    $reqtapq = $con->query("select * from hp_ligne_pointage_recu where idrecupersonnel='" . $rowrecu["idrecupersonnel"] . "' "
                            . "and idpointage='" . $rowp["idpointage"] . "' ") or die(mysqli_error($con));
                    $nbtapq = mysqli_num_rows($reqtapq);
                    if ($nbtapq == 0) {
                        $con->query("insert into hp_ligne_pointage_recu(idpointage, idrecupersonnel, nombrepointagerecu, "
                                        . "prixpointagerecu, nombrepointagerecupayer) values('" . $rowp["idpointage"] . "', "
                                        . "'" . $rowrecu["idrecupersonnel"] . "', '" . $rowp["nombreheuredecimalepointage"] . "', "
                                        . "'" . $reg["1"]['prixjeffectue'] . "', '" . $rowp["nombreheuredecimalepointage"] . "')") or die(mysqli_error($con));

                        $con->query("update hp_pointage set payepointage=1 where idpointage='" . $rowp["idpointage"] . "'") or die(mysqli_error($con));
                    }
                }
            }
            for ($i = 0; $i < $reg["1"]["nbjeffectue"]; $i++) {
                if (($reg["1"]["libjeffectue" . $i] != '')) {
                    $reqtapqp = $con->query("select * from hp_pointage where datejourpointage='" . $reg["1"]["libjeffectue" . $i] . "' ") or die(mysqli_error($con));
                while ($rowp = mysqli_fetch_assoc($reqtapqp)) {
                    $reqtapq = $con->query("select * from hp_ligne_pointage_recu where idrecupersonnel='" . $rowrecu["idrecupersonnel"] . "' "
                            . "and idpointage='" . $rowp["idpointage"] . "' ") or die(mysqli_error($con));
                    $nbtapq = mysqli_num_rows($reqtapq);
                    if ($nbtapq == 0) {
                        $con->query("insert into hp_ligne_pointage_recu(idpointage, idrecupersonnel, nombrepointagerecu, "
                                        . "prixpointagerecu, nombrepointagerecupayer) values('" . $rowp["idpointage"] . "', "
                                        . "'" . $rowrecu["idrecupersonnel"] . "', '" . $rowp["nombreheuredecimalepointage"] . "', "
                                        . "'" . $reg["1"]["prixjeffectue" . $i] . "', '" . $rowp["nombreheuredecimalepointage"] . "')") or die(mysqli_error($con));

                        $con->query("update hp_pointage set payepointage=1 where idpointage='" . $rowp["idpointage"] . "'") or die(mysqli_error($con));
                    }
                }
                }
            }
        }
        
//        if ($reg["1"]['typepaiement'] == "Mois") {
//            if (($reg["1"]["libmeffectue"] != '')) {
//                $reqtapqp = $con->query("select * from hp_pointage where datejourpointage='" . $reg["1"]["libmeffectue"] . "' ") or die(mysqli_error($con));
//                while ($rowp = mysqli_fetch_assoc($reqtapqp)) {
//                    $reqtapq = $con->query("select * from hp_ligne_pointage_recu where idrecupersonnel='" . $rowrecu["idrecupersonnel"] . "' "
//                            . "and idpointage='" . $rowp["idpointage"] . "' ") or die(mysqli_error($con));
//                    $nbtapq = mysqli_num_rows($reqtapq);
//                    if ($nbtapq == 0) {
//                        $con->query("insert into hp_ligne_pointage_recu(idpointage, idrecupersonnel, nombrepointagerecu, "
//                                        . "prixpointagerecu, nombrepointagerecupayer) values('" . $rowp["idpointage"] . "', "
//                                        . "'" . $rowrecu["idrecupersonnel"] . "', '" . $rowp["nombreheuredecimalepointage"] . "', "
//                                        . "'" . $reg["1"]['prixumeffectue'] . "', '" . $rowp["nombreheuredecimalepointage"] . "')") or die(mysqli_error($con));
//
//                        $con->query("update hp_pointage set payepointage=1 where idpointage='" . $rowp["idpointage"] . "'") or die(mysqli_error($con));
//                    }
//                }
//            }
//        }
        $op = "Paye";
        $ob = "Personnel";
        $con->query("insert into hp_trace(idrecupersonnel, operation, objet, datetrace) values('" . $rowrecu["idrecupersonnel"] . "', "
                        . "'" . $op . "', '" . $ob . "',NOW())") or die(mysqli_error($con));

        unset($_SESSION['formpaye']);
        echo "<script language='javascript'>$('div.addok').show('slow').delay(8000).hide('slow');</script>";
        ?>
        <a href="hopitalpages/hopitalpersonnel/hopitalpaye/print_recu_pdf.php?recu=<?php echo $rowrecu["idrecupersonnel"] ?>" class="btn btn-lg btn-success" target="_blank">
            <span title="Imprimer la facture de ce personnel" alt="imprimer"><i class="glyphicon glyphicon-file-pdf-o"></i> Impriner la facture</span>
        </a>
        <?php
    }
}

function lister_detail_paye($recu, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    $date = date('Y-m-d');
    $reqa = $con->query("select * from smsannee where libellean<='" . $date . "' and libellean2>='" . $date . "'") or die(mysqli_error($con));
    $rowa = mysqli_fetch_assoc($reqa);
    if ($rowa != NULL) {
        $rsltens = $con->query('select * from ligneheurerecu as lhr left join effectue as c on lhr.ideffectue=c.ideffectue '
                . 'left join enseignement as eg on c.idenseignement=eg.idenseignement left join matiereclasse as mc on '
                . 'eg.idmatiereclasse=mc.idmatiereclasse where lhr.idrecu=' . $recu . '') or die(mysqli_error($con));
        while ($recens = mysqli_fetch_assoc($rsltens)) {
            ?>

            <tr >
                <td><?php print nl2br(htmlspecialchars($recens["datee"])) ?></td>
                <td><?php print nl2br(htmlspecialchars($recens["heuredebutce"])) ?></td>
                <td><?php print nl2br(htmlspecialchars($recens["heurefince"])) ?></td>
                <td><?php print nl2br(htmlspecialchars($recens["heuree"])) ?></td>
                <td>
                    <?php
                    if (!$recens["payerce"]) {
                        if ($recens["etatce"]) {
                            ?>
                            <a data-toggle="tooltip" href='<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitaleffectue/enseignement_ajax'); ?>&ideffectue=<?php echo $recens["ideffectue"]; ?>&desactiver=desactiver' onclick="return(confirm('Etes-vous s&ucirc;r de vouloir Annuler la validation de ces heures ?'));" title="Annuler la validation de ces heures "  >
                                <span alt="desactiver" class="label-success label label-default">Valid&eacute;</span>
                            </a>
                            <?php
                        } else {
                            ?>
                            <a data-toggle="tooltip" href='<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitaleffectue/enseignement_ajax'); ?>&ideffectue=<?php echo $recens["ideffectue"]; ?>&activer=activer' onclick="return(confirm('Etes-vous s&ucirc;r de vouloir Valider ces heures ?'));" title="Valider ces heures "  >
                                <span alt="activer" class="label-warning label label-default">Non valid&eacute;</span>
                            </a>
                            <?php
                        }
                    } else {
                        if ($recens["etatce"]) {
                            ?>
                            <span alt="desactiver" class="label-success label label-default">Valid&eacute;</span>
                            <?php
                        } else {
                            ?>
                            <span alt="activer" class="label-warning label label-default">Non valid&eacute;</span>
                            <?php
                        }
                    }
                    ?>
                </td>
                <td>
                    <?php if ($recens["payerce"]) { ?>
                        <span alt="Pay&eacute;" class="label-success label label-default">Pay&eacute;</span>
                        <?php
                    } else {
                        ?>
                        <span alt="impay&eacute;" class="label-warning label label-default">Impay&eacute;</span>
                        <?php
                    }
                    ?>
                </td>
                    <!--<td><?php // print nl2br(htmlspecialchars($recens["nbheurece"]))      ?></td>-->

            </tr>

            <?php
        }
    } else {
        echo "<script language='javascript'>$('div.alertannee').show('slow').delay(8000).hide('slow');</script>";
    }
}

function lister_paye_personnel($id, $con) {
    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    $rsltens = $con->query("select * from recu where idpersonnel='" . $id . "' order by daterecu desc") or die(mysqli_error($con));
    while ($recens = mysqli_fetch_assoc($rsltens)) {
        ?>

        <tr >
            <td><?php print nl2br(htmlspecialchars($recens["datedebutp"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recens["datefinp"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recens["remunerationbrute"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recens["irpp"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recens["taxecommunale"])) ?></td>
            <td><?php print $recens["irpp"] + $recens["taxecommunale"] ?></td>
            <td><?php print nl2br(htmlspecialchars($recens["caisseretraite"])) ?></td>
            <td><?php print nl2br(htmlspecialchars($recens["caisseretraite"])) ?></td>
            <td><?php print $recens["remunerationbrute"] - ($recens["caisseretraite"] + ($recens["irpp"] + $recens["taxecommunale"])) ?></td>
            <td>
        <!--                    <a href="<?php echo $url; ?>?page=<?php echo base64_encode('hopitalpages/hopitalpersonnel/hopitalpaye/edit_paye') ?>&recu=<?php echo $recens["idrecu"] ?>">
                        <span title="Modifier ce recu" alt="payer"><i class="glyphicon glyphicon-edit"></i></span>
                    </a>&nbsp;&nbsp;-->
                <a href="hopitalpages/hopitalpersonnel/hopitalpaye/print_recu_pdf.php?recu=<?php echo $recens["idrecu"] ?>" target="blanck">
                    <span title="Imprimer ce recu" alt="lister"><i class="glyphicon glyphicon-print"></i></span>
                </a>
            </td>
        </tr>

        <?php
    }
}

function update_paye_personnel($id, $datedebutp, $datefinp, $remunerationb, $irpp, $taxec, $caisser, $journee, $heure, $heure15, $heure20, $heure30, $heure40, $heure50, $ancienne, $nouvelle, $salairet, $cac, $retenuecrtv, $creditf, $acomptes, $avancee, $retenuces, $saisie, $cotisations, $con) {

    $path = $_SERVER['PHP_SELF'];
    $url = basename($path);
    $date = date('Y-m-d');
    $reqa = $con->query("select * from smsannee where libellean<='" . $date . "' and libellean2>='" . $date . "'") or die(mysqli_error($con));
    $rowa = mysqli_fetch_assoc($reqa);
    if ($rowa != NULL) {
        $rsltind = $con->query("update recu set datedebutp='" . $datedebutp . "', datefinp='" . $datefinp . "', salairetaxable='" . $salairet . "', "
                . "remunerationbrute='" . $remunerationb . "', irpp='" . $irpp . "', cac='" . $cac . "', taxecommunale='" . $taxec . "', retenuecrtv='" . $retenuecrtv . "', "
                . "creditfoncier='" . $creditf . "', caisseretraite='" . $caisser . "', acomptesalaire='" . $acomptes . "', avanceexceptionnelle='" . $avancee . "', "
                . "retenuecession='" . $retenuces . "', saisie='" . $saisie . "', cotisationsyndicale='" . $cotisations . "', journee='" . $journee . "', "
                . "heure='" . $heure . "', heuresup15='" . $heure15 . "', heuresup20='" . $heure20 . "', heuresup30='" . $heure30 . "', heuresup40='" . $heure40 . "', "
                . "heuresup50='" . $heure50 . "', ancienne='" . $ancienne . "', nouvelle='" . $nouvelle . "' where idrecu='" . $id . "'") or die(mysqli_error($con));

        $op = "Update Paye";
        $ob = "Enseignant";
        $rsltt = $con->query("insert into trace(iduser,operation,objet,date) 
				  values('" . $_SESSION["iduser"] . "','" . $op . "','" . $ob . "',NOW())")
                or die(mysqli_error($con));

        echo "<script language='javascript'>$('div.alertmodifbon').show('slow').delay(8000).hide('slow');</script>";
    } else {

        echo "<script language='javascript'>$('div.alertannee').show('slow').delay(8000).hide('slow');</script>";
    }
}
