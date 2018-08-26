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
$ResponsabileStruttura=utf8_encode($rows["ResponsabileStruttura"]);
$NominativoPotereFirmaStruttura=utf8_encode($rows["NominativoPotereFirmaStruttura"]);
$NominativoConvenzioneStruttura=utf8_encode($rows["NominativoConvenzioneStruttura"]);
$FissoNominativoConvenzioneStruttura=trim($rows["FissoNominativoConvenzioneStruttura"]);
$CellulareNominativoConvenzioneStruttura=trim($rows["CellulareNominativoConvenzioneStruttura"]);
$EmailNominativoConvenzioneStruttura=trim($rows["EmailNominativoConvenzioneStruttura"]);


$Stato=utf8_encode($rows["stato"]);
if($rows["data_stato"]!="" ){
$data_stato=date("d/m/Y H:i", strtotime($rows["data_stato"]));
}
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
$tariffario_pdf=$rows["tariffario_pdf"];
$convenzione_pdf=$rows["convenzione_pdf"];
$data_tariffario=$rows["data_tariffario"];
$data_convenzione=$rows["data_convenzione"];
$da_cancellare=$rows["da_cancellare"];
$convenzione_confermata=$rows["convenzione_confermata"];

if($rows["timestamp_conferma"]!="" && $rows["timestamp_conferma"]!=" "){
  $timestamp_conferma=date("d/m/Y H:i", strtotime($rows["timestamp_conferma"]));
}

$servizi_confermati=$rows["servizi_confermati"];
if($rows["timestamp_servizi_confermati"]!=""  && $rows["timestamp_servizi_confermati"]!=" "){
$timestamp_servizi_confermati=date("d/m/Y H:i", strtotime($rows["timestamp_servizi_confermati"]));
}
$note_stato=utf8_encode($rows["note_stato"]);
$note_convenzione=utf8_encode($rows["note_convenzione"]);
$IdAnagraficaStruttura=$rows["IdAnagraficaStruttura"];


?>

<script>PDFObject.embed("<?php echo $p_sito;?>uploads/tariffari/files/<?php echo $tariffario_pdf;?>", "#pdf_container",{height:"500px"});</script>

