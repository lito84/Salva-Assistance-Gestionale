<?php include("../../includes/mysql.inc.php");
      include("../../includes/mysqli.inc.php");
  $sql="SELECT * FROM convenzioni WHERE id_convenzione='$_GET[id_convenzione]'";
  $res=mysql_query($sql);
  $rows=mysql_fetch_array($res, MYSQL_ASSOC);
?>
<script>
  $("#id_utente").select2();

	$(document).ready(function(){

    $(".add_prodotto").bind("click", function(){
    var iva_agente=0;
    var iva_cliente=0;
    var attivazione_immediata=0;

    if($("input[name=iva_agente]:checked").val()=="1") iva_agente=1;
    if($("input[name=iva_cliente]:checked").val()=="1") iva_cliente=1;
     if($("input[name=attivazione_immediata]:checked").val()=="1") attivazione_immediata=1;


    $.post("actions/convenzioni.php",{id_convenzione:$("#convenzione_new").val(), id_prodotto:$("#prodotto").val(), prezzo_cliente:$("#prezzo_cliente").val(), prezzo_agente:$("#prezzo_agente").val(), iva_agente:iva_agente, iva_cliente:iva_cliente, attivazione_immediata:attivazione_immediata, modello_email:$("#modello_email").val(), action:"prodotto"}, function(data){
       $(".anteprima-modello-container").empty();
       
       $(".tabella_prodotti_container").empty().load("form/convenzioni/convenzioni_prodotti.php?id_convenzione=<?php echo $_GET["id_convenzione"];?>");
       $('.nav-tabs a[href="#prodotti_convenzione"]').tab('show');
    });
  });

		$(".btn-danger").bind("click", function(){
			window.location.href="convenzioni.php";
		});

    $('.comunicazioni').summernote({
      height: 300
    });

     $(".tabella_prodotti_container").load("form/convenzioni/convenzioni_prodotti.php?id_convenzione=<?php echo $_GET["id_convenzione"];?>");

     $(".anteprima-modello").bind("click", function(){
        $.post("actions/convenzioni.php", {id_template:$("#modello_email").val(), action:"preview"}, function(data){
          $(".anteprima-modello-container").empty().append(data);
        })
     })
  

   $('form.prodotto').submit(function(e) {
      e.preventDefault(); // don't submit multiple times
      $.post("actions/convenzioni.php",{
        id_utente:$("#id_utente").val(), 
        id_convenzione:$("#id_convenzione").val(), 
        descrizione:$("#descrizione").val(), 
        landing_acquisto:$("#landing_acquisto").val(),
        nome_mittente:$("#nome_mittente").val(),
        indirizzo_mittente:$("#indirizzo_mittente").val(),
        fatturazione:$("#fatturazione").val(),
        fatturazione_agente:$("#fatturazione_agente").val(),
        vendita:$("#vendita").val(),
        action:"modifica"}, function(data){
        if(data!=""){
         window.location.href="convenzioni.php";
        }
      })
  });


  })
</script>
<div class="col-xs-12">

<div class="bs-callout bs-callout-info">
  <h4><?php echo $rows["codice_convenzione"];?></h4>
  <?php echo utf8_encode($rows["descrizione"]);?>
</div>

<ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Dati generali</a></li>
    <li role="presentation"><a href="#prodotti_convenzione" aria-controls="prodotti_convenzione" role="tab" data-toggle="tab">Prodotti convenzione</a></li>
    <li role="presentation"><a href="#nuovo_prodotto_convenzione" aria-controls="nuovo_prodotto_convenzione" role="tab" data-toggle="tab">Nuovo prodotto in convenzione</a></li>
</ul>

<div class="tab-content">
 <div role="tabpanel" class="tab-pane active" id="home">

<form class="prodotto">
  <fieldset class="form-group">
    
    <label for="descrizione">Descrizione</label>
    <input type="text" id="descrizione" name="descrizione" required class="form-control" value="<?php echo utf8_encode($rows['descrizione']);?>" /> 

</fieldset>

  <hr />
  <input type="hidden" id="id_convenzione" name="id_convenzione" value="<?php echo $_GET["id_convenzione"];?>">
  <button type="submit" class="btn btn-primary"><i class="fa fa-check" aria-hidden="true"></i></button>
  <button class="btn btn-danger"><i class="fa fa-times" aria-hidden="true"></i></button>
</form>
</div>

<div role="tabpanel" class="tab-pane" id="prodotti_convenzione">
 <fieldset class="form-group">
  <div class="bs-callout bs-callout-success">
  <h4>Prodotti in convenzione</h4>
  
  </div>
  
  <div class="tabella_prodotti_container"></div>
 </fieldset> 
</div>

<div role="tabpanel" class="tab-pane" id="nuovo_prodotto_convenzione">
  <fieldset class="form-group alert-warning">
  <legend>Nuovo prodotto</legend>
  <div class="col-xs-6 col-sm-3">
  <label>Prodotto</label>
    <select class="form-control" id="prodotto" name="prodotto">
    <option></option>
    <?php $sql1="SELECT * FROM prodotti ORDER BY prodotto";
        $res1=mysql_query($sql1);
        while($rows1=mysql_fetch_array($res1, MYSQL_ASSOC)){?>
         <option value="<?php echo $rows1["id_prodotto"];?>"><?php echo utf8_encode($rows1["prodotto"]);?></option>   
    <?php } ?>
    </select>
  </div>

  

  <input type="hidden" id="convenzione_new" name="convenzione_new" value="<?php echo $_GET["id_convenzione"];?>">

      <div class="col-xs-1">
  <label>&nbsp;</label>
    <button class="btn btn-success add_prodotto form-control"><i class="fa fa-check-circle" aria-hidden="true"></i></button>
  </div>
</fieldset>
</div>

</div>


<div class="anteprima-modello-container">
  

</div>
</div>