<?php require("../../includes/mysql.inc.php");
require("../../includes/parameters.php");

?>
<script>
$(document).ready(function(){
  $('.comunicazioni').summernote({
      height: 300
    });

  $('.descrizione').summernote({
    
    });

  

  $("#salva_modello_mail").bind("click", function(){
    var id_convenzione_prodotto=$("#id_convenzione_prodotto").val();
     $.post("actions/prodotti_meta.php", {id_convenzione_prodotto:id_convenzione_prodotto,testo_mail_prodotto_convenzione:$("#testo_mail_prodotto_convenzione").val(),action:"modello_mail"},function(data){
       $(".prodotti_convenzione_dettaglio").empty().load("form/convenzioni/convenzioni_prodotti_dettaglio.php?id_convenzione_prodotto="+id_convenzione_prodotto);
      }); 
  });


  $("#salva_modello_mail_rinnovo").bind("click", function(){
    var id_convenzione_prodotto=$("#id_convenzione_prodotto").val();
     $.post("actions/prodotti_meta.php", {id_convenzione_prodotto:id_convenzione_prodotto,testo_mail_prodotto_convenzione_rinnovo:$("#testo_mail_prodotto_convenzione_rinnovo").val(),action:"modello_rinnovo"},function(data){
       $(".prodotti_convenzione_dettaglio").empty().load("form/convenzioni/convenzioni_prodotti_dettaglio.php?id_convenzione_prodotto="+id_convenzione_prodotto);
      }); 
  });

  $("#salva_modello_mail_prenotazione").bind("click", function(){
    var id_convenzione_prodotto=$("#id_convenzione_prodotto").val();
     $.post("actions/prodotti_meta.php", {id_convenzione_prodotto:id_convenzione_prodotto,testo_mail_prodotto_convenzione_prenotazione:$("#testo_mail_prodotto_convenzione_prenotazione").val(),action:"modello_prenotazione"},function(data){
       $(".prodotti_convenzione_dettaglio").empty().load("form/convenzioni/convenzioni_prodotti_dettaglio.php?id_convenzione_prodotto="+id_convenzione_prodotto);
      }); 
  });

  $("#salva_modello_mail_invio_codice").bind("click", function(){
    var id_convenzione_prodotto=$("#id_convenzione_prodotto").val();
     $.post("actions/prodotti_meta.php", {id_convenzione_prodotto:id_convenzione_prodotto,testo_mail_prodotto_convenzione_invio_codice:$("#testo_mail_prodotto_convenzione_invio_codice").val(),action:"modello_codice"},function(data){
       $(".prodotti_convenzione_dettaglio").empty().load("form/convenzioni/convenzioni_prodotti_dettaglio.php?id_convenzione_prodotto="+id_convenzione_prodotto);
      }); 
  });


  $(".servizi").on("change", function(){
      var selezione=0;
      if($(this).is(":checked")){
        selezione=1;
      }
      var id_convenzione_prodotto=$("#id_convenzione_prodotto").val();
     $.post("actions/prodotti_meta.php",{id_convenzione_prodotto:id_convenzione_prodotto, selezione:selezione, tipo:$(this).attr("data-tipo"), valore:$(this).attr("data-value"), action:"pacchetto"});

   });


	$(".add_meta").bind("click", function(){

      var id_convenzione_prodotto=$("#id_convenzione_prodotto").val();
      $.post("actions/prodotti_meta.php", {id_convenzione_prodotto:id_convenzione_prodotto,chiave:$("#chiave").val(),nuova_chiave:$("#nuova_chiave").val(),valore:$("#valore").val(),action:"nuovo_meta"},function(data){
       $(".prodotti_convenzione_dettaglio").empty().load("form/convenzioni/convenzioni_prodotti_dettaglio.php?id_convenzione_prodotto="+id_convenzione_prodotto);
      })

    });

    $(".valore").bind("keyup", function(){
      var id=$(this).attr("data-id");
      $.post("actions/prodotti_meta.php",{id:id, valore:$(this).val(), action:"valore"});
    });

    $("#salva_descrizione").on("click", function(){
      var descrizione=$(".descrizione").val();
      var id=$(this).attr("data-id");
      $.post("actions/prodotti_meta.php",{id:id, valore:descrizione, action:"valore"});
    });


    $(".chiave").bind("keyup", function(){
      var id=$(this).attr("data-id");
      $.post("actions/prodotti_meta.php",{id:id, chiave:$(this).val(), action:"chiave"});
    });


    $(".rimuovi_meta").bind("click", function(){
      var id_convenzione_prodotto=$("#id_convenzione_prodotto").val();
       var id=$(this).attr("data-id");
        $.post("actions/prodotti_meta.php",{id:id, action:"rimuovi_meta"});
        $(".prodotti_convenzione_dettaglio").empty().load("form/convenzioni/convenzioni_prodotti_dettaglio.php?id_convenzione_prodotto="+id_convenzione_prodotto);
    });


    $(".gallery").bind("click", function(){
    		var logo=$(this).attr("data-id");
    		$(".modal-body").empty().load("form/immagini/galleria.php?logo="+logo+"&id_convenzione_prodotto="+$("#id_convenzione_prodotto").val());
    });

    $('.fileupload').each(function () {
		    $(this).fileupload({
		        dropZone: $(this)
		    });
		});


    var url = '<?php echo $p_sito;?>uploads/prodotti/index.php';
    $('#fileupload').fileupload({
        url: url,
        dataType: 'json',
        imageMaxHeight: 200,
        imageMaxWidth:400,
        imageForceResize:true,

        done: function (e, data) {
            $.each(data.result.files, function (index, file) {
          		$('<p/>').text(file.name).appendTo('#files');
              $.post("actions/prodotti.php",{file:file.name, id_prodotto:'<?php echo $_GET["id_convenzione_prodotto"];?>',action:"immagine_convenzione"});
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

        $('#myModal').on('hidden.bs.modal', function () {
        	 var id_convenzione_prodotto=$("#id_convenzione_prodotto").val();
			 $(".prodotti_convenzione_dettaglio").empty().load("form/convenzioni/convenzioni_prodotti_dettaglio.php?id_convenzione_prodotto="+id_convenzione_prodotto);
		});

		var url_modello = '<?php echo $p_sito;?>uploads/modelli/index.php';
    $('#modelloupload').fileupload({
        url: url_modello,
        dataType: 'json',

        done: function (e, data) {
            $.each(data.result.files, function (index, file) {
          		$('<p/>').text(file.name).appendTo('#files_modello');
          		 $.post("actions/prodotti.php",{file:file.name, id_prodotto:'<?php echo $_GET["id_convenzione_prodotto"];?>',action:"modello_convenzione"}, function(data){
          		 	var id_convenzione_prodotto=$("#id_convenzione_prodotto").val();
				 $(".prodotti_convenzione_dettaglio").empty().load("form/convenzioni/convenzioni_prodotti_dettaglio.php?id_convenzione_prodotto="+id_convenzione_prodotto);	
          		 });
          		 
      		});
        },
        progressall: function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('#progress_modello .progress-bar').css(
                'width',
                progress + '%'
            );
        }
    }).prop('disabled', !$.support.fileInput)
        .parent().addClass($.support.fileInput ? undefined : 'disabled');


    var url_card = '<?php echo $p_sito;?>uploads/card/index.php';
    $('#cardupload').fileupload({
        url: url_card,
        dataType: 'json',

        done: function (e, data) {
            $.each(data.result.files, function (index, file) {
              $('<p/>').text(file.name).appendTo('#files_modello');
               $.post("actions/prodotti.php",{file:file.name, id_prodotto:'<?php echo $_GET["id_convenzione_prodotto"];?>',action:"card_convenzione"}, function(data){
                var id_convenzione_prodotto=$("#id_convenzione_prodotto").val();
         $(".prodotti_convenzione_dettaglio").empty().load("form/convenzioni/convenzioni_prodotti_dettaglio.php?id_convenzione_prodotto="+id_convenzione_prodotto); 
               });
               
          });
        },
        progressall: function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('#progress_card .progress-bar').css(
                'width',
                progress + '%'
            );
        }
    }).prop('disabled', !$.support.fileInput)
        .parent().addClass($.support.fileInput ? undefined : 'disabled');

});
</script>




<?php $sql0="SELECT * FROM convenzioni_prodotti LEFT JOIN prodotti ON prodotti.id_prodotto=convenzioni_prodotti.id_prodotto WHERE id_convenzione_prodotto ='$_GET[id_convenzione_prodotto]'";
$res0=mysql_query($sql0);
$rows0=mysql_fetch_array($res0, MYSQL_ASSOC);?>

<fieldset class="form-group alert-info">
<input type="hidden" name="id_convenzione_prodotto" id="id_convenzione_prodotto" value="<?php echo $_GET["id_convenzione_prodotto"];?>" />
<legend>Modello invio card - <?php echo utf8_encode(stripslashes($rows0["prodotto"]." - ".$rows0["prezzo_cliente"]));?></legend>   
<label for="testo_mail_prodotto_convenzione">Testo email prodotto</label>
  <textarea id="testo_mail_prodotto_convenzione" name="testo_mail_prodotto_convenzione" class="form-control comunicazioni prodotto" name="content"><?php echo $rows0["testo_mail_prodotto"];?></textarea>
  <div class="col-md-4 center-block">
    <button id="salva_modello_mail" name="salva_modello_mail" class="btn btn-large btn-primary">Salva modello</button> 
    </div>
</fieldset>


<fieldset class="form-group alert-info">
<legend>Modello rinnovo - <?php echo utf8_encode(stripslashes($rows0["prodotto"]." - ".$rows0["prezzo_cliente"]));?></legend>   
<label for="testo_mail_prodotto_convenzione_rinnovo">Testo email rinnovo</label>
  <textarea id="testo_mail_prodotto_convenzione_rinnovo" name="testo_mail_prodotto_convenzione_rinnovo" class="form-control comunicazioni rinnovo" name="content"><?php echo $rows0["testo_mail_rinnovo"];?></textarea>
  <div class="col-md-4 center-block">
    <button id="salva_modello_mail_rinnovo" name="salva_modello_mail_rinnovo" class="btn btn-large btn-primary">Salva modello rinnovo</button> 
    </div>
</fieldset>

<fieldset class="form-group alert-info">
<legend>Modello prenotazione - <?php echo utf8_encode(stripslashes($rows0["prodotto"]." - ".$rows0["prezzo_cliente"]));?></legend>   
<label for="testo_mail_prodotto_convenzione_prenotazione">Testo email prenotazione</label>
  <textarea id="testo_mail_prodotto_convenzione_prenotazione" name="testo_mail_prodotto_convenzione_prenotazione" class="form-control comunicazioni prenotazione" name="content"><?php echo $rows0["testo_mail_prenotazione"];?></textarea>
  <div class="col-md-4 center-block">
    <button id="salva_modello_mail_prenotazione" name="salva_modello_mail_prenotazione" class="btn btn-large btn-primary">Salva modello prenotazione</button> 
    </div>
</fieldset>



<fieldset class="form-group alert-info">
<input type="hidden" name="id_convenzione_prodotto" id="id_convenzione_prodotto" value="<?php echo $_GET["id_convenzione_prodotto"];?>" />

<legend>Metadati - <?php echo utf8_encode(stripslashes($rows0["prodotto"]." - ".$rows0["prezzo_cliente"]));?></legend>

<table class="table">
<thead>
  <tr>
    <th style="width:20%;">Chiave</th>
    <th style="width:80%;">Valore</th>
    <th>&nbsp;</th>
  </tr>
</thead>
<tbody>

	<?php $sql="SELECT * FROM prodotti_convenzione_meta WHERE id_prodotto_convenzione='$_GET[id_convenzione_prodotto]' AND chiave <> 'Pacchetto' AND chiave <> 'Servizio'";
		  $res=mysql_query($sql);
		  while($rows=mysql_fetch_array($res, MYSQL_ASSOC)){?>
		  	  <tr>
          <td><input type="text" data-id="<?php echo $rows["id_prodotto_meta"];?>" class="chiave form-control" value='<?php echo utf8_encode($rows["chiave"]);?>' /></td>
          <td>

          <?php if($rows["chiave"]=="Descrizione"){?>

          <textarea data-id="<?php echo $rows["id_prodotto_meta"];?>" class="valore form-control descrizione" name="content"><?php echo utf8_decode($rows["valore"]);?></textarea>
            <button id="salva_descrizione" data-id="<?php echo $rows["id_prodotto_meta"];?>" class="btn btn-primary">Salva descrizione</button>

          <?php } else {?>
          <input type="text" data-id="<?php echo $rows["id_prodotto_meta"];?>" class="valore form-control" value='<?php echo utf8_encode($rows["valore"]);?>' />
          <?php } ?>
          </td>  
          <td><button data-id="<?php echo $rows['id_prodotto_meta'];?>" class="btn btn-danger rimuovi_meta"><i class="fa fa-trash" aria-hidden="true"></i></button></td>
        </tr>
  	<?php } ?>
</tbody>
</table>
</fieldset>


<fieldset class="form-group alert-info">
  <legend>Nuovo valore</legend>
  <div class="col-xs-6 col-sm-3">
  <label>Chiave</label>
    <select class="form-control" id="chiave" name="chiave">
    <option></option>
    <?php $sql1="SELECT chiave FROM prodotti_convenzione_meta WHERE chiave <> 'Pacchetto' AND chiave <> 'Servizio' GROUP BY chiave ORDER BY chiave";
        $res1=mysql_query($sql1);
        while($rows1=mysql_fetch_array($res1, MYSQL_ASSOC)){?>
         <option value="<?php echo $rows1["chiave"];?>"><?php echo utf8_encode($rows1["chiave"]);?></option>   
    <?php } ?>
    </select>
  </div>

 <?php /* <div class="col-xs-6 col-sm-4">
  <label>Nuova Chiave</label>
    <input type="text" id="nuova_chiave" name="nuova_chiave" class="form-control" />
  </div> */?>

    <div class="col-xs-6 col-sm-4">
  <label>Valore</label>
    <input type="text" id="valore" name="valore" class="form-control" />
  </div>

      <div class="col-xs-1">
  <label>&nbsp;</label>
    <button class="btn btn-success add_meta form-control"><i class="fa fa-check-circle" aria-hidden="true"></i></button>
  </div>
</fieldset>



<fieldset  class="form-group alert-success">
  <legend>Pacchetti & Servizi </legend>
  <ul>
        <?php $sqlp="SELECT * FROM pacchetti ORDER BY id_pacchetto";
              $resp=mysql_query($sqlp);
              while($rowsp=mysql_fetch_array($resp, MYSQL_ASSOC)){

                  $sql2="SELECT * FROM prodotti_convenzione_meta WHERE id_prodotto_convenzione='$_GET[id_convenzione_prodotto]' AND chiave='Pacchetto' AND valore='$rowsp[id_pacchetto]'";
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

                          $sql3="SELECT * FROM prodotti_convenzione_meta WHERE id_prodotto_convenzione='$_GET[id_convenzione_prodotto]' AND chiave='Servizio' AND valore='$rowss[id_area]'";
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

</fieldset>


<fieldset class="form-group alert-info">
  <legend>Nuovo modello </legend>
       
  <div class="col-xs-12">
	<label>Carica Nuovo Modello</label>	
		<span class="btn btn-success fileinput-button form-control">
        <i class="glyphicon glyphicon-plus"></i>
        <span>Trascina file qui...</span>
        <!-- The file input field used as target for the file upload widget -->
        <input id="modelloupload" type="file" name="files[]" class="fileupload" multiple>
    </span>
    <br>
    <br>
    <!-- The global progress bar -->
    <div id="progress_modello" class="progress">
        <div class="progress-bar progress-bar-success"></div>
    </div>
    <!-- The container for the uploaded files -->
    <div id="files_modello" class="files"></div>
	</div>


</fieldset>

<fieldset class="form-group alert-info">
  <legend>Modello Card</legend>
       
  <div class="col-xs-12">
  <label>Carica Nuovo Modello Card</label> 
    <span class="btn btn-success fileinput-button form-control">
        <i class="glyphicon glyphicon-plus"></i>
        <span>Trascina file qui...</span>
        <!-- The file input field used as target for the file upload widget -->
        <input id="cardupload" type="file" name="files[]" class="fileupload" multiple>
    </span>
    <br>
    <br>
    <!-- The global progress bar -->
    <div id="progress_card" class="progress">
        <div class="progress-bar progress-bar-success"></div>
    </div>
    <!-- The container for the uploaded files -->
    <div id="files_card" class="files"></div>
  </div>


</fieldset>

<fieldset class="form-group alert-info">
<div class="col-xs-12 col-sm-6">
  <label>Carica Immagini</label>  
    <span class="btn btn-success fileinput-button form-control">
        <i class="glyphicon glyphicon-plus"></i>
        <span>Trascina file qui...</span>
        <!-- The file input field used as target for the file upload widget -->
        <input id="fileupload" type="file" name="files[]" class="fileupload" multiple>
    </span>
    <br>
    <br>
    <!-- The global progress bar -->
    <div id="progress" class="progress">
        <div class="progress-bar progress-bar-success"></div>
    </div>
    <!-- The container for the uploaded files -->
    <div id="files" class="files"></div>
  </div>
</fieldset>

<?php /*
<fieldset class="form-group alert-info">
	<legend>Grafica PDF</legend>
	<div class="col-xs-12 col-sm-6">
		<div class="row">
			<div class="col-xs-11">	
				<label>Logo #1</label>

				<?php $sql2="SELECT * FROM prodotti_convenzione_meta_pdf WHERE chiave='logo1' AND id_prodotto_convenzione='$_GET[id_convenzione_prodotto]'";
					  $res2=mysql_query($sql2);
					  $rows2=mysql_fetch_array($res2, MYSQL_ASSOC);
					  $logo1=$rows2["valore"];?>	
					<input type="text" id="logo_1" name="logo_1" class="form-control" value="<?php echo $logo1;?>" />
			</div>
			<div class="col-xs-1">
			<label></label>
			<button class="btn btn-info gallery" data-id="logo1" data-toggle="modal" data-target="#myModal"><i class="fa fa-eyedropper" aria-hidden="true"></i></button>
			</div>
		</div>	
	
		<div class="row">
			<div class="col-xs-11">	
				<label>Logo #2</label>
				<?php $sql2="SELECT * FROM prodotti_convenzione_meta_pdf WHERE chiave='logo2' AND id_prodotto_convenzione='$_GET[id_convenzione_prodotto]'";
					  $res2=mysql_query($sql2);
					  $rows2=mysql_fetch_array($res2, MYSQL_ASSOC);
					  $logo2=$rows2["valore"];?>	
				<input type="text" id="logo_2" name="logo_2" class="form-control" value="<?php echo $logo2;?>" />
			</div>
			<div class="col-xs-1">
			<label></label>
			<button class="btn btn-info gallery" data-id="logo2" data-toggle="modal" data-target="#myModal"><i class="fa fa-eyedropper" aria-hidden="true"></i></button>
			</div>
		</div>

		<div class="row">
			<div class="col-xs-11">	
				<label>Logo #3</label>
				<?php $sql2="SELECT * FROM prodotti_convenzione_meta_pdf WHERE chiave='logo3' AND id_prodotto_convenzione='$_GET[id_convenzione_prodotto]'";
					  $res2=mysql_query($sql2);
					  $rows2=mysql_fetch_array($res2, MYSQL_ASSOC);
					  $logo3=$rows2["valore"];?>	
				<input type="text" id="logo_3" name="logo_3" class="form-control" value="<?php echo $logo3;?>" />
			</div>
			<div class="col-xs-1">
			<label></label>
			<button class="btn btn-info gallery" data-id="logo3" data-toggle="modal" data-target="#myModal"><i class="fa fa-eyedropper" aria-hidden="true"></i></button>
			</div>
		</div>		

	</div>
	
</fieldset>
*/?>
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Chiudi"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Galleria Immagini</h4>
      </div>
      <div class="modal-body">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Chiudi</button>
      </div>
    </div>
  </div>
</div>

