<?php include("../../includes/mysql.inc.php");
$sql="SELECT * FROM circuiti WHERE id_circuito='$_GET[id_circuito]'";
$res=mysql_query($sql);
$rows=mysql_fetch_array($res, MYSQL_ASSOC);

$id_circuito=$rows["id_circuito"];
$circuito=$rows["circuito"];
$responsabile=$rows["responsabile"];
$telefono=$rows["telefono"];
$email=$rows["email"];
$tariffario_pdf=$rows["tariffario_pdf"];

?>
<script>
$(document).ready(function(){

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


<form class="circuito" action="actions/strutture.php">
  <fieldset class="form-group">
    <label for="circuito">Circuito</label>
    <input type="text" class="form-control" id="circuito" name="circuito" placeholder="circuito"  value="<?php echo utf8_encode($circuito);?>"> 
    <label for="responsabile">Responsabile</label>
    <input type="text" class="form-control" id="responsabile" name="responsabile" placeholder="responsabile"  value="<?php echo utf8_encode($responsabile);?>">
    <label for="email">Email</label>
    <input type="text" class="form-control" id="email" name="email" placeholder="email"  value="<?php echo utf8_encode($email);?>">
    <label for="telefono">Telefono</label>
    <input type="text" class="form-control" id="telefono" name="telefono" placeholder="telefono"  value="<?php echo utf8_encode($telefono);?>">
    <label for="descrizione">Descrizione/Note</label>
    <textarea class="form-control" rows="5" id="descrizione" name="descrizione"><?php echo utf8_encode($descrizione);?></textarea>

  </fieldset>

  
  
  
  <input type="hidden" name="action" id="action" value="inserisci">
  <input type="hidden" name="id_circuito" id="id_circuito" value="<?php echo $id_circuito;?>">
  <button type="submit" class="btn btn-primary"><i class="fa fa-check" aria-hidden="true"></i></button>
  <button class="btn btn-danger"><i class="fa fa-times" aria-hidden="true"></i></button>
</form>