<?php include("../../includes/mysql.inc.php");
include("../../includes/parameters.php");

$sql="SELECT * FROM anagraficastruttura WHERE IdAnagraficaStruttura='$_GET[id_struttura]'";
$res=mysql_query($sql);
$rows=mysql_fetch_array($res, MYSQL_ASSOC);

$RagioneSocialeStruttura=utf8_encode($rows["RagioneSocialeStruttura"]);
$LogoStruttura=utf8_encode($rows["LogoStruttura"]);

$FormaGiuridicaStruttura=utf8_encode($rows["FormaGiuridicaStruttura"]);
$IndirizzoLegaleStruttura=utf8_encode($rows["IndirizzoLegaleStruttura"]);
$CittaLegaleStruttura=utf8_encode($rows["CittaLegaleStruttura"]);
$ProvinciaLegaleStruttura=utf8_encode($rows["ProvinciaLegaleStruttura"]);
$CapLegaleStruttura=utf8_encode($rows["CapLegaleStruttura"]);

$IndirizzoOperativaStruttura=utf8_encode($rows["IndirizzoOperativaStruttura"]);
$CittaOperativaStruttura=utf8_encode($rows["CittaOperativaStruttura"]);
$ProvinciaOperativaStruttura=utf8_encode($rows["ProvinciaOperativaStruttura"]);
$CapOperativaStruttura=utf8_encode($rows["CapOperativaStruttura"]);
$RegioneStruttura=utf8_encode($rows["RegioneStruttura"]);
$NazioneStruttura=utf8_encode($rows["NazioneStruttura"]);

$Telefono1Struttura=$rows["Telefono1Struttura"];
$Telefono2Struttura=$rows["Telefono2Struttura"];
$CupStruttura=$rows["CupStruttura"];
$NumeroVerdeStruttura=$rows["NumeroVerdeStruttura"];

$EmailStruttura=trim($rows["EmailStruttura"]);
$PecStruttura=trim($rows["PecStruttura"]);

$Latitudine=trim($rows["Latitudine"]);
$Longitudine=trim($rows["Longitudine"]);
$SitoWebStruttura=trim($rows["SitoWebStruttura"]);
$CellulareTitolareStruttura=trim($rows["CellulareTitolareStruttura"]);

$CodiceFiscaleStruttura=trim($rows["CodiceFiscaleStruttura"]);
$PartitaIvaStruttura=trim($rows["PartitaIvaStruttura"]);
$CellulareTitolareStruttura=trim($rows["CellulareTitolareStruttura"]);

$NominativoPotereFirmaStruttura=utf8_encode($rows["NominativoPotereFirmaStruttura"]);
$NominativoConvenzioneStruttura=utf8_encode($rows["NominativoConvenzioneStruttura"]);
$FissoNominativoConvenzioneStruttura=trim($rows["FissoNominativoConvenzioneStruttura"]);
$CellulareNominativoConvenzioneStruttura=trim($rows["CellulareNominativoConvenzioneStruttura"]);
$EmailNominativoConvenzioneStruttura=trim($rows["EmailNominativoConvenzioneStruttura"]);

$ScontoUnicoStruttura=utf8_encode($rows["ScontoUnicoStruttura"]);
$NoteStruttura=utf8_encode($rows["NoteStruttura"]);

$accesso=$rows["accesso"];
$Categoria=utf8_encode($rows["Categoria"]);
$Provenienza=utf8_encode($rows["Provenienza"]);
$Contatto=utf8_encode($rows["Contatto"]);
$migliorsalute=$rows["migliorsalute"];
$migliorsorriso=$rows["migliorsorriso"];
$attivo=$rows["attivo"];
$SoloAree=$rows["SoloAree"];


if($rows["timestamp_conferma"]!=""){
  $data_conferma=date("d/m/Y H:i", strtotime($rows["timestamp_conferma"]));
}else{
  $data_conferma="";
}


$IdAnagraficaStruttura=$rows["IdAnagraficaStruttura"];


?>
<script>
$(document).ready(function(){

  $('form.struttura').submit(function(e) {
      e.preventDefault();
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
         // alert(returndata);
         $("#contenitore").empty().load("form/strutture/struttura_migliorsalute.php?id_struttura=<?php echo $IdAnagraficaStruttura;?>"); 
        }
      });
  });

});
</script>


<h3>Dati anagrafici</h3>

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

      <label for="FissoNominativoConvenzioneStruttura">Telefono Nominativo Convenzione Struttura</label>
      <input type="text" class="form-control" id="FissoNominativoConvenzioneStruttura" name="FissoNominativoConvenzioneStruttura" placeholder="Telefono Nominativo Convenzione Struttura"  value="<?php echo $FissoNominativoConvenzioneStruttura;?>">

      <label for="CellulareNominativoConvenzioneStruttura">Cellulare Nominativo Convenzione Struttura</label>
      <input type="text" class="form-control" id="CellulareNominativoConvenzioneStruttura" name="CellulareNominativoConvenzioneStruttura" placeholder="Cellulare Nominativo Convenzione Struttura"  value="<?php echo $CellulareNominativoConvenzioneStruttura;?>">

      <label for="EmailNominativoConvenzioneStruttura">Email Nominativo Convenzione Struttura</label>
      <input type="text" class="form-control" id="EmailNominativoConvenzioneStruttura" name="EmailNominativoConvenzioneStruttura" placeholder="Email Nominativo Convenzione Struttura"  value="<?php echo $EmailNominativoConvenzioneStruttura;?>">
    </fieldset>

    <fieldset>
      <legend><i class="fa fa-list"></i> Servizi</legend>
      <ul>
      <?php $sqls="SELECT * FROM servizi_strutture_migliorsorriso LEFT JOIN servizi_migliorsorriso ON servizi_strutture_migliorsorriso.id_contratto = servizi_migliorsorriso.id_servizio WHERE id_struttura = '$IdAnagraficaStruttura' ORDER BY tipologia";
        $ress=mysql_query($sqls);
        while($rowss=mysql_fetch_array($ress, MYSQL_ASSOC)){ ?>
          <li><?php echo $rowss["tipologia"];?></li>
        <?php } ?>
        </ul>

    </fieldset>
</form>