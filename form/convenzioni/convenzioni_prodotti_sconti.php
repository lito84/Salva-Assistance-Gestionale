<?php require("../../includes/mysql.inc.php");
require("../../includes/parameters.php");?>


<script>
  
  $(document).ready(function(){


    $(".codice_sconto").on("keyup", function(){
      var id_sconto=$(this).attr("data-id");
      $.post("actions/convenzioni.php", {id_sconto:id_sconto, codice_sconto:$(this).val(), action:"modifica_codice"});
    });

    $(".prezzo_sconto").on("keyup", function(){
      var id_sconto=$(this).attr("data-id");
      $.post("actions/convenzioni.php", {id_sconto:id_sconto, prezzo:$(this).val(), action:"modifica_sconto"});
    });

    $(".data_sconto").on("keyup", function(){

      if($(this).val().length==10){
         var id_sconto=$(this).attr("data-id");
         $.post("actions/convenzioni.php", {id_sconto:id_sconto, data_limite:$(this).val(), action:"modifica_data"});
      }
     
    });

    $(".data_limite").mask("99/99/9999");
    $(".aggiungi_sconto").on("click", function(){
        var nuovo_codice=$(".nuovo_codice").val();
        var nuovo_prezzo=$(".nuovo_prezzo").val();
        nuovo_prezzo=nuovo_prezzo.replace(",",".");
        var data_limite=$(".data_limite").val();
        $.post("actions/convenzioni.php",{nuovo_codice:nuovo_codice, nuovo_prezzo:nuovo_prezzo, data_limite:data_limite, id_convenzione_prodotto:'<?php echo $_GET["id_convenzione_prodotto"];?>', action:"nuovo_sconto"}, function(data){
            $(".prodotti_convenzione_dettaglio").empty().load("form/convenzioni/convenzioni_prodotti_sconti.php?id_convenzione_prodotto=<?php echo $_GET["id_convenzione_prodotto"];?>");
        })
    });


  });
   
</script>

<?php $sql0="SELECT * FROM convenzioni_prodotti LEFT JOIN prodotti ON prodotti.id_prodotto=convenzioni_prodotti.id_prodotto WHERE id_convenzione_prodotto ='$_GET[id_convenzione_prodotto]'";
$res0=mysql_query($sql0);
$rows0=mysql_fetch_array($res0, MYSQL_ASSOC);?>

<legend>Sconti - <?php echo utf8_encode(stripslashes($rows0["prodotto"]));?></legend>   
<table class="table table-striped table-bordered">
    <thead>
        <tr>
            
            <th>Codice sconto</th>
            <th>Importo Cliente Finale Scontato</th>
            <th>Data limite utilizzo</th>
        </tr>   
    </thead>
    <tbody>
    <?php 


       $sql="SELECT * FROM convenzioni_prodotti_sconti WHERE id_convenzione_prodotto ='$_GET[id_convenzione_prodotto]'";
        $res=mysql_query($sql);
        while($rows=mysql_fetch_array($res, MYSQL_ASSOC)){

          $data_limite = ($rows['data_limite'] != '') ? $data_limite=date("d/m/Y", strtotime($rows["data_limite"])) : $data_limite="";
        
          ?>
            
            <tr>
               
                <td><input type="text" class="codice_sconto sconto"  data-id="<?php echo $rows["id_sconto"];?>" value="<?php echo utf8_encode($rows["codice_sconto"]);?>" /></td>
                <td><input type="text" class="prezzo_sconto sconto"  data-id="<?php echo $rows["id_sconto"];?>" value="<?php echo utf8_encode($rows["prezzo"]);?>" /></td>
                <td><input type="text" class="data_sconto sconto"  data-id="<?php echo $rows["id_sconto"];?>" value="<?php echo $data_limite;?>" /></td>
            </tr>
        <?php }?>
    </tbody>    
</table>

<fieldset>
  <legend>Nuovo codice sconto</legend>
  <div class="form-group">
  <div class="row">
    <div class="col-xs-3">
      <label>Codice sconto</label>
      <input type="text" class="form_control nuovo_codice">
    </div>
    <div class="col-xs-3">
      <label>Prezzo applicato</label>
      <input type="text" class="form_control nuovo_prezzo ">
    </div>
    <div class="col-xs-3">
      <label>Data limite utilizzo applicato</label>
      <input type="text" class="form_control data_limite ">
    </div>

    <div class="col-xs-3">
      <label>&nbsp;</label>
      <button class="btn btn-primary aggiungi_sconto">Aggiungi sconto</button>
    </div>
  </div>
</div>
</fieldset>