<script>
$(document).ready(function(){

  $("#note_stato").on("keyup", function(){
    $.post("actions/strutture_migliorsalute.php",{id_struttura:'<?php echo $IdAnagraficaStruttura;?>',note_stato:$(this).val(), action:"note_stato"});
  });

  $("#ScontoUnicoStruttura").on("keyup", function(){
    $.post("actions/strutture_migliorsalute.php",{id_struttura:'<?php echo $IdAnagraficaStruttura;?>',ScontoUnicoStruttura:$(this).val(), action:"ScontoUnicoStruttura"});
  });
  $("#stampa_scheda").bind("click", function(){
    window.open("http://migliorsalute.it/pdf/MS_scheda_ridotta.php?code=<?php echo md5($IdAnagraficaStruttura);?>","_blank");
  });

  $("#invia_adesione").bind("click", function(){
    $.post("actions/strutture.php", {id_anagrafica:'<?php echo $IdAnagraficaStruttura;?>', action:"invia_adesione"}, function(){
      alert("Email inviata");
    });
  });

  $("#invia_adesione_lettera").bind("click", function(){
    $.post("actions/strutture.php", {id_anagrafica:'<?php echo $IdAnagraficaStruttura;?>', action:"invia_adesione_lettera"}, function(){
      alert("Email inviata");
    });
  });

  $("#genera_adesione").bind("click", function(){
    window.open("http://www.migliorsalute.it/conferma-strutture/index.php?code=<?php echo md5($IdAnagraficaStruttura);?>","_blank");
  });


   $(".servizi").on("change", function(){
      var selezione=0;
      if($(this).is(":checked")){
        selezione=1;
      }
     $.post("actions/strutture_migliorsalute.php",{id_struttura:'<?php echo $IdAnagraficaStruttura;?>', selezione:selezione, tipo:$(this).attr("data-tipo"), valore:$(this).attr("data-value"), action:"pacchetto"});

   });


   $(".elimina_struttura_confirm").on("click", function(){
      $.post("actions/strutture_migliorsalute.php",{id_struttura:'<?php echo $IdAnagraficaStruttura;?>', action:"elimina_struttura"}, function(){
      $("#myModalElimina").modal('toggle');
       location.reload();
      })
   });

   $(".disattiva_struttura_confirm").on("click", function(){
      $.post("actions/strutture_migliorsalute.php",{id_struttura:'<?php echo $IdAnagraficaStruttura;?>', action:"disabilita_struttura"}, function(){
      $("#myModalDisattiva").modal('toggle');
       location.reload();
      })
   });
   
   $("#da_cancellare").on("change", function(){
    var da_cancellare=0;
      if($(this).is(":checked")){
        da_cancellare=1;
      }
      $.post("actions/strutture_migliorsalute.php",{id_struttura:'<?php echo $IdAnagraficaStruttura;?>', da_cancellare:da_cancellare, action:"da_cancellare"});
   });

  $(".contenitore_servizi").load("form/strutture/servizi.php?id_struttura=<?php echo $IdAnagraficaStruttura;?>");

  var url = '<?php echo $p_sito;?>uploads/loghi/index.php';
    $('#fileupload').fileupload({
        url: url,
        dataType: 'json',
        done: function (e, data) {
            $.each(data.result.files, function (index, file) {
               $.post("actions/strutture_migliorsalute.php",{file:file.name, id_struttura:'<?php echo $IdAnagraficaStruttura;?>',action:"logo"});
          $('<p/>').text(file.name).appendTo('#files');
      });
        },
        progressall: function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('#progress .progress-bar').css(
                'width',
                progress + '%'
            );
        }
    }).prop('disabled', !$.support.fileInput)
        .parent().addClass($.support.fileInput ? undefined : 'disabled');


   var url = '<?php echo $p_sito;?>uploads/tariffari/index.php';
    $('#fileuploadtariffario').fileupload({
        url: url,
        dataType: 'json',
        done: function (e, data) {
            $.each(data.result.files, function (index, file) {
               $.post("actions/strutture_migliorsalute.php",{file:file.name, id_struttura:'<?php echo $IdAnagraficaStruttura;?>',action:"tariffario"});
          $('<p/>').text(file.name).appendTo('#filestariffario');
      });
        },
        progressall: function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('#progresstariffario .progress-bar').css(
                'width',
                progress + '%'
            );
        }
    }).prop('disabled', !$.support.fileInput)
        .parent().addClass($.support.fileInput ? undefined : 'disabled');


        var url = '<?php echo $p_sito;?>uploads/convenzioni/index.php';
        $('#fileuploadconvenzione').fileupload({
            url: url,
            dataType: 'json',
            done: function (e, data) {
                $.each(data.result.files, function (index, file) {
                   $.post("actions/strutture_migliorsalute.php",{file:file.name, id_struttura:'<?php echo $IdAnagraficaStruttura;?>',action:"convenzione"});
              $('<p/>').text(file.name).appendTo('#filesconvenzione');
          });
            },
            progressall: function (e, data) {
                var progress = parseInt(data.loaded / data.total * 100, 10);
                $('#progressconvenzione .progress-bar').css(
                    'width',
                    progress + '%'
                );
            }
        }).prop('disabled', !$.support.fileInput)
            .parent().addClass($.support.fileInput ? undefined : 'disabled');

  
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




<ul class="nav nav-tabs">
  <li class="active"><a href="#1" data-toggle="tab">Dati Anagrafici</a></li>
  <li><a href="#2" data-toggle="tab">Dati Legali</a></li>
  <li><a href="#3" data-toggle="tab">Logo</a></li>
  <li><a href="#4" data-toggle="tab">Servizi</a></li>
  <li><a href="#5" data-toggle="tab">Tariffario PDF</a></li>
   <li><a href="#6" data-toggle="tab">Pacchetti</a></li>
  <li><a href="#7" data-toggle="tab">Dati convenzione</a></li>
</ul>


