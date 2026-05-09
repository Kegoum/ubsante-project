
<?php
session_start();
ob_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>HOPITAL</title>
        <link rel="shortcut icon" href="hopitalupload/logo/logo.jpeg"> 
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link href="hopitalcss/login.css" rel="stylesheet" type="text/css" />
        <link href="hopitalcss/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <style>
            body{
                font-family: Book Antiqua !important;
            }
        </style>
    </head>
    <?php
    include('hopitalconnexion/connexion.php');
    //include('hopitalpages/hopitalfunction.php');

    if (isset($_GET["locks"])) {
        //session_unregister("login");
        session_unset();
        session_destroy();
        header("Location:./");
        exit();
    }
    ?>

    <body>
        <?php
//        print ceil(933.3333333);
        if (isset($_POST['consot'])) {
            $log = addslashes($_POST["loginsot"]);
            $pwd = sha1(addslashes($_POST["passwordsot"]));
            $repro = $con->query("select * from hp_proprietaire as p left join hp_departement as d on "
                    . "p.iddepartement=d.iddepartement left join hp_region as r on d.idregion=r.idregion "
                    . "where loginproprietaire='" . $log . "' and motdepasseproprietaire='" . $pwd . "'") or die(mysqli_error($con));

            $nbpro = mysqli_num_rows($repro);
            if ($nbpro == 0) {
                $reqper = "select * from hp_compte_personnel as cp left join hp_personnel as p on cp.idpersonnel=p.idpersonnel "
                        . "where cp.logincomptepersonnel='" . $log . "' and cp.motdepassecomptepersonnel='" . $pwd . "'";
                $reper = $con->query($reqper) or die(mysqli_error($con));
                $nbper = mysqli_num_rows($reper);
                if ($nbper == 0) {
                    echo"<script language='javascript'>alert('Identifiants incorrects')</script>";
                } else {
                    $enreg = mysqli_fetch_assoc($reper);
                    $reqperserv = "select * from hp_affectation as a left join hp_service as s on "
                            . "a.idservice=s.idservice where a.idpersonnel='" . $enreg["idpersonnel"] . "' and "
                            . "a.etataffectation=true";
                    $reperserv = $con->query($reqperserv) or die(mysqli_error($con));
                    $enregps = mysqli_fetch_assoc($reperserv);

                    $reqperpro = "select * from hp_proprietaire as p left join hp_departement as d on "
                            . "p.iddepartement=d.iddepartement left join hp_region as r on d.idregion=r.idregion "
                            . "where etatproprietaire=true limit 0,1";
                    $reperpro = $con->query($reqperpro) or die(mysqli_error($con));
                    $enregpp = mysqli_fetch_assoc($reperpro);
                    $_SESSION["nompersonnel"] = $enreg["nompersonnel"];
                    $_SESSION["idpersonnel"] = $enreg["idpersonnel"];
                    $_SESSION["idcomptepersonnel"] = $enreg["idcomptepersonnel"];
                    $_SESSION["prenompersonnel"] = $enreg["prenompersonnel"];
                    $_SESSION["logincomptepersonnel"] = $enreg["logincomptepersonnel"];
                    $_SESSION["motdepassecomptepersonnel"] = $enreg["motdepassecomptepersonnel"];
                    $_SESSION["rolepersonnel"] = $enreg["rolepersonnel"];
                    $_SESSION["rolecomptepersonnel"] = $enreg["rolecomptepersonnel"];
                    $_SESSION["telephonepersonnel"] = $enreg["telephonepersonnel"];
//                    $_SESSION["emailpersonnel"] = $enreg["emailpersonnel"];
                    $_SESSION["etatpersonnel"] = $enreg["etatpersonnel"];
                    $_SESSION["etatcomptepersonnel"] = $enreg["etatcomptepersonnel"];
//                    $_SESSION["achivepersonnel"] = $enreg["archivepersonnel"];

                    $_SESSION["codeservice"] = $enregps["codeservice"];
                    $_SESSION["nomservice"] = $enregps["nomservice"];
                    $_SESSION["telephoneservice"] = $enregps["telephoneservice"];
                    $_SESSION["idservice"] = $enregps["idservice"];
                    $_SESSION["domaineservice"] = $enregps["domaineservice"];
                    $_SESSION["localservice"] = $enregps["localservice"];

                    $_SESSION["idproprietaire"] = $enregpp["idproprietaire"];
                    $_SESSION["nomproprietaire"] = $enregpp["nomproprietaire"];
                    $_SESSION["telephoneproprietaire"] = $enregpp["telephoneproprietaire"];
                    $_SESSION["hopitalproprietaire"] = $enregpp["hopitalproprietaire"];
                    $_SESSION["logoproprietaire"] = $enregpp["logoproprietaire"];
                    $_SESSION["datecreationproprietaire"] = $enregpp["datecreationproprietaire"];
                    $_SESSION["typeproprietaire"] = $enregpp["typeproprietaire"];
                    $_SESSION["bpproprietaire"] = $enregpp["bpproprietaire"];
                    $_SESSION["idregion"] = $enregpp["idregion"];
                    $_SESSION["coderegion"] = $enregpp["coderegion"];
                    $_SESSION["libelleregion"] = $enregpp["libelleregion"];
                    $_SESSION["cheflieuregion"] = $enregpp["cheflieuregion"];
                    $_SESSION["iddepartement"] = $enregpp["iddepartement"];
                    $_SESSION["libelledepartement"] = $enregpp["libelledepartement"];
                    $_SESSION["cheflieudepartement"] = $enregpp["cheflieudepartement"];
                    if ($enreg["rolepersonnel"] == "Caisse") {
                        $reqresto = $con->query("select * from hp_personnel_caisse as r left join hp_caisse as u on r.idcaisse=u.idcaisse "
                                    . "where r.idpersonnel='" . $enreg["idpersonnel"] . "'") or die(mysqli_error($con));
                        $rowresto = mysqli_fetch_assoc($reqresto);
                        $_SESSION["idcaisse"] = $rowresto["idcaisse"];
                        $_SESSION["nomcaisse"] = $rowresto["nomcaisse"];
                    }
                    if ($enreg["rolepersonnel"] == "Magasinier") {
                        $reqresto = $con->query("select * from hp_personnel_magasin as r left join hp_magasin as u on r.idmagasin=u.idmagasin "
                                    . "where r.idpersonnel='" . $enreg["idpersonnel"] . "'") or die(mysqli_error($con));
                        $rowresto = mysqli_fetch_assoc($reqresto);
                        $_SESSION["idmagasin"] = $rowresto["idmagasin"];
                        $_SESSION["nommagasin"] = $rowresto["nommagasin"];
                    }
                    if ($enreg["rolepersonnel"] == "Pharmacien") {
                        $reqresto = $con->query("select * from hp_personnel_pharmacie as r left join hp_pharmacie as u on r.idpharmacie=u.idpharmacie "
                                    . "where r.idpersonnel='" . $enreg["idpersonnel"] . "'") or die(mysqli_error($con));
                        $rowresto = mysqli_fetch_assoc($reqresto);
                        $_SESSION["idpharmacie"] = $rowresto["idpharmacie"];
                        $_SESSION["nompharmacie"] = $rowresto["nompharmacie"];
                    }

                    if (isset($_SESSION["logincomptepersonnel"]) && (isset($_SESSION["motdepassecomptepersonnel"])) && ($_SESSION["rolepersonnel"] == "Directeur de Centre") && ($_SESSION["etatcomptepersonnel"])) {
                        header("Location:indexdg.php");
                    } else if (isset($_SESSION["logincomptepersonnel"]) && (isset($_SESSION["motdepassecomptepersonnel"])) && ($_SESSION["etatcomptepersonnel"])) {
                        header("Location:indexpersonnel.php");
                    } else {
                        echo"<script language='javascript'>alert('page introuvable')</script>";
//                echo"<script language='javascript'>$('div.alertpageint').show('slow').delay(4000).hide('slow');</script>";
                    }
                }
            } else {

                $enregpp = mysqli_fetch_assoc($repro);
                $_SESSION["idproprietaire"] = $enregpp["idproprietaire"];
                $_SESSION["nomproprietaire"] = $enregpp["nomproprietaire"];
                $_SESSION["telephoneproprietaire"] = $enregpp["telephoneproprietaire"];
                $_SESSION["hopitalproprietaire"] = $enregpp["hopitalproprietaire"];
                $_SESSION["logoproprietaire"] = $enregpp["logoproprietaire"];
                $_SESSION["datecreationproprietaire"] = $enregpp["datecreationproprietaire"];
                $_SESSION["typeproprietaire"] = $enregpp["typeproprietaire"];
                $_SESSION["bpproprietaire"] = $enregpp["bpproprietaire"];
                $_SESSION["idregion"] = $enregpp["idregion"];
                $_SESSION["coderegion"] = $enregpp["coderegion"];
                $_SESSION["libelleregion"] = $enregpp["libelleregion"];
                $_SESSION["cheflieuregion"] = $enregpp["cheflieuregion"];
                $_SESSION["iddepartement"] = $enregpp["iddepartement"];
                $_SESSION["libelledepartement"] = $enregpp["libelledepartement"];
                $_SESSION["cheflieudepartement"] = $enregpp["cheflieudepartement"];
                $_SESSION["loginproprietaire"] = $enregpp["loginproprietaire"];
                $_SESSION["motdepasseproprietaire"] = $enregpp["motdepasseproprietaire"];

                if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
                    header("Location:indexproprietaire.php");
                } else {
                    echo"<script language='javascript'>alert('page introuvable')</script>";
//            echo"<script language='javascript'>$('div.alertpageint').show('slow').delay(4000).hide('slow');</script>";
                }
            }
        }

        if (isset($_SESSION["loginproprietaire"]) && (isset($_SESSION["motdepasseproprietaire"]))) {
            header("Location:indexproprietaire.php");
        } else if (isset($_SESSION["logincomptepersonnel"]) && (isset($_SESSION["motdepassecomptepersonnel"])) && ($_SESSION["rolepersonnel"] == "Directeur de Centre") && ($_SESSION["etatcomptepersonnel"])) {
            header("Location:indexdg.php");
        } else if (isset($_SESSION["logincomptepersonnel"]) && (isset($_SESSION["motdepassecomptepersonnel"])) && ($_SESSION["etatcomptepersonnel"])) {
            header("Location:indexpersonnel.php");
        }
        ?>

        <div class="wrapper">
            <!--            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"></div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">-->
            <br>
            <form method="post" action="#">
                <center>
                    <input type="text" id=""  class="form-conrol" required="" name="loginsot" placeholder="Entrez votre identifiant ici !">
                    <input type="password" id=""  class="form-conrol" required="" name="passwordsot" placeholder="Entrez votre mot de passe ici !"><br>
                    <input type="submit" name="consot" class="btn btn-primary" value="Connexion">
                </center>
            </form>
            <!--</div>-->
        </div>
    </body>

</html>

<?php
ob_end_flush();
?>
