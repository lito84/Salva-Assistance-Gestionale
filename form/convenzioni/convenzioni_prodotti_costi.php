<?php require("../../includes/mysql.inc.php");
require("../../includes/parameters.php");?>


<script>
  
  $(document).ready(function(){

    $(".prezzo").on("keyup change", function(){
        var prezzo_cliente_scontato=$(".prezzo_cliente_scontato").val();
        var prezzo_cliente_prodotto=$(".prezzo_cliente_prodotto").val();
        var prezzo_agente_prodotto=$(".prezzo_agente_prodotto").val();
        var id_aliquota=$(".aliquota").val();
        prezzo_cliente_prodotto=prezzo_cliente_prodotto.replace(",",".");
        prezzo_agente_prodotto=prezzo_agente_prodotto.replace(",",".");

        $.post("actions/convenzioni.php",{prezzo_cliente_scontato:prezzo_cliente_scontato,id_aliquota:id_aliquota, prezzo_cliente_prodotto:prezzo_cliente_prodotto,prezzo_agente_prodotto:prezzo_agente_prodotto,id_convenzione_prodotto:'<?php echo $_GET["id_convenzione_prodotto"];?>', action:"prezzi"}, function(data){
         })
    });


  });
   
</script>

<?php $sql0="SELECT * FROM convenzioni_prodotti LEFT JOIN prodotti ON prodotti.id_prodotto=convenzioni_prodotti.id_prodotto WHERE id_convenzione_prodotto ='$_GET[id_convenzione_prodotto]'";
$res0=mysql_query($sql0);
$rows0=mysql_fetch_array($res0, MYSQL_ASSOC);?>

<legend>Prezzi - <?php echo utf8_encode(stripslashes($rows0["prodotto"]));?></legend>   
<table class="table table-striped table-bordered">
    <thead>
        <tr>
            
            <th>Importo Cliente Finale</th>
            <th>Importo Agente</th>
             <th>Aliquota</th>
           
        </tr>   
    </thead>
    <tbody>
    <?php 


       $sql="SELECT * FROM convenzioni_prodotti LEFT JOIN prodotti ON prodotti.id_prodotto=convenzioni_prodotti.id_prodotto WHERE id_convenzione_prodotto ='$_GET[id_convenzione_prodotto]'";
        $res=mysql_query($sql);
        while($rows=mysql_fetch_array($res, MYSQL_ASSOC)){?>
            
            <tr>
               
                <td><input type="text" class="prezzo_cliente_prodotto prezzo"  value="<?php echo utf8_encode($rows["prezzo_cliente"]);?>" /></td>
                <td><input type="text" class="prezzo_agente_prodotto prezzo"  value="<?php echo utf8_encode($rows["prezzo_agente"]);?>" /></td>
                <td>
                  <select class="aliquota prezzo">
                    <option></option>
                    <?php $sql1="SELECT * FROM aliquote_iva";
                          $res1=mysql_query($sql1);
                          while($rows1=mysql_fetch_array($res1, MYSQL_ASSOC)):?>
                          <option value="<?php echo $rows1["id_aliquota"];?>" <?php if($rows["id_aliquota"]==$rows1["id_aliquota"]) echo "selected";?>><?php echo $rows1["aliquota"];?></option>
                    <?php      
                          endwhile;
                    ?>
                  </select>  
                </td>
            </tr>
        <?php }?>
    </tbody>    
</table>