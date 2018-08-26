<?php include("../../includes/mysql.inc.php");
      include("../../includes/parameters.php");
?>
<script src="<?php echo $p_sito;?>js/image-picker.js"></script>
<link rel="stylesheet" href="<?php echo $p_sito;?>js/image-picker.css" />
<script>
	$(document).ready(function(){
		$("select#immagine_selezionata").imagepicker({
			selected:function(){
				var immagine = $(this).val();
				$("#immagine_selezionata_valore").val(""+immagine);
			}
		});

		$(".aggiungi_immagine").bind("click", function(){
			$.post("actions/prodotti.php",{id_prodotto_convenzione:$("#id_convenzione_prodotto").val(), chiave:$("#data-logo").val(), valore:$("#immagine_selezionata_valore").val(), action:"logo"}, function(data){
				if(data==""){
					$(".risultato").empty().html('<div class="alert alert-success"><strong>Logo impostato correttamente</strong></div>')
				}
			});
		})
	});

</script>

<?php
$dir = "../../uploads/immagini/files/";
?>
<input id="data-logo" value="<?php echo $_GET["logo"];?>" type="hidden" />
<input id="data-id_convenzione_prodotto" value="<?php echo $_GET["id_convenzione_prodotto"];?>" type="hidden" />
<input id="immagine_selezionata_valore" name="immagine_selezionata_valore" type="hidden" value="" />

<select id="immagine_selezionata" name="immagine_selezionata">
<option></option>
<?php 
// Open a directory, and read its contents
$allowed =  array('gif','png' ,'jpg');
if (is_dir($dir)){
  if ($dh = opendir($dir)){
    while (($file = readdir($dh)) !== false){
     $ext = pathinfo($file, PATHINFO_EXTENSION);
		if(in_array($ext,$allowed) ) {

			$path=$p_sito."uploads/immagini/files/".$file;
		    echo '<option data-img-src="'.$path.'" value="'.$file.'">'.$file.'</option>';
		}
    }
    closedir($dh);
  }
}
?>
</select>
<span class="risultato" class="form-control"></span>
<hr />
<button type="button" class="btn btn-primary aggiungi_immagine">Salva</button>

