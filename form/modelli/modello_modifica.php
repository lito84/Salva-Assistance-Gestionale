<?php

include("../../includes/mysql.inc.php");
include("../../includes/mysqli.inc.php");
include("../../includes/parameters.php");

$sql="SELECT * FROM templates_email WHERE id_template='$_GET[id_modello]'";
$res=$mysqli->query($sql);
$rows=$res->fetch_assoc();


$id_template=$rows["id_template"];
$nome=$rows["nome"];
$template=$rows["template"];

?>
<script>
$(document).ready(function(){
   $('.comunicazioni').summernote({
      height: 600
    });
});
</script>
<form class="prodotto">

    <label>Modello</label>
    <input class="form-control" type="text" name="nome" id="nome" value="<?php echo utf8_encode($nome);?>">

<label for="testo_mail_prodotto_convenzione">Testo email prodotto</label>
  <textarea id="testo_mail_prodotto_convenzione" name="testo_mail_prodotto_convenzione" class="form-control comunicazioni prodotto" name="content"><?php echo utf8_encode($template);?></textarea>
  <button type="submit" class="btn btn-primary"><i class="fa fa-check" aria-hidden="true"></i></button>
  <button class="btn btn-danger"><i class="fa fa-times" aria-hidden="true"></i></button>
</form>