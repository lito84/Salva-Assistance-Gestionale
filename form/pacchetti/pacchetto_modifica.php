<?php

include("../../includes/mysql.inc.php");
include("../../includes/parameters.php");

$sql="SELECT * FROM pacchetti WHERE id_pacchetto='$_GET[id_pacchetto]'";
$res=mysql_query($sql);
$rows=mysql_fetch_array($res, MYSQL_ASSOC);
?>
<script>
$(document).ready(function(){


  $('#bugiardino').summernote();
  $('#bugiardino_ss').summernote();


  $('.bugiardino').on("click", function(){
     $.post("actions/pacchetti.php",{bugiardino:$("#bugiardino").val(), id_pacchetto:'<?php echo $_GET['id_pacchetto'];?>', action:"bugiardino"});
  });

  $('.bugiardino_ss').on("click", function(){
     $.post("actions/pacchetti.php",{bugiardino_ss:$("#bugiardino_ss").val(), id_pacchetto:'<?php echo $_GET['id_pacchetto'];?>', action:"bugiardino_ss"});
  });


  
   $('form.circuito').submit(function(e) {
      event.preventDefault();
      //grab all form data  
      var formData = new FormData($('form.circuito')[0]);
      $.ajax({
        url: 'actions/pacchetti.php',
        type: 'POST',
        data: formData,
        async: false,
        cache: false,
        contentType: false,
        processData: false,
        success: function (returndata) {
         $("#contenitore").empty().load("form/pacchetti/pacchetti.php"); 
        }
      });
  });


});
</script>

<fieldset>
<legend>Bugiardino Pdf</legend>
  <textarea id="bugiardino" name="bugiardino"><?php echo utf8_decode($rows["bugiardino"]);?></textarea>
  <button class="btn btn-primary bugiardino"><i class="fa fa-check" aria-hidden="true"></i> Salva bugiardino</button>   
</fieldset>


<fieldset>
<legend>Bugiardino App</legend>
  <textarea id="bugiardino_ss" name="bugiardino_ss"><?php echo utf8_decode($rows["bugiardino_ss"]);?></textarea>
  <button class="btn btn-primary bugiardino_ss"><i class="fa fa-check" aria-hidden="true"></i> Salva bugiardino App</button>   
</fieldset>
