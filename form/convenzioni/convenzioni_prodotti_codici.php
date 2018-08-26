<?php require("../../includes/mysql.inc.php");
require("../../includes/parameters.php");?>


<script>
  
  $(document).ready(function(){
    $(".loading-codice").hide();
    $("#genera_codici_button").bind("click", function(){
      var id_convenzione_prodotto=$(this).attr("data-id");
      var pagato=0;
      var attivo=1;
      if($("#pagato_codici").is(":checked")){
        pagato=1;
      }
      
      $.post("actions/convenzioni.php",{descrizione_lotto:$("#descrizione_lotto").val(), numero_codici:$("#numero_codici").val(), id_convenzione_prodotto:id_convenzione_prodotto, pagato:pagato,attivo:attivo,action:"genera_codici"}, function(){

          $(".prodotti_convenzione_dettaglio").empty().load("form/convenzioni/convenzioni_prodotti_codici.php?id_convenzione_prodotto="+id_convenzione_prodotto);
      });
    });



    $("#invia_codice").bind("click", function(){
      $(".invio_result").empty();
        $(".loading-codice").show();
      var id_convenzione_prodotto=$(this).attr("data-id");
      var pagato_codice=0;
      var attivo=1;
      if($("#pagato_codice").is(":checked")){
        pagato_codice=1;
      }
      
      $.post("actions/convenzioni.php",{nominativo_codice:$("#nominativo_codice").val(), email_codice:$("#email_codice").val(), id_convenzione_prodotto:id_convenzione_prodotto, pagato:pagato_codice,attivo:attivo,action:"invia_codice"}, function(data){
          if(data!=""){
            $(".invio_result").empty().append("<div class='alert alert-success' role='alert'>Codice generato: "+data+"</div>");
              $(".loading-codice").hide();
          }
         
      });
    });


     $(".esportazione").bind("click", function(){
      window.open("esportazione_codici.php?id_lotto="+$(this).attr("data-id"),"_blank");
    });
  });
</script>



<table class="table table-striped table-bordered table-codici">
    <thead>
        <tr>
            
            <th>Lotto</th>
            <th>Data inserimento</th>
            <th>Prodotto</th>
            <th># Codici</th>

            <th>&nbsp;</th>
        </tr>   
    </thead>
    <tbody>
    <?php 


        $sql="SELECT * FROM convenzioni_prodotti_codici_lotti LEFT JOIN convenzioni_prodotti ON convenzioni_prodotti.id_convenzione_prodotto = convenzioni_prodotti_codici_lotti.id_prodotto_convenzione LEFT JOIN convenzioni ON convenzioni.id_convenzione = convenzioni_prodotti.id_convenzione LEFT JOIN utenti ON utenti.id_utente = convenzioni.id_utente ";
        $sql.="WHERE convenzioni_prodotti_codici_lotti.id_prodotto_convenzione='$_GET[id_convenzione_prodotto]' ORDER BY data_inserimento DESC";
        $res=mysql_query($sql);
        while($rows=mysql_fetch_array($res, MYSQL_ASSOC)){?>
            
            <?php 
                $data_inserimento = ($rows['data_inserimento'] != '') ? $data_inserimento=date("d/m/Y", strtotime($rows["data_inserimento"])) : $data_inserimento="";
            
                $sql1="SELECT * FROM prodotti WHERE prodotti.id_prodotto=$rows[id_prodotto]";
                $res1=mysql_query($sql1);
                $rows1=mysql_fetch_array($res1, MYSQL_ASSOC);    
            ?>

            <tr>
               
                <td><?php echo utf8_encode($rows["lotto"]);?></td>
                <td><?php echo $data_inserimento;?></td>
            
                <td><?php echo utf8_encode($rows1["prodotto"]);?></td>
                <td><?php echo utf8_encode($rows["quantita"]);?></td>
                <td>
          
<button title="Esportazione" data-id="<?php echo $rows['id_lotto'];?>" class="btn btn-success esportazione"><i class="fa fa-file-excel-o" aria-hidden="true"></i>
</button>

                </td>
            </tr>
        <?php }?>
    </tbody>    
</table>


<?php $sql="SELECT * FROM convenzioni_prodotti LEFT JOIN prodotti ON prodotti.id_prodotto = convenzioni_prodotti.id_prodotto WHERE id_convenzione_prodotto = '$_GET[id_convenzione_prodotto]'";
$res=mysql_query($sql);
$rows=mysql_fetch_array($res, MYSQL_ASSOC);?>


<fieldset class="form-group">
<legend>Generazione codici <?php echo utf8_encode($rows["prodotto"]);?></legend>

  <div class="col-xs-5">
    <label>Descrizione lotto</label>
    <input type="text" id="descrizione_lotto" name="descrizione_lotto" class="form-control" />
  </div>

  <div class="col-xs-2">
    <label>Quantità</label>
    <input type="text" id="numero_codici" name="numero_codici" class="form-control" />
  </div>
  <div class="col-xs-1">
    <label>Pagato</label>
    <input type="checkbox" id="pagato_codici" name="pagato_codici" class="form-control" />
  </div>
  
  <div class="col-xs-1">
    <label>&nbsp;</label>
    <button id="genera_codici_button" name="genera_codici_button" class="btn btn-primary" data-id="<?php echo $_GET["id_convenzione_prodotto"];?>">Genera codici</button>
  </div>
</div>
</fieldset>