<div class="tab-content ">
    


    <div class="tab-pane active" id="1">

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
    <div class="row">
      <div class="col-xs-11">
    <input type="text" class="form-control" id="Telefono1Struttura" name="Telefono1Struttura" placeholder="Telefono 1"  value="<?php echo $Telefono1Struttura;?>">
    </div>
    <div class="col-xs-1">
      <a href="tel:<?php echo $Telefono1Struttura;?>" data-role='button' class='btn btn-warning'><i class="fa fa-phone"></i></a>
    </div>
  </div>
    <label for="Telefono2Struttura">Telefono 2</label>
    <input type="text" class="form-control" id="Telefono2Struttura" name="Telefono2Struttura" placeholder="Telefono 2"  value="<?php echo $Telefono2Struttura;?>">

    <label for="CupStruttura">CUP</label>
    <input type="text" class="form-control" id="CupStruttura" name="CupStruttura" placeholder="CUP"  value="<?php echo $CupStruttura;?>">

    <label for="CellulareTitolareStruttura">Cellulare Titolare Struttura</label>
    <input type="text" class="form-control" id="CellulareTitolareStruttura" name="CellulareTitolareStruttura" placeholder="Cellulare Titolare Struttura"  value="<?php echo $CellulareTitolareStruttura;?>">

    <label for="NumeroVerdeStruttura">Numero verde</label>
    <input type="text" class="form-control" id="NumeroVerdeStruttura" name="NumeroVerdeStruttura" placeholder="Numero Verde"  value="<?php echo $NumeroVerdeStruttura;?>">

    <label for="EmailStruttura">Email struttura</label>
    <div class="row">    
      <div class="col-xs-11">
        <input type="text" class="form-control" id="EmailStruttura" name="EmailStruttura" placeholder="Email struttura"  value="<?php echo $EmailStruttura;?>">
      </div>
      <div class="col-xs-1">
        <a href="mailto:<?php echo $EmailStruttura;?>" data-role='button' class='btn btn-warning'><i class="fa fa-envelope"></i></a>
      </div>
    </div>
    <label for="PecStruttura">Pec struttura</label>
    <input type="text" class="form-control" id="PecStruttura" name="PecStruttura" placeholder="Pec struttura"  value="<?php echo $PecStruttura;?>">


    <label for="SitoWebStruttura">Sito web</label>
    <input type="text" class="form-control" id="SitoWebStruttura" name="SitoWebStruttura" placeholder="Sito web"  value="<?php echo $SitoWebStruttura;?>">

    </fieldset>

    <fieldset class="form-group">
      <legend><i class="fa fa-group"></i> Nominativi</legend>


      <label for="NominativoPotereFirmaStruttura">Nominativo Potere Firma Struttura</label>
      <input type="text" class="form-control" id="NominativoPotereFirmaStruttura" name="NominativoPotereFirmaStruttura" placeholder="NominativoPotereFirmaStruttura"  value="<?php echo $NominativoPotereFirmaStruttura;?>">

       <label for="ResponsabileStruttura">Responsabile Struttura</label>
      <input type="text" class="form-control" id="ResponsabileStruttura" name="ResponsabileStruttura" placeholder="Responsabile Struttura"  value="<?php echo $ResponsabileStruttura;?>">

      <label for="NominativoConvenzioneStruttura">Nominativo Convenzione Struttura</label>
      <input type="text" class="form-control" id="NominativoConvenzioneStruttura" name="NominativoConvenzioneStruttura" placeholder="Nominativo Convenzione Struttura"  value="<?php echo $NominativoConvenzioneStruttura;?>">

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

    </fieldset>

  
  <input type="hidden" name="action" id="action" value="modifica">
  <input type="hidden" name="IdAnagraficaStruttura" id="IdAnagraficaStruttura" value="<?php echo $IdAnagraficaStruttura;?>">
  <button type="submit" class="btn btn-primary"><i class="fa fa-check" aria-hidden="true"></i> Salva modifiche</button>
  <hr />

  <button class="btn btn-warning disabilita_struttura" data-toggle="modal" data-target="#myModalDisattiva"><i class="fa fa-times" aria-hidden="true"></i> Disattiva struttura</button>

  <button class="btn btn-danger elimina_struttura" data-toggle="modal" data-target="#myModalElimina"><i class="fa fa-times" aria-hidden="true"></i> Elimina struttura</button>


