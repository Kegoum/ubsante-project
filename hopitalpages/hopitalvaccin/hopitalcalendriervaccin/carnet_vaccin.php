<style>
    .signature {
        position: relative;
        margin-left:300px;
        width: 100px;
        border-radius: 50%;
        -webkit-transform: rotate(-60deg);
        -moz-transform: rotate(-60deg);
        -ms-transform: rotate(-60deg);
        -o-transform: rotate(-60deg);
        transform: rotate(-60deg);

    }

    h6 span {
        font: 15px Monaco, MonoSpace;
        height: 200px;
        position: absolute;
        width: 20px;
        left: 0;
        top: 0;
        -webkit-transform-origin: bottom center;
        -moz-transform-origin: bottom center;
        -ms-transform-origin: bottom center;
        -o-transform-origin: bottom center;
        transform-origin: bottom center;
    }

    div.badge
    {


        width:       96mm;
        height:      146mm;
        overflow: hidden;
        border:2px solid #999;
        border-radius:5px 5px 5px 5px; 
        /*        box-shadow:3px 3px 2px 2px #999; 
                -webkit-box-shadow:2px 2px 1px #999; */
        margin:auto; 
        margin-bottom:0px; 
        font-size:12px;
        opacity: 0.6;
    }

    div.badge2i
    {


        width:       4mm;
        height:      18mm;
        border:2px solid #999;
        border-radius:5px 5px 5px 5px;  
        margin:auto; 
        margin-bottom:0px; 
    }

    .ul2
    {
        list-style: square;
        padding: 0px;
        margin: 0px;
    }

    .ul3 li
    {
        padding: 0px;
        margin: 0px;
    }

</style>
<?php
@include("../../../hopitalconnexion/connexion.php");
$id = $_GET["hopital"];

$date = date('Y-m-d');

$reqa = $con->query("select *, DATE_FORMAT(datefinvalidite, \"%d-%m-%Y\") AS "
        . "datefinvalidite_fr from hp_validite where idhopital='" . $id . "'") or die(mysqli_error($con));
$rowa = mysqli_fetch_assoc($reqa);

$req = $con->query("select * from hp_hopital as mt left join hp_commune_secteur as cs on mt.idcommunesecteur=cs.idcommunesecteur "
        . "left join hp_commune as c on cs.idcommune=c.idcommune "
        . "left join hp_ville as v on c.idville=v.idville left join hp_region as r on v.idregion=r.idregion "
        . "where mt.idhopital='" . $id . "'") or die(mysqli_error($con));
$row = mysqli_fetch_object($req);

$rsltniv = $con->query("select * from hp_secteur where idsecteur='" . $row->idsecteur . "'") or die(mysqli_error($con));
$recniv = mysqli_fetch_assoc($rsltniv);
?>
<page backtop="1mm" backbottom="1mm" backleft="1mm" backright="1mm">
    <div class="badge" <?php if (file_exists("../../../hopitalimages/badges.PNG")) { ?> style=" background: url(../../../hopitalimages/badges.PNG) center center no-repeat;" <?php } ?>>

        <table style="border:0px; width: 100%;">
            <tr>
                <td style="width:14%"><img src="../../../hopitalimages/drapeau.png" style="height: 30mm; border-radius: 6mm;"/></td>
                <td align="center" style=" width: 75%">
                    &nbsp;
                </td>
            </tr>
        </table>
        <table style="border:0px; width: 100%">
            <tr>
                <td style="width : 40%">
                    <table style="border:0px;">
                        <tr>
                            <td>
                                <br><br>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <img src="../../../hopitalupload/profil/<?php print $row->photohopital; ?>" style="width: 20mm; height: 23mm; border-radius: 10mm;"/></td>
                        </tr>
<!--                        <tr>
                            <td><h1><?php echo $row->lettre; ?></h1></td>
                            <td align="center"><br /><br />Validit&eacute;/Validity<br /><?php echo $rowa["datefinvalidite_fr"]; ?></td>
                        </tr>-->
                    </table>

                </td>
                <td style="width : 60%; color: white">
                    <br><br><br>
                    <table style="border:0px; width: 100%; font-size : 6.8px;">
                        <tr>
                            <td style="width: 22%">
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font>Nom : </font><br />
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font>Name : </font>
                            </td>
                            <td align="left" style="width: 78%"><b><em style="font-size:12px"><?php echo $row->nomhopital; ?></em></b></td>
                        </tr>
                        <tr>
                            <td style="width: 22%">
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font>Prenom : </font><br />
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font>Surname: </font>
                            </td>
                            <td align="left" style="width: 78%"><b><em style="font-size:12px"><?php echo $row->prenomhopital; ?></em></b></td>
                        </tr>
                        <tr>
                            <td style="width: 100%; font-size: 7.5px;" colspan="2">
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font>T&eacute;l : </font>
                                <?php echo $row->telephonehopital; ?>
                                &nbsp;&nbsp;<font>Personne &agrave; contacter : </font>
                                &nbsp;&nbsp;<?php echo $row->telephonecontacthopital; ?></td>
                        </tr>
                        <tr>
                            <td style="width: 22%; font-size: 7.5px;">
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font>Permis :</font>
                            </td>
                            <td style="width: 78%; font-size: 7.5px;">
                                &nbsp;&nbsp;<?php echo $row->permishopital; ?>
                                &nbsp;&nbsp;<?php echo $row->categoriepermishopital; ?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <br><br><br><br>
        <table style="border:0px; width: 100%; text-align: center">
            <tr>
                <td style="width:14%"></td>
                <td align="center" style=" width: 75%"><br />
                    <b style="font-size:10px">BADGE PROFFESSIONNEL D'IDENTIFICATION<br /> PROFESSIONAL IDENTIFICATION BADGE</b>
                    <h5  style="color: RGB(0, 172, 232)">Moto-Taxi de la Commune de : <?php echo $row->libellecommune; ?></h5>
                </td>
            </tr>
        </table>
        <div>
            <div align="center">
                <b style="font-size:60px"><?php echo $row->matriculehopital; ?></b>
            </div>
        </div>
        <br>
<div align="center"> 
        <qrcode value="<?php echo $row->matriculehopital; ?>" ec="H" style="width: 15mm; text-align: center;"></qrcode>
</div>
        
    </div>
</page>