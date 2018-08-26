<script>
$(document).ready(function(){
  $(".pacchetto_circuito").on("change", function(){
    var check=0;
    if($(this).is(":checked")) check=1;
    $.post("actions/pacchetti.php",{check:check, id_circuito:'<?php echo $_GET["id_circuito"];?>', id_pacchetto:$(this).attr("data-id"), action:"pacchetto_circuito"});
  });


   $(".servizi").on("change", function(){
    var check=0;
    if($(this).is(":checked")) check=1;
    $.post("actions/pacchetti.php",{check:check, id_circuito:'<?php echo $_GET["id_circuito"];?>', id_servizio:$(this).attr("data-value"), action:"servizio_circuito"});
  });   

});
</script>

<table class="table table-striped table-bordered table-pacchetti">
    <thead>
        <tr>
            <th>ID</th>
            <th>Pacchetto</th>
            
            <th class="actions"></th>
            
        </tr>   
    </thead>
    <tbody>
    <?php include("../../includes/mysql.inc.php");
$sql="SELECT * FROM pacchetti ORDER BY id_pacchetto";
$res=mysql_query($sql);
while($rows=mysql_fetch_array($res, MYSQL_ASSOC)){?>
  <tr>
      <td><?php echo utf8_encode($rows["id_pacchetto"]);?></td>
      <td><?php echo utf8_encode($rows["pacchetto"]);?></td>

      <?php $sql1="SELECT * FROM circuiti_pacchetti WHERE id_circuito = '$_GET[id_circuito]' AND id_pacchetto='$rows[id_pacchetto]'";
            $res1=mysql_query($sql1);

            $check="";
            if(mysql_num_rows($res1)==1) $check="checked";?>
      <td><input type="checkbox" class="pacchetto_circuito" <?php echo $check;?> data-id="<?php echo $rows["id_pacchetto"];?>"/></td>
  </tr>


  <?php $sqls="SELECT * FROM aree_servizi WHERE id_pacchetto='$rows[id_pacchetto]'";
       $ress=mysql_query($sqls);
       if($nums=mysql_num_rows($ress)>0){
                        while($rowss=mysql_fetch_array($ress, MYSQL_ASSOC)){
                            echo "<tr><td></td>";
                      
                          $sql3="SELECT * FROM circuiti_servizi WHERE id_circuito='$_GET[id_circuito]' AND id_servizio='$rowss[id_area]'";

                  
                  $res3=mysql_query($sql3);
                  $selecteds="";
                  if(mysql_num_rows($res3)>0) $selecteds="checked";
                  ?>
                          <td><?php echo utf8_encode($rowss["area"]);?></td>
                          <td><input type="checkbox" data-value='<?php echo $rowss["id_area"];?>' data-tipo="Servizio" class="servizi" <?php echo $selecteds;?> /></td>
                        <?php } 
                        echo "</tr>";
                      }
} ?>

    </tbody>    
</table>