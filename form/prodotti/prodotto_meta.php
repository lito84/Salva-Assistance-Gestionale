<?php include("../../includes/mysql.inc.php");?>
<?php include("../../includes/parameters.php");?>
<script>
	$(document).ready(function(){
  	
    $(".add_meta").bind("click", function(){

      var id_prodotto=$("#id_prodotto_meta").val();
      $.post("actions/prodotti.php", {id_prodotto:id_prodotto,chiave:$("#chiave").val(),nuova_chiave:$("#nuova_chiave").val(),valore:$("#valore").val(),colore:$("#colore").val(),action:"nuovo_meta"},function(data){
        $(".prodotti_meta").empty().load("form/prodotti/prodotto_meta.php?id_prodotto="+id_prodotto);
      })

    });

    $(".valore").bind("keyup", function(){
      var id=$(this).attr("data-id");
      $.post("actions/prodotti.php",{id:id, valore:$(this).val(), action:"valore"});
    });

    $(".chiave").bind("keyup", function(){
      var id=$(this).attr("data-id");
      $.post("actions/prodotti.php",{id:id, chiave:$(this).val(), action:"chiave"});
    });


    $(".rimuovi_meta").bind("click", function(){
      var id_prodotto=$("#id_prodotto_meta").val();
       var id=$(this).attr("data-id");
        $.post("actions/prodotti.php",{id:id, action:"rimuovi_meta"});
        $(".prodotti_meta").empty().load("form/prodotti/prodotto_meta.php?id_prodotto="+id_prodotto);
    });

    var url = '<?php echo $p_sito;?>uploads/modelli/index.php';
    $('#fileupload').fileupload({
        url: url,
        dataType: 'json',
        done: function (e, data) {
            $.each(data.result.files, function (index, file) {
               $.post("actions/prodotti.php",{file:file.name, id_prodotto:'<?php echo $_GET["id_prodotto"];?>',action:"modello"});
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



         var url_immagine = '<?php echo $p_sito;?>uploads/prodotti/index.php';
    $('#fileupload_immagine').fileupload({
        url: url_immagine,
        dataType: 'json',
        done: function (e, data) {
            $.each(data.result.files, function (index, file) {
               $.post("actions/prodotti.php",{file:file.name, id_prodotto:'<?php echo $_GET["id_prodotto"];?>',action:"immagine"});
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

<hr />


<input type="hidden" id="id_prodotto_meta" name="id_prodotto_meta" value="<?php echo $_GET["id_prodotto"];?>" />

<fieldset class="form-group">
<legend>Modello pdf</legend>
<span class="btn btn-success fileinput-button">
        <i class="glyphicon glyphicon-plus"></i>
        <span>Trascina file qui...</span>
        <!-- The file input field used as target for the file upload widget -->
        <input id="fileupload" type="file" name="files[]" multiple>
    </span>
<legend>Modello grafico</legend>
<span class="btn btn-success fileinput-button">
        <i class="glyphicon glyphicon-plus"></i>
        <span>Trascina file qui...</span>
        <!-- The file input field used as target for the file upload widget -->
        <input id="fileupload_immagine" type="file" name="files[]" multiple>
    </span>

<p>&nbsp;</p>


    <!-- The global progress bar -->
    <div id="progress" class="progress">
        <div class="progress-bar progress-bar-success"></div>
    </div>
    <!-- The container for the uploaded files -->
    <div id="files" class="files"></div>
</fieldset>
<fieldset class="form-group">
<legend>Valori aggiuntivi</legend>
<table class="table">
<thead>
  <tr>
    <th>Chiave</th>
    <th>Valore</th>
    <th>&nbsp;</th>
  </tr>
</thead>
<tbody>
<?php $sql="SELECT * FROM prodotti_meta WHERE id_prodotto='$_GET[id_prodotto]' ORDER BY chiave";
      $res=mysql_query($sql);
      while($rows=mysql_fetch_array($res, MYSQL_ASSOC)){?>
        <tr>
          <td><input type="text" data-id="<?php echo $rows["id_prodotto_meta"];?>" class="chiave form-control" value='<?php echo utf8_encode($rows["chiave"]);?>' /></td>
          <td><input type="text" data-id="<?php echo $rows["id_prodotto_meta"];?>" class="valore form-control" value='<?php echo utf8_encode($rows["valore"]);?>' /></td>  
          <td><button data-id="<?php echo $rows['id_prodotto_meta'];?>" class="btn btn-danger rimuovi_meta"><i class="fa fa-trash" aria-hidden="true"></i></i></button></td>
        </tr>
<?php } ?>
</tbody>
</table>
</fieldset>

<hr />

<fieldset class="form-group">
  <legend>Nuovo valore</legend>
  <div class="col-xs-6 col-sm-3">
  <label>Chiave</label>
    <select class="form-control" id="chiave" name="chiave">
    <option></option>
    <?php $sql1="SELECT chiave FROM prodotti_meta GROUP BY chiave ORDER BY chiave";
        $res1=mysql_query($sql1);
        while($rows1=mysql_fetch_array($res1, MYSQL_ASSOC)){?>
         <option value="<?php echo $rows1["chiave"];?>"><?php echo utf8_encode($rows1["chiave"]);?></option>   
    <?php } ?>
    </select>
  </div>
<?php /*
  <div class="col-xs-6 col-sm-4">
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