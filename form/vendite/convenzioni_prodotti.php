<?php include("../../includes/mysql.inc.php");
      include("../../includes/parameters.php");
?>
<script>
$(document).ready(function(){

$(".btn-vendita").bind("click", function(){
  $(".prodotti_convenzione_dettaglio").empty().load("form/vendite/form_vendita.php?id_prodotto_convenzione="+$(this).attr('data-id')+"&utente_selezionato=<?php echo $_GET["utente_selezionato"];?>");
});




});
</script>
<?php $sql="SELECT * FROM convenzioni_prodotti LEFT JOIN convenzioni ON convenzioni.id_convenzione = convenzioni_prodotti.id_convenzione LEFT JOIN prodotti ON prodotti.id_prodotto= convenzioni_prodotti.id_prodotto WHERE convenzioni_prodotti.id_convenzione='$_GET[id_convenzione]'"; 
$res=mysql_query($sql);
$fatturazione=$rows["fatturazione"];
?>

<table class="table table-striped table-bordered">
  <thead>
    <tr>
      
      <th>Prodotto</th>
     
      <th>&nbsp;</th>
    </tr> 
  </thead>
  <tbody>
  <?php  while($rows=mysql_fetch_array($res, MYSQL_ASSOC)){

    if($rows["id_prodotto"]=='001') $prodotto="Mezzi Sussistenza";
    if($rows["id_prodotto"]=='002') $prodotto="Spese sanitarie";
    if($rows["id_prodotto"]=='003') $prodotto="Mezzi Sussistenza + Spese sanitarie";
    ?>
      <tr>
        
        <td><?php echo $prodotto;?></td>
        <td><button title="Vendita" data-id="<?php echo $rows["id_convenzione_prodotto"];?>" class="btn btn-success btn-info btn-vendita"><i class="fa fa-shopping-cart" aria-hidden="true"></i></button>
       </td>
      </tr>
    <?php }?>
  </tbody>  
</table>

<hr />
<div class="prodotti_convenzione_dettaglio"></div>