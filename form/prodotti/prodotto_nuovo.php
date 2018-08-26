<?php include("../../includes/mysql.inc.php");?>
<script>
	$(document).ready(function(){

   
		$(".btn-danger").bind("click", function(){
			$("#contenitore").empty().load("form/prodotti/prodotti.php");	
		});

   $('form.prodotto').submit(function(e) {
      e.preventDefault(); // don't submit multiple times
      $.post("actions/prodotti.php",{prodotto:$("#prodotto").val(), categoria:$("#categoria").val(), action:"inserisci"}, function(data){

        $("#contenitore").empty().load("form/prodotti/prodotto_inserimento_pacchetti.php?id_prodotto="+data);
        
         $("li.pacchetti").removeClass("disabled");

         $('.nav-tabs a[href="#2"]').tab('show');

      })
  });
	})
</script>

<ul class="nav nav-tabs">
  <li class="active"><a href="#1" data-toggle="tab">Dati Generali</a></li>
  <li class="disabled" id="pacchetti"><a href="#2" data-toggle="tab">Pacchetti</a></li>
  
</ul>


<div class="tab-content ">
    

    <div class="tab-pane active" id="1">
        <div class="col-xs-12">
        <form class="prodotto">
          <fieldset class="form-group">
            <label for="prodotto">Prodotto</label>
            <input type="text" class="form-control" id="prodotto" placeholder="prodotto" required>  
          </fieldset>
          <fieldset class="form-group">
            <label for="categoria">Categoria</label>
            <select id="categoria" class="form-control" required>
            	<option></option>
            <?php $sql="SELECT * FROM prodotti_categorie ORDER BY categoria";
            	  $res=mysql_query($sql);
            	  while($rows=mysql_fetch_array($res, MYSQL_ASSOC)){?>
            	  	<option value='<?php echo $rows["id_categoria"];?>'><?php echo utf8_encode($rows["categoria"]);?></option>
           	<?php } ?> 
           	</select>   	  
          </fieldset>
          <button type="submit" class="btn btn-primary"><i class="fa fa-check" aria-hidden="true"></i></button>
          <button class="btn btn-danger"><i class="fa fa-times" aria-hidden="true"></i></button>
        </form>
        </div>
    </div>

      <div class="tab-pane" id="2">
          <div class="prodotto_meta_container"></div>
      </div>
</div>