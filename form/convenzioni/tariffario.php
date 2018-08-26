<?php include("../../includes/mysql.inc.php");?>
<?php $sql="SELECT * FROM prodotti LEFT JOIN convenzioni_prodotti ON convenzioni_prodotti.id_prodotto = prodotti.id_prodotto WHERE id_convenzione_prodotto='$_GET[id_convenzione_prodotto]'";
$res=mysql_query($sql);
$rows=mysql_fetch_array($res, MYSQL_ASSOC);
?>
<script>
	$(document).ready(function(){
	

    $(".inserisci_tariffa").bind("click",function(){
      $.post("actions/prodotti.php",{id_convenzione_prodotto:$(this).attr('data-id'), mesi:$("#mesi").val(), prezzo:$("#prezzo").val(), action:"nuova_tariffa"}, function(data){
        data=data.trim();
        if(data=="OK"){
           $(".prodotti_convenzione_dettaglio").empty().load("form/convenzioni/tariffario.php?id_convenzione_prodotto=<?php echo $_GET["id_convenzione_prodotto"];?>");
        }
      });
    });

    $(".elimina_tariffa").bind("click",function(){
      $.post("actions/prodotti.php",{id_tariffario:$(this).attr('data-id'), action:"elimina_tariffa"}, function(data){
         data=data.trim();
          if(data=="OK"){
              $(".prodotti_convenzione_dettaglio").empty().load("form/convenzioni/tariffario.php?id_convenzione_prodotto=<?php echo $_GET["id_convenzione_prodotto"];?>");
          }
      });

    });
  });
</script>


<label for="prodotto">Tariffario <b><?php echo utf8_encode($rows["prodotto"]);?></b></label>

<table class="table table-striped">
  <thead>
    <tr>
      <th>Durata (mesi)</th>
      <th>Prezzo</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
    <?php $sql1="SELECT * FROM tariffario WHERE id_prodotto_convenzione='$_GET[id_convenzione_prodotto]' ORDER BY mesi ASC";
          $res1=mysql_query($sql1);
          while($rows1=mysql_fetch_array($res1, MYSQL_ASSOC)):?>
            <tr>
              <td><?php echo $rows1["mesi"];?></td>
              <td><?php echo number_format($rows1["prezzo"],2,",","");?></td>
              <td><button class="btn btn-danger elimina_tariffa" data-id=<?php echo $rows1["id_tariffario"];?>><i class="fa fa-trash-alt"></i></button></td>
            </tr>
    <?php endwhile;?>
  </tbody>
</table>



<div class="row">
  <h5>Nuova tariffa</h5>
  <div class="col-xs-4">
    <label>Mesi</label>
    <input type="text" id="mesi" name="mesi" class="form-control" />
  </div>

  <div class="col-xs-4">
    <label>Prezzo</label>
    <input type="text" id="prezzo" name="prezzo" class="form-control" />
  </div>

  <div class="col-xs-4">
    <label>&nbsp;</label>
    <button data-id="<?php echo $_GET["id_convenzione_prodotto"];?>" class="btn btn-primary btn-block inserisci_tariffa">Inserisci</button>
  </div>
</div>
