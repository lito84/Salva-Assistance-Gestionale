<?php include("../../includes/auth.inc.php");?>
<?php include("../../includes/mysql.inc.php");?>
<script src="//cdn.datatables.net/plug-ins/1.10.12/sorting/date-eu.js"></script>
<script>
$(document).ready(function(){
  $(".loading").hide();
   $('#circuito_strutture').DataTable({
          "lengthMenu": [[25, 50, 100, -1], [25, 50, 100,"Tutte"]],
           "bSort": false,
          "language": 
          {
    "sEmptyTable":     "Nessun dato presente nella tabella",
    "sInfo":           "Vista da _START_ a _END_ di _TOTAL_ elementi",
    "sInfoEmpty":      "Vista da 0 a 0 di 0 elementi",
    "sInfoFiltered":   "(filtrati da _MAX_ elementi totali)",
    "sInfoPostFix":    "",
    "sInfoThousands":  ",",
    "sLengthMenu":     "Visualizza _MENU_ elementi",
    "sLoadingRecords": "Caricamento...",
    "sProcessing":     "Elaborazione...",
    "sSearch":         "Cerca:",
     "sPrint":         "Stampa",
    "sZeroRecords":    "La ricerca non ha portato alcun risultato.",
    "oPaginate": {
        "sFirst":      "Inizio",
        "sPrevious":   "Precedente",
        "sNext":       "Successivo",
        "sLast":       "Fine"
    },
    "oAria": {
        "sSortAscending":  ": attiva per ordinare la colonna in ordine crescente",
        "sSortDescending": ": attiva per ordinare la colonna in ordine decrescente"
    }
    }
  });


$('.table-circuito-struttura').on( 'draw.dt', function () {
  $(".circuito_struttura").on("change", function(){
    var struttura = 0
    if($(this).is(':checked')) struttura=1;
    $.post("actions/circuiti.php", {struttura:struttura, id_struttura:$(this).attr("data-id"), id_circuito:'<?php echo $_GET["id_circuito"];?>', action:"struttura_circuito"});
  });                 
});


$(".indietro").bind("click", function(){
  $("#contenitore").empty().load("form/circuiti/circuiti.php");
});

$(".circuito_struttura").on("change", function(){
  var struttura = 0
  if($(this).is(':checked')) struttura=1;
  $.post("actions/circuiti.php", {struttura:struttura, id_struttura:$(this).attr("data-id"), id_circuito:'<?php echo $_GET["id_circuito"];?>', action:"struttura_circuito"});
});


});
</script>
<?php 
$sql0="SELECT * FROM circuiti WHERE id_circuito='$_GET[id_circuito]'";
$res0=mysql_query($sql0);
$rows0=mysql_fetch_array($res0, MYSQL_ASSOC);
?>

<h2>Circuito <?php echo utf8_encode($rows0["circuito"]);?> - Dettaglio strutture</h2> 

<button class="btn btn-primary indietro"><i class="fa fa-undo" aria-hidden="true"></i> Indietro</button>
<table class="table table-striped table-bordered table-circuito-struttura" id="circuito_strutture">
<thead>
	<tr>
		    <th>ID</th>
        <th>Struttura</th>
        <th>Indirizzo</th>
        <th>Citt&agrave;</th>
        <th>Provincia</th>
        <th>&nbsp;</th>
	</tr>	
  </thead>
  <tbody>
  <?php $sql="SELECT IdAnagraficaStruttura, RagioneSocialeStruttura, IndirizzoOperativaStruttura, CittaOperativaStruttura, ProvinciaOperativaStruttura FROM anagraficastruttura WHERE attivo AND migliorsalute AND IdAnagraficaStruttura IN (SELECT id_struttura FROM circuiti_strutture WHERE id_circuito= '$_GET[id_circuito]') ORDER BY RagioneSocialeStruttura";
        
        $res=mysql_query($sql);
        while($rows=mysql_fetch_array($res, MYSQL_ASSOC)){
            $sql1="SELECT * FROM circuiti_strutture WHERE id_struttura = '$rows[IdAnagraficaStruttura]'";
            $res1=mysql_query($sql1);
            $struttura_circuito=0;
            if(mysql_num_rows($res1)!=0) $struttura_circuito =1; 
        ?>
        <tr class="master">
            <td><?php echo utf8_encode($rows["IdAnagraficaStruttura"]);?></td>
            <td><?php echo utf8_encode($rows["RagioneSocialeStruttura"]);?></td>
            <td><?php echo utf8_encode($rows["IndirizzoOperativaStruttura"]);?></td>
            <td><?php echo utf8_encode($rows["CittaOperativaStruttura"]);?></td>
            <td><?php echo utf8_encode($rows["ProvinciaOperativaStruttura"]);?></td>
            <td><input type="checkbox" class="circuito_struttura" value="1" <?php if($struttura_circuito==1) echo "checked";?> data-id='<?php echo $rows["IdAnagraficaStruttura"];?>'></td>
        </tr>
  <?php } ?>

  <?php $sql="SELECT IdAnagraficaStruttura, RagioneSocialeStruttura, IndirizzoOperativaStruttura, CittaOperativaStruttura, ProvinciaOperativaStruttura FROM anagraficastruttura WHERE attivo AND migliorsalute AND IdAnagraficaStruttura NOT IN (SELECT id_struttura FROM circuiti_strutture WHERE id_circuito= '$_GET[id_circuito]') ORDER BY RagioneSocialeStruttura ";
  $res=mysql_query($sql);
        while($rows=mysql_fetch_array($res, MYSQL_ASSOC)){
            $sql1="SELECT * FROM circuiti_strutture WHERE id_struttura = '$rows[IdAnagraficaStruttura]'";
            $res1=mysql_query($sql1);
            $struttura_circuito=0;
            if(mysql_num_rows($res1)!=0) $struttura_circuito =1; 
        ?>
        <tr>
            <td><?php echo utf8_encode($rows["IdAnagraficaStruttura"]);?></td>
            <td><?php echo utf8_encode($rows["RagioneSocialeStruttura"]);?></td>
            <td><?php echo utf8_encode($rows["IndirizzoOperativaStruttura"]);?></td>
            <td><?php echo utf8_encode($rows["CittaOperativaStruttura"]);?></td>
            <td><?php echo utf8_encode($rows["ProvinciaOperativaStruttura"]);?></td>
            <td><input type="checkbox" class="circuito_struttura" value="1" <?php if($struttura_circuito==1) echo "checked";?> data-id='<?php echo $rows["IdAnagraficaStruttura"];?>'></td>
        </tr>
  <?php } ?>
</tbody>	
</table>