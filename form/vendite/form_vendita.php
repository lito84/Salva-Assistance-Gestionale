<?php include("../../includes/mysql.inc.php");
include("../../includes/auth.inc.php");

      $sql="SELECT * FROM prodotti_convenzione_meta WHERE chiave='Beneficiari' AND id_prodotto_convenzione='$_GET[id_prodotto_convenzione]'";
      $res=mysql_query($sql);
      $rows=mysql_fetch_array($res, MYSQL_ASSOC);

      $_GET["beneficiari"]=$rows["valore"];


     $sql="SELECT *, prodotti.id_prodotto AS id_prodotto FROM convenzioni_prodotti  LEFT JOIN prodotti ON prodotti.id_prodotto = convenzioni_prodotti.id_prodotto WHERE  id_convenzione_prodotto='$_GET[id_prodotto_convenzione]'";
     $res=mysql_query($sql);
     $rows=mysql_fetch_array($res, MYSQL_ASSOC);
     $id_prodotto=$rows["id_prodotto"];

     $id_prodotto_convenzione=$_GET["id_prodotto_convenzione"];

    if($rows["id_prodotto"]=='001') $prodotto="Mezzi Sussistenza";
    if($rows["id_prodotto"]=='002') $prodotto="Spese sanitarie";
    if($rows["id_prodotto"]=='003') $prodotto="Mezzi Sussistenza + Spese sanitarie";


    if($_GET["utente_selezionato"]!=""):
    	$id_utente=$_GET["utente_selezionato"];
    else:
    	$id_utente=$_SESSION["id_utente"];
    endif;

    // $prodotto = utf8_decode($rows["prodotto"]);
?>


<script>

