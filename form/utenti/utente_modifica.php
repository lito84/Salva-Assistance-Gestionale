<?php include("../../includes/mysql.inc.php");
include("../../includes/functions.php");
$sql="SELECT * FROM utenti WHERE id_utente='$_GET[id_utente]'";
$res=mysql_query($sql);
$rows=mysql_fetch_array($res, MYSQL_ASSOC);

$nome=utf8_decode($rows["nome"]);
$login=utf8_decode($rows["login"]);
$password=utf8_encode($rows["password"]);
$email=utf8_encode($rows["email"]);
$telefono=utf8_encode($rows["telefono"]);
$partitaiva=utf8_encode($rows["partitaiva"]);
$cf=utf8_encode($rows["cf"]);
$ragionesociale=utf8_encode($rows["ragionesociale"]);
$indirizzo=utf8_encode($rows["indirizzo"]);
$citta=utf8_encode($rows["citta"]);
$telefono=utf8_encode($rows["telefono"]);
$id_utente=$rows["id_utente"];
$id_ruolo=$rows["id_ruolo"];
$id_convenzione=$rows["id_convenzione"];
$agente_superiore=$rows["agente_superiore"];
$vendita=$rows["vendita"];
$percentuale=utf8_encode($rows["percentuale"]);
$stampa_prodotto=utf8_encode($rows["stampa_prodotto"]);
$aliquota=utf8_encode($rows["aliquota"]);

$data_nascita=convertiDataIT_US($rows["data_nascita"]);
?>
<script>
	$(document).ready(function(){
     $(".credenziali_inviate").hide();
     $("#ruolo").on("change", function(){
        $.post("/gestionale/actions/utenti.php",{id_ruolo:$(this).val(), action:"percentuale_provvigione"}, function(data){
          $("#percentuale").empty().val(data);
        });
       });

     $(".credenziali").on("click", function(e){
      e.preventDefault();
        $.post("/gestionale/actions/utenti.php",{id_utente:$(this).attr("data-id"), action:"credenziali"}, function(data){

          $(".credenziali_inviate").show();
        });
       });

		$(".btn-danger").bind("click", function(){
			$("#contenitore").empty().load("form/utenti/utenti.php");	
		});

   $("#citta").select2({
      placeholder: "Seleziona un comune"
   });

   $("#data_nascita").mask("99/99/9999");
   $('form.utente').submit(function(e) {
      event.preventDefault();
      //grab all form data  
      var formData = new FormData($('form.utente')[0]);
      // Main magic with files here
     // formData.append('logo', $('#logo')[0].files[0]); 

      $.ajax({
        url: 'actions/utenti.php',
        type: 'POST',
        data: formData,
        async: false,
        cache: false,
        contentType: false,
        processData: false,
        success: function (returndata) {
          $("#contenitore").empty().load("form/utenti/utenti.php"); 
        }
      });
  });

  $("#password").password();
});
</script>

