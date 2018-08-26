<?php include("../../includes/mysql.inc.php");
function generateRandomString($length = 8) {
    $characters = '123456789BCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnoprstuwxyz';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

?>
<script>
	$(document).ready(function(){
		$(".btn-danger").bind("click", function(){
			$("#contenitore").empty().load("form/utenti/utenti.php");	
		});

   $("#citta").select2({
      placeholder: "Seleziona un comune"
   });


   $("#ruolo").on("change", function(){
    $.post("/gestionale/actions/utenti.php",{id_ruolo:$(this).val(), action:"percentuale_provvigione"}, function(data){
      $("#percentuale").empty().val(data);
    });
   });

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

});
</script>

<div class="col-xs-12">
<form class="utente" enctype="multipart/form-data" >
  <fieldset class="form-group">
    <label for="nome">Nome Completo</label>
    <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome" required>  
    <label for="nome">Login</label>
    <input type="text" class="form-control" id="login" name="login" placeholder="Login" required>
    <label for="password">Password</label>
    <input type="text" class="form-control" id="password" name="password" placeholder="Password" required value="<?php echo generateRandomString();?>">    
  </fieldset>

  <fieldset class="form-group">
    <legend>Contatti</legend>
    <label for="email">Email</label>
    <input type="text" class="form-control" id="email" name="email" placeholder="Email" required>
    <label for="telefono">Telefono</label>
    <input type="text" class="form-control" id="telefono" name="telefono" placeholder="Telefono">  
  </fieldset>
  <fieldset class="form-group">
  <legend>Dati fatturazione</legend>
    <label for="ragionesociale">Ragione Sociale</label>
    <input type="text" class="form-control" id="ragionesociale" name="ragionesociale" placeholder="Ragione Sociale">
    <label for="indirizzo">Indirizzo</label>
    <input type="text" class="form-control" id="indirizzo" name="indirizzo" placeholder="Indirizzo">
    <label for="citta">Città</label>
    <select id="citta" name="citta" class="form-control">
      <option></option>
      <?php $sql1="SELECT * FROM istat_comuni WHERE cessato='N' ORDER BY comune";
            $res1=mysql_query($sql1);
            while($rows1=mysql_fetch_array($res1, MYSQL_ASSOC)){?>
              <option value='<?php echo $rows1["cod_catastale"];?>'><?php echo utf8_encode($rows1["comune"]." (".$rows1["provincia"].")");?></option>
      <?php } ?>
    </select>
    <label for="partitaiva">Partita IVA</label>
    <input type="text" class="form-control" id="partitaiva" name="partitaiva" placeholder="Partita IVA">
    <label for="cf">Codice Fiscale</label>
    <input type="text" class="form-control" id="cf" name="cf" placeholder="Codice Fiscale">
  </fieldset>
  
  <fieldset class="form-group">  
    <label for="ruolo">Ruolo</label>
    <select id="ruolo" name="ruolo" class="form-control" required>
      <option></option>
    <?php $sql="SELECT * FROM tipo_utenti ORDER BY tipo_contatto";
        $res=mysql_query($sql);
        while($rows=mysql_fetch_array($res, MYSQL_ASSOC)){?>
          <option value='<?php echo $rows["id_tipo_contatto"];?>'><?php echo utf8_encode($rows["tipo_contatto"]);?></option>
    <?php } ?> 
    </select>
    <label>Percentuale</label>
    <input type="text" class="form-control" id="percentuale" name="percentuale" placeholder="Percentuale provvigione">
    
    
    <label for="aliquota">Aliquota</label>
    <select id="aliquota" name="aliquota" class="form-control" required>
      <option></option>
    <?php $sql="SELECT * FROM aliquote_agenti";
        $res=mysql_query($sql);
        while($rows=mysql_fetch_array($res, MYSQL_ASSOC)){?>
          <option value='<?php echo $rows["id_aliquota"];?>'><?php echo utf8_encode($rows["descrizione"]);?></option>
    <?php } ?> 
    </select>


    <label for="agente_superiore">Agente superiore</label>
    <select id="agente_superiore" name="agente_superiore" class="form-control" required>
      <option></option>
    <?php $sql="SELECT * FROM utenti ORDER BY nome";
        $res=mysql_query($sql);
        while($rows=mysql_fetch_array($res, MYSQL_ASSOC)){?>
          <option value='<?php echo $rows["id_utente"];?>'><?php echo utf8_encode($rows["nome"]);?></option>
    <?php } ?> 
    </select>

     <label for="id_convenzione">Convenzione</label>
    <select id="id_convenzione" name="id_convenzione" class="form-control" required>
      <option></option>
    <?php $sql="SELECT * FROM convenzioni ORDER BY descrizione";
        $res=mysql_query($sql);
        while($rows=mysql_fetch_array($res, MYSQL_ASSOC)){?>
          <option value='<?php echo $rows["id_convenzione"];?>'><?php echo utf8_encode($rows["descrizione"]);?></option>
    <?php } ?> 
    </select>



    <hr />
  <div class="form-control">
    <label for="vendita">Abilita vendita diretta</label>
    <input type="checkbox" value="Y" id="vendita" name="vendita" />
  </div>
<hr />
  <div class="form-control">
    <label for="stampa_prodotto">Abilita stampa prodotto</label>
    <input type="checkbox" value="Y" id="stampa_prodotto" name="stampa_prodotto" />
  </div>
  </fieldset>
  
  
  <input type="hidden" name="action" id="action" value="inserisci">
  <button type="submit" class="btn btn-primary"><i class="fa fa-check" aria-hidden="true"></i> Salva</button>
  <button class="btn btn-danger"><i class="fa fa-times" aria-hidden="true"></i> Esci</button>
</form>
</div>

<p>&nbsp;</p>
<p>&nbsp;</p>