</form>

 


    </div>



    <div class="tab-pane" id="2">
      <h3>Dati legali</h3>
      <form class="legali">
        <fieldset class="form-group">
        
        
        <label for="CodiceFiscaleStruttura">Codice Fiscale</label>
        <input type="text" class="form-control" id="CodiceFiscaleStruttura" name="CodiceFiscaleStruttura" placeholder="Codice Fiscale Struttura"  value="<?php echo $CodiceFiscaleStruttura;?>">
        <label for="PartitaIvaStruttura">Partita Iva</label>
        <input type="text" class="form-control" id="PartitaIvaStruttura" name="PartitaIvaStruttura" placeholder="Partita Iva Struttura"  value="<?php echo $PartitaIvaStruttura;?>">

        </fieldset>

      
      <input type="hidden" name="action" id="action" value="modifica_legali">
      <input type="hidden" name="IdAnagraficaStruttura" id="IdAnagraficaStruttura" value="<?php echo $IdAnagraficaStruttura;?>">
      <button type="submit" class="btn btn-primary"><i class="fa fa-check" aria-hidden="true"></i></button>
      <button class="btn btn-danger"><i class="fa fa-times" aria-hidden="true"></i></button>
    </form>

    </div>
    

    <div class="tab-pane" id="3">
    <legend>Logo</legend>
  
    
    <?php if($LogoStruttura!=""){?>
    <div class="col-xs-12 row">
      <img class="img-thumbnail" src="<?php echo $p_sito;?>/uploads/loghi/files/<?php echo $LogoStruttura;?>" />
    </div> 
    <?php } ?>
    

    <div class="col-xs-12 row">
    <label>Aggiungi nuovo</label>
      <span class="btn btn-success fileinput-button">
        <i class="glyphicon glyphicon-plus"></i>
        <span>Trascina file qui...</span>
        <!-- The file input field used as target for the file upload widget -->
        <input id="fileupload" type="file" name="files[]" multiple>
    </span>
    
    
    <!-- The global progress bar -->
    <div id="progress" class="progress">
        <div class="progress-bar progress-bar-success"></div>
    </div>
    <!-- The container for the uploaded files -->
    <div id="files" class="files"></div>
    </div>
    </div>


    <div class="tab-pane" id="4">
      <h3>Servizi</h3>

      <div class="form-group">
        <label>Sconto unico Struttura</label>
        <input type="text" id="ScontoUnicoStruttura" name="ScontoUnicoStruttura" class="form-control" value="<?php echo $ScontoUnicoStruttura;?>" />
      </div>

      <div class="contenitore_servizi"></div>
    </div>

    <div class="tab-pane" id="5">
      <h3>Tariffario PDF</h3>
      <?php if($tariffario_pdf!=""){?>


      <div id="pdf_container"></div>


      <div class="col-xs-12 row">
      <i class="fa fa-file-pdf-o" data-link="<?php echo $p_sito;?>uploads/tariffari/files/<?php echo $tariffario_pdf;?>"></i> <?php echo utf8_encode($rows["tariffario_pdf"]);?>

      <?php if($data_tariffario!=""){?>
        <label>Data caricamento tariffario</label> <?php echo date("d/m/Y", strtotime($data_tariffario));?>
      <?php } ?>
    </div> 
    <?php } ?>
    

    <div class="col-xs-12 row">
      <label>Aggiungi nuovo</label>
        <span class="btn btn-success fileinput-button">
          <i class="glyphicon glyphicon-plus"></i>
          <span>Trascina file qui...</span>
          <!-- The file input field used as target for the file upload widget -->
          <input id="fileuploadtariffario" type="file" name="files[]" multiple>
      </span>
    
    
      <!-- The global progress bar -->
      <div id="progresstariffario" class="progress">
          <div class="progress-bar progress-bar-success"></div>
      </div>
      <!-- The container for the uploaded files -->
      <div id="filestariffario" class="files"></div>
    </div>
      
    </div>


    <div class="tab-pane" id="6">
    <h3>Pacchetti</h3>
      <ul>
        <?php $sqlp="SELECT * FROM pacchetti ORDER BY id_pacchetto";
              $resp=mysql_query($sqlp);
              while($rowsp=mysql_fetch_array($resp, MYSQL_ASSOC)){

                  $sql2="SELECT * FROM strutture_meta WHERE id_struttura='$IdAnagraficaStruttura' AND chiave='Pacchetto' AND valore='$rowsp[id_pacchetto]'";
                  $res2=mysql_query($sql2);
                  $selected="";
                  if(mysql_num_rows($res2)>0) $selected="checked";
                ?>
                <li><input type="checkbox" data-value='<?php echo $rowsp["id_pacchetto"];?>' data-tipo="Pacchetto" class="servizi" <?php echo $selected;?>> <?php echo utf8_encode($rowsp["pacchetto"]);?></li>

                <?php $sqls="SELECT * FROM aree_servizi WHERE id_pacchetto='$rowsp[id_pacchetto]'";
                      $ress=mysql_query($sqls);
                      if($nums=mysql_num_rows($ress)>0){
                        echo "<ul>";
                        while($rowss=mysql_fetch_array($ress, MYSQL_ASSOC)){

                          $sql3="SELECT * FROM strutture_meta WHERE id_struttura='$IdAnagraficaStruttura' AND chiave='Servizio' AND valore='".str_pad($rowss["id_area"],'3','0',STR_PAD_LEFT)."'";

                  
                  $res3=mysql_query($sql3);
                  $selecteds="";
                  if(mysql_num_rows($res3)>0) $selecteds="checked";
                  ?>
                          <li><input type="checkbox" data-value='<?php echo $rowss["id_area"];?>' data-tipo="Servizio" class="servizi" <?php echo $selecteds;?>> <?php echo utf8_encode($rowss["area"]);?></li>
                        <?php } 
                        echo "</ul>";
                      }
                      
        } ?>
        </ul>

    
    </div>
    <div class="tab-pane" id="7">
      <h3>Dati convenzione</h3>


