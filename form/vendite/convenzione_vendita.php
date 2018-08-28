<?php include("../../includes/mysql.inc.php");
  $sql="SELECT * FROM convenzioni WHERE id_convenzione='$_GET[id_convenzione]'";
  $res=mysql_query($sql);
  $rows=mysql_fetch_array($res, MYSQL_ASSOC);
?>
<script>
  $("#id_utente").select2();

	$(document).ready(function(){

     $(".tabella_prodotti_container").load("form/vendite/convenzioni_prodotti.php?id_convenzione=<?php echo $_GET["id_convenzione"];?>&utente_selezionato=<?php echo $_GET["utente_selezionato"];?>");
  

   $('form.prodotto').submit(function(e) {
      e.preventDefault(); // don't submit multiple times
      $.post("actions/convenzioni.php",{
        id_utente:$("#id_utente").val(), 
         id_convenzione:$("#id_convenzione").val(), 
        descrizione:$("#descrizione").val(), 
        nome_mittente:$("#nome_mittente").val(),
        indirizzo_mittente:$("#indirizzo_mittente").val(),
        fatturazione:$("#fatturazione").val(),
        action:"modifica"}, function(data){
        if(data!=""){
         window.location.href="convenzioni.php";
        }
      })
  });


  })
</script>
<div class="col-xs-12">


  <div class="tabella_prodotti_container"></div>

</div>