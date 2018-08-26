<?php 
include("../../includes/mysql.inc.php");
include("../../includes/auth.inc.php");
     
$sql="SELECT * FROM pratiche WHERE codice_attivazione='".substr($_GET["codice_attivazione"],0,15)."'";
$res=mysql_query($sql);
$rows=mysql_fetch_array($res, MYSQL_ASSOC);
$codice_attivazione=$rows["codice_attivazione"];
$validita=$rows["validita"];
$copertura=$rows["copertura"];
$data_effetto=$rows["data_effetto"];
$prezzo=$rows["importo"];


$sqlu="SELECT stampa_prodotto FROM utenti WHERE id_utente='$_SESSION[id_utente]'";
$resu=mysql_query($sqlu);
$rowsu=mysql_fetch_array($resu, MYSQL_ASSOC);

$stampa_prodotto=$rowsu["stampa_prodotto"];
?>
<script>
jQuery(document).ready(function(){
		$(".azioni_attivazione").hide();


		$(".attivazione_pratica_pulsante").on("click", function(e){
			e.preventDefault();
			
			$.post("/gestionale/actions/vendite.php",{codice_attivazione:$("#codice_attivazione").val(), stampa_prodotto:'<?php echo $stampa_prodotto;?>', action:"attiva"}, function(data){
				$(".azioni").hide();
				$(".azioni_attivazione").show();
			});
		});


		$(".stampa").on("click", function(){
			$.post("/gestionale/actions/vendite.php",{codice_attivazione:$("#codice_attivazione").val(), action:"stampa"});
		})

		$(".modifica_pratica").on("click", function(){
			$("#action").val("modifica");
		});
    	
});

</script>
<?php 
$sql1="SELECT * FROM clienti WHERE id_cliente = '$rows[id_cliente]'";
$res1=mysql_query($sql1);
$rows1=mysql_fetch_array($res1, MYSQL_ASSOC);

$nome=utf8_decode($rows1["nome"]);
$cognome=utf8_decode($rows1["cognome"]);

$sql2="SELECT comune FROM comuni_2017 WHERE cod_catastale = '$rows1[provenienza]'";
$res2=mysql_query($sql2);
$rows2=mysql_fetch_array($res2, MYSQL_ASSOC);
$provenienza=utf8_decode($rows2["comune"]);
$documento=utf8_decode($rows1["documento"]);
$data_documento=utf8_decode($rows1["data_documento"]);
$numero_documento=utf8_decode($rows1["numero_documento"]);
$nascita=utf8_decode($rows1["nascita"]);
$datanascita=utf8_decode($rows1["datanascita"]);
?>

<h3 class="modulo_attivazione">Dati invitato</h3>
<div class="form-group">
	<div class="row">
		<div class="col-xs-12 col-sm-3">
			<label for="nome">Validit&agrave;</label>
			<p><?php echo $validita;?> mesi</p>
		</div>
		<div class="col-xs-12 col-sm-3">
			<label for="copertura">Copertura</label>
			<p><?php echo $copertura;?></p>
		</div>

		<div class="col-xs-12 col-sm-3">
			<label for="data_effetto">Data effetto</label>
			<p><?php echo $data_effetto;?></p>
		</div>

		<div class="col-xs-12 col-sm-3">
			<label for="prezzo">Prezzo</label>
			<p><?php echo $prezzo;?></p>
		</div>
	</div>
</div>

<div class="form-group">
	<div class="row">
		<div class="col-xs-12 col-sm-6">
			<label for="nome">Nome</label>
			<p><?php echo $nome;?></p>
		</div>
		<div class="col-xs-12 col-sm-6">
			<label for="cognome">Cognome</label>
			<p><?php echo $cognome;?></p>
		</div>
	</div>
</div>
<div class="form-group">	
	<div class="row">
	
	<div class="col-xs-12 col-sm-4">
	<label for="provenienza">Paese di provenienza</label>
	<p><?php echo $provenienza;?></p>
	</div>

	<div class="col-xs-12 col-sm-4">
	<label>Luogo di nascita</label>
	<p><?php echo $nascita;?></p>
	</div>

	<div class="col-xs-12 col-sm-4">
	<label>Data di nascita</label>
	<p><?php echo $datanascita;?></p>
	</div>
</div>
</div>	


