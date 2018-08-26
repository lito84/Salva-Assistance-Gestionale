<?php

include("../../includes/mysql.inc.php");
include("../../includes/parameters.php");

$sql="SELECT * FROM circuiti WHERE id_circuito='$_GET[id_circuito]'";
$res=mysql_query($sql);
$rows=mysql_fetch_array($res, MYSQL_ASSOC);
$id_circuito=$rows["id_circuito"];
$circuito=$rows["circuito"];
$responsabile=$rows["responsabile"];
$telefono=$rows["telefono"];
$email=$rows["email"];
$tariffario_pdf=$rows["tariffario_pdf"];
$descrizione=$rows["descrizione"];

?>
<script>
$(document).ready(function(){

  $(".contenitore_servizi").load("form/circuiti/servizi.php?id_circuito=<?php echo $id_circuito;?>");
  $(".contenitore_pacchetti").load("form/circuiti/pacchetti.php?id_circuito=<?php echo $id_circuito;?>");
  $("#descrizione").summernote({
    height:150
  });
  $(".fa-file-pdf-o").on("click", function(){
    window.open($(this).attr("data-link"));
  });

  var url = '<?php echo $p_sito;?>uploads/tariffari/index.php';
    $('#fileupload').fileupload({
        url: url,
        dataType: 'json',
        done: function (e, data) {
            $.each(data.result.files, function (index, file) {
               $.post("actions/circuiti.php",{file:file.name, id_circuito:'<?php echo $id_circuito;?>',action:"tariffario"});
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
 

   $('form.circuito').submit(function(e) {
      event.preventDefault();
      //grab all form data  
      var formData = new FormData($('form.circuito')[0]);
      $.ajax({
        url: 'actions/circuiti.php',
        type: 'POST',
        data: formData,
        async: false,
        cache: false,
        contentType: false,
        processData: false,
        success: function (returndata) {
         $("#contenitore").empty().load("form/circuiti/circuiti.php"); 
        }
      });
  });


});
</script>

<ul class="nav nav-tabs">
  <li class="active"><a href="#1" data-toggle="tab">Dati Anagrafici</a></li>
  <li><a href="#2" data-toggle="tab">Servizi</a></li>
  <li><a href="#3" data-toggle="tab">Pacchetti</a></li>
  <li><a href="#4" data-toggle="tab">Tariffario PDF</a></li>
</ul>


<div class="tab-content ">
    

  <div class="tab-pane active" id="1">

    <form class="circuito" action="actions/ciruiti.php">
      <fieldset class="form-group">
        <label for="circuito">Circuito</label>
        <input type="text" class="form-control" id="circuito" name="circuito" placeholder="circuito"  value="<?php echo utf8_encode($circuito);?>"> 
        <label for="responsabile">Nominativo Convenzione</label>
        <input type="text" class="form-control" id="responsabile" name="responsabile" placeholder="responsabile"  value="<?php echo utf8_encode($responsabile);?>">
        <label for="email">Email</label>
        <input type="text" class="form-control" id="email" name="email" placeholder="email"  value="<?php echo utf8_encode($email);?>">
        <label for="telefono">Telefono</label>
        <input type="text" class="form-control" id="telefono" name="telefono" placeholder="telefono"  value="<?php echo utf8_encode($telefono);?>">
        <label for="descrizione">Descrizione/Note</label>
    <textarea class="form-control" rows="5" id="descrizione" name="descrizione"><?php echo utf8_encode($descrizione);?></textarea>
        
      </fieldset>

      
      
      
      <input type="hidden" name="action" id="action" value="modifica">
      <input type="hidden" name="id_circuito" id="id_circuito" value="<?php echo $id_circuito;?>">
      <button type="submit" class="btn btn-primary"><i class="fa fa-check" aria-hidden="true"></i></button>
      <button class="btn btn-danger"><i class="fa fa-times" aria-hidden="true"></i></button>
    </form>
  </div>

  <div class="tab-pane" id="2">
      <h3>Servizi</h3>

      <div class="contenitore_servizi"></div>
  </div>

  <div class="tab-pane" id="3">
      <h3>Pacchetti</h3>

      <div class="contenitore_pacchetti"></div>
  </div>


  <div class="tab-pane" id="4">
    <legend>Tariffario PDF</legend>
  
    
    <?php if($tariffario_pdf!=""){?>
    <div class="col-xs-12 row">
      <i class="fa fa-file-pdf-o" data-link="<?php echo $p_sito;?>uploads/tariffari/files/<?php echo $tariffario_pdf;?>"></i> <?php echo utf8_encode($rows["tariffario_pdf"]);?>
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

</div>
