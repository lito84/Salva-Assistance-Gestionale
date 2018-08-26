<?php include("../../includes/mysql.inc.php");?>
<?php $sql="SELECT * FROM prodotti WHERE id_prodotto='$_GET[id_prodotto]'";
$res=mysql_query($sql);
$rows=mysql_fetch_array($res, MYSQL_ASSOC);
?>
<script>
	$(document).ready(function(){
		$(".btn-danger").bind("click", function(){
			$("#contenitore").empty().load("form/prodotti/prodotti.php");	
		});

   $('form.prodotto').submit(function(e) {
      e.preventDefault(); // don't submit multiple times
      $.post("actions/prodotti.php",{prodotto:$("#prodotto").val(), categoria:$("#categoria").val(), id_prodotto:'<?php echo $_GET['id_prodotto'];?>', action:"modifica"}, function(data){
      $("#contenitore").empty().load("form/prodotti/prodotti.php"); 
      })
  });

   $(".prodotti_meta").load("form/prodotti/prodotto_meta.php?id_prodotto=<?php echo $_GET['id_prodotto'];?>");
	
   $(".servizi").on("change", function(){
      var selezione=0;
      if($(this).is(":checked")){
        selezione=1;
      }
     $.post("actions/prodotti.php",{id_prodotto:'<?php echo $_GET["id_prodotto"];?>', selezione:selezione, tipo:$(this).attr("data-tipo"), valore:$(this).attr("data-value"), action:"pacchetto"});

   });
  });
</script>


<ul class="nav nav-tabs">
  <li class="active"><a href="#1" data-toggle="tab">Dati Generali</a></li>
  <li><a href="#pacchetti" data-toggle="tab">Pacchetti</a></li>
  <li><a href="#meta" data-toggle="tab">Attributi</a></li>
  
</ul>


<div class="tab-content ">
    

    <div class="tab-pane active" id="1">


    <form class="prodotto">
      <fieldset class="form-group">
        <label for="prodotto">Prodotto</label>
        <input type="text" class="form-control" id="prodotto" placeholder="prodotto" required value="<?php echo utf8_encode($rows["prodotto"]);?>">  
      </fieldset>
      <fieldset class="form-group">
        <label for="categoria">Categoria</label>
        <select id="categoria" class="form-control" required>
        	<option></option>
        <?php $sql1="SELECT * FROM prodotti_categorie ORDER BY categoria";
        	  $res1=mysql_query($sql1);
        	  while($rows1=mysql_fetch_array($res1, MYSQL_ASSOC)){?>
        	  	<option value='<?php echo $rows1["id_categoria"];?>' <?php if($rows[categoria]==$rows1[id_categoria]) echo "selected";?>><?php echo utf8_encode($rows1["categoria"]);?></option>
       	<?php } ?> 
       	</select>   	  
      </fieldset>
      <button type="submit" class="btn btn-primary"><i class="fa fa-check" aria-hidden="true"></i></button>
      <button class="btn btn-danger"><i class="fa fa-times" aria-hidden="true"></i></button>
    </form>


    </div>

    <div class="tab-pane" id="pacchetti">
        <ul>
        <?php $sqlp="SELECT * FROM pacchetti ORDER BY id_pacchetto";
              $resp=mysql_query($sqlp);
              while($rowsp=mysql_fetch_array($resp, MYSQL_ASSOC)){

                  $sql2="SELECT * FROM prodotti_meta WHERE id_prodotto='$_GET[id_prodotto]' AND chiave='Pacchetto' AND valore='$rowsp[id_pacchetto]'";
                  $res2=mysql_query($sql2);
                  $selected="";
                  if(mysql_num_rows($res2)>0) $selected="checked";
                ?>
                <li><input type="checkbox" data-value='<?php echo $rowsp["id_pacchetto"];?>' data-tipo="Pacchetto" class="servizi" <?php echo $selected;?>> <?php echo utf8_encode($rowsp["pacchetto"]);?></li>

                <?php $sqls="SELECT * FROM aree_servizi WHERE id_pacchetto='$rowsp[id_pacchetto]'";
                      $ress=mysql_query($sqls);
                      if($nums=mysql_num_rows($ress)>0){
                        echo "<ul>";
                        while($rowss=mysql_fetch_array($ress, MYSQL_ASSOC)){

                          $sql3="SELECT * FROM prodotti_meta WHERE id_prodotto='$_GET[id_prodotto]' AND chiave='Servizio' AND valore='$rowss[id_area]'";
                  $res3=mysql_query($sql3);
                  $selecteds="";
                  if(mysql_num_rows($res3)>0) $selecteds="checked";
                  ?>
                          <li><input type="checkbox" data-value='<?php echo $rowss["id_area"];?>' data-tipo="Servizio" class="servizi" <?php echo $selecteds;?>> <?php echo utf8_encode($rowss["area"]);?></li>
                        <?php } 
                        echo "</ul>";
                      }
                      
        } ?>
        </ul>     
    </div>
    <div class="tab-pane" id="meta">
     <div class="prodotti_meta"></div>
    </div>
</div>