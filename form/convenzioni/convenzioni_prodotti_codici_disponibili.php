<?php require("../../includes/mysql.inc.php");
require("../../includes/parameters.php");?>


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
                 $(".prodotti_convenzione_dettaglio").empty().load("form/convenzioni/convenzioni_prodotti_codici_disponibili.php?id_convenzione_prodotto=<?php echo $_GET["id_convenzione_prodotto"];?>");
            }
        });
    });
  });
   
</script>
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
    <thead>
        <tr>
            
            <th>Codice</th>
            <th>Data inserimento</th>
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
            
            ?>
            <tr>
              <td><?php echo $rows["codice_attivazione"];?></td>
              <td><?php echo $data_inserimento;?></td>
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