<div class="col-xs-12">
<form class="utente" enctype="multipart/form-data">
  <fieldset class="form-group">
    <label for="nome">Nome Completo</label>
    <input type="text" class="form-control" id="nome" name="nome" placeholder="nome" required value="<?php echo $nome;?>">  
    <label for="nome">Login</label>
    <input type="text" class="form-control" id="login" name="login" placeholder="login" required value="<?php echo $login;?>">
    <label for="password">Password</label>
    <input type="password" class="form-control" id="password" name="password" placeholder="password" data-toggle='password' required value="<?php echo $password;?>"> 

    <label for="data_nascita">Data nascita</label>
    <input type="text" class="form-control" id="data_nascita" name="data_nascita" placeholder="gg/mm/aaaa" value="<?php echo $data_nascita;?>" />     
  </fieldset>

  <fieldset class="form-group">
    <legend>Contatti</legend>
    <label for="email">Email</label>
    <input type="text" class="form-control" id="email" name="email" placeholder="email" required value="<?php echo $email;?>">
    <label for="telefono">Telefono</label>
    <input type="text" class="form-control" id="telefono" name="telefono" placeholder="telefono" value="<?php echo $telefono;?>">  
  </fieldset>
  <fieldset class="form-group">
  <legend>Dati fatturazione</legend>
    <label for="ragionesociale">Ragione Sociale</label>
    <input type="text" class="form-control" id="ragionesociale" name="ragionesociale" placeholder="Ragione Sociale" value="<?php echo $ragionesociale;?>">
    <label for="indirizzo">Indirizzo</label>
    <input type="text" class="form-control" id="indirizzo" name="indirizzo" placeholder="Indirizzo" value="<?php echo $indirizzo;?>">
    <label for="citta">Città</label>
    <select id="citta" name="citta" class="form-control">
      <option></option>
      <?php $sql1="SELECT * FROM istat_comuni WHERE cessato='N' ORDER BY comune";
            $res1=mysql_query($sql1);
            while($rows1=mysql_fetch_array($res1, MYSQL_ASSOC)){?>
              <option value='<?php echo $rows1["cod_catastale"];?>' <?php if($citta==$rows1["cod_catastale"]) echo "selected";?>><?php echo utf8_encode($rows1["comune"]." (".$rows1["provincia"].")");?></option>
      <?php } ?>
    </select>
    <label for="partitaiva">Partita IVA</label>
    <input type="text" class="form-control" id="partitaiva" name="partitaiva" placeholder="Partitaiva" value="<?php echo $partitaiva;?>">
    <label for="cf">Codice Fiscale</label>
    <input type="text" class="form-control" id="cf" name="cf" placeholder="Codice Fiscale" value="<?php echo $cf;?>">
  </fieldset>
  
  <fieldset class="form-group">  
    <label for="ruolo">Ruolo</label>
    <select id="ruolo" name="ruolo" class="form-control" required>
      <option></option>
    <?php $sql="SELECT * FROM tipo_utenti ORDER BY tipo_contatto";
        $res=mysql_query($sql);
        while($rows=mysql_fetch_array($res, MYSQL_ASSOC)){?>
          <option value='<?php echo $rows["id_tipo_contatto"];?>' <?php if($rows["id_tipo_contatto"]==$id_ruolo) echo "selected";?>><?php echo utf8_encode($rows["tipo_contatto"]);?></option>
    <?php } ?> 
    </select>

     <label>Percentuale</label>
    <input type="text" class="form-control" id="percentuale" name="percentuale" placeholder="Percentuale provvigione" value="<?php echo $percentuale;?>">


     <label for="aliquota">Aliquota</label>
    <select id="aliquota" name="aliquota" class="form-control" required>
      <option></option>
    <?php $sql1="SELECT * FROM aliquote_agenti";
        $res1=mysql_query($sql1);
        while($rows1=mysql_fetch_array($res1, MYSQL_ASSOC)){?>
          <option value='<?php echo $rows1["id_aliquota"];?>'  <?php if($rows1["id_aliquota"]==$aliquota) echo "selected";?>><?php echo utf8_encode($rows1["descrizione"]);?></option>
    <?php } ?> 
    </select>

     <label for="agente_superiore">Agente superiore</label>

    <select id="agente_superiore" name="agente_superiore" class="form-control" required>
      <option></option>
    <?php $sql1="SELECT * FROM utenti ORDER BY nome";
        $res1=mysql_query($sql1);
        while($rows1=mysql_fetch_array($res1, MYSQL_ASSOC)){?>
          <option value='<?php echo $rows1["id_utente"];?>' <?php if($rows1["id_utente"]==$agente_superiore) echo "selected";?>><?php echo utf8_encode($rows1["nome"]);?></option>
    <?php } ?> 
    </select>

      <label for="id_convenzione">Convenzione</label>
    <select id="id_convenzione" name="id_convenzione" class="form-control" required>
      <option></option>
    <?php $sql="SELECT * FROM convenzioni ORDER BY descrizione";
        $res=mysql_query($sql);
        while($rows=mysql_fetch_array($res, MYSQL_ASSOC)){?>
          <option value='<?php echo $rows["id_convenzione"];?>' <?php if($id_convenzione==$rows["id_convenzione"]) echo "selected";?>><?php echo utf8_encode($rows["descrizione"]);?></option>
    <?php } ?> 
    </select>
    <hr />

    <div class="form-control">
      <label for="vendita">Abilita vendita diretta</label>
      <input type="checkbox" value="Y" id="vendita" name="vendita" <?php if($vendita==1) echo "checked";?> />
    </div>
    <hr />
    <div class="form-control">
      <label for="stampa_prodotto">Abilita stampa prodotto</label>
      <input type="checkbox" value="Y" id="stampa_prodotto" name="stampa_prodotto" <?php if($stampa_prodotto==1) echo "checked";?> />
    </div>

  </fieldset> 
  
  <input type="hidden" name="action" id="action" value="modifica">
  <input type="hidden" name="id_utente" id="id_utente" value="<?php echo $id_utente;?>">
  <button  class="btn btn-primary credenziali" data-id="<?php echo $id_utente;?>"><i class="fa fa-key" aria-hidden="true"></i> Invia credenziali</button>
  <button type="submit" class="btn btn-success"><i class="fa fa-check" aria-hidden="true"></i> Salva le modifiche</button>
  <button class="btn btn-danger"><i class="fa fa-times" aria-hidden="true"></i> Chiudi</button>

  <p class="alert alert-info credenziali_inviate">Credenziali inviate con successo</p>
</form>
</div>

<p>&nbsp;</p>
<p>&nbsp;</p>