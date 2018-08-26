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
$referente=$rows["referente"];
$telefono=$rows["telefono"];
$telefono1=$rows["telefono1"];
$note=$rows["note"];
$stato=$rows["stato"];
?>
<script>
$(document).ready(function(){

  $("#telefono").bind("keyup", function(){
    $.post("actions/strutture.php",{telefono:$(this).val(), id_struttura:'<?php echo $id_struttura;?>', action:"telefono"}, function(){

      var tel="tel:"+$("#telefono").val();
      $("#call").attr('href',tel);
    })
  });

  $("#telefono1").bind("keyup", function(){
    $.post("actions/strutture.php",{telefono:$(this).val(), id_struttura:'<?php echo $id_struttura;?>', action:"telefono1"}, function(){

      var tel="tel:"+$("#telefono1").val();
      $("#call1").attr('href',tel);
    })
  });

  $("#email").bind("keyup", function(){
    $.post("actions/strutture.php",{email:$(this).val(), id_struttura:'<?php echo $id_struttura;?>', action:"email"}, function(){

      var email="mailto:"+$("#email").val()+"?subject='Nuova convenzione Migliorsalute'";
      $("#send").attr('href',email);
    })
  });


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
          alert(returndata);
         $("#contenitore").empty().load("form/strutture_confermare/struttura_modifica.php?id_struttura=<?php echo $id_struttura;?>"); 
        }
      });
  });

});
</script>


<form class="struttura">
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
    <label for="referente">Referente</label>
    <input type="text" class="form-control" id="referente" name="referente" placeholder="referente"  value="<?php echo utf8_encode($referente);?>">
    
    <div class="row">
    
    <div class="col-xs-11">
    <label for="email">Email</label>
    <input type="text" class="form-control" id="email" name="email" placeholder="email"  value="<?php echo utf8_encode($email);?>">
     </div>
    <div class="col-xs-1">
    <label>&nbsp;</label>
    <a class="btn btn-warning form-control" id="send" href="<?php echo 'mailto:'.$email;?>?subject=Nuova convenzione Migliorsalute"><i class="fa fa-envelope"></i></a>
    </div>
    </div>
   <div class="row">
    
    <div class="col-xs-11">
    <label for="telefono">Telefono</label>
    <input type="text" class="form-control" id="telefono" name="telefono" placeholder="telefono"  value="<?php echo utf8_encode($telefono);?>">
    </div>
    <div class="col-xs-1">
    <label>&nbsp;</label>
    <a class="btn btn-warning form-control" id="call" href="<?php echo 'tel:'.$telefono;?>"><i class="fa fa-phone"></i></a>
    </div>
    </div>

    <div class="row">
    
    <div class="col-xs-11">
    <label for="telefono1">Telefono 1</label>
    <input type="text" class="form-control" id="telefono1" name="telefono1" placeholder="telefono1"  value="<?php echo utf8_encode($telefono1);?>">
    </div>
    <div class="col-xs-1">
    <label>&nbsp;</label>
    <a class="btn btn-warning form-control" id="call1" href="<?php echo 'tel:'.$telefono1;?>"><i class="fa fa-phone"></i></a>
    </div>
    </div>
    <label for="note">Note</label>
    <textarea class="form-control" id="note" name="note" placeholder="note"><?php echo utf8_encode($note);?></textarea>
    <label for="stato">Stato
    <select id="stato" name="stato" class="form-control">
    <option value="Da contattare" <?php if($stato=="Da contattare") echo "selected";?>>Da contattare</option>
    <option value="Da richiamare" <?php if($stato=="Da richiamare") echo "selected";?>>Da richiamare</option>
    <option value="Contatto da sito" <?php if($stato=="Contatto da sito") echo "selected";?>>Contatto da sito</option>
    <option value="Non interessato" <?php if($stato=="Non interessato") echo "selected";?>>Non interessato</option>
    <option value="Inviare comunicazione" <?php if($stato=="Inviata comunicazione") echo "selected";?>>Inviata comunicazione</option>
    <option value="Convenzione chiusa" <?php if($stato=="Convenzione chiusa") echo "selected";?>>Convenzione chiusa</option>
    </select>
  </fieldset>

  
  
  
  <input type="hidden" name="action" id="action" value="modifica">
  <input type="hidden" name="id_struttura" id="id_struttura" value="<?php echo $id_struttura;?>">
  <button type="submit" class="btn btn-primary"><i class="fa fa-check" aria-hidden="true"></i></button>
  <button class="btn btn-danger"><i class="fa fa-times" aria-hidden="true"></i></button>
</form>
</div>