jQuery(document).ready(function(){

	var url = '/gestionale/uploads/documenti/index.php';

    $('#passaporto').fileupload({
        url: url,
        dataType: 'json',
        
        done: function (e, data) {
            $.each(data.result.files, function (index, file) {
           	 $("#passaporto_val").val(file.name);
           	 $('<p/>').text(file.name).appendTo('#files');
           	});
        },
        progressall: function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('.progress-bar').css(
                'width',
                progress + '%'
            );
        }
    }).prop('disabled', !$.support.fileInput)
        .parent().addClass($.support.fileInput ? undefined : 'disabled');

    $('#visto').fileupload({
        url: url,
        dataType: 'json',
        
        done: function (e, data) {
        	$.each(data.result.files, function (index, file) {
           	 $("#visto_val").val(file.name);
           	 $('<p/>').text(file.name).appendTo('#files');
           	});
        },
        progressall: function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('.progress-bar').css(
                'width',
                progress + '%'
            );
        }
    }).prop('disabled', !$.support.fileInput)
        .parent().addClass($.support.fileInput ? undefined : 'disabled');    


	
	jQuery("#loading").hide();
	jQuery(".messaggio").hide();
	jQuery(".prezzo_container").hide();
	
	
	jQuery(".comune").select2({
		placeholder:"Seleziona un comune"
	});

	jQuery("#loading").hide();
	

	jQuery(".cf_ko").hide();
	jQuery(".cf_ok").hide();
	jQuery(".cf_ko_invitante").hide();
	jQuery(".cf_ok_invitante").hide();
	
	jQuery("#codicefiscale").on("change", function(){
		jQuery(".cf_ko").hide();
		jQuery(".cf_ok").hide();
		if(jQuery(this).val().length==16){
			jQuery.post("/gestionale/actions.php",{codicefiscale:jQuery(this).val(), action:"check_cf"}, function(data){
				if(data!="NO"){
					jQuery(".cf_ok").show();

					var res = data.split("|");

					jQuery("#sesso").empty().val(res[0]);
					jQuery("#datanascita").empty().val(res[1]);
					jQuery("#nascita").empty().val(res[2]);

				}else{
					jQuery(".cf_ko").show();
				}
			})
		}
	});

	jQuery("#codicefiscale_invitante").on("change", function(){
		jQuery(".cf_ko_invitante").hide();
		jQuery(".cf_ok_invitante").hide();
		if(jQuery(this).val().length==16){
			jQuery.post("/gestionale/actions.php",{codicefiscale:jQuery(this).val(), action:"check_cf"}, function(data){
				if(data!="NO"){
					jQuery(".cf_ok_invitante").show();

					var res = data.split("|");

					jQuery("#sesso_invitante").empty().val(res[0]);
					jQuery("#datanascita_invitante").empty().val(res[1]);
					jQuery("#nascita_invitante").empty().val(res[2]);

				}else{
					jQuery(".cf_ko_invitante").show();
				}
			})
		}
	});


	jQuery("#copertura").on("change", function(){
		var prezzo=$(this).find(':selected').attr('data-prezzo');
		$("#prezzo").val(prezzo);
		$(".prezzo_container").empty().append("€ "+prezzo).show();
	})

	jQuery('form.vendita').submit(function(e) {

		e.preventDefault();

		jQuery.ajax({
        type: "POST",
        url: "/gestionale/actions/vendite.php",
        data: jQuery('form.vendita').serialize(),
        success : function(data){
                jQuery(".creazione").hide();
                jQuery(".messaggio").show();
                jQuery(".anteprima").empty().load("/gestionale/form/vendite/anteprima_pratica.php?codice_attivazione="+data);
          
        }
        });
			
	});


	jQuery('.comune').select2({
		width:"100%",
        placeholder: 'Seleziona un comune',
        ajax: {
          url: '/gestionale/autocomplete/comune.php',
          dataType: 'json',
          delay: 250,
          processResults: function (data) {
            return {
              results: data
            };
          },
          cache: true
        }
      });


	jQuery('.stato').select2({
		width:"100%",
        placeholder: 'Seleziona uno stato',
        ajax: {
          url: '/gestionale/autocomplete/stato.php',
          dataType: 'json',
          delay: 250,
          processResults: function (data) {
            return {
              results: data
            };
          },
          cache: true
        }
      });


	jQuery(".scelta_data").mask("99/99/9999");


	jQuery('form').bind("keypress", function(e) {
		  if (e.keyCode == 13) {               
		    e.preventDefault();
		    return false;
		  }
		});
    	
});

</script>


<section id="loading"><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i> <span>Attendi il caricamento del form</span></section>
                

<div class="bs-callout bs-callout-info">
<p>Hai selezionato</p>
<h4><?php echo $prodotto;?></h4>
</div>

<form class="vendita" method="post" data-toggle="validator" id="vendita">

<div class="form-group">
	<div class="row">
	<?php /*	<div class="col-xs-12 col-sm-6">
			<label for="validita">Validit&agrave; contratto</label>
			<select class="form-control" name="validita" id="validita" required>
			<option></option>
			<option value="6">6 Mesi</option>
			<option value="12">12 Mesi</option>
			</select>
		</div>

*/?>
		<div class="col-xs-12 col-sm-6">
			<label for="copertura">Durata contratto</label>
			<select class="form-control" name="copertura" id="copertura" required>
			<option></option>
			<?php 
				$sql1="SELECT * FROM tariffario WHERE id_prodotto_convenzione ='$id_prodotto_convenzione' ORDER BY mesi ASC";
				$res1=mysql_query($sql1);
				while($rows1=mysql_fetch_array($res1)):?>
					<option value="<?php echo $rows1["mesi"];?>" data-prezzo='<?php echo $rows1["prezzo"];?>'><?php echo $rows1["mesi"];?> Mesi</option>

				<?php endwhile;?>
			</select>
		</div>

		<div class="col-xs-12 col-sm-6">
			<label for="data_effetto">Data effetto</label>
			<input id="data_effetto" name="data_effetto" value="" required class="required form-control scelta_data" placeholder="gg/mm/aaaa">
		</div>		
	</div>

	<div class="col-xs-12">
		<p class="alert alert-info prezzo_container"></p>
	</div>