<div class="form-group">	
	<div class="row">
		<div class="col-xs-12 col-sm-4">
			<label for="documento">Tipologia documento</label>
			<p><?php echo $documento;?></p>
		</div>

		<div class="col-xs-12 col-sm-4">
			<label for="numero_documento">Numero documento</label>
			<p><?php echo $numero_documento;?></p>
		</div>

		<div class="col-xs-12 col-sm-4">
			<label for="data_documento">Data scadenza documento</label>
			<p><?php echo $data_documento;?></p>
		</div>
	</div>
</div>

<?php 
$sql1="SELECT * FROM invitanti WHERE id_invitante = '$rows[id_invitante]'";
$res1=mysql_query($sql1);
$rows1=mysql_fetch_array($res1, MYSQL_ASSOC);

$nome=utf8_decode($rows1["nome"]);
$cognome=utf8_decode($rows1["cognome"]);

$codicefiscale=utf8_decode($rows1["codicefiscale"]);

$indirizzo=utf8_decode($rows1["indirizzo"]);
$cap=utf8_decode($rows1["cap"]);

$sql2="SELECT comune FROM comuni_2017 WHERE cod_catastale = '$rows1[citta]'";
$res2=mysql_query($sql2);
$rows2=mysql_fetch_array($res2, MYSQL_ASSOC);
$citta=utf8_decode($rows2["comune"]);

$telefono=utf8_decode($rows1["telefono"]);
$email=utf8_decode($rows1["email"]);
?>
<h3 class="modulo_attivazione">Dati invitante</h3>
<div class="form-group">
<div class="row">
	<div class="col-xs-12 col-sm-6">
	<label for="nome_invitante">Nome</label>
					<p><?php echo $nome;?></p>
	</div>
	<div class="col-xs-12 col-sm-4">
				<label for="cognome_invitante">Cognome</label>
					<p><?php echo $cognome;?></p>
	</div>
</div>	
</div>
<div class="form-group">	
<div class="row">
	<div class="col-xs-12 col-sm-6">
	<label for="codicefiscale_invitante">Codice Fiscale</label>
	<p><?php echo $codicefiscale;?></p>

</div>
</div>

<h3 class="modulo_attivazione">Residenza o domicilio</h3>
<div class="form-group">
	<div class="row">
	<div class="col-xs-12 col-sm-4">
	<label for="viadomicilio_invitante">Indirizzo</label>
		<p><?php echo $indirizzo;?></p>
	</div>
	<div class="col-xs-12 col-sm-4">	
	<label for="domicilio_invitante">Luogo di residenza/domicilio</label>
		<p><?php echo $citta;?></p>
	</div>
	<div class="col-xs-12 col-sm-4">
	<label for="capdomicilio_invitante">CAP</label>
		<p><?php echo $cap;?></p>	
	</div>
</div>
<h3 class="modulo_attivazione">Contatti</h3>
<div class="form-group">

	<div class="row">
	<div class="col-xs-12 col-sm-6">
		<label for="email">Email</label>
		<p><?php echo $email;?></p>
	</div>
	<div class="col-xs-12 col-sm-6">
		<label for="telefono">Telefono</label>
		<p><?php echo $telefono;?></p>
	</div>
</div>
</div>


<input type="hidden" name="codice_attivazione" id="codice_attivazione" value="<?php echo $codice_attivazione;?>" />
<input type="hidden" name="id_utente" id="id_utente" value="<?php echo $_SESSION["id_utente"];?>" />

<hr />
<div class="row azioni">
	
	<div class="col-xs-12 col-sm-6">
		<button class="btn btn-danger btn-block modifica_pratica">Modifica</button>
	</div>

	<div class="col-xs-12 col-sm-6">
		<button class="btn btn-primary btn-block attivazione_pratica_pulsante">Conferma ed attiva</button>
	</div>

	
</div>


<div class="row azioni_attivazione">
	<div class="col-xs-12">
		<hr />
		<?php if($stampa_prodotto):?>
			<a data-value='<?php echo $codice_attivazione;?>' target="_blank" href="/gestionale/pdf/download.php?action=prima_stampa&codice_attivazione=<?php echo $codice_attivazione;?>" data-role="button" class="btn btn-primary btn-block stampa">Stampa il contratto</a>
		<?php else: ?>
			<p class="alert alert-info">
				La pratica è stata presa in consegna, verrà validata dalla ammistrazione e resa disponibile per la stampa.
			</p>
		<?php endif;?>
	</div>	
</div>