<fieldset class="form-group">
<legend>Invio codice <?php echo utf8_encode($rows["prodotto"]);?></legend>

  <div class="col-xs-5">
    <label>Nominativo</label>
    <input type="text" id="nominativo_codice" name="nominativo_codice" class="form-control" />
  </div>

  <div class="col-xs-5">
    <label>Email</label>
    <input type="text" id="email_codice" name="email_codice" class="form-control" />
  </div>
   <div class="col-xs-1">
    <label>Pagato</label>
    <input type="checkbox" id="pagato_codice" name="pagato_codice" class="form-control" />
  </div>
  <div class="col-xs-1">
    <label>&nbsp;</label>
    <button id="invia_codice" name="invia_codice" class="btn btn-primary" data-id="<?php echo $_GET["id_convenzione_prodotto"];?>">Invia codice</button>
  </div>
  <div class="col-xs-12"><i class="fa loading-codice fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span></div>

  <div class="col-xs-12 invio_result"></div>
</div>
</fieldset>

<?php
$sql="SELECT * FROM pratiche WHERE data_invio<>'' AND nominativo_invio<>'' AND id_prodotto_convenzione='$_GET[id_convenzione_prodotto]'";
$res=mysql_query($sql);
$num=mysql_num_rows($res);
if($num!=0):
?>
<table class="table table-striped table-bordered table-codici">
    <caption>Codici inviati</caption>
    <thead>
        <tr>
            
            <th>Codice</th>
            <th>Data inserimento</th>
            <th>Data invio</th>
            <th>Nominativo invio</th>
            <th>Email invio</th>
        </tr>   
    </thead>
    <tbody>
<?php 
while($rows=mysql_fetch_array($res, MYSQL_ASSOC)){?>

     <?php 
            $data_inserimento = ($rows['data_inserimento'] != '') ? $data_inserimento=date("d/m/Y", strtotime($rows["data_inserimento"])) : $data_inserimento="";
            $data_invio = ($rows['data_invio'] != '') ? $data_invio=date("d/m/Y H:i", strtotime($rows["data_invio"])) : $data_invio="";
            
            ?>
            <tr>
              <td><?php echo $rows["codice_attivazione"];?></td>
              <td><?php echo $data_inserimento;?></td>
              <td><?php echo $data_invio;?></td>
              <td><?php echo $rows["nominativo_invio"];?></td>
              <td><?php echo $rows["email_invio"];?></td>
            </tr>
         
           <?php }?>
    </tbody>    
</table>

<?php endif;?>
<table class="table table-striped table-bordered table-codici">
  <caption>Codici disponibili</caption>
    <thead>
        <tr>
            
            <th>Codice</th>
            <th>Data inserimento</th>
            <th>Nominativo</th>
            <th>Email</th>
            <th>Data invio</th>
            <th></th>
           
        </tr>   
    </thead>
    <tbody>
    <?php 


        $sql="SELECT * FROM pratiche WHERE id_cliente = '0' AND data_invio='' AND data_attivazione='' AND id_prodotto_convenzione='$_GET[id_convenzione_prodotto]'";
        $res=mysql_query($sql);
        while($rows=mysql_fetch_array($res, MYSQL_ASSOC)){?>
            
            <?php 
                $data_inserimento = ($rows['data_inserimento'] != '') ? $data_inserimento=date("d/m/Y", strtotime($rows["data_inserimento"])) : $data_inserimento="";

                  $data_invio = ($rows['data_invio'] != '') ? $data_invio=date("d/m/Y", strtotime($rows["data_invio"])) : $data_invio="";
            
            ?>
            <tr>
              <td><?php echo $rows["codice_attivazione"];?></td>
              <td><?php echo $data_inserimento;?></td>
              <td><?php echo $rows["nominativo_invio"];?></td>
              <td><?php echo $rows["email_invio"];?></td>
              <td><?php echo $data_invio;?></td>
              <td><button class='btn btn-primary' data-id='<?php echo $rows["codice_attivazione"];?>'><i class="fa fa-envelope"></i></button></td>
            </tr>
            <tr class="modulo_invio <?php echo $rows["codice_attivazione"];?>">
                <td>
                    <label>Nominativo</label>
                    <input class="nominativo_<?php echo $rows["codice_attivazione"];?> form-control" />
                </td>

                <td>
                    <label>Email</label>
                    <input class="email_<?php echo $rows["codice_attivazione"];?> form-control" />
                </td>
                <td>
                    <label>&nbsp;</label>
                    <button class="btn btn-success btn-block invio-email" data-id="<?php echo $rows["codice_attivazione"];?>"><i class="fa fa-envelope-open"></i></button>
                </td>
            </tr>
           <?php }?>
    </tbody>    
</table>
<script>
  
  $(document).ready(function(){
    $(".modulo_invio").hide();

    $(".btn-primary").on("click", function(){
        $("tr."+$(this).attr("data-id")).toggle();
    });

  
      $(".invio-email").on("click", function(){
        var id=$(this).attr("data-id");
        $.post("actions/convenzioni.php",{nominativo:$(".nominativo_"+id).val(),email:$(".email_"+id).val(),codice_attivazione:id, action:"invio_codice"}, function(data){

            if(data=="OK"){
                 $(".prodotti_convenzione_dettaglio").empty().load("form/convenzioni/convenzioni_prodotti_codici.php?id_convenzione_prodotto=<?php echo $_GET["id_convenzione_prodotto"];?>");
            }
        });
    });
  });
   
</script>