</div>



<h3 class="modulo_attivazione">Dati invitato</h3>
<div class="form-group">
	<div class="row">
		<div class="col-xs-12 col-sm-6">
			<label for="cognome">Cognome</label>
			<input id="cognome" name="cognome" value="" required class="required form-control">
			
		</div>

		<div class="col-xs-12 col-sm-6">
			<label for="nome">Nome</label>
			<input id="nome" name="nome" value="" required class="required form-control">
		</div>
		
	</div>
</div>
<div class="form-group">	
	<div class="row">
	
	<div class="col-xs-12 col-sm-4">
	<label for="provenienza">Paese di provenienza</label>
	<select id="provenienza" name="provenienza" required class="stato required">
			<option></option>
	</select>
	</div>

	
	<div class="col-xs-12 col-sm-4">
		<label for="nascita">Luogo di Nascita</label>
		<input id="nascita" name="nascita" value="" required class="required form-control">
	</div>
	<div class="col-xs-12 col-sm-4">
		<label for="datanascita">Data di Nascita</label>
		<input id="datanascita" name="datanascita" value="" required class="required form-control scelta_data" placeholder="gg/mm/aaaa">
		
	</div>
	

<?php /*	
<div class="col-xs-12 col-sm-6">
	<label for="codicefiscale">Codice Fiscale</label>
	<input id="codicefiscale" name="codicefiscale" value="" required  class="form-control" maxlength="16" data-minlength="16" data-maxlength="16" data-error="Codice Fiscale di 16 caratteri ">
	<div class="help-block with-errors"></div>
	<div class="cf_ok alert alert-success">Codice Fiscale formalmente corretto</div>
	<div class="cf_ko alert alert-danger">Codice Fiscale formalmente NON corretto</div>
</div>
*/?>
</div>
</div>	


<div class="form-group">	
	<div class="row">
		<div class="col-xs-12 col-sm-4">
			<label for="documento">Tipologia documento</label>
			<input id="documento" name="documento" value="Passaporto" required  class="form-control">
		</div>

		<div class="col-xs-12 col-sm-4">
			<label for="numero_documento">Numero documento</label>
			<input id="numero_documento" name="numero_documento" value="" required  class="form-control">
		</div>

		<div class="col-xs-12 col-sm-4">
			<label for="data_documento">Data scadenza documento</label>
			<input id="data_documento" name="data_documento" value="" required  class="form-control scelta_data" placeholder="gg/mm/aaaa">
		</div>
	</div>
</div>


<div class="form-group">	
	<div class="row">
		<div class="col-xs-6">
			<label>Passaporto</label>	
				<span class="btn btn-success fileinput-button form-control">
		        <i class="glyphicon glyphicon-plus"></i>
		        <span>Trascina file qui...</span>
		        <!-- The file input field used as target for the file upload widget -->
		        <input id="passaporto" type="file" name="files[]" class="fileupload" multiple>
		    	</span>
		    <!-- The global progress bar -->
		    <input type="hidden" id="passaporto_val" name="passaporto_val" />
		</div>


		<div class="col-xs-6">
			<label>Visto</label>	
				<span class="btn btn-success fileinput-button form-control">
		        <i class="glyphicon glyphicon-plus"></i>
		        <span>Trascina file qui...</span>
		        <!-- The file input field used as target for the file upload widget -->
		        <input id="visto" type="file" name="files[]" class="fileupload" multiple>
		    	</span>
		    <!-- The global progress bar -->
		    <input type="hidden" id="visto_val" name="visto_val" />
		</div>
		<div class="col-xs-12">
			<hr />
			<div id="progres" class="progress">
		        <div class="progress-bar progress-bar-success"></div>
		        
		    </div>
		     <div id="files" class="files"></div>
		</div>
