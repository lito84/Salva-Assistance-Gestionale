<?php include("../../includes/auth.inc.php");?>
<?php include("../../includes/mysql.inc.php");?>
<script>
$(document).ready(function(){
});
</script>
<?php 
$sql="SELECT * FROM pacchetti WHERE id_pacchetto='$_GET[id_pacchetto]'";
$res=mysql_query($sql);
$rows=mysql_fetch_array($res, MYSQL_ASSOC);
?>
<fieldset>
    <h3>Pacchetto: <?php echo utf8_encode($rows["pacchetto"]);?></h3>
</fieldset>
<table class="table-striped">
<tr>
    <th>ID Servizio</th>
    <th>Tabella</th>
    <th>Servizio</th>
    <th>&nbsp;</th>
</tr>
<?php   $sql1="SELECT * FROM pacchetti_servizi WHERE id_pacchetto = '$_GET[id_pacchetto]'";
        $res1=mysql_query($sql1);
        while($rows1=mysql_fetch_array($res1, MYSQL_ASSOC)){?>
        <tr>
            <td><input type="text" data-id="<?php echo $rows1["id_pacchetto_servizio"];?>" value="<?php echo $rows1["id_pacchetto_servizio"];?>"/></td>
            <td><input type="text" data-id="<?php echo $rows1["id_pacchetto_servizio"];?>" value="<?php echo $rows1["tabella_sorgente"];?>"/></td>
            <?php   $sql2="SELECT * FROM ".$rows1["tabella_sorgente"]." WHERE id_area='$rows1[id_servizio]'";
                    $res2=mysql_query($sql2);
                    $rows2=mysql_fetch_array($res2, MYSQL_ASSOC);?>
                    <td><input class="form-control" type="text" value="<?php echo utf8_encode($rows2["area"]);?>"/></td>
        </tr>
<?php }?>
</table>