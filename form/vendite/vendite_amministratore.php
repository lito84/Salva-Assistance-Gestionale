<?php include("../../includes/auth.inc.php");?>
<?php include("../../includes/mysql.inc.php");?>
<script>
$(document).ready(function(){

    $("#agente").on("change", function(){

        var id_utente = $(this).find('option:selected').attr("data-utente");
        $("#contenitore").empty().load("form/vendite/convenzione_vendita.php?id_convenzione="+$(this).val()+"&utente_selezionato="+id_utente);
    });
    
});
</script>

<label>Selezione Agente</label>
<select id="agente" name="agente" class="form-control">
    <option></option>
    <?php $sql="SELECT * FROM utenti WHERE attivo ORDER BY nome";
        $res=mysql_query($sql);
        while($rows=mysql_fetch_array($res, MYSQL_ASSOC)):?>
        <option value="<?php echo $rows["id_convenzione"];?>" data-utente="<?php echo $rows["id_utente"];?>"><?php echo utf8_encode($rows["nome"]);?></option>  
    <?php  
        endwhile;
    ?>
</select>