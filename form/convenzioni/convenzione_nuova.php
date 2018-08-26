<?php include("../../includes/mysql.inc.php");?>
<script>
  $("#id_utente").select2();

	$(document).ready(function(){
		$(".btn-danger").bind("click", function(){
			$("#contenitore").empty().load("form/convenzioni/convenzioni.php");	
		});

    $('.comunicazioni').summernote({
      height: 300
    });

    $("#codice_convenzione").val(makeid());
    
   $('form.prodotto').submit(function(e) {
      e.preventDefault(); // don't submit multiple times
      $.post("actions/convenzioni.php",{
        codice_convenzione:$("#codice_convenzione").val(), 
        descrizione:$("#descrizione").val(),
        action:"inserisci"}, function(data){
        if(data!=""){
         $("#contenitore").empty().load("form/convenzioni/convenzioni.php");  
        }
      })
  });
	})
</script>
<div class="col-xs-12">
<form class="prodotto">
  <fieldset class="form-group">
    
    <label for="codice_convenzione">Codice Convenzione</label>
    <input type="text" id="codice_convenzione" name="codice_convenzione" required class="form-control">  

    
    <label for="descrizione">Descrizione</label>
    <input type="text" id="descrizione" name="descrizione" required class="form-control">  

    
    
  </fieldset>

  <hr />
  <button type="submit" class="btn btn-primary"><i class="fa fa-check" aria-hidden="true"></i></button>
  <button class="btn btn-danger"><i class="fa fa-times" aria-hidden="true"></i></button>
</form>
</div>