<?php if($convenzione_pdf!=""){?>
<div class="col-xs-12 row">


<i class="fa fa-file-pdf-o" data-link="<?php echo $p_sito;?>uploads/convenzioni/files/<?php echo $convenzione_pdf;?>"></i> <?php echo utf8_encode($rows["convenzione_pdf"]);?>
<?php if($data_convenzione!=""){?>
        <label>Data caricamento convenzione</label> <?php echo date("d/m/Y", strtotime($data_convenzione));?>
      <?php } ?>
</div>
<?php } ?>
       <div class="col-xs-12 row">
        <label>Aggiungi Pdf Convenzione</label>
          <span class="btn btn-success fileinput-button">
            <i class="glyphicon glyphicon-plus"></i>
            <span>Trascina file qui...</span>
            <!-- The file input field used as target for the file upload widget -->
            <input id="fileuploadconvenzione" type="file" name="files[]" multiple>
        </span>
      
      
        <!-- The global progress bar -->
        <div id="progressconvenzione" class="progress">
            <div class="progress-bar progress-bar-success"></div>
        </div>
        <!-- The container for the uploaded files -->
        <div id="filesconvenzione" class="files"></div>
      </div>

      <div class="form-group">
             <label for="stato">Stato</label>
            <input type="text" class="form-control" id="stato" name="stato" placeholder="Stato"  value="<?php echo $Stato;?>">
            <label for="data_stato">Data stato</label>
            <input type="text" class="form-control" id="data_stato" name="data_stato" placeholder="Data Stato"  value="<?php echo $data_stato;?>">
            <label for="note_stato">Note stato</label>
            <textarea class="form-control" id="note_stato" name="note_stato" placeholder="Note Stato" ><?php echo $note_stato;?></textarea>

            <label for="note_convenzione">Note convenzione</label>
            <textarea class="form-control" id="note_convenzione" name="note_convenzione" placeholder="Note Stato" ><?php echo $note_convenzione;?></textarea>
      </div>
      <div class="form-group">
      <label>Convenzione confermata</label>
      <input type="checkbox" <?php if($convenzione_confermata) echo "checked";?> />
      </div>
      <div class="form-group">
       <label>Data conferma convenzione</label>
      <input type="text" class="form-control" value="<?php echo $timestamp_conferma;?>" />
      </div>
      <div class="form-group">
      <label>Servizi confermati</label>
      <input type="checkbox" <?php if($servizi_confermati) echo "checked";?> />
      </div>
      <div class="form-group">
       <label>Data conferma servizi</label>
      <input type="text" class="form-control" value="<?php echo $timestamp_servizi_confermati;?>" />
      </div>

      <div class="form-group warning">
       <label>Da cancellare</label>
      <input type="checkbox" class="form-control" id="da_cancellare" name="da_cancellare" <?php if($da_cancellare) echo "checked";?>/>
      </div>

      <fieldset>
        <button class="btn btn-primary" id="stampa_scheda">Stampa scheda</button>
        <button class="btn btn-success" id="invia_adesione">Invia Adesione</button>
        <button class="btn btn-info" id="invia_adesione_lettera">Invia Adesione + Lettera</button>
        <button class="btn btn-danger" id="genera_adesione">Genera adesione</button>
      </fieldset>

    </div>
    

</div>