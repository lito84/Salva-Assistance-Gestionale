<?php include("../../includes/mysql.inc.php");
$sql="SELECT * FROM anagrafica_da_confermare WHERE id_struttura='$_GET[id_struttura]'";
$res=mysql_query($sql);
$rows=mysql_fetch_array($res, MYSQL_ASSOC);

$id_struttura=$rows["id_struttura"];
$struttura=$rows["struttura"];
$citta=$rows["citta"];
$indirizzo=$rows["indirizzo"];
$cap=$rows["cap"];
$pr=$rows["pr"];
$email=$rows["email"];

$telefono=$rows["telefono"];
$note=$rows["note"];
$stato=$rows["stato"];
?>
<script>
$(document).ready(function(){

   $('form.struttura').submit(function(e) {
      event.preventDefault();
      //grab all form data  
      var formData = new FormData($('form.struttura')[0]);
      $.ajax({
        url: 'actions/strutture.php',
        type: 'POST',
        data: formData,
        async: false,
        cache: false,
        contentType: false,
        processData: false,
        success: function (returndata) {
         $("#contenitore").empty().load("form/strutture_confermare/strutture_confermare.php"); 
        }
      });
  });


});
</script>


<form class="struttura" action="actions/strutture.php">
  <fieldset class="form-group">
    <label for="struttura">Struttura</label>
    <input type="text" class="form-control" id="struttura" name="struttura" placeholder="struttura"  value="<?php echo utf8_encode($struttura);?>"> 
    <label for="citta">Citta</label>
    <input type="text" class="form-control" id="citta" name="citta" placeholder="citta"  value="<?php echo utf8_encode($citta);?>">
    <label for="indirizzo">Indirizzo</label>
    <input type="text" class="form-control" id="indirizzo" name="indirizzo" placeholder="indirizzo"  value="<?php echo utf8_encode($indirizzo);?>">
    <label for="cap">Cap</label>
    <input type="text" class="form-control" id="cap" name="cap" placeholder="cap"  value="<?php echo utf8_encode($cap);?>">
    <label for="pr">Prov</label>
    <input type="text" class="form-control" id="pr" name="pr" placeholder="pr"  value="<?php echo utf8_encode($pr);?>">
    <label for="email">Email</label>
    <input type="text" class="form-control" id="email" name="email" placeholder="email"  value="<?php echo utf8_encode($email);?>">
    <label for="referente">Referente</label>
    <input type="text" class="form-control" id="referente" name="referente" placeholder="referente"  value="<?php echo utf8_encode($referente);?>">
  
    <label for="telefono">Telefono</label>
    <input type="text" class="form-control" id="telefono" name="telefono" placeholder="telefono"  value="<?php echo utf8_encode($telefono);?>">
    <label for="note">Note</label>
    <textarea class="form-control" id="note" name="note" placeholder="note"><?php echo utf8_encode($note);?></textarea>
    <label for="stato">Stato
    <select id="stato" name="stato" class="form-control">
    <option value="Da contattare" <?php if($stato=="Da contattare") echo "selected";?>>Da contattare</option>
    <option value="Da richiamare" <?php if($stato=="Da richiamare") echo "selected";?>>Da richiamare</option>
    <option value="Contatto da sito" <?php if($stato=="Contatto da sito") echo "selected";?>>Contatto da sito</option>
    <option value="Non interessato" <?php if($stato=="Non interessato") echo "selected";?>>Non interessato</option>
    <option value="Inviare comunicazione" <?php if($stato=="Inviare comunicazione") echo "selected";?>>Inviare comunicazione</option>
    <option value="Convenzione chiusa" <?php if($stato=="Convenzione chiusa") echo "selected";?>>Convenzione chiusa</option>
    </select>
  </fieldset>

  
  
  
  <input type="hidden" name="action" id="action" value="inserisci">
  <input type="hidden" name="id_struttura" id="id_struttura" value="<?php echo $id_struttura;?>">
  <button type="submit" class="btn btn-primary"><i class="fa fa-check" aria-hidden="true"></i></button>
  <button class="btn btn-danger"><i class="fa fa-times" aria-hidden="true"></i></button>
</form>
</div>