<script>
$(document).ready(function(){
    $('.table-servizi').DataTable({
          "lengthMenu": [[50,100, -1], [50, 100, "Tutte"]],
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

    $('.table-servizi tbody').on('click', '.elimina-servizio', function () {
     
         $.post("actions/servizi.php",{id_servizio:$(this).attr('data-id'), action:"elimina"}, function(data){
             $(".contenitore_servizi").empty().load("form/strutture/servizi.php?id_struttura=<?php echo $_GET["id_struttura"];?>");
         });
    } );


    $('.table-servizi tbody').on('keyup', '.sconto', function () {
     
         $.post("actions/servizi.php",{id_servizio:$(this).attr('data-id'), sconto:$(this).val(), action:"sconto"}, function(data){
         });
    } );

    $('.table-servizi tbody').on('keyup', '.prezzo_listino', function () {
     
         $.post("actions/servizi.php",{id_servizio:$(this).attr('data-id'), prezzo_listino:$(this).val(), action:"prezzo_listino"}, function(data){
         });
    } );

    $('.table-servizi tbody').on('keyup', '.prezzo_scontato', function () {
     
         $.post("actions/servizi.php",{id_servizio:$(this).attr('data-id'), prezzo_scontato:$(this).val(), action:"prezzo_scontato"}, function(data){
           
         });
    } );

    $('.table-servizi tbody').on('keyup', '.circuito', function () {
     
         $.post("actions/servizi.php",{id_servizio:$(this).attr('data-id'), circuito:$(this).val(), action:"circuito"}, function(data){
           
         });
    } );

    $(".btn-nuovo-servizio").on("click", function(){
      $(".nuovo_servizio").load("form/strutture/nuovo_servizio.php?id_struttura=<?php echo $_GET["id_struttura"];?>");
    })
});




</script>

<table class="table table-striped table-bordered table-servizi">
    <thead>
        <tr>
            <th>Area</th>
            <th>Servizio</th>
            <th>Sconto %</th>
            <th>Prezzo Listino</th>
            <th>Prezzo Scontato</th>
            <th class="actions"></th>
            
        </tr>   
    </thead>
    <tbody>
    <?php include("../../includes/mysql.inc.php");
$sql="SELECT *, servizi_strutture_migliorsalute.circuito AS circuito FROM servizi_strutture_migliorsalute LEFT JOIN servizi_migliorsalute ON servizi_strutture_migliorsalute.id_servizio=servizi_migliorsalute.id_servizio LEFT JOIN aree_servizi ON aree_servizi.id_area = servizi_strutture_migliorsalute.id_area_servizio WHERE id_struttura='$_GET[id_struttura]' AND attivo ORDER BY id_area_servizio";
$res=mysql_query($sql);
while($rows=mysql_fetch_array($res, MYSQL_ASSOC)){?>
  <tr>
      <td><?php echo utf8_encode($rows["area"]);?></td>
      <td><?php echo utf8_encode($rows["servizio"]);?></td>
      <td><input type="text" data-id="<?php echo $rows["id_servizio_struttura"];?>" value="<?php echo utf8_encode($rows["sconto"]);?>" class="sconto" /></td>
      <td><input type="text" data-id="<?php echo $rows["id_servizio_struttura"];?>" value="<?php echo utf8_encode($rows["prezzo_listino"]);?>" class="prezzo_listino" /></td>
      <td><input type="text" data-id="<?php echo $rows["id_servizio_struttura"];?>" value="<?php echo utf8_encode($rows["prezzo_scontato"]);?>" class="prezzo_scontato" /></td>
      <td><button class="btn btn-danger elimina-servizio" data-id="<?php echo $rows["id_servizio_struttura"];?>"><i class="fa fa-times"></i></button></td>
  </tr>
<?php } ?>

    </tbody>    
</table>

<button class="btn btn-block btn-primary btn-nuovo-servizio"><i class="fa fa-plus-circle" aria-hidden="true"></i> Aggiungi nuovo servizio</button>

<div class="nuovo_servizio">
</div>


