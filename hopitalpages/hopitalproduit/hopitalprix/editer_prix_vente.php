<script language="JavaScript">
    

</script>
<?php
//if (isset($_REQUEST["produit"])) {
//    $idarti = $_REQUEST["produit"];
//    $rslt = $con->query("select * from hotel_produit_point_hotel as aph left join hotel_produit as a on "
//            . "aph.id_produit=a.id_produit left join hotel_categorie as c on a.id_categorie=c.id_categorie left "
//            . "join hotel_fourniture as f on a.id_fourniture=f.id_fourniture "
//            . "where id_produit_point_hotel='" . $idarti . "'") or die("erreur");
//    $row = mysqli_fetch_assoc($rslt);
?>
<div id="modaleditprvente" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modaleditprventeLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h2 id="modaleditprventeLabel">Modifier Le prix de vente
                    <?php // echo $row["libelle_produit"]; ?> 
                </h2>
            </div>
            <div class="modal-body">
                <form name="" id="personnel_eform" method="POST" action="#">
                    <div class="form-group">
                        <label>Prix de vente</label>
                        <input name="prixvente" type="text" class="text-input form-control" id="prixlavage" required autofocus>
                    </div>
                    <input name="idproduitphv" type="hidden" class="" id="idproduitphv">
                    <br/><br/>
                    <input type="submit" class="btn btn-success"  id="Submite" name="editprvente_btn"/>
                    <input type="reset" class="btn btn-success " name="effacere" value="Effacer">
                    <input type="button" class="close btn-success" data-dismiss="modal" aria-hidden="true"  value="Annuler">
                </form>
                <?php
                if (isset($_POST["editprvente_btn"])) {
                    
        
                    $produitv = trim($_POST["idproduitphv"]);
                    $prixvent = trim($_POST["prixvente"]);
                    update_prix_vente_produit($produitv, $prixvent, $con);
                }
                ?>
            </div>

        </div>
    </div>
</div>
<?php
//}
?>