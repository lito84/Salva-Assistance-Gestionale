<?php require("../../includes/mysql.inc.php");
require("../../includes/parameters.php");?>


<script>
  
  $(document).ready(function(){
    $(".loading").hide();
    var url = 'uploads/importazioni/index.php';
    $('#fileupload').fileupload({
        url: url,
        dataType: 'json',
        done: function (e, data) {
            $.each(data.result.files, function (index, file) {
              <?php /*) $.post("importa_pratiche.php",{file:file.name, id_convenzione_prodotto:'<?php echo $_GET["id_convenzione_prodotto"];?>',action:"importa_pratiche"}); */?>
              $(".loading").show();
               $.post("importa_codici.php",{file:file.name, id_convenzione_prodotto:'<?php echo $_GET["id_convenzione_prodotto"];?>',action:"importa_codici"},function(data){
                            if(data=="DONE"){
                                $(".loading").hide();
                            }      
               });
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
   

  });
</script>



<?php $sql="SELECT * FROM convenzioni_prodotti LEFT JOIN prodotti ON prodotti.id_prodotto = convenzioni_prodotti.id_prodotto WHERE id_convenzione_prodotto = '$_GET[id_convenzione_prodotto]'";
$res=mysql_query($sql);
$rows=mysql_fetch_array($res, MYSQL_ASSOC);?>
<fieldset class="form-group">
<legend>Importa  - <?php echo utf8_encode(stripslashes($rows["prodotto"]." - ".$rows["prezzo_cliente"]));?></legend>   
<form id="data" method="post" enctype="multipart/form-data">
<span class="btn btn-primary fileinput-button">
        <i class="glyphicon glyphicon-plus"></i>
        <span>Trascina file qui...</span>
        <!-- The file input field used as target for the file upload widget -->
        <input id="fileupload" type="file" name="files[]" multiple>
    </span>
    <br>
    <br>
    <!-- The global progress bar -->
    <div id="progress" class="progress">
        <div class="progress-bar progress-bar-success"></div>
    </div>
    <!-- The container for the uploaded files -->
    <div id="files" class="files"></div>

<input type="hidden" id="id_convenzione_prodotto" name="id_convenzione_prodotto" value="<?php echo $_GET["id_convenzione_prodotto"];?>">
</form>

<div class="col-xs-12 text-center loading">
                 
          <i class="fa fa-refresh fa-spin fa-3x fa-fw"></i>
          <span class="sr-only">Loading...</span>
        </div>
</fieldset>