</div>


<h3 class="modulo_attivazione">Dati invitante</h3>
<div class="form-group">
<div class="row">
	
	<div class="col-xs-12 col-sm-6">
			<label for="cognome_invitante">Cognome</label>
			<input id="cognome_invitante" name="cognome_invitante" value="" required class="required form-control">
	</div>
	<div class="col-xs-12 col-sm-6">
		<label for="nome_invitante">Nome</label>
		<input id="nome_invitante" name="nome_invitante" value="" required class="required form-control">
	</div>
	
</div>
<input type="hidden" id="datanascita_invitante" name="datanascita_invitante" value="" type="text">
<input type="hidden" id="nascita_invitante" name="nascita_invitante" value="" type="text">	
<input type="hidden" id="sesso_invitante" name="sesso_invitante" value="" type="text">	
	
	
</div>
<div class="form-group">	
<div class="row">
	<div class="col-xs-12 col-sm-6">
	<label for="codicefiscale_invitante">Codice Fiscale</label>
	<input id="codicefiscale_invitante" name="codicefiscale_invitante" value="" required  class="form-control" maxlength="16" data-minlength="16" data-maxlength="16" data-error="Codice Fiscale di 16 caratteri ">
	<div class="help-block with-errors"></div>
	<div class="cf_ok_invitante alert alert-success">Codice Fiscale formalmente corretto</div>
	<div class="cf_ko_invitante alert alert-danger">Codice Fiscale formalmente NON corretto</div>
	</div>

</div>
</div>





<h3 class="modulo_attivazione">Residenza o domicilio</h3>
<div class="form-group">
	<div class="row">
	<div class="col-xs-12 col-sm-4">
	<label for="viadomicilio_invitante">Indirizzo</label>
		<input id="viadomicilio_invitante" name="viadomicilio_invitante" value="" required class="required form-control">
	</div>
	<div class="col-xs-12 col-sm-4">	
	<label for="domicilio_invitante">Luogo di residenza/domicilio</label>
		<select id="domicilio_invitante" name="domicilio_invitante" required class="comune required form-control">
			<option></option>
			<?php 	
					$res1=mysql_query($sql);
					while($rows=mysql_fetch_array($res1, MYSQL_ASSOC)){?>
					<option value="<?php echo $rows["cod_istat"];?>"><?php echo utf8_encode($rows["comune"]." (".$rows["sigla"].")");?></option>
			<?php }
			?>
		</select>
	</div>
	<div class="col-xs-12 col-sm-4">
	<label for="capdomicilio_invitante">CAP</label>
		<input id="capdomicilio_invitante" name="capdomicilio_invitante" value="" required class="required form-control">	
	</div>
</div>
<h3 class="modulo_attivazione">Contatti</h3>
<div class="form-group">

	<div class="row">
	<div class="col-xs-12 col-sm-6">
		<label for="email">Email</label>
		<input id="email" name="email" value="" type="email" required class="required form-control">
	</div>
	<div class="col-xs-12 col-sm-6">
		<label for="telefono">Telefono</label>
		<input id="telefono" name="telefono" value="" class="form-control">
	</div>
</div>
</div>


<input type="hidden" name="id_convenzione_prodotto" id="id_convenzione_prodotto" value="<?php echo $_GET["id_prodotto_convenzione"];?>" />
<input type="hidden" name="id_utente" id="id_utente" value="<?php echo $id_utente;?>" />
<input type="hidden" name="prezzo" id="prezzo" value="" />

<input type="hidden" name="action" id="action" value="crea_pratica">

<hr />
<input type="submit" id="submit" value="Invia" class="btn btn-primary btn-block creazione">

</form>

<div class="row">
	<div class="col-xs-12">
		<hr/>

		<div class="alert alert-info messaggio">
		<p>Controlla l'anteprima della pratica</p>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-xs-12">
		<div class="anteprima">
		</div>
	</div>
</div>
