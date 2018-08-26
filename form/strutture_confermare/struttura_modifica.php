<?php include("../../includes/mysql.inc.php");
$sql="SELECT * FROM anagrafica_salute_semplice WHERE id_struttura='$_GET[id_struttura]'";
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
$provenienza=$rows["provenienza"];
$segnalatore=$rows["segnalatore"];
$email_segnalatore=$rows["email_segnalatore"];
$note=$rows["note"];
$tariffario=$rows["tariffario"];
$strutture_aggiuntive=$rows["strutture_aggiuntive"];

?>
<script>PDFObject.embed("<?php echo $p_sito;?>uploads/tariffari/files/<?php echo $tariffario;?>", "#pdf_container",{height:"500px"});</script>


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

      var email="mailto:"+$("#email").val();
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

    <label for="segnalatore">Segnalata da</label>
    <input type="text" class="form-control" id="segnalatore" name="segnalatore" placeholder="segnalatore"  value="<?php echo utf8_encode($segnalatore);?>">

    <label for="email_segnalatore">Segnalata da - email</label>
    <input type="text" class="form-control" id="email_segnalatore" name="email_segnalatore" placeholder="email_segnalatore"  value="<?php echo utf8_encode($email_segnalatore);?>">
    <label for="provenienza">Segnalata da - provenienza</label>
    <input type="text" class="form-control" id="provenienza" name="provenienza" placeholder="provenienza"  value="<?php echo utf8_encode($provenienza);?>">


    <label for="strutture_aggiuntive">Strutture aggiuntive</label>
    <input type="text" class="form-control" id="strutture_aggiuntive" name="strutture_aggiuntive" placeholder="strutture_aggiuntive"  value="<?php echo utf8_encode($strutture_aggiuntive);?>">



      <?php if($tariffario!=""){?>
        <div class="row">
        <div class="col-xs-12">
        <label>Tariffario</label>

        <div id="pdf_container"></div>

       <i class="fa fa-file-pdf-o" data-link="<?php echo $p_sito;?>uploads/tariffari/files/<?php echo $tariffario;?>"></i> <?php echo utf8_encode($rows["tariffario"]);?>
     </div>
   </div>
      <?php } ?>

    <label for="note">Note</label>
    <textarea class="form-control" id="note" name="note" placeholder="note"><?php echo utf8_encode($note);?></textarea>
    
  </fieldset>

  
  
  
  <input type="hidden" name="action" id="action" value="modifica">
  <input type="hidden" name="id_struttura" id="id_struttura" value="<?php echo $id_struttura;?>">
  <button type="submit" class="btn btn-primary btn-lg"><i class="fa fa-check" aria-hidden="true"></i></button>
</form>
</div>