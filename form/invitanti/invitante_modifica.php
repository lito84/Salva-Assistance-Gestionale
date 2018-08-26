<?php

include("../../includes/mysql.inc.php");
include("../../includes/parameters.php");
include("../../includes/functions.php");

$sql="SELECT * FROM invitanti WHERE id_cliente='$_GET[id_cliente]'";
$res=mysql_query($sql);
$rows=mysql_fetch_array($res, MYSQL_ASSOC);
$id_cliente=$rows["id_cliente"];
$cognome=$rows["cognome"];
$nome=$rows["nome"];
$sesso=$rows["sesso"];
$codicefiscale=$rows["codicefiscale"];
$data_nascita=$rows["data_nascita"];
$luogo_nascita=$rows["luogo_nascita"];
$stato_nascita=$rows["stato_nascita"];
$indirizzo=$rows["indirizzo"];
$citta=$rows["citta"];
$cap=$rows["cap"];
$telefono=$rows["telefono"];
$email=$rows["email"];


?>
<script>
$(document).ready(function(){
  $(".tabella_pratiche_container").load("form/invitanti/pratiche.php?id_cliente=<?php echo $id_cliente;?>");

  $('form.cliente').submit(function(e) {
      event.preventDefault();
      //grab all form data  
      var formData = new FormData($('form.cliente')[0]);
      $.ajax({
        url: 'actions/invitanti.php',
        type: 'POST',
        data: formData,
        async: false,
        cache: false,
        contentType: false,
        processData: false,
        success: function (returndata) {
         $("#contenitore").empty().load("form/invitanti/invitanti.php"); 
        }
      });
  });


});
</script>

<ul class="nav nav-tabs">
  <li class="active"><a href="#1" data-toggle="tab">Dati Anagrafici</a></li>
  <li><a href="#2" data-toggle="tab">Cronologia Acquisti</a></li>
</ul>


<div class="tab-content ">
    

  <div class="tab-pane active" id="1">

    <form class="cliente" action="actions/invitanti.php">
      <fieldset class="form-group">
        <label for="cognome">Cognome</label>
        <input type="text" class="form-control" id="cognome" name="cognome" placeholder="cognome"  value="<?php echo utf8_encode($cognome);?>"> 
        
        <label for="nome">Nome</label>
        <input type="text" class="form-control" id="nome" name="nome" placeholder="nome"  value="<?php echo utf8_encode($nome);?>"> 
        
        <label for="sesso">Sesso</label>
        <input type="text" class="form-control" id="sesso" name="sesso" placeholder="sesso"  value="<?php echo utf8_encode($sesso);?>"> 
        
        <label for="codicefiscale">Codice Fiscale</label>
        <input type="text" class="form-control" id="codicefiscale" name="codicefiscale" placeholder="codicefiscale"  value="<?php echo utf8_encode($codicefiscale);?>"> 
        
        <label for="data_nascita">Data Nascita</label>
        <input type="text" class="form-control" id="data_nascita" name="data_nascita" placeholder="data_nascita"  value="<?php echo convertiDataIT_US($data_nascita);?>"> 
        
        <label for="luogo_nascita">Luogo Nascita</label>

        <select class="form-control" id="luogo_nascita" name="luogo_nascita">
        <?php $sql1="SELECT * FROM comuni_2017 ORDER BY comune";
              $res1=mysql_query($sql1);
              while($rows1=mysql_fetch_array($res1, MYSQL_ASSOC)){?>
                <option value="<?php echo $rows1["cod_catastale"];?>" <?php if($rows1["cod_catastale"]==$luogo_nascita) echo "selected";?>><?php echo utf8_encode($rows1["comune"]);?></option>
        <?php } ?>
        </select>
        
        <label for="stato_nascita">Stato Nascita</label>
        <input type="text" class="form-control" id="stato_nascita" name="stato_nascita" placeholder="stato_nascita"  value="<?php echo utf8_encode($stato_nascita);?>"> 

        <label for="indirizzo">Indirizzo</label>
        <input type="text" class="form-control" id="indirizzo" name="indirizzo" placeholder="indirizzo"  value="<?php echo utf8_encode($indirizzo);?>"> 
        
         <label for="citta">Citt&agrave;</label>
        <select  class="form-control" id="citta" name="citta">
        <?php $sql1="SELECT * FROM comuni_2017 ORDER BY comune";
              $res1=mysql_query($sql1);
              while($rows1=mysql_fetch_array($res1, MYSQL_ASSOC)){?>
                <option value="<?php echo $rows1["cod_catastale"];?>" <?php if($rows1["cod_catastale"]==$citta) echo "selected";?>><?php echo utf8_encode($rows1["comune"]);?></option>
        <?php } ?>
        </select>
        <label for="cap">CAP</label>
        <input type="text" class="form-control" id="cap" name="cap" placeholder="cap"  value="<?php echo utf8_encode($cap);?>">
        <label for="email">Email</label>
        <input type="text" class="form-control" id="email" name="email" placeholder="email"  value="<?php echo utf8_encode($email);?>">
        <label for="telefono">Telefono</label>
        <input type="text" class="form-control" id="telefono" name="telefono" placeholder="telefono"  value="<?php echo utf8_encode($telefono);?>">
        
      </fieldset>

      
      
      
      <input type="hidden" name="action" id="action" value="modifica">
      <input type="hidden" name="id_cliente" id="id_cliente" value="<?php echo $id_cliente;?>">
      <button type="submit" class="btn btn-primary"><i class="fa fa-check" aria-hidden="true"></i></button>
      <button class="btn btn-danger"><i class="fa fa-times" aria-hidden="true"></i></button>
    </form>
  </div>

  <div class="tab-pane" id="2">
      <h3>Cronologia Acquisti</h3>
      <div class="tabella_pratiche_container"></div>
  </div>

</div>
