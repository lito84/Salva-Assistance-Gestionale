<?php include("../../includes/mysql.inc.php");

?>
<script>
$(document).ready(function(){

   $('form.struttura').submit(function(e) {
      event.preventDefault();
      //grab all form data  
      var formData = new FormData($('form.struttura')[0]);
      $.ajax({
        url: 'actions/strutture_migliorsalute.php',
        type: 'POST',
        data: formData,
        async: false,
        cache: false,
        contentType: false,
        processData: false,
        success: function (returndata) {
         $("#contenitore").empty().load("form/strutture/strutture.php"); 
        }
      });
  });


});
</script>


<form class="struttura">
    <fieldset class="form-group">
    
    <label for="RagioneSocialeStruttura">Ragione Sociale</label>
    <input type="text" class="form-control" id="RagioneSocialeStruttura" name="RagioneSocialeStruttura" placeholder="Ragione Sociale Struttura"  value="<?php echo $RagioneSocialeStruttura;?>"> 
    </fieldset>
    <fieldset class="form-group">
    
    <legend><i class="fa fa-map-marker"></i> Localizzazione</legend>


    <label for="IndirizzoOperativaStruttura">Indirizzo</label>
    <input type="text" class="form-control" id="IndirizzoOperativaStruttura" name="IndirizzoOperativaStruttura" placeholder="Indirizzo Operativa Struttura"  value="<?php echo $IndirizzoOperativaStruttura;?>">

    <label for="CittaOperativaStruttura">Citt&agrave;</label>
    <input type="text" class="form-control" id="CittaOperativaStruttura" name="CittaOperativaStruttura" placeholder="Citt&agrave; Operativa Struttura"  value="<?php echo $CittaOperativaStruttura;?>"> 

    <label for="ProvinciaOperativaStruttura">Provincia</label>
    <input type="text" class="form-control" id="ProvinciaOperativaStruttura" name="ProvinciaOperativaStruttura" placeholder="Provincia Operativa Struttura"  value="<?php echo $ProvinciaOperativaStruttura;?>"> 

    <label for="RegioneStruttura">Regione</label>
    <input type="text" class="form-control" id="RegioneStruttura" name="RegioneStruttura" placeholder="Regione Struttura"  value="<?php echo $RegioneStruttura;?>">
    <label for="NazioneStruttura">Nazione</label>
    <input type="text" class="form-control" id="NazioneStruttura" name="NazioneStruttura" placeholder="Nazione Struttura"  value="<?php echo $NazioneStruttura;?>">

    <label for="Latitudine">Latitudine</label>
    <input type="text" class="form-control" id="Latitudine" name="Latitudine" placeholder="Latitudine"  value="<?php echo $Latitudine;?>">

    <label for="Longitudine">Longitudine</label>
    <input type="text" class="form-control" id="Longitudine" name="Longitudine" placeholder="Longitudine"  value="<?php echo $Longitudine;?>"> 

    </fieldset>

    <fieldset class="form-group">
    
    <legend><i class="fa fa-address-card"></i> Contatti</legend>


    <label for="Telefono1Struttura">Telefono 1</label>
    <input type="text" class="form-control" id="Telefono1Struttura" name="Telefono1Struttura" placeholder="Telefono 1"  value="<?php echo $Telefono1Struttura;?>">
    
    <label for="Telefono2Struttura">Telefono 2</label>
    <input type="text" class="form-control" id="Telefono2Struttura" name="Telefono2Struttura" placeholder="Telefono 2"  value="<?php echo $Telefono2Struttura;?>">

    <label for="CupStruttura">CUP</label>
    <input type="text" class="form-control" id="CupStruttura" name="CupStruttura" placeholder="CUP"  value="<?php echo $CupStruttura;?>">

    <label for="CellulareTitolareStruttura">Cellulare Titolare Struttura</label>
    <input type="text" class="form-control" id="CellulareTitolareStruttura" name="CellulareTitolareStruttura" placeholder="Cellulare Titolare Struttura"  value="<?php echo $CellulareTitolareStruttura;?>">

    <label for="NumeroVerdeStruttura">Numero verde</label>
    <input type="text" class="form-control" id="NumeroVerdeStruttura" name="NumeroVerdeStruttura" placeholder="Numero Verde"  value="<?php echo $NumeroVerdeStruttura;?>">

    <label for="EmailStruttura">Email struttura</label>
    <input type="text" class="form-control" id="EmailStruttura" name="EmailStruttura" placeholder="Email struttura"  value="<?php echo $EmailStruttura;?>">
    
    <label for="PecStruttura">Pec struttura</label>
    <input type="text" class="form-control" id="PecStruttura" name="PecStruttura" placeholder="Pec struttura"  value="<?php echo $PecStruttura;?>">


    <label for="SitoWebStruttura">Sito web</label>
    <input type="text" class="form-control" id="SitoWebStruttura" name="SitoWebStruttura" placeholder="Sito web"  value="<?php echo $SitoWebStruttura;?>">

    </fieldset>

    <fieldset class="form-group">
      <legend><i class="fa fa-group"></i> Responsabile</legend>

      <label for="NominativoConvenzioneStruttura">Nominativo Convenzione Struttura</label>
      <input type="text" class="form-control" id="NominativoConvenzioneStruttura" name="NominativoConvenzioneStruttura" placeholder="Nominativo Convenzione Struttura"  value="<?php echo $NominativoConvenzioneStruttura;?>">

       <label for="ResponsabileStruttura">Responsabile Struttura</label>
      <input type="text" class="form-control" id="ResponsabileStruttura" name="ResponsabileStruttura" placeholder="Responsabile Struttura"  value="<?php echo $ResponsabileStruttura;?>">

      <label for="FissoNominativoConvenzioneStruttura">Telefono Nominativo Convenzione Struttura</label>
      <input type="text" class="form-control" id="FissoNominativoConvenzioneStruttura" name="FissoNominativoConvenzioneStruttura" placeholder="Telefono Nominativo Convenzione Struttura"  value="<?php echo $FissoNominativoConvenzioneStruttura;?>">

      <label for="CellulareNominativoConvenzioneStruttura">Cellulare Nominativo Convenzione Struttura</label>
      <input type="text" class="form-control" id="CellulareNominativoConvenzioneStruttura" name="CellulareNominativoConvenzioneStruttura" placeholder="Cellulare Nominativo Convenzione Struttura"  value="<?php echo $CellulareNominativoConvenzioneStruttura;?>">

      <label for="EmailNominativoConvenzioneStruttura">Email Nominativo Convenzione Struttura</label>
      <input type="text" class="form-control" id="EmailNominativoConvenzioneStruttura" name="EmailNominativoConvenzioneStruttura" placeholder="Email Nominativo Convenzione Struttura"  value="<?php echo $EmailNominativoConvenzioneStruttura;?>">
    </fieldset>
    
  
    <fieldset class="form-group">
    <legend><i class="fa fa-share-alt"></i> Appartenenza</legend>

    <label for="Provenienza">Provenienza</label>
    <input type="text" class="form-control" id="Provenienza" name="Provenienza" placeholder="Provenienza"  value="<?php echo $Provenienza;?>">

    <label for="DataConfermaConvenzione">Data conferma convenzione</label>
    <input type="text" class="form-control" id="DataConfermaConvenzione" name="DataConfermaConvenzione" placeholder="Data conferma convenzione"  value="<?php echo $data_conferma;?>">

     <label for="stato">Stato</label>
    <input type="text" class="form-control" id="stato" name="stato" placeholder="Stato"  value="<?php echo $Stato;?>">


    </fieldset>

  
  <input type="hidden" name="action" id="action" value="inserisci">
  <input type="hidden" name="IdAnagraficaStruttura" id="IdAnagraficaStruttura" value="<?php echo $IdAnagraficaStruttura;?>">
  <button type="submit" class="btn btn-primary"><i class="fa fa-check" aria-hidden="true"></i></button>
  <button class="btn btn-danger"><i class="fa fa-times" aria-hidden="true"></i></button>
</form>
</div>