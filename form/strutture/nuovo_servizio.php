<?php include("../../includes/mysql.inc.php"); ?>

<script>
$(document).ready(function(){
	$(".loading").hide();
	$(".chosen").chosen();
	$("#area").on("change", function(){
		$(".loading").show();	
		$("#servizio_esistente_container").empty();
		$.post("actions/servizi.php", {area:$(this).val(), action:"trova_servizi"}, function(data){
				$("#servizio_esistente_container").html(data);
				$(".servizio_esistente").chosen();
				$(".loading").hide(); 
		});
		
	});

	$(".salva-servizio").on("click", function(){
		$.post("actions/servizi.php",{id_area:$("#area").val(), servizio:$(".servizio_esistente").val(), nuovo_servizio:$("#nuovo_servizio").val(), sconto:$("#sconto").val(), prezzo_listino:$("#prezzo_listino").val(), prezzo_scontato:$("#prezzo_scontato").val(), id_struttura:"<?php echo $_GET["id_struttura"];?>", action:"aggiungi_servizio"}, function(data){
				$(".contenitore_servizi").empty().load("form/strutture/servizi.php?id_struttura=<?php echo $_GET["id_struttura"];?>");
		})
	});
});	
</script>
<fieldset class="form-group">
<legend>Nuovo servizio</legend>
<div class="row">
<div class="col-xs-2">
<label>Area</label>
</div>
<div class="col-xs-10">
<select id="area" name="area" class="chosen">
<option>Seleziona un area</option>
	<?php $sql="SELECT * FROM aree_servizi ORDER BY area";
			$res=mysql_query($sql);
			while($rows=mysql_fetch_array($res, MYSQL_ASSOC)){?>
				<option value="<?php echo $rows["id_area"];?>"><?php echo utf8_encode($rows["area"]);?></option>
	<?php } ?>
</select>
</div>
</div>
<div class="row">
<div class="loading"><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i></div>
<div id="servizio_esistente_container" name="servizio_esistente_container"></div>
</div>
<div class="row">
	<div class="col-xs-2">
		<label>Nuovo servizio</label>
	</div>
	<div class="col-xs-10">
		<input type="text" id="nuovo_servizio" name="nuovo_servizio" class="form-control">
	</div>
</div>

<div class="row">
	<div class="col-xs-2">
		<label>Sconto %</label>
	</div>
	<div class="col-xs-10">
		<input type="text" id="sconto" name="sconto" class="form-control">
	</div>
</div>

<div class="row">
	<div class="col-xs-2">
		<label>Prezzo listino</label>
	</div>
	<div class="col-xs-10">
		<input type="text" id="prezzo_listino" name="prezzo_listino" class="form-control">
	</div>
</div>

<div class="row">
	<div class="col-xs-2">
		<label>Prezzo scontato</label>
	</div>
	<div class="col-xs-10">
		<input type="text" id="prezzo_scontato" name="prezzo_scontato" class="form-control">
	</div>
</div>
</fieldset>

<fieldset class="form-group">
	<button class="btn btn-success salva-servizio">Salva</button>
</fieldset>
